<?php
	require_once("Autoloader.php");
class FoodMainController 
{
	private $FoodMainModel;
	private $Session;
	private $Config;

	public function __construct($FoodMainModel){
		$this->FoodMainModel = $FoodMainModel;
		$this->Config = Config::getInstance();
	}
	
	//get config
	public function GetConfig(){
		return $this->Config;
	}
}

?>