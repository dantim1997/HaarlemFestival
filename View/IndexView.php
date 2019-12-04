<?php 
require_once("Autoloader.php");
class IndexView
{
	private $IndexController;
	private $IndexModel;

	public function __construct($indexController, $indexModel)
	{
		$this->IndexController = $indexController;
		$this->IndexModel = $indexModel;
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
		return $nav->SetNavBar("Home"). "
		<div id='main'>
			<div class='RedBar'></div>
			<div class='HomepageImages'>
				<image class='Logo' src='Images/Logo.png'>
					<div class='Imagecontainer'>
						<image class='HomepageImage' src='Images/Food.png'>
					    <div class='overlay' id='Food' onclick='ToEvent(id)'>
						  <div class='imageText'>Haarlem<br>Food</div>
						</div>
					</div>
					<div class='Imagecontainer'>
						<image class='HomepageImage' src='Images/Dance.png'>
						<div class='overlay' id='Dance' onclick='ToEvent(id)'>
						    <div class='imageText'>Haarlem<br>Dance</div>
						</div>
					</div>
					<div class='Imagecontainer'>
						<image class='HomepageImage' src='Images/Historic.png'>
						<div class='overlay' id='Historic' onclick='ToEvent(id)'>
						    <div class='imageText'>Haarlem<br>Historic</div>
						</div>
					</div>
					<div class='Imagecontainer'>
						<image class='HomepageImage' src='Images/Jazz.png'>
						<div class='overlay' id='Jazz' onclick='ToEvent(id)'>
						    <div class='imageText'>Haarlem<br>Jazz</div>
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