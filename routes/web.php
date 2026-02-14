
<?php
// API per moviments AJAX
Route::patch('/api/games/{game}', [App\Http\Controllers\GameController::class, 'apiUpdate'])->name('games.api.update');

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\GameController;

Route::get('/', [GameController::class, 'index'])->name('games.index');
Route::get('/games/create', [GameController::class, 'create'])->name('games.create');
Route::post('/games', [GameController::class, 'store'])->name('games.store');
Route::get('/games/{game}', [GameController::class, 'show'])->name('games.show');
Route::patch('/games/{game}', [GameController::class, 'update'])->name('games.update');
