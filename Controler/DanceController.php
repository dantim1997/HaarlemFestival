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

		$this->Dancemodel->SetArtists($this->DB_Helper->GetArtists());
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

	public function GetSpecialTickets(){
		$specials = $this->DB_Helper->Get_AllSpecialEvents();

		$specialTickets="";
		foreach ($specials as $special) {
			$specialTickets.= "
			<tr>
				<td>".$special["description"]."</td><td>&euro; ".$special["price"]."</td>
				<td><input type='Button' class='AddButton'
					onclick='AddToCart(".$special["ID"].",2,1)' name='' value='Add to cart'></td>
			</tr>";
		}

		return $specialTickets;
	}
	
	Public function SetArtists(){

		$artistslist = "";
		foreach ($this->Dancemodel->GetArtists() as $artist) {
			$artistslist .= "<div class='Artist' data-toggle='modal' data-target='#Artists".$artist["Id"]."'>".$artist["Name"]." <img class='ArtistImage' src='Images/Artists/".$artist["Name"].".png'> </div>";
		}
		return $artistslist;
	}

	public function GetModals(){
		$modals = "";
		foreach ($this->Dancemodel->GetArtists() as $artist) {
			$modals .= $this->GetModal($artist);	
		}
		return $modals;
	}

	public function GetModal($artist){
		return "
		<div class='modal fade' id='Artists".$artist["Id"]."' role='dialog'>
		    <div class='modal-dialog modal-lg ModalWidth'>
		    
		      <!-- Modal content-->
		      <div class='modal-content'>
		        <div class='modal-header'>
		          <h4 class='modal-title'>".$artist["Name"]."</h4>
		          <button type='button' class='close' data-dismiss='modal'>&times;</button>
		        </div>
		        <div class='modal-body ModalHeight'>
		          <div class='ArtistInfo'>
		            <img src='Images/Artists/".$artist["Name"].".png'>
		            Genre: ".$artist["Types"]."
		            <br>
		            <h4>Known for:</h4>
		            ".$this->SetKnownFor($artist["KnownFor"])."
		          </div>
		          <div class='ArtistTickets'>
		            <p>".$artist["About"]."
		            </p>
		            <h4>Optredens:</h4>
		            <table>
		              <tr>	<td class='td'>Location:</td>
		              		<td class='td'>Time</td>
		              		<td class='td'>Price</td>
		              		<td></td>
		              		<td></td>
		              </tr>
		            ".$this->SetTable($artist["Id"])."
		            </table>
		          </div>
		        </div>
		      </div>
		      </div>
		    </div>";
	}

	public function SetTable($artistId){
		$Sessions = $this->DB_Helper->GetEventsByArtist($artistId);
		$tablerows ="";
		foreach ($Sessions as $session) {
			$tablerows.="<tr>
							<td class='td'>".$session["Venue"]."</td>
							<td class='td'>".$session["StartDateTime"]."</td>
							<td class='td'>€".$session["Price"]."</td> <td>
							<td class='td'>
								<input type='Button' class='AddButton'
								onclick='AddToCart(".$session["ID"].",2,1)' name='' value='Add to cart'></td> 
							<td></td>
						</tr>
						<hr>";
		}
		return $tablerows;
	}

	public function SetKnownFor($allKnownFor){
		$types = explode(",", $allKnownFor);
		$typelist = "<ul>";
		foreach ($types as $type) {
			$typelist .= " <li>".$type."</li>";
		}
 		$typelist .= "</ul>";
		return $typelist;
	}
}
?>