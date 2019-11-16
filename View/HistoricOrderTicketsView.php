<?php 
require_once("Autoloader.php");
class HistoricOrderTicketsView
{
	private $HistoricOrderTicketsController;
	private $HistoricOrderTicketsModel;

	public function __construct($historicOrderTicketsController, $historicOrderTicketsModel)
	{
		$this->HistoricOrderTicketsController = $historicOrderTicketsController;
		$this->HistoricOrderTicketsModel = $historicOrderTicketsModel;
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
		return $this->HistoricOrderTicketsController->GetConfig()->GetHeader("Historic"). "<link rel='stylesheet' type='text/css' href='historic.css'>";
	}

	private function Body(){
		$nav = new Nav();
		return $nav->SetNavBar().
		"<div id='main'>
		<div class='lol'></div>
			<div class='orderTicketsSelection'>
				<div class='orderTicketsheaderContainer'><div class='blackBar5'></div><h2 class='orderTicketsHeader'>Order tickets</h2><div class='blackBar5'></div><br>
					<p class='orderTicketslabels'>
						Select language:<br>
						Select day:
					</p>
					<div class='orderTicketsDropdwn'>
						<select class='dropDown'>
							<option value='-'>-</option>
							<option value='English'>English</option>
							<option value='Dutch'>Dutch</option>
							<option value='Chinese'>Chinese</option>
						</select><br>
						<select class='dropDown'>
							<option value='-'>-</option>
							<option value='day1'>Thursday 26th of Juli</option>
							<option value='day2'>Friday 27th of Juli</option>
							<option value='day3'>Saturday 28th of Juli</option>
							<option value='day4'>Sunday 29th of Juli</option>
						</select>
					</div>		
			</div>


			<h5 class='dayLabel'>Saturday Juli 28th</h5>

			<div class='ticketsContainer'>
				<h5 class='normalTicket'>Normal ticket € 17,50</h5>
				<h5 class='familyTicket'>Family ticket 4 people € 60 (€ 15 p.p.)</h5>

				<div class='normalTickets'> 

					<h5 class=ticket>English tour, 10:00 - 12:30</h5>

					<!-- adding and removing buttons -->
						<form method='post' action='' class='formLeft'>	
							<input class='addRemoveBTN' type='submit' value='-' name='??????'>
							<input class='ticketTxt' type='text' value='0' name='??????'>
							<input class='addRemoveBTN' type='submit' value='+' name='??????'>
						</form><br>

					<h5 class=ticket>English tour, 13:00 - 15:30</h5>

					<!-- adding and removing buttons -->
						<form method='post' action='' class='formLeft'>	
							<input class='addRemoveBTN' type='submit' value='-' name='??????'>
							<input class='ticketTxt' type='text' value='0' name='??????'>
							<input class='addRemoveBTN' type='submit' value='+' name='??????'>
						</form><br>

					<h5 class=ticket>English tour, 16:00 - 18:30</h5>

					<!-- adding and removing buttons -->
						<form method='post' action='' class='formLeft'>	
							<input class='addRemoveBTN' type='submit' value='-' name='??????'>
							<input class='ticketTxt' type='text' value='0' name='??????'>
							<input class='addRemoveBTN' type='submit' value='+' name='??????'>
						</form><br>
				</div>

				<div class='familyTickets'>

					<h5 class=ticket>English Family ticket, 10:00 - 12:30</h5>

					<!-- adding and removing buttons -->
						<form method='post' action='' class='formRight'>	
							<input class='addRemoveBTN' type='submit' value='-' name='??????'>
							<input class='ticketTxt' type='text' value='0' name='??????'>
							<input class='addRemoveBTN' type='submit' value='+' name='??????'>
						</form><br>

					<h5 class=ticket>English Family ticket, 13:00 - 15:30</h5>

					<!-- adding and removing buttons -->
						<form method='post' action='' class='formRight'>	
							<input class='addRemoveBTN' type='submit' value='-' name='??????'>
							<input class='ticketTxt' type='text' value='0' name='??????'>
							<input class='addRemoveBTN' type='submit' value='+' name='??????'>
						</form><br>

					<h5 class=ticket>English Family ticket, 16:00 - 18:30</h5>

					<!-- adding and removing buttons -->
						<form method='post' action='' class='formRight'>	
							<input class='addRemoveBTN' type='submit' value='-' name='??????'>
							<input class='ticketTxt' type='text' value='0' name='??????'>
							<input class='addRemoveBTN' type='submit' value='+' name='??????'>
						</form><br>
				</div>
			</div>

			<!-- adding and removing buttons -->
			<form method='post' action=''>	
				<input class='addToCartBTN' type='submit' value='Add selection to cart' name='??????'>
			</form><br>

			<!-- Proceed to checkout button -->
			<form method='post' action='checkout.php'>	
				<input class='proceedToCheckoutButton' type='submit' value='Proceed to checkout' name='ProceedToCheckout'>
			</form>

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