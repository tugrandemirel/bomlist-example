<?php

use App\Http\Controllers\BomController;
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
    return view('welcome');
});
Route::get('/bom-index', [BomController::class, 'index'])->name('bom-list.index');
Route::get('/bom-list', [BomController::class, 'list'])->name('bom-list.list');
Route::get('/bom-addPartToExistingBom', [BomController::class, 'addPartToExistingBom'])->name('bom-list.addPartToExistingBom');