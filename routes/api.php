<?php

use App\Http\Controllers\campaniasController;
use App\Http\Controllers\clientesController;
use App\Http\Controllers\localidadesController;
use App\Http\Controllers\numerosController;
use App\Models\clienteModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;







Route::get('/clientes', [clientesController::class,'index']); // muestre todos

Route::get ('/clientes/{id}', [clientesController::class,'show']); // muestre uno con sus respectivas localidades relacionadas

Route::post ('/clientes', [clientesController::class,'store']); // para crear

Route::put ('/clientes/{id}', [clientesController::class,'update']); // para editar

Route::delete ('/clientes/{id}', [clientesController::class,'destroy']); // para borrar


Route::get('/localidades', [localidadesController::class,'index']); // muestre todas

Route::get ('/localidades/{id}', [localidadesController::class,'show']); // muestre una en particular

Route::post ('/localidades', [localidadesController::class,'store']); // para crear

Route::put ('/localidades/{id}', [localidadesController::class,'update']); // para editar

Route::delete ('/localidades/{id}', [localidadesController::class,'destroy']); // para borrar


Route::get('/campanias', [campaniasController::class,'index']); // muestre todos
Route::get ('/campanias/{id}', [campaniasController::class,'show']); // muestre uno con y sus respectivas localidades relacionadas
Route::post ('/campanias', [campaniasController::class,'store']); // para crear

Route::put ('/campanias/{id}', [campaniasController::class,'update']); // para editar

Route::delete ('/campanias/{id}', [campaniasController::class,'destroy']); // para borrar


Route::get('/numeros', [numerosController::class,'index']); // muestre todos

Route::get ('/numeros/{id}', [numerosController::class,'show']); // muestre uno en particular

Route::post ('/numeros', [numerosController::class,'store']); // para crear

Route::put ('/numeros/{id}', [numerosController::class,'update']); // para editar

Route::delete ('/numeros/{id}', [numerosController::class,'destroy']); // para borrar