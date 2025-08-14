<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AiMockController;
use App\Http\Controllers\Api\PurchaseOrderMockController;
use App\Http\Controllers\DocumentController;

Route::post('/mock-ai-extract', [AiMockController::class, 'extract']);
Route::get('/mock-purchase-orders', [PurchaseOrderMockController::class, 'index']);
Route::apiResource('/documents', DocumentController::class)->only(['store']);