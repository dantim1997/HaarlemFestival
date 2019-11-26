<?php 
require_once("Autoloader.php");
class HistoricTicketInfoView
{
	private $HistoricTicketInfoController;
	private $HistoricTicketInfoModel;
	private $PageContentHelper;

	public function __construct($historicTicketInfoController, $historicTicketInfoModel)
	{
		$this->HistoricTicketInfoController = $historicTicketInfoController;
		$this->HistoricTicketInfoModel = $historicTicketInfoModel;
		$this->PageContentHelper = new PageContentHelper();

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
		return $this->HistoricTicketInfoController->GetConfig()->GetHeader("Historic");
	}

	private function Body(){
		$nav = new Nav();
		return $nav->SetNavBar("Historic").
		"<div id='main'>
		<div class='pageCenter'>
			<div class='ticketInfoContainer'>
				<div class='headerContainer'><div class='blackBar3'></div><h2>".$this->PageContentHelper->GetPageText("HistoricTicketInfo", "1")."</h2><div class='blackBar3'></div></div><br>
				<h5 id='centerAndWide'>".$this->PageContentHelper->GetPageText("HistoricTicketInfo", "2")."</h5>
					<div class='languageFlags'>
						<img class='languageFlag' src='".$this->PageContentHelper->GetPageImage("HistoricTicketInfo", "1")."'><h5>".$this->PageContentHelper->GetPageText("HistoricTicketInfo", "3")."</h5>
						<img class='languageFlag' src='".$this->PageContentHelper->GetPageImage("HistoricTicketInfo", "2")."'><h5>".$this->PageContentHelper->GetPageText("HistoricTicketInfo", "4")."</h5>
						<img class='languageFlag' src='".$this->PageContentHelper->GetPageImage("HistoricTicketInfo", "3")."'><h5>".$this->PageContentHelper->GetPageText("HistoricTicketInfo", "5")."</h5>
					</div>
				<h5 id='centerAndWide'>".$this->PageContentHelper->GetPageText("HistoricTicketInfo", "6")."</h5>
					<p class='dates'>	
						".$this->PageContentHelper->GetPageText("HistoricTicketInfo", "7")."<br> 	
						".$this->PageContentHelper->GetPageText("HistoricTicketInfo", "8")."<br>		
						".$this->PageContentHelper->GetPageText("HistoricTicketInfo", "9")."<br>	
						".$this->PageContentHelper->GetPageText("HistoricTicketInfo", "10")."	
					</p>
					<p class='times'>
						".$this->PageContentHelper->GetPageText("HistoricTicketInfo", "11")."<br>
						".$this->PageContentHelper->GetPageText("HistoricTicketInfo", "12")."<br>
						".$this->PageContentHelper->GetPageText("HistoricTicketInfo", "13")."<br>
						".$this->PageContentHelper->GetPageText("HistoricTicketInfo", "14")."
					</p>

				<h5 id='centerAndWide'>".$this->PageContentHelper->GetPageText("HistoricTicketInfo", "15")."</h5>
					<p class='dates'>	
						".$this->PageContentHelper->GetPageText("HistoricTicketInfo", "16")."<br>
						".$this->PageContentHelper->GetPageText("HistoricTicketInfo", "17")."<br>
						".$this->PageContentHelper->GetPageText("HistoricTicketInfo", "18")."	
					</p>
					<p class='times'>
						".$this->PageContentHelper->GetPageText("HistoricTicketInfo", "19")."<br>
						".$this->PageContentHelper->GetPageText("HistoricTicketInfo", "20")."<br>
						".$this->PageContentHelper->GetPageText("HistoricTicketInfo", "21")."
					</p>
			</div>
			<div class='ticketInfoContainer'>
				<div class='headerContainer'><div class='blackBar4'></div><h2>".$this->PageContentHelper->GetPageText("HistoricTicketInfo", "22")."</h2><div class='blackBar4'></div></div><br>
				<p class='pricesmoreHeader'>
					<b>".$this->PageContentHelper->GetPageText("HistoricTicketInfo", "23")."<br>
 					".$this->PageContentHelper->GetPageText("HistoricTicketInfo", "24")."
    			</p>
    			<p id='centerAndWide' class='pricesMoreText'>
					".$this->PageContentHelper->GetPageText("HistoricTicketInfo", "25")."
    			</p>
    			<p id='centerAndWide' class='pricesMoreText'>
					".$this->PageContentHelper->GetPageText("HistoricTicketInfo", "26")."
    			</p>
    			<p id='centerAndWide' class='pricesMoreText'>
					<b>".$this->PageContentHelper->GetPageText("HistoricTicketInfo", "27")."</b><br>
					".$this->PageContentHelper->GetPageText("HistoricTicketInfo", "28")."
    			</p>

    			<!-- Order now button -->
				<form method='post' action='historicOrderTickets.php'>	
					<input class='orderNowButton' type='submit' value='".$this->PageContentHelper->GetPageText("HistoricTicketInfo", "29")."' name='histroricOrderTicketsBTN'>
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
