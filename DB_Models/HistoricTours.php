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

	function __construct($id, $language, $description, $startDateTime, $endDateTime, $price, $typeTicket){
		$this->Id = $id;
		$this->Language = $language;
		$this->Description = $description;
		$this->StartDateTime = $startDateTime;
		$this->EndDateTime = $endDateTime;
		$this->Price = $price;
		$this->TypeTicket = $typeTicket;
	}
}

?>