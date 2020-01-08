<?php
	require_once( "Autoloader.php");
class HistoricVenuesController 
{
	private $HistoricVenuesModel;
	private $Session;
	private $Config;

	public function __construct($historicVenuesModel){
		$this->HistoricVenuesModel = $historicVenuesModel;
		$this->Config = Config::getInstance();
	}
	
	//get config
	public function GetConfig(){
		return $this->Config;
	}
}

?>