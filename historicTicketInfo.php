<?php
	//start when page load
	require_once("Autoloader.php");
	$HistoricTicketInfoModel = new HistoricTicketInfoModel();
	$HistoricTicketInfoController = new HistoricTicketInfoController($HistoricTicketInfoModel);
	$view = new HistoricTicketInfoView($HistoricTicketInfoController, $HistoricTicketInfoModel);
	echo $view->output();
?>