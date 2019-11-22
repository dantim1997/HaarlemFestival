<?php
	//start when page load
	require_once("Autoloader.php");
	$CheckoutModel = new CheckoutModel();
	$CheckoutController = new CheckoutController($CheckoutModel);
	$view = new CheckoutView($CheckoutController, $CheckoutModel);
	echo $view->output();
?>