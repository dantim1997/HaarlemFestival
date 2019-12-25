<?php
require_once( "Autoloader.php");
class Nav
{
	function __construct()
	{
		$this->Session = new Session;
	}

	function SetNavBar($event){
		return"
		<div id='NavBarBorder'>
				<div><a href='index.php'><img class='NavBarImg' src='Images/Nav/HaarlemImage.png'></a></div>
				".$this->SetEvent("Home", $event)."
				".$this->SetEvent("Food", $event)."
				".$this->SetEvent("Dance", $event)."
				".$this->SetEvent("Historic", $event)."
				".$this->SetEvent("Jazz", $event)."
				".$this->SetEvent("MyProgram", $event)."
				<div class='right'>
					<div class='Languages'>
						<a href='".$this->DeterminGET()."Language=English'><img class='LanguagesImages ".$this->DetermineActiveLanguage('English')."' src='Images/Nav/Englishflag.png'></a>
						<a href='".$this->DeterminGET()."Language=Dutch'><img class='LanguagesImages ".$this->DetermineActiveLanguage('Dutch')."' src='Images/Nav/Dutchflag.png'></a>
					</div>
					<a href='checkout.php'>
						<div class='ShoppingCart'>
							<div class='shopcartItems' id='shoppingcartCount'>".$this->GetCartItems()."</div>
						</div>
					</a>
				</div>
		</div>

		<div id='myPopup' class='popup'>
			<div class='popupContent'>
				<span class='popuptext' >
					<p id='#popupHeader'>Ticket(s) added to cart!</p>
					<hr id='hrBars'>
					<a href='checkout.php' class='toCheckoutBTN'>To Cart</a>
				</span>
			</div>
		</div>";
	}

	public function SetEvent($event, $active){
		if($active == $event){
			if ($event == 'Home') {
				return "<div class='ActiveWrapper'>
					<div class='Active'><a class='Link' href='index.php'><div class='NavActive'>".$event."</div></a></div>
				</div>";
			}
			return "<div class='ActiveWrapper'>
					<div class='Active'><a class='Link' href='".$event.".php'><div class='NavActive'>".$event."</div></a></div>
				</div>";
		}
		else{
			if ($event == 'Home') {
				return "<div class='NavLinks'><a class='Link' href='index.php'><div class='NavText'>".$event."</div></a></div>";
			}
			return "<div class='NavLinks'><a class='Link' href='".$event.".php'><div class='NavText'>".$event."</div></a></div>";
		}
	}

	public function GetCartItems() {
		if(isset($_SESSION['Tickets'])) {
			$shoppingCartAmount = 0;
			foreach ($_SESSION['Tickets'] as $items) {
				// check if session ticket is a reservation
				if ($items['TypeEvent'] == 1) {
					// it's a reservation, this means session ticket contains 'Child/AdultAmount' instead of just Amount, act accordingly
					$shoppingCartAmount = $shoppingCartAmount + intval($items['ChildAmount']) + intval($items['AdultAmount']);
				} else {
					$shoppingCartAmount = $shoppingCartAmount+ intval($items['Amount']);
				}
			}
			return $shoppingCartAmount;
		}
		else {
			return 0;
		}
	}

	private function DetermineActiveLanguage($language){
		if (isset($_SESSION['Language'])) {
			if ($_SESSION['Language'] == $language) {
				return 'ActiveLanguage';
			}
		}
	}

	private function DeterminGET(){
		if (extract($_GET) >= 2 && isset($_GET['Language'])) {
			if ($_GET['Language'] == 'English') {
				$newUrl = substr($_SERVER['REQUEST_URI'], 0, -17);
				return $newUrl.'&';
			}
			elseif ($_GET['Language'] == 'Dutch'){
				$newUrl = substr($_SERVER['REQUEST_URI'], 0, -15);
				return $newUrl.'&';
			}
		}
		elseif (extract($_GET) > 0 && !isset($_GET['Language'])) {
			return ''.$_SERVER['REQUEST_URI'].'&';
		}
		else{
			return '?';
		}
	}

}
?>