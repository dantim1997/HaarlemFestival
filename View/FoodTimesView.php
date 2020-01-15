<?php 
require_once("Autoloader.php");
class FoodTimesView
{
	// create variables to be instantiated
	private $FoodTimesController;
	private $FoodTimesModel;

	// instantiate variables
	public function __construct($FoodTimesController, $FoodTimesModel)
	{
		$this->FoodTimesController = $FoodTimesController;
		$this->FoodTimesModel = $FoodTimesModel;
		$this->PageContentHelper = new PageContentHelper();
	}

	// output to html
	public function output() {
		$page = "";
		$page .= $this->Header();
		$page .= $this->Body();
		$page .= $this->Footer();
		return $page;
	}

	// get header from config file
	private function Header() {
		return $this->FoodTimesController->GetConfig()->GetHeader("FoodTimes");
	}

	// return body HTML code, partially generically generated based upon data in database in controller
	private function Body() {
		$nav = new Nav();
		// get page text from database
		$pageTexts = $this->PageContentHelper->GetPageText("RestaurantFilterFood");
		return $nav->SetNavBar("Food").
		"
		<div class='restaurantFilter'>
			<form action='' method='get' class='searchRButton'>
				<div class='searchHeader'>
					<h2 class='searchRestaurants'>".current($pageTexts)."</h2>
				</div>
				<div class='timeHeader'>
					<p class='timeHeaderP'>".next($pageTexts)."</p>
				</div>
				<div class='timeSelection'>
					<div class='timeSelLeftSide'>
						".$this->FoodTimesController->GetFilterTimes("left")."
					</div>
					<div class='timeSelRightSide'>
						".$this->FoodTimesController->GetFilterTimes("right")."
					</div>
				</div>
				<div class='cuisineHeader'>
					<p class='cuisineHeaderP'>".next($pageTexts)."</p>
				</div>
				<div class='cuisineSelection'>
					<div class='cuisineSelLeftSide'>
						".$this->FoodTimesController->GetCuisines(0, 5)."
					</div>
					<div class='cuisineSelRightSide'>
						".$this->FoodTimesController->GetCuisines(5, 9)."
						<div class='searchRButton'>
							<button class='searchRBtn'>".next($pageTexts)."</button>
						</div>
					</div>
				</div>
			</form>
		</div>
		<div class='restaurants'>
			".$this->FoodTimesController->GetSections()."
		</div>
		";
	}

	private function Footer() {
		return $this->FoodTimesController->GetConfig()->SetFooter();
	}
}
?>