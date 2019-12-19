<?php 
require_once("Autoloader.php");
class DanceView
{
	private $DanceController;
	private $DanceModel;
	private $PageContentHelper;

	public function __construct($danceController, $danceModel)
	{
		$this->DanceController = $danceController;
		$this->DanceModel = $danceModel;
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
		return $this->DanceController->GetConfig()->GetHeader("Dance");
	}

	private function Body(){
		$pageTexts = $this->PageContentHelper->GetPageText("Dance");
		$nav = new Nav();
		return $nav->SetNavBar("Dance"). "
		<div id='main'>
			<div class='container-fluid'>
			  <div class='row'>
			    <div class='col-sm-2' ></div>
			    <div class='col-sm-9'>
					<div class='Info'>
						".current($pageTexts)."
						".next($pageTexts)."
					</div>
					<div class='Locations'>
					".next($pageTexts)."
						<table>
						".$this->DanceController->GetLocation()."
						</table>
					</div>
					<div class='Artists'>".next($pageTexts)."
						".$this->DanceController->SetArtists()."
					</div>
					<div class='Special'>
					".next($pageTexts)."
						<table>
							".$this->DanceController->GetSpecialTickets()."
						</table>
						".next($pageTexts)."
					</div>
					<a href='DanceTimeTable.php'><div class='LocationsAndTickets'>".next($pageTexts)."</div></a>
			    </div>
			    <div class='col-sm-2'></div>
			  </div>
			</div>
			
		</div>
		".$this->DanceController->GetModals()."
      
  </div>
		";
	}

	private function Footer(){
		return $this->DanceController->GetConfig()->SetFooter();
	}
}
?>