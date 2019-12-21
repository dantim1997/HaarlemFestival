<?php
class Config
{
	private static $instance = null;	
	private function __construct()
	{
	}
  
	public static function getInstance()
	{
		/*if(!self::$instance)
		{
		self::$instance = new Config();
		}*/
		   return new Config();
		//return self::$instance;
	}
	public function GetAPIKey(){
		//return APIKey
		return "6LePibwUAAAAALoQwjvKnqjQEd_P2ZcDiHY54oTX";
	}
	
	public function GetMollieKey(){
		//return APIKey
		return "test_Ds3fz4U9vNKxzCfVvVHJT2sgW5ECD8";
	}

	public function GetWebURL(){
		//return APIKey
		return "http://hfteam3.infhaarlem.nl/Main53";
	}

	public function GetHeader($header){
	//return header of each page
	return "<!DOCTYPE html>
				<html>
				<head>
				<title>".$header."</title>
				<meta charset='utf-8'>
				<meta name='viewport' content='width=device-width, initial-scale=1'>
				<link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css' integrity='sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO' crossorigin='anonymous'>
				<link rel='stylesheet' type='text/css' href='//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css'>

				<link rel='stylesheet' type='text/css' href='css/Style.css'>
				<link rel='stylesheet' type='text/css' href='css/Popup.css'>
				".$this->SetLibaries($header)."
				
				<script src='https://www.google.com/recaptcha/api.js?hl=en' async defer></script>
				<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>
				<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js'></script>
				<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>
				<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js'></script>
				<script src='Javascript.js'></script>
				</head><body>";
	}

	public function SetLibaries($event){
		if($event == "Dance"){	
			return "<link rel='stylesheet' type='text/css' href='css/DanceStyle.css'><script src='https://code.jquery.com/jquery-3.1.1.min.js'>
				</script>
				<script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js'>
				</script>";
		}
		if($event == "Historic"){
			return "<link rel='stylesheet' type='text/css' href='css/historic.css'>";
		}
		if($event == "Jazz"){
			return "<link rel='stylesheet' type='text/css' href='css/StyleJazz.css'>
			<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
			<script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js'></script>
			<script src='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js'></script>";
		}
		if($event == "FoodMain"){
			return "<link rel='stylesheet' type='text/css' href='css/FoodMainStyle.css'>";
		}
		if($event == "FoodTimes"){
			return "<link rel='stylesheet' type='text/css' href='css/FoodTimesStyle.css'>";
		}
		if($event == "MyProgram"){
			return "<link rel='stylesheet' type='text/css' href='css/MyProgram.css'>";
		}
		if($event == 'ThankYou'){
			return "<link rel='stylesheet' type='text/css' href='css/ThankYou.css'>";
		}
	}

	public function SetFooter(){
		return "<div class='Footer'>
		<p id='DesignedBy'>Designed by: Chris Lips, Thijs van Tol, Tim Gras, Stan Roozendaal en Stef Robbe
		<image class='MediaIcons' src='Images/instagram-icon-black.png'>
		<image class='MediaIcons' src='Images/facebook-icon.png'>
		</p>
	</div>
	</body></html>";
	}
}
?>