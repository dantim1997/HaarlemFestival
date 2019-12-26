<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

class PageContentHelper 
{
	public function __construct(){
		$this->DB_Helper = new DB_Helper;
	}
	

	public function GetPageText($page){
		$this->DetermineLanguage();

		//If Dutch is chosen switch to it.
		if (isset($_SESSION['Language']) && $_SESSION['Language'] == 'Dutch') {
			return $this->DB_Helper->Get_PageTextDutch($page);
		}
		//By default we use English.
		else{
			return $this->DB_Helper->Get_PageTextEnglish($page);
		}
	}

	public function DetermineLanguage(){
		//If a language is chosen switch to it.
		if (isset($_GET['Language'])) {
			$_SESSION['Language'] = $_GET['Language'];
		}
		else{
			$_SESSION['Language'] = 'English';
		}
	}

	public function GetPageImage($page){
		return $this->DB_Helper->Get_PageImage($page);
	}

}


?>