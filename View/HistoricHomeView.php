<?php 
require_once("Autoloader.php");
class HistoricHomeView
{
	private $HistoricHomeController;
	private $HistoricHomeModel;

	public function __construct($historicHomeController, $historicHomeModel)
	{
		$this->HistoricHomeController = $historicHomeController;
		$this->HistoricHomeModel = $historicHomeModel;
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
		return $this->HistoricHomeController->GetConfig()->GetHeader("Historic"). "<link rel='stylesheet' type='text/css' href='historic.css'>";
	}

	private function Body(){
		$nav = new Nav();
		return $nav->SetNavBar(). "<div id='main'>
		<div class='lol'></div>
			<div class='historicBoxCenter'>
				<div class='headerContainer'><div class='blackBar'></div><h1>Haarlem historic</h1><div class='blackBar'></div></div><br>
				<h4>a stroll through time</h4>
				<p class='boxText'>The city of Haarlem has a rich history and dates back to the 10th century. We as Haarlem festival provide a <b>guided tour</b> in which we visit several venues with great historic value. <p>

				<h4>The tours will be available in:</h4>
				<div class='languageFlagsHome'>
						<img class='languageFlagHome' src='Images/Dutchflag.png'>
						<img class='languageFlagHome' src='Images/Englishflag.png'>
						<img class='languageFlagHome' src='Images/Chinaflag.png'>
					</div>
			</div>

			<div class='historicBoxes'>
				<div class='historicBox'>
					<div class='headerContainer'><div class='blackBar2'></div><h2>Venues</h2><div class='blackBar2'></div></div><br>
					<h4><b>The venues we are going to visit during the guided tour:</b></h4>
					<ul class='venueList'>
						<li>Church of St. Bavo</li>
						<li>Grote Markt</li>
						<li>De Hallen</li>
					</ul>
					<ul class='venueList'>
						<li>Proveniershof</li>
						<li>Jopenkerk (Break location)</li>
						<li>Waalse Kerk Haarlem</li>
					</ul>
					<ul class='venueList'>
						<li>Molen de Adriaan</li>
						<li>Amsterdamse Poort</li>
						<li>Hof van Bakenes</li>						
					</ul>

					<!-- Venues button -->
					<form method='post' action='historicVenues.php'>	
						<input class='historicHomeButtons' type='submit' value='More about venues' name='historicVenues'>
					</form>
				</div>

				
				<div class='historicBox'>
					<div class='headerContainer'><div class='blackBar2'></div><h2>Tickets</h2><div class='blackBar2'></div></div><br>
					<ul class='pricesList'>
						<li>Regular Participant: € 17,50 ,-</li>
						<li>Family tickets (4 participants): € 60 ,-</li>
					</ul>

					<!-- Tickets button -->
					<form method='post' action='historicTicketInfo.php'>	
						<input class='historicHomeButtons' type='submit' value='Order tickets' name='histroricTicketInfoBTN'>
					</form>
				</div>
			</div>

			<!-- Download route button -->
			<a href='https://www.google.nl/maps/dir/St+Bavo,+Grote+Markt,+Haarlem/Grote+Markt,+2011+RD+Haarlem/Frans+Hals+Museum+-+Hal,+Grote+Markt,+Haarlem/Proveniershof,+Grote+Houtstraat,+Haarlem/Jopenkerk+Haarlem,+Gedempte+Voldersgracht,+Haarlem/Waalse+Kerk+Haarlem,+Begijnhof,+Haarlem/Molen+De+Adriaan+(1779),+Papentorenvest,+Haarlem/Amsterdamse+Poort,+Haarlem,+Haarlem/Hofje+van+Bakenes,+Wijde+Appelaarsteeg,+Haarlem/@52.3806353,4.6331231,16z/data=!4m56!4m55!1m5!1m1!1s0x47c5ef6bea0a4215:0x2cefd774cf4e0dab!2m2!1d4.6373349!2d52.3810706!1m5!1m1!1s0x47c5ef6b924ce7ed:0xd9721c5337b4704!2m2!1d4.6363168!2d52.3813315!1m5!1m1!1s0x47c5ef6b980372c1:0x4b0852fe3cebc6fa!2m2!1d4.636051!2d52.381114!1m5!1m1!1s0x47c5ef1555569fcf:0x1f066ef6d1316959!2m2!1d4.631349!2d52.3774464!1m5!1m1!1s0x47c5ef14ed768603:0x5ff6ab7a87061c90!2m2!1d4.6297315!2d52.3812145!1m5!1m1!1s0x47c5ef6eac878693:0x4f36049541e081f1!2m2!1d4.6392365!2d52.3824922!1m5!1m1!1s0x47c5ef6ee47c7b93:0xb548e94f26e9e63b!2m2!1d4.6427362!2d52.3838112!1m5!1m1!1s0x47c5ef663e696523:0x6b7eed60d6568553!2m2!1d4.6464488!2d52.3806052!1m5!1m1!1s0x47c5ef6946739fd1:0xf72ecd986b1f0270!2m2!1d4.6397805!2d52.3815878!3e2' target='_blank' class='historicHomeButtons' id='downloadRouteBTN'>Route</a>
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