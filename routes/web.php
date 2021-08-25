<?php

use Illuminate\Support\Facades\Route;


Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('role:sales-user')->get('/sales-user',function(){
    return 'hompage sales user';
})->name('sales-user');

Route::middleware('role:sales-admin-1')->get('/sales-admin-1',function(){
    return 'hompage sales admin 1';
})->name('sales-admin-1');