<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

class PageContentHelper 
{
	public function __construct(){
		$this->LanguageRepository = new LanguageRepository;
	}
	

	public function GetPageText($page){
		$this->DetermineLanguage();

		//If Dutch is chosen switch to it.
		if (isset($_SESSION['Language']) && EncryptionHelper::Decrypt($_SESSION['Language']) == 'Dutch') {
			return $this->LanguageRepository->Get_PageTextDutch($page);
		}
		//By default we use English.
		else{
			return $this->LanguageRepository->Get_PageTextEnglish($page);
		}
	}

	public function DetermineLanguage(){
		//If a language is chosen switch to it.
		if (isset($_GET['Language'])) {
			$_SESSION['Language'] = EncryptionHelper::Encrypt($_GET['Language']);
		}
	}

	public function GetPageImage($page){
		$images = $this->LanguageRepository->Get_PageImage($page);
		//Modify the image paths so they get the images from the cms folder
		$newImages = array();
		foreach ($images as $image) {
			array_push($newImages, $this->ModifyImageURL($image));
		}
		return $newImages;
	}

	public function ModifyImageURL($image){
		$newUrl = "http://hfteam3.infhaarlem.nl/cms/" . $image;
		return $newUrl;
	}

}


?>