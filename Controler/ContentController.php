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
			$output .= "<h2>TITLE</h2>";
			$output .= "<p>MAIN</p>";
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
			$language = $_SESSION['Language'];
		}
		return $language;
	}
}

?>