<?php
require_once( "Autoloader.php");
class DanceModel
{
	Public $Artists;
	function __construct(){
	}

	Public function GetArtists(){
		return $Artists;
	}

	Public function SetArtists($value){
		var_dump($value);
		$this->Artists = $value;
	}
}
?>