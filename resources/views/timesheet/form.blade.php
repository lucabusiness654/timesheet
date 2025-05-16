@extends('layouts.app')

@section('content')

@if(session('error'))
    <div class="alert alert-warning">
        {{ session('error') }}
    </div>
@endif


<div class="container mt-4">

    @if(session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

<form method="POST" action="{{ route('cache.clear') }}" class="mb-3">
    @csrf
    <button type="submit" class="btn btn-danger">
        🧹 Clear Cache
    </button>
</form>


    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">🧠 AI Timesheet Summary Generator</div>

            
                <div class="card-body">
                    <form method="POST" action="{{ route('timesheet.generate') }}">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Select Name:</label>
                            <select class="form-select" id="name" name="name" required>
                                <option value="">-- Select Member --</option>
                                @foreach(['Prasanna','Sathiyamurthy','Bharath'] as $person)
                                    <option value="{{ $person }}">{{ $person }}</option>
                                @endforeach
                            </select>
                        </div>

                        @php
                        use Carbon\Carbon;
                    
                        $today = Carbon::today();
                    
                        // Start from 20th of the previous month
                        $start = Carbon::now()->subMonthNoOverflow()->day(20);
                    
                        // Move to Monday of the week that contains the 20th
                        $startOfWeek = $start->copy()->startOfWeek(Carbon::MONDAY);
                    
                        $weeks = [];
                        $current = $startOfWeek->copy();
                    
                        while ($current->lte($today)) {
                            $weekStart = $current->copy();
                            $weekEnd = $current->copy()->endOfWeek(Carbon::SUNDAY);
                            $weekNumber = $current->isoWeek();
                    
                            if ($weekEnd->gte($start) && $weekStart->lte($today)) {
                                $weeks[] = [
                                    'number' => $weekNumber,
                                    'start' => $weekStart->format('d-m-Y'),
                                    'end' => $weekEnd->format('d-m-Y'),
                                    'year' => $weekStart->year
                                ];
                            }
                    
                            $current->addWeek();
                        }
                    @endphp
                    
                    <div class="form-group mb-3">
                        <label for="week_no" class="form-label fw-bold text-primary">Select Week Number:</label>
                        <select class="form-select border-primary" id="week_no" name="week_no" required>
                            @foreach ($weeks as $week)
                                <option value="{{ $week['number'] }}">
                                    🗓️ <span class="fw-bold text-success">Week {{ $week['number'] }}</span> —
                                    <span class="text-dark">{{ $week['start'] }}</span> →
                                    <span class="text-dark">{{ $week['end'] }}</span>
                                </option>
                            @endforeach
                        </select>
                    </div>
                    

                        <div class="form-group mb-3">
                            <label for="timesheet_data" class="form-label">Paste Team Timesheet Data:</label>
                            <textarea class="form-control" id="timesheet_data" name="timesheet_data" rows="18" required style="font-family: monospace;"></textarea>
                        </div>

                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-robot me-2"></i> Generate Summary
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
