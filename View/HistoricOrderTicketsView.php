<?php 
require_once("Autoloader.php");
class HistoricOrderTicketsView
{
	private $HistoricOrderTicketsController;
	private $HistoricOrderTicketsModel;
	private $ticketInformation;
	private $PageContentHelper;

	public function __construct($historicOrderTicketsController, $historicOrderTicketsModel)
	{
		$this->HistoricOrderTicketsController = $historicOrderTicketsController;
		$this->HistoricOrderTicketsModel = $historicOrderTicketsModel;
		$this->PageContentHelper = new PageContentHelper();

	}

	//output to html
	public function output(){
		$this->ticketInformation = $this->HistoricOrderTicketsController->GetTickets();
		$page = "";
		$page .= $this->Header();
		$page .= $this->Body();
		$page .= $this->Footer();
		return $page;
	}

	private function Header(){
		return $this->HistoricOrderTicketsController->GetConfig()->GetHeader("Historic");
	}

	private function Body(){
		$nav = new Nav();
		return $nav->SetNavBar("Historic").
		"<div id='main'>
			<div class='orderTicketsContainer'>
				<div class='orderTicketsSelection'>
							<div class='orderTicketsheaderContainer'>
								<div class='blackBar5'></div>
									<h2 class='orderTicketsHeader'>".$this->PageContentHelper->GetPageText("HistoricOrderTickets", "1")."</h2>
								<div class='blackBar5'></div>
							</div>

							<p class='orderTicketslabels'>
								".$this->PageContentHelper->GetPageText("HistoricOrderTickets", "2")."<br>
								".$this->PageContentHelper->GetPageText("HistoricOrderTickets", "3")."
							</p>
							<form method='post' action='historicOrderTickets.php'>
								<div class='orderTicketsDropdwn'>
									<select name='language' class='dropDown'>
										<option value='-'>-</option>
										<option value='English'>English</option>
										<option value='Dutch'>Dutch</option>
										<option value='Chinese'>Chinese</option>
									</select><br>
									<select name='day' class='dropDown' onchange='this.form.submit()'>
										<option value='-'>-</option>
										<option value='2020-07-26'>Sunday 26th of Juli</option>
										<option value='2020-07-27'>Monday 27th of Juli</option>
										<option value='2020-07-28'>Tuesday 28th of Juli</option>
										<option value='2020-07-29'>Wednesday 29th of Juli</option>
									</select>
								</div>	
							</form>	
				</div>


				<h5 class='dayLabel'>".$this->ticketInformation['day']."</h5>

				<div class='ticketsContainer'>
					<h5 class='normalTicket'>".$this->PageContentHelper->GetPageText("HistoricOrderTickets", "4")."</h5>
					<h5 class='familyTicket'>".$this->PageContentHelper->GetPageText("HistoricOrderTickets", "5")."</h5>

					<div class='normalTickets'> 
					".$this->ticketInformation['normalTickets']."
					</div>

					<div class='familyTickets'>
					".$this->ticketInformation['familyTickets']."
					</div>
				</div>

				<!-- Proceed to checkout button -->
				<form method='post' action='checkout.php'>	
					<input class='proceedToCheckoutButton' type='submit' value='".$this->PageContentHelper->GetPageText("HistoricOrderTickets", "6")."' name='ProceedToCheckout'>
				</form>
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