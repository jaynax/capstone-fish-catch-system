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

                        <!-- ✨ GENERAL INFORMATION -->
                        <div class="card mb-4 border-primary">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0"><i class="bx bx-info-circle me-2"></i>✨ GENERAL INFORMATION</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="landing_center" class="form-label">Landing Center: <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="landing_center" name="landing_center" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="date_sampling" class="form-label">Date of Sampling: <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="date_sampling" name="date_sampling" required>
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
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0"><i class="bx bx-ship me-2"></i>🚢 BOAT INFORMATION</h5>
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
                                        <input type="number" step="0.1" class="form-control" id="boat_length" name="boat_length" required>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="boat_width" class="form-label">Width (m): <span class="text-danger">*</span></label>
                                        <input type="number" step="0.1" class="form-control" id="boat_width" name="boat_width" required>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="boat_depth" class="form-label">Depth (m): <span class="text-danger">*</span></label>
                                        <input type="number" step="0.1" class="form-control" id="boat_depth" name="boat_depth" required>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="gross_tonnage" class="form-label">Gross Tonnage (GT):</label>
                                        <input type="number" step="0.1" class="form-control" id="gross_tonnage" name="gross_tonnage">
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
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0"><i class="bx bx-anchor me-2"></i>🎯 FISHING OPERATION DETAILS</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="fishing_gear_type" class="form-label">Fishing Gear Type: <span class="text-danger">*</span></label>
                                        <select class="form-select" id="fishing_gear_type" name="fishing_gear_type" required>
                                            <option value="">Select Gear Type</option>
                                            <option value="Gill Net">Gill Net</option>
                                            <option value="Trawl">Trawl</option>
                                            <option value="Hook and Line">Hook and Line</option>
                                            <option value="Longline">Longline</option>
                                            <option value="Purse Seine">Purse Seine</option>
                                            <option value="Ring Net">Ring Net</option>
                                            <option value="Cast Net">Cast Net</option>
                                            <option value="Bamboo Trap">Bamboo Trap</option>
                                            <option value="Fish Pot">Fish Pot</option>
                                            <option value="Other">Other</option>
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
                            <div class="card-header bg-warning text-white">
                                <h5 class="mb-0"><i class="bx bx-weight me-2"></i>⚖️ CATCH INFORMATION</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Catch Type: <span class="text-danger">*</span></label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="catch_type" id="complete" value="Complete" required>
                                            <label class="form-check-label" for="complete">☑ Complete</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="catch_type" id="incomplete" value="Incomplete" required>
                                            <label class="form-check-label" for="incomplete">☑ Incomplete</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="catch_type" id="partly_sold" value="Partly Sold" required>
                                            <label class="form-check-label" for="partly_sold">☑ Partly Sold</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="total_catch_kg" class="form-label">Total Catch (kg): <span class="text-danger">*</span></label>
                                        <input type="number" step="0.1" class="form-control" id="total_catch_kg" name="total_catch_kg" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Sub-sample Taken?</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="subsample_taken" id="subsample_yes" value="Yes">
                                            <label class="form-check-label" for="subsample_yes">☑ Yes</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="subsample_taken" id="subsample_no" value="No">
                                            <label class="form-check-label" for="subsample_no">☑ No</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="subsample_weight" class="form-label">Sub-sample Weight (kg):</label>
                                        <input type="number" step="0.1" class="form-control" id="subsample_weight" name="subsample_weight">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Were any fish below legal size?</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="below_legal_size" id="below_yes" value="Yes">
                                            <label class="form-check-label" for="below_yes">☑ Yes</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="below_legal_size" id="below_no" value="No">
                                            <label class="form-check-label" for="below_no">☑ No</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="below_legal_species" class="form-label">If Yes, which species:</label>
                                        <input type="text" class="form-control" id="below_legal_species" name="below_legal_species">
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
                                <div class="row mt-3">
                                    <div class="col-md-6 mb-3">
                                        <label for="confidence_score" class="form-label">Species Recognition Confidence:</label>
                                        <input type="text" class="form-control" id="confidence_score" name="confidence_score" readonly>
                                        <div class="form-text">CNN + MobileNetV2 confidence percentage</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="detection_confidence" class="form-label">Fish Detection Confidence:</label>
                                        <input type="text" class="form-control" id="detection_confidence" name="detection_confidence" readonly>
                                        <div class="form-text">YOLOv8 detection confidence percentage</div>
                                    </div>
                                </div>

                                <!-- Size Estimation Details -->
                                <div class="row mt-3">
                                    <div class="col-md-4 mb-3">
                                        <label for="bbox_width" class="form-label">Bounding Box Width (px):</label>
                                        <input type="number" class="form-control" id="bbox_width" name="bbox_width" readonly>
                                        <div class="form-text">YOLOv8 detected fish width in pixels</div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="bbox_height" class="form-label">Bounding Box Height (px):</label>
                                        <input type="number" class="form-control" id="bbox_height" name="bbox_height" readonly>
                                        <div class="form-text">YOLOv8 detected fish height in pixels</div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="pixels_per_cm" class="form-label">Pixels per cm (Reference):</label>
                                        <input type="number" step="0.01" class="form-control" id="pixels_per_cm" name="pixels_per_cm" readonly>
                                        <div class="form-text">Calibration ratio for size estimation</div>
                                    </div>
                                </div>

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
document.addEventListener('DOMContentLoaded', function() {
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('date_sampling').value = today;
    
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