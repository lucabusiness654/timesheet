<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class LogViewerController extends Controller
{
    public function index()
    {
        $logFile = storage_path('logs/laravel.log');

        if (!File::exists($logFile)) {
            return response("Log file not found.", 404);
        }

        $logs = File::get($logFile);


        return view('log-viewer', ['logs' => $logs]);
    }

    public function clear()
    {
        $logFile = storage_path('logs/laravel.log');

        if (file_exists($logFile)) {
            file_put_contents($logFile, ''); // Clear the file content
        }

        return redirect()->route('logs.view')->with('success', 'Logs have been cleared.');
    }
}

