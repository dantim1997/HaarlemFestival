<?php 
require_once("Autoloader.php");
class HistoricVenuesView
{
	private $HistoricVenuesController;
	private $HistoricVenuesModel;

	public function __construct($historicVenuesController, $historicVenuesModel)
	{
		$this->HistoricVenuesController = $historicVenuesController;
		$this->HistoricVenuesModel = $historicVenuesModel;
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
		return $this->HistoricVenuesController->GetConfig()->GetHeader("Historic"). "<link rel='stylesheet' type='text/css' href='historic.css'>";
	}

	private function Body(){
		//setnav()
		return "<div id='main'>
		<div class='lol'></div>
			<div class='row1'>
				<div class='venueContainer'>
					<image class='venueImgs' src='Images/Venue1.png'>
					<h4 class='venueHeaders'>Church of St. Bavo</h4>
					<p class='venueText'>The great church of St. Bavo is one of the biggest churches in Haarlem located at the 'Grote markt'. It was build inbetween 1370 - 1520 in 'gotische' style. The wooden tower in the center of the church reaches a height of 78 meters!</p>
				</div>
				<div class='venueContainer'>
					<image class='venueImgs' src='Images/Venue2.png'>
					<h4 class='venueHeaders'>De Grote Markt</h4>
					<p class='venueText'>The Grote Markt in Haarlem is a large square in the center of haarlem, with a lot of old buildings. The square is also often being used for activiteis such as festivals and markets. </p>
				</div>
				<div class='venueContainer'>
					<image class='venueImgs' src='Images/Venue3.png'>
					<h4 class='venueHeaders'>De Hallen</h4>
					<p class='venueText'>Hal (formerly called De Hallen Haarlem) is an exhibition complex of the Frans Hals museum where modern and contemporary art is exhibited in serveral presentations. Most of what is exhibited has something to do with photo and video.</p>
				</div>
				<div class='venueContainer'>
					<image class='venueImgs' src='Images/Venue4.png'>
					<h4 class='venueHeaders'>Proveniershof</h4>
					<p class='venueText'>The Proveniershof is a courtyard in Haarlem located at Grote Houtstraat 140 which is the busiest shopping street in Haarlem. It is unique because it was not founded by a guild, rich individials or a church.</p>
				</div>
				<div class='venueContainer'>
					<image class='venueImgs' src='Images/Venue5.png'>
					<h4 class='venueHeaders'>Jopenkerk</h4>
					<p class='venueText'>Jopenkerk is a Dutch brewery from Haarlem that originated from the Haarlems Biergenootschap foundation, which was founded in 1992. The name Jopen derived from the 112 liter barrels in which Haarlem beer used to be transported.</p>
				</div>
			</div>	
			<div class='row2'>
				<div class='venueContainer'>
					<image class='venueImgs' src='Images/Venue6.png'>
					<h4 class='venueHeaders'>Waalse Kerk Haarlem</h4>
					<p class='venueText'>The Waalse Kerk is the oldest church in Haarlem, built in 1348 and a national monument. Before reformation it used to be a Catholic church called Begijnhofkapel.</p>
				</div>
				<div class='venueContainer'>
					<image class='venueImgs' src='Images/Venue7.png'>
					<h4 class='venueHeaders'>Molen de Adriaan</h4>
					<p class='venueText'>This mill was openen back in 1779. It is located at the river 'Spaarne', at that time the edge of the city. The mill was built at the fundament of an old tower called the 'Goede vrouwen toren' which was part of the old fortification around Haarlem. </p>
				</div>
				<div class='venueContainer'>
					<image class='venueImgs' src='Images/Venue8.png'>
					<h4 class='venueHeaders'>Amsterdamse Poort</h4>
					<p class='venueText'>The Amsterdamse Poort is a Haarlem city gate from 1400. The gate is called The Amstedamse Poort because it is at the end of the old route from Amsterdam to Haarlem.</p>
				</div>
				<div class='venueContainer'>
					<image class='venueImgs' src='Images/Venue9.png'>
					<h4 class='venueHeaders'>Hof van Bakenes</h4>
					<p class='venueText'>The Hofje van Bakenes is also a Haarlem courtyard. The courtyard is located on the Bakenessergracht in the center of Haarlem. The courtyard has two entrances: one at the Bakenessergracht and one at the Wijde Appelaarsteeg.</p>
				</div>
			</div>
			
		</div>";
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