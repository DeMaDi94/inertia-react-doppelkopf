<?php

use App\Http\Components\Game\GameController;
use App\Http\Components\Round\RoundController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('login');
});

Route::resource('games', GameController::class)
    ->only(['index', 'store'])
    ->middleware(['auth', 'verified']);

Route::get('/dashboard', [GameController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/games/{gameId}', [GameController::class, 'show'])->middleware(['auth', 'verified'])->name('game');
Route::post('/games/{gameId}/rounds', [RoundController::class, 'store'])->middleware(['auth', 'verified']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
