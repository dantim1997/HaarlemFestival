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
		return $this->DanceController->GetConfig()->GetHeader("Index"). "
		<link rel='stylesheet' type='text/css' href='DanceStyle.css'>";
	}

	private function Body(){
		//setnav()
		return "
		<div id='main'>
			<div class='container-fluid'>
			  <div class='row'>
			    <div class='col-sm-2' ></div>
			    <div class='col-sm-8'>
			    	<div class='Info'><h2>Haarlem Dance</h2>
						When you hear Dance you will think of your favorite DJ's. This year we will present the top DJ's of the world, who will play on the Haarlem festival.
						</div>
						<div class='Locations'>
						<h2>Locations</h2>
							<table>
								<tr><td><b>Club Stalker</b><br>Kromme Elleboogsteeg 20, 2011 TS Haarlem</td>				
								<td><b>Lichefabriek</b> <br> Mickelersweg 2, 2031, EM Haarlem</td></tr>

								<tr><td><b>Caprera Openluchttheater</b> <br> Hoge Duin en DaalseWeg 2, 2061 AG Bloemendaal</td>
								<td><b>Club Ruis</b> <br> Smedestraat 3, 2011 RE Haarlem</td></tr>

								<tr><td><b>Jopenkerk</b> <br> Gedempte Voldersgracht 2, 2011 WD Haarlem</td>					
								<td><b>XO the CLub</b> <br> Grote Markt 8, 2011 RD Haarlem</td></tr>
							</table>
						</div>
						<div class='Artists'><h2>Artists</h2>
							<div class='Artist' data-toggle='modal' data-target='#Artists'>Hardwel <img class='ArtistImage' src='Images/Artists/Hardwell.png'> </div>
							<div class='Artist' data-toggle='modal' data-target='#Artists'>Armin van Buuren<img class='ArtistImage' src='Images/Artists/ArminVanBuuren.png'></div>
							<div class='Artist' data-toggle='modal' data-target='#Artists'>Martin Garrix<img class='ArtistImage' src='Images/Artists/MartinGarrix.png'></div>
							<div class='Artist' data-toggle='modal' data-target='#Artists'>Nicky Romero<img class='ArtistImage' src='Images/Artists/NickyRomero.png'></div>
							<div class='Artist' data-toggle='modal' data-target='#Artists'>Tiesto<img class='ArtistImage' src='Images/Artists/Tiesto.png'></div>
							<div class='Artist' data-toggle='modal' data-target='#Artists'>AfroJack<img class='ArtistImage' src='Images/Artists/AfroJack.png'></div>
						</div>
						<div class='Special'>
							<h2>Special Tickets</h2>
							<table>
								<tr><td>All-Acces Pass Friday</td><td>&euro; 125,--</td><td>Add to cart</td></tr>
								<tr><td>All-Acces Pass Saturday</td><td>&euro; 150,--</td><td>Add to cart</td></tr>
								<tr><td>All-Acces Pass Sunday</td><td>&euro; 150,--</td><td>Add to cart</td></tr>
								<tr><td>All-Acces Pass (Fri-Sat-Sun)</td><td>&euro; 250,--</td><td>Add to cart</td></tr>
							</table>
							<p>* The capacity of the Club sessions is very limited. Availability for All-Access pas holders can not be garanteed due to safety regulations.</p>
						</div>
						<a href='DanceTimeTable.php'><div class='LocationsAndTickets'>Locations, Times & Tickets</div></a>
			    </div>
			    <div class='col-sm-2'></div>
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
