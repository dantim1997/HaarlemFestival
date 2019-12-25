<?php
/**
 * UserViewmodel
 */
class User
{
	public $Id = 0;
	public $Venue= "";
	public $Location = "";
	public $Description = "";
	public $StartDateTime= "";
	public $EndDateTime= "";
	public $Price = 0.00;
	public $Artist ="";

	public function __construct($id, $venue, $location, $description, $startDateTime, $endDateTime, $price, $artist)
	{
		$this->Id = $id;
		$this->Venue = $venue;
		$this->Location = $location;
		$this->Description = $description;
		$this->StartDateTime= $startDateTime;
		$this->EndDateTime= $endDateTime;
		$this->Price= $price;
		$this->Artist = $artist;
	}
}
?>