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
		//Get all the content and put it in an array
		$pageTexts = $this->PageContentHelper->GetPageText("HistoricVenues");
		$pageImages = $this->PageContentHelper->GetPageimage("HistoricVenues");
		return $nav->SetNavBar("Historic").
		"<div id='main'>
			<div class='venuesContainer'>
				<div class='row1'>
					<div class='venueContainer'>
						<image class='venueImgs' src='".current($pageImages)."'>
						<h4 class='venueHeaders'>".current($pageTexts)."</h4>
						<p class='venueText'>".next($pageTexts)."</p>
					</div>
					<div class='venueContainer'>
						<image class='venueImgs' src='".next($pageImages)."'>
						<h4 class='venueHeaders'>".next($pageTexts)."</h4>
						<p class='venueText'>".next($pageTexts)."</p>
					</div>
					<div class='venueContainer'>
						<image class='venueImgs' src='".next($pageImages)."'>
						<h4 class='venueHeaders'>".next($pageTexts)."</h4>
						<p class='venueText'>".next($pageTexts)."</p>
					</div>
					<div class='venueContainer'>
						<image class='venueImgs' src='".next($pageImages)."'>
						<h4 class='venueHeaders'>".next($pageTexts)."</h4>
						<p class='venueText'>".next($pageTexts)."</p>
					</div>
					<div class='venueContainer'>
						<image class='venueImgs' src='".next($pageImages)."'>
						<h4 class='venueHeaders'>".next($pageTexts)."</h4>
						<p class='venueText'>".next($pageTexts)."</p>
					</div>
				</div>	
				<div class='row2'>
					<div class='venueContainer'>
						<image class='venueImgs' src='".next($pageImages)."'>
						<h4 class='venueHeaders'>".next($pageTexts)."</h4>
						<p class='venueText'>".next($pageTexts)."</p>
					</div>
					<div class='venueContainer'>
						<image class='venueImgs' src='".next($pageImages)."'>
						<h4 class='venueHeaders'>".next($pageTexts)."</h4>
						<p class='venueText'>".next($pageTexts)."</p>
					</div>
					<div class='venueContainer'>
						<image class='venueImgs' src='".next($pageImages)."'>
						<h4 class='venueHeaders'>".next($pageTexts)."</h4>
						<p class='venueText'>".next($pageTexts)."</p>
					</div>
					<div class='venueContainer'>
						<image class='venueImgs' src='".next($pageImages)."'>
						<h4 class='venueHeaders'>".next($pageTexts)."</h4>
						<p class='venueText'>".next($pageTexts)."</p>
					</div>
				</div>
			</div>
		</div>";
	}

	private function Footer(){
		return $this->HistoricVenuesController->GetConfig()->SetFooter();
	}
}
?>