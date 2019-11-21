<?php 
require_once("Autoloader.php");
class FoodMainView
{
	private $FoodMainController;
	private $FoodMainModel;

	public function __construct($FoodMainController, $FoodMainModel)
	{
		$this->FoodMainController = $FoodMainController;
		$this->FoodMainModel = $FoodMainModel;
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
		return $this->FoodMainController->GetConfig()->GetHeader("Food")."<link rel='stylesheet' type='text/css' href='FoodMainStyle.css";
	}

	private function Body(){
		$nav = new Nav();
		return $nav->SetNavBar("Food").
		"<div class='container'>
			<div class='food-header'>
				<h1>Haarlem Food</h1>
			</div>
			<div class='headertext'>
				<p>The first thing you think about when you hear 'Haarlem' is probably not it's cuisine, but despite it being rather unknown, we think that it's perfect for after a long day of enjoying other events at the Haarlem festival.</p>
			</div>
			<div class='timesTicketsBtn'>
				<button class='ticketsBtn'>Times & Tickets</button>
			</div>
			<div class='restaurantsGrid-container'>
				<div class='restaurantsContainer'>
  					<div class='restaurant-item'>
  						<img src='./Images/Brinkmann.png' class='gridImage'>
  						<p>A grand café located in the center of Haarlem, and next to the Grote Kerk. <br/> <b>Food tags</b>: Dutch, European, Modern</p>
  					</div>
  					<div class='restaurant-item'>
  						<img src='./Images/ML.png' class='gridImage'>
  						<p>Restaurant ML is decorated with a Michelin star and located in the centre of Haarlem. <br/> <b>Food tags</b>: Dutch, fish, seafood and European</p>
  					</div>
  					<div class='restaurant-item'>
  						<img src='./Images/Fris.png' class='gridImage'>
  						<p>Located on the more outer ridges of Haarlem, restaurant Fris serves mainly French seasonal dishes.<br/> <b>Food tags</b>: Dutch, French, European</p>
  					</div>
  					<div class='restaurant-item'>
  						<img src='./Images/Ratatouille.png' class='gridImage'>
  						<p>Ratatouille is, as the name suggests, a French restaurant that is in posession of a Michelin star since 2014.<br/> <b>Food tags</b>: French, fish and seafood, European</p>
  					</div>
  					<div class='restaurant-item'>
  						<img src='./Images/Specktakel.png' class='gridImage'>
  						<p>Restaurant Specktakel lays in the center of Haarlem and makes food from all over the world.<br/> <b>Food tags</b>: European, International, Asian</p>
  					</div>
  					<div class='restaurant-item'>
  						<img src='./Images/Toujours.png' class='gridImage'>
  						<p>Toujours is an Urban French restaurant that has an American twist. It's located in the centre of Haarlem.</br> <b>Food tags</b>: Dutch, fish and seafood, European</p>
  					</div>
  					<div class='restaurant-item'>
  						<img src='./Images/MrMrs.png' class='gridImage'>
  						<p>Mr & Mrs is known for serving some nice wine with their food.</br> <b>Food tags</b>: Dutch, fish and seafood, European</p>
  					</div>
  					<div class='restaurant-item'>
  						<img src='./Images/GoldenBull.png' class='gridImage'>
  						<p>The golden bull is a Steak restaurant in the centre of Haarlem.</br> <b>Food tags</b>: Steakhouse, Argentinian, European</p>
  					</div>
  				</div>
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