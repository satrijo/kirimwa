<?php

use Illuminate\Support\Facades\Auth;
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
Route::get('/wa', [App\Http\Controllers\KirimWAController::class, 'index'])->name('index');
Route::prefix('wa')->group(function () {
    Route::get('/add-device/{nama}', [App\Http\Controllers\KirimWAController::class, 'addDevice'])->name('addDevice');
    Route::get('/get-devices', [App\Http\Controllers\KirimWAController::class, 'getDevices'])->name('getDevices');
    Route::get('/qr-code/{id}', [App\Http\Controllers\KirimWAController::class, 'qrCode'])->name('qrCode');
    Route::post('/send-message', [App\Http\Controllers\KirimWAController::class, 'sendMessage'])->name('sendMessage');
    Route::get('/get-groups', [App\Http\Controllers\KirimWAController::class, 'getGroups'])->name('getGroups');
    Route::get('/get-group-detail/{id}', [App\Http\Controllers\KirimWAController::class, 'getGroupDetail'])->name('getGroupDetail');
    Route::post('/add-data' , [App\Http\Controllers\KirimWAController::class, 'addData'])->name('addData');
    Route::get('/delete-data/{id}' , [App\Http\Controllers\KirimWAController::class, 'deleteData'])->name('deleteData');
    Route::get('/edit-data/{id}' , [App\Http\Controllers\KirimWAController::class, 'editData'])->name('editData');
    Route::post('/update-data' , [App\Http\Controllers\KirimWAController::class, 'updateData'])->name('updateData');
    Route::post('/import-data' , [App\Http\Controllers\KirimWAController::class, 'importData'])->name('importData');
});
