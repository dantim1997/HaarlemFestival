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
		return "<div id='main'>
			<div class='container'>
				<image class='banner' src='Images/jazzbanner.png'>
				<div class='title'>Jazz</div>
			</div>
			<div class='content'>
				<h1>Haarlem Jazz</h1>
				<p>Find your Jazz genre on the four different days of the Haarlem Festival and visit the Jazz event!<br>There's free access for everyone on Sundays. So look for the artist or band you like and enjoy!</p>
				<h2>Artists</h2>
				<div class='artists'>
					<div class='artist'>
						<div class='artistname'>Gumbo Kings</div>
						<div class='artistcontainer'>
							<image class='artistimage' src='Images/gumbo.png'>
							<div class='genre1'>Blues</div>
							<div class='genre0'>0</div>
						</div>
					</div>
					<div class='artist'>
						<div class='artistname'>Wicked Jazz Sounds</div>
						<div class='artistcontainer'>
							<image class='artistimage' src='Images/wicked.jpg'>
							<div class='genre2'>Ragtime</div>
							<div class='genre0'>0</div>
						</div>
					</div>
					<div class='artist'>
						<div class='artistname'>Evolve</div>
						<div class='artistcontainer'>
							<image class='artistimage' src='Images/evolve.png'>
							<div class='genre1'>Blues</div>
							<div class='genre0'>0</div>
						</div>
					</div>
					<div class='artist'>
						<div class='artistname'>Ntjam Rosie</div>
						<div class='artistcontainer'>
							<image class='artistimage' src='Images/ntjam.jpg'>
							<div class='genre3'>Classic Soul</div>
							<div class='genre4'>Classic</div>
						</div>
					</div>
				</div>
				<h2>Programme</h2>
					<table class='tg'>
					<tr>
						<th class='tg-lh0f'></th>
						<th class='tg-qcxk'><span style='font-weight:700'>Thursday - 26 July</span></th>
						<th class='tg-qcxk'><span style='font-weight:700'>Friday - 27 July</span></th>
						<th class='tg-qcxk'><span style='font-weight:700'>Saturday - 28 July</span></th>
						<th class='tg-qcxk'><span style='font-weight:700'>Sunday - 29 July</span></th>
					</tr>
					<tr>
						<td class='tg-6jhs'>15:00 - 16:00</td>
						<td class='tg-nrh4'></td>
						<td class='tg-nrh4'></td>
						<td class='tg-nrh4'></td>
						<td class='tg-nrh4'>Ruis Soundsystem</td>
					</tr>
					<tr>
						<td class='tg-6jhs'>16:00 - 17:00</td>
						<td class='tg-m4n1'></td>
						<td class='tg-m4n1'></td>
						<td class='tg-m4n1'></td>
						<td class='tg-m4n1'>Wicked Jazz Sounds</td>
					</tr>
					<tr>
						<td class='tg-6jhs'>17:00 - 18:00</td>
						<td class='tg-nrh4'></td>
						<td class='tg-nrh4'></td>
						<td class='tg-nrh4'></td>
						<td class='tg-nrh4'>Evolve</td>
					</tr>
					<tr>
						<td class='tg-6jhs' rowspan='2' valign='center'>18:00 - 19:00</td>
						<td class='tg-m4n1'>Gumbo Kings</td>
						<td class='tg-m4n1'>Fox &amp; The Mayors</td>
						<td class='tg-m4n1'>Gare du Nord</td>
						<td class='tg-m4n1'>The Nordanians</td>
					</tr>
					<tr>
						<td class='tg-nrh4'>Wicked Jazz Sounds</td>
						<td class='tg-nrh4'>Myles Sanko</td>
						<td class='tg-nrh4'>Han Bennink</td>
						<td class='tg-nrh4'></td>
					</tr>
					<tr>
						<td class='tg-6jhs'>19:00 - 20:00</td>
						<td class='tg-m4n1'></td>
						<td class='tg-m4n1'></td>
						<td class='tg-m4n1'></td>
						<td class='tg-m4n1'>Gumbo Kings</td>
					</tr>
					<tr>
						<td class='tg-6jhs' rowspan='2' valign='center'>19:30 - 20:30</td>
						<td class='tg-nrh4'>Evolve</td>
						<td class='tg-nrh4'>Uncle Sue</td>
						<td class='tg-nrh4'>Rilan &amp; The Bombadiers</td>
						<td class='tg-nrh4'></td>
					</tr>
					<tr>
						<td class='tg-m4n1'>Tom Thomsom Assemble</td>
						<td class='tg-m4n1'>Ruis Soundsysteem</td>
						<td class='tg-m4n1'>The Nordanians</td>
						<td class='tg-m4n1'></td>
					</tr>
					<tr>
						<td class='tg-6jhs'>20:00 - 21:00</td>
						<td class='tg-nrh4'></td>
						<td class='tg-nrh4'></td>
						<td class='tg-nrh4'></td>
						<td class='tg-nrh4'>Garde du Nord</td>
					</tr>
					<tr>
						<td class='tg-6jhs' rowspan='2' valign='center'>21:00 - 22:00</td>
						<td class='tg-m4n1'>Ntjam Rosie</td>
						<td class='tg-m4n1'>Chris Allen</td>
						<td class='tg-m4n1'>Soul Six</td>
						<td class='tg-m4n1'></td>
					</tr>
					<tr>
						<td class='tg-nrh4'>Jonna Frazer</td>
						<td class='tg-nrh4'>The Family XL</td>
						<td class='tg-nrh4'>Lilith Merlot</td>
						<td class='tg-nrh4'></td>
					</tr>
					</table>
				<h2>Tickets</h2>
				<div class='dates'>
					<div class='selectday'><h3>Thursday</h3>26-07<br>Patronaat</div>
					<div class='selectday'><h3>Friday</h3>27-07<br>Patronaat</div>
					<div class='selectday'><h3>Saturday</h3>28-07<br>Patronaat</div>
					<div class='selectday'><h3>Sunday</h3>29-07<br>Grote Markt</div>
				</div>
				<div>
					<image class='arrow-up' src='Images/arrow-up.png'>
					<image class='arrow-up' src='Images/arrow-up.png'>
					<image class='arrow-up' src='Images/arrow-up.png'>
					<image class='arrow-up' src='Images/arrow-up.png'>
				</div>
				<div class='thursday'>
				</div>
				<div class='friday'>
				</div>
				<div class='saturday'>
					<h1>Saturday</h1>
					<p>blalbabla</p>
					<br>
					<h2>Programme</h2>
					<br>
					15:00 - 16:00&nbsp;&nbsp;Ruis Soundsystem<hr>
					16:00 - 17:00&nbsp;&nbsp;Wicked Jazz Sounds<hr>
					17:00 - 18:00&nbsp;&nbsp;Evolve<hr>
					18:00 - 19:00&nbsp;&nbsp;The Nordanians<hr>
					19:00 - 20:00&nbsp;&nbsp;Gumbo Kings<hr>
					20:00 - 21:00&nbsp;&nbsp;Gare du Nord
					<br>
					<br>
					<h2>Location<h2>
					<p class='location'>Patronaat<br>Zijlsingel 2, 2013 DN Haarlem</p>
					<iframe class='googlemaps' src='https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d2435.303300925829!2d4.62801880212946!3d52.38305184490867!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x74fe2502604b46ae!2sPatronaat!5e0!3m2!1snl!2snl!4v1573735570305!5m2!1snl!2snl' frameborder='0' style='border:0;' allowfullscreen=''></iframe>
				</div>
				<div class='sunday'>
					<h1>Sunday - Free access for all visitors</h1>
					<p>Sunday is the last day of the event. The event will be held in the Grote Markt. You can listen to every band for free!</p>
					<br>
					<h2>Programme</h2>
					<br>
					15:00 - 16:00&nbsp;&nbsp;Ruis Soundsystem<hr>
					16:00 - 17:00&nbsp;&nbsp;Wicked Jazz Sounds<hr>
					17:00 - 18:00&nbsp;&nbsp;Evolve<hr>
					18:00 - 19:00&nbsp;&nbsp;The Nordanians<hr>
					19:00 - 20:00&nbsp;&nbsp;Gumbo Kings<hr>
					20:00 - 21:00&nbsp;&nbsp;Gare du Nord
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