<?php

class Nav
{
	function __construct()
	{
	}

	function SetNavBar(){
		return"
		<div id='NavBarBorder'>
			<div class='NavBar'>
				<div><img class='NavBarImg' src='Images/HaarlemImage.png'></div>
				<div class='Active'>Home</div>
				<div class='NavLinks'>Food</div>
			</div>
		</div>";
	}
}
?>

