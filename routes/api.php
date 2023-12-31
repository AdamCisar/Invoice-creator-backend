<?php

use App\Http\Controllers\CustomItemController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceItemController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\ScraperController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('search/{query}', [ScraperController::class, 'show']);

Route::get('invoice-download/{id}', [PdfController::class, 'show']);

Route::get('item', [ItemController::class, 'show']);
Route::post('item', [ItemController::class, 'save']);
Route::patch('item/{id}', [ItemController::class, 'update']);

Route::put('custom-item', [CustomItemController::class, 'save']);

Route::post('invoice', [InvoiceController::class, 'save']);
Route::get('invoice', [InvoiceController::class, 'show']);
Route::delete('invoice/{id}', [InvoiceController::class, 'delete']);

Route::post('invoice-item', [InvoiceItemController::class, 'save']);
Route::delete('invoice-item', [InvoiceItemController::class, 'delete']);
Route::get('invoice-item/{invoiceId}', [InvoiceItemController::class, 'show']);

