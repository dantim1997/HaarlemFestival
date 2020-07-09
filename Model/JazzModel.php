<?php
require_once( "Autoloader.php");
class JazzModel
{
	private $id;
	private $ArtistName;
	private $Image;
	private $Genre;
	private $Hall;
	private $Location;
	private $Price;
	private $Amount;
	private $StartDateTime;
	private $EndDateTime;
	private $Special;

	public function __construct(){
	}

	public function fillAll($id, $ArtistName, $Image, $Genre, $Hall, $Location, $Price, $Amount, $StartDateTime, $EndDateTime, $Special){
		$this->id = $id;
		$this->ArtistName = $ArtistName;
		$this->Image = $Image;
		$this->Genre = $Genre;
		$this->Hall = $Hall;
		$this->Location = $Location;
		$this->Location = $Price;
		$this->Amount = $Amount;
		$this->StartDateTime = $StartDateTime;
		$this->EndDateTime = $EndDateTime;
		$this->Special = $Special;
	}

	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getArtistName(){
		return $this->ArtistName;
	}

	public function setArtistName($ArtistName){
		$this->ArtistName = $ArtistName;
	}

	public function getImage(){
		return $this->Image;
	}

	public function setImage($Image){
		$this->Image = $Image;
	}

	public function getGenre(){
		return $this->Genre;
	}

	public function setGenre($Genre){
		$this->Genre = $Genre;
	}

	public function getHall(){
		return $this->Hall;
	}

	public function setHall($Hall){
		$this->Hall = $Hall;
	}

	public function getLocation(){
		return $this->Location;
	}

	public function setLocation($Location){
		$this->Location = $Location;
	}

	public function getPrice(){
		return $this->Price;
	}

	public function setPrice($Price){
		$this->Price = $Price;
	}

	public function getAmount(){
		return $this->Amount;
	}

	public function setAmount($Amount){
		$this->Amount = $Amount;
	}

	public function getStartDateTime(){
		return $this->StartDateTime;
	}

	public function setStartDateTime($StartDateTime){
		$this->StartDateTime = $StartDateTime;
	}

	public function getEndDateTime(){
		return $this->EndDateTime;
	}

	public function setEndDateTime($EndDateTime){
		$this->EndDateTime = $EndDateTime;
	}

	public function getSpecial(){
		return $this->Special;
	}

	public function setSpecial($Special){
		$this->Special = $Special;
	}
}
?>