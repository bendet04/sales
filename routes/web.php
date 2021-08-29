<?php

use Illuminate\Support\Facades\Route;


Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('role:sales')->get('/add-order',\App\Http\Livewire\AddOrder::class)->name('add-order');

Route::middleware('auth')->group(function (){
    Route::get('/order',\App\Http\Livewire\Order::class)->name('order');
    Route::get('/order-detail/{order_id}',\App\Http\Livewire\OrderDetail::class)->name('order-detail');
});