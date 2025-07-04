@extends('layouts.app')

@section('content')
<div class="container py-5">
    <!-- Header -->
    <div class="text-center mb-5">
        <h1 class="display-5 fw-bold text-dark mb-3">Dashboard</h1>
        <p class="lead text-muted">Manage your system tools and resources</p>
    </div>

    <!-- Cards Grid -->
    <div class="row g-4">
        <!-- Timesheet Card -->
        <div class="col-md-6 col-lg-4">
            <a href="{{ route('timesheet.view') }}" class="card card-hover h-100 text-decoration-none">
                <div class="card-body p-4">
                    <div class="d-flex align-items-start">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar text-primary">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                        </div>
                        <div>
                            <h3 class="h5 card-title mb-1 text-dark">Timesheet</h3>
                            <p class="text-muted small mb-3">Track and manage your work hours</p>
                            <div class="d-flex align-items-center text-primary fw-medium small">
                                <span>Go to Timesheet</span>
                                <i class="fas fa-chevron-right ms-2 small transition-all"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Logs Card -->
        <div class="col-md-6 col-lg-4">
            <a href="{{ route('logs.view') }}" class="card card-hover h-100 text-decoration-none">
                <div class="card-body p-4">
                    <div class="d-flex align-items-start">
                        <div class="bg-danger bg-opacity-10 p-3 rounded-3 me-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-activity text-danger">
                                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                            </svg>
                        </div>
                        <div>
                            <h3 class="h5 card-title mb-1 text-dark">System Logs</h3>
                            <p class="text-muted small mb-3">Monitor application activity and errors</p>
                            <div class="d-flex align-items-center text-danger fw-medium small">
                                <span>View Logs</span>
                                <i class="fas fa-chevron-right ms-2 small transition-all"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Rewards & Recognition Card -->
        <div class="col-md-6 col-lg-4">
            <a href="{{ route('rewards.view') }}" class="card card-hover h-100 text-decoration-none">
                <div class="card-body p-4">
                    <div class="d-flex align-items-start">
                        <div class="bg-warning bg-opacity-10 p-3 rounded-3 me-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-award text-warning">
                                <circle cx="12" cy="8" r="7"></circle>
                                <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline>
                            </svg>
                        </div>
                        <div>
                            <h3 class="h5 card-title mb-1 text-dark">Rewards & Recognition</h3>
                            <p class="text-muted small mb-3">View achievements and employee recognition</p>
                            <div class="d-flex align-items-center text-warning fw-medium small">
                                <span>View Rewards</span>
                                <i class="fas fa-chevron-right ms-2 small transition-all"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Zoho Inventory Documentation Feature -->
        <div class="col-md-6 col-lg-4">
            <a href="{{ route('zoho-inventory-docs.view') }}" class="card card-hover h-100 text-decoration-none">
                <div class="card-body p-4">
                    <div class="d-flex align-items-start">
                        <div class="bg-success bg-opacity-10 p-3 rounded-3 me-4">
                            <!-- Box/Inventory SVG Icon in Green -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-box text-success">
                                <path d="M21 16V8a2 2 0 0 0-1-1.73L13 2.27a2 2 0 0 0-2 0L4 6.27A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4a2 2 0 0 0 1-1.73z"/>
                                <polyline points="3.27 6.96 12 12.01 20.73 6.96"/>
                                <line x1="12" y1="22.08" x2="12" y2="12"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="h5 card-title mb-1 text-dark">Zoho Inventory Guide</h3>
                            <p class="text-muted small mb-3">Understand and manage the complete inventory flow with Zoho docs.</p>
                            <div class="d-flex align-items-center text-success fw-medium small">
                                <span>Explore Documentation</span>
                                <i class="fas fa-chevron-right ms-2 small transition-all"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

       
    </div>

    <!-- Stats Section -->
    {{-- <div class="row mt-4 g-4">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase text-muted mb-2 small">Total Hours</h6>
                            <h3 class="mb-0">38.5</h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock text-primary">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="text-success small fw-bold">
                            <i class="fas fa-caret-up me-1"></i> 2.4%
                        </span>
                        <span class="text-muted small ms-1">from last week</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase text-muted mb-2 small">Recent Errors</h6>
                            <h3 class="mb-0">4</h3>
                        </div>
                        <div class="bg-danger bg-opacity-10 p-3 rounded-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-triangle text-danger">
                                <path d="M10.29 3.86L1.82 18a2 2 2 0 0 0 1.71 3h16.94a2 2 2 0 0 0 1.71-3L13.71 3.86a2 2 2 0 0 0-3.42 0z"></path>
                                <line x1="12" y1="9" x2="12" y2="13"></line>
                                <line x1="12" y1="17" x2="12.01" y2="17"></line>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="text-success small fw-bold">
                            <i class="fas fa-caret-up me-1"></i> 60%
                        </span>
                        <span class="text-muted small ms-1">reduction</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase text-muted mb-2 small">Tasks Completed</h6>
                            <h3 class="mb-0">12/15</h3>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle text-success">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 80%;" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <span class="text-muted small">80% completed</span>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
</div>

<style>
    .card-hover {
        transition: all 0.3s ease;
        border: 1px solid rgba(0,0,0,0.05);
    }
    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        border-color: rgba(0,0,0,0.1);
    }
    .card-hover:hover .feather {
        transform: scale(1.05);
    }
    .feather {
        transition: all 0.3s ease;
    }
    .transition-all {
        transition: all 0.2s ease;
    }
    .card-hover:hover .fa-chevron-right {
        transform: translateX(3px);
    }
</style>
@endsection