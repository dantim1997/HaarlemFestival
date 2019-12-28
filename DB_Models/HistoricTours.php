<?php
require_once( "Autoloader.php");
Class HistoricTours{

	public $Id;
	public $Language;
	public $Description;
	public $StartDateTime;
	public $EndDateTime;
	public $Price;
	public $TypeTicket;
	public $ReferenceId;
	public $Amount;

	function __construct($id, $language, $description, $startDateTime, $endDateTime, $price, $typeTicket,  $referenceId, $amount){
		$this->Id = $id;
		$this->Language = $language;
		$this->Description = $description;
		$this->StartDateTime = $startDateTime;
		$this->EndDateTime = $endDateTime;
		$this->Price = $price;
		$this->TypeTicket = $typeTicket;
		$this->Amount = $amount;
		$this->ReferenceId = $referenceId;
	}
}

?>