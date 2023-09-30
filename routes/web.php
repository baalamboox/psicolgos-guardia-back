<?php

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

Route::get('/', function () {
    return view('home');
});

Route::get('/iniciar-sesion', function () {
    return view('auth.signin');
});

Route::get('/recuperar-clave', function () {
    return view('auth.forgot-password');
});

Route::get('/nuevo-administrador', function () {
    return view('admin.new-admin');
});

Route::get('/perfil', function () {
    return view('admin.profile');
});

Route::get('/configuraciones', function () {
    return view('admin.config');
});

Route::get('/metricas', function () {
    return view('admin.metrics');
});

Route::get('/perfil/actividad', function () {
    return view('admin.logs');
});

Route::get('/pacientes', function () {
    return view('admin.patients');
});

Route::get('/psicologos', function () {
    return view('admin.psychologists');
});
