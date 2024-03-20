<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DutyController;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
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

Route::post('/login', [AuthController::class, 'auth'])->name('login');
Route::post('/register', [AuthController::class, 'store'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');

Route::prefix('api')->group(function () {
    //User routes
    Route::get('/user', [UserController::class, 'check'])->name('users.check');
    Route::get('/dashboard', [DashboardController::class, 'dashboardData'])->name('dashboard.data');

    //House routes
    Route::get('/houses', [HouseController::class, 'index'])->name('houses.index');
    Route::post('/houses', [HouseController::class, 'store'])->name('houses.store');
    Route::get('/houses/{house}', [HouseController::class, 'show'])->name('houses.show');
    Route::put('/houses/{house}/set', [HouseController::class, 'set'])->name('houses.set');
    Route::put('/houses/{house}', [HouseController::class, 'update'])->name('houses.update');
    Route::delete('/houses/{house}', [HouseController::class, 'destroy'])->name('houses.destroy');

    //Room routes
    Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
    Route::post('/rooms', [RoomController::class, 'store'])->name('rooms.store');
    Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');
    Route::put('/rooms/{room}', [RoomController::class, 'update'])->name('rooms.update');
    Route::delete('/rooms/{room}', [RoomController::class, 'destroy'])->name('rooms.destroy');

    //Duty routes
    Route::get('/duties', [DutyController::class, 'index'])->name('duties.index');
    Route::post('/duties', [DutyController::class, 'store'])->name('duties.store');
    Route::get('/duties/{duty}', [DutyController::class, 'show'])->name('duties.show');
    Route::put('/duties/{duty}', [DutyController::class, 'update'])->name('duties.update');
    Route::delete('/duties/{duty}', [DutyController::class, 'destroy'])->name('duties.destroy');

    //Entry routes
    Route::get('/entries', [EntryController::class, 'index'])->name('entries.index');
    Route::post('/entries', [EntryController::class, 'store'])->name('entries.store');
    Route::get('/entries/{entry}', [EntryController::class, 'show'])->name('entries.show');
    Route::put('/entries/{entry}', [EntryController::class, 'update'])->name('entries.update');
    Route::delete('/entries/{entry}', [EntryController::class, 'destroy'])->name('entries.destroy');
});

//To prevent duplicating blank routes for vue.js, we can use this wildcard route
Route::get('/{any?}', function () {
    return view('layouts.main');
});
