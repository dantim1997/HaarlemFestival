<?php
	//start when page load
	require_once("Autoloader.php");
	$ThankYouModel = new ThankYouModel();
	$ThankYouController = new ThankYouController($ThankYouModel);
	$view = new ThankYouView($ThankYouController, $ThankYouModel);
	echo $view->output();
?>