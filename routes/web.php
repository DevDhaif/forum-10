<?php


use App\Http\Controllers\ChannelController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\ThreadController;

use App\Models\Thread;

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

Route::get('/threads', [ThreadController::class, 'index'])->name('threads');


Route::get("/threads/create", [ThreadController::class, 'create'])->middleware('auth')->name('threads.create');

Route::get("/threads/{channel}", [ThreadController::class, 'index'])->name('threads.channel');
Route::post("/threads/", [ThreadController::class, 'store'])->name('threads.store');
// Route::get('/threads/{thread}', [ThreadController::class, 'show'])
//     ->name('threads.show');
Route::get("/threads/{channel}/{thread}", [ThreadController::class,'show']);
Route::post('replies/{reply}/favorites', [FavoriteController::class, 'store'])->name('replies.favorite');
Route::post('/threads/{channel}/{thread}/replies', [ReplyController::class, 'store'])->name('replies.store');

require __DIR__.'/auth.php';
