<?php
require_once "../controllers/blacklist.controller.php";
require_once "../models/blacklist.model.php";
require_once "../views/modules/session.php";
$type = $_SESSION['type'];
if($type=="admin" || $type =="pdr_admin"){
	$activateBlacklist = new blacklistTable();
	$activateBlacklist -> showBlacklistTable();
}elseif($type=="user" || $type=="pdr_user"  ){
	$activateBlacklist = new blacklistTable();
	$activateBlacklist -> showUserBlacklistTable();
}

 
class blacklistTable{
	public function showBlacklistTable(){
		$blacklist = (new ControllerBlacklist)->ctrShowBlacklist();
		if(count($blacklist) == 0){
			$jsonData = '{"data":[]}';
			echo $jsonData;
			return;
		}
		$jsonData = '{
			"data":[';
				for($i=0; $i < count($blacklist); $i++){
				 
						$buttons =  "<div  class='btn-group group-round m-1'><button class='btn btn-sm btn-success waves-effect waves-light btnEditShowClient' data-toggle='tooltip' data-placement='top' title='View' idClient='".$blacklist[$i]["id"]."'>VIEW</button><button data-toggle='tooltip' data-placement='top' title='Edit'  class='btn btn-sm btn-info waves-effect waves-light btnEditClient' idClient='".$blacklist[$i]["id"]."'>EDIT</i></button><button data-toggle='tooltip' data-placement='top' title='Delete'  class='btn btn-sm btn-danger waves-effect waves-light btnDeleteClient' idClient='".$blacklist[$i]["id"]."' clientid='".$blacklist[$i]["clientid"]."' file_name='".$blacklist[$i]["upload_files"]."'><i style='font-size: 15px;'  class='fa fa-trash'></i></button></div>";		  			
					
					$jsonData .='[
						"'.$blacklist[$i]["last_name"].'",
						"'.$blacklist[$i]["middle_name"].'",
						"'.$blacklist[$i]["first_name"].'",
						"'.$blacklist[$i]["lending_firm"].'",
						"'.$buttons.'"
					],';
				}
				$jsonData = substr($jsonData, 0, -1);
				$jsonData .= '] 
			}';
		echo $jsonData;
	}
	public function showUserBlacklistTable(){
		$blacklist = (new ControllerBlacklist)->ctrShowBlacklist();
		if(count($blacklist) == 0){
			$jsonData = '{"data":[]}';
			echo $jsonData;
			return;
		}
		$jsonData = '{
			"data":[';
				for($i=0; $i < count($blacklist); $i++){
				
						$buttons =  "<div  class='btn-group group-round m-1'><button class='btn btn-sm btn-success waves-effect waves-light btnEditShowClient' data-toggle='tooltip' data-placement='top' title='View' idClient='".$blacklist[$i]["id"]."'>VIEW</button></div>";		  			
					
					$jsonData .='[
						"'.$blacklist[$i]["last_name"].'",
						"'.$blacklist[$i]["middle_name"].'",
						"'.$blacklist[$i]["first_name"].'",
						"'.$blacklist[$i]["lending_firm"].'",
						"'.$buttons.'"
					],';
				}
				$jsonData = substr($jsonData, 0, -1);
				$jsonData .= '] 
			}';
		echo $jsonData;
	}

	
}

