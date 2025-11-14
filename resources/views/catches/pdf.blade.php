<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BFAR Fish Catch Report #{{ $catch->id }}</title>
    <style>
        @page {
            margin: 1.5cm 2cm;
            @top-center {
                content: "BUREAU OF FISHERIES AND AQUATIC RESOURCES";
                font-size: 12px;
                font-weight: bold;
            }
            @bottom-center {
                content: "Page " counter(page) " of " counter(pages);
                font-size: 10px;
            }
        }

        @media print {
            body { 
                margin: 0;
                padding: 0;
                font-family: 'Arial', sans-serif;
                color: #000;
                background: #fff;
                line-height: 1.5;
            }
            .no-print { 
                display: none !important; 
            }
            .page-break { 
                page-break-before: always;
                margin-top: 2cm;
            }
            .section {
                margin: 0 0 20px 0;
                page-break-inside: avoid;
            }
            .section:last-child {
                page-break-after: auto;
            }
            table {
                page-break-inside: auto;
            }
            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
        }
        
        body {
            font-family: 'Arial', sans-serif;
            font-size: 11px;
            line-height: 1.5;
            margin: 0;
            padding: 0;
            color: #000;
            background: #fff;
        }
        
        .header {
            text-align: center;
            border-bottom: 2px solid #003366;
            padding-bottom: 15px;
            margin-bottom: 20px;
            position: relative;
        }
        
        .logo {
            position: absolute;
            left: 10px;
            top: 0;
            max-height: 70px;
        }
        
        .header h1 {
            margin: 5px 0 0 0;
            font-size: 16px;
            font-weight: bold;
            color: #003366;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .header p {
            margin: 3px 0;
            font-size: 11px;
            color: #333;
        }
        
        .section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }
        
        .program-header {
            text-align: center;
            font-weight: bold;
            font-size: 13px;
            margin: 25px 0 5px 0;
            padding: 8px 10px;
            background-color: #003366;
            color: white;
            border: 1px solid #002244;
            border-radius: 3px 3px 0 0;
        }
        
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 0 15px 0;
            font-size: 10px;
            border: 1px solid #ddd;
        }
        
        table.data-table th, 
        table.data-table td {
            border: 1px solid #ddd;
            padding: 5px 8px;
            vertical-align: middle;
            line-height: 1.3;
        }
        
        table.data-table th {
            background-color: #f0f7ff;
            color: #003366;
            font-weight: bold;
            text-align: left;
            font-size: 10px;
            padding: 7px 8px;
            border-bottom: 2px solid #003366;
        }
        
        table.data-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        table.data-table tr:hover {
            background-color: #f1f1f1;
        }
        
        .photo-section {
            text-align: center;
            margin: 20px 0;
        }
        
        .photo-section img {
            max-width: 300px;
            max-height: 200px;
            border: 1px solid #333;
            margin-bottom: 10px;
        }
        
        .footer {
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #333;
            font-size: 10px;
            text-align: center;
        }
        
        .metadata table {
            width: 100%;
            font-size: 10px;
            border-collapse: collapse;
        }
        
        .metadata th, 
        .metadata td {
            border: 1px solid #333;
            padding: 4px 6px;
        }
        
        .metadata th {
            background-color: #f5f5f5;
        }
        
        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <button class="print-button no-print" onclick="window.print()">
        Print Report
    </button>

    <div class="header">
        <img src="{{ public_path('assets/img/icons/brands/BFAR.png') }}" alt="BFAR Logo" class="logo" style="width: 80px; height: auto;">
        <h1>BUREAU OF FISHERIES AND AQUATIC RESOURCES</h1>
        <p>National Stock Assessment Program (NSAP)</p>
        <p>Region VIII - Eastern Visayas</p>
        <p style="margin-top: 10px; font-weight: bold;">FISH CATCH MONITORING FORM</p>
        <p>Report ID: NSAP-{{ strtoupper(substr($catch->region, 0, 3)) }}-{{ $catch->id }} | Date Generated: {{ now()->format('F d, Y h:i A') }}</p>
        <p>Date of Catch: {{ \Carbon\Carbon::parse($catch->date_sampling)->format('F d, Y') }}</p>
    </div>

    <!-- General Information -->
    <div class="section">
    
        <div class="section-title">GENERAL INFORMATION</div>
        <table class="data-table">
            <tr>
                <th>Region:</th>
                <td>{{ $catch->region }}</td>
                <th>Landing Center:</th>
                <td>{{ $catch->landing_center }}</td>
            </tr>
            <tr>
                <th>Date of Sampling:</th>
                <td>{{ \Carbon\Carbon::parse($catch->date_sampling)->format('F d, Y') }}</td>
                <th>Time of Landing:</th>
                <td>{{ $catch->time_landing }}</td>
            </tr>
            <tr>
                <th>Enumerator(s):</th>
                <td colspan="3">{{ $catch->enumerators }}</td>
            </tr>
            <tr>
                <th>Fishing Ground:</th>
                <td colspan="3">{{ $catch->fishing_ground }}</td>
            </tr>
            <tr>
                <th>Weather Conditions:</th>
                <td colspan="3">{{ $catch->weather_conditions }}</td>
            </tr>
        </table>
    </div>

    <!-- Boat Information -->
    <div class="section">
    
        <div class="section-title">BOAT INFORMATION</div>
        
        @if($catch->boats->count() > 0)
            @foreach($catch->boats as $index => $boat)
                <h4 style="margin: 15px 0 10px 0; font-weight: bold;">Boat #{{ $index + 1 }}</h4>
                <table class="data-table">
                    <tr>
                        <th>Boat Name (F/B):</th>
                        <td>{{ $boat->boat_name ?? 'N/A' }}</td>
                        <th>Boat Type:</th>
                        <td>{{ $boat->boat_type ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Length (m):</th>
                        <td>{{ $boat->boat_length ? number_format($boat->boat_length, 2) : 'N/A' }}</td>
                        <th>Width (m):</th>
                        <td>{{ $boat->boat_width ? number_format($boat->boat_width, 2) : 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Depth (m):</th>
                        <td>{{ $boat->boat_depth ? number_format($boat->boat_depth, 2) : 'N/A' }}</td>
                        <th>Gross Tonnage (GT):</th>
                        <td>{{ $boat->gross_tonnage ? number_format($boat->gross_tonnage, 2) : 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Horsepower (HP):</th>
                        <td>{{ $boat->horsepower ?? 'N/A' }}</td>
                        <th>Engine Type:</th>
                        <td>{{ $boat->engine_type ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Number of Fishermen:</th>
                        <td colspan="3">{{ $boat->fishermen_count ?? 'N/A' }}</td>
                    </tr>
                </table>
                @if(!$loop->last)
                    <div style="page-break-before: always;"></div>
                @endif
            @endforeach
        @else
            <p>No boat information available.</p>
        @endif
    </div>

    <!-- Fishing Operation Details -->
    <div class="section">
    
        <div class="section-title">FISHING OPERATION DETAILS</div>
        
        @if($catch->fishingOperations->count() > 0)
            @foreach($catch->fishingOperations as $index => $operation)
                <h4 style="margin: 15px 0 10px 0; font-weight: bold;">Operation #{{ $index + 1 }}</h4>
                <table class="data-table">
                    <tr>
                        <th>Fishing Gear Type:</th>
                        <td>{{ $operation->gear_type ?? 'N/A' }}</td>
                        <th>Days Fished:</th>
                        <td>{{ $operation->days_fished ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Net/Line Length (m):</th>
                        <td>{{ $operation->net_line_length ? number_format($operation->net_line_length, 2) : 'N/A' }}</td>
                        <th>Soaking Time (hours):</th>
                        <td>{{ $operation->soaking_time ? number_format($operation->soaking_time, 2) : 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Mesh Size (cm):</th>
                        <td>{{ $operation->mesh_size ? number_format($operation->mesh_size, 2) : 'N/A' }}</td>
                        <th>Number of Hooks:</th>
                        <td>{{ $operation->number_of_hooks ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Fishing Ground:</th>
                        <td colspan="3">{{ $operation->fishing_ground ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Coordinates (Lat, Lng):</th>
                        <td colspan="3">
                            @if($operation->latitude && $operation->longitude)
                                {{ number_format($operation->latitude, 6) }}, {{ number_format($operation->longitude, 6) }}
                            @else
                                N/A
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Notes:</th>
                        <td colspan="3">{{ $operation->notes ?? 'N/A' }}</td>
                    </tr>
                </table>
                @if(!$loop->last)
                    <div style="page-break-before: always;"></div>
                @endif
            @endforeach
        @else
            <p>No fishing operation details available.</p>
        @endif
    </div>

    <!-- Catch Information -->
    <div class="section">
    
        <div class="section-title">CATCH INFORMATION</div>
        <table class="data-table">
            <tr>
                <th>Catch Type:</th>
                <td>{{ $catch->catch_type }}</td>
                <th>Total Catch (kg):</th>
                <td>{{ number_format($catch->total_catch_kg, 2) }}</td>
            </tr>
            <tr>
                <th>Sub-sample Taken:</th>
                <td>{{ $catch->subsample_taken ?: 'N/A' }}</td>
                <th>Sub-sample Weight (kg):</th>
                <td>{{ $catch->subsample_weight ? number_format($catch->subsample_weight, 2) : 'N/A' }}</td>
            </tr>
            <tr>
                <th>Below Legal Size:</th>
                <td>{{ $catch->below_legal_size ?: 'N/A' }}</td>
                <th>Below Legal Species:</th>
                <td>{{ $catch->below_legal_species ?: 'N/A' }}</td>
            </tr>
        </table>
    </div>

    <!-- AI Species Recognition & Size Estimation -->
    <div class="section">
    
        <div class="section-title">SPECIES RECOGNITION & SIZE ESTIMATION</div>
        <table class="data-table">
            <tr>
                <th>Species:</th>
                <td>{{ $catch->species ?: 'N/A' }}</td>
                <th>Scientific Name:</th>
                <td>{{ $catch->scientific_name ?: 'N/A' }}</td>
            </tr>
            <tr>
                <th>Length (cm):</th>
                <td>{{ $catch->length_cm ? number_format($catch->length_cm, 1) : 'N/A' }}</td>
                <th>Weight (g):</th>
                <td>{{ $catch->weight_g ? number_format($catch->weight_g, 1) : 'N/A' }}</td>
            </tr>
        </table>
        <br>
        <!-- Report Metadata -->
        <div class="metadata" style="margin-top: 20px;">
            <table class="data-table">
                <tr>
                    <td width="25%"><strong>Report ID:</strong></td>
                    <td width="25%">#{{ $catch->id }}</td>
                    <td width="25%"><strong>Submitted by:</strong></td>
                    <td width="25%">{{ $catch->user->name }}</td>
                </tr>
                <tr>
                    <td><strong>Submitted on:</strong></td>
                    <td>{{ $catch->created_at->format('F d, Y \a\t g:i A') }}</td>
                    <td><strong>Last updated:</strong></td>
                    <td>{{ $catch->updated_at->format('F d, Y \a\t g:i A') }}</td>
                </tr>
                <tr>
                    <td><strong>Processing mode:</strong></td>
                    <td colspan="3">
                        @if($catch->image_path)
                            AI Processing (with photo)
                        @else
                            Manual Entry
                        @endif
                    </td>
                </tr>
            </table>
        </div>

        <div class="footer" style="text-align: center; margin-top: 30px; font-size: 11px; color: #666; border-top: 1px solid #eee; padding-top: 10px;">
            <p>This is an official BFAR Fish Catch Monitoring Report generated on {{ now()->format('F d, Y \a\t g:i A') }}</p>
            <p>Bureau of Fisheries and Aquatic Resources - National Stock Assessment Program</p>
        </div>
    </div>

    <!-- Fish Photo -->
    @if($catch->image_path)
    @php
        // Get the full path to the image
        $imagePath = storage_path('app/public/' . $catch->image_path);
        // Convert image to base64 for embedding in PDF
        $imageData = file_exists($imagePath) ? 'data:image/'.pathinfo($imagePath, PATHINFO_EXTENSION).';base64,'.base64_encode(file_get_contents($imagePath)) : null;
    @endphp
    @if($imageData)
    <div class="section">
    
        <div class="section-title">FISH PHOTO</div>
        <div class="photo-section">
            <img src="{{ $imageData }}" alt="Fish Photo" style="max-width: 100%; height: auto;">
        </div>
    </div>
    @endif
    @endif


</body>
</html> 