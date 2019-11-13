<?php 
require_once("Autoloader.php");
class JazzView
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
		return $this->IndexController->GetConfig()->GetHeader("Jazz");
	}

	private function Body(){
		return "<div id='main'>
			<div class='container'>
				<image class='banner' src='Images/jazzbanner.png'>
				<div class='title'>Jazz</div>
			</div>
			<div class='content'>
				<h1>Haarlem Jazz</h1>
				<p>Find your Jazz genre on the four different days of the Haarlem Festival and visit the Jazz event!<br>There's free access for everyone on Sundays. So look for the artist or band you like and enjoy!</p>
				<h2>Artists</h2>

				<h2>Programme</h2>

				<h2>Tickets</h2>
			</div>
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