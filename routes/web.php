<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\MailController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', [App\Http\Controllers\RunJobController::class, 'dashboard'])->name('dashboard');

Route::post('/startJob', [App\Http\Controllers\BotController::class, 'startJob'])->name('startJob');    


require __DIR__.'/auth.php';
