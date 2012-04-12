<?php
/**
 * Baseline Pseudo Element Generator
 * Thanks to Michael Wright <michael@wserver.co.uk> for the image generation code
 * @author Daniel Eden <dan.eden@me.com>
 */

// Set the content-type to css
header("Content-type: text/css");
?>
body:after {
	position: fixed;
	z-index: 9999;
	content: '';
	display: block;
	pointer-events: none;
	width: 100%;
	height: 100%;
	top: 0;
	left: 0;
	background: url(image.php?height=<?php echo $_GET['h']; ?>) repeat top left;
}