<?php
/**
 * Baseline Pseudo Element Generator
 * Thanks to Michael Wright <michael@wserver.co.uk> for the image generation code
 * @author Daniel Eden <dan.eden@me.com>
 */

// Parse GET __req__
if (!isset($_GET['__req__'])) {
	$parameters = $_GET;
} else {
	$req = $_GET['__req__'];
	$parameters = array();
	$routes = array(
		"([0-9]+)" => function($matches) {
			return array("height"=>$matches[1]);
		},
		"([0-9]+)\/([a-zA-Z0-9]{6})" => function($matches) {
			return array("height"=>$matches[1],"hex"=>$matches[2]);
		},
		"([0-9]+)\/([0-9]{1,3})\/([0-9]{1,3})\/([0-9]{1,3})" => function($matches) {
			return array("height"=>$matches[1],"r"=>$matches[2],"g"=>$matches[3],"b"=>$matches[4]);
		}
	);
	foreach ($routes as $k=>$v) {
		if (preg_match("%^\/?(i\/)?$k\/?$%", $req, $matches) === 0) continue;
		$matches = array_merge(array($matches[0]), array_splice($matches, 2));
		$parameters = $v($matches);
	}
}

$queryString = array();
foreach ($parameters as $key => $value) {
	$queryString[] = $key . '=' . $value;
}
$image = "/image.php?" . implode('&', $queryString);

if (!isset($parameters['height'])) {
	die('/* A height parameter is required. */');
}

if (preg_match("%^\/?i(\/)?.*?\/?$%", $req) !== 0) {
	include 'image.php';
	die();
}

// Set the content-type to css
header("Content-type: text/css");
?>
body {
	position: relative;
}

body:after {
	position: absolute;
	width: auto;
	height: auto;
	z-index: 9999;
	content: '';
	display: block;
	pointer-events: none;
	top: 0;
	right: 0;
	bottom: 0;
	left: 0;
	background: url(<?php echo $image; ?>) repeat top left;
}