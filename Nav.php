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
				<div><a href='index.php'><img class='NavBarImg' src='Images/HaarlemImage.png'></a></div>
				".$this->SetEvent("Home", $event)."
				".$this->SetEvent("Food", $event)."
				".$this->SetEvent("Dance", $event)."
				".$this->SetEvent("Historic", $event)."
				".$this->SetEvent("Jazz", $event)."
				".$this->SetEvent("MyProgram", $event)."
				<div class='right'>
					<div class='Languages'>
						<img class='LanguagesImages ActiveLanguage' src='Images/EnglishFlag.png'>
						<img class='LanguagesImages' src='Images/NederlandFlag.jpg'>
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

	public function GetCartItems(){
		if(isset($_SESSION['Tickets'])){
			$shoppingCartAmount = 0;
			foreach ($_SESSION['Tickets'] as $items) {
				$shoppingCartAmount = $shoppingCartAmount+ intval($items['Amount']);
			}
			return $shoppingCartAmount;
		}
		else{
			return 0;
		}
	}

}
?>

