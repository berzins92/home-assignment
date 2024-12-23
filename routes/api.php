<?php

use App\Http\Controllers\Api\InvestmentDistributionApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/distribution', [InvestmentDistributionApiController::class, 'distribute']);
Route::get('/distribution', [InvestmentDistributionApiController::class, 'getAllDistributions']);
Route::get('/distribution/roundings', [InvestmentDistributionApiController::class, 'getRoundingDetailsForDistributions']);
