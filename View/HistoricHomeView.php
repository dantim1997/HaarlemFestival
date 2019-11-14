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
		return $this->HistoricHomeController->GetConfig()->GetHeader("Historic");
	}

	private function Body(){
		//setnav()
		return "<div id='main'>
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
			<form method='post' action='downloadRoute.php'>	
				<input class='historicHomeButtons' id='downloadRouteBTN' type='submit' value='Download route' name='downloadRouteBTN'>
			</form>
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