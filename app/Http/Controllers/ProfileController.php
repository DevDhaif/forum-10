<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Activity;
use App\Models\Thread;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Inertia\Inertia;

class ProfileController extends Controller
{
    public function show(Request $request, User $user)
    {
        $user->load([
            'university' => function ($query) {
                $query->select('name', 'id');
            },
            'field' => function ($query) {
                $query->select('name', 'id');
            },
            'roles',
            'threads.creator'
        ]);

        return Inertia::render('Profile/Index', [
            'profileUser' => $user,
            'threads' => $user->threads,
            'activities' => Activity::feed($user, 50),
        ]);
    }
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request, User $user)
    {
        if (!$request->user()->hasRole('admin') && $request->user()->id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();
        $user->load('university', 'field', 'roles');

        return response()->json($user, 200);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(User $user, Request $request)
    {
        if ($user->id !== $request->user()->id && !$request->user()->hasRole('admin')) {
            return response()->json(['error' => 'Unauthorized User'], 403);
        }
        if (!$request->user()->hasRole('admin')) {
            $request->validateWithBag('userDeletion', [
                'password' => ['required', 'current-password'],
            ]);
        }
        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'User deleted'], 200);
    }
}
