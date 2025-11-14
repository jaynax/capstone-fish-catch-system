@extends('layouts.users.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title">
                            <i class="bx bx-edit me-2"></i>Edit Fish Catch Report #{{ $catch->id }}
                        </h4>
                        <div class="btn-group">
                            <a href="{{ route('catches.index') }}" class="btn btn-outline-secondary">
                                <i class="bx bx-arrow-back me-1"></i>Back to List
                            </a>
                            <a href="{{ route('catches.show', $catch->id) }}" class="btn btn-info">
                                <i class="bx bx-show me-1"></i>View
                            </a>
                        </div>
                    </div>
                    <p class="card-subtitle mt-2">BFAR Fish Catch Monitoring Form - {{ \Carbon\Carbon::parse($catch->date_sampling)->format('F d, Y') }}</p>
                </div>

                <div class="card-body">
                    <form id="catchForm" action="{{ route('catches.update', $catch->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <!-- General Information -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">
                                    <i class="bx bx-info-circle me-2"></i>General Information
                                </h5>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-bold">Region:</label>
                                <select class="form-select @error('region') is-invalid @enderror" name="region" required>
                                    <option value="" disabled>Select Region</option>
                                    @foreach(['I', 'II', 'III', 'IV-A', 'IV-B', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII', 'XIII', 'ARMM', 'CAR', 'NCR'] as $region)
                                        <option value="{{ $region }}" {{ old('region', $catch->region) == $region ? 'selected' : '' }}>{{ $region }}</option>
                                    @endforeach
                                </select>
                                @error('region')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-bold">Landing Center:</label>
                                <input type="text" class="form-control @error('landing_center') is-invalid @enderror" 
                                       name="landing_center" value="{{ old('landing_center', $catch->landing_center) }}" required>
                                @error('landing_center')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-bold">Date of Sampling:</label>
                                <input type="date" class="form-control @error('date_sampling') is-invalid @enderror" 
                                       name="date_sampling" value="{{ old('date_sampling', $catch->date_sampling) }}" required>
                                @error('date_sampling')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-bold">Time of Landing:</label>
                                <input type="time" class="form-control @error('time_landing') is-invalid @enderror" 
                                       name="time_landing" value="{{ old('time_landing', $catch->time_landing) }}" required>
                                @error('time_landing')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Enumerator(s):</label>
                                <input type="text" class="form-control @error('enumerators') is-invalid @enderror" 
                                       name="enumerators" value="{{ old('enumerators', $catch->enumerators) }}" required>
                                @error('enumerators')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Fishing Ground:</label>
                                <input type="text" class="form-control @error('fishing_ground') is-invalid @enderror" 
                                       name="fishing_ground" value="{{ old('fishing_ground', $catch->fishing_ground) }}" required>
                                @error('fishing_ground')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Weather Conditions:</label>
                                <select class="form-select @error('weather_conditions') is-invalid @enderror" name="weather_conditions" required>
                                    <option value="Sunny" {{ old('weather_conditions', $catch->weather_conditions) == 'Sunny' ? 'selected' : '' }}>Sunny</option>
                                    <option value="Partly Cloudy" {{ old('weather_conditions', $catch->weather_conditions) == 'Partly Cloudy' ? 'selected' : '' }}>Partly Cloudy</option>
                                    <option value="Cloudy" {{ old('weather_conditions', $catch->weather_conditions) == 'Cloudy' ? 'selected' : '' }}>Cloudy</option>
                                    <option value="Rainy" {{ old('weather_conditions', $catch->weather_conditions) == 'Rainy' ? 'selected' : '' }}>Rainy</option>
                                    <option value="Stormy" {{ old('weather_conditions', $catch->weather_conditions) == 'Stormy' ? 'selected' : '' }}>Stormy</option>
                                </select>
                                @error('weather_conditions')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
                                <label class="form-label fw-bold">Fisherman Registration ID: <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('fisherman_registration_id') is-invalid @enderror" 
                                       name="fisherman_registration_id" 
                                       value="{{ old('fisherman_registration_id', $catch->fisherman_registration_id) }}" 
                                       placeholder="Enter the fisherman registration ID" required>
                                @error('fisherman_registration_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Fisherman's Full Name: <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('fisherman_name') is-invalid @enderror" 
                                       name="fisherman_name" 
                                       value="{{ old('fisherman_name', $catch->fisherman_name) }}" required>
                                @error('fisherman_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            </div>
                        </div>

                        <!-- Boat Information -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">
                                    <i class="bx bx-ship me-2"></i>Boat Information
                                </h5>
                            </div>
                            
                            <!-- Boat #1 -->
                            <div class="col-12 mb-4">
                                <div class="card">
                                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0">Boat #1</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Boat Type: <span class="text-danger">*</span></label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="boat_type_motorized" name="boats[0][is_motorized]" value="1" {{ old('boats.0.is_motorized', $catch->boats->first()?->is_motorized) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="boat_type_motorized">Motorized</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="boat_type_non_motorized" name="boats[0][is_non_motorized]" value="1" {{ old('boats.0.is_non_motorized', !$catch->boats->first()?->is_motorized) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="boat_type_non_motorized">Non-motorized</label>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Boat Name (F/B): <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('boats.0.boat_name') is-invalid @enderror" 
                                                       name="boats[0][boat_name]" 
                                                       value="{{ old('boats.0.boat_name', $catch->boats->first()?->name) }}" required>
                                                @error('boats.0.boat_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label fw-bold">Length (m): <span class="text-danger">*</span></label>
                                                <input type="number" step="0.01" class="form-control @error('boats.0.length') is-invalid @enderror" 
                                                       name="boats[0][length]" 
                                                       value="{{ old('boats.0.length', $catch->boats->first()?->length) }}" required>
                                                @error('boats.0.length')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label fw-bold">Width (m): <span class="text-danger">*</span></label>
                                                <input type="number" step="0.01" class="form-control @error('boats.0.width') is-invalid @enderror" 
                                                       name="boats[0][width]" 
                                                       value="{{ old('boats.0.width', $catch->boats->first()?->width) }}" required>
                                                @error('boats.0.width')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label fw-bold">Depth (m): <span class="text-danger">*</span></label>
                                                <input type="number" step="0.01" class="form-control @error('boats.0.depth') is-invalid @enderror" 
                                                       name="boats[0][depth]" 
                                                       value="{{ old('boats.0.depth', $catch->boats->first()?->depth) }}" required>
                                                @error('boats.0.depth')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label fw-bold">Gross Tonnage (GT):</label>
                                                <input type="number" step="0.01" class="form-control @error('boats.0.gross_tonnage') is-invalid @enderror" 
                                                       name="boats[0][gross_tonnage]" 
                                                       value="{{ old('boats.0.gross_tonnage', $catch->boats->first()?->gross_tonnage) }}" 
                                                       placeholder="Auto-calculated" readonly>
                                                <small class="text-muted">Auto-calculated</small>
                                                @error('boats.0.gross_tonnage')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label fw-bold">Horsepower (HP):</label>
                                                <input type="number" class="form-control @error('boats.0.horsepower') is-invalid @enderror" 
                                                       name="boats[0][horsepower]" 
                                                       value="{{ old('boats.0.horsepower', $catch->boats->first()?->horsepower) }}">
                                                @error('boats.0.horsepower')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label fw-bold">Engine Type:</label>
                                                <input type="text" class="form-control @error('boats.0.engine_type') is-invalid @enderror" 
                                                       name="boats[0][engine_type]" 
                                                       value="{{ old('boats.0.engine_type', $catch->boats->first()?->engine_type) }}">
                                                @error('boats.0.engine_type')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label fw-bold">Number of Fishermen on Board: <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control @error('boats.0.number_of_fishermen') is-invalid @enderror" 
                                                       name="boats[0][number_of_fishermen]" 
                                                       value="{{ old('boats.0.number_of_fishermen', $catch->boats->first()?->number_of_fishermen) }}" required>
                                                @error('boats.0.number_of_fishermen')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Fishing Operation Details -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">
                                    <i class="bx bx-navigation me-2"></i>Fishing Operation Details
                                </h5>
                            </div>
                            
                            <div class="col-12 mb-4">
                                <div class="card">
                                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0">Operation #1</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Fishing Gear Type: <span class="text-danger">*</span></label>
                                                <select class="form-select @error('fishing_operations.0.gear_type') is-invalid @enderror" 
                                                        name="fishing_operations[0][gear_type]" required>
                                                    <option value="" disabled selected>Select Gear Type</option>
                                                    @foreach(['Gill Net', 'Purse Seine', 'Trawl', 'Handline', 'Longline', 'Trap', 'Spear', 'Other'] as $gearType)
                                                        <option value="{{ $gearType }}" {{ old('fishing_operations.0.gear_type', $catch->fishingOperations->first()?->gear_type) == $gearType ? 'selected' : '' }}>
                                                            {{ $gearType }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('fishing_operations.0.gear_type')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Specifications:</label>
                                                <input type="text" class="form-control @error('fishing_operations.0.specifications') is-invalid @enderror" 
                                                       name="fishing_operations[0][specifications]" 
                                                       value="{{ old('fishing_operations.0.specifications', $catch->fishingOperations->first()?->specifications) }}">
                                                @error('fishing_operations.0.specifications')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label fw-bold">Number of Hooks/Hauls:</label>
                                                <input type="number" class="form-control @error('fishing_operations.0.hooks_hauls') is-invalid @enderror" 
                                                       name="fishing_operations[0][hooks_hauls]" 
                                                       value="{{ old('fishing_operations.0.hooks_hauls', $catch->fishingOperations->first()?->hooks_hauls) }}">
                                                @error('fishing_operations.0.hooks_hauls')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label fw-bold">Net/Line Length (m):</label>
                                                <input type="number" step="0.1" class="form-control @error('fishing_operations.0.net_line_length') is-invalid @enderror" 
                                                       name="fishing_operations[0][net_line_length]" 
                                                       value="{{ old('fishing_operations.0.net_line_length', $catch->fishingOperations->first()?->net_line_length) }}">
                                                @error('fishing_operations.0.net_line_length')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label fw-bold">Soaking/Fishing Time (hrs):</label>
                                                <input type="number" step="0.1" class="form-control @error('fishing_operations.0.soaking_time') is-invalid @enderror" 
                                                       name="fishing_operations[0][soaking_time]" 
                                                       value="{{ old('fishing_operations.0.soaking_time', $catch->fishingOperations->first()?->soaking_time) }}">
                                                @error('fishing_operations.0.soaking_time')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label fw-bold">Mesh Size (cm):</label>
                                                <input type="number" step="0.1" class="form-control @error('fishing_operations.0.mesh_size') is-invalid @enderror" 
                                                       name="fishing_operations[0][mesh_size]" 
                                                       value="{{ old('fishing_operations.0.mesh_size', $catch->fishingOperations->first()?->mesh_size) }}">
                                                @error('fishing_operations.0.mesh_size')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label fw-bold">Number of Days Fished: <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control @error('fishing_operations.0.days_fished') is-invalid @enderror" 
                                                       name="fishing_operations[0][days_fished]" 
                                                       value="{{ old('fishing_operations.0.days_fished', $catch->fishingOperations->first()?->days_fished) }}" required>
                                                @error('fishing_operations.0.days_fished')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label fw-bold">Fishing Location (Click on the map or enter coordinates):</label>
                                                <div id="map" style="height: 300px; width: 100%; margin-bottom: 15px;" class="mb-2">
                                                    <!-- Map will be rendered here -->
                                                    <div class="text-center py-5 bg-light">
                                                        <p>Loading map...</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Latitude</label>
                                                        <input type="number" step="0.000001" class="form-control" name="fishing_operations[0][latitude]" 
                                                               id="latitude" value="{{ old('fishing_operations.0.latitude', $catch->fishingOperations->first()?->latitude) }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Longitude</label>
                                                        <input type="number" step="0.000001" class="form-control" name="fishing_operations[0][longitude]" 
                                                               id="longitude" value="{{ old('fishing_operations.0.longitude', $catch->fishingOperations->first()?->longitude) }}">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Payao Used?</label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="fishing_operations[0][payao_used]" id="payao_yes" value="1" 
                                                           {{ old('fishing_operations.0.payao_used', $catch->fishingOperations->first()?->payao_used) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="payao_yes">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="fishing_operations[0][payao_used]" id="payao_no" value="0"
                                                           {{ !old('fishing_operations.0.payao_used', $catch->fishingOperations->first()?->payao_used) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="payao_no">No</label>
                                                </div>
                                                @error('fishing_operations.0.payao_used')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-12 mb-3">
                                                <label class="form-label fw-bold">Fishing Effort Notes:</label>
                                                <textarea class="form-control @error('fishing_operations.0.notes') is-invalid @enderror" 
                                                          name="fishing_operations[0][notes]" rows="3">{{ old('fishing_operations.0.notes', $catch->fishingOperations->first()?->notes) }}</textarea>
                                                @error('fishing_operations.0.notes')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Catch Information -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">
                                    <i class="bx bx-package me-2"></i>Catch Information
                                </h5>
                            </div>
                            
                            <div class="col-12 mb-4">
                                <div class="card">
                                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0">Catch #1</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label fw-bold">Catch Type: <span class="text-danger">*</span></label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="catch_type" id="catch_type_complete" value="Complete" 
                                                           {{ old('catch_type', $catch->catch_type) == 'Complete' ? 'checked' : '' }} required>
                                                    <label class="form-check-label" for="catch_type_complete">Complete</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="catch_type" id="catch_type_incomplete" value="Incomplete"
                                                           {{ old('catch_type', $catch->catch_type) == 'Incomplete' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="catch_type_incomplete">Incomplete</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="catch_type" id="catch_type_partly_sold" value="Partly Sold"
                                                           {{ old('catch_type', $catch->catch_type) == 'Partly Sold' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="catch_type_partly_sold">Partly Sold</label>
                                                </div>
                                                @error('catch_type')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Total Catch (kg): <span class="text-danger">*</span></label>
                                                <input type="number" step="0.01" class="form-control @error('total_catch') is-invalid @enderror" 
                                                       name="total_catch" 
                                                       value="{{ old('total_catch', $catch->total_catch) }}" required>
                                                @error('total_catch')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Sub-sample Taken? <span class="text-danger">*</span></label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="subsample_taken" id="subsample_yes" value="1" 
                                                           {{ old('subsample_taken', $catch->subsample_taken) ? 'checked' : '' }} required>
                                                    <label class="form-check-label" for="subsample_yes">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="subsample_taken" id="subsample_no" value="0"
                                                           {{ !old('subsample_taken', $catch->subsample_taken) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="subsample_no">No</label>
                                                </div>
                                                @error('subsample_taken')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Sub-sample Weight (kg):</label>
                                                <input type="number" step="0.01" class="form-control @error('subsample_weight') is-invalid @enderror" 
                                                       name="subsample_weight" 
                                                       value="{{ old('subsample_weight', $catch->subsample_weight) }}"
                                                       {{ old('subsample_taken', $catch->subsample_taken) ? '' : 'disabled' }}>
                                                @error('subsample_weight')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Were any fish below legal size? <span class="text-danger">*</span></label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="below_legal_size" id="below_legal_yes" value="1" 
                                                           {{ old('below_legal_size', $catch->below_legal_size) ? 'checked' : '' }} required>
                                                    <label class="form-check-label" for="below_legal_yes">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="below_legal_size" id="below_legal_no" value="0"
                                                           {{ !old('below_legal_size', $catch->below_legal_size) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="below_legal_no">No</label>
                                                </div>
                                                @error('below_legal_size')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-12 mb-3" id="below_legal_species_container" 
                                                 style="display: {{ old('below_legal_size', $catch->below_legal_size) ? 'block' : 'none' }};">
                                                <label class="form-label fw-bold">If Yes, which species:</label>
                                                <input type="text" class="form-control @error('below_legal_species') is-invalid @enderror" 
                                                       name="below_legal_species" 
                                                       value="{{ old('below_legal_species', $catch->below_legal_species) }}">
                                                @error('below_legal_species')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Species Recognition & Size Estimation -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">
                                    <i class="bx bx-dna me-2"></i>Species Recognition & Size Estimation
                                </h5>
                            </div>
                            
                            <div class="col-12 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Species: <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('species') is-invalid @enderror" 
                                                       name="species" 
                                                       value="{{ old('species', $catch->species) }}" required>
                                                @error('species')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Scientific Name:</label>
                                                <input type="text" class="form-control @error('scientific_name') is-invalid @enderror" 
                                                       name="scientific_name" 
                                                       value="{{ old('scientific_name', $catch->scientific_name) }}">
                                                @error('scientific_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label fw-bold">Length (cm):</label>
                                                <input type="number" step="0.1" class="form-control @error('length') is-invalid @enderror" 
                                                       name="length" 
                                                       value="{{ old('length', $catch->length) }}">
                                                @error('length')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label fw-bold">Weight (kg):</label>
                                                <input type="number" step="0.01" class="form-control @error('weight') is-invalid @enderror" 
                                                       name="weight" 
                                                       value="{{ old('weight', $catch->weight) }}">
                                                @error('weight')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label fw-bold">AI Confidence Score (%):</label>
                                                <input type="number" step="0.01" min="0" max="100" class="form-control @error('ai_confidence') is-invalid @enderror" 
                                                       name="ai_confidence" 
                                                       value="{{ old('ai_confidence', $catch->ai_confidence) }}">
                                                @error('ai_confidence')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">Species Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="species" class="form-label">Species</label>
                                    <input type="text" class="form-control @error('species') is-invalid @enderror" 
                                           id="species" name="species" value="{{ old('species', $catch->species) }}" required>
                                    @error('species')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="weight" class="form-label">Weight (kg)</label>
                                                    <input type="number" step="0.01" class="form-control @error('weight') is-invalid @enderror" 
                                                           id="weight" name="weight" value="{{ old('weight', $catch->weight) }}" required>
                                                    @error('weight')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="length" class="form-label">Length (cm)</label>
                                                    <input type="number" step="0.1" class="form-control @error('length') is-invalid @enderror" 
                                                           id="length" name="length" value="{{ old('length', $catch->length) }}" required>
                                                    @error('length')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="location" class="form-label">Location</label>
                                            <input type="text" class="form-control @error('location') is-invalid @enderror" 
                                                   id="location" name="location" value="{{ old('location', $catch->location) }}" required>
                                            @error('location')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="date_caught" class="form-label">Date Caught</label>
                                            <input type="datetime-local" class="form-control @error('date_caught') is-invalid @enderror" 
                                                   id="date_caught" name="date_caught" 
                                                   value="{{ old('date_caught', \Carbon\Carbon::parse($catch->date_caught)->format('Y-m-d\TH:i')) }}" required>
                                            @error('date_caught')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Fisherman Information -->
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">Fisherman Information</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="fisherman_registration_id" class="form-label">Fisherman Registration ID</label>
                                            <input type="text" class="form-control @error('fisherman_registration_id') is-invalid @enderror" 
                                                   id="fisherman_registration_id" name="fisherman_registration_id" 
                                                   value="{{ old('fisherman_registration_id', $catch->fisherman_registration_id) }}" required>
                                            @error('fisherman_registration_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="fisherman_name" class="form-label">Fisherman's Full Name</label>
                                            <input type="text" class="form-control @error('fisherman_name') is-invalid @enderror" 
                                                   id="fisherman_name" name="fisherman_name" 
                                                   value="{{ old('fisherman_name', $catch->fisherman_name) }}" required>
                                            @error('fisherman_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Fishing Method -->
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">Fishing Method</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="fishing_method" class="form-label">Method</label>
                                            <select class="form-select @error('fishing_method') is-invalid @enderror" 
                                                    id="fishing_method" name="fishing_method" required>
                                                <option value="net" {{ old('fishing_method', $catch->fishing_method) == 'net' ? 'selected' : '' }}>Net</option>
                                                <option value="line" {{ old('fishing_method', $catch->fishing_method) == 'line' ? 'selected' : '' }}>Line</option>
                                                <option value="trap" {{ old('fishing_method', $catch->fishing_method) == 'trap' ? 'selected' : '' }}>Trap</option>
                                                <option value="spear" {{ old('fishing_method', $catch->fishing_method) == 'spear' ? 'selected' : '' }}>Spear</option>
                                                <option value="other" {{ old('fishing_method', $catch->fishing_method) == 'other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                            @error('fishing_method')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <!-- Fish Photo with AI Analysis -->
                                <div class="card mb-4">
                                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0">Fish Photo & AI Analysis</h6>
                                        @if($catch->ai_analyzed_at)
                                            <span class="badge bg-success">AI Analyzed</span>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <!-- Current/Uploaded Image -->
                                        <div class="text-center mb-4">
                                            <div id="imagePreviewContainer" class="mb-3">
                                                @if($catch->image_path)
                                                    <img id="imagePreview" 
                                                         src="{{ Storage::exists('public/' . $catch->image_path) ? asset('storage/' . $catch->image_path) : $catch->image_path }}" 
                                                         alt="Fish Photo" 
                                                         class="img-fluid rounded shadow" 
                                                         style="max-height: 300px; display: block; margin: 0 auto;">
                                                    <p class="text-muted mt-2 mb-0">Current photo</p>
                                                @else
                                                    <div id="noImagePreview" class="bg-light p-5 text-muted rounded text-center">
                                                        <i class="bx bx-image fs-1 d-block mb-2"></i>
                                                        <span>No photo available</span>
                                                    </div>
                                                @endif
                                            </div>
                                            
                                            <!-- Upload Controls -->
                                            <div class="mb-3">
                                                <input type="file" 
                                                       class="form-control @error('image') is-invalid @enderror" 
                                                       id="image" 
                                                       name="image" 
                                                       accept="image/*" 
                                                       onchange="previewImage(this)">
                                                <div class="form-text">
                                                    {{ $catch->image_path ? 'Upload a new photo to replace the current one' : 'Upload a clear photo of the fish catch' }}
                                                </div>
                                                @error('image')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <!-- AI Analysis Button -->
                                            @if($catch->image_path)
                                                <button type="button" class="btn btn-outline-primary" id="analyzeImageBtn" onclick="analyzeImage()">
                                                    <i class="bx bx-analyse me-1"></i> Re-analyze with AI
                                                </button>
                                                <div id="aiAnalysisSpinner" class="spinner-border text-primary d-none" role="status">
                                                    <span class="visually-hidden">Analyzing...</span>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <!-- AI Analysis Results -->
                                        @if($catch->ai_analyzed_at)
                                            <div class="mt-4 border-top pt-3">
                                                <h6 class="mb-3">AI Analysis Results</h6>
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <div class="p-3 bg-light rounded">
                                                            <small class="text-muted d-block">Species</small>
                                                            <strong>{{ $catch->ai_species_detected ?? 'Not detected' }}</strong>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="p-3 bg-light rounded">
                                                            <small class="text-muted d-block">Confidence</small>
                                                            <div class="d-flex align-items-center">
                                                                <div class="progress flex-grow-1 me-2" style="height: 6px;">
                                                                    <div class="progress-bar bg-success" 
                                                                         role="progressbar" 
                                                                         style="width: {{ $catch->ai_confidence ?? 0 }}%"
                                                                         aria-valuenow="{{ $catch->ai_confidence ?? 0 }}" 
                                                                         aria-valuemin="0" 
                                                                         aria-valuemax="100">
                                                                    </div>
                                                                </div>
                                                                <small>{{ $catch->ai_confidence ?? 0 }}%</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="p-3 bg-light rounded">
                                                            <small class="text-muted d-block">Estimated Length</small>
                                                            <strong>
                                                                @if($catch->ai_estimated_length)
                                                                    {{ number_format($catch->ai_estimated_length, 1) }} cm
                                                                @else
                                                                    N/A
                                                                @endif
                                                            </strong>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="p-3 bg-light rounded">
                                                            <small class="text-muted d-block">Estimated Weight</small>
                                                            <strong>
                                                                @if($catch->ai_estimated_weight)
                                                                    {{ number_format($catch->ai_estimated_weight, 2) }} kg
                                                                @else
                                                                    N/A
                                                                @endif
                                                            </strong>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mt-2 text-muted small">
                                                    <i class="bx bx-time me-1"></i> 
                                                    Last analyzed: {{ $catch->ai_analyzed_at->diffForHumans() }}
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Notes -->
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">Additional Notes</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="notes" class="form-label">Notes</label>
                                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                                      id="notes" name="notes" rows="4">{{ old('notes', $catch->notes) }}</textarea>
                                            @error('notes')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Status -->
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">Status</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <select class="form-select @error('status') is-invalid @enderror" 
                                                    id="status" name="status" required>
                                                <option value="recorded" {{ old('status', $catch->status) == 'recorded' ? 'selected' : '' }}>Recorded</option>
                                                <option value="verified" {{ old('status', $catch->status) == 'verified' ? 'selected' : '' }}>Verified</option>
                                                <option value="pending" {{ old('status', $catch->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="rejected" {{ old('status', $catch->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="{{ route('catches.index') }}" class="btn btn-secondary me-md-2">
                                <i class="bx bx-x"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-save"></i> Update Catch Record
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Image preview function
    function previewImage(input) {
        const previewContainer = document.getElementById('imagePreviewContainer');
        const preview = document.getElementById('imagePreview');
        const noPreview = document.getElementById('noImagePreview');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                if (!preview) {
                    // Create image element if it doesn't exist
                    const img = document.createElement('img');
                    img.id = 'imagePreview';
                    img.src = e.target.result;
                    img.className = 'img-fluid rounded shadow';
                    img.style = 'max-height: 300px; display: block; margin: 0 auto;';
                    
                    if (noPreview) {
                        previewContainer.removeChild(noPreview);
                    }
                    previewContainer.appendChild(img);
                    
                    // Show analyze button if it's hidden
                    const analyzeBtn = document.getElementById('analyzeImageBtn');
                    if (analyzeBtn) {
                        analyzeBtn.classList.remove('d-none');
                    }
                } else {
                    preview.src = e.target.result;
                }
            };
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    // Form validation
    document.getElementById('catchForm').addEventListener('submit', function(e) {
        const form = e.target;
        if (!form.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
        }
        form.classList.add('was-validated');
    });
    
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Initialize any image preview if page is loaded with an image
        const imageInput = document.getElementById('image');
        if (imageInput.files.length > 0) {
            previewImage(imageInput);
        }
    });
    
    // Preview uploaded image
    function previewImage(input) {
        const previewContainer = document.getElementById('imagePreviewContainer');
        const noPreview = document.getElementById('noImagePreview');
        const preview = document.getElementById('imagePreview');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                // Hide 'no image' message if shown
                if (noPreview) noPreview.style.display = 'none';
                
                // Create or update image preview
                if (!preview) {
                    const img = document.createElement('img');
                    img.id = 'imagePreview';
                    img.className = 'img-fluid rounded shadow';
                    img.style.maxHeight = '300px';
                    img.style.display = 'block';
                    img.style.margin = '0 auto';
                    img.alt = 'Preview';
                    previewContainer.prepend(img);
                    document.getElementById('imagePreview').src = e.target.result;
                } else {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                
                // Show analyze button if it exists
                const analyzeBtn = document.getElementById('analyzeImageBtn');
                if (analyzeBtn) analyzeBtn.classList.remove('d-none');
            }
            
            reader.readAsDataURL(input.files[0]);
        } else if (preview) {
            preview.src = "";
            preview.style.display = 'none';
            if (noPreview) noPreview.style.display = 'block';
        }
    }
    
    // Analyze image with AI
    async function analyzeImage() {
        const analyzeBtn = document.getElementById('analyzeImageBtn');
        const spinner = document.getElementById('aiAnalysisSpinner');
        const formData = new FormData();
        const fileInput = document.getElementById('image');
        
        // Add CSRF token
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        
        // Add image or image path to form data
        if (fileInput.files && fileInput.files[0]) {
            formData.append('image', fileInput.files[0]);
        } else if (document.getElementById('imagePreview') && document.getElementById('imagePreview').src) {
            // If no new file is selected but there's a preview, use the existing image
            formData.append('image_path', '{{ $catch->image_path }}');
        } else {
            alert('Please upload an image first');
            return;
        }
        
        // Show loading state
        analyzeBtn.disabled = true;
        if (spinner) spinner.classList.remove('d-none');
        
        try {
            const response = await fetch('{{ route("catches.analyze", $catch->id) }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });
            
            const data = await response.json();
            
            if (!response.ok) {
                throw new Error(data.message || 'Failed to analyze image');
            }
            
            // Update the form fields with the analysis results
            if (data.data) {
                const { species, scientific_name, confidence, length, weight } = data.data;
                
                // Update species field
                const speciesInput = document.getElementById('species');
                if (speciesInput) speciesInput.value = species || '';
                
                // Update scientific name field if it exists
                const sciNameInput = document.getElementById('scientific_name');
                if (sciNameInput) sciNameInput.value = scientific_name || '';
                
                // Update confidence display
                const confidenceDisplay = document.querySelector('.ai-confidence-value');
                const confidenceBar = document.querySelector('.ai-confidence-bar');
                if (confidenceDisplay && confidenceBar) {
                    confidenceDisplay.textContent = confidence ? `${confidence}%` : 'N/A';
                    confidenceBar.style.width = `${confidence || 0}%`;
                    confidenceBar.setAttribute('aria-valuenow', confidence || 0);
                }
                
                // Update length and weight if fields exist
                const lengthInput = document.getElementById('length');
                if (lengthInput && length) lengthInput.value = length;
                
                const weightInput = document.getElementById('weight');
                if (weightInput && weight) weightInput.value = weight;
                
                // Show success message
                alert('Image analyzed successfully!');
                
                // Reload the page to show updated analysis results
                window.location.reload();
            }
            
        } catch (error) {
            console.error('Error analyzing image:', error);
            alert('Error analyzing image: ' + error.message);
        } finally {
            // Reset button state
            analyzeBtn.disabled = false;
            if (spinner) spinner.classList.add('d-none');
        }
        
        // If there's a newly uploaded file, use that, otherwise use the existing image
        if (fileInput.files.length > 0) {
            formData.append('image', fileInput.files[0]);
        } else if ('{{ $catch->image_path }}') {
            // For existing images, we'll use the image path
            formData.append('image_path', '{{ $catch->image_path }}');
        } else {
            alert('Please upload an image first');
            return;
        }
        
        try {
            // Show loading state
            analyzeBtn.disabled = true;
            spinner.classList.remove('d-none');
            
            // Call the AI analysis endpoint
            const response = await fetch('{{ route("catches.analyze", $catch->id) }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: formData
            });
            
            const data = await response.json();
            
            if (!response.ok) {
                throw new Error(data.message || 'Failed to analyze image');
            }
            
            // Update the form fields with the analysis results
            if (data.species) {
                const speciesInput = document.querySelector('input[name="species"]');
                if (speciesInput) speciesInput.value = data.species;
            }
            
            if (data.scientific_name) {
                const scientificNameInput = document.querySelector('input[name="scientific_name"]');
                if (scientificNameInput) scientificNameInput.value = data.scientific_name;
            }
            
            if (data.length) {
                const lengthInput = document.querySelector('input[name="length"]');
                if (lengthInput) lengthInput.value = parseFloat(data.length).toFixed(1);
            }
            
            if (data.weight) {
                const weightInput = document.querySelector('input[name="weight"]');
                if (weightInput) weightInput.value = parseFloat(data.weight).toFixed(2);
            }
            
            // Show success message and reload to show updated analysis
            alert('Image analyzed successfully!');
            window.location.reload();
            
        } catch (error) {
            console.error('Error analyzing image:', error);
            alert('Error analyzing image: ' + (error.message || 'Please try again later'));
        } finally {
            // Reset button state
            if (analyzeBtn) analyzeBtn.disabled = false;
            if (spinner) spinner.classList.add('d-none');
        }
    }
    
    // Toggle subsample weight field based on subsample_taken radio buttons
    document.addEventListener('DOMContentLoaded', function() {
        const subsampleYes = document.querySelector('input[name="subsample_taken"][value="1"]');
        const subsampleNo = document.querySelector('input[name="subsample_taken"][value="0"]');
        const subsampleWeightInput = document.querySelector('input[name="subsample_weight"]');
        
        function toggleSubsampleWeight() {
            if (subsampleYes && subsampleYes.checked) {
                subsampleWeightInput.disabled = false;
            } else {
                subsampleWeightInput.disabled = true;
                subsampleWeightInput.value = '';
            }
        }
        
        if (subsampleYes && subsampleNo && subsampleWeightInput) {
            subsampleYes.addEventListener('change', toggleSubsampleWeight);
            subsampleNo.addEventListener('change', toggleSubsampleWeight);
            toggleSubsampleWeight(); // Initialize on page load
        }
        
        // Toggle below legal species field
        const belowLegalYes = document.querySelector('input[name="below_legal_size"][value="1"]');
        const belowLegalNo = document.querySelector('input[name="below_legal_size"][value="0"]');
        const belowLegalContainer = document.getElementById('below_legal_species_container');
        
        function toggleBelowLegalSpecies() {
            if (belowLegalYes && belowLegalContainer) {
                belowLegalContainer.style.display = belowLegalYes.checked ? 'block' : 'none';
            }
        }
        
        if (belowLegalYes && belowLegalNo && belowLegalContainer) {
            belowLegalYes.addEventListener('change', toggleBelowLegalSpecies);
            belowLegalNo.addEventListener('change', toggleBelowLegalSpecies);
            toggleBelowLegalSpecies(); // Initialize on page load
        }
    });
</script>
@endpush
@endsection
