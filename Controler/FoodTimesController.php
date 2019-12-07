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
		foreach ($foodSections as $foodSection) {
			$sections .= $this->GetSection($foodSection);
		}
		return $sections;
	}

	private function GetSection($section) {
		return "
			<div class='restaurantSection'>
				<div class='logo'>
					".$section["Logo"]."
				</div>
				<div class='information'>
					<h2>".$section["Name"]."</h2>
					<p class='restaurantInfoP'>".$section["Location"]." <br /> <b>Cuisines: </b>".$section["Cuisines"]."</p>
				</div>
				<div class='rating'>
					".$this->GetRating($section["Rating"])."
				</div>
				<div class='locationWidget'>
					<div class='mapouter'><div class='gmap_canvas'><iframe width='600' height='405' id='gmap_canvas' src='".$section["LocationLink"]."' frameborder='0' scrolling='no' marginheight='0' marginwidth='0'></iframe><a href='https://www.whatismyip-address.com'>whatismyip-address.com</a></div><style>.mapouter{position:relative;text-align:right;height:405px;width:600px;}.gmap_canvas {overflow:hidden;background:none!important;height:405px;width:600px;}</style>
					</div>
				</div>
				<div class='prices'>
					<h2 class='pricesH2'>PRICES</h2>
					<h4 class='pricesH4'>Reservation fee: €10,- <br /> Normal price: €".$section["NormalPrice"].",- <br /> Price for children (below the age of 12): €".$section["ChildPrice"]."</h4>
				</div>
				<div class='createReservation'>
					<div class='createReservationH2'>
						<h2>Create your reservation:</h2>
					</div>
					<div class='peopleAboveOption'>
						<select class='pplAbove12'>
							<option value='People &gt;12'>People</option>
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
						<select class='pplBelow12'>
							<option value='Children (&lt;12)'>Children (&lt;12)</option>
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
						<select class='pickDay'>
							<option value='Pick a day'>Pick a day</option>
            				".$this->GetDateTimes($section["Name"], "Date")."
            			</select>
					</div>
            		<br />
					<div class='pickSessionOption'>
						<select class='pickSession'>
							<option value='Pick a session'>Pick a session</option>
            				".$this->GetDateTimes($section["Name"], "Time")."
            			</select>
					</div>
					<div class='specialNeeds'>
						<p class='specialNeedsP'>Any special needs (wheelchair access, allergies, etc.) can be submitted on the payment page.</p>
					</div>
					<div class='makeReservation'>
						<button class='makeReservationBtn'>Make Reservation</button>
					</div>
				</div>
			</div>";
	}

	private function GetRating($fullStars) {
		$stars = "";
		$emptyStars = 5 - $fullStars;
		for ($i=0; $i < $fullStars; $i++) { 
			$stars .= "<img src='./Images/starFull.png' class='starFull'>
			";
		}
		for ($i=0; $i < $emptyStars; $i++) { 
			$stars .= "<img src='./Images/starEmpty.png' class='starEmpty'>
			";
		}
		return $stars;
	}

	private function GetDateTimes($name, $type) {
		$dateTimes = "";
		$index = "Session";
		if ($type == "Date") {
			$foodDateTimes = $this->DB_Helper->GetFoodDates($name);
			$index .= $type;
		} else if ($type == "Time") {
			$foodDateTimes = $this->DB_Helper->GetFoodTimes($name);
			$index .= "Start".$type;
		}
		foreach ($foodDateTimes as $foodDateTime) {
			if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $foodDateTime[$index])) {
				$dateOrTime = new DateTime($foodDateTime[$index]);
				$dateOrTime = $dateOrTime->format("d/m/Y");
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