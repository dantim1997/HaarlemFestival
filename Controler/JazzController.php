<?php
	require_once( "Autoloader.php");
class JazzController 
{
	private $JazzModel;
	private $Session;
	private $Config;

	public function __construct($jazzModel){
		$this->JazzModel = $jazzModel;
		$this->Config = Config::getInstance();
	}
	
	//get config
	public function GetConfig(){
		return $this->Config;
	}
}

?>