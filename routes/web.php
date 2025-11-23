<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ReportController;

Route::get('/', function(){ return redirect()->route('orders.index'); });

Route::resource('services', ServiceController::class)->except(['show','edit','create']);
Route::post('services/{service}', [ServiceController::class,'update'])->name('services.update'); // form post update

Route::get('orders', [OrderController::class,'index'])->name('orders.index');
Route::get('orders/create', [OrderController::class,'create'])->name('orders.create');
Route::post('orders', [OrderController::class,'store'])->name('orders.store');
Route::post('orders/{order}/update-status', [OrderController::class,'updateStatus'])->name('orders.updateStatus');
Route::delete('orders/{order}', [OrderController::class,'destroy'])->name('orders.destroy');

Route::get('reports', [ReportController::class,'index'])->name('reports.index');
