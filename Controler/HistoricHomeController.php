<?php
	require_once( "Autoloader.php");
class HistoricHomeController 
{
	private $HistoricHomeModel;
	private $Session;
	private $Config;

	public function __construct($historicHomeModel){
		$this->HistoricHomeModel = $historicHomeModel;
		$this->Config = Config::getInstance();
	}
	
	//get config
	public function GetConfig(){
		return $this->Config;
	}
}

?>