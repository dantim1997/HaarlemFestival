<?php 
require_once("Autoloader.php");
class IndexView
{
	private $IndexController;
	private $IndexModel;
	private $PageContentHelper;

	public function __construct($indexController, $indexModel)
	{
		$this->IndexController = $indexController;
		$this->IndexModel = $indexModel;
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
		return $this->IndexController->GetConfig()->GetHeader("Home");
	}

	private function Body(){
		$nav = new Nav();
		$pageTexts = $this->PageContentHelper->GetPageText("Index");
		$pageImages = $this->PageContentHelper->GetPageimage("Index");
		return $nav->SetNavBar("Home"). "
		<div id='main'>
			<div class='RedBar'></div>
			<div class='HomepageImages'>
				<image class='Logo' src='".current($pageImages)."'>
					<div class='Imagecontainer'>
						<image class='HomepageImage' src='".next($pageImages)."'>
					    <div class='overlay' id='Food' onclick='ToEvent(id)'>
						  <div class='imageText'>".current($pageTexts)."</div>
						</div>
					</div>
					<div class='Imagecontainer'>
						<image class='HomepageImage' src='".next($pageImages)."'>
						<div class='overlay' id='Dance' onclick='ToEvent(id)'>
						    <div class='imageText'>".next($pageTexts)."</div>
						</div>
					</div>
					<div class='Imagecontainer'>
						<image class='HomepageImage' src='".next($pageImages)."'>
						<div class='overlay' id='Historic' onclick='ToEvent(id)'>
						    <div class='imageText'>".next($pageTexts)."</div>
						</div>
					</div>
					<div class='Imagecontainer'>
						<image class='HomepageImage' src='".next($pageImages)."'>
						<div class='overlay' id='Jazz' onclick='ToEvent(id)'>
						    <div class='imageText'>".next($pageTexts)."</div>
						</div>
					</div>
			</div>
			<div class='RedBar'></div>

		</div>";
	}

	private function Footer(){
		return $this->IndexController->GetConfig()->SetFooter();
	}
}
?>