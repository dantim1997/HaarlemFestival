<?php 
require_once("Autoloader.php");
class DanceTimeTableView
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
								<tr><td>All-Acces Pass Friday</td><td>&euro; 125,--</td><td><button class='AddButton' value='1' name=''>Add to cart</button></td></tr>
								<tr><td>All-Acces Pass Saturday</td><td>&euro; 150,--</td><td><button class='AddButton' value='1' name=''>Add to cart</button></td></tr>
								<tr><td>All-Acces Pass Sunday</td><td>&euro; 150,--</td><td><button class='AddButton' value='1' name=''>Add to cart</button></td></tr>
								<tr><td>All-Acces Pass (Fri-Sat-Sun)</td><td>&euro; 250,--</td><td><button class='AddButton' value='1' name=''>Add to cart</button></td></tr>
							</table>
							<p>* The capacity of the Club sessions is very limited. Availability for All-Access pas holders can not be garanteed due to safety regulations.</p>
						</div>
						<a href='checkout.php'><div class='ProceeToCheckout'>Proceed to checkout</div>
						</a>
			    <div class='col-sm-1'></div>
			  </div>
			</div>
			
		</div>
		<div class='modal fade' id='Artists' role='dialog'>
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
                <li>Coffee</li>
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
