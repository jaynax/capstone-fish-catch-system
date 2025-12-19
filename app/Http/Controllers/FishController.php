<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Exception;
use Log;

class FishController extends Controller
{
    /**
     * Identify fish species and estimate length from an uploaded image using OpenAI's Generative AI (GPT-5).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function identify(Request $request): JsonResponse
    {
        // 1. Validation
        if (!$request->hasFile('image')) {
            return response()->json([
                'error' => 'No image file uploaded. Please upload a file with the field name "image".'
            ], 400);
        }

        try {
            // 2. Setup API Key and Model
            $apiKey = env('OPENAI_API_KEY');
            if (empty($apiKey)) {
                throw new Exception('OPENAI_API_KEY is not set in .env file or is empty.');
            }

            $uploadedFile = $request->file('image');
            
            // 3. Prepare Image and Prompts
            $imageData = base64_encode(file_get_contents($uploadedFile->getRealPath()));
            $mimeType = $uploadedFile->getClientMimeType();

            // System prompt to force JSON structure and define the task
            $systemPrompt = "You are an expert marine biologist with extensive experience in fish measurement. Analyze the provided image of a fish and provide the following details in a JSON format. For length estimation, use visual cues like the fish's body proportions, fin positions, and any visible reference objects to make the most accurate estimate possible. If there's no reference for scale, make an educated guess based on the fish's species and proportions.";
            
            // 4. OpenAI Request Payload
            $payload = [
                'model' => 'gpt-4o', // Using the latest vision model
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => $systemPrompt
                    ],
                    [
                        'role' => 'user',
                        'content' => [
                            [
                                'type' => 'text',
                                'text' => 'Please analyze this fish image and provide:
1. Common species name (species)
2. Scientific name (scientific_name)
3. Water type (water_type)
4. Estimated length in centimeters (length_cm) - this is crucial, please make your best estimate using visual cues

Return the response as a valid JSON object with these exact keys. For length, provide a number (e.g., 25.5) or null if absolutely no estimation is possible.'
                            ],
                            [
                                'type' => 'image_url',
                                'image_url' => [
                                    'url' => "data:{$mimeType};base64,{$imageData}",
                                    'detail' => 'auto'
                                ]
                            ]
                        ]
                    ]
                ],
                'response_format' => ['type' => 'json_object'],
                'max_tokens' => 1000
            ];

            // 5. API Call (Uses Bearer Token authentication)
            $response = Http::withToken($apiKey) 
                ->timeout(60) // Increased timeout for large image processing
                ->post('https://api.openai.com/v1/chat/completions', $payload);

            if ($response->failed()) {
                throw new Exception('OpenAI API request failed: ' . $response->body());
            }

            $responseData = $response->json();

            // 6. Parse and Decode Response from OpenAI format
            $jsonString = $responseData['choices'][0]['message']['content'] ?? '{"error": "No content found"}';
            $resultData = json_decode($jsonString, true);

            // Check if JSON decoding failed 
            if (json_last_error() !== JSON_ERROR_NONE || (isset($resultData['error']))) {
                Log::error("AI JSON Parse Error: " . $jsonString);
                throw new Exception('Failed to parse AI response. Raw Response: ' . $jsonString);
            }
            
            // 7. Return Structured Data
            return response()->json([
                'species' => $resultData['species'] ?? 'Unknown',
                'scientific_name' => $resultData['scientific_name'] ?? 'Unknown',
                'water_type' => $resultData['water_type'] ?? 'Unknown',
                'length_cm' => $resultData['length_cm'] ?? null, // Length can be null if not estimated
                'debug' => [
                    'model' => 'gpt-4o',
                ]
            ]);

        } catch (Exception $e) {
            Log::error("Fish Identification Error: " . $e->getMessage());
            
            $errorMessage = config('app.debug') 
                ? $e->getMessage() 
                : 'Failed to process the image. Please try again later.';

            return response()->json([
                'error' => $errorMessage
            ], 500);
        }
    }
}
