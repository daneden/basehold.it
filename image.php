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

$parameters = isset($parameters) ? $parameters : $_GET;

// Check for provided hex colour
if(isset($parameters['hex'])){
	// Add hex to list of things to store in stats
	$store['hex'] = $parameters['hex'];
	// Split hex colour into parts
	preg_match_all("/[a-f0-9]{2}/i", $parameters['hex'], $colour);
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
}else if(isset($parameters['r']) && $parameters['r'] <= 255 && $parameters['r'] >= 0 && isset($parameters['g']) && $parameters['g'] <= 255 && $parameters['g'] >= 0 && isset($parameters['b']) && $parameters['b'] <= 255 && $parameters['b'] >= 0){
	$colour = array($parameters['r'], $parameters['g'], $parameters['b']);
	// Setup array of what to store in stats
	$store = array(
		'r' => $parameters['r'],
		'g' => $parameters['g'],
		'b' => $parameters['b']
	);
// Use default colour if all fail
}else{
	$colour = $settings['colour'];
}

// Default to 10 px height if they set no height.
$settings['currentHeight'] = (isset($parameters['height']) && $parameters['height'] > $settings['minHeight']? $parameters['height'] : $settings['currentHeight']);

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
$im = imagecreate(4, $settings['currentHeight']);

// Declare some colours
$white = imagecolorallocate($im, 255, 255, 255);  
$line = imagecolorallocatealpha($im, $colour[0], $colour[1], $colour[2], 100);

// Set the image to use white as transparent
imagecolortransparent($im, $white);

// Draw a line starting bottom left, for 2px along
imageline($im, 0, $settings['currentHeight']-1, 2, $settings['currentHeight']-1, $line);

// Output the image as a png
imagepng($im);