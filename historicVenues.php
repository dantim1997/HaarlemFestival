<?php
	//start when page load
	require_once("Autoloader.php");
	$HistoricVenuesModel = new HistoricVenuesModel();
	$HistoricVenuesController = new HistoricVenuesController($HistoricVenuesModel);
	$view = new HistoricVenuesView($HistoricVenuesController, $HistoricVenuesModel);
	echo $view->output();
?>