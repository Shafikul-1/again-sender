<?php

use App\Http\Controllers\mail\MailDeliveryDetailsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\mail\MailSetupController;
use App\Http\Controllers\mail\SendingEmailController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('admin', function (){
    return view("dashboard.admin");
})->middleware(['auth', 'verified', 'role:admin'])->name('admin');

Route::get('editor', function (){
    return view("dashboard.editor");
})->middleware(['auth', 'verified', 'role:editor'])->name('editor');

Route::get('user', function (){
    return view("dashboard.user");
})->middleware(['auth', 'verified', 'role:user'])->name('user');

Route::get('check', function (){
    return view("dashboard.check");
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::resource('mailsetup', MailSetupController::class)->middleware('auth');
Route::resource('sendingemails', SendingEmailController::class)->middleware('auth');


Route::get('check', function (){
    return view('mail.template');
});


require __DIR__.'/auth.php';
