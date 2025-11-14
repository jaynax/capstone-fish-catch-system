<?php
// Create a simple colored image with text
function createImage($width, $height, $bgColor, $text = '') {
    $image = imagecreatetruecolor($width, $height);
    
    // Allocate colors
    $bg = imagecolorallocate($image, 
        hexdec(substr($bgColor, 0, 2)),
        hexdec(substr($bgColor, 2, 2)),
        hexdec(substr($bgColor, 4, 2))
    );
    $white = imagecolorallocate($image, 255, 255, 255);
    
    // Fill background
    imagefill($image, 0, 0, $bg);
    
    // Add text if provided
    if ($text) {
        $fontSize = min($width, $height) * 0.3;
        $font = 5; // Default font
        
        // Calculate text position to center it
        $textWidth = imagefontwidth($font) * strlen($text);
        $x = ($width - $textWidth) / 2;
        $y = ($height - imagefontheight($font)) / 2;
        
        imagestring($image, $font, $x, $y, $text, $white);
    }
    
    return $image;
}

// Icons configuration
$iconSizes = [72, 96, 128, 144, 152, 192, 384, 512];
$splashSizes = [
    '640x1136', '750x1334', '828x1792', '1125x2436', 
    '1242x2208', '1242x2688', '1536x2048', '1668x2224', 
    '1668x2388', '2048x2732'
];

// Create icons
foreach ($iconSizes as $size) {
    $image = createImage($size, $size, '1a56db', $size);
    $filename = __DIR__ . "/icons/icon-{$size}x{$size}.png";
    imagepng($image, $filename);
    imagedestroy($image);
    echo "Created icon: $filename\n";
}

// Create splash screens
foreach ($splashSizes as $size) {
    list($width, $height) = explode('x', $size);
    $image = createImage($width, $height, '1a56db', "{$width}x{$height}");
    $filename = __DIR__ . "/splash/splash-{$size}.png";
    imagepng($image, $filename);
    imagedestroy($image);
    echo "Created splash: $filename\n";
}

echo "\nPWA assets generated successfully!\n";
