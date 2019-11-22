<?php
	//start when page load
	require_once("Autoloader.php");
	$DanceTimeTableModel = new DanceTimeTableModel();
	$DanceTimeTableController = new DanceTimeTableController($DanceTimeTableModel);
	$view = new DanceTimeTableView($DanceTimeTableController, $DanceTimeTableModel);
	echo $view->output();
?>