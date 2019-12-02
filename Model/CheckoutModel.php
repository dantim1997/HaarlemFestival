<?php
require_once( "Autoloader.php");
class CheckoutModel
{
	public $SortedDays =array();
	function __construct(){
	}

	public function GetSortedDays(){
		return $this->SortedDays;
	}

	public function SetSortedDays($value)
	{
		$this->SortedDays = $value;
	}

}
?>