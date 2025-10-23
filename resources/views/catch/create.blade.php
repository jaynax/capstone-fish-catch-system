@extends('layouts.users.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
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

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        <i class="bx bx-clipboard me-2"></i>BFAR Fish Catch Monitoring Form
                    </h4>
                    <p class="card-subtitle">National Stock Assessment Program (NSAP)</p>
                </div>
                <div class="card-body">
                    <form action="{{ route('catch.store') }}" method="POST" enctype="multipart/form-data" id="catchForm">
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
                        <div class="card mb-4 border-primary">
                            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                <h5 class="mb-0"><i class="bx bx-info-circle me-2"></i>✨ GENERAL INFORMATION</h5>
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
                                                    <input type="text" class="form-control" name="general[0][landing_center]" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Date of Sampling: <span class="text-danger">*</span></label>
                                                    <input type="date" class="form-control" name="general[0][date_sampling]" required>
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
                                                    <label class="form-label">Landing Center: <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="general[0][landing_center]" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Date of Sampling: <span class="text-danger">*</span></label>
                                                    <input type="date" class="form-control" name="general[0][date_sampling]" required>
                                                </div>
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
                        <div class="card mb-4 border-info">
                            <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                                <h5 class="mb-0"><i class="bx bx-ship me-2"></i>🚢 BOAT INFORMATION</h5>
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
                                    <div class="card-body">
                                        <!-- Map Container -->
                                        
                                        
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Boat Name (F/B): <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="boats[0][boat_name]" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Boat Type: <span class="text-danger">*</span></label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="boats[0][boat_type]" value="Motorized" required>
                                                    <label class="form-check-label">☑ Motorized</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="boats[0][boat_type]" value="Non-motorized" required>
                                                    <label class="form-check-label">☑ Non-motorized</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Length (m): <span class="text-danger">*</span></label>
                                                <input type="number" step="0.1" class="form-control" name="boats[0][boat_length]" oninput="calculateGrossTonnage(this)" required>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Width (m): <span class="text-danger">*</span></label>
                                                <input type="number" step="0.1" class="form-control" name="boats[0][boat_width]" oninput="calculateGrossTonnage(this)" required>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Depth (m): <span class="text-danger">*</span></label>
                                                <input type="number" step="0.1" class="form-control" name="boats[0][boat_depth]" oninput="calculateGrossTonnage(this)" required>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Gross Tonnage (GT):</label>
                                                <input type="number" step="0.1" class="form-control" name="boats[0][gross_tonnage]" readonly>
                                                <div class="form-text">Auto-calculated</div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Horsepower (HP):</label>
                                                <input type="number" class="form-control" name="boats[0][horsepower]">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Engine Type:</label>
                                                <input type="text" class="form-control" name="boats[0][engine_type]">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Number of Fishermen on Board: <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" name="boats[0][fishermen_count]" required>
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
                                            <input class="form-check-input" type="radio" name="boat_type" id="motorized" value="Motorized" required>
                                            <label class="form-check-label" for="motorized">☑ Motorized</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="boat_type" id="non_motorized" value="Non-motorized" required>
                                            <label class="form-check-label" for="non_motorized">☑ Non-motorized</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="boat_length" class="form-label">Length (m): <span class="text-danger">*</span></label>
                                        <input type="number" step="0.1" class="form-control" id="boat_length" name="boat_length" oninput="calculateGrossTonnage()" required>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="boat_width" class="form-label">Width (m): <span class="text-danger">*</span></label>
                                        <input type="number" step="0.1" class="form-control" id="boat_width" name="boat_width" oninput="calculateGrossTonnage()" required>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="boat_depth" class="form-label">Depth (m): <span class="text-danger">*</span></label>
                                        <input type="number" step="0.1" class="form-control" id="boat_depth" name="boat_depth" oninput="calculateGrossTonnage()" required>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="gross_tonnage" class="form-label">Gross Tonnage (GT):</label>
                                        <input type="number" step="0.1" class="form-control" id="gross_tonnage" name="gross_tonnage" readonly>
                                        <div class="form-text">Auto-calculated</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="horsepower" class="form-label">Horsepower (HP):</label>
                                        <input type="number" class="form-control" id="horsepower" name="horsepower">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="engine_type" class="form-label">Engine Type:</label>
                                        <input type="text" class="form-control" id="engine_type" name="boats[0][engine_type]">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="fishermen_count" class="form-label">Number of Fishermen on Board: <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="fishermen_count" name="boats[0][fishermen_count]" required>
                                    </div>
                                </div>
                            </div>
                            <!-- End of First Boat Entry -->
                        </div>

                        <!-- 🎯 FISHING OPERATION DETAILS -->
                        <div class="card mb-4 border-success">
                            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                                <h5 class="mb-0"><i class="bx bx-anchor me-2"></i>🎯 FISHING OPERATION DETAILS</h5>
                                <button type="button" id="addFishingOpBtn" class="btn btn-light btn-sm">
                                    <i class="bx bx-plus-circle"></i> Add Operation
                                </button>
                            </div>
                            <div class="card-body" id="fishingOpContainer">
                                <!-- Fishing Operation Entry Template (Hidden) -->
                                <div class="fishing-op-entry card mb-3 border-secondary" style="display: none;">
                                    <div class="card-header py-1 bg-light d-flex justify-content-between align-items-center">
                                        <span class="fw-bold">Operation #<span class="entry-number">1</span></span>
                                        <button type="button" class="btn btn-sm btn-danger remove-fishing-op" title="Remove this operation">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <!-- Map Container -->
                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <label class="form-label">Fishing Location: <span class="text-danger">*</span></label>
                                                <div class="map-container border rounded" style="height: 300px; width: 100%;"></div>
                                                <div class="row mt-2">
                                                    <div class="col-md-6">
                                                        <div class="input-group mb-2">
                                                            <span class="input-group-text">Latitude</span>
                                                            <input type="number" step="0.000001" class="form-control latitude" name="fishing_ops[0][latitude]" placeholder="e.g. 14.5995" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-group mb-2">
                                                            <span class="input-group-text">Longitude</span>
                                                            <input type="number" step="0.000001" class="form-control longitude" name="fishing_ops[0][longitude]" placeholder="e.g. 120.9842" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Fishing Gear Type: <span class="text-danger">*</span></label>
                                                <select class="form-select" name="fishing_ops[0][fishing_gear_type]" required>
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
                                                <div class="map-container" style="height: 300px; margin-bottom: 15px; border-radius: 5px;"></div>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">Latitude</span>
                                                    <input type="number" step="0.000001" class="form-control" name="fishing_ops[0][latitude]" placeholder="e.g. 12.8797">
                                                    <span class="input-group-text">Longitude</span>
                                                    <input type="number" step="0.000001" class="form-control" name="fishing_ops[0][longitude]" placeholder="e.g. 121.7740">
                                                </div>
                                                <input type="hidden" name="fishing_ops[0][fishing_location]">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Payao Used?</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="fishing_ops[0][payao_used]" value="Yes">
                                                    <label class="form-check-label">☑ Yes</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="fishing_ops[0][payao_used]" value="No">
                                                    <label class="form-check-label">☑ No</label>
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
                                                <select class="form-select" name="fishing_ops[0][fishing_gear_type]" required>
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
                                            <div class="col-md-6 mb-3">
                                        <label for="fishing_location" class="form-label">Fishing Location (Click on the map or enter coordinates):</label>
                                        <div id="map" style="height: 300px; margin-bottom: 15px; border-radius: 5px; border: 1px solid #dee2e6;"></div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text"><i class="bx bx-navigation"></i> Latitude</span>
                                            <input type="number" step="0.000001" class="form-control" id="latitude" name="latitude" placeholder="e.g. 12.8797">
                                            <span class="input-group-text"><i class="bx bx-navigation"></i> Longitude</span>
                                            <input type="number" step="0.000001" class="form-control" id="longitude" name="longitude" placeholder="e.g. 121.7740">
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <button type="button" id="useCurrentLocation" class="btn btn-sm btn-outline-primary">
                                                <i class="bx bx-current-location"></i> Use My Location
                                            </button>
                                            <small class="text-muted">Click on the map or enter coordinates manually</small>
                                        </div>
                                        <input type="hidden" id="fishing_location" name="fishing_location">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Payao Used?</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="payao_used" id="payao_yes" value="Yes">
                                            <label class="form-check-label" for="payao_yes">☑ Yes</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="payao_used" id="payao_no" value="No">
                                            <label class="form-check-label" for="payao_no">☑ No</label>
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
                        <div class="card mb-4 border-warning">
                            <div class="card-header bg-warning text-white d-flex justify-content-between align-items-center">
                                <h5 class="mb-0"><i class="bx bx-weight me-2"></i>⚖️ CATCH INFORMATION</h5>
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
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="catches[0][catch_type]" value="Complete" required>
                                                    <label class="form-check-label">☑ Complete</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="catches[0][catch_type]" value="Incomplete" required>
                                                    <label class="form-check-label">☑ Incomplete</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="catches[0][catch_type]" value="Partly Sold" required>
                                                    <label class="form-check-label">☑ Partly Sold</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Total Catch (kg): <span class="text-danger">*</span></label>
                                                <input type="number" step="0.1" class="form-control" name="catches[0][total_catch_kg]" required>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Sub-sample Taken?</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="catches[0][subsample_taken]" value="Yes">
                                                    <label class="form-check-label">☑ Yes</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="catches[0][subsample_taken]" value="No">
                                                    <label class="form-check-label">☑ No</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Sub-sample Weight (kg):</label>
                                                <input type="number" step="0.1" class="form-control" name="catches[0][subsample_weight]">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Were any fish below legal size?</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="catches[0][below_legal_size]" value="Yes">
                                                    <label class="form-check-label">☑ Yes</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="catches[0][below_legal_size]" value="No">
                                                    <label class="form-check-label">☑ No</label>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">If Yes, which species:</label>
                                                <input type="text" class="form-control" name="catches[0][below_legal_species]">
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
                                                    <input class="form-check-input" type="radio" name="catches[0][catch_type]" value="Complete" required>
                                                    <label class="form-check-label">☑ Complete</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="catches[0][catch_type]" value="Incomplete" required>
                                                    <label class="form-check-label">☑ Incomplete</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="catches[0][catch_type]" value="Partly Sold" required>
                                                    <label class="form-check-label">☑ Partly Sold</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Total Catch (kg): <span class="text-danger">*</span></label>
                                                <input type="number" step="0.1" class="form-control" name="catches[0][total_catch_kg]" required>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Sub-sample Taken?</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="catches[0][subsample_taken]" value="Yes">
                                                    <label class="form-check-label">☑ Yes</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="catches[0][subsample_taken]" value="No">
                                                    <label class="form-check-label">☑ No</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Sub-sample Weight (kg):</label>
                                                <input type="number" step="0.1" class="form-control" name="catches[0][subsample_weight]">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Were any fish below legal size?</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="catches[0][below_legal_size]" value="Yes">
                                                    <label class="form-check-label">☑ Yes</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="catches[0][below_legal_size]" value="No">
                                                    <label class="form-check-label">☑ No</label>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">If Yes, which species:</label>
                                                <input type="text" class="form-control" name="catches[0][below_legal_species]">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 📏 LENGTH FREQUENCY MEASUREMENT -->
                        
                        <!-- AI Species Recognition Section -->
                        <div class="card mb-4 border-danger">
                            <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
                                <h5 class="mb-0"><i class="bx bx-brain me-2"></i> SPECIES RECOGNITION & SIZE ESTIMATION</h5>
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
                                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                            <button type="button" class="btn btn-primary" id="cameraBtn">
                                                <i class="bx bx-camera me-1"></i>Take Photo
                                            </button>
                                        </div>
                                        <div class="form-text">Upload clear photos or take a photo using your camera for AI species recognition and size estimation</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div id="imagePreview" class="mt-2" style="display: none;">
                                            <img id="preview" src="" alt="Preview" class="img-fluid rounded" style="max-height: 200px;">
                                            <div id="detectionOverlay" class="mt-2" style="display: none;">
                                                <small class="text-info"><i class="bx bx-target me-1"></i>Fish detected and cropped</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Camera Modal -->
                                <div class="modal fade" id="cameraModal" tabindex="-1" aria-labelledby="cameraModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="cameraModalLabel">
                                                    <i class="bx bx-camera me-2"></i>Take Fish Photo
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-12 text-center mb-3">
                                                        <video id="cameraVideo" autoplay playsinline style="width: 100%; max-width: 640px; border-radius: 8px;"></video>
                                                    </div>
                                                    <div class="col-12 text-center">
                                                        <canvas id="cameraCanvas" style="display: none;"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    <i class="bx bx-x me-1"></i>Cancel
                                                </button>
                                                <button type="button" class="btn btn-primary" id="captureBtn">
                                                    <i class="bx bx-camera me-1"></i>Capture Photo
                                                </button>
                                                <button type="button" class="btn btn-success" id="usePhotoBtn" style="display: none;">
                                                    <i class="bx bx-check me-1"></i>Use This Photo
                                                </button>
                                                <button type="button" class="btn btn-warning" id="retakeBtn" style="display: none;">
                                                    <i class="bx bx-refresh me-1"></i>Retake
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- AI Prediction Results -->
                                <div class="row mt-3">
                                    <div class="col-md-3 mb-3">
                                        <label for="species" class="form-label">Species (CNN + MobileNetV2): <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="species" name="species" required>
                                        <div class="form-text">Auto-detected by CNN + MobileNetV2</div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="scientific_name" class="form-label">Scientific Name:</label>
                                        <input type="text" class="form-control" id="scientific_name" name="scientific_name">
                                        <div class="form-text">Auto-filled from species database</div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="length_cm" class="form-label">Length (cm) - YOLOv8 + OpenCV: <span class="text-danger">*</span></label>
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

                        <!-- Submit Button -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bx bx-save me-2"></i>Submit Fish Catch Report
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

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

<!-- Your existing content -->
<div id="map"></div>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
    crossorigin=""></script>

<script>
// Wait for the DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Check if map container exists
    const mapElement = document.getElementById('map');
    if (!mapElement) return;
    
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
    const mapContainer = boatElement.querySelector('.map-container');
    if (!mapContainer) return;
    
    // Create a unique ID for the map container
    const mapId = 'map-' + index + '-' + Date.now();
    mapContainer.id = mapId;
    
    // Initialize the map
    const map = L.map(mapId).setView([12.8797, 121.7740], 10);
    
    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
    
    // Get the latitude and longitude inputs for this boat
    const latInput = boatElement.querySelector('.latitude');
    const lngInput = boatElement.querySelector('.longitude');
    
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
        const lat = parseFloat(latInput?.value) || 12.8797;
        const lng = parseFloat(lngInput?.value) || 121.7740;
        updateMarker(lat, lng);
    };
    
    // Handle map click
    map.on('click', function(e) {
        if (latInput && lngInput) {
            latInput.value = e.latlng.lat.toFixed(6);
            lngInput.value = e.latlng.lng.toFixed(6);
            updateMarker(e.latlng.lat, e.latlng.lng);
        }
    });
    
    // Initialize with default values
    updateFromInputs();
    
    // Update map when inputs change
    if (latInput && lngInput) {
        latInput.addEventListener('change', updateFromInputs);
        lngInput.addEventListener('change', updateFromInputs);
    }
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
                removeBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (document.querySelectorAll('.boat-entry').length > 1) {
                        newBoat.remove();
                        updateBoatNumbers();
                    }
                });
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
    });
    return opEntries.length - 1;
}

// Add Fishing Operation Functionality
document.addEventListener('DOMContentLoaded', function() {
    const addFishingOpBtn = document.getElementById('addFishingOpBtn');
    const fishingOpContainer = document.getElementById('fishingOpContainer');
    const fishingOpTemplate = document.querySelector('.fishing-op-entry[style*="display: none"]');
    let fishingOpCount = 0;

    // Show remove button for the first fishing op entry
    const firstFishingOpEntry = document.querySelector('.fishing-op-entry:not([style*="display: none"])');
    if (firstFishingOpEntry) {
        const firstRemoveBtn = firstFishingOpEntry.querySelector('.remove-fishing-op');
        if (firstRemoveBtn) {
            firstRemoveBtn.style.display = 'inline-block';
            firstRemoveBtn.addEventListener('click', function(e) {
                e.preventDefault();
                if (document.querySelectorAll('.fishing-op-entry').length > 1) {
                    this.closest('.fishing-op-entry').remove();
                    updateFishingOpNumbers();
                }
            });
        }
        
        // Set initial fishing op count
        fishingOpCount = document.querySelectorAll('.fishing-op-entry').length - 1;
    }

    if (addFishingOpBtn && fishingOpTemplate) {
        addFishingOpBtn.addEventListener('click', function() {
            fishingOpCount++;

            // Clone the hidden template
            const newOp = fishingOpTemplate.cloneNode(true);
            newOp.style.display = 'block';

            // Update all input names and IDs for the new fishing op
            newOp.querySelectorAll('input, select, textarea, label').forEach((element) => {
                // Update input/select/textarea elements
                if (element.name) {
                    element.name = element.name.replace(/\[\d+\]/g, `[${fishingOpCount}]`);
                    
                    // Clear the value for the new entry
                    if (element.type !== 'radio' && element.type !== 'checkbox' && !element.readOnly) {
                        element.value = '';
                    } else if (element.type === 'radio' || element.type === 'checkbox') {
                        element.checked = false;
                    }
                }
                
                // Update IDs and for attributes
                if (element.id) {
                    const newId = element.id + '_' + fishingOpCount;
                    element.id = newId;
                    
                    // Update 'for' attributes in labels
                    if (element.tagName === 'LABEL' && element.htmlFor) {
                        element.htmlFor = newId;
                    }
                }
            });

            // Update entry number
            const entryNumber = newOp.querySelector('.entry-number');
            if (entryNumber) {
                entryNumber.textContent = fishingOpCount + 1;
            }

            // Add remove event
            const removeBtn = newOp.querySelector('.remove-fishing-op');
            if (removeBtn) {
                removeBtn.style.display = 'inline-block';
                removeBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (document.querySelectorAll('.fishing-op-entry').length > 1) {
                        newOp.remove();
                        updateFishingOpNumbers();
                    }
                });
            }

            // Add the new fishing op to the container
            fishingOpContainer.appendChild(newOp);
            
            // Update fishing op numbers
            fishingOpCount = updateFishingOpNumbers();
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
    }

});

// Function to calculate Gross Tonnage based on boat dimensions
function calculateGrossTonnage(input) {
    // Debug log to check if function is called
    console.log('calculateGrossTonnage called');
    
    // Get the parent boat entry
    const boatEntry = input.closest('.boat-entry');
    
    // Debug log to check boat entry
    console.log('Boat entry found:', boatEntry);
    
    // Get all the dimension inputs
    const lengthInput = boatEntry.querySelector('input[name$="[boat_length]"]');
    const widthInput = boatEntry.querySelector('input[name$="[boat_width]"]');
    const depthInput = boatEntry.querySelector('input[name$="[boat_depth]"]');
    const gtInput = boatEntry.querySelector('input[name$="[gross_tonnage]"]');
    
    // Debug logs to check inputs
    console.log('Inputs found:', {lengthInput, widthInput, depthInput, gtInput});
    
    // Get the values as numbers
    const length = parseFloat(lengthInput.value) || 0;
    const width = parseFloat(widthInput.value) || 0;
    const depth = parseFloat(depthInput.value) || 0;
    
    // Debug log to check values
    console.log('Values:', {length, width, depth});
    
    // Calculate gross tonnage: (Length × Width × Depth) × 0.45
    const grossTonnage = (length * width * depth) * 0.45;
    
    // Debug log to check calculation
    console.log('Calculated GT:', grossTonnage);
    
    // Update the gross tonnage field, rounded to 2 decimal places
    if (gtInput) {
        gtInput.value = grossTonnage.toFixed(2);
        console.log('GT Input updated:', gtInput.value);
    } else {
        console.error('GT input not found');
    }
}
</script>
@endsection 