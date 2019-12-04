<?php 
require_once("Autoloader.php");
class AdvancedDanceSearchView
{
	private $AdvancedDanceSearchController;
	private $AdvancedDanceSearchModel;

	public function __construct($advancedDanceSearchController, $advancedDanceSearchModel)
	{
		$this->AdvancedDanceSearchController = $advancedDanceSearchController;
		$this->AdvancedDanceSearchModel = $advancedDanceSearchModel;
	}

	//output to html
	public function output(){
		$this->Tickets = $this->AdvancedDanceSearchController->GetSearchResults();
		$page = "";
		$page .= $this->Header();
		$page .= $this->Body();
		$page .= $this->Footer();
		return $page;
	}

	private function Header(){
		return $this->AdvancedDanceSearchController->GetConfig()->GetHeader("Dance"). "
		<link rel='stylesheet' type='text/css' href='DanceTimeTableStyle.css'>
		<script src='Javascript.js'></script> ";
	}

	private function Body(){
		$nav = new Nav();
		return $nav->SetNavBar("Dance"). "
		<div id='main'>
			<div class='container-fluid'>
			  <div class='row'>
			    <div class='col-sm-1' ></div>
			    <div class='col-sm-10'>
				    <div class='Results'>
					    ".$this->AdvancedDanceSearchController->CreateDays($this->Tickets)."
						<div class='AdvancedFilter'>
							<div class='dropdown'>
						  <div class='dropdownCritiria'>
						  <h3>Artists:</h3>
						   	<form method='get' action='AdvancedDanceSearch.php'>
							   	".$this->AdvancedDanceSearchController->MakeArtistAdvancedSearch()."
							   	<h3>Locations:</h3>
							   	".$this->AdvancedDanceSearchController->MakeLocationAdvancedSearch()."
							   	<input type='submit' class='SearchNow' value='Search Dance event'>
							</form>
						  </div>
						</div>
						</div>
						<div><a href='checkout.php'><div class='ProceeToCheckout'>Proceed to checkout</div>
							</a></div>
					</div>
			    <div class='col-sm-1'></div>
			  </div>
			</div>
		</div>
		";
	}

	private function Footer(){
		return $this->AdvancedDanceSearchController->GetConfig()->SetFooter();
	}
}
?>
