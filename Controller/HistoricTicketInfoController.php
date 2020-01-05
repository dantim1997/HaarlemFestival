<?php
	require_once( "Autoloader.php");
class HistoricTicketInfoController 
{
	private $HistoricTicketInfoModel;
	private $Session;
	private $Config;

	public function __construct($historicTicketInfoModel){
		$this->HistoricTicketInfoModel = $historicTicketInfoModel;
		$this->Config = Config::getInstance();
	}
	
	//get config
	public function GetConfig(){
		return $this->Config;
	}
}

?>