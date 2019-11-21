<?php
class Config
{
	private static $instance = null;	


	private function __construct()
	{
	}
  
	public static function getInstance()
	{
		if(!self::$instance)
		{
		self::$instance = new Config();
		}
		   
		return self::$instance;
	}

	public function GetAPIKey(){
		//return APIKey
		return "6LePibwUAAAAALoQwjvKnqjQEd_P2ZcDiHY54oTX";
	}

	public function GetHeader($header){
	//return header of each page
	return "<!DOCTYPE html>
				<html>
				<head>
				<title>".$header."</title>
				<meta charset='utf-8'>
				<meta name='viewport' content='width=device-width, initial-scale=1'>
				<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css'>
				<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>
				<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js'></script>
				<link rel='stylesheet' type='text/css' href='Style.css'>

				<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>
				<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js'></script>
				<link rel='stylesheet' type='text/css' href='//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css'>
				<script src='https://www.google.com/recaptcha/api.js?hl=en' async defer></script>
				<link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css' integrity='sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO' crossorigin='anonymous'>
				<link rel='stylesheet' type='text/css' href='Style.css'>
				<link rel='stylesheet' type='text/css' href='Popup.css'>
				</head><body>";
	}
}
?>