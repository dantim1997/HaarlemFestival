<?php
	require_once( "Autoloader.php");
class AdvancedDanceSearchController 
{
	private $DanceModel;
	private $Session;
	private $Config;

	public function __construct($danceModel){
		$this->Dancemodel = $danceModel;
		$this->Config = Config::getInstance();
	}
	
	//get config
	public function GetConfig(){
		return $this->Config;
	}

	public function GetSearchResults(){
		if(isset($_GET['ArtistCheckbox']))
		{
		    var_dump($_GET['ArtistCheckbox']);
		}
	}
}
?>