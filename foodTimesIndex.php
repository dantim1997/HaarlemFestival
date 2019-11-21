<?php
	//start when page load
	require_once("Autoloader.php");
	$FoodModel = new FoodTimesModel();
	$FoodController = new FoodTimesController($FoodModel);
	$FoodView = new FoodTimesView($FoodController, $FoodModel);
	echo $FoodView->output();
?>