<?php 
require_once("Autoloader.php");
class DanceTimeTableView
{
	private $DanceTimeTableController;
	private $DanceTimeTableModel;
	private $PageContentHelper;

	public function __construct($danceTimeTableController, $danceTimeTableModel)
	{
		$this->DanceTimeTableController = $danceTimeTableController;
		$this->DanceTimeTableModel = $danceTimeTableModel;
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
		return $this->DanceTimeTableController->GetConfig()->GetHeader("Dance"). "
		<link rel='stylesheet' type='text/css' href='DanceTimeTableStyle.css'>
		<script src='Javascript.js'></script> ";
	}

	private function Body(){
		$pageTexts = $this->PageContentHelper->GetPageText("DanceTimeTable");
		$nav = new Nav();
		return $nav->SetNavBar("Dance"). "
		<div id='main'>
			<div class='container-fluid'>
			  <div class='row TimeTable'>
			    <div class='col-sm-1' ></div>
			    <div class='col-sm-11'>
				    <div class='dropdown'>
					  <button onclick='ToggleAdvanced()' class='dropbtn Search'>Advanced Search</button>
					  <div id='AdvancedSearch' class='dropdown-content'>
					  <h3>Artists:</h3>
					  <form method='get' action='AdvancedDanceSearch.php'>
					   	".$this->DanceTimeTableController->MakeArtistAdvancedSearch()."
					   	<h3>Locations:</h3>
					   		".$this->DanceTimeTableController->MakeLocationAdvancedSearch()."

					   	<input type='submit' class='SearchNow' value='Search Dance event'>
					   </form>
					  </div>
					</div>
			    <div>
				    ".$this->DanceTimeTableController->MakeTimeTables()."
					  <div class='Special'>
							<h2>Special Tickets</h2>
							<table>
								".$this->DanceTimeTableController->GetSpecialTickets()."
							</table>
							".current($pageTexts)."
						</div>
						<a href='checkout.php'><div class='ProceeToCheckout'>".next($pageTexts)."</div>
						</a>
			    <div class='col-sm-1'></div>
			  </div>
			</div>
		</div>";
	}

	private function Footer(){
		return $this->DanceTimeTableController->GetConfig()->SetFooter();
	}
}
?>
