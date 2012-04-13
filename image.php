<?php
/**
 * Baseline Image Creator
 * @author Michael Wright	@MichaelW90
 */

// Height settings
$settings = array(
	'colour' => array(0, 0, 0),
	'currentHeight' => 10, 	// default to 10px height
	'minHeight' => 1		// ensure baseline is bigger than 1px
);
$store = array();

// Check for provided hex colour
if(isset($_GET['hex'])){
	// Add hex to list of things to store in stats
	$store['hex'] = $_GET['hex'];
	// Split hex colour into parts
	preg_match_all("/[a-f0-9]{2}/i", $_GET['hex'], $colour);
	// Check we have a 3 parts to the hex
	if(count($colour[0]) != 3){
		$colour = $settings['colour'];
	}else{
		// Convert hex to decimal for RGB
		$colour = array(
			hexdec($colour[0][0]),
			hexdec($colour[0][1]),
			hexdec($colour[0][2])
		);
	}

// Check for provided R, G or B values
}else if(isset($_GET['r']) && $_GET['r'] <= 255 && $_GET['r'] >= 0 && isset($_GET['g']) && $_GET['g'] <= 255 && $_GET['g'] >= 0 && isset($_GET['b']) && $_GET['b'] <= 255 && $_GET['b'] >= 0){
	$colour = array($_GET['r'], $_GET['g'], $_GET['b']);
	// Setup array of what to store in stats
	$store = array(
		'r' => $_GET['r'],
		'g' => $_GET['g'],
		'b' => $_GET['b']
	);
// Use default colour if all fail
}else{
	$colour = $settings['colour'];
}

// Default to 10 px height if they set no height.
$settings['currentHeight'] = (isset($_GET['height']) && $_GET['height'] > $settings['minHeight']? $_GET['height'] : $settings['currentHeight']);

// Store Height
$store['height'] = $settings['currentHeight'];

// Stats class include
if(!include_once('./Stats.class.php'))
	die('Error including Stats.class.php');
// Instantiate instance of class
$stats = new Stats();
// Store the stats!
$stats -> store($store);

// Set the content-type to png
header("Content-type: image/png"); 

// Create an image at the right dimensions.
$im = imagecreate(4, $height['currentHeight']);

// Declare some colours
$white = imagecolorallocate($im, 255, 255, 255);  
$line = imagecolorallocatealpha($im, $colour[0], $colour[1], $colour[2], 100);

// Set the image to use white as transparent
imagecolortransparent($im, $white);

// Draw a line starting bottom left, for 2px along
imageline($im, 0, $height['currentHeight']-1, 2, $height['currentHeight']-1, $line);

// Output the image as a png
imagepng($im);