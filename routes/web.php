<?php

use App\Http\Controllers\Admin\ParticipantController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;

Route::get('/', [FrontController::class, 'index'])->name('index');
Route::get('event/{id}', [FrontController::class, 'event'])->name('event.detail');
Route::get('event/{slug}/register', [FrontController::class, 'create'])->name('event.create');
Route::post('register-event', [FrontController::class, 'store'])->name('event.store');

Auth::routes();

Route::group([
    'middleware' => 'auth'
], function () {
    Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('participant', [ParticipantController::class, 'index'])->name('participant.index');
    Route::post('participant', [ParticipantController::class, 'store'])->name('participant.store');
    Route::post('participant/edit', [ParticipantController::class, 'edit'])->name('participant.edit');
    Route::delete('participant/{id}', [ParticipantController::class, 'delete'])->name('participant.delete');
    Route::get('checkin', [ParticipantController::class, 'checkin'])->name('participant.checkin');
    Route::post('checkin', [ParticipantController::class, 'checkinStatus'])->name('participant.checkin.status');
});
