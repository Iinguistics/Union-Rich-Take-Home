<?php

use App\Http\Controllers\ClosureController;
use App\Http\Controllers\Shopper\ShopperQueueController;
use App\Http\Controllers\Store\Location\LocationController;
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

Route::get('/', [ClosureController::class, 'index']);
Route::get('/create-location-checkin', [LocationController::class, 'createLocationCheckin']);

Route::name('locationCheckin')
    ->post('/location-checkin', [LocationController::class, 'locationCheckin']);

Route::name('locationCustomerCheckin')
    ->get('/location-checkin/{locationId}', [LocationController::class, 'locationCustomerCheckin']);

Route::name('queueCustomerCheckin')
    ->post('/queue-customer-checkin', [ShopperQueueController::class, 'queueCustomerCheckin']);


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])
    ->namespace('Store')
    ->prefix('store')
    ->name('store.')
    ->group(__DIR__ . '/Store/web.php');

Route::namespace('Store')
    ->prefix('sign-in')
    ->name('public.')
    ->group(__DIR__ . '/Store/Location/public.php');
