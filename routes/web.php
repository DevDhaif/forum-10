<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\ThreadController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Route::get('/threads', [ThreadController::class, 'index'])->name('threads');
// Route::get('/threads/create', [ThreadController::class, 'create'])
//     ->name('threads.create');
// Route::post("/threads/", [ThreadController::class, 'store'])->name('threads.store');
// Route::get('/threads/{thread}', [ThreadController::class, 'show'])
//     ->name('threads.show');

Route::resource('/threads' , ThreadController::class);


Route::post('/threads/{thread}/replies', [ReplyController::class, 'store'])->name('replies.store');


require __DIR__.'/auth.php';
