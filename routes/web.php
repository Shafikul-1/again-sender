<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CollectDataController;
use App\Http\Controllers\mail\MailSetupController;
use App\Http\Controllers\mail\SendingEmailController;
use App\Http\Controllers\mail\MailDeliveryDetailsController;

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
Route::post('multiwork', [SendingEmailController::class, 'multiwork'])->name('sendingemails.multiwork')->middleware('auth');
Route::get('uploadFileDelete/{url}', [SendingEmailController::class, 'uploadFileDelete'])->name('sendingemails.uploadFileDelete')->middleware('auth');

Route::middleware('auth')->group(function (){
    Route::get('index', [CollectDataController::class, 'index'])->name('collectData.index');
    Route::get('all-link', [LinkController::class, 'index'])->name('allLink.index');
    Route::post('all-link/store', [LinkController::class, 'store'])->name('allLink.store');
    Route::delete('all-link/destroy/{id}', [LinkController::class, 'destroy'])->name('allLink.destroy');
});


Route::get('check', function (){
    return view('mail.template');
});


require __DIR__.'/auth.php';
