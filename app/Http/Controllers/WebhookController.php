<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function store(Request $request)
    {
        // Optional: You can format or filter the request data here
        $payload = $request->all();

        // Log the payload
        Log::info('Webhook received:', [
            'timestamp' => now()->toDateTimeString(),
            'data' => $payload,
        ]);

        return response()->json(['status' => 'success'], 200);
    }
}
