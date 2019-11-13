<?php
	//start when page load
	require_once("Autoloader.php");
	$IndexModel = new IndexModel();
	$IndexController = new IndexController($IndexModel);
	$view = new JazzView($IndexController, $IndexModel);
	echo $view->output();
?>