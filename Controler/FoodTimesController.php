<?php
	require_once("Autoloader.php");
class FoodTimesController 
{
	private $FoodTimesModel;
	private $Session;
	private $Config;

	public function __construct($FoodTimesModel){
		$this->FoodTimesModel = $FoodTimesModel;
		$this->Config = Config::getInstance();
	}
	
	//get config
	public function GetConfig(){
		return $this->Config;
	}
}

?>