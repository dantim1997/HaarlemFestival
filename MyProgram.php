<?php
	//start when page load
	require_once("Autoloader.php");
	$MyProgramModel = new MyProgramModel();
	$MyProgramController = new MyProgramController($MyProgramModel);
	$view = new MyProgramView($MyProgramController, $MyProgramModel);
	echo $view->output();
?>