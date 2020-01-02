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
		$this->PageContentHelper = new PageContentHelper();
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
		return $this->FoodMainController->GetConfig()->GetHeader("FoodMain");
	}

	private function Body(){
		$nav = new Nav();
		$pageTexts = $this->PageContentHelper->GetPageText("FoodMain");
		return $nav->SetNavBar("Food").
		"<div class='container'>
			<div class='food-header'>
				<h1>".current($pageTexts)."</h1>
			</div>
			<div class='headertext'>
				<p>".next($pageTexts)."</p>
			</div>
			<div class='timesTicketsBtn'>
				<form action='FoodTimesIndex.php' method=''>
					<input type='submit' class='ticketsBtn' value='".next($pageTexts)."'/>
				</form>
			</div>
			<div class='restaurantsGrid-container'>
				<div class='restaurantsContainer'>
  					".$this->FoodMainController->GetRestaurants()."
  				</div>
			</div>
		</div>";
	}

	private function Footer(){
		return $this->FoodMainController->GetConfig()->SetFooter();
	}
}
?>