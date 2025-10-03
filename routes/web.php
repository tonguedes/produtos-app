<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReviewController;
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;

/* Route::get('/', function () {
    return view('welcome');
}); */

Route::get('/', function () {
    return redirect()->route('dashboard');
});




Route::resource('products', ProductController::class);


Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::post('/products/{product}/favorite', [ProductController::class, 'toggleFavorite'])
  ->middleware(['auth'])
->name('products.favorite');

Route::post('/products/{product}/update-stock', [ProductController::class, 'updateStock'])
  ->middleware(['auth'])
    ->name('products.updateStock');



/* Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
 */

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//review 

Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])
    ->middleware('auth')
    ->name('products.reviews.store');

//download pdf and excel





Route::get('/products/export/excel', [ProductController::class, 'exportExcel'])->name('products.export.excel');
Route::get('/products/export/pdf', [ProductController::class, 'exportPdf'])->name('products.export.pdf');




require __DIR__.'/auth.php';
