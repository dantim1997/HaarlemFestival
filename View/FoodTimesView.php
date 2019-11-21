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
		return $this->FoodTimesController->GetConfig()->GetHeader("FoodTimes")."<link rel='stylesheet' type='text/css' href='FoodTimesStyle.css'>";
	}

	private function Body(){
		//setnav()
		return 
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
					<input type='checkbox' class='timeCheckbox' name='1630'>16:30 <br />
					<input type='checkbox' class='timeCheckbox' name='1700'>17:00 <br />
					<input type='checkbox' class='timeCheckbox' name='1730'>17:30 <br />
					<input type='checkbox' class='timeCheckbox' name='1800'>18:00 <br />
					<input type='checkbox' class='timeCheckbox' name='1830'>18:30 <br />
				</div>
				<div class='timeSelRightSide'>
					<input type='checkbox' class='timeCheckbox' name='1900'>19:00 <br />
					<input type='checkbox' class='timeCheckbox' name='1930'>19:30 <br />
					<input type='checkbox' class='timeCheckbox' name='2000'>20:00 <br />
					<input type='checkbox' class='timeCheckbox' name='2030'>20:30 <br />
					<input type='checkbox' class='timeCheckbox' name='2100'>21:00 <br />
				</div>
			</div>
			<div class='cuisineHeader'>
				<p class='cuisineHeaderP'>Select Cuisine</p>
			</div>
			<div class='cuisineSelection'>
				<div class='cuisineSelLeftSide'>
					<input type='checkbox' class='cuisineCheckbox' name='Dutch'>Dutch <br />
					<input type='checkbox' class='cuisineCheckbox' name='French'>French <br />
					<input type='checkbox' class='cuisineCheckbox' name='Steakhouse'>Steakhouse <br />
					<input type='checkbox' class='cuisineCheckbox' name='FishAndSeafood'>Fish and Seafood <br />
					<input type='checkbox' class='cuisineCheckbox' name='Asian'>Asian <br />
				</div>
				<div class='cuisineSelRightSide'>
					<input type='checkbox' class='cuisineCheckbox' name='European'>European <br />
					<input type='checkbox' class='cuisineCheckbox' name='International'>International <br />
					<input type='checkbox' class='cuisineCheckbox' name='Modern'>Modern <br />
					<input type='checkbox' class='cuisineCheckbox' name='Argentinian'>Argentinian <br />
					<div class='searchRButton'>
						<button class='searchRBtn'>Search Restaurants</button>
					</div>
				</div>
			</div>
		</div>

		<div class='restaurants'>
			<div class='restaurantSection'>
				<div class='logo'>
					<img src='./Images/Brinkmann.png' class='restaurantInfoImages'>
				</div>
				<div class='information'>
					<h2>Grand Café Brinkmann</h2>
					<p class='restaurantInfoP'>Grote Markt 13 2011 RC Haarlem <br /> <b>Cuisines: </b>Dutch, European, Modern</p>
				</div>
				<div class='rating'>
					<img src='./Images/starFull.png' class='starFull'>
					<img src='./Images/starFull.png' class='starFull'>
					<img src='./Images/starFull.png' class='starFull'>
					<img src='./Images/starEmpty.png' class='starEmpty'>
					<img src='./Images/starEmpty.png' class='starEmpty'>
				</div>
				<div class='locationWidget'></div>
				<div class='prices'>
					<h2 class='pricesH2'>PRICES</h2>
					<h4 class='pricesH4'>Reservation fee: €10,- <br /> Normal price: €35,- <br /> Price for children (below the age of 12): €17,50</h4>
				</div>
				<div class='createReservation'>
					<div class='createReservationH2'>
						<h2>Create your reservation:</h2>
					</div>
					<div class='peopleAboveOption'>
						<select class='pplAbove12'>
							<option value='People &gt;12'>People &gt;12</option>
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
            				<option value='1st session (17:00 - 19:00)'>1st session (17:00 - 19:00)</option>
            				<option value='2nd session (19:00 - 21:00)'>2nd session (19:00 - 21:00)</option>
            			</select>
					</div>
					<div class='specialNeeds'>
						<p class='specialNeedsP'>Any special needs (wheelchair access, allergies, etc.) can be submitted on the payment page.</p>
					</div>
					<div class='makeReservation'>
						<button class='makeReservationBtn'>Make Reservation</button>
					</div>
				</div>
			</div>
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