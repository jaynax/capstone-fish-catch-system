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
                                <button type="button" class="btn btn-sm btn-light" id="addGeneralInfo">
                                    <i class="bx bx-plus"></i> Add Location
                                </button>
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
                            <div class="card-body border-top">
                                <h6 class="mb-3"><i class="bx bx-map me-2"></i>Location Information</h6>
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
                                <button type="button" class="btn btn-sm btn-light" id="addBoatInfo">
                                    <i class="bx bx-plus"></i> Add Boat
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
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="boat_name" class="form-label">Boat Name (F/B): <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="boat_name" name="boat_name" required>
                                    </div>
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
                                        <input type="text" class="form-control" id="engine_type" name="engine_type">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="fishermen_count" class="form-label">Number of Fishermen on Board: <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="fishermen_count" name="fishermen_count" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 🎯 FISHING OPERATION DETAILS -->
                        <div class="card mb-4 border-success">
                            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                                <h5 class="mb-0"><i class="bx bx-anchor me-2"></i>🎯 FISHING OPERATION DETAILS</h5>
                                <button type="button" class="btn btn-sm btn-light" id="addFishingOp">
                                    <i class="bx bx-plus"></i> Add Operation
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
                                <!-- End of Template -->
                                
                                <!-- Initial Visible Entry -->
                                <div class="fishing-op-entry card mb-3 border-secondary">
                                    <div class="card-header py-1 bg-light d-flex justify-content-between align-items-center">
                                        <span class="fw-bold">Operation #<span class="entry-number">1</span></span>
                                        <button type="button" class="btn btn-sm btn-danger remove-fishing-op d-none" title="Remove this operation">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </div>
                                    <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="fishing_gear_type" class="form-label">Fishing Gear Type: <span class="text-danger">*</span></label>
                                        <select class="form-select" id="fishing_gear_type" name="fishing_gear_type" required>
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
                                        <label for="gear_specifications" class="form-label">Specifications:</label>
                                        <textarea class="form-control" id="gear_specifications" name="gear_specifications" rows="2"></textarea>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="hooks_hauls" class="form-label">Number of Hooks/Hauls:</label>
                                        <input type="number" class="form-control" id="hooks_hauls" name="hooks_hauls">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="net_line_length" class="form-label">Net/Line Length (m):</label>
                                        <input type="number" step="0.1" class="form-control" id="net_line_length" name="net_line_length">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="soaking_time" class="form-label">Soaking/Fishing Time (hrs):</label>
                                        <input type="number" step="0.1" class="form-control" id="soaking_time" name="soaking_time">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="mesh_size" class="form-label">Mesh Size (cm):</label>
                                        <input type="number" step="0.1" class="form-control" id="mesh_size" name="mesh_size">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="days_fished" class="form-label">Number of Days Fished: <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="days_fished" name="days_fished" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="fishing_location" class="form-label">Fishing Location (Click on the map or enter coordinates):</label>
                                        <div id="map" style="height: 300px; margin-bottom: 15px; border-radius: 5px;"></div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">Latitude</span>
                                            <input type="number" step="0.000001" class="form-control" id="latitude" name="latitude" placeholder="e.g. 12.8797">
                                            <span class="input-group-text">Longitude</span>
                                            <input type="number" step="0.000001" class="form-control" id="longitude" name="longitude" placeholder="e.g. 121.7740">
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
                                <button type="button" class="btn btn-sm btn-light" id="addCatchInfo">
                                    <i class="bx bx-plus"></i> Add Catch
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
                            </div>
                        </div>

                        <!-- 📏 LENGTH FREQUENCY MEASUREMENT -->
                        
                        <!-- AI Species Recognition Section -->
                        <div class="card mb-4 border-danger">
                            <div class="card-header bg-danger text-white">
                                <h5 class="mb-0"><i class="bx bx-brain me-2"></i> SPECIES RECOGNITION & SIZE ESTIMATION</h5>
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
                                            <span id="errorText">Error processing image. Please try again.</span>
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
<!-- Leaflet JavaScript -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
    crossorigin=""></script>

<script>
// Initialize the map centered on the Philippines
const map = L.map('map').setView([12.8797, 121.7740], 6);

// Add OpenStreetMap tiles
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    maxZoom: 19
}).addTo(map);

// Add a marker that can be dragged
let marker = null;

// Function to update the marker position
function updateMarker(lat, lng) {
    // Remove existing marker if any
    if (marker) {
        map.removeLayer(marker);
    }
    
    // Add new marker
    marker = L.marker([lat, lng], {draggable: true}).addTo(map);
    
    // Update coordinates when marker is dragged
    marker.on('dragend', function(e) {
        const position = marker.getLatLng();
        updateCoordinateInputs(position.lat, position.lng);
    });
    
    // Center the map on the marker
    map.setView([lat, lng], map.getZoom());
    
    // Update the hidden input field
    document.getElementById('fishing_location').value = `${lat}, ${lng}`;
}

// Function to update coordinate input fields
function updateCoordinateInputs(lat, lng) {
    document.getElementById('latitude').value = lat.toFixed(6);
    document.getElementById('longitude').value = lng.toFixed(6);
    document.getElementById('fishing_location').value = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
}

// Add click event to the map
map.on('click', function(e) {
    const lat = e.latlng.lat;
    const lng = e.latlng.lng;
    updateMarker(lat, lng);
    updateCoordinateInputs(lat, lng);
});

// Update marker when coordinates are manually entered
function updateFromInputs() {
    const lat = parseFloat(document.getElementById('latitude').value);
    const lng = parseFloat(document.getElementById('longitude').value);
    
    if (!isNaN(lat) && !isNaN(lng)) {
        updateMarker(lat, lng);
    }
}

// Add event listeners to coordinate inputs
document.getElementById('latitude').addEventListener('change', updateFromInputs);
document.getElementById('longitude').addEventListener('change', updateFromInputs);

// Add a scale control
L.control.scale().addTo(map);

// Add a default marker if coordinates are already set
window.addEventListener('load', function() {
    const latInput = document.getElementById('latitude');
    const lngInput = document.getElementById('longitude');
    
    if (latInput.value && lngInput.value) {
        updateMarker(parseFloat(latInput.value), parseFloat(lngInput.value));
    }
});

let lengthRowCount = 1;
let stream = null;
let capturedImage = null;
let isAutoMode = true;

// Mode toggle functionality
document.getElementById('autoModeToggle').addEventListener('change', function() {
    isAutoMode = this.checked;
    updateModeUI();
});

// Update UI based on mode
// Calculate Gross Tonnage based on boat dimensions (L x W x D x 0.45)
function calculateGrossTonnage() {
    const length = parseFloat(document.getElementById('boat_length').value) || 0;
    const width = parseFloat(document.getElementById('boat_width').value) || 0;
    const depth = parseFloat(document.getElementById('boat_depth').value) || 0;
    
    if (length > 0 && width > 0 && depth > 0) {
        const grossTonnage = (length * width * depth) * 0.45;
        document.getElementById('gross_tonnage').value = grossTonnage.toFixed(2);
    } else {
        document.getElementById('gross_tonnage').value = '';
    }
}

function updateModeUI() {
    const speciesField = document.getElementById('species');
    const scientificNameField = document.getElementById('scientific_name');
    const lengthField = document.getElementById('length_cm');
    const weightField = document.getElementById('weight_g');
    const confidenceField = document.getElementById('confidence_score');
    const detectionConfidenceField = document.getElementById('detection_confidence');
    const bboxWidthField = document.getElementById('bbox_width');
    const bboxHeightField = document.getElementById('bbox_height');
    const pixelsPerCmField = document.getElementById('pixels_per_cm');
    const modeLabel = document.getElementById('modeLabel');
    const imageField = document.getElementById('image');
    const cameraBtn = document.getElementById('cameraBtn');
    const imageRequiredSpan = document.getElementById('imageRequired');

    if (isAutoMode) {
        // Automatic mode - fields are readonly, AI processing enabled
        modeLabel.textContent = 'Automatic AI Processing';
        speciesField.readOnly = true;
        scientificNameField.readOnly = true;
        lengthField.readOnly = true;
        weightField.readOnly = true;
        confidenceField.readOnly = true;
        detectionConfidenceField.readOnly = true;
        bboxWidthField.readOnly = true;
        bboxHeightField.readOnly = true;
        pixelsPerCmField.readOnly = true;
        
        // Enable image upload and camera
        imageField.disabled = false;
        cameraBtn.disabled = false;
        imageRequiredSpan.textContent = '*'; // Show required asterisk
        imageField.required = true; // Make image required in automatic mode
        
        // Update field descriptions
        updateFieldDescriptions(true);
        
    } else {
        // Manual mode - fields are editable, AI processing disabled
        modeLabel.textContent = 'Manual Input Mode';
        speciesField.readOnly = false;
        scientificNameField.readOnly = false;
        lengthField.readOnly = false;
        weightField.readOnly = false;
        confidenceField.readOnly = true;
        detectionConfidenceField.readOnly = true;
        bboxWidthField.readOnly = true;
        bboxHeightField.readOnly = true;
        pixelsPerCmField.readOnly = true;
        
        // Disable image upload and camera
        imageField.disabled = true;
        cameraBtn.disabled = true;
        imageRequiredSpan.textContent = ''; // Hide required asterisk
        imageField.required = false; // Make image not required in manual mode
        
        // Clear AI-generated fields
        confidenceField.value = '';
        detectionConfidenceField.value = '';
        bboxWidthField.value = '';
        bboxHeightField.value = '';
        pixelsPerCmField.value = '';
        
        // Update field descriptions
        updateFieldDescriptions(false);
    }
}

// Update field descriptions based on mode
function updateFieldDescriptions(isAuto) {
    const speciesDesc = document.querySelector('label[for="species"] + .form-text');
    const scientificDesc = document.querySelector('label[for="scientific_name"] + .form-text');
    const lengthDesc = document.querySelector('label[for="length_cm"] + .form-text');
    const weightDesc = document.querySelector('label[for="weight_g"] + .form-text');
    
    if (isAuto) {
        speciesDesc.textContent = 'Auto-detected by CNN + MobileNetV2';
        scientificDesc.textContent = 'Auto-filled from species database';
        lengthDesc.textContent = 'Auto-estimated using YOLOv8 detection + OpenCV measurement';
        weightDesc.textContent = 'Calculated from length using fish weight formulas';
    } else {
        speciesDesc.textContent = 'Enter fish species manually';
        scientificDesc.textContent = 'Enter scientific name manually';
        lengthDesc.textContent = 'Enter fish length manually (cm)';
        weightDesc.textContent = 'Enter fish weight manually (g)';
    }
}

// Camera functionality
document.getElementById('cameraBtn').addEventListener('click', function() {
    if (isAutoMode) {
        openCamera();
    } else {
        alert('Camera is disabled in manual mode. Please switch to automatic mode to use camera.');
    }
});

document.getElementById('captureBtn').addEventListener('click', function() {
    capturePhoto();
});

document.getElementById('usePhotoBtn').addEventListener('click', function() {
    useCapturedPhoto();
});

document.getElementById('retakeBtn').addEventListener('click', function() {
    retakePhoto();
});

// Open camera
function openCamera() {
    const modal = new bootstrap.Modal(document.getElementById('cameraModal'));
    modal.show();
    
    navigator.mediaDevices.getUserMedia({ 
        video: { 
            facingMode: 'environment', // Use back camera on mobile
            width: { ideal: 1280 },
            height: { ideal: 720 }
        } 
    })
    .then(function(mediaStream) {
        stream = mediaStream;
        const video = document.getElementById('cameraVideo');
        video.srcObject = mediaStream;
        
        // Show capture button
        document.getElementById('captureBtn').style.display = 'inline-block';
        document.getElementById('usePhotoBtn').style.display = 'none';
        document.getElementById('retakeBtn').style.display = 'none';
    })
    .catch(function(error) {
        console.error('Camera access error:', error);
        alert('Unable to access camera. Please check camera permissions and try again.');
    });
}

// Capture photo
function capturePhoto() {
    const video = document.getElementById('cameraVideo');
    const canvas = document.getElementById('cameraCanvas');
    const context = canvas.getContext('2d');
    
    // Set canvas size to match video
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    
    // Draw video frame to canvas
    context.drawImage(video, 0, 0, canvas.width, canvas.height);
    
    // Convert canvas to blob
    canvas.toBlob(function(blob) {
        capturedImage = blob;
        
        // Show captured image
        const img = document.createElement('img');
        img.src = URL.createObjectURL(blob);
        img.style.width = '100%';
        img.style.maxWidth = '640px';
        img.style.borderRadius = '8px';
        
        // Replace video with captured image
        const videoContainer = document.querySelector('#cameraModal .modal-body .col-12:first-child');
        videoContainer.innerHTML = '';
        videoContainer.appendChild(img);
        
        // Show use/retake buttons
        document.getElementById('captureBtn').style.display = 'none';
        document.getElementById('usePhotoBtn').style.display = 'inline-block';
        document.getElementById('retakeBtn').style.display = 'inline-block';
        
        // Stop camera stream
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
        }
    }, 'image/jpeg', 0.8);
}

// Use captured photo
function useCapturedPhoto() {
    if (capturedImage) {
        // Create a File object from the blob
        const file = new File([capturedImage], 'fish_photo.jpg', { type: 'image/jpeg' });
        
        // Set the file input
        const fileInput = document.getElementById('image');
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        fileInput.files = dataTransfer.files;
        
        // Trigger the change event to process the image
        const event = new Event('change', { bubbles: true });
        fileInput.dispatchEvent(event);
        
        // Close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('cameraModal'));
        modal.hide();
    }
}

// Retake photo
function retakePhoto() {
    // Reset modal content
    const modalBody = document.querySelector('#cameraModal .modal-body');
    modalBody.innerHTML = `
        <div class="row">
            <div class="col-12 text-center mb-3">
                <video id="cameraVideo" autoplay playsinline style="width: 100%; max-width: 640px; border-radius: 8px;"></video>
            </div>
            <div class="col-12 text-center">
                <canvas id="cameraCanvas" style="display: none;"></canvas>
            </div>
        </div>
    `;
    
    // Reopen camera
    openCamera();
}

// Clean up camera when modal is closed
document.getElementById('cameraModal').addEventListener('hidden.bs.modal', function() {
    if (stream) {
        stream.getTracks().forEach(track => track.stop());
        stream = null;
    }
    capturedImage = null;
});

// Image preview and AI prediction
document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview').src = e.target.result;
            document.getElementById('imagePreview').style.display = 'block';
        };
        reader.readAsDataURL(file);

        // Only process with AI if in automatic mode
        if (isAutoMode) {
            // Show processing status
            showProcessingStatus('Initializing AI models (CNN + MobileNetV2, YOLOv8, OpenCV)...');

            // Auto-trigger AI prediction
            const formData = new FormData();
            formData.append('image', file);

            fetch('/predict', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Hide processing status and show completion
                hideProcessingStatus();
                showProcessingComplete();

                // Update species recognition results (CNN + MobileNetV2)
                if (data.species) {
                    document.getElementById('species').value = data.species;
                }
                if (data.scientific_name) {
                    document.getElementById('scientific_name').value = data.scientific_name;
                }
                if (data.confidence_score) {
                    document.getElementById('confidence_score').value = data.confidence_score + '%';
                }

                // Update size estimation results (YOLOv8 + OpenCV)
                if (data.length_cm) {
                    document.getElementById('length_cm').value = data.length_cm;
                }
                if (data.weight_g) {
                    document.getElementById('weight_g').value = data.weight_g;
                }
                if (data.detection_confidence) {
                    document.getElementById('detection_confidence').value = data.detection_confidence + '%';
                }

                // Update bounding box details (YOLOv8 detection)
                if (data.bbox_width) {
                    document.getElementById('bbox_width').value = data.bbox_width;
                }
                if (data.bbox_height) {
                    document.getElementById('bbox_height').value = data.bbox_height;
                }
                if (data.pixels_per_cm) {
                    document.getElementById('pixels_per_cm').value = data.pixels_per_cm;
                }

                // Show detection overlay
                document.getElementById('detectionOverlay').style.display = 'block';

                // Auto-fill species breakdown if available
                if (data.species && data.scientific_name) {
                    // Update the first species row in the breakdown table if it exists
                    const firstSpeciesRow = document.querySelector('input[name="species[0][scientific_name]"]');
                    if (firstSpeciesRow) {
                        firstSpeciesRow.value = data.scientific_name;
                    }
                    const firstCommonNameRow = document.querySelector('input[name="species[0][common_name]"]');
                    if (firstCommonNameRow) {
                        firstCommonNameRow.value = data.species;
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                hideProcessingStatus();
                showProcessingError('Failed to process image. Please check your connection and try again.');
            });
        } else {
            // Manual mode - just show image preview
            document.getElementById('detectionOverlay').style.display = 'none';
        }
    }
});

// Show processing status
function showProcessingStatus(message) {
    document.getElementById('processingStatus').style.display = 'block';
    document.getElementById('statusText').textContent = message;
    document.getElementById('processingComplete').style.display = 'none';
    document.getElementById('processingError').style.display = 'none';
}

// Hide processing status
function hideProcessingStatus() {
    document.getElementById('processingStatus').style.display = 'none';
}

// Show processing complete
// Function to clone and update form fields with new indices
function cloneAndUpdateFields(container, entryClass, namePrefix, entryIndex) {
    const entries = container.querySelectorAll(`.${entryClass}:not([style*="display: none"])`);
    const template = container.querySelector(`.${entryClass}`);
    const newEntry = template.cloneNode(true);
    
    // Update the entry number display if exists
    const numberDisplay = newEntry.querySelector('.entry-number');
    if (numberDisplay) {
        numberDisplay.textContent = entries.length + 1;
    }
    
    // Update all input names with the new index
    const inputs = newEntry.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        if (input.name) {
            input.name = input.name.replace(new RegExp(`${namePrefix}\\[\\d+\\]`, 'g'), `${namePrefix}[${entryIndex}]`);
            // Reset radio/checkbox states for the new entry
            if (input.type === 'radio' || input.type === 'checkbox') {
                input.checked = false;
            } else if (input.type !== 'button' && input.type !== 'submit') {
                input.value = '';
            }
        }
    });
    
    // Make the new entry visible
    newEntry.style.display = 'block';
    
    // Add the new entry before the template
    container.insertBefore(newEntry, template);
    
    return newEntry;
}

// Function to add new catch information fields
function addCatchInfo() {
    const container = document.getElementById('catchInfoContainer');
    const entries = container.querySelectorAll('.catch-entry:not([style*="display: none"])');
    const newEntry = cloneAndUpdateFields(container, 'catch-entry', 'catches', entries.length);
    
    // Update the catch number display
    newEntry.querySelector('.catch-number').textContent = entries.length + 1;
    
    // Enable remove button if there's more than one entry
    updateRemoveButtons();
}

// Function to remove a catch entry
function removeCatchEntry(button) {
    const entry = button.closest('.catch-entry');
    if (document.querySelectorAll('.catch-entry:not([style*="display: none"])').length <= 1) {
        // Don't remove the last entry
        return;
    }
    entry.remove();
    
    // Update catch numbers and input names
    updateCatchNumbers();
    updateRemoveButtons();
}

// Update catch numbers and input names after removal
function updateCatchNumbers() {
    const entries = document.querySelectorAll('.catch-entry:not([style*="display: none"])');
    entries.forEach((entry, index) => {
        // Update the catch number display
        entry.querySelector('.catch-number').textContent = index + 1;
        
        // Update all input names with the new index
        const inputs = entry.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            if (input.name) {
                input.name = input.name.replace(/catches\[\d+\]/g, `catches[${index}]`);
            }
        });
    });
}

// Show/hide remove buttons based on number of entries
function updateRemoveButtons() {
    const entries = document.querySelectorAll('.catch-entry:not([style*="display: none"])');
    const removeButtons = document.querySelectorAll('.remove-catch');
    
    // Show remove buttons only if there's more than one entry
    removeButtons.forEach(button => {
        button.style.visibility = entries.length > 1 ? 'visible' : 'hidden';
    });
}

// Initialize the first catch entry
document.addEventListener('DOMContentLoaded', function() {
    // Add click event for adding new catch info
    document.getElementById('addCatchInfo').addEventListener('click', addCatchInfo);
    
    // Add click event for removing catch info (using event delegation)
    document.getElementById('catchInfoContainer').addEventListener('click', function(e) {
        if (e.target.closest('.remove-catch')) {
            removeCatchEntry(e.target.closest('.remove-catch'));
        }
    });
    
    // Add the first catch entry
    addCatchInfo();
});

function showProcessingComplete() {
    document.getElementById('processingComplete').style.display = 'block';
    setTimeout(() => {
        document.getElementById('processingComplete').style.display = 'none';
    }, 5000);
}

// Show processing error
function showProcessingError(message) {
    document.getElementById('processingError').style.display = 'block';
    document.getElementById('errorText').textContent = message;
    setTimeout(() => {
        document.getElementById('processingError').style.display = 'none';
    }, 8000);
}

// Add length row
function addLengthRow() {
    const tbody = document.getElementById('lengthTableBody');
    const newRow = tbody.insertRow();
    newRow.innerHTML = `
        <td>${lengthRowCount + 1}</td>
        <td><input type="number" step="0.1" class="form-control" name="lengths[${lengthRowCount}]" placeholder="Length"></td>
        <td><button type="button" class="btn btn-sm btn-danger" onclick="removeLengthRow(this)">Remove</button></td>
    `;
    lengthRowCount++;
}

// Remove length row
function removeLengthRow(button) {
    button.closest('tr').remove();
}

// Auto-fill current date and initialize mode
// Initialize plus button event listeners
function initPlusButtons() {
    // Add catch info
    document.getElementById('addCatchInfo')?.addEventListener('click', addCatchInfo);
    
    // Add general info
    document.getElementById('addGeneralInfo')?.addEventListener('click', addGeneralInfo);
    
    // Add boat info
    document.getElementById('addBoatInfo')?.addEventListener('click', addBoatInfo);
    
    // Add fishing operation
    document.getElementById('addFishingOp')?.addEventListener('click', addFishingOp);
    const container = document.getElementById('fishingOpContainer');
    const entries = container.querySelectorAll('.fishing-op-entry:not([style*="display: none"])');
    const newEntry = cloneAndUpdateFields(container, 'fishing-op-entry', 'fishing_ops', entries.length);
    
    // Update the entry number display
    newEntry.querySelector('.entry-number').textContent = entries.length + 1;
}

// Function to add new fishing operation entry
function addFishingOp() {
    const container = document.getElementById('fishingOpContainer');
    const entries = container.querySelectorAll('.fishing-op-entry:not([style*="display: none"])');
    const newEntry = cloneAndUpdateFields(container, 'fishing-op-entry', 'fishing_ops', entries.length);
    
    // Update the entry number display
    newEntry.querySelector('.entry-number').textContent = entries.length + 1;
    
    // Initialize map for this entry
    const mapContainer = newEntry.querySelector('.map-container');
    if (mapContainer) {
        // Create a new map instance for this entry
        const latitudeInput = newEntry.querySelector('input[name$="[latitude]"]');
        const longitudeInput = newEntry.querySelector('input[name$="[longitude]"]');
        const locationInput = newEntry.querySelector('input[name$="[fishing_location]"]');
        
        // Add a unique ID to the map container
        const mapId = 'map-' + Date.now();
        mapContainer.id = mapId;
        
        // Initialize map after a small delay to ensure DOM is ready
        setTimeout(() => {
            const map = L.map(mapId).setView([12.8797, 121.7740], 5);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);
            
            let marker = null;
            
            // Add click event to set location
            map.on('click', function(e) {
                if (marker) {
                    map.removeLayer(marker);
                }
                
                marker = L.marker(e.latlng).addTo(map);
                if (latitudeInput) latitudeInput.value = e.latlng.lat.toFixed(6);
                if (longitudeInput) longitudeInput.value = e.latlng.lng.toFixed(6);
                if (locationInput) locationInput.value = `${e.latlng.lat.toFixed(6)}, ${e.latlng.lng.toFixed(6)}`;
            });
            
            // Update location when coordinates are manually entered
            const updateMarker = () => {
                const lat = parseFloat(latitudeInput?.value);
                const lng = parseFloat(longitudeInput?.value);
                
                if (!isNaN(lat) && !isNaN(lng)) {
                    if (marker) {
                        map.removeLayer(marker);
                    }
                    const latLng = L.latLng(lat, lng);
                    marker = L.marker(latLng).addTo(map);
                    map.setView(latLng, Math.max(map.getZoom(), 10));
                    if (locationInput) locationInput.value = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
                }
            };
            
            if (latitudeInput && longitudeInput) {
                latitudeInput.addEventListener('change', updateMarker);
                longitudeInput.addEventListener('change', updateMarker);
            }
        }, 100);
    }
    
    // Enable remove button if there's more than one entry
    updateRemoveButtons('.fishing-op-entry', '.remove-fishing-op');
}

// Function to add new fishing operation entry
function addFishingOp() {
    const container = document.getElementById('fishingOpContainer');
    const entries = container.querySelectorAll('.fishing-op-entry:not([style*="display: none"])');
    const template = container.querySelector('.fishing-op-entry[style*="display: none"]');
    
    if (!template) return;
    
    const newEntry = template.cloneNode(true);
    const entryIndex = entries.length;
    
    // Update the entry number
    newEntry.querySelector('.entry-number').textContent = entryIndex + 1;
    
    // Update all input names with the new index
    const inputs = newEntry.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        if (input.name) {
            input.name = input.name.replace(/fishing_ops\[\d+\]/g, `fishing_ops[${entryIndex}]`);
            // Reset values for the new entry
            if (input.type === 'radio' || input.type === 'checkbox') {
                input.checked = false;
            } else if (input.type !== 'button' && input.type !== 'submit') {
                input.value = '';
            }
        }
    });
    
    // Show the remove button (but keep it hidden for the first entry)
    if (entryIndex > 0) {
        newEntry.querySelector('.remove-fishing-op').classList.remove('d-none');
    }
    
    // Make the new entry visible and insert it before the template
    newEntry.style.display = 'block';
    container.insertBefore(newEntry, template);
    
    // Initialize map for the new entry
    initMapForEntry(newEntry);
}

// Function to initialize map for a fishing operation entry
function initMapForEntry(entry) {
    const mapContainer = entry.querySelector('.map-container');
    if (!mapContainer) return;
    
    const mapId = 'map-' + Date.now();
    mapContainer.id = mapId;
    
    // Initialize map after a small delay to ensure DOM is ready
    setTimeout(() => {
        const map = L.map(mapId).setView([12.8797, 121.7740], 5);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);
        
        const latitudeInput = entry.querySelector('input[name$="[latitude]"]');
        const longitudeInput = entry.querySelector('input[name$="[longitude]"]');
        const locationInput = entry.querySelector('input[name$="[fishing_location]"]');
        
        let marker = null;
        
        // Add click event to set location
        map.on('click', function(e) {
            if (marker) {
                map.removeLayer(marker);
            }
            
            marker = L.marker(e.latlng).addTo(map);
            if (latitudeInput) latitudeInput.value = e.latlng.lat.toFixed(6);
            if (longitudeInput) longitudeInput.value = e.latlng.lng.toFixed(6);
            if (locationInput) locationInput.value = `${e.latlng.lat.toFixed(6)}, ${e.latlng.lng.toFixed(6)}`;
        });
        
        // Update location when coordinates are manually entered
        const updateMarker = () => {
            const lat = parseFloat(latitudeInput?.value);
            const lng = parseFloat(longitudeInput?.value);
            
            if (!isNaN(lat) && !isNaN(lng)) {
                if (marker) {
                    map.removeLayer(marker);
                }
                const latLng = L.latLng(lat, lng);
                marker = L.marker(latLng).addTo(map);
                map.setView(latLng, Math.max(map.getZoom(), 10));
                if (locationInput) locationInput.value = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
            }
        };
        
        if (latitudeInput && longitudeInput) {
            latitudeInput.addEventListener('change', updateMarker);
            longitudeInput.addEventListener('change', updateMarker);
        }
    }, 100);
}

// Function to add new boat information entry
function addBoatInfo() {
    const container = document.getElementById('boatInfoContainer');
    const entries = container.querySelectorAll('.boat-entry:not([style*="display: none"])');
    const newEntry = cloneAndUpdateFields(container, 'boat-entry', 'boats', entries.length);
    
    // Update the entry number display
    newEntry.querySelector('.entry-number').textContent = entries.length + 1;
    
    // Add event listeners for gross tonnage calculation
    const lengthInput = newEntry.querySelector('input[name$="[boat_length]"]');
    const widthInput = newEntry.querySelector('input[name$="[boat_width]"]');
    const depthInput = newEntry.querySelector('input[name$="[boat_depth]"]');
    const gtInput = newEntry.querySelector('input[name$="[gross_tonnage]"]');
    
    if (lengthInput && widthInput && depthInput && gtInput) {
        const calculate = () => {
            const length = parseFloat(lengthInput.value) || 0;
            const width = parseFloat(widthInput.value) || 0;
            const depth = parseFloat(depthInput.value) || 0;
            const gt = (length * width * depth * 0.2).toFixed(1); // Simple GT calculation
            gtInput.value = gt;
        };
        
        lengthInput.addEventListener('input', calculate);
        widthInput.addEventListener('input', calculate);
        depthInput.addEventListener('input', calculate);
    }
    
    // Enable remove button if there's more than one entry
    updateRemoveButtons('.boat-entry', '.remove-boat');
}

// Function to add new general information entry
function addGeneralInfo() {
    const container = document.getElementById('generalInfoContainer');
    const entries = container.querySelectorAll('.general-entry:not([style*="display: none"])');
    const newEntry = cloneAndUpdateFields(container, 'general-entry', 'general', entries.length);
    
    // Update the entry number display
    newEntry.querySelector('.entry-number').textContent = entries.length + 1;
    
    // Set today's date as default for new entries
    const today = new Date().toISOString().split('T')[0];
    const dateInput = newEntry.querySelector('input[type="date"]');
    if (dateInput && !dateInput.value) {
        dateInput.value = today;
    }
    
    // Enable remove button if there's more than one entry
    updateRemoveButtons('.general-entry', '.remove-entry');
}

// Update all remove buttons' visibility
function updateRemoveButtons(entrySelector, removeButtonSelector) {
    const entries = document.querySelectorAll(entrySelector);
    const removeButtons = document.querySelectorAll(removeButtonSelector);
    
    if (entries.length <= 1) {
        removeButtons.forEach(btn => {
            btn.style.display = 'none';
        });
    } else {
        removeButtons.forEach(btn => {
            btn.style.display = 'inline-block';
        });
    }
}

// Handle remove entry buttons
document.addEventListener('click', function(e) {
    // Handle remove catch buttons
    if (e.target.closest('.remove-catch')) {
        const entry = e.target.closest('.catch-entry');
        if (entry && document.querySelectorAll('.catch-entry:not([style*="display: none"])').length > 1) {
            entry.remove();
            updateRemoveButtons('.catch-entry', '.remove-catch');
            // Renumber remaining entries
            document.querySelectorAll('.catch-entry:not([style*="display: none"])').forEach((entry, index) => {
                entry.querySelector('.catch-number').textContent = index + 1;
            });
        }
    }
    
    // Handle remove general info buttons
    if (e.target.closest('.remove-entry')) {
        const entry = e.target.closest('.general-entry');
        if (entry && document.querySelectorAll('.general-entry:not([style*="display: none"])').length > 1) {
            entry.remove();
            updateRemoveButtons('.general-entry', '.remove-entry');
            // Renumber remaining entries
            document.querySelectorAll('.general-entry:not([style*="display: none"])').forEach((entry, index) => {
                entry.querySelector('.entry-number').textContent = index + 1;
            });
        }
    }
    
    // Handle remove boat buttons
    if (e.target.closest('.remove-boat')) {
        const entry = e.target.closest('.boat-entry');
        if (entry && document.querySelectorAll('.boat-entry:not([style*="display: none"])').length > 1) {
            entry.remove();
            updateRemoveButtons('.boat-entry', '.remove-boat');
            // Renumber remaining entries
            document.querySelectorAll('.boat-entry:not([style*="display: none"])').forEach((entry, index) => {
                entry.querySelector('.entry-number').textContent = index + 1;
            });
        }
    }
    
    // Handle remove fishing operation buttons
    if (e.target.closest('.remove-fishing-op')) {
        const entry = e.target.closest('.fishing-op-entry');
        if (entry && document.querySelectorAll('.fishing-op-entry:not([style*="display: none"])').length > 1) {
            entry.remove();
            // Renumber remaining entries
            document.querySelectorAll('.fishing-op-entry:not([style*="display: none"])').forEach((entry, index) => {
                entry.querySelector('.entry-number').textContent = index + 1;
                // Hide remove button for the first entry
                const removeBtn = entry.querySelector('.remove-fishing-op');
                if (removeBtn) {
                    removeBtn.classList.toggle('d-none', index === 0);
                }
            });
        }
    }
    
    // Handle remove fishing operation buttons
    if (e.target.closest('.remove-fishing-op')) {
        const entry = e.target.closest('.fishing-op-entry');
        if (entry && document.querySelectorAll('.fishing-op-entry:not([style*="display: none"])').length > 1) {
            entry.remove();
            updateRemoveButtons('.fishing-op-entry', '.remove-fishing-op');
            // Renumber remaining entries
            document.querySelectorAll('.fishing-op-entry:not([style*="display: none"])').forEach((entry, index) => {
                entry.querySelector('.entry-number').textContent = index + 1;
            });
        }
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const today = new Date().toISOString().split('T')[0];
    
    // Initialize plus buttons
    initPlusButtons();
    
    // Add first entries by default
    addGeneralInfo();
    addBoatInfo();
    
    // Initialize map for the first fishing operation entry
    const firstFishingOp = document.querySelector('.fishing-op-entry:not([style*="display: none"])');
    if (firstFishingOp) {
        initMapForEntry(firstFishingOp);
    }
    addFishingOp();
    
    // Initialize mode UI
    updateModeUI();
    
    // Form submission handling
    document.getElementById('catchForm').addEventListener('submit', function(e) {
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        
        // Show loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin me-2"></i>Submitting...';
        
        // Validate required fields
        const requiredFields = this.querySelectorAll('[required]');
        let isValid = true;
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });
        
        // Additional validation for image field in automatic mode
        const imageField = document.getElementById('image');
        if (isAutoMode && (!imageField.files || imageField.files.length === 0)) {
            imageField.classList.add('is-invalid');
            isValid = false;
        } else {
            imageField.classList.remove('is-invalid');
        }
        
        if (!isValid) {
            e.preventDefault();
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
            
            let errorMessage = 'Please fill in all required fields.';
            if (isAutoMode && (!imageField.files || imageField.files.length === 0)) {
                errorMessage = 'Please upload an image or take a photo in automatic mode.';
            }
            
            alert(errorMessage);
            return;
        }
        
        // Form is valid, allow submission
        // The loading state will be maintained until the page redirects
    });
});
</script>

<style>
.card-header {
    border-bottom: none;
}

.form-check {
    margin-bottom: 0.5rem;
}

.table th {
    background-color: #f8f9fa;
    font-weight: 600;
}

.btn-lg {
    padding: 12px 30px;
    font-size: 1.1rem;
}
</style>
@endsection 