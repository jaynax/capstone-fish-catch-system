@extends('layouts.users.app')

@push('styles')
<!-- SweetAlert2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<!-- Leaflet Control Geocoder CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
<style>
    /* Modern Form Styles */
    .form-section {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        margin-bottom: 2rem;
        overflow: hidden;
    }

    .form-section .card-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .form-section .card-body {
        padding: 2rem;
    }

    .form-label {
        font-weight: 500;
        color: #3a3a3a;
        margin-bottom: 0.5rem;
    }

    .form-control, .form-select {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.15);
    }

    .btn-primary {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        border: none;
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(78, 115, 223, 0.25);
    }

    .btn-outline-primary {
        border: 1px solid #4e73df;
        color: #4e73df;
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-outline-primary:hover {
        background: rgba(78, 115, 223, 0.1);
    }

    /* Card Styling */
    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
    }

    /* Alert Styling */
    .alert {
        border: none;
        border-radius: 10px;
        padding: 1rem 1.5rem;
    }

    .alert-success {
        background-color: #e6f7ee;
        color: #0d6832;
    }

    .alert-danger {
        background-color: #fdecea;
        color: #d32f2f;
    }

    /* Form Group Styling */
    .form-group {
        margin-bottom: 1.5rem;
    }

    /* Custom Radio and Checkbox */
    .form-check-input:checked {
        background-color: #4e73df;
        border-color: #4e73df;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .form-section .card-body {
            padding: 1.5rem;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-10">
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bx bx-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bx bx-error-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bx bx-error-circle me-2"></i>
                    <strong>Please fix the following errors:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">
                                <i class="bx bx-clipboard me-2"></i>BFAR Fish Catch Monitoring Form
                            </h4>
                            <p class="mb-0 text-white-50">National Stock Assessment Program (NSAP)</p>
                        </div>
                        <div class="badge bg-white text-primary px-3 py-2">
                            <i class="bx bx-time me-1"></i> {{ now()->format('F j, Y') }}
                        </div>
                    </div>
                </div>
        <div class="card-body">
            <form action="{{ route('catch.store') }}" method="POST" enctype="multipart/form-data" id="catchForm" novalidate>
                @csrf
                        
                <!-- Region Selection -->
                <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="region" class="form-label fw-bold">Region: <span class="text-danger">*</span></label>
                                <select class="form-select" id="region" name="region" required>
                                    <option value="">Select Region</option>
                                    <option value="NCR">National Capital Region (NCR)</option>
                                    <option value="CAR">Cordillera Administrative Region (CAR)</option>
                                    <option value="I">Ilocos Region (Region I)</option>
                                    <option value="II">Cagayan Valley (Region II)</option>
                                    <option value="III">Central Luzon (Region III)</option>
                                    <option value="IV-A">Calabarzon (Region IV-A)</option>
                                    <option value="IV-B">Mimaropa (Region IV-B)</option>
                                    <option value="V">Bicol Region (Region V)</option>
                                    <option value="VI">Western Visayas (Region VI)</option>
                                    <option value="VII">Central Visayas (Region VII)</option>
                                    <option value="VIII">Eastern Visayas (Region VIII)</option>
                                    <option value="IX">Zamboanga Peninsula (Region IX)</option>
                                    <option value="X">Northern Mindanao (Region X)</option>
                                    <option value="XI">Davao Region (Region XI)</option>
                                    <option value="XII">Soccsksargen (Region XII)</option>
                                    <option value="XIII">Caraga (Region XIII)</option>
                                    <option value="BARMM">Bangsamoro Autonomous Region in Muslim Mindanao (BARMM)</option>
                                </select>
                            </div>
                        </div>

                        <!-- General Information -->
                        <div class="card mb-4 border-0 shadow-sm">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center border-bottom">
                                <h5 class="mb-0 text-primary"><i class="bx bx-info-circle me-2"></i>✨ GENERAL INFORMATION</h5>
                                <span class="badge bg-primary bg-opacity-10 ">Required</span>
                            </div>
                            
                            <!-- Fisherman Information -->
                            <div class="card-body">
                                <h6 class="mb-3"><i class="bx bx-id-card me-2"></i>Fisherman Information</h6>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="fisherman_registration_id" class="form-label">Fisherman Registration ID: <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="fisherman_registration_id" name="fisherman_registration_id" required>
                                        <div class="form-text">Enter the fisherman registration ID</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="fisherman_name" class="form-label">Fisherman's Full Name: <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="fisherman_name" name="fisherman_name" required>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Location Information -->
                            <div class="card-body border-top" id="generalInfoContainer">
                                <h6 class="mb-3"><i class="bx bx-map me-2"></i>Location Information</h6>
                                
                                <!-- General Entry Template (Hidden) -->
                                <div class="general-entry" style="display: none;">
                                <div class="card mb-3 border-secondary">
                                <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Location Entry <span class="entry-number">1</span></h6>
                                <button type="button" class="btn btn-sm btn-danger remove-entry">
                                <i class="bx bx-trash"></i> Remove
                                </button>
                                </div>
                                <div class="card-body">
                                <div class="row">
                                <div class="col-md-6 mb-3">
                                <label class="form-label">Landing Center: <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="landing_center">
                                </div>
                                <div class="col-md-6 mb-3">
                                <label class="form-label">Date of Sampling: <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="date_sampling">
                                </div>
                                </div>
                                </div>
                                </div>
                                </div>
                                
                                <!-- First General Entry (Visible) -->
                                <div class="general-entry">
                                    <div class="card mb-3 border-secondary">
                                        <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0">Location Entry <span class="entry-number">1</span></h6>
                                            <button type="button" class="btn btn-sm btn-danger remove-entry" style="display: none;">
                                                <i class="bx bx-trash"></i> Remove
                                            </button>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="landing_center" class="form-label">Landing Center: <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control @error('landing_center') is-invalid @enderror" id="landing_center" name="landing_center" required value="{{ old('landing_center') }}">
                                                    @error('landing_center')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="date_sampling" class="form-label">Date of Sampling: <span class="text-danger">*</span></label>
                                                    <input type="date" class="form-control @error('date_sampling') is-invalid @enderror" id="date_sampling" name="date_sampling" required value="{{ old('date_sampling') }}">
                                                    @error('date_sampling')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Static Fields -->
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="time_landing" class="form-label">Time of Landing: <span class="text-danger">*</span></label>
                                        <input type="time" class="form-control" id="time_landing" name="time_landing" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="enumerators" class="form-label">Enumerator(s): <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="enumerators" name="enumerators" value="{{ Auth::user()->name }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="fishing_ground" class="form-label">Fishing Ground: <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="fishing_ground" name="fishing_ground" required>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="weather_conditions" class="form-label">Weather Conditions: <span class="text-danger">*</span></label>
                                        <select class="form-select" id="weather_conditions" name="weather_conditions" required>
                                            <option value="">Select Weather</option>
                                            <option value="Sunny">Sunny</option>
                                            <option value="Cloudy">Cloudy</option>
                                            <option value="Rainy">Rainy</option>
                                            <option value="Stormy">Stormy</option>
                                            <option value="Calm">Calm</option>
                                            <option value="Windy">Windy</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                <!-- 🚢 BOAT INFORMATION -->
                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center border-bottom">
                        <h5 class="mb-0 text-info"><i class="bx bx-ship me-2"></i>🚢 BOAT INFORMATION</h5>
                        <button type="button" id="addBoatBtn" class="btn btn-light btn-sm">
                            <i class="bx bx-plus-circle"></i> Add Boat
                        </button>
                    </div>
                            <div class="card-body" id="boatInfoContainer">
                                <!-- Boat Info Entry Template (Hidden) -->
                                <div class="boat-entry card mb-3 border-secondary" style="display: none;">
                                    <div class="card-header py-1 bg-light d-flex justify-content-between align-items-center">
                                        <span class="fw-bold">Boat #<span class="entry-number">1</span></span>
                                        <button type="button" class="btn btn-sm btn-danger remove-boat" title="Remove this boat">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </div>
                                    
                                        
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Boat Name (F/B): <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="boats[0][boat_name]" disabled>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Boat Type: <span class="text-danger">*</span></label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="boats[0][boat_type]" value="Motorized" disabled>
                                                    <label class="form-check-label">Motorized</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="boats[0][boat_type]" value="Non-motorized" disabled>
                                                    <label class="form-check-label">Non-motorized</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Length (m): <span class="text-danger">*</span></label>
                                                <input type="number" step="0.1" class="form-control" name="boats[0][boat_length]" oninput="calculateGrossTonnage(this)" disabled>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Width (m): <span class="text-danger">*</span></label>
                                                <input type="number" step="0.1" class="form-control" name="boats[0][boat_width]" oninput="calculateGrossTonnage(this)" disabled>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Depth (m): <span class="text-danger">*</span></label>
                                                <input type="number" step="0.1" class="form-control" name="boats[0][boat_depth]" oninput="calculateGrossTonnage(this)" disabled>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Gross Tonnage (GT):</label>
                                                <input type="number" step="0.1" class="form-control" name="boats[0][gross_tonnage]" readonly disabled>
                                                <div class="form-text">Auto-calculated</div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Horsepower (HP):</label>
                                                <input type="number" class="form-control" name="boats[0][horsepower]" disabled>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Engine Type:</label>
                                                <input type="text" class="form-control" name="boats[0][engine_type]" disabled>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Number of Fishermen on Board: <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" name="boats[0][fishermen_count]" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- First Boat Entry (Visible) -->
                            <div class="boat-entry card mb-3 border-secondary">
                                <div class="card-header py-1 bg-light d-flex justify-content-between align-items-center">
                                    <span class="fw-bold">Boat #<span class="entry-number">1</span></span>
                                    <button type="button" class="btn btn-sm btn-danger remove-boat" title="Remove this boat" style="display: none;">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                    <div class="col-md-6 mb-3">
                                    <label class="form-label">Boat Type: <span class="text-danger">*</span></label>
                                    <div class="form-check">
                                    <input class="form-check-input" type="radio" name="boats[0][boat_type]" id="motorized_0" value="Motorized" required>
                                    <label class="form-check-label" for="motorized_0">Motorized</label>
                                    </div>
                                    <div class="form-check">
                                    <input class="form-check-input" type="radio" name="boats[0][boat_type]" id="non_motorized_0" value="Non-motorized" required>
                                    <label class="form-check-label" for="non_motorized_0">Non-motorized</label>
                                    </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                    <label for="boat_name_0" class="form-label">Boat Name (F/B): <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="boat_name_0" name="boats[0][boat_name]" required>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="boat_length_0" class="form-label">Length (m): <span class="text-danger">*</span></label>
                                        <input type="number" step="0.1" class="form-control boat-dimension" id="boat_length_0" name="boats[0][boat_length]" oninput="calculateGrossTonnage(this)" required>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="boat_width_0" class="form-label">Width (m): <span class="text-danger">*</span></label>
                                        <input type="number" step="0.1" class="form-control boat-dimension" id="boat_width_0" name="boats[0][boat_width]" oninput="calculateGrossTonnage(this)" required>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="boat_depth_0" class="form-label">Depth (m): <span class="text-danger">*</span></label>
                                        <input type="number" step="0.1" class="form-control boat-dimension" id="boat_depth_0" name="boats[0][boat_depth]" oninput="calculateGrossTonnage(this)" required>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="gross_tonnage_0" class="form-label">Gross Tonnage (GT):</label>
                                        <input type="number" step="0.1" class="form-control" id="gross_tonnage_0" name="boats[0][gross_tonnage]" readonly>
                                        <div class="form-text">Auto-calculated</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="horsepower_0" class="form-label">Horsepower (HP):</label>
                                        <input type="number" class="form-control" id="horsepower_0" name="boats[0][horsepower]">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="engine_type_0" class="form-label">Engine Type:</label>
                                        <input type="text" class="form-control" id="engine_type_0" name="boats[0][engine_type]">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="fishermen_count_0" class="form-label">Number of Fishermen on Board: <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="fishermen_count_0" name="boats[0][fishermen_count]" required>
                                    </div>
                                </div>
                            </div>
                            <!-- End of First Boat Entry -->
                        </div>

                <!-- 🎯 FISHING OPERATION DETAILS -->
                <div class="card mb-4 border-0 shadow-sm">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center border-bottom">
                                <h5 class="mb-0 text-success"><i class="bx bx-anchor me-2"></i>🎯 FISHING OPERATION DETAILS</h5>
                                
                            </div>
                            <div class="card-body">
                                <div id="fishingOpContainer">
                                    <!-- Fishing Operation Entry Template (Hidden) -->
                                    <div class="fishing-op-entry card mb-3 border-secondary" style="display: none;">
                                    <div class="card-header py-1 bg-light d-flex justify-content-between align-items-center">
                                        <span class="fw-bold">Operation #<span class="entry-number">1</span></span>
                                        <button type="button" class="btn btn-sm btn-danger remove-fishing-op" title="Remove this operation">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Fishing Gear Type: <span class="text-danger">*</span></label>
                                                <select class="form-select @error('fishing_ops.0.fishing_gear_type') is-invalid @enderror" name="fishing_ops[0][fishing_gear_type]" required>
                                                    @error('fishing_ops.0.fishing_gear_type')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                    <option value="">Select Gear Type</option>
                                                    <optgroup label="Net Gears">
                                                        <option value="Gill Net">Gill Net</option>
                                                        <option value="Drift Gill Net">Drift Gill Net</option>
                                                        <option value="Set Gill Net">Set Gill Net</option>
                                                        <option value="Trammel Net">Trammel Net</option>
                                                        <option value="Beach Seine">Beach Seine</option>
                                                        <option value="Purse Seine">Purse Seine</option>
                                                        <option value="Ring Net">Ring Net</option>
                                                        <option value="Danish Seine">Danish Seine</option>
                                                        <option value="Trawl">Trawl (Bottom Trawl)</option>
                                                        <option value="Midwater Trawl">Midwater Trawl</option>
                                                        <option value="Pair Trawl">Pair Trawl</option>
                                                        <option value="Baby Trawl">Baby Trawl</option>
                                                        <option value="Bagnet">Bagnet (Suro)</option>
                                                    </optgroup>
                                                    <optgroup label="Line Gears">
                                                        <option value="Handline">Handline</option>
                                                        <option value="Multiple Handline">Multiple Handline</option>
                                                        <option value="Troll Line">Troll Line</option>
                                                        <option value="Longline">Longline</option>
                                                        <option value="Bottom Set Longline">Bottom Set Longline</option>
                                                        <option value="Drift Longline">Drift Longline</option>
                                                        <option value="Pole and Line">Pole and Line</option>
                                                        <option value="Jigging">Jigging</option>
                                                    </optgroup>
                                                    <optgroup label="Trap Gears">
                                                        <option value="Fish Pot">Fish Pot</option>
                                                        <option value="Lobster Pot">Lobster Pot</option>
                                                        <option value="Crab Pot">Crab Pot</option>
                                                        <option value="Bamboo Trap">Bamboo Trap</option>
                                                        <option value="Funnel Net">Funnel Net (Bintol)</option>
                                                        <option value="Fyke Net">Fyke Net</option>
                                                    </optgroup>
                                                    <optgroup label="Other Gears">
                                                        <option value="Spear">Spear (Pana)</option>
                                                        <option value="Harpoon">Harpoon</option>
                                                        <option value="Scoop Net">Scoop Net (Sipol/Salap)</option>
                                                        <option value="Cast Net">Cast Net (Lambat)</option>
                                                        <option value="Drive-in Net">Drive-in Net (Pukot Hataw)</option>
                                                        <option value="Lift Net">Lift Net (Bintahan)</option>
                                                        <option value="Push Net">Push Net (Suro)</option>
                                                        <option value="Dive">Dive (Pangulong)</option>
                                                        <option value="Gathering">Gathering (Pulot)</option>
                                                        <option value="Other">Other (Please specify in notes)</option>
                                                    </optgroup>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Specifications:</label>
                                                <textarea class="form-control" name="fishing_ops[0][gear_specifications]" rows="2"></textarea>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Number of Hooks/Hauls:</label>
                                                <input type="number" class="form-control" name="fishing_ops[0][hooks_hauls]">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Net/Line Length (m):</label>
                                                <input type="number" step="0.1" class="form-control" name="fishing_ops[0][net_line_length]">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Soaking/Fishing Time (hrs):</label>
                                                <input type="number" step="0.1" class="form-control" name="fishing_ops[0][soaking_time]">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Mesh Size (cm):</label>
                                                <input type="number" step="0.1" class="form-control" name="fishing_ops[0][mesh_size]">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Number of Days Fished: <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" name="fishing_ops[0][days_fished]" required>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label class="form-label">Fishing Location (Click on the map or enter coordinates):</label>
                                                <div class="map-container" style="height: 300px; margin-bottom: 15px; border-radius: 5px; border: 1px solid #dee2e6;"></div>
                                                <div class="input-group mb-3">
                                                <span class="input-group-text">Latitude <span class="text-danger">*</span></span>
                                                <input type="number" step="0.000001" 
                                                    class="form-control latitude @error('fishing_ops.0.latitude') is-invalid @enderror" 
                                                    name="fishing_ops[0][latitude]" 
                                                    value="{{ old('fishing_ops.0.latitude', '12.8797') }}" 
                                                    placeholder="e.g. 12.8797" required>
                                                <span class="input-group-text">Longitude <span class="text-danger">*</span></span>
                                                <input type="number" step="0.000001" 
                                                    class="form-control longitude @error('fishing_ops.0.longitude') is-invalid @enderror" 
                                                    name="fishing_ops[0][longitude]" 
                                                    value="{{ old('fishing_ops.0.longitude', '121.7740') }}" 
                                                    placeholder="e.g. 121.7740" required>
                                                @error('fishing_ops.0.latitude')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                @error('fishing_ops.0.longitude')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                                <input type="hidden" name="fishing_ops[0][fishing_location]">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Payao Used?</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="fishing_ops[0][payao_used]" id="payao_yes_0" value="Yes">
                                                    <label class="form-check-label" for="payao_yes_0">☑ Yes</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="fishing_ops[0][payao_used]" id="payao_no_0" value="No" checked>
                                                    <label class="form-check-label" for="payao_no_0">☑ No</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Fishing Effort Notes:</label>
                                                <textarea class="form-control" name="fishing_ops[0][fishing_effort_notes]" rows="2"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- First Visible Fishing Operation Entry -->
                                <div class="fishing-op-entry card mb-3 border-secondary">
                                    <div class="card-header py-1 bg-light d-flex justify-content-between align-items-center">
                                        <span class="fw-bold">Operation #<span class="entry-number">1</span></span>
                                        <button type="button" class="btn btn-sm btn-danger remove-fishing-op" title="Remove this operation" style="display: none;">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </div>
                                    <div class="card-body">
                                    
                                     
                                        
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Fishing Gear Type: <span class="text-danger">*</span></label>
                                                <select class="form-select @error('fishing_ops.0.fishing_gear_type') is-invalid @enderror" name="fishing_ops[0][fishing_gear_type]" required>
                                                    @error('fishing_ops.0.fishing_gear_type')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                    <option value="">Select Gear Type</option>
                                                    <optgroup label="Net Gears">
                                                        <option value="Gill Net">Gill Net</option>
                                                        <option value="Drift Gill Net">Drift Gill Net</option>
                                                        <option value="Set Gill Net">Set Gill Net</option>
                                                        <option value="Trammel Net">Trammel Net</option>
                                                        <option value="Beach Seine">Beach Seine</option>
                                                        <option value="Purse Seine">Purse Seine</option>
                                                        <option value="Ring Net">Ring Net</option>
                                                        <option value="Danish Seine">Danish Seine</option>
                                                        <option value="Trawl">Trawl (Bottom Trawl)</option>
                                                        <option value="Midwater Trawl">Midwater Trawl</option>
                                                        <option value="Pair Trawl">Pair Trawl</option>
                                                        <option value="Baby Trawl">Baby Trawl</option>
                                                        <option value="Bagnet">Bagnet (Suro)</option>
                                                    </optgroup>
                                                    <optgroup label="Line Gears">
                                                        <option value="Handline">Handline</option>
                                                        <option value="Multiple Handline">Multiple Handline</option>
                                                        <option value="Troll Line">Troll Line</option>
                                                        <option value="Longline">Longline</option>
                                                        <option value="Bottom Set Longline">Bottom Set Longline</option>
                                                        <option value="Drift Longline">Drift Longline</option>
                                                        <option value="Pole and Line">Pole and Line</option>
                                                        <option value="Jigging">Jigging</option>
                                                    </optgroup>
                                                    <optgroup label="Trap Gears">
                                                        <option value="Fish Pot">Fish Pot</option>
                                                        <option value="Lobster Pot">Lobster Pot</option>
                                                        <option value="Crab Pot">Crab Pot</option>
                                                        <option value="Bamboo Trap">Bamboo Trap</option>
                                                        <option value="Funnel Net">Funnel Net (Bintol)</option>
                                                        <option value="Fyke Net">Fyke Net</option>
                                                    </optgroup>
                                                    <optgroup label="Other Gears">
                                                        <option value="Spear">Spear (Pana)</option>
                                                        <option value="Harpoon">Harpoon</option>
                                                        <option value="Scoop Net">Scoop Net (Sipol/Salap)</option>
                                                        <option value="Cast Net">Cast Net (Lambat)</option>
                                                        <option value="Drive-in Net">Drive-in Net (Pukot Hataw)</option>
                                                        <option value="Lift Net">Lift Net (Bintahan)</option>
                                                        <option value="Push Net">Push Net (Suro)</option>
                                                        <option value="Dive">Dive (Pangulong)</option>
                                                        <option value="Gathering">Gathering (Pulot)</option>
                                                        <option value="Other">Other (Please specify in notes)</option>
                                                    </optgroup>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Specifications:</label>
                                                <textarea class="form-control" name="fishing_ops[0][gear_specifications]" rows="2"></textarea>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Number of Hooks/Hauls:</label>
                                                <input type="number" class="form-control" name="fishing_ops[0][hooks_hauls]">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Net/Line Length (m):</label>
                                                <input type="number" step="0.1" class="form-control" name="fishing_ops[0][net_line_length]">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Soaking/Fishing Time (hrs):</label>
                                                <input type="number" step="0.1" class="form-control" name="fishing_ops[0][soaking_time]">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Mesh Size (cm):</label>
                                                <input type="number" step="0.1" class="form-control" name="fishing_ops[0][mesh_size]">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Number of Days Fished: <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" name="fishing_ops[0][days_fished]" required>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label class="form-label">Fishing Location: <span class="text-danger">*</span></label>
                                                <div class="position-relative mb-3" style="height: 400px; border: 1px solid #dee2e6; border-radius: 5px; overflow: hidden;">
                                                    <!-- Search Box -->
                                                    <div class="position-absolute top-0 start-0 w-100 p-2" style="z-index: 1000;">
                                                        <div class="input-group shadow-sm" style="max-width: 500px; margin: 0 auto;">
                                                            <input type="text" class="form-control border-end-0" placeholder="Search location..." id="fishing-location-search">
                                                            <button class="btn btn-primary" type="button" id="search-location-btn">
                                                                <i class="bx bx-search"></i> Search
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <!-- Map Container -->
                                                    <div id="fishing-location-map" style="height: 100%; width: 100%;"></div>
                                                </div>
                                                <div class="text-muted small mb-2">Click on the map or search to set the location</div>
                                                
                                                <!-- Coordinates Inputs -->
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="input-group">
                                                            <span class="input-group-text">Latitude <span class="text-danger">*</span></span>
                                                            <input type="number" step="0.000001" 
                                                                class="form-control latitude @error('fishing_ops.0.latitude') is-invalid @enderror" 
                                                                name="fishing_ops[0][latitude]" 
                                                                id="latitude"
                                                                value="{{ old('fishing_ops.0.latitude', '12.8797') }}" 
                                                                placeholder="e.g. 12.8797" required>
                                                            <span class="input-group-text">Longitude <span class="text-danger">*</span></span>
                                                            <input type="number" step="0.000001" 
                                                                class="form-control longitude @error('fishing_ops.0.longitude') is-invalid @enderror" 
                                                                name="fishing_ops[0][longitude]"
                                                                id="longitude"
                                                                value="{{ old('fishing_ops.0.longitude', '121.7740') }}" 
                                                                placeholder="e.g. 121.7740" required>
                                                            @error('fishing_ops.0.latitude')
                                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                            @enderror
                                                            @error('fishing_ops.0.longitude')
                                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="fishing_ops[0][fishing_location]" id="fishing_location">
                                            </div>                                       
                                        <input type="hidden" id="fishing_location" name="fishing_location">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Payao Used?</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="payao_used" id="payao_yes" value="Yes">
                                            <label class="form-check-label" for="payao_yes">Yes</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="payao_used" id="payao_no" value="No">
                                            <label class="form-check-label" for="payao_no">No</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="fishing_effort_notes" class="form-label">Fishing Effort Notes:</label>
                                        <textarea class="form-control" id="fishing_effort_notes" name="fishing_effort_notes" rows="2"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                                           

                <!-- ⚖️ CATCH INFORMATION -->
                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center border-bottom">
                        <h5 class="mb-0 text-warning"><i class="bx bx-weight me-2"></i>⚖️ CATCH INFORMATION</h5>
                        <button type="button" id="addCatchBtn" class="btn btn-light btn-sm">
                            <i class="bx bx-plus-circle"></i> Add Catch
                        </button>
                    </div>
                            <div class="card-body" id="catchInfoContainer">
                                <!-- Catch Information Entry Template (Hidden) -->
                                <div class="catch-entry card mb-3 border-secondary" style="display: none;">
                                    <div class="card-header py-1 bg-light d-flex justify-content-between align-items-center">
                                        <span class="fw-bold">Catch #<span class="catch-number">1</span></span>
                                        <button type="button" class="btn btn-sm btn-danger remove-catch" title="Remove this catch">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Catch Type: <span class="text-danger">*</span></label>
                                                @error('catch_type')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                                <div class="form-check">
                                                    <input class="form-check-input @error('catch_type') is-invalid @enderror" type="radio" name="catch_type" value="Complete" {{ old('catch_type') == 'Complete' ? 'checked' : '' }} required>
                                                    <label class="form-check-label">Complete</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input @error('catch_type') is-invalid @enderror" type="radio" name="catch_type" value="Incomplete" {{ old('catch_type') == 'Incomplete' ? 'checked' : '' }} required>
                                                    <label class="form-check-label">Incomplete</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input @error('catch_type') is-invalid @enderror" type="radio" name="catch_type" value="Partly Sold" {{ old('catch_type') == 'Partly Sold' ? 'checked' : '' }} required>
                                                    <label class="form-check-label">Partly Sold</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Total Catch (kg): <span class="text-danger">*</span></label>
                                                <input type="number" step="0.1" class="form-control @error('total_catch_kg') is-invalid @enderror" name="total_catch_kg" value="{{ old('catches.0.total_catch_kg') }}" required>
                                                @error('catches.0.total_catch_kg')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Sub-sample Taken?</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="subsample_taken" value="Yes">
                                                    <label class="form-check-label">Yes</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="subsample_taken" value="No">
                                                    <label class="form-check-label">No</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Sub-sample Weight (kg):</label>
                                                <input type="number" step="0.1" class="form-control" name="subsample_weight">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Were any fish below legal size?</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="below_legal_size" value="Yes">
                                                    <label class="form-check-label">Yes</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="below_legal_size" value="No">
                                                    <label class="form-check-label">No</label>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">If Yes, which species:</label>
                                                <input type="text" class="form-control" name="below_legal_species">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- First Visible Catch Entry -->
                                <div class="catch-entry card mb-3 border-secondary">
                                    <div class="card-header py-1 bg-light d-flex justify-content-between align-items-center">
                                        <span class="fw-bold">Catch #<span class="catch-number">1</span></span>
                                        <button type="button" class="btn btn-sm btn-danger remove-catch" title="Remove this catch" style="display: none;">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Catch Type: <span class="text-danger">*</span></label>
                                                <div class="form-check">
                                                    <input class="form-check-input @error('catch_type') is-invalid @enderror" type="radio" name="catch_type" value="Complete" {{ old('catch_type') == 'Complete' ? 'checked' : '' }} required>
                                                    <label class="form-check-label">Complete</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input @error('catch_type') is-invalid @enderror" type="radio" name="catch_type" value="Incomplete" {{ old('catch_type') == 'Incomplete' ? 'checked' : '' }}>
                                                    <label class="form-check-label">Incomplete</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input @error('catch_type') is-invalid @enderror" type="radio" name="catch_type" value="Partly Sold" {{ old('catch_type') == 'Partly Sold' ? 'checked' : '' }}>
                                                    <label class="form-check-label">Partly Sold</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Total Catch (kg): <span class="text-danger">*</span></label>
                                                <input type="number" step="0.1" class="form-control @error('catches.0.total_catch_kg') is-invalid @enderror" name="total_catch_kg" required value="{{ old('catches.0.total_catch_kg') }}">
                                                @error('catches.0.total_catch_kg')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 mb-3">

                                                <label class="form-label">Sub-sample Taken?</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="subsample_taken" value="Yes">
                                                    <label class="form-check-label">Yes</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="subsample_taken" value="No">
                                                    <label class="form-check-label">No</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Sub-sample Weight (kg):</label>
                                                <input type="number" step="0.1" class="form-control" name="subsample_weight">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Were any fish below legal size?</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="below_legal_size" value="Yes">
                                                    <label class="form-check-label">Yes</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="below_legal_size" value="No">
                                                    <label class="form-check-label">No</label>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">If Yes, which species:</label>
                                                <input type="text" class="form-control" name="below_legal_species">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 📏 LENGTH FREQUENCY MEASUREMENT -->
                        
                                </div> <!-- End fishingOpContainer -->
                            </div> <!-- End card-body -->
                        </div> <!-- End fishing operation card -->

                        <!-- AI Species Recognition Section -->
                        <div class="card mb-4 border-0 shadow-sm">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center border-bottom">
                                <h5 class="mb-0 text-danger"><i class="bx bx-brain me-2"></i> SPECIES RECOGNITION & SIZE ESTIMATION</h5>
                                <button type="button" id="addSpeciesBtn" class="btn btn-light btn-sm">
                                    <i class="bx bx-plus-circle"></i> Add Species
                                </button>
                            </div>
                            <div class="card-body">
                                <!-- AI Models Information -->
                                <div class="alert alert-info mb-4">
                                    <h6 class="alert-heading"><i class="bx bx-chip me-2"></i>ML Models Used:</h6>
                                    <ul class="mb-0">
                                        <li><strong>Species Recognition:</strong> CNN + MobileNetV2 (TensorFlow/Keras)</li>
                                        <li><strong>Object Detection:</strong> YOLOv8 (Ultralytics)</li>
                                        <li><strong>Size Estimation:</strong> OpenCV + Computer Vision</li>
                                        <li><strong>Image Processing:</strong> Fish detection, cropping, and measurement</li>
                                    </ul>
                                </div>

                                <!-- Fish Image Upload and Preview for AI Recognition -->


                                <!-- Mode Toggle -->
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <div class="card border-secondary">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <h6 class="mb-1"><i class="bx bx-cog me-2"></i>Processing Mode</h6>
                                                        <small class="text-muted">Choose between automatic AI processing or manual input</small>
                                                    </div>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" id="autoModeToggle" checked>
                                                        <label class="form-check-label" for="autoModeToggle">
                                                            <span id="modeLabel">Automatic AI Processing</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="image" class="form-label">Fish Photo: <span class="text-danger" id="imageRequired">*</span></label>
                                        <div class="input-group">
                                            <input type="file" class="form-control" id="image" name="image" accept="image/jpeg,image/png,image/jpg,image/gif">
                                            <button type="button" class="btn btn-primary" id="cameraBtn">
                                                <i class="bx bx-camera me-1"></i>Open Camera
                                            </button>
                                        </div>
                                        <div class="form-text">Upload clear photos or take a photo using your camera for AI species recognition and size estimation</div>
                                        
                                        <!-- Preview Wrapper -->
                                        <div id="imagePreview" class="mt-3" style="display: none;">
                                            <div id="previewWrapper" class="text-center" style="min-height: 200px; display: flex; justify-content: center; align-items: center; border: 2px dashed #dee2e6; border-radius: 0.5rem; padding: 1rem;">
                                                <img id="preview" src="#" alt="Preview" class="img-fluid" style="max-height: 300px; max-width: 100%; object-fit: contain; display: none;">
                                            </div>
                                            <div class="mt-2 text-center">
                                                <button type="button" class="btn btn-sm btn-danger" onclick="clearImage()">
                                                    <i class="bx bx-trash me-1"></i> Remove Image
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Camera Preview Section -->
                                    <div class="col-md-6 mb-3">
                                        <div id="cameraContainer" class="d-none">
                                            <div class="card">
                                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                                    <span>Camera Preview</span>
                                                    <button type="button" class="btn-close" id="closeCameraBtn" aria-label="Close"></button>
                                                </div>
                                                <div class="card-body p-0">
                                                    <div class="position-relative" style="height: 300px; background: #000; overflow: hidden; display: flex; justify-content: center; align-items: center;">
                                                        <video id="video" autoplay playsinline style="max-height: 100%; max-width: 100%; object-fit: contain;"></video>
                                                        <canvas id="canvas" class="d-none"></canvas>
                                                        <div id="cameraPreview" class="position-absolute w-100 h-100 d-none" style="top: 0; left: 0;">
                                                            <img id="cameraImage" alt="Captured photo" class="h-100 w-100" style="object-fit: contain;">
                                                        </div>
                                                    </div>
                                                    <div class="card-footer bg-white">
                                                        <div class="d-flex gap-2 justify-content-center flex-wrap">
                                                            <button type="button" class="btn btn-primary" id="captureBtn">
                                                                <i class="bx bx-camera me-1"></i>Capture
                                                            </button>
                                                            <button type="button" class="btn btn-outline-secondary" id="switchCameraBtn">
                                                                <i class="bx bx-refresh me-1"></i>Switch Camera
                                                            </button>
                                                            <button type="button" class="btn btn-outline-danger d-none" id="retakeBtn">
                                                                <i class="bx bx-reset me-1"></i>Retake
                                                            </button>
                                                            <button type="button" class="btn btn-success d-none" id="usePhotoBtn">
                                                                <i class="bx bx-check me-1"></i>Use Photo
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Processing Status -->
                                        <div id="processingStatus" class="alert alert-warning mt-3" style="display: none;">
                                            <div class="d-flex align-items-center">
                                                <div class="spinner-border spinner-border-sm me-2" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                                <span id="statusText">Processing image with AI models...</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                
                                <!-- AI Prediction Results -->
                                <div class="row mt-3">
                                    <div class="col-md-4 mb-3">
                                        <label for="species" class="form-label">Species: <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="species" name="species" required>
                                        <div class="form-text">Auto-detected from image</div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="scientific_name" class="form-label">Scientific Name: <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="scientific_name" name="scientific_name" required>
                                        <div class="form-text">Auto-detected from image</div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="length_cm" class="form-label">Length (cm) <span class="text-danger">*</span></label>
                                        <input type="number" step="0.1" class="form-control" id="length_cm" name="length_cm" required>
                                        <div class="form-text">Auto-estimated using YOLOv8 detection + OpenCV measurement</div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="weight_g" class="form-label">Weight (g) - Estimated: <span class="text-danger">*</span></label>
                                        <input type="number" step="0.1" class="form-control" id="weight_g" name="weight_g" required>
                                        <div class="form-text">Calculated from length using fish weight formulas</div>
                                    </div>
                                </div>

                                <!-- AI Processing Details -->
                                

                                <!-- Size Estimation Details -->
                               

                                <!-- AI Processing Status -->
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <div id="processingStatus" class="alert alert-warning" style="display: none;">
                                            <i class="bx bx-loader-alt bx-spin me-2"></i>
                                            <span id="statusText">Processing image with AI models...</span>
                                        </div>
                                        <div id="processingComplete" class="alert alert-success" style="display: none;">
                                            <i class="bx bx-check-circle me-2"></i>
                                            <span>AI analysis complete! Species and size estimated.</span>
                                        </div>
                                        <div id="processingError" class="alert alert-danger" style="display: none;">
                                            <i class="bx bx-error-circle me-2"></i>
                                            <span id="errorText">Error processing image. Please check your connection and try again.</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Validation Error Container -->
                        <div id="formErrors" class="alert alert-danger d-none mb-4">
                            <i class="bx bx-error-circle me-2"></i>
                            <span id="errorMessage">Please fill in all required fields.</span>
                        </div>

                        <!-- Submit Button -->
                        <div class="text-center">
                            <div class="d-flex justify-content-end gap-3 pt-4 border-top">
                            <button type="button" class="btn btn-outline-secondary">
                                <i class="bx bx-save me-2"></i>Save Draft
                            </button>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bx bx-check-circle me-2"></i>Submit Form
                            </button>
                        </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Load Leaflet CSS from CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.min.css" 
    crossorigin="anonymous"
    onerror="console.error('Failed to load Leaflet CSS')">

<!-- Load Leaflet JS from CDN -->
<script src="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.min.js" 
    crossorigin="anonymous"
    onerror="console.error('Failed to load Leaflet JS')"></script>

<!-- Load Leaflet Control Geocoder CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" 
    onerror="console.error('Failed to load Geocoder CSS'); this.remove();" />

<!-- Load Leaflet Control Geocoder JS -->
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"
    onerror="console.error('Failed to load Geocoder JS'); this.remove();"></script>

<!-- Include the fish identification script -->
<script src="{{ asset('js/fish-identification.js') }}" onerror="console.error('Failed to load fish identification script')"></script>

<!-- Initialize global L object -->
<script>
// Ensure L is available globally for Leaflet
window.L = window.L || {};
console.log('Leaflet version:', L.version);
</script>

<script>
// Ensure hidden templates do not have required fields that trigger native validation
(function () {
    document.addEventListener('DOMContentLoaded', function() {
        // Disable and strip required from inputs inside display:none templates so they are ignored
        document.querySelectorAll('[style*="display: none"] input, [style*="display: none"] select, [style*="display: none"] textarea').forEach(function(el){
            if (el.hasAttribute('required')) el.removeAttribute('required');
            el.disabled = true;
        });
    });
})();

// Function to check if element is visible and enabled
function isVisibleAndEnabled(element) {
    if (!element) return false;
    if (element.offsetParent === null) return false;
    if (window.getComputedStyle(element).display === 'none') return false;
    if (window.getComputedStyle(element).visibility === 'hidden') return false;
    if (element.disabled) return false;
    
    // Check if any parent is hidden
    let parent = element.parentElement;
    while (parent && parent !== document.body) {
        const style = window.getComputedStyle(parent);
        if (style.display === 'none' || style.visibility === 'hidden') {
            return false;
        }
        parent = parent.parentElement;
    }
    
    return true;
}

// Form validation function
function validateForm(formElement) {
    const form = formElement || document.getElementById('catchForm');
    if (!form) return false;
    
    // Prevent default HTML5 validation
    form.setAttribute('novalidate', '');
    
    // Clear previous errors
    const errorElements = form.querySelectorAll('.is-invalid');
    errorElements.forEach(el => el.classList.remove('is-invalid'));
    
    // Step 1: Handle hidden required fields before validation
    const allRequiredFields = Array.from(form.querySelectorAll('[required]'));
    const hiddenRequiredFields = [];
    
    // Store and remove required attribute from hidden fields
    allRequiredFields.forEach(field => {
        if (!isVisibleAndEnabled(field)) {
            field.setAttribute('data-was-required', 'true');
            field.removeAttribute('required');
            hiddenRequiredFields.push(field);
        }
    });
    
    // Step 2: Validate only visible fields
    const visibleRequiredFields = allRequiredFields.filter(field => isVisibleAndEnabled(field));
    const invalidFields = [];
    let isValid = true;
    
    visibleRequiredFields.forEach(field => {
        let isFieldValid = true;
        const fieldType = field.type ? field.type.toLowerCase() : 'text';
        const fieldValue = field.value;
        
        // Handle different field types
        if (fieldType === 'checkbox') {
            isFieldValid = field.checked;
        } else if (fieldType === 'radio') {
            const radioGroup = form.querySelectorAll(`input[type="radio"][name="${field.name}"]`);
            isFieldValid = Array.from(radioGroup).some(radio => radio.checked && isVisibleAndEnabled(radio));
        } else if (fieldType === 'select-one' || fieldType === 'select-multiple') {
            isFieldValid = field.selectedIndex !== -1 && field.value !== '';
        } else {
            // For text, number, date, etc.
            isFieldValid = fieldValue !== null && fieldValue.toString().trim() !== '';
        }
        
        if (!isFieldValid) {
            field.classList.add('is-invalid');
            invalidFields.push(field);
            isValid = false;
        }
    });
    
    // Step 3: Restore required attributes to hidden fields
    hiddenRequiredFields.forEach(field => {
        if (field.getAttribute('data-was-required') === 'true') {
            field.setAttribute('required', '');
            field.removeAttribute('data-was-required');
        }
    });
    
    // Show error message if validation fails
    const errorContainer = document.getElementById('formErrors');
    if (errorContainer) {
        if (!isValid) {
            errorContainer.classList.remove('d-none');
            errorContainer.innerHTML = '<i class="bx bx-error-circle me-2"></i> Please fill in all required fields.';
            
            // Scroll to first invalid field
            if (invalidFields.length > 0) {
                invalidFields[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
                invalidFields[0].focus();
            }
        } else {
            errorContainer.classList.add('d-none');
        }
    }
    
    return isValid;
}

// Add event listener for form submission
document.addEventListener('DOMContentLoaded', function() {
    try {
        const form = document.getElementById('catchForm');
        if (!form) {
            console.error('Form element not found');
            return;
        }
        
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            e.stopPropagation();
            if (!validateForm(this)) {
                return;
            }
            await submitCatchFormAjax(this);
        }, false);
        
        // Add input event listeners to clear error state when user starts typing
        form.querySelectorAll('input, select, textarea').forEach(field => {
            field.addEventListener('input', function() {
                if (this.classList.contains('is-invalid')) {
                    this.classList.remove('is-invalid');
                }
            });
            
            // For select elements, also clear on change
            if (field.tagName === 'SELECT') {
                field.addEventListener('change', function() {
                    if (this.classList.contains('is-invalid')) {
                        this.classList.remove('is-invalid');
                    }
                });
            }
        });
    }
});

// Helper function to mark a field as invalid
function markFieldAsInvalid(field, index) {
    field.classList.add('is-invalid');
    
    // For radio buttons, find the first one in the group and mark all as invalid
    if (field.type === 'radio') {
        const radioGroup = document.querySelectorAll(`input[name="${field.name}"]`);
        if (radioGroup.length > 0) {
            radioGroup[0].classList.add('is-invalid');
        }
    }
    
    // Scroll to the field if it's the first error
    if (index === 0) {
        field.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
}

// Initialize error message element
const errorMessage = document.getElementById('errorMessage');
    
    // Reset error state
    errorContainer.classList.add('d-none');
    
    // Check required fields
    const requiredFields = form.querySelectorAll('[required]');
    const emptyRequiredFields = [];
    
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            // Skip hidden fields that might be required but not visible
            if (field.offsetParent !== null) {
                emptyRequiredFields.push(field);
                isValid = false;
                
                // Add error class to the field
                field.classList.add('is-invalid');
                
                // Add event listener to remove error class when field is filled
                field.addEventListener('input', function() {
                    if (this.value.trim()) {
                        this.classList.remove('is-invalid');
                    }
                });
                
                // Get field label for error message
                let fieldName = field.name || field.id || 'Field';
                const label = field.labels && field.labels[0] ? field.labels[0].textContent : fieldName;
                
                // Clean up label text (remove asterisks and trim)
                fieldName = label.replace(/\*+$/, '').trim();
                
                if (!errorMessages.some(msg => msg.includes(fieldName))) {
                    errorMessages.push(fieldName);
                }
            }
        } else {
            field.classList.remove('is-invalid');
        }
    });
    
    // If there are validation errors
    if (!isValid) {
        // Show error message
        if (errorMessages.length > 0) {
            errorMessage.textContent = `Please fill in the following required fields: ${errorMessages.join(', ')}`;
        } else {
            errorMessage.textContent = 'Please fill in all required fields.';
        }
        errorContainer.classList.remove('d-none');
        
        // Scroll to first error
        if (emptyRequiredFields.length > 0) {
            emptyRequiredFields[0].focus();
            emptyRequiredFields[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }
    
    return isValid;
}

// Add CSS for error states
const style = document.createElement('style');
style.textContent = `
    .is-invalid {
        border-color: #dc3545 !important;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e") !important;
        background-repeat: no-repeat !important;
        background-position: right calc(0.375em + 0.1875rem) center !important;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem) !important;
    }
    .is-invalid:focus {
        border-color: #dc3545 !important;
        box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25) !important;
    }
`;
document.head.appendChild(style);

// Camera functionality
document.addEventListener('DOMContentLoaded', function() {
    // DOM Elements
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const captureBtn = document.getElementById('captureBtn');
    const switchCameraBtn = document.getElementById('switchCameraBtn');
    const usePhotoBtn = document.getElementById('usePhotoBtn');
    const cameraPreview = document.getElementById('cameraPreview');
    const fileInput = document.getElementById('image');
    const cameraBtn = document.getElementById('cameraBtn');
    const cameraContainer = document.getElementById('cameraContainer');
    
    // Camera state
    let currentFacingMode = 'environment'; // Start with back camera
    let stream = null;
    
    // Check if all required elements exist
    if (!video || !canvas || !cameraBtn) {
        console.error('Required camera elements are missing');
        return;
    }
    
    // Debug: Log all elements
    console.log('Camera Elements:', {
        video, canvas, captureBtn, retakeBtn, usePhotoBtn,
        cameraPreview, fileInput, cameraModal, cameraBtn
    });
    
    // Check for required elements
    if (!video || !canvas || !cameraModal) {
        const missing = [];
        if (!video) missing.push('video');
        if (!canvas) missing.push('canvas');
        if (!cameraModal) missing.push('cameraModal');
        console.error('Missing required elements:', missing.join(', '));
        return;
    }
    
    // State
    let stream = null;
    let isCaptured = false;

    // Toggle camera visibility
    // Function to properly stop the camera
    function stopCamera() {
        console.log('Stopping camera...');
        if (stream) {
            // Stop all tracks in the stream
            stream.getTracks().forEach(track => {
                track.stop();
                console.log('Stopped track:', track.kind);
            });
            stream = null;
        }
        
        // Reset video element
        if (video) {
            video.pause();
            video.srcObject = null;
            video.style.display = 'block';
        }
        
        // Reset canvas
        if (canvas) {
            const context = canvas.getContext('2d');
            context.clearRect(0, 0, canvas.width, canvas.height);
        }
        
        // Reset preview
        const cameraPreview = document.getElementById('cameraPreview');
        const capturedPreviewContainer = document.getElementById('capturedPreviewContainer');
        if (cameraPreview) cameraPreview.src = '#';
        if (capturedPreviewContainer) capturedPreviewContainer.style.display = 'none';
        
        // Reset UI
        if (usePhotoBtn) usePhotoBtn.classList.add('d-none');
        if (captureBtn) captureBtn.classList.remove('d-none');
    }
    
    // Toggle camera visibility
    function toggleCamera(show) {
        if (show) {
            cameraContainer.classList.remove('d-none');
            startCamera().catch(error => {
                console.error('Error starting camera:', error);
                showError('Failed to access camera. Please make sure camera permissions are granted.');
                cameraContainer.classList.add('d-none');
            });
        } else {
            stopCamera();
        }
    }
    
    // Show error message
    function showError(message) {
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-danger mt-3';
        alertDiv.innerHTML = `
            <i class="bx bx-error me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        const container = cameraContainer.parentElement;
        container.insertBefore(alertDiv, cameraContainer);
        
        // Auto-remove after 5 seconds
        setTimeout(() => {
            alertDiv.remove();
        }, 5000);
    }
    
    // Start camera function with detailed error handling
    async function startCamera() {
        console.log('Starting camera...');
        try {
            // Stop any existing stream
            if (stream) {
                console.log('Stopping existing stream');
                stopCamera();
            }
            
            // Log available devices
            const devices = await navigator.mediaDevices.enumerateDevices();
            console.log('Available devices:', devices);
            
            // Try to get user media with different constraints
            const constraints = {
                video: {
                    facingMode: 'environment', // Try back camera first
                    width: { ideal: 1280 },
                    height: { ideal: 720 }
                },
                audio: false
            };
            
            console.log('Requesting camera with constraints:', constraints);
            
            // Request camera access
            stream = await navigator.mediaDevices.getUserMedia(constraints);
            console.log('Got media stream:', stream);
            
            // Set video source
            video.srcObject = stream;
            
            // Wait for video to be ready
            await new Promise((resolve, reject) => {
                video.onloadedmetadata = () => {
                    video.play();
                    resolve();
                };
                video.onerror = (error) => {
                    console.error('Error loading video:', error);
                    reject(new Error('Failed to load video stream'));
                };
            });
                video.onloadedmetadata = () => {
                    console.log('Video metadata loaded, playing...');
                    video.play()
                        .then(() => {
                            console.log('Video is playing');
                            resolve();
                        })
                        .catch(reject);
                };
                video.onerror = reject;
                
                // Set timeout in case onloadedmetadata doesn't fire
                setTimeout(() => {
                    if (video.readyState >= 2) { // HAVE_CURRENT_DATA
                        video.play().then(resolve).catch(reject);
                    }
                }, 1000);
            });
            
            // Show video and hide canvas
            video.classList.remove('d-none');
            canvas.classList.add('d-none');
            
            // Update UI state
            if (captureBtn) captureBtn.classList.remove('d-none');
            if (usePhotoBtn) usePhotoBtn.classList.add('d-none');
            
            isCaptured = false;
            
        } catch (err) {
            console.error('Camera error:', err);
            
            let errorMessage = 'Camera error: ';
            if (err.name === 'NotAllowedError') {
                errorMessage = 'Please allow camera access in your browser settings.';
            } else if (err.name === 'NotFoundError') {
                errorMessage = 'No camera found on this device.';
            } else if (err.name === 'NotReadableError') {
                errorMessage = 'Camera is already in use by another application.';
            } else {
                errorMessage += err.message || 'Unknown error';
            }
            
            showError(errorMessage);
            
            // Try fallback to user-facing camera
            if (err.name === 'OverconstrainedError' || err.name === 'NotFoundError') {
                console.log('Trying fallback to user-facing camera...');
                try {
                    const fallbackStream = await navigator.mediaDevices.getUserMedia({
                        video: { facingMode: 'user' },
                        audio: false
                    });
                    stream = fallbackStream;
                    video.srcObject = stream;
                    await video.play();
                    video.classList.remove('d-none');
                    return true; // Success
                } catch (fallbackErr) {
                    console.error('Fallback camera failed:', fallbackErr);
                    // Close modal if we can't access camera
                    const modal = bootstrap && bootstrap.Modal ? bootstrap.Modal.getInstance(cameraModal) : null;
                    if (modal) {
                        modal.hide();
                    }
                    return false; // Indicate failure
                }
        }
    }

    // Stop camera function
    function stopCamera() {
        if (stream) {
            stream.getTracks().forEach(track => {
                track.stop();
            });
            stream = null;
        }
        
        if (video.srcObject) {
            video.srcObject = null;
        }
    }

    // Capture photo function
    function capturePhoto() {
        try {
            if (!stream || !video.videoWidth) {
                throw new Error('Camera not ready');
            }
            
            // Set canvas dimensions to match video
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            
            // Draw current video frame to canvas
            const context = canvas.getContext('2d');
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            
            // Show the captured image and hide the video
            video.style.display = 'none';
            
            // Show the use photo button and hide capture button
            captureBtn.classList.add('d-none');
            usePhotoBtn.classList.remove('d-none');
            
            // Set the preview image source and show it
            const imageDataUrl = canvas.toDataURL('image/jpeg');
            const cameraPreview = document.getElementById('cameraPreview');
            const capturedPreviewContainer = document.getElementById('capturedPreviewContainer');
            
            cameraPreview.src = imageDataUrl;
            capturedPreviewContainer.style.display = 'block';
            
            console.log('Photo captured successfully');
            
        } catch (error) {
            console.error('Error capturing photo:', error);
            showError('Failed to capture photo. Please try again.');
        }
    }

    // Show error message to user
    function showError(message) {
        console.error('Camera Error:', message);
        // You can show this in a more user-friendly way in your UI
        alert('Camera Error: ' + message);
    }
    
    // Initialize event listeners
    function initializeCamera() {
        // Toggle camera when camera button is clicked
        if (cameraBtn) {
            let isCameraOpen = false;
            
            cameraBtn.addEventListener('click', (e) => {
                e.preventDefault();
                isCameraOpen = !isCameraOpen;
                toggleCamera(isCameraOpen);
                
                // Update button text
                cameraBtn.innerHTML = isCameraOpen ? 
                    '<i class="bx bx-x me-1"></i>Close Camera' : 
                    '<i class="bx bx-camera me-1"></i>Open Camera';
                
                // Toggle button class
                cameraBtn.classList.toggle('btn-danger', isCameraOpen);
                cameraBtn.classList.toggle('btn-primary', !isCameraOpen);
            });
        }
        
        // Capture button
        if (captureBtn) {
            captureBtn.addEventListener('click', capturePhoto);
        }
        
        // Switch camera button
        if (switchCameraBtn) {
            switchCameraBtn.addEventListener('click', () => {
                // Toggle between front and back camera
                currentFacingMode = currentFacingMode === 'environment' ? 'user' : 'environment';
                startCamera();
            });
        }
        
        // Use photo button
        if (usePhotoBtn) {
            usePhotoBtn.addEventListener('click', usePhoto);
        }
        
        // Handle page visibility changes
        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                // Page is hidden, stop camera to save resources
                stopCamera();
            } else if (cameraContainer && !cameraContainer.classList.contains('d-none')) {
                // Page is visible and camera was open, restart camera
                startCamera();
            }
        });
        
        console.log('Camera initialized');
    }
    
    // Initialize camera when all required libraries are loaded
    function checkDependencies() {
        if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
            initializeCamera();
        } else {
            console.log('Waiting for Bootstrap to load...');
            setTimeout(checkDependencies, 100);
        }
    }
    
    // Start the initialization process
    checkDependencies();
    }
    
    // Camera button click
    if (cameraBtn) {
        cameraBtn.addEventListener("click", function(e) {
            e.preventDefault();
            const modal = new bootstrap.Modal(cameraModal);
            modal.show();
        });
    }
});
        // Show the captured image and hide the video
        video.classList.add('d-none');
        canvas.classList.remove('d-none');
        
        // Toggle buttons
        captureBtn.classList.add('d-none');
        retakeBtn.classList.remove('d-none');
        usePhotoBtn.classList.remove('d-none');
    }

    // Function to retake photo
    function retakePhoto() {
        video.classList.remove('d-none');
        canvas.classList.add('d-none');
        captureBtn.classList.remove('d-none');
        retakeBtn.classList.add('d-none');
        usePhotoBtn.classList.add('d-none');
    }

    // Function to use the captured photo
    function usePhoto() {
        // Convert canvas to blob
        canvas.toBlob(function(blob) {
            // Create a file from the blob
            const file = new File([blob], 'captured-photo.jpg', { type: 'image/jpeg' });
            
            // Create a data URL for preview
            const imageUrl = URL.createObjectURL(blob);
            
            // Update the file input
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            fileInput.files = dataTransfer.files;
            
            // Show preview
            cameraPreview.src = imageUrl;
            cameraPreview.classList.remove('d-none');
            
            // Close the modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('cameraModal'));
            if (modal) modal.hide();
            
            // Enable the process button if it exists
            const processBtn = document.getElementById('processImageBtn');
            if (processBtn) processBtn.disabled = false;
            
        }, 'image/jpeg', 0.9);
    }

    // Event Listeners
    if (document.getElementById('cameraModal')) {
        const cameraModal = document.getElementById('cameraModal');
        
        // When modal is shown
        cameraModal.addEventListener('shown.bs.modal', function() {
            startCamera();
        });
        
        // When modal is hidden
        cameraModal.addEventListener('hidden.bs.modal', function() {
            stopCamera();
            retakePhoto(); // Reset camera state
        });
        
        // Capture button
        if (captureBtn) {
            captureBtn.addEventListener('click', capturePhoto);
        }
        
        // Retake button
        if (retakeBtn) {
            retakeBtn.addEventListener('click', retakePhoto);
        }
        
        // Use Photo button
        if (usePhotoBtn) {
    const video = document.getElementById("video");
    const canvas = document.getElementById("canvas");
    const captureBtn = document.getElementById("captureBtn");
    const retakeBtn = document.getElementById("retakeBtn");
    const usePhotoBtn = document.getElementById("usePhotoBtn");
    const cameraPreview = document.getElementById("cameraPreview");
    const fileInput = document.getElementById("image");
    const cameraModal = document.getElementById("cameraModal");

    let stream = null;

    async function startCamera() {
        try {
            stream = await navigator.mediaDevices.getUserMedia({
                video: {
                    facingMode: { ideal: "environment" }, 
                    width: { ideal: 1280 },
                    height: { ideal: 720 },
                },
                audio: false
            });

            video.srcObject = stream;
            video.play();
        } catch (err) {
            alert("Camera error: " + err.message);
            const modal = bootstrap.Modal.getInstance(cameraModal);
            if (modal) modal.hide();
        }
    }

    function stopCamera() {
        if (!stream) return;
        stream.getTracks().forEach(track => track.stop());
    }

    captureBtn.addEventListener("click", () => {
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        canvas.getContext("2d").drawImage(video, 0, 0);

        video.classList.add("d-none");
        canvas.classList.remove("d-none");

        captureBtn.classList.add("d-none");
        retakeBtn.classList.remove("d-none");
        usePhotoBtn.classList.remove("d-none");
    });

    retakeBtn.addEventListener("click", () => {
        canvas.classList.add("d-none");
        video.classList.remove("d-none");

        captureBtn.classList.remove("d-none");
        retakeBtn.classList.add("d-none");
        usePhotoBtn.classList.add("d-none");
    });

    usePhotoBtn.addEventListener("click", () => {
        canvas.toBlob(blob => {
            const file = new File([blob], "camera-photo.jpg", { type: "image/jpeg" });

            const dt = new DataTransfer();
            dt.items.add(file);
            fileInput.files = dt.files;

            cameraPreview.src = URL.createObjectURL(blob);
            cameraPreview.classList.remove("d-none");

            const modal = bootstrap.Modal.getInstance(cameraModal);
            if (modal) modal.hide();

        }, "image/jpeg", 0.9);
    });

    cameraModal.addEventListener("shown.bs.modal", () => {
        // Reset UI
        video.classList.remove("d-none");
        canvas.classList.add("d-none");
        captureBtn.classList.remove("d-none");
        retakeBtn.classList.add("d-none");
        usePhotoBtn.classList.add("d-none");

        startCamera();
    });

    cameraModal.addEventListener("hidden.bs.modal", () => {
        stopCamera();
    });
});

// AJAX submit that maps visible UI values to backend-expected keys
function getVal(selector) {
  const el = document.querySelector(selector);
  return el ? el.value : '';
}
function getCheckedVal(name) {
  const el = document.querySelector(`input[name="${name}"]:checked`);
  return el ? el.value : '';
}
function clearServerErrors() {
  document.querySelectorAll('.invalid-feedback.server').forEach(e => e.remove());
  document.querySelectorAll('.is-invalid').forEach(e => e.classList.remove('is-invalid'));
}
function showServerErrors(errors) {
  const mapping = {
    'landing_center': 'landing_center',
    'date_sampling': 'date_sampling',
    'weather_conditions': 'weather_conditions',
    'total_catch_kg': 'total_catch_kg',
    'catch_type': 'catch_type', 
    'fishing_gear_type': 'fishing_gear_type'
  };
  Object.keys(errors || {}).forEach(key => {
    const name = mapping[key] || key;
    const input = document.querySelector(`[name="${name}"]`);
    if (input) {
      input.classList.add('is-invalid');
      let feedback = input.parentElement.querySelector('.invalid-feedback.server');
      if (!feedback) {
        feedback = document.createElement('div');
        feedback.className = 'invalid-feedback d-block server';
        input.parentElement.appendChild(feedback);
      }
      feedback.textContent = (errors[key] && errors[key][0]) ? errors[key][0] : 'Invalid value';
      input.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
  });
  const errorContainer = document.getElementById('formErrors');
  if (errorContainer) {
    errorContainer.classList.remove('d-none');
    errorContainer.innerHTML = '<i class="bx bx-error-circle me-2"></i> Please check the highlighted fields.';
  }
}
// Helper function to safely get form field values
function getFormValue(selector) {
    const element = document.querySelector(selector);
    return element ? element.value : null;
}

// Function to validate boat entries
function validateBoatEntries() {
    const boatEntries = document.querySelectorAll('.boat-entry:not([style*="display: none"])');
    const errors = {};
    
    boatEntries.forEach((boat, index) => {
        const boatType = boat.querySelector('input[name$="[boat_type]"]:checked');
        const boatName = boat.querySelector('input[name$="[boat_name]"]');
        const boatLength = boat.querySelector('input[name$="[boat_length]"]');
        const boatWidth = boat.querySelector('input[name$="[boat_width]"]');
        const boatDepth = boat.querySelector('input[name$="[boat_depth]"]');
        const fishermenCount = boat.querySelector('input[name$="[fishermen_count]"]');
        
        if (!boatType) {
            errors[`boats.${index}.boat_type`] = ['The boat type is required.'];
        }
        if (!boatName || !boatName.value.trim()) {
            errors[`boats.${index}.boat_name`] = ['The boat name is required.'];
        }
        if (!boatLength || !boatLength.value) {
            errors[`boats.${index}.boat_length`] = ['The boat length is required.'];
        }
        if (!boatWidth || !boatWidth.value) {
            errors[`boats.${index}.boat_width`] = ['The boat width is required.'];
        }
        if (!boatDepth || !boatDepth.value) {
            errors[`boats.${index}.boat_depth`] = ['The boat depth is required.'];
        }
        if (!fishermenCount || !fishermenCount.value) {
            errors[`boats.${index}.fishermen_count`] = ['The number of fishermen is required.'];
        }
    });
    
    return Object.keys(errors).length > 0 ? errors : null;
}

// Function to get form field value safely
function getFormValue(selector, form = document) {
    const element = form.querySelector(selector);
    if (!element) return null;
    
    if (element.type === 'select-one' || element.tagName === 'SELECT') {
        return element.value || null;
    }
    
    if (element.type === 'radio') {
        const checked = form.querySelector(`${selector}:checked`);
        return checked ? checked.value : null;
    }
    
    if (element.type === 'checkbox') {
        return element.checked;
    }
    
    return element.value || null;
}

// Function to get boat data from a boat entry
function getBoatData(boatElement, index) {
    return {
        boat_type: getFormValue('input[name^="boats['+index+'][boat_type]"][type="radio"]:checked', boatElement),
        boat_name: getFormValue('input[name^="boats['+index+'][boat_name]"]', boatElement),
        boat_length: getFormValue('input[name^="boats['+index+'][boat_length]"]', boatElement),
        boat_width: getFormValue('input[name^="boats['+index+'][boat_width]"]', boatElement),
        boat_depth: getFormValue('input[name^="boats['+index+'][boat_depth]"]', boatElement),
        fishermen_count: getFormValue('input[name^="boats['+index+'][fishermen_count]"]', boatElement),
        // Add other boat fields as needed
    };
}

// Function to validate boat entries
function validateBoatEntries() {
    const boatEntries = document.querySelectorAll('.boat-entry:not([style*="display: none"])');
    const errors = {};
    
    boatEntries.forEach((boat, index) => {
        const boatData = getBoatData(boat, index);
        
        if (!boatData.boat_type) {
            errors[`boats.${index}.boat_type`] = ['The boat type is required.'];
        }
        if (!boatData.boat_name) {
            errors[`boats.${index}.boat_name`] = ['The boat name is required.'];
        }
        if (!boatData.boat_length) {
            errors[`boats.${index}.boat_length`] = ['The boat length is required.'];
        }
        if (!boatData.boat_width) {
            errors[`boats.${index}.boat_width`] = ['The boat width is required.'];
        }
        if (!boatData.boat_depth) {
            errors[`boats.${index}.boat_depth`] = ['The boat depth is required.'];
        }
        if (!boatData.fishermen_count) {
            errors[`boats.${index}.fishermen_count`] = ['The number of fishermen is required.'];
        }
    });
    
    return Object.keys(errors).length > 0 ? errors : null;
}

async function submitCatchFormAjax(form) {
    clearServerErrors();
    const submitBtn = document.getElementById('submitBtn');
    if (submitBtn) submitBtn.disabled = true;
    
    try {
        // Get the weather conditions select element directly
        const weatherSelect = document.querySelector('select[name="weather_conditions"]');
        if (!weatherSelect || !weatherSelect.value) {
            showServerErrors({ weather_conditions: ['The weather conditions field is required.'] });
            if (submitBtn) submitBtn.disabled = false;
            weatherSelect?.scrollIntoView({ behavior: 'smooth', block: 'center' });
            weatherSelect?.focus();
            return;
        }
        
        // Get all boat data
        const boatEntries = document.querySelectorAll('.boat-entry:not([style*="display: none"])');
        
        // Validate boat entries first
        const boatErrors = validateBoatEntries();
        Object.assign(errors, boatErrors);
        
        // Validate fishing operation entries
        const fishingOpErrors = validateFishingOpEntries();
        Object.assign(errors, fishingOpErrors);
        
        // If there are errors, show them and stop form submission
        if (Object.keys(errors).length > 0) {
            showServerErrors(errors);
            if (submitBtn) submitBtn.disabled = false;
            return false;
        }
        
        // Create FormData from the form directly
        const fd = new FormData(form);
        
        // Make sure weather_conditions is included
        if (!fd.has('weather_conditions') && weatherSelect) {
            fd.append('weather_conditions', weatherSelect.value);
        }
        
        // Debug: Log the form data being sent
        console.log('FormData contents:');
        for (let pair of fd.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }

        const resp = await fetch(form.action, {
            method: 'POST',
            body: fd,
            headers: { 
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const contentType = resp.headers.get('content-type') || '';
        const data = contentType.includes('application/json') ? await resp.json() : null;

    if (!resp.ok) {
      if (resp.status === 422 && data && data.errors) {
        showServerErrors(data.errors);
        return;
      }
      const errorContainer = document.getElementById('formErrors');
      if (errorContainer) {
        errorContainer.classList.remove('d-none');
        errorContainer.innerHTML = '<i class="bx bx-error-circle me-2"></i> ' + ((data && data.message) ? data.message : 'An error occurred while saving. Please try again.');
      }
      return;
    }

    if (data && data.success) {
      alert('Fish catch recorded successfully!');
      if (data.redirect) {
        window.location.href = data.redirect;
      } else {
        window.location.href = '{{ route('catches.index') }}';
      }
      return;
    }

    // Fallback for non-JSON success
    window.location.href = '{{ route('catches.index') }}';

  } catch (err) {
    const errorContainer = document.getElementById('formErrors');
    if (errorContainer) {
      errorContainer.classList.remove('d-none');
      errorContainer.innerHTML = '<i class="bx bx-error-circle me-2"></i> Network error. Please try again.';
    }
    console.error('Submit error:', err);
  } finally {
    if (submitBtn) submitBtn.disabled = false;
  }
}
</script>

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
    crossorigin=""/>
<style>
    /* Ensure map container has proper dimensions */
    #map { 
        height: 300px; 
        width: 100%;
        border-radius: 5px;
        border: 1px solid #dee2e6;
        background-color: #f8f9fa; /* Fallback background */
    }
    /* Fix for Leaflet container */
    .leaflet-container {
        background-color: #f8f9fa !important;
    }
</style>


<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
    crossorigin=""></script>

<!-- Fishing Location Map Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Check if map container exists
    const mapElement = document.getElementById('fishing-location-map');
    const latInput = document.getElementById('latitude');
    const lngInput = document.getElementById('longitude');
    const locationInput = document.getElementById('fishing_location');
    const searchInput = document.getElementById('fishing-location-search');
    const searchButton = document.getElementById('search-location-btn');
    
    if (!mapElement) {
        console.error('Fishing location map container not found');
        return;
    }
    
    try {
        // Set initial coordinates from input fields or default to Philippines
        let initialLat = parseFloat(latInput?.value) || 12.8797;
        let initialLng = parseFloat(lngInput?.value) || 121.7740;
        let map, marker, geocoder;
        
        // Initialize the map
        function initMap() {
            map = L.map('fishing-location-map').setView([initialLat, initialLng], 10);
            
            // Add OpenStreetMap tiles
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                maxZoom: 19,
            }).addTo(map);
            
            // Add scale control
            L.control.scale({
                imperial: false,
                metric: true,
                position: 'bottomright'
            }).addTo(map);
            
            // Create a marker with initial position
            marker = L.marker([initialLat, initialLng], {
                draggable: true,
                title: 'Drag to adjust location'
            }).addTo(map);
            
            // Initialize geocoder
            initGeocoder();
            
            // Update form fields when marker is dragged
            marker.on('dragend', function(e) {
                const newLat = marker.getLatLng().lat;
                const newLng = marker.getLatLng().lng;
                updateFormFields(newLat, newLng);
            });
            
            // Handle map click to move marker
            map.on('click', function(e) {
                marker.setLatLng(e.latlng);
                updateFormFields(e.latlng.lat, e.latlng.lng);
            });
        }
        
        // Initialize geocoder for search functionality
        function initGeocoder() {
            // Handle search button click
            if (searchButton && searchInput) {
                searchButton.addEventListener('click', function() {
                    const query = searchInput.value.trim();
                    if (query) {
                        searchLocation(query);
                    }
                });
                
                // Allow search on Enter key
                searchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        const query = searchInput.value.trim();
                        if (query) {
                            searchLocation(query);
                        }
                    }
                });
            }
        }
        
        // Search for a location using Nominatim
        function searchLocation(query) {
            if (!query) return;
            
            // Show loading state
            const originalButtonText = searchButton.innerHTML;
            searchButton.disabled = true;
            searchButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Searching...';
            
            // Use Nominatim for geocoding
            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&limit=1`)
                .then(response => response.json())
                .then(data => {
                    if (data && data.length > 0) {
                        const result = data[0];
                        const lat = parseFloat(result.lat);
                        const lng = parseFloat(result.lon);
                        
                        // Update map view and marker
                        map.setView([lat, lng], 15);
                        marker.setLatLng([lat, lng]);
                        updateFormFields(lat, lng);
                        
                        // Update search input with formatted address
                        searchInput.value = result.display_name.split(',', 2).join(','); // Show first two parts of address
                    } else {
                        alert('Location not found. Please try a different search term.');
                    }
                })
                .catch(error => {
                    console.error('Geocoding error:', error);
                    alert('Error searching for location. Please try again.');
                })
                .finally(() => {
                    // Reset button state
                    searchButton.disabled = false;
                    searchButton.innerHTML = originalButtonText;
                });
        }
        
        // Function to update form fields
        function updateFormFields(lat, lng) {
            if (latInput) latInput.value = lat.toFixed(6);
            if (lngInput) lngInput.value = lng.toFixed(6);
            if (locationInput) locationInput.value = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
        }
        
        // Update marker position when input fields change
        if (latInput && lngInput) {
            const updateMarkerFromInputs = () => {
                const lat = parseFloat(latInput.value);
                const lng = parseFloat(lngInput.value);
                if (!isNaN(lat) && !isNaN(lng)) {
                    const newLatLng = L.latLng(lat, lng);
                    if (marker) marker.setLatLng(newLatLng);
                    if (map) map.panTo(newLatLng);
                }
            };
            
            latInput.addEventListener('change', updateMarkerFromInputs);
            lngInput.addEventListener('change', updateMarkerFromInputs);
        }
        
        // Initialize the map
        initMap();
        
    } catch (error) {
        console.error('Error initializing fishing location map:', error);
        if (mapElement) {
            mapElement.innerHTML = `
                <div class="alert alert-danger m-3">
                    <i class="bx bx-error"></i> Failed to load map. Please check your internet connection and refresh the page.
                    <div class="mt-2">${error.message}</div>
                </div>`;
        }
    }
});
</script>

<!-- jQuery (required for some plugins) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Simple form submission with alert -->
<script>
$(document).ready(function() {
    $('#catchForm').on('submit', function(e) {
        // Show loading state
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');
        
        // Show success message
        setTimeout(() => {
            alert('Report successfully saved');
            submitBtn.prop('disabled', false).html(originalText);
        }, 500);
        
        // Let the form submit normally
        return true;
    });
});
</script>

<script>
// Wait for the DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Check if map container exists
    const mapElement = document.getElementById('map');
    if (!mapElement) {
        console.log('Map container not found, skipping map initialization');
    } else if (typeof initMap === 'function') {
        // Initialize map only if element exists and initMap function is defined
        initMap();
    }
    
    // Show loading state
    mapElement.innerHTML = '<div class="d-flex justify-content-center align-items-center h-100"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading map...</span></div></div>';
    
    // Initialize the map with a fallback view
    try {
        // Set initial view (Philippines coordinates)
        const map = L.map('map').setView([12.8797, 121.7740], 6);
        
        // Add OpenStreetMap tiles with error handling
        const osmTiles = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            maxZoom: 19,
            errorTileUrl: 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=' // Transparent 1x1 image
        });
        
        // Add tile layer with error handling
        osmTiles.addTo(map);
        
        // Add scale control
        L.control.scale({
            imperial: false,
            metric: true,
            position: 'bottomright'
        }).addTo(map);
        
        // Add a default marker
        const marker = L.marker([12.8797, 121.7740], {
            draggable: true,
            title: 'Drag to adjust location'
        }).addTo(map);
        
        // Update form fields when marker is dragged
        marker.on('dragend', function(e) {
            const newLat = marker.getLatLng().lat;
            const newLng = marker.getLatLng().lng;
            updateFormFields(newLat, newLng);
        });
        
        // Handle map click
        map.on('click', function(e) {
            marker.setLatLng(e.latlng);
            updateFormFields(e.latlng.lat, e.latlng.lng);
        });
        
        // Function to update form fields
        function updateFormFields(lat, lng) {
            const latInput = document.getElementById('latitude');
            const lngInput = document.getElementById('longitude');
            const locationInput = document.getElementById('fishing_location');
            
            if (latInput) latInput.value = lat.toFixed(6);
            if (lngInput) lngInput.value = lng.toFixed(6);
            if (locationInput) locationInput.value = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
        }
        
        // Initialize form fields with default values
        updateFormFields(12.8797, 121.7740);
        
        console.log('Map initialized successfully');
        
    } catch (error) {
        console.error('Error initializing map:', error);
        mapElement.innerHTML = `
            <div class="alert alert-danger m-3">
                <i class="bx bx-error"></i> Failed to load map. Please check your internet connection and refresh the page.
                <div class="mt-2">${error.message}</div>
            </div>`;
    }
});

// Function to initialize map for boat entry
function initMapForBoat(boatElement, index) {
    // Get the map container
    const mapContainer = boatElement.querySelector(`#map-${index}`) || boatElement.querySelector('.map-container');
    if (!mapContainer) return;
    
    // Set a unique ID for the map container if it doesn't have one
    const mapId = mapContainer.id || `map-${index}-${Date.now()}`;
    mapContainer.id = mapId;
    
    // Get the search input and button
    const searchInput = boatElement.querySelector(`#search-location-${index}`);
    const searchButton = boatElement.querySelector(`#search-button-${index}`);
    
            // Initialize the map
    const map = L.map(mapId, {
        center: [12.8797, 121.7740],
        zoom: 10
    });
    
    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
    
    // Initialize geocoder control after map is ready
    function initGeocoder() {
        try {
            // Check if Leaflet is loaded
            if (typeof L === 'undefined') {
                console.error('Leaflet is not loaded');
                return null;
            }

            // Check if map is initialized
            if (!map || typeof map.addControl !== 'function') {
                console.error('Map is not properly initialized');
                return null;
            }
            
            // Check if geocoder control is already added
            if (map._geocoderControl) {
                console.log('Geocoder control already initialized');
                return map._geocoderControl;
            }
            
            // Create a custom geocoder control
            const geocoder = L.Control.geocoder({
                defaultMarkGeocode: false,
                position: 'topright',
                placeholder: 'Search location...',
                errorMessage: 'Location not found.',
                showResultIcons: true,
                collapsed: false
            });
            
            // Add the geocoder to the custom container
            const geocoderContainer = document.getElementById(`geocoder-container-${index}`);
            if (geocoderContainer) {
                geocoder.onAdd = function() {
                    const div = L.DomUtil.create('div', 'leaflet-control-geocoder leaflet-bar');
                    const form = L.DomUtil.create('form', 'd-flex', div);
                    const input = L.DomUtil.create('input', 'form-control', form);
                    input.type = 'text';
                    input.placeholder = 'Search location...';
                    
                    const button = L.DomUtil.create('button', 'btn btn-primary ms-1', form);
                    button.type = 'submit';
                    button.innerHTML = '<i class="bx bx-search"></i>';
                    
                    L.DomEvent.on(form, 'submit', function(e) {
                        e.preventDefault();
                        const query = input.value.trim();
                        if (query) {
                            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`)
                                .then(response => response.json())
                                .then(data => {
                                    if (data && data.length > 0) {
                                        const result = data[0];
                                        const lat = parseFloat(result.lat);
                                        const lng = parseFloat(result.lon);
                                        map.setView([lat, lng], 15);
                                        
                                        // Update the coordinates in the form
                                        const latInput = boatElement.querySelector('.latitude');
                                        const lngInput = boatElement.querySelector('.longitude');
                                        if (latInput) latInput.value = lat;
                                        if (lngInput) lngInput.value = lng;
                                    }
                                })
                                .catch(error => {
                                    console.error('Geocoding error:', error);
                                });
                        }
                    });
                    
                    return div;
                };
                
                // Add the geocoder to the map
                geocoder.addTo(map);
                
                // Store reference to remove later if needed
                map._geocoderControl = geocoder;
                
                return geocoder;
            }

            console.log('Initializing geocoder...');
            
            try {
                // Create geocoder control with error handling
                const geocoder = L.Control.Geocoder.nominatim();
                if (!geocoder) throw new Error('Failed to create geocoder instance');
                
                // Create a container for the geocoder control
                const geocoderContainer = L.DomUtil.create('div', 'leaflet-bar leaflet-control leaflet-control-custom');
                
                // Create the search control
                const searchControl = L.Control.geocoder({
                    defaultMarkGeocode: false,
                    placeholder: 'Search location...',
                    errorMessage: 'Location not found.',
                    position: 'topright',
                    collapsed: false,
                    geocoder: geocoder
                });
                
                // Add control to map
                searchControl.addTo(map);
                
                // Ensure the control is visible
                const geocoderInput = map.getContainer().querySelector('.leaflet-control-geocoder-form input[type="text"]');
                if (geocoderInput) {
                    geocoderInput.style.width = '200px';
                    geocoderInput.style.height = '30px';
                }
                
                // Add custom CSS for the geocoder
                const style = document.createElement('style');
                style.textContent = `
                    .leaflet-control-geocoder {
                        box-shadow: 0 1px 5px rgba(0,0,0,0.4);
                        background: #fff;
                        border-radius: 4px;
                    }
                    .leaflet-control-geocoder a {
                        background-color: #fff;
                        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="%23666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>');
                        background-repeat: no-repeat;
                        background-position: 8px 8px;
                        width: 30px;
                        height: 30px;
                        display: block;
                    }
                `;
                document.head.appendChild(style);
                
                // Handle geocoding results
                searchControl.on('markgeocode', function(e) {
                    try {
                        const center = e.geocode.center;
                        const lat = parseFloat(center.lat).toFixed(6);
                        const lng = parseFloat(center.lng).toFixed(6);
                        
                        console.log('Geocoder result:', e.geocode);
                        
                        // Update the input fields
                        if (latInput) latInput.value = lat;
                        if (lngInput) lngInput.value = lng;
                        
                        // Update the marker
                        updateMarker(parseFloat(lat), parseFloat(lng));
                        
                        // Center the map with padding
                        if (e.geocode.bbox) {
                            map.fitBounds([
                                [e.geocode.bbox[0][0], e.geocode.bbox[0][1]],
                                [e.geocode.bbox[1][0], e.geocode.bbox[1][1]]
                            ], { padding: [50, 50] });
                        } else {
                            map.setView([center.lat, center.lng], 15);
                        }
                    } catch (err) {
                        console.error('Error handling geocode result:', err);
                    }
                });
                
                console.log('Geocoder initialized successfully');
                return searchControl;
                
            } catch (err) {
                console.error('Failed to initialize geocoder control:', err);
                console.warn('Falling back to simple coordinate input');
                return null;
            }
            
        } catch (error) {
            console.error('Error in initGeocoder:', error);
            return null;
        }
    }
    
    // Initialize geocoder when map is ready
    let geocoderInitialized = false;
    
    // Add search functionality
    if (searchInput && searchButton) {
        const performSearch = () => {
            const query = searchInput.value.trim();
            if (!query) return;
            
            // Show loading state
            searchButton.disabled = true;
            searchButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Searching...';
            
            // Use Nominatim for geocoding
            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    if (data && data.length > 0) {
                        const result = data[0];
                        const lat = parseFloat(result.lat);
                        const lng = parseFloat(result.lon);
                        
                        // Center the map on the found location
                        map.setView([lat, lng], 15);
                        
                        // Add a marker at the location
                        if (window.boatMarkers && window.boatMarkers[index]) {
                            map.removeLayer(window.boatMarkers[index]);
                        }
                        
                        const marker = L.marker([lat, lng]).addTo(map);
                        if (!window.boatMarkers) window.boatMarkers = {};
                        window.boatMarkers[index] = marker;
                        
                        // Update the coordinates in the form
                        const latInput = boatElement.querySelector('.latitude');
                        const lngInput = boatElement.querySelector('.longitude');
                        if (latInput) latInput.value = lat;
                        if (lngInput) lngInput.value = lng;
                    } else {
                        alert('Location not found. Please try a different search term.');
                    }
                })
                .catch(error => {
                    console.error('Search error:', error);
                    alert('Error searching for location. Please try again.');
                })
                .finally(() => {
                    // Reset button state
                    searchButton.disabled = false;
                    searchButton.innerHTML = '<i class="bx bx-search"></i> Search';
                });
        };
        
        // Add event listeners
        searchButton.addEventListener('click', performSearch);
        searchInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                performSearch();
            }
        });
    }
    
    function initGeocoderWhenReady() {
        if (geocoderInitialized) return;
        
        if (window.L && window.L.Control && window.L.Control.Geocoder) {
            const geocoder = initGeocoder();
            if (geocoder) {
                geocoderInitialized = true;
                return;
            }
        }
        
        // Try again after a short delay
        if (!geocoderInitialized) {
            setTimeout(initGeocoderWhenReady, 200);
        }
    }
    
    // Start geocoder initialization
    setTimeout(initGeocoderWhenReady, 1000);
    
    // Get the latitude and longitude inputs for this boat
    const latInput = boatElement.querySelector('.latitude');
    const lngInput = boatElement.querySelector('.longitude');
    
    // Initialize with default values if inputs are empty
    let currentLat = latInput && latInput.value ? parseFloat(latInput.value) : 12.8797;
    let currentLng = lngInput && lngInput.value ? parseFloat(lngInput.value) : 121.7740;
    
    // Add a marker
    let marker = null;
    
    // Function to update the marker position
    const updateMarker = (lat, lng) => {
        if (!marker) {
            marker = L.marker([lat, lng], {
                draggable: true,
                title: 'Drag to adjust location'
            }).addTo(map);
            
            // Update inputs when marker is dragged
            marker.on('dragend', function(e) {
                const newLat = marker.getLatLng().lat;
                const newLng = marker.getLatLng().lng;
                if (latInput) latInput.value = newLat.toFixed(6);
                if (lngInput) lngInput.value = newLng.toFixed(6);
            });
        } else {
            marker.setLatLng([lat, lng]);
        }
        map.setView([lat, lng], map.getZoom());
    };
    
    // Update marker when coordinates are manually entered
    const updateFromInputs = () => {
        const lat = parseFloat(latInput.value) || 12.8797;
        const lng = parseFloat(lngInput.value) || 121.7740;
        updateMarker(lat, lng);
    };
    
    // Update inputs when marker is dragged
    if (latInput) latInput.addEventListener('change', updateFromInputs);
    if (lngInput) lngInput.addEventListener('change', updateFromInputs);
    
    // Update marker on map click
    map.on('click', function(e) {
        if (latInput && lngInput) {
            latInput.value = e.latlng.lat.toFixed(6);
            lngInput.value = e.latlng.lng.toFixed(6);
            updateMarker(e.latlng.lat, e.latlng.lng);
        }
    });
    
    // Store the map instance
    mapContainer._map = map;
    
    return map;
}

// Function to update boat numbers when one is removed
function updateBoatNumbers() {
    const boatEntries = document.querySelectorAll('.boat-entry');
    boatEntries.forEach((entry, index) => {
        const numberSpan = entry.querySelector('.entry-number');
        if (numberSpan) {
            numberSpan.textContent = index + 1;
        }
        
        // Update input names with new indices
        const inputs = entry.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            if (input.name) {
                input.name = input.name
                    .replace(/boats\[\d+\]/g, `boats[${index}]`)
                    .replace(/fishing_ops\[\d+\]/g, `fishing_ops[${index}]`);
            }
        });
    });
    return boatEntries.length - 1;
}

// Add Boat Functionality
document.addEventListener('DOMContentLoaded', function() {
    const addBoatBtn = document.getElementById('addBoatBtn');
    const boatInfoContainer = document.getElementById('boatInfoContainer');
    const boatTemplate = document.querySelector('.boat-entry[style*="display: none"]');
    let boatCount = 0;

    // Show remove button for the first boat entry
    const firstBoatEntry = document.querySelector('.boat-entry:not([style*="display: none"])');
    if (firstBoatEntry) {
        const firstRemoveBtn = firstBoatEntry.querySelector('.remove-boat');
        if (firstRemoveBtn) {
            firstRemoveBtn.style.display = 'inline-block';
            firstRemoveBtn.addEventListener('click', function(e) {
                e.preventDefault();
                if (document.querySelectorAll('.boat-entry').length > 1) {
                    this.closest('.boat-entry').remove();
                    updateBoatNumbers();
                }
            });
        }
        
        // Initialize map for the first boat entry
        initMapForBoat(firstBoatEntry, 0);
        
        // Set initial boat count
        boatCount = document.querySelectorAll('.boat-entry').length - 1;
    }

    if (addBoatBtn && boatTemplate) {
        addBoatBtn.addEventListener('click', function() {
            boatCount++;

            // Clone the hidden template
            const newBoat = boatTemplate.cloneNode(true);
            newBoat.style.display = 'block';
            // Re-enable fields from template and ensure they are not disabled/required
            newBoat.querySelectorAll('input, select, textarea').forEach(el => { el.disabled = false; });

            // Update all input names and IDs for the new boat
            newBoat.querySelectorAll('input, select, textarea, label').forEach((element) => {
                // Update input/select/textarea elements
                if (element.name) {
                    element.name = element.name.replace(/\[\d+\]/g, `[${boatCount}]`);
                    
                    // Clear the value for the new entry
                    if (element.type !== 'radio' && element.type !== 'checkbox' && !element.readOnly) {
                        element.value = '';
                    } else if (element.type === 'radio' || element.type === 'checkbox') {
                        element.checked = false;
                    }
                }
                
                // Update IDs and for attributes
                if (element.id) {
                    const newId = element.id + '_' + boatCount;
                    element.id = newId;
                    
                    // Update 'for' attributes in labels
                    if (element.tagName === 'LABEL' && element.htmlFor) {
                        element.htmlFor = newId;
                    }
                }
            });

            // Update entry number
            const entryNumber = newBoat.querySelector('.entry-number');
            if (entryNumber) {
                entryNumber.textContent = boatCount + 1;
            }

            // Add remove event
            const removeBtn = newBoat.querySelector('.remove-boat');
            if (removeBtn) {
                removeBtn.style.display = 'inline-block';
            }

            // Add the new boat to the container
            boatInfoContainer.appendChild(newBoat);

            
            // Initialize map for the new boat entry
            initMapForBoat(newBoat, boatCount);
            
            // Update boat numbers
            boatCount = updateBoatNumbers();
        });
    }
});

// Function to update fishing operation numbers when one is removed
function updateFishingOpNumbers() {
    const opEntries = document.querySelectorAll('.fishing-op-entry');
    opEntries.forEach((entry, index) => {
        const numberSpan = entry.querySelector('.entry-number');
        if (numberSpan) {
            numberSpan.textContent = index + 1;
        }
        
        // Update input names with new indices
        const inputs = entry.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            if (input.name) {
                input.name = input.name.replace(/fishing_ops\[\d+\]/g, `fishing_ops[${index}]`);
            }
        });
        
        // Reinitialize map with new index
        if (entry.style.display !== 'none') {
            initFishingOpMap(entry, index);
        }
    });
    return opEntries.length - 1;
}

// Function to initialize map for fishing operation
function initFishingOpMap(container, index) {
    // Check if map is already initialized in the document
    if (window.fishingOpMap) {
        // If map exists, just update the container reference and return
        window.fishingOpMap._container = container;
        return window.fishingOpMap;
    }
    
    // Find or create the single map container
    let mapContainer = document.getElementById('fishing-op-single-map');
    
    // If map container doesn't exist, create it
    if (!mapContainer) {
        mapContainer = document.createElement('div');
        mapContainer.id = 'fishing-op-single-map';
        mapContainer.className = 'fishing-op-map-container';
        mapContainer.style.height = '300px';
        mapContainer.style.marginBottom = '15px';
        mapContainer.style.borderRadius = '5px';
        mapContainer.style.border = '1px solid #dee2e6';
        
        // Insert the map container at the top of the fishing operations section
        const fishingOpSection = document.querySelector('.fishing-op-entry .card-body');
        if (fishingOpSection) {
            fishingOpSection.insertBefore(mapContainer, fishingOpSection.firstChild);
        }
    }
    
    // Create a unique ID for the map container
    const mapId = 'fishingOpMap_' + index + '_' + Math.floor(Math.random() * 1000);
    mapContainer.id = mapId;
    
    // Initialize the map
    const map = L.map(mapId, {
        center: [12.8797, 121.7740],
        zoom: 6,
        zoomControl: true
    });
    
    // Add the OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 19
    }).addTo(map);
    
    // Get the latitude and longitude inputs
    const latInput = container.querySelector('input[name$="[latitude]"]');
    const lngInput = container.querySelector('input[name$="[longitude]"]');
    const locationInput = container.querySelector('input[name$="[fishing_location]"]');
    
    // Set initial coordinates from inputs or default
    let initialLat = parseFloat(latInput?.value) || 12.8797;
    let initialLng = parseFloat(lngInput?.value) || 121.7740;
    
    // Add a marker
    const marker = L.marker([initialLat, initialLng], {
        draggable: true
    }).addTo(map);
    
    // Set initial view
    map.setView([initialLat, initialLng], 12);
    
    // Function to update marker position from inputs
    const updateMarkerFromInputs = () => {
        const lat = parseFloat(latInput?.value) || 12.8797;
        const lng = parseFloat(lngInput?.value) || 121.7740;
        marker.setLatLng([lat, lng]);
        map.setView([lat, lng], map.getZoom());
    };
    
    // Update inputs when marker is dragged
    marker.on('dragend', function(e) {
        const latLng = marker.getLatLng();
        const lat = latLng.lat.toFixed(6);
        const lng = latLng.lng.toFixed(6);
        
        if (latInput) latInput.value = lat;
        if (lngInput) lngInput.value = lng;
        if (locationInput) locationInput.value = `${lat}, ${lng}`;
    });
    
    // Update marker when inputs change
    if (latInput) latInput.addEventListener('change', updateMarkerFromInputs);
    if (lngInput) lngInput.addEventListener('change', updateMarkerFromInputs);
    
    // Update marker on map click and update inputs for the active fishing operation
    map.on('click', function(e) {
        const latLng = e.latlng;
        const lat = latLng.lat.toFixed(6);
        const lng = latLng.lng.toFixed(6);
        
        marker.setLatLng(latLng);
        
        // Get the active fishing operation container
        const activeOp = document.querySelector('.fishing-op-entry:not([style*="display: none"])');
        if (activeOp) {
            const latInput = activeOp.querySelector('input[name$="[latitude]"]');
            const lngInput = activeOp.querySelector('input[name$="[longitude]"]');
            const locationInput = activeOp.querySelector('input[name$="[fishing_location]"]');
            
            if (latInput) latInput.value = lat;
            if (lngInput) lngInput.value = lng;
            if (locationInput) locationInput.value = `${lat}, ${lng}`;
        }
    });
    
    // Store the map instance globally and mark as initialized
    window.fishingOpMap = map;
    map._container = container; // Store reference to current container
    
    // Initialize marker position from inputs
    updateMarkerFromInputs();
    
    return map;
}

// Function to update fishing operation numbers
function updateFishingOpNumbers() {
    const opEntries = document.querySelectorAll('.fishing-op-entry:not([style*="display: none"])');
    opEntries.forEach((entry, index) => {
        const numberSpan = entry.querySelector('.entry-number');
        if (numberSpan) {
            numberSpan.textContent = index + 1;
        }
        
        // Update input names with new indices
        const inputs = entry.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            if (input.name) {
                input.name = input.name.replace(/fishing_ops\[\d+\]/g, `fishing_ops[${index}]`);
                
                // Update IDs for radio buttons and their labels
                if (input.type === 'radio' || input.type === 'checkbox') {
                    const oldId = input.id;
                    const newId = oldId.replace(/\d+$/, index);
                    input.id = newId;
                    
                    // Update corresponding label
                    const label = entry.querySelector(`label[for="${oldId}"]`);
                    if (label) {
                        label.htmlFor = newId;
                    }
                }
            }
        });
    });
    
    return opEntries.length - 1;
}

// Initialize fishing operation entry
// Initialize fishing operation entries when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    try {
        // Initialize the first fishing operation entry
        const firstEntry = document.querySelector('.fishing-op-entry:not([style*="display: none"])');
        if (firstEntry) {
            // Hide the remove button since there's only one entry
            const removeBtn = firstEntry.querySelector('.remove-fishing-op');
            if (removeBtn) {
                removeBtn.style.display = 'none';
            }
        }
    } catch (error) {
        console.error('Error initializing fishing operation entries:', error);
    }
});

// Boat Information Autofill Functionality
document.addEventListener('DOMContentLoaded', function() {
    // Debounce function to limit API calls
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Function to handle boat name input and fetch boat data
    function setupBoatAutofill() {
        const boatEntries = document.querySelectorAll('.boat-entry:not([style*="display: none"])');
        
        boatEntries.forEach((boatEntry, index) => {
            const boatNameInput = boatEntry.querySelector('input[name$="[boat_name]"]');
            
            if (boatNameInput && !boatNameInput.hasAttribute('data-autofill-listener')) {
                // Mark this input as having a listener to avoid duplicates
                boatNameInput.setAttribute('data-autofill-listener', 'true');
                
                // Add debounced input event listener
                boatNameInput.addEventListener('input', debounce(async function(e) {
                    const query = this.value.trim();
                    
                    // Don't search if query is too short
                    if (query.length < 2) return;
                    
                    try {
                        const response = await fetch(`/boats/search?query=${encodeURIComponent(query)}`);
                        const data = await response.json();
                        
                        if (data.status === 'found' && data.data) {
                            const boat = data.data;
                            const entryIndex = this.name.match(/\d+/)[0]; // Get the index from the input name
                            
                            // Update the boat type radio buttons
                            const boatTypeInput = boatEntry.querySelector(`input[name="boats[${entryIndex}][boat_type]"][value="${boat.boat_type}"]`);
                            if (boatTypeInput) boatTypeInput.checked = true;
                            
                            // Update other fields
                            setInputValue(boatEntry, `boats[${entryIndex}][boat_length]`, boat.boat_length);
                            setInputValue(boatEntry, `boats[${entryIndex}][boat_width]`, boat.boat_width);
                            setInputValue(boatEntry, `boats[${entryIndex}][boat_depth]`, boat.boat_depth);
                            setInputValue(boatEntry, `boats[${entryIndex}][gross_tonnage]`, boat.gross_tonnage);
                            setInputValue(boatEntry, `boats[${entryIndex}][horsepower]`, boat.horsepower);
                            setInputValue(boatEntry, `boats[${entryIndex}][engine_type]`, boat.engine_type);
                            setInputValue(boatEntry, `boats[${entryIndex}][fishermen_count]`, boat.fishermen_count);
                            
                            // Show success message
                            showToast('Boat information loaded successfully!', 'success');
                        }
                    } catch (error) {
                        console.error('Error fetching boat data:', error);
                        showToast('Error fetching boat information', 'error');
                    }
                }, 300)); // 300ms debounce delay
            }
        });
    }
    
    // Helper function to set input values
    function setInputValue(container, name, value) {
        const input = container.querySelector(`[name="${name}"]`);
        if (input) {
            input.value = value || '';
            // Trigger any necessary events (like for gross tonnage calculation)
            if (input.oninput) input.oninput();
        }
    }
    
    // Show toast notification
    function showToast(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `toast align-items-center text-white bg-${type} border-0 position-fixed bottom-0 end-0 m-3`;
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-live', 'assertive');
        toast.setAttribute('aria-atomic', 'true');
        
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bx ${type === 'success' ? 'bx-check-circle' : 'bx-error'}"></i> ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        `;
        
        document.body.appendChild(toast);
        const bsToast = new bootstrap.Toast(toast);
        bsToast.show();
        
        // Remove toast after it's hidden
        toast.addEventListener('hidden.bs.toast', function() {
            document.body.removeChild(toast);
        });
    }
    
    // Initialize autofill for existing boat entries
    setupBoatAutofill();
    
    // Set up a mutation observer to handle dynamically added boat entries
    const boatInfoContainer = document.getElementById('boatInfoContainer');
    if (boatInfoContainer) {
        const observer = new MutationObserver(function(mutations) {
            setupBoatAutofill();
        });
        
        observer.observe(boatInfoContainer, {
            childList: true,
            subtree: true
        });
    }
});

// Function to update catch numbers when one is removed
function updateCatchNumbers() {
    const catchEntries = document.querySelectorAll('.catch-entry');
    catchEntries.forEach((entry, index) => {
        const numberSpan = entry.querySelector('.catch-number');
        if (numberSpan) {
            numberSpan.textContent = index + 1;
        }
        
        // Update input names with new indices
        const inputs = entry.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            if (input.name) {
                input.name = input.name.replace(/catches\[\d+\]/g, `catches[${index}]`);
            }
        });
    });
    return catchEntries.length - 1;
}

// Add Catch Functionality
document.addEventListener('DOMContentLoaded', function() {
    const addCatchBtn = document.getElementById('addCatchBtn');
    const catchContainer = document.getElementById('catchInfoContainer');
    const catchTemplate = document.querySelector('.catch-entry[style*="display: none"]');
    let catchCount = 0;

    // Show remove button for the first catch entry
    const firstCatchEntry = document.querySelector('.catch-entry:not([style*="display: none"])');
    if (firstCatchEntry) {
        const firstRemoveBtn = firstCatchEntry.querySelector('.remove-catch');
        if (firstRemoveBtn) {
            firstRemoveBtn.style.display = 'inline-block';
            firstRemoveBtn.addEventListener('click', function(e) {
                e.preventDefault();
                if (document.querySelectorAll('.catch-entry').length > 1) {
                    this.closest('.catch-entry').remove();
                    updateCatchNumbers();
                }
            });
        }
        
        // Set initial catch count
        catchCount = document.querySelectorAll('.catch-entry').length - 1;
    }

    if (addCatchBtn && catchTemplate) {
        addCatchBtn.addEventListener('click', function() {
            catchCount++;

            // Clone the hidden template
            const newCatch = catchTemplate.cloneNode(true);
            newCatch.style.display = 'block';

            // Update all input names and IDs for the new catch
            newCatch.querySelectorAll('input, select, textarea, label').forEach((element) => {
                // Update input/select/textarea elements
                if (element.name) {
                    element.name = element.name.replace(/\[\d+\]/g, `[${catchCount}]`);
                    
                    // Clear the value for the new entry
                    if (element.type !== 'radio' && element.type !== 'checkbox' && !element.readOnly) {
                        element.value = '';
                    } else if (element.type === 'radio' || element.type === 'checkbox') {
                        element.checked = false;
                    }
                }
                
                // Update IDs and for attributes
                if (element.id) {
                    const newId = element.id + '_' + catchCount;
                    element.id = newId;
                    
                    // Update 'for' attributes in labels
                    if (element.tagName === 'LABEL' && element.htmlFor) {
                        element.htmlFor = newId;
                    }
                }
            });

            // Update catch number
            const catchNumber = newCatch.querySelector('.catch-number');
            if (catchNumber) {
                catchNumber.textContent = catchCount + 1;
            }

            // Add remove event
            const removeBtn = newCatch.querySelector('.remove-catch');
            if (removeBtn) {
                removeBtn.style.display = 'inline-block';
                removeBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (document.querySelectorAll('.catch-entry').length > 1) {
                        newCatch.remove();
                        updateCatchNumbers();
                    }
                });
            }

            // Add the new catch to the container
            catchContainer.appendChild(newCatch);
            
            // Update catch numbers
            catchCount = updateCatchNumbers();
        });
    }
});

// Add Species Functionality
document.addEventListener('DOMContentLoaded', function() {
    const addSpeciesBtn = document.getElementById('addSpeciesBtn');
    const speciesContainer = document.querySelector('.card-body'); // Using the main card body for species entries
    
    // Create a container for species entries if it doesn't exist
    let speciesEntriesContainer = document.getElementById('speciesEntriesContainer');
    if (!speciesEntriesContainer) {
        speciesEntriesContainer = document.createElement('div');
        speciesEntriesContainer.id = 'speciesEntriesContainer';
        speciesContainer.appendChild(speciesEntriesContainer);
    }
    
    // Function to create a new species entry
    const createNewSpeciesEntry = (index) => {
        const entryDiv = document.createElement('div');
        entryDiv.className = 'species-entry card mb-3 border-secondary';
        entryDiv.innerHTML = `
            <div class="card-header py-1 bg-light d-flex justify-content-between align-items-center">
                <span class="fw-bold">Species #<span class="species-number">${index + 1}</span></span>
                <button type="button" class="btn btn-sm btn-danger remove-species" title="Remove this species">
                    <i class="bx bx-trash"></i>
                </button>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Species: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="species[${index}][name]" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Length (cm): <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control" name="species[${index}][length]" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Weight (kg): <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control" name="species[${index}][weight]" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-3">
                        <label class="form-label">Notes:</label>
                        <textarea class="form-control" name="species[${index}][notes]" rows="2"></textarea>
                    </div>
                </div>
            </div>
        `;
        
        // Add remove event
        const removeBtn = entryDiv.querySelector('.remove-species');
        if (removeBtn) {
            removeBtn.addEventListener('click', function() {
                entryDiv.remove();
                updateSpeciesNumbers();
            });
        }
        
        return entryDiv;
    };
    
    // Function to update species numbers
    const updateSpeciesNumbers = () => {
        const speciesEntries = document.querySelectorAll('.species-entry');
        speciesEntries.forEach((entry, index) => {
            const numberSpan = entry.querySelector('.species-number');
            if (numberSpan) {
                numberSpan.textContent = index + 1;
            }
            
            // Update input names with new indices
            entry.querySelectorAll('input, select, textarea').forEach(element => {
                if (element.name) {
                    element.name = element.name.replace(/species\[\d+\]/g, `species[${index}]`);
                }
            });
        });
    };
    
    // Add initial species entry if none exists
    if (addSpeciesBtn) {
        // Add click event for the Add Species button
        addSpeciesBtn.addEventListener('click', function() {
            const speciesEntries = document.querySelectorAll('.species-entry');
            const newEntry = createNewSpeciesEntry(speciesEntries.length);
            speciesEntriesContainer.appendChild(newEntry);
            updateSpeciesNumbers();
        });
        
        // Add event delegation for delete buttons (for dynamically added elements)
        speciesContainer.addEventListener('click', function(e) {
            if (e.target.closest('.remove-species')) {
                e.preventDefault();
                const entryToRemove = e.target.closest('.species-entry');
                if (entryToRemove && document.querySelectorAll('.species-entry').length > 1) {
                    entryToRemove.remove();
                    updateSpeciesNumbers();
                } else if (document.querySelectorAll('.species-entry').length === 1) {
                    // If it's the last entry, just clear the fields instead of removing
                    const entry = document.querySelector('.species-entry');
                    entry.querySelectorAll('input[type="text"], input[type="number"], textarea').forEach(input => {
                        input.value = '';
                    });
                }
            }
        });
    }

});

// Camera functionality
function initializeCamera() {
    // DOM Elements
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const captureBtn = document.getElementById('captureBtn');
    const switchCameraBtn = document.getElementById('switchCameraBtn');
    const usePhotoBtn = document.getElementById('usePhotoBtn');
    const cameraPreview = document.getElementById('cameraPreview');
    const fileInput = document.getElementById('image');
    const cameraBtn = document.getElementById('cameraBtn');
    const cameraContainer = document.getElementById('cameraContainer');
    
    // Camera state
    let currentFacingMode = 'environment'; // Start with back camera
    let stream = null;
    let isCaptured = false;

    // Toggle camera visibility and connection
    async function toggleCamera(show) {
        if (show) {
            cameraContainer.classList.remove('d-none');
            await connectCamera();
            cameraBtn.innerHTML = '<i class="bx bx-x me-1"></i>Close Camera';
            cameraBtn.classList.remove('btn-primary');
            cameraBtn.classList.add('btn-danger');
        } else {
            disconnectCamera();
            cameraContainer.classList.add('d-none');
            cameraBtn.innerHTML = '<i class="bx bx-camera me-1"></i>Open Camera';
            cameraBtn.classList.remove('btn-danger');
            cameraBtn.classList.add('btn-primary');
        }
    }

    // Connect to camera
    async function connectCamera() {
        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
            alert('Camera access is not supported in this browser.');
            return;
        }

        try {
            // Stop any existing stream
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }

            // Get video stream
            stream = await navigator.mediaDevices.getUserMedia({
                video: {
                    facingMode: currentFacingMode,
                    width: { ideal: 1280 },
                    height: { ideal: 720 }
                }
            });

            // Set video source
            video.srcObject = stream;
            await video.play();
            
            // Reset UI
            video.classList.remove('d-none');
            canvas.classList.add('d-none');
            captureBtn.classList.remove('d-none');
            usePhotoBtn.classList.add('d-none');
            isCaptured = false;

        } catch (err) {
            console.error('Camera error:', err);
            alert('Unable to access camera. Please check permissions and try again.');
            cameraContainer.classList.add('d-none');
            cameraBtn.innerHTML = '<i class="bx bx-camera me-1"></i>Open Camera';
            cameraBtn.classList.remove('btn-danger');
            cameraBtn.classList.add('btn-primary');
        }
    }

    // Disconnect camera
    function disconnectCamera() {
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
            stream = null;
        }
        if (video.srcObject) {
            video.srcObject = null;
        }
    }

    // Capture photo
    function capturePhoto() {
        if (!stream) return;

        try {
            // Set canvas dimensions to match video
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            
            // Draw video frame to canvas
            const ctx = canvas.getContext('2d');
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
            
            // Update UI
            video.classList.add('d-none');
            canvas.classList.remove('d-none');
            captureBtn.classList.add('d-none');
            usePhotoBtn.classList.remove('d-none');
            isCaptured = true;

        } catch (err) {
            console.error('Error capturing photo:', err);
            alert('Failed to capture photo. Please try again.');
        }
    }

    // Use the captured photo
    function usePhoto() {
        if (!isCaptured) return;

        try {
            // Convert canvas to blob
            canvas.toBlob((blob) => {
                // Create a file from the blob
                const file = new File([blob], 'fish-photo.jpg', { type: 'image/jpeg' });
                
                // Create a new FileList and DataTransfer
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                
                // Update file input
                fileInput.files = dataTransfer.files;
                
                // Show preview
                cameraPreview.src = URL.createObjectURL(blob);
                cameraPreview.classList.remove('d-none');
                
                // Close camera
                toggleCamera(false);
            }, 'image/jpeg', 0.9);

        } catch (err) {
            console.error('Error using photo:', err);
            alert('Failed to process photo. Please try again.');
        }
    }

    // Switch between front and back camera
    async function switchCamera() {
        currentFacingMode = currentFacingMode === 'user' ? 'environment' : 'user';
        await connectCamera();
    }

    // Initialize event listeners
    function setupEventListeners() {
        // Add event listener for camera button
        if (cameraBtn) {
            cameraBtn.addEventListener('click', function() {
                const isCameraVisible = !cameraContainer.classList.contains('d-none');
                if (!isCameraVisible) {
                    // Only update button text when opening the camera
                    cameraBtn.innerHTML = '<i class="bx bx-camera me-1"></i>Open Camera';
                    toggleCamera(true);
                }
            });
        }
        
        // Add event listener for close camera button
        const closeCameraBtn = document.getElementById('closeCameraBtn');
        if (closeCameraBtn) {
            closeCameraBtn.addEventListener('click', function() {
                stopCamera();
                cameraContainer.classList.add('d-none');
                cameraBtn.innerHTML = '<i class="bx bx-camera me-1"></i>Open Camera';
            });
        }
        
        // Capture button
        captureBtn?.addEventListener('click', capturePhoto);

        // Switch camera button
        switchCameraBtn?.addEventListener('click', switchCamera);

        // Use photo button
        usePhotoBtn?.addEventListener('click', usePhoto);

        // Clean up camera when page is hidden
        document.addEventListener('visibilitychange', () => {
            if (document.hidden && stream) {
                disconnectCamera();
            }
        });
    }

    // Initialize the camera functionality
    setupEventListeners();
}

// Initialize fishing location map
function initFishingLocationMap() {
    const mapElement = document.getElementById('fishing-location-map');
    const searchInput = document.getElementById('fishing-location-search');
    const searchButton = document.getElementById('search-location-btn');
    const latInput = document.querySelector('input[name$="[latitude]"]');
    const lngInput = document.querySelector('input[name$="[longitude]"]');
    
    if (!mapElement) return;
    
    // Initialize the map
    const map = L.map('fishing-location-map').setView([12.8797, 121.7740], 10);
    
    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
    
    // Add a marker
    const marker = L.marker([12.8797, 121.7740], {
        draggable: true
    }).addTo(map);
    
    // Update marker position and input fields when marker is dragged
    marker.on('dragend', function(e) {
        const latLng = marker.getLatLng();
        updateInputs(latLng.lat, latLng.lng);
    });
    
    // Update marker position when map is clicked
    map.on('click', function(e) {
        marker.setLatLng(e.latlng);
        updateInputs(e.latlng.lat, e.latlng.lng);
    });
    
    // Update marker and map view when inputs change
    if (latInput && lngInput) {
        const updateMarkerFromInputs = () => {
            const lat = parseFloat(latInput.value) || 12.8797;
            const lng = parseFloat(lngInput.value) || 121.7740;
            const newLatLng = L.latLng(lat, lng);
            marker.setLatLng(newLatLng);
            map.setView(newLatLng, 13);
        };
        
        latInput.addEventListener('change', updateMarkerFromInputs);
        lngInput.addEventListener('change', updateMarkerFromInputs);
    }
    
    // Handle search functionality
    if (searchInput && searchButton) {
        const performSearch = () => {
            const query = searchInput.value.trim();
            if (!query) return;
            
            // Show loading state
            const originalButtonText = searchButton.innerHTML;
            searchButton.disabled = true;
            searchButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Searching...';
            
            // Use Nominatim for geocoding
            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    if (data && data.length > 0) {
                        const result = data[0];
                        const lat = parseFloat(result.lat);
                        const lng = parseFloat(result.lon);
                        
                        // Update marker and map view
                        const newLatLng = L.latLng(lat, lng);
                        marker.setLatLng(newLatLng);
                        map.setView(newLatLng, 15);
                        
                        // Update input fields
                        updateInputs(lat, lng);
                    } else {
                        alert('Location not found. Please try a different search term.');
                    }
                })
                .catch(error => {
                    console.error('Search error:', error);
                    alert('Error searching for location. Please try again.');
                })
                .finally(() => {
                    // Reset button state
                    searchButton.disabled = false;
                    searchButton.innerHTML = originalButtonText;
                });
        };
        
        // Add event listeners for search
        searchButton.addEventListener('click', performSearch);
        searchInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                performSearch();
            }
        });
    }
    
    // Helper function to update input fields
    function updateInputs(lat, lng) {
        if (latInput) latInput.value = lat.toFixed(6);
        if (lngInput) lngInput.value = lng.toFixed(6);
    }
    
    return map;
}

// Initialize camera when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Initialize fishing location map
    initFishingLocationMap();
    
    // Handle adding new fishing operation entries
    const addFishingOpBtn = document.getElementById('addFishingOpBtn');
    const fishingOpContainer = document.getElementById('fishingOpContainer');
    
    if (addFishingOpBtn && fishingOpContainer) {
        addFishingOpBtn.addEventListener('click', function() {
            // Get the template
            const template = document.querySelector('.fishing-op-entry[style*="display: none"]');
            if (!template) return;
            
            // Clone the template
            const newEntry = template.cloneNode(true);
            newEntry.style.display = '';
            
            // Update the entry number
            const entryNumber = document.querySelectorAll('.fishing-op-entry:not([style*="display: none"])').length;
            const numberSpan = newEntry.querySelector('.entry-number');
            if (numberSpan) {
                numberSpan.textContent = entryNumber + 1;
            }
            
            // Update input names with new index
            const inputs = newEntry.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                if (input.name) {
                    input.name = input.name.replace(/fishing_ops\[\d+\]/g, `fishing_ops[${entryNumber}]`);
                    
                    // Clear the value for new entries
                    if (input.type !== 'hidden') {
                        input.value = '';
                    }
                    
                    // Update IDs for radio buttons and their labels
                    if (input.type === 'radio' || input.type === 'checkbox') {
                        const oldId = input.id;
                        if (oldId) {
                            const newId = oldId.replace(/\d+$/, entryNumber);
                            input.id = newId;
                            
                            // Update corresponding label
                            const label = newEntry.querySelector(`label[for="${oldId}"]`);
                            if (label) {
                                label.htmlFor = newId;
                            }
                        }
                    }
                }
            });
            
            // Show the remove button for all entries except the first one
            const removeBtns = document.querySelectorAll('.remove-fishing-op');
            if (removeBtns.length > 0) {
                removeBtns.forEach(btn => {
                    btn.style.display = 'block';
                });
            }
            
            // Insert the new entry before the add button
            const addButtonContainer = document.querySelector('#fishingOpContainer > .text-end');
            if (addButtonContainer) {
                fishingOpContainer.insertBefore(newEntry, addButtonContainer);
            } else {
                fishingOpContainer.appendChild(newEntry);
            }
            
            // Initialize map for the new entry if needed
            const mapContainer = newEntry.querySelector('.map-container');
            if (mapContainer && typeof initFishingLocationMap === 'function') {
                // Add a unique ID to the map container
                const mapId = 'fishing-location-map-' + Date.now();
                mapContainer.id = mapId;
                
                // Initialize the map
                initFishingLocationMap();
            }
            
            // Update entry numbers
            updateFishingOpNumbers();
        });
    }
    
    // Handle removing fishing operation entries
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-fishing-op')) {
            const entry = e.target.closest('.fishing-op-entry');
            if (entry) {
                entry.remove();
                updateFishingOpNumbers();
                
                // Hide remove button if only one entry remains
                const entries = document.querySelectorAll('.fishing-op-entry:not([style*="display: none"])');
                if (entries.length <= 1) {
                    const removeBtns = document.querySelectorAll('.remove-fishing-op');
                    removeBtns.forEach(btn => {
                        btn.style.display = 'none';
                    });
                }
            }
        }
    });
    
    // Update fishing operation numbers
    function updateFishingOpNumbers() {
        const entries = document.querySelectorAll('.fishing-op-entry:not([style*="display: none"])');
        entries.forEach((entry, index) => {
            const numberSpan = entry.querySelector('.entry-number');
            if (numberSpan) {
                numberSpan.textContent = index + 1;
            }
            
            // Update input names with new indices
            const inputs = entry.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                if (input.name) {
                    input.name = input.name.replace(/fishing_ops\[\d+\]/g, `fishing_ops[${index}]`);
                }
            });
        });
    }
    
    try {
        // Check if camera elements exist before initializing
        const cameraBtn = document.getElementById('cameraBtn');
        const cameraModal = document.getElementById('cameraModal');
        
        if (!cameraBtn || !cameraModal) {
            console.log('Camera elements not found, skipping camera initialization');
            return;
        }
        
        // Only initialize camera when the modal is shown
        cameraModal.addEventListener('show.bs.modal', function() {
            try {
                initializeCamera();
            } catch (error) {
                console.error('Error initializing camera:', error);
                // Show error to user
                const errorDiv = document.createElement('div');
                errorDiv.className = 'alert alert-danger mt-3';
                errorDiv.textContent = 'Failed to initialize camera. Please check your browser permissions and try again.';
                cameraModal.querySelector('.modal-body').prepend(errorDiv);
            }
        });
        
        // Clean up camera when modal is hidden
        cameraModal.addEventListener('hidden.bs.modal', function() {
            if (window.cameraStream) {
                window.cameraStream.getTracks().forEach(track => track.stop());
                window.cameraStream = null;
            }
        });
    } catch (error) {
        console.error('Error setting up camera event listeners:', error);
    }
});

// Function to calculate Gross Tonnage based on boat dimensions
function calculateGrossTonnage(input) {
    // Debug log to check if function is called
    console.log('calculateGrossTonnage called');
    
    // Get the parent boat entry
    const boatEntry = input.closest('.boat-entry');
    if (!boatEntry) return;
    
    // Get the input values - using more specific selectors to match the form structure
    const lengthInput = boatEntry.querySelector('input[name*="[boat_length]"]');
    const widthInput = boatEntry.querySelector('input[name*="[boat_width]"]');
    const depthInput = boatEntry.querySelector('input[name*="[boat_depth]"]');
    const gtInput = boatEntry.querySelector('input[name*="[gross_tonnage]"]');
    
    if (!lengthInput || !widthInput || !depthInput || !gtInput) {
        console.error('One or more required inputs not found');
        return;
    }
    
    const length = parseFloat(lengthInput.value) || 0;
    const width = parseFloat(widthInput.value) || 0;
    const depth = parseFloat(depthInput.value) || 0;
    
    // Debug log to check values
    console.log('Boat dimensions (LxWxD):', {length, width, depth});
    
    // Calculate gross tonnage: (Length × Width × Depth) × 0.45
    const grossTonnage = (length * width * depth) * 0.45;
    
    // Debug log to check calculation
    console.log('Calculated Gross Tonnage:', grossTonnage);
    
    // Update the gross tonnage field, rounded to 2 decimal places
    gtInput.value = grossTonnage.toFixed(2);
    console.log('Gross Tonnage updated to:', gtInput.value);
}
</script>
@endsection

