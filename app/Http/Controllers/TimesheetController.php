<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use DateTime;
use Cache;

class TimesheetController extends Controller
{
    private $openRouterApiKey;
    private $openRouterBaseUrl = 'https://openrouter.ai/api/v1';

    public function __construct()
    {
        $this->openRouterApiKey = env('OPENROUTER_API_KEY');
    }

    public function generateSummary(Request $request)
{
    $input = $request->input('timesheet_data');
    $name = $request->input('name');
    $week = $request->input('week_no');
    $model = 'deepseek/deepseek-prover-v2:free';

    // Generate unique cache key
    $cacheKey = "summary_{$name}_week{$week}_model_" . md5($model);

    // Cache the result for 24 hours
    $dailySummaries = Cache::remember($cacheKey, now()->addDay(), function () use ($input, $model) {
        $parsedData = $this->parseTimesheetData($input);
        return $this->generateDailySummaries($parsedData, $model);
    });

    return view('timesheet.result', [
        'dailySummaries' => $dailySummaries,
        'modelUsed' => $model,
        'provider' => $this->provider ?? 'Unknown', // fallback if $this->provider is not defined
    ]);
}


    private function parseTimesheetData($data)
    {
        // Same parsing logic as before
        $employees = [];
        $currentEmployee = null;
        $lines = explode("\n", trim($data));

        foreach ($lines as $line) {
            if (strpos($line, 'Emp Id:') !== false) {
                $currentEmployee = [
                    'id' => trim(str_replace('Emp Id:', '', $line)),
                    'name' => '',
                    'entries' => []
                ];
            } elseif (strpos($line, 'Emp Name:') !== false && $currentEmployee) {
                $currentEmployee['name'] = trim(str_replace('Emp Name:', '', $line));
                $employees[] = $currentEmployee;
            } elseif (preg_match('/^\d{2}\/\d{2}\/\d{4}/', $line) && !empty($employees)) {
                $parts = preg_split('/\t+/', $line);
                if (count($parts) >= 4) {
                    $lastEmployee = &$employees[count($employees) - 1];
                    $lastEmployee['entries'][] = [
                        'date' => $parts[0],
                        'project' => $parts[1] ?? '',
                        'activity' => $parts[2] ?? '',
                        'description' => $parts[3] ?? ''
                    ];
                }
            }
        }

        return $employees;
    }

    private function generateDailySummaries($parsedData, $model)
{
    $entriesByDate = [];
    
    // Group all entries by date while preserving original content
    foreach ($parsedData as $employee) {
        foreach ($employee['entries'] as $entry) {
            $date = $entry['date'];
            if (!isset($entriesByDate[$date])) {
                $entriesByDate[$date] = [];
            }
            // Remove "Development:" prefix if present
            $activity = preg_replace('/^Development:\s*/i', '', $entry['activity']);
            $description = preg_replace('/^Development:\s*/i', '', $entry['description']);
            $entriesByDate[$date][] = [
                'employee' => $employee['name'],
                'activity' => $activity,
                'description' => $description
            ];
        }
    }

    $dailySummaries = [];
    
    foreach ($entriesByDate as $date => $entries) {
        // Build comprehensive activity list with ALL details
        $detailedActivities = "Complete daily activities with ALL details:\n";
        foreach ($entries as $entry) {
            $detailedActivities .= sprintf(
                "[%s] %s: %s\n",
                $entry['employee'],
                $entry['activity'],
                $entry['description']
            );
        }

        $prompt = <<<PROMPT
Create EXACTLY ONE fluent sentence summarizing my support activities as team lead on {$date} that:

1. MUST include every team member mentioned
2. MUST preserve ALL original task details exactly as written (without "Development:" prefix)
3. MUST explain specifically how I helped each person
4. MUST maintain natural flow in one complete sentence
5. MUST NOT use phrases like "I completed" or "I worked on"
6. MUST focus on the support provided rather than individual completion

Activities with ALL details:
{$detailedActivities}

Respond ONLY with the summary sentence in this EXACT format:
"Supported [Name] with [EXACT original task description] by [specific help method], assisted [Name] with [EXACT original task description] through [specific help method], and helped [Name] with [EXACT original task description] via [specific help method]."

DO NOT shorten, modify, or omit any details from the original task descriptions.
PROMPT;

        $summary = $this->getAISummary($prompt, $model);
        
        $dailySummaries[] = [
            'date' => $date,
            'summary' => $summary,
            'raw_activities' => $entries
        ];
    }

    // Sort by date
    usort($dailySummaries, function($a, $b) {
        return DateTime::createFromFormat('d/m/Y', $a['date']) <=> 
               DateTime::createFromFormat('d/m/Y', $b['date']);
    });

    return $dailySummaries;
}
    private function getAISummary($prompt, $model)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->openRouterApiKey,
                'HTTP-Referer' => env('APP_URL'),
                'X-Title' => 'Timesheet Summary Generator'
            ])
            ->timeout(60)
            ->connectTimeout(20)
            ->retry(3, 5000)
            ->post("{$this->openRouterBaseUrl}/chat/completions", [
                'model' => $model,
                'messages' => [
                    ['role' => 'system', 'content' => 'You create concise, fluent single-sentence summaries of support activities.'],
                    ['role' => 'user', 'content' => $prompt]
                ],
                'temperature' => 0.5,
                'max_tokens' => 200
            ]);

            if ($response->successful()) {
                $content = $response->json()['choices'][0]['message']['content'] ?? '';
                return preg_replace('/^\d+\.\s+|^-\s+/', '', $content);
            }

            return 'Error generating summary: ' . $response->status();
        } catch (\Exception $e) {
            return 'Error generating summary (Exception): ' . $e->getMessage();
        }
    }

}