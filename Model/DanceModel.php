<?php
require_once( "Autoloader.php");
class DanceModel
{
	private $Artists;
	function __construct(){
	}

	Public function GetArtists(){
		return $this->Artists;
	}

	Public function SetArtists($value){
		$this->Artists = $value;
	}
}
?>