<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BFAR Fish Catch Report #{{ $catch->id }}</title>
    <style>
        @media print {
            body { 
                margin: 0;
                padding: 15mm;
            }
            .no-print { 
                display: none; 
            }
            .page-break { 
                page-break-before: always; 
            }
            .section {
                margin: 0 0 20mm 0;
            }
            .section:last-child {
                margin-bottom: 0;
            }
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
            color: #333;
            background: white;
        }
        
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        
        .header h1 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }
        
        .header p {
            margin: 5px 0;
            font-size: 12px;
        }
        
        .section {
            margin-bottom: 30px;
            page-break-inside: avoid;
            page-break-after: always;
        }
        
        .section:last-child {
            page-break-after: auto;
        }
        
        .section-title {
            font-size: 14px;
            font-weight: bold;
            background-color: #f0f0f0;
            padding: 8px 10px;
            margin: 15px 0 10px 0;
            border: 1px solid #333;
            text-align: center;
        }
        
        .program-header {
            text-align: center;
            font-weight: bold;
            font-size: 14px;
            margin: 20px 0 5px 0;
            padding: 5px;
            background-color: #f0f0f0;
            border: 1px solid #333;
            border-bottom: none;
        }
        
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 12px;
        }
        
        table.data-table th, 
        table.data-table td {
            border: 1px solid #333;
            padding: 6px 8px;
            vertical-align: top;
        }
        
        table.data-table th {
            background-color: #f5f5f5;
            text-align: left;
            width: 30%;
        }
        
        table.data-table td {
            width: 70%;
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
        <h1>BFAR FISH CATCH MONITORING FORM</h1>
        <p>National Stock Assessment Program (NSAP)</p>
        <p>Report ID: #{{ $catch->id }} | Date: {{ \Carbon\Carbon::parse($catch->date_sampling)->format('F d, Y') }}</p>
    </div>

    <!-- General Information -->
    <div class="section">
        <div class="program-header">National Stock Assessment Program in Region 8</div>
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
        <div class="program-header">National Stock Assessment Program in Region 8</div>
        <div class="section-title">BOAT INFORMATION</div>
        <table class="data-table">
            <tr>
                <th>Boat Name (F/B):</th>
                <td>{{ $catch->boat_name }}</td>
                <th>Boat Type:</th>
                <td>{{ $catch->boat_type }}</td>
            </tr>
            <tr>
                <th>Length (m):</th>
                <td>{{ number_format($catch->boat_length, 2) }}</td>
                <th>Width (m):</th>
                <td>{{ number_format($catch->boat_width, 2) }}</td>
            </tr>
            <tr>
                <th>Depth (m):</th>
                <td>{{ number_format($catch->boat_depth, 2) }}</td>
                <th>Gross Tonnage (GT):</th>
                <td>{{ $catch->gross_tonnage ? number_format($catch->gross_tonnage, 2) : 'N/A' }}</td>
            </tr>
            <tr>
                <th>Horsepower (HP):</th>
                <td>{{ $catch->horsepower ?: 'N/A' }}</td>
                <th>Engine Type:</th>
                <td>{{ $catch->engine_type ?: 'N/A' }}</td>
            </tr>
            <tr>
                <th>Number of Fishermen:</th>
                <td colspan="3">{{ $catch->fishermen_count }}</td>
            </tr>
        </table>
    </div>

    <!-- Fishing Operation Details -->
    <div class="section">
        <div class="program-header">National Stock Assessment Program in Region 8</div>
        <div class="section-title">FISHING OPERATION DETAILS</div>
        <table class="data-table">
            <tr>
                <th>Fishing Gear Type:</th>
                <td>{{ $catch->fishing_gear_type }}</td>
                <th>Days Fished:</th>
                <td>{{ $catch->days_fished }}</td>
            </tr>
            <tr>
                <th>Gear Specifications:</th>
                <td colspan="3">{{ $catch->gear_specifications ?: 'N/A' }}</td>
            </tr>
            <tr>
                <th>Hooks/Hauls:</th>
                <td>{{ $catch->hooks_hauls ?: 'N/A' }}</td>
                <th>Net/Line Length (m):</th>
                <td>{{ $catch->net_line_length ? number_format($catch->net_line_length, 2) : 'N/A' }}</td>
            </tr>
            <tr>
                <th>Soaking Time (hrs):</th>
                <td>{{ $catch->soaking_time ? number_format($catch->soaking_time, 2) : 'N/A' }}</td>
                <th>Mesh Size (cm):</th>
                <td>{{ $catch->mesh_size ? number_format($catch->mesh_size, 2) : 'N/A' }}</td>
            </tr>
            <tr>
                <th>Fishing Location:</th>
                <td colspan="3">{{ $catch->fishing_location ?: 'N/A' }}</td>
            </tr>
            <tr>
                <th>Payao Used:</th>
                <td colspan="3">{{ $catch->payao_used ?: 'N/A' }}</td>
            </tr>
            <tr>
                <th>Fishing Effort Notes:</th>
                <td colspan="3">{{ $catch->fishing_effort_notes ?: 'N/A' }}</td>
            </tr>
        </table>
    </div>

    <!-- Catch Information -->
    <div class="section">
        <div class="program-header">National Stock Assessment Program in Region 8</div>
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
        <div class="program-header">National Stock Assessment Program in Region 8</div>
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
    <div class="section">
        <div class="program-header">National Stock Assessment Program in Region 8</div>
        <div class="section-title">FISH PHOTO</div>
        <div class="photo-section">
            <img src="{{ asset('storage/' . $catch->image_path) }}" alt="Fish Photo">
        </div>
    </div>
    @endif


</body>
</html> 