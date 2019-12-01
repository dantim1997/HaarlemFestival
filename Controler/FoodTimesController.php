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

	public function GetTimes($query) {
		$foodTimes = $this->DB_Helper->GetAllFoodSessions($query);
		$times = "";
		foreach ($foodTimes as $foodTime) {
			$startDateTime = $this->RemoveDate($foodTime["SessionStartDateTime"]);
			$cleanName = trim($startDateTime, ':');
			$times .= "<label for='".$cleanName."'><input type='checkbox' class='timeCheckbox' id='".$cleanName."' name='TimeCheckbox[]'>".$startDateTime."</label> <br />";
		}
		return $times;
	}

	public function GetFilterResults() {
		if (isset($_GET['TimeCheckbox'])) {
			$names = array();
			foreach ($_GET['TimeCheckbox'] as $timeCheckbox ) {
				$name = $this->DB_Helper->GetRestaurantNames($timeCheckbox);
				$names[] = $name;
			}
			foreach ($names as $name) {
				$section = $this->DB_Helper->GetFoodSections($name);
				$this->GetSection($section);
			}
		}
	}

	public function GetSections() {
		$foodSections = $this->DB_Helper->GetAllFoodSections();
		$sections = "";
		foreach ($foodSections as $section) {
			$sections .= $this->GetSection($section);
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
            				<option value='Thursday July 26'>Thursday July 26</option>
            				<option value='Friday July 27'>Friday July 27</option>
            				<option value='Saturday July 28'>Saturday July 28</option>
            				<option value='Sunday July 29'>Sunday July 29</option>
            			</select>
					</div>
            		<br />
					<div class='pickSessionOption'>
						<select class='pickSession'>
							<option value='Pick a session'>Pick a session</option>
            				".$this->GetSessions($section["Name"])."
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

	private function GetSessions($name) {
		$sessions = "";
		$foodSessions = $this->DB_Helper->GetFoodSessions($name);
		foreach ($foodSessions as $foodSession) {
			$startDateTime = $this->RemoveDate($foodSession["SessionStartDateTime"]);
		 	$sessions .= "<option value='".$startDateTime."'>".$startDateTime."</option>
		 	";
		}
		return $sessions;
	}

	private function RemoveDate($dateTime) {
		$startDateTime = substr($dateTime, 11);
		if (strlen($startDateTime) > 5) {
			$startDateTime = substr($startDateTime, 0, -3);
		}
		return $startDateTime;
	}
}

?>