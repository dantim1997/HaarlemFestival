<?php 
require_once("Autoloader.php");
class FoodTimesView
{
	private $FoodTimesController;
	private $FoodTimesModel;
	private $restaurantPrices;

	public function __construct($FoodTimesController, $FoodTimesModel)
	{
		$this->FoodTimesController = $FoodTimesController;
		$this->FoodTimesModel = $FoodTimesModel;
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
		return $this->FoodTimesController->GetConfig()->GetHeader("FoodTimes");
	}

	private function Body(){
		$nav = new Nav();
		return $nav->SetNavBar("Food").
		"
		<div class='restaurantFilter'>
			<div class='searchHeader'>
				<h2 class='searchRestaurants'>Search Restaurants</h2>
			</div>
			<div class='timeHeader'>
				<p class='timeHeaderP'>Pick your time</p>
			</div>
			<div class='timeSelection'>
				<div class='timeSelLeftSide'>
					".$this->FoodTimesController->GetTimes("SELECT SessionStartDateTime FROM foodrestaurants LIMIT 5")."
				</div>
				<div class='timeSelRightSide'>
					".$this->FoodTimesController->GetTimes("SELECT SessionStartDateTime FROM foodrestaurants LIMIT 5 OFFSET 5")."
				</div>
			</div>
			<div class='cuisineHeader'>
				<p class='cuisineHeaderP'>Select Cuisine</p>
			</div>
			<div class='cuisineSelection'>
				<div class='cuisineSelLeftSide'>
					<label for='Dutch'><input type='checkbox' class='cuisineCheckbox' id='Dutch' name='Dutch'>Dutch</label> <br />
					<label for='French'><input type='checkbox' class='cuisineCheckbox' id='French' name='French'>French</label> <br />
					<label for='Steakhouse'><input type='checkbox' class='cuisineCheckbox' id='Steakhouse' name='Steakhouse'>Steakhouse</label> <br />
					<label for='FishAndSeafood'><input type='checkbox' class='cuisineCheckbox' id='FishAndSeafood' name='FishAndSeaFood'>Fish and Seafood</label> <br />
					<label for='Asian'><input type='checkbox' class='cuisineCheckbox' id='Asian' name='Asian'>Asian</label> <br />
				</div>
				<div class='cuisineSelRightSide'>
					<label for='European'><input type='checkbox' class='cuisineCheckbox' id='European' name='European'>European</label> <br />
					<label for='International'><input type='checkbox' class='cuisineCheckbox' id='International' name='International'>International</label> <br />
					<label for='Modern'><input type='checkbox' class='cuisineCheckbox' id='Modern' name='Modern'>Modern</label> <br />
					<label for='Argentinian'><input type='checkbox' class='cuisineCheckbox' id='Argentinian' name='Argentinian'>Argentinian</label> <br />
					<div class='searchRButton'>
						<button class='searchRBtn'>Search Restaurants</button>
					</div>
				</div>
			</div>
		</div>

		<div class='restaurants'>
			".$this->FoodTimesController->GetSections()."
		</div>
		";
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