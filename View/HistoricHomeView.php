<?php 
require_once("Autoloader.php");
class HistoricHomeView
{
	private $HistoricHomeController;
	private $HistoricHomeModel;
	private $PageContentHelper;

	public function __construct($historicHomeController, $historicHomeModel)
	{
		$this->HistoricHomeController = $historicHomeController;
		$this->HistoricHomeModel = $historicHomeModel;
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
		return $this->HistoricHomeController->GetConfig()->GetHeader("Historic");
	}

	private function Body(){
		$nav = new Nav();
		//Getting all page content of Historic home in an array
		$pageTexts = $this->PageContentHelper->GetPageText("HistoricHome");
		$pageImages = $this->PageContentHelper->GetPageImage("HistoricHome");
		return $nav->SetNavBar("Historic"). 
		"<div id='main'>
			<div class='historicBoxCenter'>
				<div class='headerContainer'><div class='blackBar'></div><h1>".current($pageTexts)."</h1><div class='blackBar'></div></div><br>
				<h4>".next($pageTexts)."</h4>
				<p class='boxText'>".next($pageTexts)."<p>

				<h4>".next($pageTexts)."</h4>
				<div class='languageFlagsHome'>
						<img class='languageFlagHome' src='".current($pageImages)."'>
						<img class='languageFlagHome' src='".next($pageImages)."'>
						<img class='languageFlagHome' src='".next($pageImages)."'>
					</div>
			</div>
			<div class='historicBoxes'>
				<div class='historicBox'>
					<div class='headerContainer'><div class='blackBar2'></div><h2>".next($pageTexts)."</h2><div class='blackBar2'></div></div><br>
					<h4><b>".next($pageTexts)."</b></h4>
					<ul class='venueList'>
						<li>".next($pageTexts)."</li>
						<li>".next($pageTexts)."</li>
						<li>".next($pageTexts)."</li>
					</ul>
					<ul class='venueList'>
						<li>".next($pageTexts)."</li>
						<li>".next($pageTexts)."</li>
						<li>".next($pageTexts)."</li>
					</ul>
					<ul class='venueList'>
						<li>".next($pageTexts)."</li>
						<li>".next($pageTexts)."</li>
						<li>".next($pageTexts)."</li>						
					</ul>

					<!-- Venues button -->
					<a href='HistoricVenues.php' id='historicHomeButtons'  name='historicVenues'>".next($pageTexts)."</a>
				</div>

				
				<div class='historicBox'>
					<div class='headerContainer'><div class='blackBar2'></div><h2>".next($pageTexts)."</h2><div class='blackBar2'></div></div><br>
					<ul class='pricesList'>
						<li class='liLeft'>".next($pageTexts)."</li>
						<li class='liLeft'>".next($pageTexts)."</li>
					</ul>

					<!-- Tickets button -->
					<a href='HistoricTicketInfo.php' id='historicHomeButtons' type='submit' name='histroricTicketInfoBTN'>".next($pageTexts)."</a>
				</div>
			</div>

			<!-- Download route button -->
			<a href='https://www.google.nl/maps/dir/St+Bavo,+Grote+Markt,+Haarlem/Grote+Markt,+2011+RD+Haarlem/Frans+Hals+Museum+-+Hal,+Grote+Markt,+Haarlem/Proveniershof,+Grote+Houtstraat,+Haarlem/Jopenkerk+Haarlem,+Gedempte+Voldersgracht,+Haarlem/Waalse+Kerk+Haarlem,+Begijnhof,+Haarlem/Molen+De+Adriaan+(1779),+Papentorenvest,+Haarlem/Amsterdamse+Poort,+Haarlem,+Haarlem/Hofje+van+Bakenes,+Wijde+Appelaarsteeg,+Haarlem/@52.3806353,4.6331231,16z/data=!4m56!4m55!1m5!1m1!1s0x47c5ef6bea0a4215:0x2cefd774cf4e0dab!2m2!1d4.6373349!2d52.3810706!1m5!1m1!1s0x47c5ef6b924ce7ed:0xd9721c5337b4704!2m2!1d4.6363168!2d52.3813315!1m5!1m1!1s0x47c5ef6b980372c1:0x4b0852fe3cebc6fa!2m2!1d4.636051!2d52.381114!1m5!1m1!1s0x47c5ef1555569fcf:0x1f066ef6d1316959!2m2!1d4.631349!2d52.3774464!1m5!1m1!1s0x47c5ef14ed768603:0x5ff6ab7a87061c90!2m2!1d4.6297315!2d52.3812145!1m5!1m1!1s0x47c5ef6eac878693:0x4f36049541e081f1!2m2!1d4.6392365!2d52.3824922!1m5!1m1!1s0x47c5ef6ee47c7b93:0xb548e94f26e9e63b!2m2!1d4.6427362!2d52.3838112!1m5!1m1!1s0x47c5ef663e696523:0x6b7eed60d6568553!2m2!1d4.6464488!2d52.3806052!1m5!1m1!1s0x47c5ef6946739fd1:0xf72ecd986b1f0270!2m2!1d4.6397805!2d52.3815878!3e2' target='_blank' id='historicHomeButtons' class='downloadRouteBTN'>".next($pageTexts)."<div class='routeIcon'></div></a>
		</div>";
	}

	private function Footer(){
		return $this->HistoricHomeController->GetConfig()->SetFooter();
	}
}
?>
