<?php 
require_once("Autoloader.php");
class HistoricVenuesView
{
	private $HistoricVenuesController;
	private $HistoricVenuesModel;
	private $PageContentHelper;

	public function __construct($historicVenuesController, $historicVenuesModel)
	{
		$this->HistoricVenuesController = $historicVenuesController;
		$this->HistoricVenuesModel = $historicVenuesModel;
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
		return $this->HistoricVenuesController->GetConfig()->GetHeader("Historic");
	}

	private function Body(){
		$nav = new Nav();
		return $nav->SetNavBar("Historic").
		"<div id='main'>
			<div class='venuesContainer'>
				<div class='row1'>
					<div class='venueContainer'>
						<image class='venueImgs' src='".$this->PageContentHelper->GetPageImage("HistoricVenues", "1")."'>
						<h4 class='venueHeaders'>".$this->PageContentHelper->GetPageText("HistoricVenues", "1")."</h4>
						<p class='venueText'>".$this->PageContentHelper->GetPageText("HistoricVenues", "10")."</p>
					</div>
					<div class='venueContainer'>
						<image class='venueImgs' src='".$this->PageContentHelper->GetPageImage("HistoricVenues", "2")."'>
						<h4 class='venueHeaders'>".$this->PageContentHelper->GetPageText("HistoricVenues", "2")."</h4>
						<p class='venueText'>".$this->PageContentHelper->GetPageText("HistoricVenues", "11")."</p>
					</div>
					<div class='venueContainer'>
						<image class='venueImgs' src='".$this->PageContentHelper->GetPageImage("HistoricVenues", "3")."'>
						<h4 class='venueHeaders'>".$this->PageContentHelper->GetPageText("HistoricVenues", "3")."</h4>
						<p class='venueText'>".$this->PageContentHelper->GetPageText("HistoricVenues", "12")."</p>
					</div>
					<div class='venueContainer'>
						<image class='venueImgs' src='".$this->PageContentHelper->GetPageImage("HistoricVenues", "4")."'>
						<h4 class='venueHeaders'>".$this->PageContentHelper->GetPageText("HistoricVenues", "4")."</h4>
						<p class='venueText'>".$this->PageContentHelper->GetPageText("HistoricVenues", "13")."</p>
					</div>
					<div class='venueContainer'>
						<image class='venueImgs' src='".$this->PageContentHelper->GetPageImage("HistoricVenues", "5")."'>
						<h4 class='venueHeaders'>".$this->PageContentHelper->GetPageText("HistoricVenues", "5")."</h4>
						<p class='venueText'>".$this->PageContentHelper->GetPageText("HistoricVenues", "14")."</p>
					</div>
				</div>	
				<div class='row2'>
					<div class='venueContainer'>
						<image class='venueImgs' src='".$this->PageContentHelper->GetPageImage("HistoricVenues", "6")."'>
						<h4 class='venueHeaders'>".$this->PageContentHelper->GetPageText("HistoricVenues", "6")."</h4>
						<p class='venueText'>".$this->PageContentHelper->GetPageText("HistoricVenues", "15")."</p>
					</div>
					<div class='venueContainer'>
						<image class='venueImgs' src='".$this->PageContentHelper->GetPageImage("HistoricVenues", "7")."'>
						<h4 class='venueHeaders'>".$this->PageContentHelper->GetPageText("HistoricVenues", "7")."</h4>
						<p class='venueText'>".$this->PageContentHelper->GetPageText("HistoricVenues", "16")."</p>
					</div>
					<div class='venueContainer'>
						<image class='venueImgs' src='".$this->PageContentHelper->GetPageImage("HistoricVenues", "8")."'>
						<h4 class='venueHeaders'>".$this->PageContentHelper->GetPageText("HistoricVenues", "8")."</h4>
						<p class='venueText'>".$this->PageContentHelper->GetPageText("HistoricVenues", "17")."</p>
					</div>
					<div class='venueContainer'>
						<image class='venueImgs' src='".$this->PageContentHelper->GetPageImage("HistoricVenues", "9")."'>
						<h4 class='venueHeaders'>".$this->PageContentHelper->GetPageText("HistoricVenues", "9")."</h4>
						<p class='venueText'>".$this->PageContentHelper->GetPageText("HistoricVenues", "18")."</p>
					</div>
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