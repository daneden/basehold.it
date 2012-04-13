<?php
/**
 * Stats Example
 * @author Michael Wright	@MichaelW90
 */


// Stats class include
if(!include_once('./Stats.class.php'))
	die('Error including Stats.class.php');

// Instantiate instance of class
$stats = new Stats();

// Store the stats!
foreach($stats -> getStats() as $key => $item){
	echo '<strong>' . ucwords($key) . ':</strong> ';
	if(is_array($item)){
		echo '<br />';
		ksort($item);
		foreach($item as $subkey => $subitem){
			echo '<strong>- ' . $subkey . ':</strong> ' . $subitem . '<br />';
		}
	}else{
		echo $item . '<br />';
	}
}