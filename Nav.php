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
				<div class='Active'><div class='NavActive'>Home</div></div>
				<div class='NavLinks'><div class='NavText'>Food</div></div>
				<div class='NavLinks'><div class='NavText'>Dance</div></div>
				<div class='NavLinks'><div class='NavText'>Historic</div></div>
				<div class='NavLinks'><div class='NavText'>Jazz</div></div>
				<div class='NavLinks'><div class='NavText'>Programme</div></div>
				<div class='Languages'>
					<img class='LanguagesImages ActiveLanguage' src='Images/EnglishFlag.png'>
					<img class='LanguagesImages' src='Images/NederlandFlag.jpg'>
				</div>
				<div class='ShoppingCart'>
					<div class='shopcartItems'>1</div>
				</div>
		</div>";
	}
}
?>

