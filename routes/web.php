<?php

use App\Http\Controllers\DataController;
use App\Http\Controllers\YajraController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('data.index', [DataController::class, 'index'])->name('data');

Route::post('data.store', [DataController::class, 'store'])->name('data.store');
Route::post('data.edits', [DataController::class, 'edits'])->name('edits');
Route::post('data.updates', [DataController::class, 'updates'])->name('updates');
Route::post('data.hapus', [DataController::class, 'hapus'])->name('hapus');
