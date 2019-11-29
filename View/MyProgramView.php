<?php 
require_once("Autoloader.php");
class MyProgramView
{
	private $MyProgramController;
	private $MyProgramModel;

	public function __construct($myProgramController, $myProgramModel)
	{
		$this->MyProgramController = $myProgramController;
		$this->MyProgramModel = $myProgramModel;
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
		return $this->MyProgramController->GetConfig()->GetHeader("MyProgram");
	}

	private function Body(){
		$nav = new Nav();
		return $nav->SetNavBar("MyProgram"). "
		<div id='main'>
			<div class='container-fluid'>
				<div class='row'>
				    <div class='col-sm-2' ></div>
					    <div class='col-sm-9'>
					    	<div class='OrderNumber'><form method='post'>Enter your OrderNumber: <input type='Text' name='OrderNumber'><button class='ViewProgram'>View Programme</button></form>
					    	</div>
					    <div>
					    ".$this->MyProgramController->CheckOrderNumber()."
						</div>
					    <div class='col-sm-2'></div>
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