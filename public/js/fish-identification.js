// Function to handle image upload and process with AI
async function handleImageUpload(event) {
    if (!event || !event.target) return;
    
    const file = event.target.files[0];
    if (!file) return;

    // Show preview with better styling
    const reader = new FileReader();
    reader.onload = function(e) {
        const preview = document.getElementById('preview');
        const previewContainer = document.getElementById('imagePreview');
        const previewWrapper = document.getElementById('previewWrapper');
        
        if (preview) {
            preview.src = e.target.result;
            preview.style.display = 'block';
            preview.style.maxHeight = '300px';
            preview.style.width = 'auto';
            preview.className = 'img-fluid rounded border p-1';
        }
        
        if (previewWrapper) {
            previewWrapper.style.display = 'flex';
            previewWrapper.style.justifyContent = 'center';
            previewWrapper.style.alignItems = 'center';
            previewWrapper.style.minHeight = '200px';
            previewWrapper.style.border = '2px dashed #dee2e6';
            previewWrapper.style.borderRadius = '0.375rem';
            previewWrapper.style.padding = '1rem';
        }
        
        if (previewContainer) {
            previewContainer.style.display = 'block';
            previewContainer.style.marginTop = '1rem';
        }
    };
    
    reader.onerror = function(error) {
        console.error('Error reading file:', error);
        alert('Error loading image. Please try another file.');
    };
    
    try {
        reader.readAsDataURL(file);
    } catch (error) {
        console.error('Error processing file:', error);
        alert('Error processing image. The file might be corrupted.');
    }

    // Get all fields
    const speciesField = document.getElementById('species');
    const scientificNameField = document.getElementById('scientific_name');
    const waterTypeField = document.getElementById('water_type');
    const lengthCmField = document.getElementById('length_cm');
    const weightGField = document.getElementById('weight_g');
    
    // Show loading state
    if (speciesField) speciesField.placeholder = 'Identifying species...';
    if (scientificNameField) scientificNameField.placeholder = 'Identifying...';
    if (waterTypeField) waterTypeField.placeholder = 'Detecting...';
    if (lengthCmField) {
        lengthCmField.value = '';
        lengthCmField.placeholder = 'Estimating size...';
    }
    if (weightGField) {
        weightGField.value = '';
        weightGField.placeholder = 'Calculating weight...';
    }

    // Show processing status
    const processingStatus = document.getElementById('processingStatus');
    const statusText = document.getElementById('statusText');
    if (processingStatus) processingStatus.style.display = 'block';
    if (statusText) statusText.textContent = 'Processing image with AI models...';

    try {
        const formData = new FormData();
        formData.append('image', file);

        // Get CSRF token from meta tag
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        
        // Make API request to identify fish
        const response = await fetch('/api/identify', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': token || '',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
        });

        if (!response.ok) {
            const errorData = await response.json().catch(() => ({}));
            throw new Error(errorData.error || 'Failed to identify fish. Please try again.');
        }

        const data = await response.json();
        
        // Update form fields with the response data
        if (speciesField) speciesField.value = data.species || '';
        if (scientificNameField) scientificNameField.value = data.scientific_name || '';
        if (waterTypeField) waterTypeField.value = data.water_type || '';
        
        // Update length field if available
        if (lengthCmField && data.length_cm !== undefined) {
            lengthCmField.value = data.length_cm ? parseFloat(data.length_cm).toFixed(1) : '';
            
            // If length is available, we can estimate weight (simple formula: weight = a * length^b)
            if (data.length_cm && weightGField) {
                const length = parseFloat(data.length_cm);
                // This is a simplified estimation - you might want to adjust coefficients based on species
                const estimatedWeight = 0.01 * Math.pow(length, 3); // a*L^b where a=0.01, b=3 is a rough estimate
                weightGField.value = Math.round(estimatedWeight * 100) / 100; // Round to 2 decimal places
            }
        }
        
        // Show success status
        if (statusText) statusText.textContent = 'Analysis complete!';
        
    } catch (error) {
        console.error('Error identifying fish:', error);
        
        // Show error to user
        if (statusText) {
            statusText.textContent = 'Error: ' + (error.message || 'Failed to process image');
            const processingStatus = document.getElementById('processingStatus');
            if (processingStatus) {
                processingStatus.className = 'alert alert-danger';
                processingStatus.innerHTML = `<i class="bx bx-error-circle me-2"></i>${statusText.textContent}`;
            }
        } else {
            alert('Error identifying fish: ' + (error.message || 'Please try again.'));
        }
    } finally {
        // Clear loading placeholders
        if (speciesField && !speciesField.value) speciesField.placeholder = '';
        if (scientificNameField && !scientificNameField.value) scientificNameField.placeholder = '';
        if (waterTypeField && !waterTypeField.value) waterTypeField.placeholder = '';
        if (lengthCmField && !lengthCmField.value) lengthCmField.placeholder = '';
    }
}

// Helper function to parse the AI response (kept for backward compatibility)
function parseFishIdentification(text) {
    const result = {
        species: '',
        scientificName: '',
        waterType: ''
    };

    if (!text) return result;

    // Try to parse as JSON first (new format)
    try {
        const jsonData = JSON.parse(text);
        return {
            species: jsonData.species || '',
            scientificName: jsonData.scientific_name || '',
            waterType: jsonData.water_type || ''
        };
    } catch (e) {
        // Fall back to old text parsing if not JSON
    }

    // Try to extract information from the bullet point format (legacy)
    const commonNameMatch = text.match(/\*\s*\*\*Common Name:\*\*\s*([^\n*]+)/i) || 
                          text.match(/Common Name:[^\n*]+\*\*([^\n*]+)\*/i);
    
    const scientificNameMatch = text.match(/\*\s*\*\*Scientific Name:\*\*\s*\*([^\n*]+)\*/i) ||
                              text.match(/Scientific Name:[^\n*]+\*([^\n*]+)\*/i);
    
    const waterTypeMatch = text.match(/\*\s*\*\*Water Type:\*\*\s*([^\n*]+)/i) ||
                         text.match(/Water Type:[^\n*]+\*\*([^\n*]+)\*/i);
    
    // Extract and clean the matches
    if (commonNameMatch && commonNameMatch[1]) {
        result.species = commonNameMatch[1].trim();
    }
    
    if (scientificNameMatch && scientificNameMatch[1]) {
        // Remove any markdown formatting from scientific name
        result.scientificName = scientificNameMatch[1].replace(/\*/g, '').trim();
    }
    
    if (waterTypeMatch && waterTypeMatch[1]) {
        result.waterType = waterTypeMatch[1].trim();
    }
    
    // Fallback to simpler patterns if not found in the bullet point format
    if (!result.species || !result.scientificName) {
        const lines = text.split('\n');
        for (const line of lines) {
            const trimmedLine = line.trim();
            
            // Look for common name patterns
            if (!result.species && /common name:\s*([^\n,]+)/i.test(trimmedLine)) {
                result.species = trimmedLine.split(':')[1].trim();
            }
            
            // Look for scientific name patterns
            if (!result.scientificName && /scientific name:\s*([^\n,]+)/i.test(trimmedLine)) {
                result.scientificName = trimmedLine.split(':')[1].replace(/\*/g, '').trim();
            }
        }
    }
    
    // Final fallback - if we have scientific name but no common name
    if (result.scientificName && !result.species) {
        result.species = result.scientificName.split(' ')[0];
    }

    return result;
}

// Clear image and reset fields
function clearImage() {
    const fileInput = document.getElementById('image');
    const previewContainer = document.getElementById('imagePreview');
    const previewImage = document.getElementById('previewImage');
    
    if (fileInput) fileInput.value = '';
    if (previewImage) previewImage.src = '#';
    if (previewContainer) previewContainer.classList.add('d-none');
    
    // Clear the species and scientific name fields
    const speciesField = document.getElementById('species');
    const scientificNameField = document.getElementById('scientific_name');
    const waterTypeField = document.getElementById('water_type');
    
    if (speciesField) speciesField.value = '';
    if (scientificNameField) scientificNameField.value = '';
    if (waterTypeField) waterTypeField.selectedIndex = 0;
}

// Camera functionality
let stream = null;
let currentFacingMode = 'environment'; // Start with back camera by default

// Toggle camera on/off
async function toggleCamera() {
    const cameraBtn = document.getElementById('cameraBtn');
    const cameraContainer = document.getElementById('cameraContainer');
    const video = document.getElementById('video');
    const cameraPreview = document.getElementById('cameraPreview');
    const captureBtn = document.getElementById('captureBtn');
    const usePhotoBtn = document.getElementById('usePhotoBtn');
    const retakeBtn = document.getElementById('retakeBtn');
    
    if (stream) {
        // Stop all tracks in the stream
        stream.getTracks().forEach(track => track.stop());
        stream = null;
        cameraContainer.classList.add('d-none');
        video.srcObject = null;
    } else {
        try {
            stream = await navigator.mediaDevices.getUserMedia({
                video: { 
                    facingMode: currentFacingMode,
                    width: { ideal: 1280 },
                    height: { ideal: 720 }
                },
                audio: false
            });
            
            if (video) {
                video.srcObject = stream;
                cameraContainer.classList.remove('d-none');
                cameraPreview.classList.add('d-none');
                video.classList.remove('d-none');
                
                // Reset buttons
                if (captureBtn) captureBtn.classList.remove('d-none');
                if (usePhotoBtn) usePhotoBtn.classList.add('d-none');
                if (retakeBtn) retakeBtn.classList.add('d-none');
                
                // Play the video
                return video.play().catch(err => {
                    console.error('Error playing video:', err);
                    alert('Error accessing camera stream. Please try again.');
                    toggleCamera(); // Close camera on error
                });
            }
            
        } catch (err) {
            console.error('Error accessing camera:', err);
            alert('Could not access the camera. Please make sure you have granted camera permissions.');
            
            // Reset UI on error
            if (cameraContainer) cameraContainer.classList.add('d-none');
            if (cameraBtn) cameraBtn.innerHTML = '<i class="bx bx-camera me-1"></i>Open Camera';
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
                stream = null;
            }
        }
    }
}

// Capture photo from camera
function capturePhoto() {
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const cameraPreview = document.getElementById('cameraPreview');
    const cameraImage = document.getElementById('cameraImage');
    const captureBtn = document.getElementById('captureBtn');
    const usePhotoBtn = document.getElementById('usePhotoBtn');
    const retakeBtn = document.getElementById('retakeBtn');
    
    if (!video || !canvas || !cameraPreview || !cameraImage) {
        console.error('Required elements not found');
        return;
    }
    
    try {
        // Set canvas dimensions to match video stream
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        
        // Draw video frame to canvas
        const context = canvas.getContext('2d');
        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        
        // Show the captured image
        cameraImage.src = canvas.toDataURL('image/jpeg');
        cameraPreview.classList.remove('d-none');
        video.classList.add('d-none');
        
        // Update UI
        if (captureBtn) captureBtn.classList.add('d-none');
        if (usePhotoBtn) usePhotoBtn.classList.remove('d-none');
        if (retakeBtn) retakeBtn.classList.remove('d-none');
        
    } catch (err) {
        console.error('Error capturing photo:', err);
        alert('Error capturing photo. Please try again.');
    }
}

// Switch between front and back camera
async function switchCamera() {
    if (!stream) return;
    
    const video = document.getElementById('video');
    const switchBtn = document.getElementById('switchCameraBtn');
    
    if (!video || !switchBtn) return;
    
    // Disable button during switch
    switchBtn.disabled = true;
    
    try {
        // Stop all tracks in the current stream
        stream.getTracks().forEach(track => track.stop());
        
        // Toggle between front and back camera
        currentFacingMode = currentFacingMode === 'user' ? 'environment' : 'user';
        
        // Get new stream with the other camera
        stream = await navigator.mediaDevices.getUserMedia({
            video: { 
                facingMode: currentFacingMode,
                width: { ideal: 1280 },
                height: { ideal: 720 }
            },
            audio: false
        });
        
        // Update video source
        video.srcObject = stream;
        
        // Reset UI
        const cameraPreview = document.getElementById('cameraPreview');
        const captureBtn = document.getElementById('captureBtn');
        const usePhotoBtn = document.getElementById('usePhotoBtn');
        const retakeBtn = document.getElementById('retakeBtn');
        
        if (cameraPreview) cameraPreview.classList.add('d-none');
        if (captureBtn) captureBtn.classList.remove('d-none');
        if (usePhotoBtn) usePhotoBtn.classList.add('d-none');
        if (retakeBtn) retakeBtn.classList.add('d-none');
        
        // Play the video
        await video.play();
        
    } catch (err) {
        console.error('Error switching camera:', err);
        alert('Error switching camera. Please try again.');
    } finally {
        // Re-enable button
        if (switchBtn) switchBtn.disabled = false;
    }
}

// Use the captured photo for fish identification
function usePhoto() {
    const canvas = document.getElementById('canvas');
    const imageInput = document.getElementById('image');
    
    if (!canvas || !imageInput) {
        console.error('Required elements not found');
        return;
    }
    
    // Convert canvas to blob and create a file
    canvas.toBlob(function(blob) {
        if (!blob) {
            console.error('Failed to create image blob');
            return;
        }
        
        // Create a file from the blob
        const file = new File([blob], 'captured-photo.jpg', { type: 'image/jpeg' });
        
        // Update the file input
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        imageInput.files = dataTransfer.files;
        
        // Show preview
        const preview = document.getElementById('preview');
        const previewWrapper = document.getElementById('previewWrapper');
        const imagePreview = document.getElementById('imagePreview');
        
        if (preview && previewWrapper && imagePreview) {
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
            previewWrapper.style.display = 'flex';
            imagePreview.style.display = 'block';
        }
        
        // Close the camera
        toggleCamera();
        
        // Trigger change event to process the image
        const event = new Event('change');
        imageInput.dispatchEvent(event);
        
    }, 'image/jpeg', 0.9); // 0.9 is the quality (0-1)
}

// Clear image and reset fields
function clearImage() {
    const fileInput = document.getElementById('image');
    const previewContainer = document.getElementById('imagePreview');
    const previewImage = document.getElementById('previewImage');
    
    if (fileInput) fileInput.value = '';
    if (previewImage) previewImage.src = '#';
    if (previewContainer) previewContainer.classList.add('d-none');
    
    // Clear the species and scientific name fields
    const speciesField = document.getElementById('species');
    const scientificNameField = document.getElementById('scientific_name');
    const waterTypeField = document.getElementById('water_type');
    
    if (speciesField) speciesField.value = '';
    if (scientificNameField) scientificNameField.value = '';
    if (waterTypeField) waterTypeField.selectedIndex = 0;
    
    // Clear camera preview if open
    const cameraPreview = document.getElementById('cameraPreview');
    if (cameraPreview) {
        cameraPreview.src = '#';
        cameraPreview.classList.add('d-none');
    }
}

// Initialize event listeners when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // File upload handling
    const fileInput = document.getElementById('image');
    if (fileInput) {
        // Remove any existing event listeners to prevent duplicates
        const newFileInput = fileInput.cloneNode(true);
        fileInput.parentNode.replaceChild(newFileInput, fileInput);
        
        // Add new event listener
        newFileInput.addEventListener('change', handleImageUpload);
    }
    
    // Add event listener for the camera button
    const cameraBtn = document.getElementById('cameraBtn');
    if (cameraBtn) {
        cameraBtn.addEventListener('click', function() {
            // Close any open camera streams first
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
                stream = null;
            }
            toggleCamera();
        });
    }
    
    // Add event listener for the close camera button
    const closeCameraBtn = document.getElementById('closeCameraBtn');
    if (closeCameraBtn) {
        closeCameraBtn.addEventListener('click', toggleCamera);
    }
    
    // Add event listener for the capture button
    const captureBtn = document.getElementById('captureBtn');
    if (captureBtn) {
        captureBtn.addEventListener('click', capturePhoto);
    }
    
    // Add event listener for the retake button
    const retakeBtn = document.getElementById('retakeBtn');
    if (retakeBtn) {
        retakeBtn.addEventListener('click', function() {
            const video = document.getElementById('video');
            const cameraPreview = document.getElementById('cameraPreview');
            const captureBtn = document.getElementById('captureBtn');
            const usePhotoBtn = document.getElementById('usePhotoBtn');
            const retakeBtn = document.getElementById('retakeBtn');
            
            if (video) video.classList.remove('d-none');
            if (cameraPreview) cameraPreview.classList.add('d-none');
            if (captureBtn) captureBtn.classList.remove('d-none');
            if (usePhotoBtn) usePhotoBtn.classList.add('d-none');
            if (retakeBtn) retakeBtn.classList.add('d-none');
        });
    }
    
    // Add event listener for the use photo button
    const usePhotoBtn = document.getElementById('usePhotoBtn');
    if (usePhotoBtn) {
        usePhotoBtn.addEventListener('click', usePhoto);
    }
    
    // Add event listener for the switch camera button
    const switchCameraBtn = document.getElementById('switchCameraBtn');
    if (switchCameraBtn) {
        switchCameraBtn.addEventListener('click', switchCamera);
    }
    
    // Clean up camera stream when leaving the page
    window.addEventListener('beforeunload', function() {
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
            stream = null;
        }
    });
});
