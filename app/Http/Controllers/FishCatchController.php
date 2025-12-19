<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FishCatch;
use App\Models\Boat;
use App\Models\FishingOperation;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class FishCatchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $catches = FishCatch::with(['user', 'boats', 'fishingOperations'])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('catches.index', compact('catches'));
    }
    
    /**
     * Display all catches for admin
     */
    public function adminIndex()
    {
        $catches = FishCatch::with([
                'user', 
                'boats', 
                'fishingOperations',
                'user.role' // Load user's role relationship
            ])
            ->withCount('boats')
            ->withCount('fishingOperations')
            ->orderBy('created_at', 'desc')
            ->paginate(25);
            
        // Get all available columns from the database
        $columns = \Schema::getColumnListing((new FishCatch)->getTable());
        
        return view('admin.catches', [
            'catches' => $catches,
            'columns' => $columns
        ]);
    }
    
    /**
     * Display the specified catch for admin
     */
    public function adminShow(FishCatch $catch)
    {
        $catch->load(['user', 'boats', 'fishingOperations']);
        return view('admin.view-catch', compact('catch'));
    }
    private $mlApiUrl = 'http://localhost:5000';
    
    /**
     * Process fish image and return species and size estimation
     */
    /**
     * Show the form for creating a new fish catch.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('catch.create');
    }

    /**
     * Display the specified fish catch.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $catch = FishCatch::with(['user', 'boats', 'fishingOperations'])
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();
            
        return view('catches.show', compact('catch'));
    }

    /**
     * Show the form for editing the specified fish catch.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $catch = FishCatch::with(['boats', 'fishingOperations'])
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();
            
        return view('catches.edit', compact('catch'));
    }

    /**
     * Update the specified fish catch in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $catch = FishCatch::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $validated = $request->validate([
            'species' => 'required|string|max:255',
            'weight' => 'required|numeric|min:0.01',
            'length' => 'required|numeric|min:0.1',
            'location' => 'required|string|max:255',
            'date_caught' => 'required|date',
            'fishing_method' => 'required|string|in:net,line,trap,spear,other',
            'notes' => 'nullable|string',
            'status' => 'required|string|in:recorded,verified,pending,rejected',
            'image' => 'nullable|image|max:10240', // Max 10MB
        ]);

        // Handle image upload if a new image is provided
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($catch->image_path && Storage::disk('public')->exists($catch->image_path)) {
                Storage::disk('public')->delete($catch->image_path);
            }
            
            // Store new image
            $imagePath = $request->file('image')->store('catches', 'public');
            $validated['image_path'] = $imagePath;
        }

        // Update the catch record
        $catch->update($validated);

        return redirect()->route('catches.show', $catch->id)
            ->with('success', 'Catch record updated successfully!');
    }

    /**
     * Remove the specified fish catch from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $catch = FishCatch::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Delete associated image if it exists
        if ($catch->image_path && Storage::disk('public')->exists($catch->image_path)) {
            Storage::disk('public')->delete($catch->image_path);
        }

        // Delete the catch record
        $catch->delete();

        return redirect()->route('catches.index')
            ->with('status', 'Catch record has been deleted successfully.');
    }

    /**
     * Store a newly created fish catch in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */


    /**
     * Process fish image and return species and size estimation
     */
    public function processFishImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:10240', // Max 10MB
        ]);

        try {
            // Save the uploaded file temporarily
            $image = $request->file('image');
            $imagePath = $image->store('temp', 'public');
            
            // Call the ML API for prediction
            $response = Http::attach(
                'image', 
                file_get_contents($image->getRealPath()),
                $image->getClientOriginalName()
            )->post($this->mlApiUrl . '/predict');

            if (!$response->successful()) {
                throw new \Exception('Failed to process image with ML API');
            }

            $result = $response->json();
            
            // Delete the temporary file
            Storage::disk('public')->delete($imagePath);
            
            return response()->json($result);
            
        } catch (\Exception $e) {
            // Clean up temp file if it exists
            if (isset($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to record fish catch: ' . $e->getMessage(),
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ], 500);
            }
            
            return back()->withInput()
                ->with('error', 'Failed to record fish catch: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        // Debug: Log the request data
        \Log::info('Store request data:', $request->all());
        \Log::info('Starting fish catch submission', ['input' => $request->except(['_token', 'image'])]);
        
        try {
            // Set JSON response for AJAX requests
            $isAjax = $request->ajax() || $request->wantsJson();
            // Validate the request data
            $validatedData = $request->validate([
                // Fisherman Information
                'fisherman_registration_id' => 'required|string|max:255',
                'fisherman_name' => 'required|string|max:255',
                
                // General Information
                'region' => 'required|string|max:255',
                'landing_center' => 'required|string|max:255',
                'date_sampling' => 'required|date',
                'time_landing' => 'required|date_format:H:i',
                'enumerators' => 'required|string|max:255',
                'fishing_ground' => 'required|string|max:255',
                'weather_conditions' => 'required|string|in:Sunny,Cloudy,Rainy,Stormy,Calm,Windy',
                
                // Boat Information
                'boats' => 'required|array|min:1',
                'boats.*.boat_name' => 'required|string|max:255',
                'boats.*.boat_type' => 'required|string|in:Motorized,Non-motorized',
                'boats.*.boat_length' => 'required|numeric|min:0',
                'boats.*.boat_width' => 'required|numeric|min:0',
                'boats.*.boat_depth' => 'required|numeric|min:0',
                'boats.*.gross_tonnage' => 'nullable|numeric|min:0',
                'boats.*.horsepower' => 'nullable|numeric|min:0',
                'boats.*.engine_type' => 'nullable|string|max:255',
                'boats.*.fishermen_count' => 'required|integer|min:1',
                
                // Fishing Operation Details - Update to match form structure
                'fishing_ops' => 'required|array|min:1',
                'fishing_ops.*.fishing_gear_type' => 'required|string|in:Gill Net,Drift Gill Net,Set Gill Net,Trammel Net,Beach Seine,Purse Seine,Ring Net,Danish Seine,Trawl,Midwater Trawl,Pair Trawl,Baby Trawl,Bagnet,Handline,Multiple Handline,Troll Line,Longline,Bottom Set Longline,Drift Longline,Pole and Line,Jigging,Fish Pot,Lobster Pot,Crab Pot,Bamboo Trap,Funnel Net,Fyke Net,Spear,Harpoon,Scoop Net,Cast Net,Drive-in Net,Lift Net',
                'fishing_ops.*.gear_specifications' => 'nullable|string',
                'fishing_ops.*.hooks_hauls' => 'nullable|integer|min:0',
                'fishing_ops.*.net_line_length' => 'nullable|numeric|min:0',
                'fishing_ops.*.soaking_time' => 'nullable|numeric|min:0',
                'fishing_ops.*.mesh_size' => 'nullable|numeric|min:0',
                'fishing_ops.*.days_fished' => 'required|integer|min:1',
                'fishing_ops.*.latitude' => 'nullable|numeric|between:-90,90',
                'fishing_ops.*.longitude' => 'nullable|numeric|between:-180,180',
                'fishing_ops.*.payao_used' => 'nullable|string|in:Yes,No',
                'fishing_ops.*.fishing_effort_notes' => 'nullable|string',
                
                // Catch Information - Flat fields (not in an array)
                'catch_type' => 'required|string|in:Complete,Incomplete,Partly Sold',
                'total_catch_kg' => 'required|numeric|min:0',
                'subsample_taken' => 'required|string|in:Yes,No',
                'subsample_weight' => 'nullable|numeric|min:0',
                'below_legal_size' => 'required|string|in:Yes,No',
                'below_legal_species' => 'nullable|string|max:255',
                
                // AI Species Recognition & Size Estimation
                'species' => 'required|string|max:255',
                'scientific_name' => 'nullable|string|max:255',
                'length_cm' => 'required|numeric|min:0',
                'weight_g' => 'required|numeric|min:0',
                'confidence_score' => 'nullable|string|max:255',
                
                // Image (if any)
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            ]);

            // Start database transaction
            \DB::beginTransaction();

            try {
                // Set user ID
                $validatedData['user_id'] = auth()->id();

                // Set catch_datetime from date_sampling and time_landing
                $validatedData['catch_datetime'] = $validatedData['date_sampling'] . ' ' . $validatedData['time_landing'];

                // Handle image upload if present
                if ($request->hasFile('image') && $request->file('image')->isValid()) {
                    $imagePath = $request->file('image')->store('catches', 'public');
                    $validatedData['image_path'] = $imagePath;
                }

                // Extract boats and fishing_ops data before creating FishCatch
                $boatsData = $validatedData['boats'] ?? [];
                $fishingOpsData = $validatedData['fishing_ops'] ?? [];
                
                // Convert 'Yes'/'No' to boolean for database fields
                $validatedData['subsample_taken'] = isset($validatedData['subsample_taken']) && 
                    ($validatedData['subsample_taken'] === 'Yes' || $validatedData['subsample_taken'] === '1' || $validatedData['subsample_taken'] === true) ? 1 : 0;
                    
                $validatedData['below_legal_size'] = isset($validatedData['below_legal_size']) && 
                    ($validatedData['below_legal_size'] === 'Yes' || $validatedData['below_legal_size'] === '1' || $validatedData['below_legal_size'] === true) ? 1 : 0;
                
                // Remove arrays from validated data before creating FishCatch
                unset($validatedData['boats'], $validatedData['fishing_ops']);

                // Log before creating fish catch
                \Log::info('Creating fish catch record', ['data' => $validatedData]);
                
                // Create the fish catch record
                try {
                    // Create the fish catch record
                    $fishCatch = FishCatch::create($validatedData);
                    \Log::info('Fish catch record created', ['id' => $fishCatch->id]);
                    
                    // Create boat records
                    if (!empty($boatsData)) {
                        foreach ($boatsData as $boatData) {
                            // Ensure we're using the correct column name (fish_catch_id)
                            $boat = new Boat($boatData);
                            $boat->fish_catch_id = $fishCatch->id; // Explicitly set the fish_catch_id
                            $boat->save();
                            \Log::info('Boat created', ['id' => $boat->id, 'fish_catch_id' => $fishCatch->id]);
                        }
                    }
                    
                    // Create fishing operation records
                    if (!empty($fishingOpsData)) {
                        foreach ($fishingOpsData as $opData) {
                            // Ensure we're using the correct column name (fish_catch_id)
                            $fishingOp = new FishingOperation();
                            $fishingOp->fish_catch_id = $fishCatch->id;
                            
                            // Map the form data to the model fields
                            $fishingOp->fishing_gear_type = $opData['fishing_gear_type'] ?? null;
                            $fishingOp->gear_specifications = $opData['gear_specifications'] ?? null;
                            $fishingOp->hooks_hauls = $opData['hooks_hauls'] ?? null;
                            $fishingOp->net_line_length = $opData['net_line_length'] ?? null;
                            $fishingOp->soaking_time = $opData['soaking_time'] ?? null;
                            $fishingOp->mesh_size = $opData['mesh_size'] ?? null;
                            $fishingOp->days_fished = $opData['days_fished'] ?? 1;
                            $fishingOp->latitude = $opData['latitude'] ?? null;
                            $fishingOp->longitude = $opData['longitude'] ?? null;
                            $fishingOp->fishing_location = $opData['fishing_location'] ?? 
                                (isset($opData['latitude']) && isset($opData['longitude']) 
                                    ? $opData['latitude'] . ',' . $opData['longitude'] 
                                    : null);
                            $fishingOp->payao_used = $opData['payao_used'] ?? 'No';
                            $fishingOp->fishing_effort_notes = $opData['fishing_effort_notes'] ?? null;
                            
                            $fishingOp->save();
                            \Log::info('Fishing operation created', [
                                'id' => $fishingOp->id, 
                                'fish_catch_id' => $fishCatch->id,
                                'latitude' => $fishingOp->latitude,
                                'longitude' => $fishingOp->longitude,
                                'gear_specifications' => $fishingOp->gear_specifications
                            ]);
                        }
                    }
                    
                    // Commit the transaction
                    \DB::commit();
                    
                    \Log::info('Fish catch submission completed successfully', 
                        ['id' => $fishCatch->id]);
                        
                    if ($isAjax) {
                        return response()->json([
                            'success' => true,
                            'message' => 'Fish catch recorded successfully!',
                            'redirect' => route('catches.show', $fishCatch->id)
                        ]);
                    }
                    
                    return redirect()->route('catches.index')
                        ->with('success', 'Fish catch recorded successfully!');
                } catch (\Exception $e) {
                    \Log::error('Error creating fish catch record', [
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString(),
                        'validated_data' => $validatedData
                    ]);
                    throw $e;
                }

                // Save boats data
                \Log::info('Saving boats data', ['count' => count($boatsData), 'data' => $boatsData]);
                foreach ($boatsData as $boatData) {
                    $boat = $fishCatch->boats()->create($boatData);
                    \Log::info('Boat record created', ['id' => $boat->id]);
                }

                // Save fishing operations data
                \Log::info('Saving fishing operations data', ['count' => count($fishingOpsData), 'data' => $fishingOpsData]);
                foreach ($fishingOpsData as $opData) {
                    // Combine lat/lng into fishing_location if both exist
                    if (!empty($opData['latitude']) && !empty($opData['longitude'])) {
                        $opData['fishing_location'] = $opData['latitude'] . ',' . $opData['longitude'];
                    }
                    $operation = $fishCatch->fishingOperations()->create($opData);
                    \Log::info('Fishing operation record created', ['id' => $operation->id]);
                }

                // Commit the transaction
                \DB::commit();

                // Log successful submission
                \Log::info('Fish catch report submitted successfully', [
                    'fish_catch_id' => $fishCatch->id,
                    'user_id' => auth()->id(),
                    'fisherman_name' => $validatedData['fisherman_name']
                ]);

                // Return success response with consistent format
                return response()->json([
                    'success' => true,
                    'message' => 'Fish catch recorded successfully!',
                    'redirect' => route('catches.index') // Changed to redirect to index instead of show
                ]);

            } catch (\Exception $e) {
                // Rollback the transaction on error
                \DB::rollBack();
                throw $e;
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Log validation errors
            \Log::warning('Validation failed in FishCatchController@store', [
                'errors' => $e->errors(),
                'user_id' => auth()->id()
            ]);
            
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
                'message' => 'Please check the form for errors and try again.'
            ], 422);
            
        } catch (\Exception $e) {
            // Log the full error with trace
            \Log::error('Error in FishCatchController@store', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'code' => $e->getCode(),
                'trace' => $e->getTraceAsString(),
                'user_id' => auth()->id(),
                'input_data' => $request->except(['_token', 'image'])
            ]);
            
            // Return detailed error in development, generic message in production
            $message = config('app.debug') 
                ? 'Error: ' . $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine()
                : 'We encountered an error while processing your request. Please try again.';
                
            return response()->json([
                'success' => false,
                'message' => $message,
                'error' => config('app.debug') ? [
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'exception' => get_class($e)
                ] : null
            ], 500);
        }
    }

    public function predict(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240'
            ]);

        $image = $request->file('image');
            
            // Log the prediction request
            Log::info('ML Prediction Request', [
                'user_id' => auth()->id(),
                'filename' => $image->getClientOriginalName(),
                'size' => $image->getSize(),
                'mime_type' => $image->getMimeType()
            ]);

            // Check if ML API is available
            $healthCheck = Http::timeout(5)->get($this->mlApiUrl . '/health');
            
            if (!$healthCheck->successful()) {
                Log::error('ML API Health Check Failed', [
                    'status' => $healthCheck->status(),
                    'response' => $healthCheck->body()
                ]);
                
                return response()->json([
                    'error' => 'ML API is not available. Please try again later.',
                    'details' => 'The machine learning service is currently unavailable.'
                ], 503);
            }

            // Send image to ML API for processing
            $response = Http::timeout(30)->attach(
                'image', 
                file_get_contents($image), 
                $image->getClientOriginalName()
            )->post($this->mlApiUrl . '/predict');

            if (!$response->successful()) {
                Log::error('ML API Prediction Failed', [
                    'status' => $response->status(),
                    'response' => $response->body()
                ]);
                
                return response()->json([
                    'error' => 'Failed to process image with ML models.',
                    'details' => 'The image could not be processed. Please try again.'
                ], 500);
            }

            $predictionData = $response->json();

            // Log successful prediction
            Log::info('ML Prediction Success', [
                'user_id' => auth()->id(),
                'species' => $predictionData['species'] ?? 'Unknown',
                'confidence' => $predictionData['confidence_score'] ?? 0,
                'length_cm' => $predictionData['length_cm'] ?? 0
            ]);

            // Return the prediction results
            return response()->json($predictionData);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('ML Prediction Validation Error', [
                'errors' => $e->errors()
            ]);
            
            return response()->json([
                'error' => 'Invalid image format or size.',
                'details' => 'Please upload a valid image (JPEG, PNG, JPG, GIF) under 10MB.'
            ], 422);

        } catch (\Exception $e) {
            Log::error('ML Prediction Error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            return response()->json([
                'error' => 'An unexpected error occurred during image processing.',
                'details' => 'Please try again later or contact support if the problem persists.'
            ], 500);
        }
    }

    public function mlApiHealth()
    {
        try {
            $response = Http::timeout(5)->get($this->mlApiUrl . '/health');
            
            if ($response->successful()) {
                return response()->json([
                    'status' => 'healthy',
                    'ml_api' => $response->json(),
                    'message' => 'ML API is running properly'
                ]);
            } else {
                return response()->json([
                    'status' => 'unhealthy',
                    'ml_api' => null,
                    'message' => 'ML API is not responding'
                ], 503);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'ml_api' => null,
                'message' => 'Cannot connect to ML API: ' . $e->getMessage()
            ], 503);
        }
    }

    public function mlApiModels()
    {
        try {
            $response = Http::timeout(5)->get($this->mlApiUrl . '/models');
            
            if ($response->successful()) {
                return response()->json([
                    'status' => 'success',
                    'models' => $response->json(),
                    'message' => 'ML models information retrieved successfully'
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'models' => null,
                    'message' => 'Failed to get ML models information'
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'models' => null,
                'message' => 'Cannot connect to ML API: ' . $e->getMessage()
            ], 503);
        }
        if ($catch->user_id !== auth()->id() && auth()->user()->role !== 'REGIONAL_ADMIN') {
            abort(403);
        }
        
        return view('catches.show', compact('catch'));
    }

    public function generatePdf(FishCatch $catch)
    {
        // Ensure user can only generate PDF for their own catches
        if ($catch->user_id !== auth()->id() && auth()->user()->role !== 'REGIONAL_ADMIN') {
            abort(403);
        }

        // Debug: Log the catch ID and relationships
        \Log::info('Generating PDF for catch ID: ' . $catch->id);
        
        // Eager load relationships
        $catch->load(['boats', 'fishingOperations']);

        // Debug: Log the loaded relationships
        \Log::info('Loaded boats count: ' . $catch->boats->count());
        \Log::info('Loaded fishing operations count: ' . $catch->fishingOperations->count());
        \Log::info('Catch data: ' . json_encode($catch->toArray()));

        // Get the data to pass to the view
        $data = [
            'catch' => $catch,
            'boats' => $catch->boats,
            'fishingOperations' => $catch->fishingOperations
        ];

        // Debug: Log the data being passed to the view
        \Log::info('Data being passed to PDF view: ' . json_encode($data));

        // Generate PDF using the correct facade
        $pdf = \PDF::loadView('catches.pdf', $data);
        
        // Set paper size and orientation
        $pdf->setPaper('a4', 'portrait');
        
        // Generate a filename
        $filename = 'BFAR_Fish_Catch_Report_' . $catch->id . '_' . now()->format('Y-m-d') . '.pdf';
        
        // Download the PDF
        return $pdf->download($filename);
    }
}
