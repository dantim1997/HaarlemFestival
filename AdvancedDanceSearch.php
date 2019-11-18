<?php
	//start when page load
	require_once("Autoloader.php");
	$AdvancedDanceSearchModel = new AdvancedDanceSearchModel();
	$AdvancedDanceSearchController = new AdvancedDanceSearchController($AdvancedDanceSearchModel);
	$view = new AdvancedDanceSearchView($AdvancedDanceSearchController, $AdvancedDanceSearchModel);
	echo $view->output();
?>