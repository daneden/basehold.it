<?php
/**
 * Baseline Pseudo Element Generator
 * Thanks to Michael Wright <michael@wserver.co.uk> for the image generation code
 * @author Daniel Eden <dan.eden@me.com>
 */

// Check if GET h is set as it is required.
if (!isset($_GET['height'])) die();

$queryString = array();
foreach ($_GET as $key => $value) {
	$queryString[] = $key . '=' . $value;
}

// Set the content-type to css
header("Content-type: text/css");
?>
body:after {
	position: absolute;
	widh: auto;
	height: auto;
	z-index: 9999;
	content: '';
	display: block;
	pointer-events: none;
	top: 0;
	right: 0;
	bottom: 0;
	left: 0;
	background: url(/image.php?<?php echo implode('&', $queryString); ?>) repeat top left;
}