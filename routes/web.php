<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RelController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
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
Route::get('/teste', function(){
    return view('relatorio.teste');
});
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::get('/logout', [LoginController::class, 'logout']);

Route::get('/register', [RegisterController::class, 'index']);
Route::post('/register', [RegisterController::class, 'register']);

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
    Route::post('/justify2', [RelController::class, 'justify2']);
    Route::get('/fin/{id}', [RelController::class, 'fin']);
    Route::get('/print/{id}', [RelController::class, 'print']);
    Route::get('/jrelatorio', [RelController::class, 'jrelatorio']);
    Route::get('/jid/{id}', [RelController::class, 'jid']);
    Route::get('/usuarios', [RelController::class, 'usuarios']);
    Route::get('/usuario/editar/{id}', [RelController::class, 'usuarioEditar']);
    Route::post('/usuario/editar/{id}', [RelController::class, 'usuarioEditarAction']);
    Route::get('/usuario/del/{id}', [RelController::class, 'usuarioDel']);
});