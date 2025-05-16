@extends('layouts.app')

@section('content')
<style>
    .summary-card {
        animation: fadeInUp 0.6s ease;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .copy-btn {
        float: right;
    }

    .summary-text {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-size: 1rem;
        line-height: 1.5;
    }

    .table thead th {
        background-color: #f8f9fa;
    }

    .copied-alert {
        display: none;
        font-size: 0.85rem;
        color: green;
    }
</style>

<div class="container mt-5">
    <h2 class="mb-1">🗓️ Weekly Timesheet Summary</h2>

    @php
        // Get the first valid date from summaries
        $firstDate = null;
        foreach ($dailySummaries as $day) {
            $cleanDate = preg_replace('/\s*\(.*\)/', '', $day['date']);
            try {
                $firstDate = \Carbon\Carbon::createFromFormat('d/m/Y', $cleanDate);
                break;
            } catch (Exception $e) {}
        }

        $weekNumber = $firstDate ? $firstDate->weekOfYear : null;
        $year = $firstDate ? $firstDate->year : null;
    @endphp

    @if($weekNumber && $year)
        <p><strong>📅 Week {{ $weekNumber }} of {{ $year }}</strong></p>
    @endif

    <p><small>🔍 Generated using: <strong>{{ $modelUsed }}</strong></small></p>
    <a href="{{ url('/timesheet') }}" class="btn btn-secondary mb-3">← Back to Timesheet</a>

    <div class="table-responsive mt-4">
        <table class="table table-bordered align-middle shadow-sm">
            <thead class="text-center">
                <tr>
                    <th width="15%">📅 Date</th>
                    <th>📝 Summary</th>
                    <th width="10%">📋 Copy</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dailySummaries as $day)
                    @php
                        $cleanDate = preg_replace('/\s*\(.*\)/', '', $day['date']);
                    @endphp
                    <tr class="summary-card">
                        <td class="text-center">
                            {{ \Carbon\Carbon::createFromFormat('d/m/Y', $cleanDate)->format('d M Y') }}
                        </td>
                        <td>
                            <p id="summary-{{ $loop->index }}" class="summary-text mb-0">
                                {{ $day['summary'] }}
                            </p>
                            <span class="copied-alert" id="alert-{{ $loop->index }}">✅ Copied!</span>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-outline-primary btn-sm copy-btn"
                                onclick="copyToClipboard('summary-{{ $loop->index }}', 'alert-{{ $loop->index }}')">
                                Copy
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    function copyToClipboard(summaryId, alertId) {
        const text = document.getElementById(summaryId).innerText;
        navigator.clipboard.writeText(text).then(() => {
            const alert = document.getElementById(alertId);
            alert.style.display = 'inline';
            setTimeout(() => alert.style.display = 'none', 2000);
        });
    }
</script>
@endsection
