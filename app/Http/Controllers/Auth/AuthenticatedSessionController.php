<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();
        $request->user()->update([
            'last_login' => Carbon::now()
        ]);
        $request->session()->regenerate();
        if ($request->user()->hasRole('admin')) {
            return redirect()->route('nova.pages.home');
        }

        return redirect()->route('all.content');

        // return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('all.content');
    }
    public function apiLogin(LoginRequest $request)
    {
        // Attempt to authenticate the user
        $request->authenticate();

        // Check if login was successful
        $user = Auth::user();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials.'],
            ]);
        }

        // Update user's last login time
        $user->update(['last_login' => now()]);

        // Generate a Sanctum token for the user
        $token = $user->createToken('authToken')->plainTextToken;

        // Return the token and user data as JSON
        return response()->json([
            'status' => 'success',
            'message' => 'User logged in successfully',
            'user' => $user,
            'token' => $token,
        ], 200);
    }

    /**
     * API Logout method.
     */
    public function apiLogout(Request $request)
    {
        // Revoke the token that was used to authenticate the current request
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
