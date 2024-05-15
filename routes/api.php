<?php

use App\Http\Controllers\EventController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/calender/getEvents', [EventController::class, 'index']);
Route::post('/calender/addEvent', [EventController::class, 'store']);
Route::post('/calender/deleteEvent/{id}', [EventController::class, 'destroy']);
Route::post('/calender/EditEvent/{id}', [EventController::class, 'update']);
