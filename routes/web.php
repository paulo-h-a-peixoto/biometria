<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RelController;
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

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('/relatorio')->group(function(){
    Route::get('/', [RelController::class, 'index']);
    Route::get('/home', [RelController::class, 'home']);
    Route::get('/gerar', [RelController::class, 'gerar']);
    Route::post('/gerar', [RelController::class, 'gerarAction']);
    Route::get('/update', [RelController::class, 'update']);
    Route::post('/update', [RelController::class, 'updateAction']);
    Route::get('/id/{id}', [RelController::class, 'id']);
    Route::post('/id/{id}', [RelController::class, 'idAction']);
    Route::post('/justify', [RelController::class, 'justify']);
    Route::get('/fin/{id}', [RelController::class, 'fin']);
    Route::get('/print/{id}', [RelController::class, 'print']);
});