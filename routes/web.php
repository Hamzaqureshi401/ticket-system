<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\StaffController;

Route::get('/', function () {
   return redirect()->route('login');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::resource('tickets', TicketController::class);
    
    Route::prefix('staff')->group(function () {
        Route::get('/', [StaffController::class, 'index'])->name('staff.index');
    });
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
