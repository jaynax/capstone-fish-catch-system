@extends('layouts.users.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title">
                                <i class="bx bx-file me-2"></i>Fish Catch Report #{{ $catch->id }}
                            </h4>
                            <p class="card-subtitle">BFAR Fish Catch Monitoring Form - {{ \Carbon\Carbon::parse($catch->date_sampling)->format('F d, Y') }}</p>
                        </div>
                        <div class="btn-group">
                            <a href="{{ route('catches.index') }}" class="btn btn-outline-secondary">
                                <i class="bx bx-arrow-back me-1"></i>Back to List
                            </a>
                            <a href="{{ route('catches.pdf', $catch) }}" class="btn btn-success">
                                <i class="bx bx-download me-1"></i>Download PDF
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- General Information -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="border-bottom pb-2 mb-3">
                                <i class="bx bx-info-circle me-2"></i>General Information
                            </h5>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Region:</label>
                            <p class="form-control-plaintext">{{ $catch->region }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Landing Center:</label>
                            <p class="form-control-plaintext">{{ $catch->landing_center }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Date of Sampling:</label>
                            <p class="form-control-plaintext">{{ \Carbon\Carbon::parse($catch->date_sampling)->format('F d, Y') }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Time of Landing:</label>
                            <p class="form-control-plaintext">{{ $catch->time_landing }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Enumerator(s):</label>
                            <p class="form-control-plaintext">{{ $catch->enumerators }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Fishing Ground:</label>
                            <p class="form-control-plaintext">{{ $catch->fishing_ground }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Weather Conditions:</label>
                            <p class="form-control-plaintext">{{ $catch->weather_conditions }}</p>
                        </div>
                    </div>

                    <!-- Fisherman Information -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="border-bottom pb-2 mb-3">
                                <i class="bx bx-user me-2"></i>Fisherman Information
                            </h5>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Fisherman Registration ID:</label>
                            <p class="form-control-plaintext">{{ $catch->fisherman_registration_id ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Fisherman's Full Name:</label>
                            <p class="form-control-plaintext">{{ $catch->fisherman_name ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <!-- Boat Information -->
                    @if($catch->boats->count() > 0)
                        @foreach($catch->boats as $index => $boat)
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="border-bottom pb-2 mb-3">
                                        <i class="bx bx-ship me-2"></i>Boat Information #{{ $index + 1 }}
                                    </h5>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Boat Name (F/B):</label>
                                    <p class="form-control-plaintext">{{ $boat->boat_name }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Boat Type:</label>
                                    <p class="form-control-plaintext">{{ $boat->boat_type }}</p>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label fw-bold">Length (m):</label>
                                    <p class="form-control-plaintext">{{ number_format($boat->boat_length, 2) }}</p>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label fw-bold">Width (m):</label>
                                    <p class="form-control-plaintext">{{ number_format($boat->boat_width, 2) }}</p>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label fw-bold">Depth (m):</label>
                                    <p class="form-control-plaintext">{{ number_format($boat->boat_depth, 2) }}</p>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label fw-bold">Gross Tonnage (GT):</label>
                                    <p class="form-control-plaintext">{{ $boat->gross_tonnage ? number_format($boat->gross_tonnage, 2) : 'N/A' }}</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Horsepower (HP):</label>
                                    <p class="form-control-plaintext">{{ $boat->horsepower ?: 'N/A' }}</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Engine Type:</label>
                                    <p class="form-control-plaintext">{{ $boat->engine_type ?: 'N/A' }}</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Number of Fishermen:</label>
                                    <p class="form-control-plaintext">{{ $boat->fishermen_count }}</p>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="alert alert-warning">No boat information available.</div>
                    @endif

                    <!-- Fishing Operation Details -->
                    @if($catch->fishingOperations->count() > 0)
                        @foreach($catch->fishingOperations as $index => $operation)
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="border-bottom pb-2 mb-3">
                                        <i class="bx bx-anchor me-2"></i>Fishing Operation #{{ $index + 1 }}
                                    </h5>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Fishing Gear Type:</label>
                                    <p class="form-control-plaintext">{{ $operation->fishing_gear_type }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Days Fished:</label>
                                    <p class="form-control-plaintext">{{ $operation->days_fished }}</p>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-bold">Gear Specifications:</label>
                                    <p class="form-control-plaintext">{{ $operation->gear_specifications ?: 'N/A' }}</p>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label fw-bold">Hooks/Hauls:</label>
                                    <p class="form-control-plaintext">{{ $operation->hooks_hauls ?: 'N/A' }}</p>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label fw-bold">Net/Line Length (m):</label>
                                    <p class="form-control-plaintext">{{ $operation->net_line_length ? number_format($operation->net_line_length, 2) : 'N/A' }}</p>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label fw-bold">Soaking Time (hrs):</label>
                                    <p class="form-control-plaintext">{{ $operation->soaking_time ? number_format($operation->soaking_time, 2) : 'N/A' }}</p>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label fw-bold">Mesh Size (cm):</label>
                                    <p class="form-control-plaintext">{{ $operation->mesh_size ? number_format($operation->mesh_size, 2) : 'N/A' }}</p>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label fw-bold">Latitude:</label>
                                    <p class="form-control-plaintext">
                                        {{ $operation->latitude ? number_format($operation->latitude, 6) : 'N/A' }}
                                    </p>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label fw-bold">Longitude:</label>
                                    <p class="form-control-plaintext">
                                        {{ $operation->longitude ? number_format($operation->longitude, 6) : 'N/A' }}
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Map Location:</label>
                                    <p class="form-control-plaintext">
                                        @if($operation->latitude && $operation->longitude)
                                            <a href="https://www.google.com/maps?q={{ $operation->latitude }},{{ $operation->longitude }}" 
                                               target="_blank" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="bx bx-map"></i> View on Map
                                            </a>
                                        @else
                                            N/A
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Payao Used:</label>
                                    <p class="form-control-plaintext">{{ $operation->payao_used ?: 'N/A' }}</p>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-bold">Fishing Effort Notes:</label>
                                    <p class="form-control-plaintext">{{ $operation->fishing_effort_notes ?: 'N/A' }}</p>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="alert alert-warning">No fishing operation information available.</div>
                    @endif

                    <!-- Catch Information -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="border-bottom pb-2 mb-3">
                                <i class="bx bx-weight me-2"></i>Catch Information
                            </h5>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Catch Type:</label>
                            <p class="form-control-plaintext">{{ $catch->catch_type }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Total Catch (kg):</label>
                            <p class="form-control-plaintext">{{ number_format($catch->total_catch_kg, 2) }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Sub-sample Taken:</label>
                            <p class="form-control-plaintext">{{ $catch->subsample_taken ?: 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Sub-sample Weight (kg):</label>
                            <p class="form-control-plaintext">{{ $catch->subsample_weight ? number_format($catch->subsample_weight, 2) : 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Below Legal Size:</label>
                            <p class="form-control-plaintext">{{ $catch->below_legal_size ?: 'N/A' }}</p>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold">Below Legal Species:</label>
                            <p class="form-control-plaintext">{{ $catch->below_legal_species ?: 'N/A' }}</p>
                        </div>
                    </div>

                    <!-- AI Species Recognition & Size Estimation -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="border-bottom pb-2 mb-3">
                                <i class="bx bx-brain me-2"></i>AI Species Recognition & Size Estimation
                            </h5>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Species:</label>
                            <p class="form-control-plaintext">{{ $catch->species }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Scientific Name:</label>
                            <p class="form-control-plaintext">{{ $catch->scientific_name ?: 'N/A' }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Length (cm):</label>
                            <p class="form-control-plaintext">{{ number_format($catch->length_cm, 1) }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Weight (g):</label>
                            <p class="form-control-plaintext">{{ number_format($catch->weight_g, 1) }}</p>
                        </div>
                        
                    </div>

                    <!-- Fish Photo -->
                    @if($catch->image_path)
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="border-bottom pb-2 mb-3">
                                <i class="bx bx-image me-2"></i>Fish Photo
                            </h5>
                            <div class="text-center">
                                <img src="{{ asset('storage/' . $catch->image_path) }}" 
                                     alt="Fish Photo" 
                                     class="img-fluid rounded" 
                                     style="max-height: 400px;">
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Report Metadata -->
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-info">
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>Report ID:</strong> #{{ $catch->id }}<br>
                                        <strong>Submitted by:</strong> {{ $catch->user->name }}<br>
                                        <strong>Submitted on:</strong> {{ $catch->created_at->format('F d, Y \a\t g:i A') }}
                                    </div>
                                    <div class="col-md-6 text-md-end">
                                        <strong>Last updated:</strong> {{ $catch->updated_at->format('F d, Y \a\t g:i A') }}<br>
                                        <strong>Processing mode:</strong> 
                                        @if($catch->image_path)
                                            <span class="badge bg-success">AI Processing</span>
                                        @else
                                            <span class="badge bg-warning">Manual Entry</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.form-control-plaintext {
    padding: 0.375rem 0;
    margin-bottom: 0;
    color: #212529;
    background-color: transparent;
    border: solid transparent;
    border-width: 1px 0;
}

.border-bottom {
    border-bottom: 2px solid #dee2e6 !important;
}

.alert-info {
    background-color: #d1ecf1;
    border-color: #bee5eb;
    color: #0c5460;
}
</style>
@endsection 