<?php


use App\Http\Controllers\ChannelController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\ThreadController;
use App\Models\Reply;
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

Route::get("/threads/{channel}/{thread}/replies", [ThreadController::class, 'getReplies'])->name('getReplies');
Route::post('/threads/{channel}/{thread}/replies', [ReplyController::class, 'store'])->name('replies.store');
Route::get("/threads/{channel}/{thread}", [ThreadController::class,'show'])->name('threads.show');
Route::delete("/threads/{channel}/{thread}", [ThreadController::class,'destroy']);


Route::post('{type}/{id}/favorites', [FavoriteController::class, 'store'])->name('replies.favorite');
Route::delete('{type}/{id}/favorites', [FavoriteController::class, 'destroy'])->name('replies.unfavorite');
Route::get('/replies/{reply}/isFavorited', [ReplyController::class, 'isFavorited'])->name('replies.isFavorited');
Route::patch("/replies/{reply}" , [ReplyController::class , 'update'])->name('replies.update');
Route::delete("/replies/{reply}" , [ReplyController::class , 'destroy'])->name('replies.destroy');


// http://forum-10.test/threads/minus/39/replies?page=2

Route::get('/profiles/{user:name}', [ProfileController::class, 'show'])->name('profile.show');



require __DIR__.'/auth.php';
