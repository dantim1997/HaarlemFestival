<?php
	require_once( "Autoloader.php");
class IndexController implements IController
{
	private $IndexModel;
	private $Session;
	private $Config;

	public function __construct($indexModel){
		$this->IndexModel = $indexModel;
		$this->Config = Config::getInstance();
		$this->Session = new SessionUser();
		$this->IndexModel->SetCurrentUser($this->Session->CheckSession());
	}
	
	//get config
	public function GetConfig(){
		return $this->Config;
	}
}

?>