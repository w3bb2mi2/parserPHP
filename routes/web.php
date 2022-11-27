<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers;
use App\Http\Controllers\ParseController;
use App\Service\Parser2\Parser;

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


Route::view('/', "xmlParser");

Route::post('/xmlParser', [ParseController::class, 'index']);
Route::get('/parser', [Parser::class, 'save2Db']);

