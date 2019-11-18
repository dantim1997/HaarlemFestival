<?php
	require_once( "Autoloader.php");
class DanceController 
{
	private $DanceModel;
	private $Session;
	private $Config;

	public function __construct($danceModel){
		$this->Dancemodel = $danceModel;
		$this->Config = Config::getInstance();
		$this->DB_Helper = new DB_Helper;

		$this->Artists =$this->DB_Helper->GetArtists();
		//$this->DanceModel->SetArtists($test);
		//var_dump($this->DanceModel->GetArtists());
	}
	
	//get config
	public function GetConfig(){
		return $this->Config;
	}

	public function GetLocation(){
		$locations = $this->DB_Helper->GetLocations();

		$venues="";
		foreach ($locations as $location) {
			$venues.= "<div class='Location'><b>".$location["Name"]."</b><br>".$location["Location"]."</div>";
		}

		return $venues;
	}

	public function GetEventsByArtist(){

	}

	Public function SetArtists(){

		$artistslist = "";
		foreach ($this->Artists as $artist) {
			$artistslist .= "<div class='Artist' data-toggle='modal' data-target='#Artists".$artist["Id"]."'>".$artist["Name"]." <img class='ArtistImage' src='Images/Artists/".$artist["Name"].".png'> </div>";
		}
		return $artistslist;
	}

	public function GetModals(){
		$modals = "";
		foreach ($this->Artists as $artist) {
			var_dump("");
			$modals .= $this->GetModal($artist);	
		}
		return $modals;
	}

	public function GetModal($artist){
		return "<div class='modal fade' id='Artists".$artist["Id"]."' role='dialog'>
		    <div class='modal-dialog ModalWidth'>
		    
		      <!-- Modal content-->
		      <div class='modal-content'>
		        <div class='modal-header'>
		          <button type='button' class='close' data-dismiss='modal'>&times;</button>
		          <h4 class='modal-title'>Hardwell</h4>
		        </div>
		        <div class='modal-body ModalHeight'>
		          <div class='ArtistInfo'>
		            <img src='Images/Artists/Hardwell.png'>
		            <br>
		            Genre: Dance, House
		            <br>
		            <h4>Known for:</h4>
		            <ul>
		                <li>ttt</li>
		                <li>Tea</li>
		                <li>Milk</li>
		            </ul> 
		          </div>
		          <div>
		            <p>Robbert van de Corput or Hardwell was born on the 7th of january 1988 in Breda. He’s one of the Leading DJ's in the Dance scene. With numbers popular all over the world, like Apollo, Follow me and Power. This summer he will play his DJ-set in Haarlem!
		            </p>
		            <h4>Optredens:</h4>
		            <table>
		              <tr><td>Location:</td><td>Time</td><td>Price</td><td></td></tr>
		              <tr><td>Jopenkerk</td><td>Friday 23:01:00</td><td>20</td> <td></td></tr>
		              <tr><td>Caperea Openluchttheater</td><td>Friday 23:01:00</td><td>20</td> <td></td></tr>
		              <tr><td>Xo the Club</td><td>Friday 23:01:00</td><td>20</td><td></td></tr>
		            </table>
		          </div>
		          <div class='ArtistTickets'></div>
		        </div>
		      </div>
		      </div>
		    </div>";
	}
}
?>