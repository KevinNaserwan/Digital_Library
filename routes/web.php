<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DigitalLabController;
use App\Http\Controllers\Route_Controller;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [Route_Controller::class, 'dashboard'])->name('dashboard')->middleware('auth');
Route::get('/login', [Route_Controller::class, 'login'])->name('login');
Route::get('/register', [Route_Controller::class, 'register']);
Route::get('//tambah-data-buku', [Route_Controller::class, 'tambahbuku'])->middleware('auth');
Route::get('/datakategori', [Route_Controller::class, 'datakategori'])->middleware('auth');
Route::get('/editbuku/{judul_buku}', [Route_Controller::class, 'editbuku'])->middleware('auth');
Route::get('/export-to-pdf', [DigitalLabController::class, 'exportToPdf'])->name('export.pdf')->middleware('auth');

Route::post('registerprocess', [AuthController::class, 'registerprocess']);
Route::post('loginprocess', [AuthController::class, 'login']);
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth');

/* Route CRUD */
Route::post('/postkategori', [DigitalLabController::class, 'storekategori'])->middleware('auth');
Route::post('/postbuku', [DigitalLabController::class, 'storebuku'])->middleware('auth');
Route::get('/delete/{judul_buku}', [DigitalLabController::class, 'delete'])->middleware('auth');
Route::get('/deletekategori/{kategori_buku}', [DigitalLabController::class, 'deletekategori'])->middleware('auth');
Route::post('/updatekategori/{id}', [DigitalLabController::class, 'updatekategori'])->middleware('auth');
Route::post('/updatebuku/{id}', [DigitalLabController::class, 'updatebuku'])->middleware('auth');
