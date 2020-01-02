<?php
	require_once("Autoloader.php");
class FoodTimesController 
{
	private $FoodTimesModel;
	private $Session;
	private $Config;

	public function __construct($FoodTimesModel){
		$this->FoodTimesModel = $FoodTimesModel;
		$this->Config = Config::getInstance();
		$this->DB_Helper = new DB_Helper;
		$this->PageContentHelper = new PageContentHelper();
	}

	//get config
	public function GetConfig(){
		return $this->Config;
	}

	public function GetFilterTimes($side) {
		$foodTimes = $this->DB_Helper->GetAllFoodSessions($side);
		$times = "";
		foreach ($foodTimes as $foodTime) {
			$time = new DateTime($foodTime["SessionStartDateTime"]);
			$time = $time->format("H:i");
			$cleanName = trim($time, ':');
			$times .= "<label for='".$cleanName."'><input type='checkbox' class='timeCheckbox' id='".$cleanName."' name='TimeCheckbox[]' value='".$time."'>".$time."</label> <br />";
		}
		return $times;
	}

	public function GetCuisines($start, $amount) {
		$groupedCuisines = $this->DB_Helper->GetAllCuisines();
		$cuisinesWithDuplicates = array();
		$cuisines = array();
		foreach ($groupedCuisines as $cuisine) {
			$cuisines = explode(",", $cuisine["Cuisines"]);
			foreach ($cuisines as $cuisine) {
				$cuisinesWithDuplicates[] = $cuisine;
			}
		}
		$cuisines = array_unique($cuisinesWithDuplicates);
		$cuisines = array_values($cuisines);
		return $this->MakeCuisines($cuisines, $start, $amount);
	}

	private function MakeCuisines($cuisines, $start, $amount) {
		$allCuisines = "";
		for ($i=$start; $i < $amount; $i++) {
			$allCuisines .= "<label for='".$cuisines[$i]."'><input type='checkbox' class='cuisineCheckbox' id='".$cuisines[$i]."' name='CuisineCheckbox[]' value='".$cuisines[$i]."'>".$cuisines[$i]."</label> <br />
				";
		}
		return $allCuisines;
	}

	public function GetSections() {
		$queryStringTimes = "";
		$queryStringCuisines = "";
		$queryStringRestaurants = "";
		$first = true;

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
			$queryStringRestaurants = "Name LIKE '".$_GET['restaurant']."'";
		}
		$foodSections = $this->DB_Helper->GetFoodSections($queryStringTimes, $queryStringCuisines, $queryStringRestaurants);
		$sections = "";
		$count = 1;
		foreach ($foodSections as $foodSection) {
			$sections .= $this->GetSection($foodSection, $count);
			$count++;
		}
		return $sections;
	}

	private function GetSection($section, $count) {
		$pageTexts = $this->PageContentHelper->GetPageText("FoodTimesController");
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
					<div class='mapouter'><div class='gmap_canvas'><iframe width='600' height='405' id='gmap_canvas' src='".$section["LocationLink"]."' frameborder='0' scrolling='no' marginheight='0' marginwidth='0'></iframe><a href='https://www.whatismyip-address.com'>whatismyip-address.com</a></div><style>.mapouter{position:relative;text-align:right;height:405px;width:600px;}.gmap_canvas {overflow:hidden;background:none!important;height:405px;width:600px;}</style>
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
							".$this->SelectOptions($section)."
						</select>
					</div>
            		<br />
					<div class='peopleBelowOption'>
						<p id='childrenP'>".next($pageTexts).":</p>
						<select class='pplBelow12' id='pplBelow12".$count."'>
							".$this->SelectOptions($section)."
            			</select>
					</div>
            		<br />
					<div class='pickDayOption'>
						<select class='pickDay' id='pickDay".$count."' onchange='SelectedDate(".$count.", ".$section["Id"].")'>
							<option value='Pick a day'>".next($pageTexts)."</option>
            				".$this->GetDateTimes($section["Id"], "Date")."
            			</select>
					</div>
            		<br />
					<div class='pickSessionOption'>
						<select class='pickSession' id='pickSession".$count."' disabled>
							<option value='Pick a session'>".next($pageTexts)."</option>
            				".$this->GetDateTimes($section["Id"], "Time")."
            			</select>
					</div>
					<div class='specialNeeds'>
						<p class='specialNeedsP'>".next($pageTexts).":</p>
						<textarea id='extraInfo".$count."' rows='2' cols='50' maxlength='40'></textarea>
					</div>
					<div class='makeReservation'>
						<input type='hidden' id='date".$count."' value='".$section["SessionStartDateTime"]."'/>
						<input type='hidden' id='name".$count."' value='".$section["Name"]."'/>
						<input type='button' class='makeReservationBtn' value='Make Reservation' onclick='FoodAddToCartHelper(".$count.")' />
						<div id='emptyTicketsWarning'>
							".$this->TicketsUnavailable($section)."
						</div>
					</div>
				</div>
			</div>
			";
	}

	private function GetRating($fullStars) {
		$stars = "";
		$emptyStars = 5 - $fullStars;
		for ($i=0; $i < $fullStars; $i++) { 
			$stars .= "<img src='./Images/Food/starFull.png' class='starFull'>
			";
		}
		for ($i=0; $i < $emptyStars; $i++) { 
			$stars .= "<img src='./Images/Food/starEmpty.png' class='starEmpty'>
			";
		}
		return $stars;
	}

	// 'cleans' up prices (turns . into ,'s and adds ,-'s to whole numbers)
	private function CheckPrice($givenPrice) {
		$haystack = (string)$givenPrice;
		$needle = '.';
		if (strpos($haystack, $needle)) {
			// it's not a whole number
			$givenPrice = str_replace('.', ',', (string)$givenPrice);
		} else {
			// it's a whole number
			$givenPrice .= ',-';
		}
		return $givenPrice;
	}

	private function SelectOptions($section) {
		$options = "";
		$amount = 0;

		if ($section["Amount"] >= 11) {
			$amount = 11;
		} else {
			$amount = $section["Amount"];
		}

		for ($i=0; $i < $amount; $i++) {
			$options .= "<option value='".$i."'>".$i."</option>";
		}
		return $options;
	}

	private function TicketsUnavailable($section) {
		if ($section["Amount"] == 0) {
			return "TICKETS SOLD OUT";
		}
	}

	private function GetDateTimes($id, $type) {
		$dateTimes = "";
		$index = "Session";
		if ($type == "Date") {
			$foodDateTimes = $this->DB_Helper->GetFoodDates($id);
			$index .= $type;
		} else if ($type == "Time") {
			$foodDateTimes = $this->DB_Helper->GetFoodTimes($id);
			$index .= "Start".$type;
		}
		foreach ($foodDateTimes as $foodDateTime) {
			if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $foodDateTime[$index])) {
				$dateOrTime = new DateTime($foodDateTime[$index]);
				$dateOrTime = $dateOrTime->format("d-F-Y");
			} else {
				$dateOrTime = new DateTime($foodDateTime[$index]);
				$dateOrTime = $dateOrTime->format("H:i");
			}
			$dateTimes .= "<option value='".$dateOrTime."'>".$dateOrTime."</option>";
		}
		return $dateTimes;
	}
}

?>