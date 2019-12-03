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

	public function GetFilterTimes($query) {
		$foodTimes = $this->DB_Helper->GetAllFoodSessions($query);
		$times = "";
		foreach ($foodTimes as $foodTime) {
			$startDateTime = $this->RemoveDateOrTime($foodTime["SessionStartDateTime"], "time");
			$cleanName = trim($startDateTime, ':');
			$times .= "<label for='".$cleanName."'><input type='checkbox' class='timeCheckbox' id='".$cleanName."' name='TimeCheckbox[]' value='".$startDateTime."'>".$startDateTime."</label> <br />";
		}
		return $times;
	}

	public function GetSections() {
		$queryStringTimes = "";
		$queryStringCuisines = "";
		$first = true;

		if (isset($_GET['TimeCheckbox'])) {
			foreach ($_GET['TimeCheckbox'] as $timeCheckbox) {
				if (!$first) {
					$queryStringTimes .= " OR ";
				}
				$queryStringTimes .= "SessionStartDateTime LIKE '%".$timeCheckbox."%'";
				$first = false;
			}
		}
		if (isset($_GET['CuisineCheckbox'])) {
			foreach ($_GET['CuisineCheckbox'] as $cuisineCheckbox) {
				if (!$first) {
					$queryStringCuisines .= " OR ";
				}
				$queryStringCuisines .= "Cuisines LIKE '%".$cuisineCheckbox."%'";
				$first = false;
			}
		}
		$foodSections = $this->DB_Helper->GetFoodSections($queryStringTimes, $queryStringCuisines);
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
            				".$this->GetDateTimes($section["Name"], "day")."
            			</select>
					</div>
            		<br />
					<div class='pickSessionOption'>
						<select class='pickSession'>
							<option value='Pick a session'>Pick a session</option>
            				".$this->GetDateTimes($section["Name"], "time")."
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
		$foodDateTimes = $this->DB_Helper->GetFoodDateTimes($name);
		foreach ($foodDateTimes as $foodDateTime) {
			$dateTime = $this->RemoveDateOrTime($foodDateTime["SessionStartDateTime"], $type);
			$dateTimes .= "<option value='".$dateTime."'>".$dateTime."</option>";
		}
		return $dateTimes;
	}

	private function RemoveDateOrTime($dateTime, $type) {
		if ($type == "day") {
			$dateTime = substr($dateTime, 0, 9);
		} else {
			$dateTime = substr($dateTime, 11);
			if (strlen($dateTime) > 5) {
				$dateTime = substr($dateTime, 0, -3);
			}
		}
		return $dateTime;
	}

	private function RemoveDateOrTime($dateTime, $type) {
		if ($type == "day") {
			$dateTime = substr($dateTime, 0, 9);
		} else {
			$dateTime = substr($dateTime, 11);
			if (strlen($dateTime) > 5) {
				$dateTime = substr($dateTime, 0, -3);
			}
		}
		return $dateTime;
	}
}

?>