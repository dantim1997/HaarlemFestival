<?php
	//start when page load
	require_once("Autoloader.php");
	$HistoricHomeModel = new HistoricHomeModel();
	$HistoricHomeController = new HistoricHomeController($HistoricHomeModel);
	$view = new HistoricHomeView($HistoricHomeController, $HistoricHomeModel);
	echo $view->output();
?>