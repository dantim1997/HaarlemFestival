<?php
	//start when page load
	require_once("Autoloader.php");
	$ContentModel = new ContentModel();
	$ContentController = new ContentController($ContentModel);
	$view = new ContentView($ContentController, $ContentModel);
	echo $view->output();
?>