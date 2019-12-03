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
			<form action='' method='get' class='searchRButton'>
				<div class='searchHeader'>
					<h2 class='searchRestaurants'>Search Restaurants</h2>
				</div>
				<div class='timeHeader'>
					<p class='timeHeaderP'>Pick your time</p>
				</div>
				<div class='timeSelection'>
					<div class='timeSelLeftSide'>
						".$this->FoodTimesController->GetFilterTimes("SELECT SessionStartDateTime FROM foodrestaurants ORDER BY SessionStartDateTime LIMIT 5")."
					</div>
					<div class='timeSelRightSide'>
						".$this->FoodTimesController->GetFilterTimes("SELECT SessionStartDateTime FROM foodrestaurants ORDER BY SessionStartDateTime LIMIT 5 OFFSET 5")."
					</div>
				</div>
				<div class='cuisineHeader'>
					<p class='cuisineHeaderP'>Select Cuisine</p>
				</div>
				<div class='cuisineSelection'>
					<div class='cuisineSelLeftSide'>
						<label for='Dutch'><input type='checkbox' class='cuisineCheckbox' id='Dutch' name='CuisineCheckbox[]' value='Dutch'>Dutch</label> <br />
						<label for='Fishandseafood'><input type='checkbox' class='cuisineCheckbox' id='Fishandseafood' name='CuisineCheckbox[]' value='Fish and seafood'>Fish and seafood</label> <br />
						<label for='Asian'><input type='checkbox' class='cuisineCheckbox' id='Asian' name='CuisineCheckbox[]' value='Asian'>Asian</label> <br />
						<label for='Steakhouse'><input type='checkbox' class='cuisineCheckbox' id='Steakhouse' name='CuisineCheckbox[]' value='Steakhouse'>Steakhouse</label> <br />
						<label for='French'><input type='checkbox' class='cuisineCheckbox' id='French' name='CuisineCheckbox[]' value='French'>French</label> <br />
					</div>
					<div class='cuisineSelRightSide'>
						<label for='European'><input type='checkbox' class='cuisineCheckbox' id='European' name='CuisineCheckbox[]' value='European'>European</label> <br />
						<label for='International'><input type='checkbox' class='cuisineCheckbox' id='International' name='CuisineCheckbox[]' value='International'>International</label> <br />
						<label for='Modern'><input type='checkbox' class='cuisineCheckbox' id='Modern' name='CuisineCheckbox[]' value='Modern'>Modern</label> <br />
						<label for='Argentinian'><input type='checkbox' class='cuisineCheckbox' id='Argentinian' name='CuisineCheckbox[]' value='Argentinian'>Argentinian</label> <br />
						<input type='submit' class='searchRBtn' name='searchButton' value='Search Restaurants' />
					</div>
				</div>
			</form>
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