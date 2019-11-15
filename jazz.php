<?php
	//start when page load
	require_once("Autoloader.php");
	$JazzModel = new JazzModel();
	$JazzController = new JazzController($JazzModel);
	$view = new JazzView($JazzController, $JazzModel);
	echo $view->output();
?>
