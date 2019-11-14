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
		return $this->IndexController->GetConfig()->GetHeader("Index");
	}

	private function Body(){
		$nav = new Nav();
		return $nav->SetNavBar(). "
		<div id='main'>
			<div class='RedBar'></div>
			<div class='HomepageImages'>
				<image class='Logo' src='Images/Logo.png'>
					<image class='HomepageImage' src='Images/Food.png'>
					<image class='HomepageImage' src='Images/Dance.png'>
					<image class='HomepageImage' src='Images/Historic.png'>
					<image class='HomepageImage' src='Images/Jazz.png'>
			</div>
			<div class='RedBar'></div>

		</div>";
	}

	private function Footer(){
		return "
		<div class='Footer'>
			<p id='DesignedBy'>Designed by: Chris Lips, Thijs van Tol, Tim Gras, Stan Roozendaal en Stef Robbe
			<image class='MediaIcons' src='Images/instagram-icon-black.png'>
			<image class='MediaIcons' src='Images/facebook-icon.png'>
			</p>
		</div>
		</body></html> ";
	}
}
?>