<?php
	require_once( "Autoloader.php");
class ContentController 
{
	private $ContentModel;
	private $Session;
	private $Config;

	public function __construct($contentModel){
		$this->ContentModel = $contentModel;
		$this->Config = Config::getInstance();
		$this->LanguageRepository = new LanguageRepository;
	}
	
	//get config
	public function GetConfig(){
		return $this->Config;
	}

	public function GetPage(){
		$output = "";
		if (isset($_GET["id"])){
			$language = $this->GetLanguage();
			//call DB Helper
			$content = $this->LanguageRepository->GetContentPage($_GET["id"]);
			if ($language == "Dutch"){
				$output .= "<h1>".$content["DutchTitle"]."</h2>";
				$output .= $content["DutchText"];
				$output .= "<br><br><i>Voor het laatst bewerkt op:  ".$content["Date"]."</i>";
			}
			else{
				$output .= "<h1>".$content["EnglishTitle"]."</h2>";
				$output .= $content["EnglishText"];
				$output .= "<br><br><i>Last edited: ".$content["Date"]."</i>";
			}
		}
		else {
			$output .= "<h2>Requested page doesn't exists.</h2><br>";
			$output .= "<a href='javascript:window.history.back();'><button>Go back</button></a>";
		}
		return $output;
	}

	private function GetLanguage(){
		$language = 'English';
		if (isset($_SESSION['Language'])){
			$language = EncryptionHelper::Decrypt($_SESSION['Language']);
		}
		return $language;
	}
}

?>