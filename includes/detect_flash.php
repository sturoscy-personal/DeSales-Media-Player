<?php
	//This script detects whether or not the user has flash installed.
	//Search through the HTTP_ACCEPT header for the Flash Player mime-type.
	$swfheader = strpos($_SERVER['HTTP_ACCEPT'],'application/x-shockwave-flash');
	if($swfheader === false) {
		$hasFlash = true;
	} else {
		$hasFlash = false;
	}
	
	//Return the boolean
	return $hasFlash;
?>