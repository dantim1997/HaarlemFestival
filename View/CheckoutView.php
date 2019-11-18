<?php 
require_once("Autoloader.php");
class CheckoutView
{
	private $CheckoutController;
	private $CheckoutModel;

	public function __construct($checkoutController, $checkoutModel)
	{
		$this->CheckoutController = $checkoutController;
		$this->CheckoutModel = $checkoutModel;
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
		return $this->CheckoutController->GetConfig()->GetHeader("Checkout"). "<link rel='stylesheet' type='text/css' href='checkout.css'>";
	}

	private function Body(){
		$nav = new Nav();
		return $nav->SetNavBar()."<div id='main'>
			<div class='checkoutContainer'>
				<h2 id='checkoutlbl'>Checkout</h2>

				<!-- date of ticket in cart -->
				<h3 id='daylbl'>Saturday Juli 28th (hier kan elke datum als var)</h3>
				<div class='blackBar'></div>

					<div class='tickets'>
						<div class=ticket>
							<p class=amountTickets>1 x</p>
							<p class='ticketText'>Restaurant Fris normal tickets 2nd session (19:00 - 20:30)   *Reservation fee*   € 40,-</p>
								<form method='post' action=''>	
									<input class='removeCheckoutItem' type='submit' value='&#10006' name='??????'>
								</form>
						</div>
					</div>	

					<!-- Dit is een ticket template, op de plekken VAR kan een aantal en de tekst van de ticket 
					<div class=ticket>
						<p class=amountTickets>VAR x</p>
						<p class='ticketText'>VAR</p>
							<form method='post' action=''>	
								<input class='removeCheckoutItem' type='submit' value='&#10006' name='??????'>
							</form>
					</div
					-->

				<div class='bottomBar'></div>

					<div class='checkoutControls'>
						<div class='input'>
							<select class='dropDown2'>
								<option value='-'>-</option>
								<option value='IDEAL'>IDEAL</option>
								<option value='VISA'>VISA</option>
								<option value='Paypal'>Paypal</option>
							</select>					

							<input class='emailtxt' type='text' placeholder='email' name='??????'>
						</div>

						<div class='labels'>
							<h3 class='selectlbl'>Select payment method</h3>
							<h3 class='selectlbl'>Enter email</h3>
						</div>

						<input class='extraNotestxt' type='text' placeholder='Special needs (allergies, wheelchair access, etc.):' name='??????'>
						
						<!-- proceed to payment button -->
						<form method='post' action=''>	
							<input class='proceedToCheckoutBTN checkoutBTN' type='submit' value='Proceed to payment' name='proceedToPaymentBTN'>
						</form>

					</div>
				
				<h2 id='totallbl'>Total due:</h2>	<!--Hier de totale prijs als var !-->

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