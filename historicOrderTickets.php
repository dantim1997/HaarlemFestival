<?php
	//start when page load
	require_once("Autoloader.php");
	$HistoricOrderTicketsModel = new HistoricOrderTicketsModel();
	$HistoricOrderTicketsController = new HistoricOrderTicketsController($HistoricOrderTicketsModel);
	$view = new HistoricOrderTicketsView($HistoricOrderTicketsController, $HistoricOrderTicketsModel);
	echo $view->output();
?>