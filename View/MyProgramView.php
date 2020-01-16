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
		return $this->MyProgramController->GetConfig()->GetHeader("MyProgram");
	}

	private function Body(){
		$nav = new Nav();
		$pageContent = $this->PageContentHelper->GetPageText("MyProgram");
		return $nav->SetNavBar("MyProgram"). "
		<div id='main'>
			<div class='container-fluid'>
				<div class='row'>
				    <div class='col-sm-2' ></div>
					    <div class='col-sm-9'>
					    	<div class='OrderNumber'><form method='post'>".$pageContent[0]."<input type='Text' name='OrderNumber'><button class='ViewProgram'>".$pageContent[1]."</button></form>
					    	</div>
					    <div>
					    ".$this->MyProgramController->CheckOrderNumber($pageContent)."
						</div>
						<div class='spacingBar'></div>
					    <div class='col-sm-2'></div>
				  	</div>
				</div>
			
			</div>
      
  		</div>
		";
	}

	private function Footer(){
		return $this->MyProgramController->GetConfig()->SetFooter();
	}
}
?>