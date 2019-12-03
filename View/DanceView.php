<?php 
require_once("Autoloader.php");
class DanceView
{
	private $DanceController;
	private $DanceModel;

	public function __construct($danceController, $danceModel)
	{
		$this->DanceController = $danceController;
		$this->DanceModel = $danceModel;
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
		$nav = new Nav();
		return $nav->SetNavBar("Dance"). "
		<div id='main'>
			<div class='container-fluid'>
			  <div class='row'>
			    <div class='col-sm-2' ></div>
			    <div class='col-sm-9'>
			    	<div class='Info'><h2>Haarlem Dance</h2>
						When you hear Dance you will think of your favorite DJ's. This year we will present the top DJ's of the world, who will play on the Haarlem festival.
						</div>
						<div class='Locations'>
						<h2>Locations</h2>
							<table>
							".$this->DanceController->GetLocation()."
							</table>
						</div>
						<div class='Artists'><h2>Artists</h2>
							".$this->DanceController->SetArtists()."
						</div>
						<div class='Special'>
							<h2>Special Tickets</h2>
							<table>
								".$this->DanceController->GetSpecialTickets()."
							</table>
							<p>* The capacity of the Club sessions is very limited. Availability for All-Access pas holders can not be garanteed due to safety regulations.</p>
						</div>
						<a href='DanceTimeTable.php'><div class='LocationsAndTickets'>Locations, Times & Tickets</div></a>
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