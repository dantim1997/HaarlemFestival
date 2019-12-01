<?php
class PageContentHelper 
{
	public function __construct(){
		$this->DB_Helper = new DB_Helper;
	}
	

	public function GetPageText($page){
		return $this->DB_Helper->Get_PageText($page);
	}

	public function GetPageImage($page){
		return $this->DB_Helper->Get_PageImage($page);
	}

}


?>