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
		//Get all the content and put it in an array
		$pageTexts = $this->PageContentHelper->GetPageText("HistoricOrderTickets");
		return $nav->SetNavBar("Historic").
		"<div id='main'>
			<div class='orderTicketsContainer'>
				<div class='orderTicketsSelection'>
							<div class='orderTicketsheaderContainer'>
								<div class='blackBar5'></div>
									<h2 class='orderTicketsHeader'>".current($pageTexts)."</h2>
								<div class='blackBar5'></div>
							</div>

							<p class='orderTicketslabels'>
								".next($pageTexts)."<br>
								".next($pageTexts)."
							</p>
							<form method='post' action='HistoricOrderTickets.php'>
								<div class='orderTicketsDropdwn'>
									<select name='language' class='dropDown'>
										<option value='".$this->getSelectedLanguage()."'>".$this->getSelectedLanguage()."</option>
										<option value='English'>English</option>
										<option value='Dutch'>Dutch</option>
										<option value='Mandarin'>Mandarin</option>
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

				<p class='unavailableTickets'>".$this->ticketInformation['NotAvailable']."</p>

				<div class='ticketsContainer'>
					<h5 class='normalTicket'>".next($pageTexts)."</h5>
					<h5 class='familyTicket'>".next($pageTexts)."</h5>

					<div class='normalTickets'> 
					".$this->ticketInformation['normalTickets']."
					</div>

					<div class='familyTickets'>
					".$this->ticketInformation['familyTickets']."
					</div>
				</div>

				<!-- Proceed to checkout button -->
				<a href='Checkout.php' id='proceedToCheckoutButton' type='submit' name='ProceedToCheckout'>".next($pageTexts)."</a>
			</div>
		</div>";
	}

	private function getSelectedLanguage(){
		if (isset($_POST['language'])) {
			return $_POST['language'];
		}
		else{
			return "-";
		}
	}

	private function Footer(){
		return $this->HistoricOrderTicketsController->GetConfig()->SetFooter();
	}
}
?>