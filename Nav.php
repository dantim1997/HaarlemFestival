<?php

class Nav
{
	function __construct()
	{
	}

	function SetNavBar(){
		return"
		<div id='NavBarBorder'>
				<div><img class='NavBarImg' src='Images/HaarlemImage.png'></div>
				<div class='ActiveWrapper'>
					<div class='Active'><a href='index.php'><div class='NavActive'>Home</div></a></div>
				</div>
				<div class='NavLinks'><a href='Food.php'><div class='NavText'>Food</div></a></div>
				<div class='NavLinks'><a href='Dance.php'><div class='NavText'>Dance</div></a></div>
				<div class='NavLinks'><a href='historicHome.php'><div class='NavText'>Historic</div></a></div>
				<div class='NavLinks'><a href='jazz.php'><div class='NavText'>Jazz</div></a></div>
				<div class='NavLinks'><a href='Programme.php'><div class='NavText'>Programme</div></a></div>
				<div class='Languages'>
					<img class='LanguagesImages ActiveLanguage' src='Images/EnglishFlag.png'>
					<img class='LanguagesImages' src='Images/NederlandFlag.jpg'>
				</div>
				<a href='checkout.php'>
					<div class='ShoppingCart'>
						<div class='shopcartItems'>1</div>
					</div>
				</a>
		</div>";
	}
}
?>

