<?php 
require_once("Autoloader.php");
class FoodTimesView
{
	private $FoodTimesController;
	private $FoodTimesModel;

	public function __construct($FoodTimesController, $FoodTimesModel)
	{
		$this->FoodTimesController = $FoodTimesController;
		$this->FoodTimesModel = $FoodTimesModel;
		$this->PageContentHelper = new PageContentHelper();
	}

	//output to html
	public function output() {
		$page = "";
		$page .= $this->Header();
		$page .= $this->Body();
		$page .= $this->Footer();
		return $page;
	}

	private function Header() {
		return $this->FoodTimesController->GetConfig()->GetHeader("FoodTimes");
	}

	private function Body() {
		$nav = new Nav();
		$pageTexts = $this->PageContentHelper->GetPageText("FoodTimesView");
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