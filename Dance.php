<?php
	//start when page load
	require_once("Autoloader.php");
	$DanceModel = new DanceModel();
	$DanceController = new DanceController($DanceModel);
	$view = new DanceView($DanceController, $DanceModel);
	echo $view->output();
?>