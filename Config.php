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
				<link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css' integrity='sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO' crossorigin='anonymous'>
				<link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.3.1/css/all.css' integrity='sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU' crossorigin='anonymous'>
				<link rel='stylesheet' type='text/css' href='//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css'>
				<script src='https://www.google.com/recaptcha/api.js?hl=en' async defer></script>
				<link rel='stylesheet' type='text/css' href='historic.css'>
				<link rel='stylesheet' type='text/css' href='Style.css'></head><body>";
	}
}
?>