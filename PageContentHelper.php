<?php
class PageContentHelper 
{
	public function __construct(){
		$this->DB_Helper = new DB_Helper;
	}
	

	public function GetPageText($page, $sequence){
		return $this->DB_Helper->Get_PageText($page, $sequence);
	}

	public function GetPageImage($page, $sequence){
		return $this->DB_Helper->Get_PageImage($page, $sequence);
	}

}


?>