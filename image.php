<?php
/**
 * Baseline Image Creator
 * @author Michael Wright	@MichaelW90
 */

// Height settings
$settings = array(
	'color' => array(0, 0, 0),
	'currentHeight' => 10, 	// default to 10px height
	'minHeight' => 1		// ensure baseline is bigger than 1px
);

// Convenience function to see if a number is a valid rgb value
function valid_rgb($val=NULL) {
	return isset($val) && $val <= 255 && $val >= 0;
}

// Check for provided hex color
if (isset($_GET['hex'])) {
	// Split hex color into parts
	preg_match_all("/[a-f0-9]{2}/i", $_GET['hex'], $color);
	// Check we have a 3 parts to the hex
	if (count($color[0]) != 3) {
		$color = $settings['color'];
	} else {
		// Convert hex to decimal for RGB
		$color = array(
			hexdec($color[0][0]),
			hexdec($color[0][1]),
			hexdec($color[0][2])
		);
	}

// Check for provided R, G or B values
} else if (
	valid_rgb($_GET['r']) &&
	valid_rgb($_GET['g']) &&
	valid_rgb($_GET['b']))
{
	$color = array($_GET['r'], $_GET['g'], $_GET['b']);

	// Add alpha if present
	if (isset($_GET['a']) && $_GET['a'] >= 0 && $_GET['a'] <= 1) {
		$color[] = $_GET['a'];
	}
// Use default color if all fail
} else {
	$color = $settings['color'];
}

// Default to 10px height if they set no height.
$settings['currentHeight'] = (
	isset($_GET['height']) && $_GET['height'] > $settings['minHeight']
		? $_GET['height'] 
		: $settings['currentHeight']
);

// Set the content-type to png
header("Content-type: image/png");

// Create an image at the right dimensions.
$im = imagecreate(4, $settings['currentHeight']);

// Declare some colors
$white = imagecolorallocate($im, 255, 255, 255);
if (count($color) == 4) {
	$line = imagecolorallocatealpha($im, $color[0], $color[1], $color[2], 127-$color[3]*127);
} else {
	$line = imagecolorallocatealpha($im, $color[0], $color[1], $color[2], 100);
}

// Set the image to use white as transparent
imagecolortransparent($im, $white);

// Draw a line starting bottom left, for 2px along
imageline($im, 0, $settings['currentHeight']-1, 2, $settings['currentHeight']-1, $line);

// Output the image as a png
imagepng($im);
