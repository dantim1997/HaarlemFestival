<?php 
require_once("Autoloader.php");
class ContentView
{
	private $ContentController;
	private $ContentModel;

	public function __construct($contentController, $contentModel)
	{
		$this->ContentController = $contentController;
		$this->ContentModel = $contentModel;
		$this->PageContentHelper = new PageContentHelper();
	}

	//output to html
	public function output(){
		$page = "";
		$page .= $this->Header();
		$page .= $this->Body();
		$page .= $this->Footer();
		return $page;
	}

	private function Header(){
		return $this->ContentController->GetConfig()->GetHeader("Content");
	}

	private function Body(){
		$nav = new Nav();
		$this->PageContentHelper->DetermineLanguage();
		return $nav->SetNavBar("Content"). "
		<div id='main'>
			<div class='RedBar'></div>
				<article class='contentContainer'>
				".$this->ContentController->GetPage()."
				</article>
			<div class='RedBar'></div>
		</div>";
	}

	private function Footer(){
		return $this->ContentController->GetConfig()->SetFooter();
	}
}
?>