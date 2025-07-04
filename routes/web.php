<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TimesheetController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\ProductSearchController;


Route::get('/', function () {
    return view('welcome');
});

// Route::get('/', function () {
//     return view('zlta_ppt');
// });

Route::get('/timesheet', function () {
    return view('timesheet.form', [
        'aiModels' => [
            'deepseek/deepseek-prover-v2:free' => 'DeepSeek Chat',
            'gpt-3.5-turbo' => 'GPT-3.5 Turbo',
            'gpt-4' => 'GPT-4',
            'claude-2' => 'Claude 2',
            'mistralai/mistral-small-24b-instruct-2501:free' => 'Mistral 7B'
        ]
    ]);
})->name('timesheet.view');


Route::post('/timesheet/generate', [TimesheetController::class, 'generateSummary'])->name('timesheet.generate');

Route::post('/clear-cache', function () {
    Artisan::call('optimize:clear');
    return redirect()->back()->with('status', '✅ Cache cleared successfully!');
})->name('cache.clear');


Route::get('/rewards', function () {
    return view('rewards');
})->name('rewards.view');

Route::get('/zoho-inventory-docs', function () {
    return view('zoho-inventory-docs');
})->name('zoho-inventory-docs.view');




Route::get('/logs', [App\Http\Controllers\LogViewerController::class, 'index'])->name('logs.view');
Route::get('/logs/clear', [App\Http\Controllers\LogViewerController::class, 'clear'])->name('logs.clear');



// API Routes
Route::get('/api/products/search', [ProductSearchController::class, 'search']);

// Web Routes
Route::get('/products', function () {
    return view('products.search');
});