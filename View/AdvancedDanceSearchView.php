<?php 
require_once("Autoloader.php");
class AdvancedDanceSearchView
{
	private $DanceTimeTableController;
	private $DanceTimeTableModel;

	public function __construct($danceTimeTableController, $danceTimeTableModel)
	{
		$this->DanceTimeTableController = $danceTimeTableController;
		$this->DanceTimeTableModel = $danceTimeTableModel;
	}

	//output to html
	public function output(){
		$this->DanceTimeTableController->GetSearchResults();
		$page = "";
		$page .= $this->Header();
		$page .= $this->Body();
		$page .= $this->Footer();
		return $page;
	}

	private function Header(){
		return $this->DanceTimeTableController->GetConfig()->GetHeader("Index"). "
		<link rel='stylesheet' type='text/css' href='DanceStyle.css'>.
		<link rel='stylesheet' type='text/css' href='DanceTimeTableStyle.css'>
		<script src='Javascript.js'></script> ";
	}

	private function Body(){
		//setnav()
		return "
		<div id='main'>
			<div class='container-fluid'>
			  <div class='row'>
			    <div class='col-sm-1' ></div>
			    <div class='col-sm-10'>
				    <div class='Results'>
					    <div class='Tickets'>
					    	<h2>Tickets found with the critiria:</h2>
							<h3>Friday</h3>
							<hr>
							<div class='SessionFound'>
							<p class='SessionInfo'>Haarlem Dance 14:00 - 20:00, Hardwell/Marting Garrix/Armin van Buuren,Caprera OpenLucht theater     € 110 ,-</p>
							<input class='SessionAdd' type='button' value='+'>
							</div>
						</div>
						<div class='AdvancedFilter'>
							<div class='dropdown'>
						  <div class='dropdownCritiria'>
						  <h3>Artists:</h3>
						   	<input type='checkbox' name='check_list[]' value='Hardwell'><label>Hardwell</label><br/>
						   	<input type='checkbox' name='check_list[]' value='Armin'><label>Armin</label><br/>
						   	<input type='checkbox' name='check_list[]' value='Hardwell'><label>Martin Garrix</label><br/>
						   	<input type='checkbox' name='check_list[]' value='Hardwell'><label>Tiësto</label><br/>
						   	<input type='checkbox' name='check_list[]' value='Hardwell'><label>Nickey Romero</label><br/>
						   	<input type='checkbox' name='check_list[]' value='Hardwell'><label>AfroJack</label><br/>

						   	<h3>Locations:</h3>
						   	<input type='checkbox' name='check_list[]' value='Hardwell'><label>Hardwell</label><br/>
						   	<input type='checkbox' name='check_list[]' value='Armin'><label>Caprera Openluchttheater</label><br/>
						   	<input type='checkbox' name='check_list[]' value='Armin'><label>Jopenkerk</label><br/>
						   	<input type='checkbox' name='check_list[]' value='Armin'><label>Xo the Club</label><br/>
						   	<input type='checkbox' name='check_list[]' value='Armin'><label>Caprera</label><br/>
						   	<input type='checkbox' name='check_list[]' value='Armin'><label>Lichtenfabriek</label>

						   	<a href='AdvancedDanceSearch.php'><i class='SearchNow'>Search Dance event</i></a>
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
