<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TimesheetController;
use Illuminate\Support\Facades\Artisan;


Route::get('/', function () {
    return view('welcome');
});

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



Route::get('/logs', [App\Http\Controllers\LogViewerController::class, 'index'])->name('logs.view');
Route::get('/logs/clear', [App\Http\Controllers\LogViewerController::class, 'clear'])->name('logs.clear');

