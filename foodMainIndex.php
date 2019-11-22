<?php
	//start when page load
	require_once("Autoloader.php");
	$FoodModel = new FoodMainModel();
	$FoodController = new FoodMainController($FoodModel);
	$FoodView = new FoodMainView($FoodController, $FoodModel);
	echo $FoodView->output();
?>