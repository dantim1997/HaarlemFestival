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
				<div><img class='NavBarImg' src='Images/HaarlemImage.png'></div>
				".$this->SetEvent("Home", $event)."
				".$this->SetEvent("Food", $event)."
				".$this->SetEvent("Dance", $event)."
				".$this->SetEvent("Historic", $event)."
				".$this->SetEvent("Jazz", $event)."
				".$this->SetEvent("MyProgram", $event)."
				
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

		<div id='myPopup' class='popup'>
			<div class='popupContent'>
				<span class='popuptext' >
					<p id='#popupHeader'>Tickets added to cart!</p>
					<hr id='hrBars'>
					<p>Tekst enzo en nog een beetje hier en daar</p>
					<hr id='hrBars'>
					<p>Tekst enzo en nog een beetje hier en daar en mogelijk daar links nog een restje</p>
					<hr id='hrBars'>
					<a href='checkout.php' class='toCheckoutBTN'>To Cart</a>
					<button class='closePopup' type='button' onclick='ShowPopup()'>Close</button>
				</span>
			</div>
		</div>";
	}

	public function SetEvent($event, $active){
		if($active == $event){
			if($event == "Home"){
				$event = "Index";
			}
			return "<div class='ActiveWrapper'>
					<div class='Active'><a class='Link' href='".$event.".php'><div class='NavActive'>".$event."</div></a></div>
				</div>";
		}
		else{
			if($event == "Home"){
				$event = "Index";
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
	}

}
?>

