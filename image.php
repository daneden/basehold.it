<?php
/**
 * Baseline Image Creator
 * @author Michael Wright <michael@wserver.co.uk>
 */

// Height settings
$height = array(
	'current' => 10, 	// default to 10px height
	'min' => 1			// ensure baseline is bigger than 1px
);

// Set the content-type to png
header("Content-type: image/png"); 

// Default to 10 px height if they set no height.
$height['current'] = (isset($_GET['height']) && $_GET['height'] > $height['min']? $_GET['height'] : $height['current']);

// Create an image at the right dimensions.
$im = imagecreate(4, $height['current']);

// Declare some colours
$white = imagecolorallocate($im, 255, 255, 255);  
$line = imagecolorallocatealpha($im, 0, 0, 0, 100);

// Set the image to use white as transparent
imagecolortransparent($im, $white);

// Draw a line starting bottom left, for 2px along
imageline($im, 0, $height['current']-1, 2, $height['current']-1, $line);

// Output the image as a png
imagepng($im);