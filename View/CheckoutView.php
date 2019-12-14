<?php 
require_once("Autoloader.php");
class CheckoutView
{
	private $CheckoutController;
	private $CheckoutModel;
	private $PageContentHelper;

	public function __construct($checkoutController, $checkoutModel)
	{
		$this->CheckoutController = $checkoutController;
		$this->CheckoutModel = $checkoutModel;
		$this->PageContentHelper = new PageContentHelper();
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
		//Getting all page content of Historic home in an array
		$pageTexts = $this->PageContentHelper->GetPageText("Checkout");
		return $nav->SetNavBar("Checkout")."<div id='main'>
			<div class='checkoutContainer'>
				<h2 id='checkoutlbl'>".current($pageTexts)."</h2>

				<!-- date of ticket in cart -->
				<div>
							".$this->CheckoutController->GetAllItems()."

					</div>
				<div class='bottomHalfCheckout'>
					<div class='bottomBar'></div>

						<div class='checkoutControls'>
							<div class='input'>
								<select class='dropDown2'>
									<option value='-'>-</option>
									<option value='IDEAL'>IDEAL</option>
									<option value='VISA'>VISA</option>
									<option value='Paypal'>Paypal</option>
								</select>					

								<input class='lbltxt' type='text' placeholder='Firstname' name='??????'>
								<input class='lbltxt' type='text' placeholder='Lastname' name='??????'>
								<input class='lbltxt' type='text' placeholder='Email' name='??????'>
								<input class='lbltxt' type='text' placeholder='Address' name='??????'>
								<input class='lbltxt' type='text' placeholder='Phone number' name='??????'>
							</div>

							<div class='labels'>
								<h3 class='selectlbl selectlblextra'>".next($pageTexts)."</h3>
								<h3 class='selectlbl'>".next($pageTexts)."</h3>
								<h3 class='selectlbl'>".next($pageTexts)."</h3>
								<h3 class='selectlbl'>".next($pageTexts)."</h3>
								<h3 class='selectlbl'>".next($pageTexts)."</h3>
								<h3 class='selectlbl'>".next($pageTexts)."</h3>
								<h3 class='selectlbl selectlblextra2'>".next($pageTexts)."</h3>
							</div>

							<input class='extraNotestxt' type='text' placeholder='Special needs (allergies, wheelchair access, etc.):' name='??????'>
							
							<!-- proceed to payment button -->
							<form method='post' action=''>	
								<input class='proceedToCheckoutBTN checkoutBTN' type='submit' value='".next($pageTexts)."' name='proceedToPaymentBTN'>
							</form>

						</div>
					
					<h2 id='totallbl'>".next($pageTexts)." ".Number_format($this->CheckoutModel->GetTotal(), 2, ',', ' ')."</h2>	<!--Hier de totale prijs als var !-->
				</div>
			</div>
		</div>";
	}

	private function Footer(){
		return $this->CheckoutController->GetConfig()->SetFooter();
	}
}
?>