<?php

use App\Http\Controllers\PrintController;
use App\Livewire\Cart\Payment;
use App\Models\Order;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

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

Route::middleware('guest')->group(function () {
    Volt::route('/', 'pages.auth.login')
        ->name('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/order', App\Livewire\Cart\Order::class)->name('order');
    Route::get('/payment', App\Livewire\Cart\Payment::class)->name('payment');


   Route::get('/receipt-pdf', [App\Http\Controllers\ReceiptPrint::class, 'index'])->name('receipt');

});

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');



require __DIR__.'/auth.php';
