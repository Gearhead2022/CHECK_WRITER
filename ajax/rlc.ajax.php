<?php
require_once "../controllers/rlc.controller.php";
require_once "../models/rlc.model.php";
require_once "../views/modules/session.php";
	$activateRlc = new rlcTable();
	$activateRlc -> showRlcTable();


class rlcTable{
	public function showRlcTable(){
		$rlc = (new ControllerRlc)->ctrShowRlc();
		if(count($rlc) == 0){
			$jsonData = '{"data":[]}';
			echo $jsonData;
			return;
		}
		$jsonData = '{
			"data":[';
				for($i=0; $i < count($rlc); $i++){
					$type = $_SESSION['type'];
					if($type == "admin" || $type == "hr_admin"  ){
						$buttons =  "<div  class='btn-group group-round m-1'><button class='btn btn-sm btn-success waves-effect waves-light btnEditShowClient' data-toggle='tooltip' data-placement='top' title='View'  idClient='".$rlc[$i]["id"]."' type='".$rlc[$i]["company"]."'>View</button><button data-toggle='tooltip' data-placement='top' title='Edit'  class='btn btn-sm btn-info waves-effect waves-light btnEditClient' type='".$rlc[$i]["company"]."' idClient='".$rlc[$i]["id"]."' >EDIT</button><button data-toggle='tooltip' data-placement='top' title='Delete'  class='btn btn-sm btn-danger waves-effect waves-light btnDeleteClient' idClient='".$rlc[$i]["id"]."' file_name='".$rlc[$i]["picture"]."' id_num='".$rlc[$i]["id_num"]."' company='".$rlc[$i]["company"]."'  ><i style='font-size: 15px;'  class='fa fa-trash'></i></button></div>";
					}elseif($type == "hr_user"){
						$buttons =  "<div  class='btn-group group-round m-1'><button class='btn btn-sm btn-success waves-effect waves-light btnEditShowClient' data-toggle='tooltip' data-placement='top' title='View' idClient='".$rlc[$i]["id"]."' type='".$rlc[$i]["company"]."'><i  style='font-size: 15px;' class='fa fa-eye'></i></button></div>";		  			

					}
				
					$jsonData .='[
					"'.$rlc[$i]["id_num"].'",
						"'.$rlc[$i]["fname"].'",
						"'.$rlc[$i]["mname"].'",
						"'.$rlc[$i]["lname"].'",
						"'.$rlc[$i]["company"].'",
						"'.$rlc[$i]["date_hired"].'",
						"'.$buttons.'"
					],';
				}
				$jsonData = substr($jsonData, 0, -1);
				$jsonData .= '] 
			}';
		echo $jsonData;
	}
	public function showHrTable(){
		$rlc = (new ControllerRlc)->ctrShowRlc();
		if(count($rlc) == 0){
			$jsonData = '{"data":[]}';
			echo $jsonData;
			return;
		}
		$jsonData = '{
			"data":[';
				for($i=0; $i < count($rlc); $i++){
				
						$buttons =  "<div  class='btn-group group-round m-1'><button class='btn btn-sm btn-success waves-effect waves-light btnEditShowClient' data-toggle='tooltip' data-placement='top' title='View' idClient='".$rlc[$i]["id"]."' type='".$rlc[$i]["company"]."'><i  style='font-size: 15px;' class='fa fa-eye'></i></button><button data-toggle='tooltip' data-placement='top' title='Edit'  class='btn btn-sm btn-info waves-effect waves-light btnEditClient' idClient='".$rlc[$i]["id"]."' type='".$rlc[$i]["company"]."'><i style='font-size: 15px;'  class='fa fa-pencil'></i></button></div>";		  			
					
					$jsonData .='[
					"'.$rlc[$i]["id_num"].'",
						"'.$rlc[$i]["fname"].'",
						"'.$rlc[$i]["mname"].'",
						"'.$rlc[$i]["lname"].'",
						"'.$rlc[$i]["company"].'",
						"'.$rlc[$i]["date_hired"].'",
						"'.$buttons.'"
					],';
				}
				$jsonData = substr($jsonData, 0, -1);
				$jsonData .= '] 
			}';
		echo $jsonData;
	}
	public function showUserRlcTable(){
		$rlc = (new ControllerRlc)->ctrShowRlc();
		if(count($rlc) == 0){
			$jsonData = '{"data":[]}';
			echo $jsonData;
			return;
		}
		$jsonData = '{
			"data":[';
				for($i=0; $i < count($rlc); $i++){
				
						$buttons =  "<div  class='btn-group group-round m-1'><button class='btn btn-sm btn-success waves-effect waves-light btnEditShowClient' data-toggle='tooltip' data-placement='top' title='View' idClient='".$rlc[$i]["id"]."' type='".$rlc[$i]["company"]."'><i  style='font-size: 15px;' class='fa fa-eye'></i></button></div>";		  			
					
					$jsonData .='[
						"'.$rlc[$i]["id_num"].'",
						"'.$rlc[$i]["fname"].'",
						"'.$rlc[$i]["mname"].'",
						"'.$rlc[$i]["lname"].'",
						"'.$rlc[$i]["company"].'",
						"'.$rlc[$i]["date_hired"].'",
						"'.$buttons.'"
					],';
				}
				$jsonData = substr($jsonData, 0, -1);
				$jsonData .= '] 
			}';
		echo $jsonData;
	}

	
}

