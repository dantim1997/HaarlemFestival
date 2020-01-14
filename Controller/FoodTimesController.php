<?php
require_once("Autoloader.php");
class FoodTimesController 
{
	private $foodTimesModel;
	private $config;

	public function __construct($foodTimesModel) {
		$this->foodTimesModel = $foodTimesModel;
		$this->config = Config::getInstance();
		$this->FoodRepository = new FoodRepository;
		$this->PageContentHelper = new PageContentHelper();
	}

	// get config
	public function GetConfig() {
		return $this->config;
	}

	// get all the times from DB to put in filter on corresponding sides
	public function GetFilterTimes($side) {
		$foodTimes = $this->FoodRepository->GetAllFoodSessions($side);
		$times = "";

		// loop through found dateTimes and represent them as Hour and Minutes.
		foreach ($foodTimes as $foodTime) {
			$time = new DateTime($foodTime["SessionStartDateTime"]);
			$time = $time->format("H:i");
			// create 'clean' name for html element label name and ids
			$cleanName = trim($time, ':');
			// each time has as name 'TimeCheckBox[]', this makes it an array of each time allowing it to be looped through easily later on
			$times .= "<label for='".$cleanName."'><input type='checkbox' class='timeCheckbox' id='".$cleanName."' name='TimeCheckbox[]' value='".$time."'>".$time."</label> <br />";
		}
		return $times;
	}

	// get all the cuisines from DB and make them in MakeCuisines()
	public function GetCuisines($start, $amount) {
		$groupedCuisines = $this->FoodRepository->GetAllCuisines();
		$cuisinesWithDuplicates = array();
		$cuisines = array();
		foreach ($groupedCuisines as $cuisine) {
			// get array with seperate cuisines by 'exploding' cuisines from DB (still grouped)
			$cuisines = explode(",", $cuisine["Cuisines"]);
			foreach ($cuisines as $cuisine) {
				$cuisinesWithDuplicates[] = $cuisine;
			}
		}
		// remove duplicates and get values from array to in result have an array with all the available cuisines from DB
		$cuisines = array_unique($cuisinesWithDuplicates);
		$cuisines = array_values($cuisines);
		// create HTML code to display all the cuisines
		return $this->MakeCuisines($cuisines, $start, $amount);
	}

	// make filter cuisines HTML code
	private function MakeCuisines($cuisines, $start, $amount) {
		$allCuisines = "";
		// a for loop with $amount is being used to prevent all cuisines to be displayed on one side. The $start and $amount values make sure they get evenly distributed on the filter.
		for ($i=$start; $i < $amount; $i++) {
			$allCuisines .= "<label for='".$cuisines[$i]."'><input type='checkbox' class='cuisineCheckbox' id='".$cuisines[$i]."' name='CuisineCheckbox[]' value='".$cuisines[$i]."'>".$cuisines[$i]."</label> <br />
				";
		}
		return $allCuisines;
	}

	// get all food restaurant sections
	public function GetSections() {
		$queryStringTimes = "";
		$queryStringCuisines = "";
		$queryStringRestaurants = "";
		$first = true;

		// create custom query depending on certain GET's being set or not (from Time and cuisine filters or from the 'main' food page)
		if (isset($_GET['TimeCheckbox'])) {
			foreach ($_GET['TimeCheckbox'] as $timeCheckbox) {
				if (!$first) {
					$queryStringTimes .= " AND ";
				}
				$queryStringTimes .= "SessionStartDateTime LIKE '%".$timeCheckbox."%'";
				$first = false;
			}
		}
		if (isset($_GET['CuisineCheckbox'])) {
			foreach ($_GET['CuisineCheckbox'] as $cuisineCheckbox) {
				if (!$first) {
					$queryStringCuisines .= " AND ";
				}
				$queryStringCuisines .= "Cuisines LIKE '%".$cuisineCheckbox."%'";
				$first = false;
			}
		} else if (isset($_GET['restaurant'])) {
			$restaurantName = $_GET['restaurant'];
			if (strpos($restaurantName, "Mr.") !== false) {
				$restaurantName = "Mr. & Mrs.";
			}
			$queryStringRestaurants = "Name LIKE '".$restaurantName."'";
		}

		// get restaurants from DB
		$foodSections = $this->FoodRepository->GetFoodSections($queryStringTimes, $queryStringCuisines, $queryStringRestaurants);
		$sections = "";
		$count = 1;

		// get HMTL code for each restaurant
		foreach ($foodSections as $foodSection) {
			// check if the amount for each restaurant is higher than zero. If not, don't bother displaying them
			if ($foodSection["Amount"] > 0) {
				// add Restaurant section code to $sections variable which gets returned and echoed
				// $count is given to give each restaurant unique HTML Id's allowing for the add to cart function
				$sections .= $this->GetSection($foodSection, $count);
				$count++;
			}
		}

		// check if results exists, otherwise return message
		if ($sections == "") {
			return "<p id='noResultsFood'>No results found.</p>";
		} else {
			return $sections;
		}
	}

	// create HTML code for each restaurant section
	private function GetSection($section, $count) {
		// get page text from database allowing text translation and 'dynamic' text
		$pageTexts = $this->PageContentHelper->GetPageText("RestaurantSection");
		return "
			<div class='restaurantSection'>
				<div class='logo'>
					".$section["Logo"]."
				</div>
				<div class='information'>
					<h2 id='restaurantName".$count."'>".$section["Name"]."</h2>
					<p class='restaurantInfoP'>".$section["Location"]." <br /> <b>".current($pageTexts).": </b>".$section["Cuisines"]."</p>
				</div>
				<div class='rating'>
					".$this->GetRating($section["Rating"])."
				</div>
				<div class='locationWidget'>
					<div class='mapouter'><div class='gmap_canvas'><iframe width='600' height='405' id='gmap_canvas' src='".$section["LocationLink"]."' frameborder='0' scrolling='no' marginheight='0' marginwidth='0'></iframe></div><style>.mapouter{position:relative;text-align:right;height:405px;width:600px;}.gmap_canvas {overflow:hidden;background:none!important;height:405px;width:600px;}</style>
					</div>
				</div>
				<div class='prices'>
					<h2 class='pricesH2'>".next($pageTexts)."</h2>
					<h4 class='pricesH4'>".next($pageTexts).": €10,00 <br /> ".next($pageTexts).": €".$this->CheckPrice($section["NormalPrice"])." <br /> ".next($pageTexts).": €".$this->CheckPrice($section["ChildPrice"])."
					</h4>
				</div>
				<div class='createReservation'>
					<div class='createReservationH2'>
						<h2>".next($pageTexts).":</h2>
					</div>
					<div class='peopleAboveOption'>
						<p id='normalP'>".next($pageTexts).":</p>
						<select class='pplAbove12' id='pplAbove12".$count."'>
							<option value='0'>0</option>
							<option value='1'>1</option>
							<option value='2'>2</option>
							<option value='3'>3</option>
							<option value='4'>4</option>
							<option value='5'>5</option>
							<option value='6'>6</option>
							<option value='7'>7</option>
							<option value='8'>8</option>
							<option value='9'>9</option>
							<option value='10'>10</option>
						</select>
					</div>
            		<br />
					<div class='peopleBelowOption'>
						<p id='childrenP'>".next($pageTexts).":</p>
						<select class='pplBelow12' id='pplBelow12".$count."'>
							<option value='0'>0</option>
							<option value='1'>1</option>
							<option value='2'>2</option>
							<option value='3'>3</option>
							<option value='4'>4</option>
							<option value='5'>5</option>
							<option value='6'>6</option>
							<option value='7'>7</option>
							<option value='8'>8</option>
							<option value='9'>9</option>
							<option value='10'>10</option>
            			</select>
					</div>
            		<br />
					<div class='pickDayOption'>
						<select class='pickDay' id='pickDay".$count."' onchange='SelectedDate(".$count.", ".$section["Id"].")'>
							<option value='Pick a day'>".next($pageTexts)."</option>
            				".$this->GetDates($section["Id"])."
            			</select>
					</div>
            		<br />
					<div class='pickSessionOption'>
						<select class='pickSession' id='pickSession".$count."' disabled>
							<option value='Pick a session'>".next($pageTexts)."</option>
            			</select>
					</div>
					<div class='specialNeeds'>
						<p class='specialNeedsP'>".next($pageTexts).":</p>
						<textarea id='extraInfo".$count."' rows='2' cols='50' maxlength='40'></textarea>
					</div>
					<div class='makeReservation'>
						<input type='hidden' id='date".$count."' value='".$section["SessionStartDateTime"]."'/>
						<input type='hidden' id='name".$count."' value='".$section["Name"]."'/>
						<input type='button' class='makeReservationBtn' value='".next($pageTexts)."' onclick='FoodAddToCartHelper(".$count.")' />
					</div>
				</div>
			</div>
			";
	}

	// create and return HTML code for restaurant rating
	private function GetRating($fullStars) {
		$stars = "";
		$emptyStars = 5 - $fullStars;
		for ($i=0; $i < $fullStars; $i++) { 
			$stars .= "<img src='http://hfteam3.infhaarlem.nl/cms/Images/Food/starFull.png' class='starFull'>
			";
		}
		for ($i=0; $i < $emptyStars; $i++) { 
			$stars .= "<img src='http://hfteam3.infhaarlem.nl/cms/Images/Food/starEmpty.png' class='starEmpty'>
			";
		}
		return $stars;
	}

	// 'cleans' up prices (turns . into ,'s and returns it)
	private function CheckPrice($givenPrice) {
		return str_replace('.', ',', (string)$givenPrice);
	}
	
	// get dates for reservation creation
	private function GetDates($id) {
		$dates = "";
		$foodDates = $this->FoodRepository->GetFoodDates();
		
		foreach ($foodDates as $foodDate) {
			$date = new DateTime($foodDate["SessionDate"]);
			$date = $date->format("d-F-Y");
			$dates .= "<option value='".$date."'>".$date."</option>";
		}
		return $dates;
	}
}

?>