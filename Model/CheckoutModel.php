<?php
require_once( "Autoloader.php");
class CheckoutModel
{
	private $SortedDays = array();

	public $Total = 0;
	function __construct()	{}

	public function GetSortedDays()
	{
		return $this->SortedDays;
	}

	public function SetSortedDays($value)
	{
		$this->SortedDays = $value;
	}

	public function GetTotal()
	{
		return $this->Total;
	}
	
	public function SetTotal($value)
	{
		$this->Total = $value;
	}

	public function AddTotal($value)
	{
		$this->Total = $this->Total + $value;
	}

	// nieuwe total

}
?>