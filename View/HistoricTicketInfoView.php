<?php 
require_once("Autoloader.php");
class HistoricTicketInfoView
{
	private $HistoricTicketInfoController;
	private $HistoricTicketInfoModel;

	public function __construct($historicTicketInfoController, $historicTicketInfoModel)
	{
		$this->HistoricTicketInfoController = $historicTicketInfoController;
		$this->HistoricTicketInfoModel = $historicTicketInfoModel;
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
		return $this->HistoricTicketInfoController->GetConfig()->GetHeader("Historic"). "<link rel='stylesheet' type='text/css' href='historic.css'>";
	}

	private function Body(){
		$nav = new Nav();
		return $nav->SetNavBar().
		"<div id='main'>
		<div class='pageCenter'>
			<div class='ticketInfoContainer'>
				<div class='headerContainer'><div class='blackBar3'></div><h2>Time & date</h2><div class='blackBar3'></div></div><br>
				<h5 id='centerAndWide'>The tours will be available in:</h5>
					<div class='languageFlags'>
						<img class='languageFlag' src='Images/Dutchflag.png'><h5>Dutch</h5>
						<img class='languageFlag' src='Images/EnglishFlag.png'><h5>English</h5>
						<img class='languageFlag' src='Images/Chinaflag.png'><h5>Chinese</h5>
					</div>
				<h5 id='centerAndWide'>The guided tours will be held on:</h5>
					<p class='dates'>	
						Thursday 26th of Juli<br> 	
						Friday 27th of Juli<br>		
						Saturday 28th of Juli<br>	
						Sunday 29th of Juli		
					</p>
					<p class='times'>
						10:00, 13:00 and 16:00<br>
						10:00, 13:00 and 16:00<br>
						10:00, 13:00 and 16:00<br>
						10:00, 13:00 and 16:00
					</p>

				<h5 id='centerAndWide'>However the Chinese tours will only be available at the following days:</h5>
					<p class='dates'>	
						Friday 27th of Juli<br>
						Saturday 28th of Juli<br>
						Sunday 29th of Juli	
					</p>
					<p class='times'>
						13:00<br>
						13:00 and 16:00<br>
						10:00 and 13:00
					</p>
			</div>
			<div class='ticketInfoContainer'>
				<div class='headerContainer'><div class='blackBar4'></div><h2>Prices & more</h2><div class='blackBar4'></div></div><br>
				<p class='pricesmoreHeader'>
					<b>Regular Participant: € 17,50<br>
 					Family ticket (max. 4 participants): € 60<br></b>
    				(tour including one drink p.p.)
    			</p>
    			<p id='centerAndWide' class='pricesMoreText'>
					The tour starts near the Church of St. Bavo at the ‘Grote markt’<br>
					which is located in the centre of Haarlem. The exact starting location<br>
					will be marked with a giant flag marked ‘Haarlem Historic’
    			</p>
    			<p id='centerAndWide' class='pricesMoreText'>
					Each tour has a maximum of 12 participants + 1 guide.<br>
					The tour will take aproximatly 2,5 hours with a 15-minute break<br> 
					with refreshments.
    			</p>
    			<p id='centerAndWide' class='pricesMoreText'>
					<b>Please note!</b><br>
					Due to the nature of this walk participants must be a <br>
					minimum of 12 years old and no strollers are allowed.
    			</p>

    			<!-- Order now button -->
				<form method='post' action='historicOrderTickets.php'>	
					<input class='orderNowButton' type='submit' value='Order now' name='histroricOrderTicketsBTN'>
				</form>
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
