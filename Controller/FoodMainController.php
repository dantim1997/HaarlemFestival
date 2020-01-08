<?php
	require_once("Autoloader.php");
class FoodMainController 
{
	private $FoodMainModel;
	private $Session;
	private $Config;

	public function __construct($FoodMainModel){
		$this->FoodMainModel = $FoodMainModel;
		$this->Config = Config::getInstance();
		$this->FoodRepository = new FoodRepository;
		$this->PageContentHelper = new PageContentHelper();
	}
	
	//get config
	public function GetConfig(){
		return $this->Config;
	}

	public function GetRestaurants() {
		$restaurants = "";
		$function = "";
		$restaurantInfos = $this->FoodRepository->GetRestaurantInfo();

		foreach ($restaurantInfos as $restaurantInfo) {
			// find out what language we're using
			if (isset($_SESSION['Language']) && EncryptionHelper::Decrypt($_SESSION['Language']) == 'Dutch') {
				$pageTexts = $this->DB_Helper->GetFoodDescriptionDutch($restaurantInfo["Name"]);
			} else {
				$pageTexts = $this->DB_Helper->GetFoodDescriptionEnglish($restaurantInfo["Name"]);
			}

			$restaurants .= $this->GetRestaurant($restaurantInfo, $pageTexts);
		}
		return $restaurants;
	}

	function GetRestaurant($restaurant, $pageTexts) {
		return 
		"<div class='restaurant-item'>
			<a href='FoodTimesIndex.php?restaurant=".$restaurant["Name"]."'><img src='".$restaurant["Image"]."' class='gridImage'></a>
			<p>".current($pageTexts)."</p> <p class='descriptionAndCuisines'><b>Food Cuisines</b>: ".$restaurant["Cuisines"]."</p>
		</div>";
	}
}
?>