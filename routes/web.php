<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortfolioController; // Add this line

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

// You can keep or modify this default route
Route::get('/', function () {
    return view('welcome');
});

 
// Portfolio Creation Routes
Route::get('/create', [PortfolioController::class, 'create'])->name('portfolio.create');
Route::post('/create', [PortfolioController::class, 'store'])->name('portfolio.store');

// Route to display a single portfolio (using Route Model Binding)
Route::get('/portfolio/{portfolio}', [PortfolioController::class, 'show'])->name('portfolio.show');
// Explanation: Laravel will automatically fetch the Portfolio model instance based on the ID in the URL and inject it into the show method.
