<?php 
require_once("Autoloader.php");

class JazzView
{
	private $JazzController;
	private $JazzModel;

	public function __construct($jazzController, $jazzModel)
	{
		$this->JazzController = $jazzController;
		$this->JazzModel = $jazzModel;
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
		return $this->JazzController->GetConfig()->GetHeader("Jazz");
	}

	private function Body(){
		$nav = new Nav();
		return $nav->SetNavBar("Jazz"). "<div class='main'>
			<div class='container'>
				<div class='title'>Jazz</div>
			</div>
			<div class='content'>
				<h1>Haarlem Jazz</h1>
				<p>Find your Jazz genre on the four different days of the Haarlem Festival and visit the Jazz event!<br>There's free access for everyone on Sundays. So look for the artist or band you like and enjoy!</p>
				<h2>Artists</h2>

					<button onclick='ToggleAdvancedJazz()' class='filterbutton2'>Filter genre</button>
					<div id='AdvancedFilter' class='filter'>
						<form method='GET' action='Jazz.php'>
					   	".$this->JazzController->MakeGenreAdvancedSearch()."
					   	<input type='submit' class='filterbutton' value='Filter Artists'>
						</form>
					</div><br>
						  


				<div id='carouselExampleControls' class='carousel slide' data-ride='carousel'>
  					<div class='carousel-inner'>
						<div class='carousel-item active'>
							<div class='artists'>
							".$this->JazzController->GetFilterResults()."
							</div>
    					</div>
    					<div class='carousel-item'>
						<div class='artists'>
							".$this->JazzController->MakeArtistCarousel()."
						</div>
    					</div>
    					<div class='carousel-item'>
							<div class='artists'>
							".$this->JazzController->MakeArtistCarousel()."
							</div>
    					</div>
  					</div>
  						<a class='carousel-control-prev' href='#carouselExampleControls' role='button' data-slide='prev'>
    					<span class='carousel-control-prev-icon' aria-hidden='true'></span>
    					<span class='sr-only'>Previous</span>
  						</a>
  						<a class='carousel-control-next' href='#carouselExampleControls' role='button' data-slide='next'>
    					<span class='carousel-control-next-icon' aria-hidden='true'></span>
    					<span class='sr-only'>Next</span>
  						</a>
				</div>
				<h2>Programme</h2>
					<table class='tg'>
					".$this->JazzController->GetTable()."
					</table>
				<h2>Tickets</h2>
				<div class='dates'>
					<div onclick='ShowDate(1)' class='selectday'><h3>Thursday</h3>26-07<br>Patronaat</div>
					<div onclick='ShowDate(2)' class='selectday'><h3>Friday</h3>27-07<br>Patronaat</div>
					<div onclick='ShowDate(3)' class='selectday'><h3>Saturday</h3>28-07<br>Patronaat</div>
					<div onclick='ShowDate(4)' class='selectday'><h3>Sunday</h3>29-07<br>Grote Markt</div>
				</div>
				<div>
					<image id='Thursday' class='arrow-up' src='Images/arrow-up.png'>
					<image id='Friday' class='arrow-up' src='Images/arrow-up.png'>
					<image id='Saturday' class='arrow-up' src='Images/arrow-up.png'>
					<image id='Sunday' class='arrow-up' src='Images/arrow-up.png'>
				</div>
				<div id='Thursday1' class='thursday'>
				<h1>Thursday - Tickets</h1>
				<br>
				<div class='form'>
					<form action='addTicket.php' method='post'>
						<button>-</button><input type='text' value='0' name='ticket1'><button>+</button><br>
						<button>-</button><input type='text' value='0' name='ticket2'><button>+</button><br>
						<button>-</button><input type='text' value='0' name='ticket3'><button>+</button><br>
						<button>-</button><input type='text' value='0' name='ticket4'><button>+</button><br>
						<button>-</button><input type='text' value='0' name='ticket5'><button>+</button><br>
						<button>-</button><input type='text' value='0' name='ticket6'><button>+</button><br>
						<button>-</button><input type='text' value='0' name='ticket7'><button>+</button><br>
						<button>-</button><input type='text' value='0' name='ticket8'><button>+</button><br>
						<br>
						<input class='addCart' type='submit' value='Add Tickets'>
					</form>
					</div>
				<div class='tickets'>
					<hr>
					".$this->JazzController->FillTickets("2020-07-26")."
					All Access pass for Saturday for the event 'Jazz'<hr>
					All Acces pass for the whole event 'Jazz'<hr>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<h2>Location<h2>
					<p class='location'>Patronaat<br>Zijlsingel 2, 2013 DN Haarlem</p>
					<iframe class='googlemaps' src='https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d2435.303300925829!2d4.62801880212946!3d52.38305184490867!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x74fe2502604b46ae!2sPatronaat!5e0!3m2!1snl!2snl!4v1573735570305!5m2!1snl!2snl' frameborder='0' style='border:0;' allowfullscreen=''></iframe>
				</div>
				</div>
				<div id='Friday1' class='friday'>
				<h1>Friday - Tickets</h1>
				<br>
				<div class='form'>
					<form action='addTicket.php' method='post'>
						<button>-</button><input type='text' value='0' name='ticket9'><button>+</button><br>
						<button>-</button><input type='text' value='0' name='ticket10'><button>+</button><br>
						<button>-</button><input type='text' value='0' name='ticket11'><button>+</button><br>
						<button>-</button><input type='text' value='0' name='ticket12'><button>+</button><br>
						<button>-</button><input type='text' value='0' name='ticket13'><button>+</button><br>
						<button>-</button><input type='text' value='0' name='ticket14'><button>+</button><br>
						<button>-</button><input type='text' value='0' name='ticket15'><button>+</button><br>
						<button>-</button><input type='text' value='0' name='ticket16'><button>+</button><br>
						<br>
						<input class='addCart' type='submit' value='Add Tickets'>
					</form>
					</div>
				<div class='tickets'>
					<hr>
					".$this->JazzController->FillTickets("2020-07-27")."
					All Access pass for Saturday for the event 'Jazz'<hr>
					All Acces pass for the whole event 'Jazz'<hr>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<h2>Location<h2>
					<p class='location'>Patronaat<br>Zijlsingel 2, 2013 DN Haarlem</p>
					<iframe class='googlemaps' src='https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d2435.303300925829!2d4.62801880212946!3d52.38305184490867!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x74fe2502604b46ae!2sPatronaat!5e0!3m2!1snl!2snl!4v1573735570305!5m2!1snl!2snl' frameborder='0' style='border:0;' allowfullscreen=''></iframe>
				</div>
				</div>
				<div id='Saturday1' class='saturday'>
					<h1>Saturday - Tickets</h1>
					<br>
					<div class='form'>
						<form action='addTicket.php' method='post'>
							<button>-</button><input type='text' value='0' name='ticket17'><button>+</button><br>
							<button>-</button><input type='text' value='0' name='ticket18'><button>+</button><br>
							<button>-</button><input type='text' value='0' name='ticket19'><button>+</button><br>
							<button>-</button><input type='text' value='0' name='ticket20'><button>+</button><br>
							<button>-</button><input type='text' value='0' name='ticket21'><button>+</button><br>
							<button>-</button><input type='text' value='0' name='ticket22'><button>+</button><br>
							<button>-</button><input type='text' value='0' name='ticket23'><button>+</button><br>
							<button>-</button><input type='text' value='0' name='ticket24'><button>+</button><br>
							<br>
							<input class='addCart' type='submit' value='Add Tickets'>
						</form>
						</div>
					<div class='tickets'>
						<hr>
						".$this->JazzController->FillTickets("2020-07-28")."
						All Access pass for Saturday for the event 'Jazz'<hr>
						All Acces pass for the whole event 'Jazz'<hr>
						<br>
						<br>
						<br>
						<br>
						<br>
						<br>
						<h2>Location<h2>
						<p class='location'>Patronaat<br>Zijlsingel 2, 2013 DN Haarlem</p>
						<iframe class='googlemaps' src='https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d2435.303300925829!2d4.62801880212946!3d52.38305184490867!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x74fe2502604b46ae!2sPatronaat!5e0!3m2!1snl!2snl!4v1573735570305!5m2!1snl!2snl' frameborder='0' style='border:0;' allowfullscreen=''></iframe>
					</div>
				</div>
				<div id='Sunday1' class='sunday'>
					<h1>Sunday - Free access for all visitors</h1>
					<p>Sunday is the last day of the event. The event will be held in the Grote Markt. You can listen to every band for free!</p>
					<br>
					<h2>Programme</h2>
					<br>
					<hr>
					".$this->JazzController->FillTickets("2020-07-29")."
					<br>
					<br>
					<h2>Location<h2>
					<p class='location'>Grote Markt<br>2011 RD, Haarlem</p>
					<iframe class='googlemaps' src='https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2435.3981932556803!2d4.634128115354485!3d52.38133147978822!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c5ef6b924ce7ed%3A0xd9721c5337b4704!2sGrote%20Markt%2C%202011%20RD%20Haarlem!5e0!3m2!1snl!2snl!4v1573677475830!5m2!1snl!2snl' frameborder='0' style='border:0;' allowfullscreen=''></iframe>
				</div>
			</div>
		</div>";
	}

	private function Footer(){
		return $this->JazzController->GetConfig()->SetFooter();
	}
}
?>