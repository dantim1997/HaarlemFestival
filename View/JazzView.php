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
		return $this->JazzController->GetConfig()->GetHeader("Jazz");
	}

	private function Body(){
		$nav = new Nav();
		$pageTexts = $this->PageContentHelper->GetPageText("Jazz");
		$dates = $this->JazzController->days;
		return $nav->SetNavBar("Jazz"). "<div class='main'>
			<div class='container'>
				<div class='title'>".current($pageTexts)."</div>
			</div>
			<div class='content'>
				<h1>".next($pageTexts)."</h1>
				<p class='paragraph'>".next($pageTexts)."</p>
				<h2>".next($pageTexts)."</h2>

					<button onclick='ToggleAdvancedJazz()' class='filterbutton2'>".next($pageTexts)."</button>
					<div id='AdvancedFilter' class='filter'>
						<form method='GET' action='Jazz.php'>
					   	".$this->JazzController->MakeGenreAdvancedSearch()."
					   	<input type='submit' class='filterbutton' value='Filter Artists'>
						</form>
					</div><br>

				<div id='carouselExampleControls' class='carousel slide' data-ride='carousel'>
					<div class='carousel-inner'>
					  ".$this->JazzController->MakeCarousel()."
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

				<h2>".next($pageTexts)."</h2>
					<table class='tg'>
					".$this->JazzController->GetProgramme()."
					</table>
				<h2>".next($pageTexts)."</h2>
				<section class='ticketsJazz'>
					<div class='dates'>
						<div onclick='ShowDate(1)' class='selectday'>".next($pageTexts)."</div>
						<div onclick='ShowDate(2)' class='selectday'>".next($pageTexts)."</div>
						<div onclick='ShowDate(3)' class='selectday'>".next($pageTexts)."</div>
						<div onclick='ShowDate(4)' class='selectday'>".next($pageTexts)."</div>
					</div>
					<div>
						<image id='Thursday' class='arrow-up' src='http://hfteam3.infhaarlem.nl/cms/Images/Jazz/arrow-up.png'>
						<image id='Friday' class='arrow-up' src='http://hfteam3.infhaarlem.nl/cms/Images/Jazz/arrow-up.png'>
						<image id='Saturday' class='arrow-up' src='http://hfteam3.infhaarlem.nl/cms/Images/Jazz/arrow-up.png'>
						<image id='Sunday' class='arrow-up' src='http://hfteam3.infhaarlem.nl/cms/Images/Jazz/arrow-up.png'>
					</div>
					<div id='Thursday1' class='thursday'>
					<h1>".next($pageTexts)."</h1>
					<br>
					<div class='form'>
							".$this->JazzController->GetOrderForm($dates[0]["Dates"])."
							<br>
							<input class='addCart' onclick='JazzAddToCart()' type='submit' value='Add Tickets'>
					</div>
					<div class='tickets'>
						<hr>
						".$this->JazzController->FillTickets($dates[0]["Dates"])."
						<br>
						<br>
						<br>
						<br>
						<br>
						<br>
						".$this->JazzController->GetLocation($dates[0]["Dates"])."
					</div>
					</div>
					<div id='Friday1' class='friday'>
					<h1>".next($pageTexts)."</h1>
					<br>
					<div class='form'>
							".$this->JazzController->GetOrderForm($dates[1]["Dates"])."
							<br>
							<input class='addCart' onclick='JazzAddToCart()' type='submit' value='Add Tickets'>
					</div>
					<div class='tickets'>
						<hr>
						".$this->JazzController->FillTickets($dates[1]["Dates"])."
						<br>
						<br>
						<br>
						<br>
						<br>
						<br>
						".$this->JazzController->GetLocation($dates[1]["Dates"])."
					</div>
					</div>
					<div id='Saturday1' class='saturday'>
						<h1>".next($pageTexts)."</h1>
						<br>
						<div class='form'>
							".$this->JazzController->GetOrderForm($dates[2]["Dates"])."
							<br>
							<input class='addCart' onclick='JazzAddToCart()' type='submit' value='Add Tickets'>
						</div>
						<div class='tickets'>
							<hr>
							".$this->JazzController->FillTickets($dates[2]["Dates"])."
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							".$this->JazzController->GetLocation($dates[2]["Dates"])."
						</div>
					</div>
					<div id='Sunday1' class='sunday'>
						<h1>".next($pageTexts)."</h1>
						<p class='paragraph'>".next($pageTexts)."</p>
						<br>
						<h2>".next($pageTexts)."</h2>
						<br>
						<hr>
						".$this->JazzController->FillTickets($dates[3]["Dates"])."
						<br>
						<br>
						".$this->JazzController->GetLocation($dates[3]["Dates"])."
					</div>
				</section>
			</div>
		</div>
		<script>
		Hide();
		</script>";
	}

	private function Footer(){
		return $this->JazzController->GetConfig()->SetFooter();
	}

	public function FilterInputBox($genre){
		return "<input class='checkbox' type='checkbox' name='GenreCheckbox[]' value=".$genre."><label>".$genre."</label><br/>";
	}

	public function Carousel($artists){
		$this->JazzController = new JazzController;
		$first = true;
		foreach ($artists as $artist) {
			$counter++;
			//If is the first item, add div header (active row)
			if ($first){
				$carousel .= "<div class='carousel-item active'><div class='artists'>";
			}
			//else add normal row
			else if ($counter == 1 && !$first){
				$carousel .= "<div class='carousel-item'><div class='artists'>";
			}
			$first = false;
			$carousel .= "<div class='artist'>
							<div class='artistname'>".$artist->getArtistName()."</div>
							<div class='artistcontainer'>
								<image class='artistimage' src='".$this->JazzController->CheckImageIsSet($artist->getImage())."'>
								<div class='".$this->JazzController->DefineStyleGenre($artist->getGenre())."'>".$artist->getGenre()."</div>
								<div class='genre0'>0</div></div></div>";
			//Close artist section (1 row = 4 columns)
			if ($counter == 4){
				$counter = 0;
				$carousel .= "</div></div>";
			}
		}
		//Close div section if items are not 0 (prevents empty slide)
		if ($counter % 4 != 0){
			$carousel .= "</div></div>";
		}
		return $carousel;
	}

	public function TimeTableHeader($dates){
		$tableHeader = "<tr><th class='tg-lh0f'></th>";

		foreach ($dates as $date) {
			$tableHeader .= "<th class='tg-qcxk'><span style='font-weight:700'>".$date."</span></th>";
		}

		$tableHeader .= "</tr>";

		return $tableHeader;
	}

	public function TimeTableRows($timeBegin, $timeEnd, $days){
		for($i=0; $i < count($timeBegin); $i++) {
			$time = $timeBegin[$i];
			$programme .= "<tr><td class='tg-6jhs'>".$timeBegin[$i]." - ".$timeEnd[$i]."</td>";
			//Add rows foreach day
			for ($counter=0; $counter < count($days); $counter++) { 
				$day = $days[$counter]["Dates"]; 
				$day = date('Y-m-d H:i:s', strtotime($day." $time"));
				$programme .= "<td class='tg-m4n1'>".$this->JazzController->GetArtistForProgramme($day)."</td>";
			}
			$programme .= "<tr>";
		}
		return $programme;
	}

	public function TimeTableSplit(){
		return "<hr id='bordertable'>";
	}
}
?>