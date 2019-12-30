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
		return $this->CheckoutController->GetConfig()->GetHeader("Checkout"). "<link rel='stylesheet' type='text/css' href='css/checkout.css'>";
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
					<form method='post' action=''>	
								<table>
									
									<tr>
										<td><h3 class='selectlbl selectlblextra'>".next($pageTexts)."</h3></td>
										<td><input pattern='[a-zA-Z]*' class='lbltxt' type='text'  name='FirstName'></td>
									</tr>
									<tr>
										<td><h3 class='selectlbl'>".next($pageTexts)."</h3></td>
										<td><input pattern='[a-zA-Z]*' class='lbltxt' type='text'  name='LastName'></td>
									</tr>
									<tr>
										<td><h3 class='selectlbl'>".next($pageTexts)."</h3></td>
										<td><input class='lbltxt' type='Email'  name='Email'></td>
									</tr>
									<tr>
										<td><h3 class='selectlbl'>".next($pageTexts)."</h3></td>
										<td><input pattern='[0-9]{4}[a-zA-Z]{2}' class='lbltxt' type='text' name='PostCode'></td>
									</tr>
									<tr>
										<td><h3 class='selectlbl'>".next($pageTexts)."</h3></td>
										<td>
											<input pattern='[0-9]{4}' style='width:20%;' class='lbltxt' type='number' name='HouseNumber'>
											<input pattern='[a-zA-Z]*'style='width:80%;' class='lbltxt' type='text' placeholder='Street' name='Street'>
										</td>
									</tr>
									<tr>
										<td><h3 class='selectlbl'>".next($pageTexts)."</h3></td>
										<td><input class='lbltxt' type='text'  name='PhoneNumber'></td>
									</tr>
								</table>
								<p>* This is required</p>
							</div>
							
							<!-- proceed to payment button -->
								<input class='proceedToCheckoutBTN checkoutBTN' type='submit' value='".next($pageTexts)."' name='proceedToPaymentBTN'>
							</form>
						</div>
					".$this->CheckoutController->GetReservationFee()."
					<h2 id='totallbl'>".next($pageTexts)." </h2><h2 id='TotalAmount'>".Number_format($this->CheckoutModel->GetTotal(), 2, ',', '')."</h2>	<!--Hier de totale prijs als var !-->
					</br>
					</br>
					<h2 id='totalFoodlbl'>".next($pageTexts)." </h2><h2 id='TotalFoodAmount'>".Number_format($this->CheckoutModel->GetFoodTotal(), 2, ',', '')."</h2>
				</div>
			</div>
		</div>";
	}

	private function Footer() {
		return $this->CheckoutController->GetConfig()->SetFooter();
	}
}
?>