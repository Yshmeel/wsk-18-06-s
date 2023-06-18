<?php
$imagePath = 'image.png';

function getPredominantColors($imagePath, $numColors = 3) {
    $image = imagecreatefrompng($imagePath);

    $width = imagesx($image);
    $height = imagesy($image);

    $colors = array();

    for ($x = 0; $x < $width; $x++) {
        for ($y = 0; $y < $height; $y++) {
            $rgb = imagecolorat($image, $x, $y);
            $color = imagecolorsforindex($image, $rgb);

            if ($rgb == 0 || $rgb == 16777215) {
                continue;
            }

            $hex = sprintf("#%02x%02x%02x", $color['red'], $color['green'], $color['blue']);

            if (!isset($colors[$hex])) {
                $colors[$hex] = 0;
            }

            $colors[$hex]++;
        }
    }

    arsort($colors);
    $predominantColors = array_slice(array_keys($colors), 0, $numColors);

    imagedestroy($image);

    return $predominantColors;
}

// Usage example
$predominantColors = getPredominantColors($imagePath);

// Output the predominant colors
foreach ($predominantColors as $color) {
    echo "<div style='width: 50px; height: 50px; background-color: $color;'></div>";
}
?>