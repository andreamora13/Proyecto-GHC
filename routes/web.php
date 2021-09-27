<?php

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

Route::get('/progress', function () {
    return view('welcome2');
});
Route::get('/timer', function () {
    return view('home1');
});
Route::get('/tim', function () {
    return view('prueba');
});


/*Route::post('form', 'ProController@store');*/

Auth::routes();
Route::resource('/proyecto', 'ProyectoController');

Route::get('/home', 'HomeController@index')->name('home');



Route::get('/inicio', 'ProController@inicio');
Route::post('/cultivo', 'ProController@CrearCultivo');
Route::get('/ra', 'ProController@Riego');
Route::get('/abono', 'ProController@Abono');
Route::get('/crecimiento', 'ProController@Crecimiento');
Route::get('/inv', 'ProController@Inventario');

Route::post('/mercado', 'ProController@Mercado');


Route::post('/seleccion', 'ProController@Seleccion');

Route::get('/evento', 'ProController@evento');
Route::get('/principal', 'ProController@principal');
Route::get('/partida', 'ProController@Partida');
Route::get('/informe', 'ProController@info');
Route::get('/espera', 'ProController@espera');
Route::get('/terminar', 'ProController@terminar');


Route::get('/merca', 'ProController@merca');
Route::get('/Admin', 'AdmiController@Admin');
Route::post('/AdminDatos', 'AdmiController@Datos');


Route::get('/Admi', 'AdmiController@defecto');
Route::get('/AdmiHome', 'AdmiController@home');
Route::post('/Asigna', 'AdmiController@Asignacion');



Route::get('/semana', 'ProController@semana');


Route::post('/dosd', 'AdmiController@pruebacheck');
Route::get('/time', 'AdmiController@Time');



Route::post('/all', 'ProyectoController@all');
Route::get('/sera', 'ProyectoController@destroy');
Route::post('/vista', 'ProyectoController@vista');

Route::get('/json', 'ProyectoController@json');
Route::get('/info', 'ProyectoController@Info');


Route::post('/InformePartida', 'ProyectoController@InformeGlo');
Route::post('/datosgra', 'ProyectoController@datos');



Route::post('/InformeUsuario', 'ProyectoController@InformeInd');
Route::post('/datosind', 'ProyectoController@datosInd');

Route::get('/perdida', 'ProController@perdida');

Route::get('/prod', 'ProController@produccion');

Route::get('/parti', 'ProController@partidaDet');



Route::get('/proyect', 'GraController@principal');
Route::post('/crea', 'GraController@CrearCultivo');
Route::post('/sele', 'GraController@Seleccion');
Route::post('/mer', 'GraController@Mercado');
Route::get('/dat', 'ProyectoController@datd');
