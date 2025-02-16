@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Title Row -->
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="mb-0 d-flex align-items-center">
                <i class="bi bi-graph-up-arrow text-primary me-2"></i>
                Exchange Rates
            </h4>
        </div>
    </div>

    <!-- Subtitle Row with Date -->
    <div class="row justify-content-between align-items-center mb-4">
        <div class="col-auto">
            <h6 class="text-secondary mb-0" id="rate-date">
                Rate as of <span id="display-date" class="fw-semibold">{{ date('d-m-Y') }}</span>
            </h6>
        </div>
        <div class="col-auto">
            <div class="input-group shadow-sm" style="width: 200px;">
                <input type="text" class="form-control border-end-0" id="datepicker" placeholder="Select Date">
                <span class="input-group-text bg-primary border-start-0">
                    <i class="bi bi-calendar3 text-white"></i>
                </span>
            </div>
        </div>
    </div>

    <!-- Loading Placeholder -->
    <div id="loading-placeholder" class="text-center py-5">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <div class="mt-3 text-secondary">Loading exchange rates...</div>
    </div>

    <!-- Error Message -->
    <div id="error-message" class="alert alert-danger d-none shadow-sm" role="alert">
        <div class="d-flex align-items-center">
            <i class="bi bi-exclamation-circle me-2"></i>
            <div>Error loading exchange rates. Please try again.</div>
        </div>
    </div>

    <!-- Exchange Rates Grid -->
    <div class="row g-4" id="rates-grid">
    </div>
</div>
@endsection
\
