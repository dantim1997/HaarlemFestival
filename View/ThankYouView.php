<?php 
require_once("Autoloader.php");
class ThankYouView
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
		return $this->IndexController->GetConfig()->GetHeader("ThankYou");
	}

	private function Body(){
		$nav = new Nav();
		$helper = new DB_Helper;
		$test = $helper->GetAllByOrderLine(65);
		var_dump($test);
		return $nav->SetNavBar("Home"). "
		<div id='main'>
			<div class='RedBar'></div>
			<div class='ThankYou'>
			<h1>Thank you of buying ticket(s)</h1>
			</div>
			<div class='RedBar'></div>

		</div>";
	}

	private function Footer(){
		return $this->IndexController->GetConfig()->SetFooter();
	}
}
?>