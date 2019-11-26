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
		return $this->FoodTimesController->GetConfig()->GetHeader("Food");
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
					<label for='1630'><input type='checkbox' class='timeCheckbox' id='1630' name='1630'>16:30</label> <br />
					<label for='1700'><input type='checkbox' class='timeCheckbox' id='1700' name='1700'>17:00</label> <br />
					<label for='1730'><input type='checkbox' class='timeCheckbox' id='1730' name='1730'>17:30</label> <br />
					<label for='1800'><input type='checkbox' class='timeCheckbox' id='1800' name='1800'>18:00</label> <br />
					<label for='1830'><input type='checkbox' class='timeCheckbox' id='1830' name='1830'>18:30</label> <br />
				</div>
				<div class='timeSelRightSide'>
					<label for='1900'><input type='checkbox' class='timeCheckbox' id='1900' name='1900'>19:00</label> <br />
					<label for='1930'><input type='checkbox' class='timeCheckbox' id='1930' name='1930'>19:30</label> <br />
					<label for='2000'><input type='checkbox' class='timeCheckbox' id='2000' name='2000'>20:00</label> <br />
					<label for='2030'><input type='checkbox' class='timeCheckbox' id='2030' name='2030'>20:30</label> <br />
					<label for='2100'><input type='checkbox' class='timeCheckbox' id='2100' name='2100'>21:00</label> <br />
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