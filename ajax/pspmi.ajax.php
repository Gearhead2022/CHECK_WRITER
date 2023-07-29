<?php
require_once "../controllers/pspmi.controller.php";
require_once "../models/pspmi.model.php";
require_once "../views/modules/session.php";
$activatePspmi = new pspmiTable();
$activatePspmi -> showPspmiTable();



class pspmiTable{
	public function showPspmiTable(){
		$pspmi = (new ControllerPspmi)->ctrShowPspmi();
		if(count($pspmi) == 0){
			$jsonData = '{"data":[]}';
			echo $jsonData;
			return;
		}
		$jsonData = '{
			"data":[';
				for($i=0; $i < count($pspmi); $i++){
					$type = $_SESSION['type'];
					if($type == "hr_admin" || $type == "admin"){
						$buttons =  "<div  class='btn-group group-round m-1'><button class='btn btn-sm btn-success waves-effect waves-light btnEditShowClient' data-toggle='tooltip' data-placement='top' title='View'  idClient='".$pspmi[$i]["id"]."' type='".$pspmi[$i]["company"]."'>View</button><button data-toggle='tooltip' data-placement='top' title='Edit'  class='btn btn-sm btn-info waves-effect waves-light btnEditClient' type='".$pspmi[$i]["company"]."' idClient='".$pspmi[$i]["id"]."' >EDIT</button><button data-toggle='tooltip' data-placement='top' title='Delete'  class='btn btn-sm btn-danger waves-effect waves-light btnDeleteClient' idClient='".$pspmi[$i]["id"]."' file_name='".$pspmi[$i]["picture"]."' id_num='".$pspmi[$i]["id_num"]."' company='".$pspmi[$i]["company"]."'  ><i style='font-size: 15px;'  class='fa fa-trash'></i></button></div>";
					}elseif($type == "hr_user"){
						$buttons =  "<div  class='btn-group group-round m-1'><button class='btn btn-sm btn-success waves-effect waves-light btnEditShowClient' data-toggle='tooltip' data-placement='top' title='View' idClient='".$pspmi[$i]["id"]."' type='".$pspmi[$i]["company"]."'><i  style='font-size: 15px;' class='fa fa-eye'></i></button></div>";		  			
					}	
						$jsonData .='[
					"'.$pspmi[$i]["id_num"].'",
						"'.$pspmi[$i]["fname"].'",
						"'.$pspmi[$i]["mname"].'",
						"'.$pspmi[$i]["lname"].'",
						"'.$pspmi[$i]["company"].'",
						"'.$pspmi[$i]["date_hired"].'",
						"'.$buttons.'"
					],';
				}
				$jsonData = substr($jsonData, 0, -1);
				$jsonData .= '] 
			}';
		echo $jsonData;
	}

	public function showHrTable(){
		$pspmi = (new ControllerPspmi)->ctrShowPspmi();
		if(count($pspmi) == 0){
			$jsonData = '{"data":[]}';
			echo $jsonData;
			return;
		}
		$jsonData = '{
			"data":[';
				for($i=0; $i < count($pspmi); $i++){
				
						$buttons =  "<div  class='btn-group group-round m-1'><button class='btn btn-sm btn-success waves-effect waves-light btnEditShowClient' data-toggle='tooltip' data-placement='top' title='View' idClient='".$pspmi[$i]["id"]."' type='".$pspmi[$i]["company"]."'><i  style='font-size: 15px;' class='fa fa-eye'></i></button><button data-toggle='tooltip' data-placement='top' title='Edit'  class='btn btn-sm btn-info waves-effect waves-light btnEditClient' idClient='".$pspmi[$i]["id"]."' type='".$pspmi[$i]["company"]."'><i style='font-size: 15px;'  class='fa fa-pencil'></i></button></div>";		  			
					
					$jsonData .='[
					"'.$pspmi[$i]["id_num"].'",
						"'.$pspmi[$i]["fname"].'",
						"'.$pspmi[$i]["mname"].'",
						"'.$pspmi[$i]["lname"].'",
						"'.$pspmi[$i]["company"].'",
						"'.$pspmi[$i]["date_hired"].'",
						"'.$buttons.'"
					],';
				}
				$jsonData = substr($jsonData, 0, -1);
				$jsonData .= '] 
			}';
		echo $jsonData;
	}
	public function showUserPspmiTable(){
		$pspmi = (new ControllerPspmi)->ctrShowPspmi();
		if(count($pspmi) == 0){
			$jsonData = '{"data":[]}';
			echo $jsonData;
			return;
		}
		$jsonData = '{
			"data":[';
				for($i=0; $i < count($pspmi); $i++){
				
						$buttons =  "<div  class='btn-group group-round m-1'><button class='btn btn-sm btn-success waves-effect waves-light btnEditShowClient' data-toggle='tooltip' data-placement='top' title='View' idClient='".$pspmi[$i]["id"]."' type='".$pspmi[$i]["company"]."'><i  style='font-size: 15px;' class='fa fa-eye'></i></button></div>";		  			
					
					$jsonData .='[
						"'.$pspmi[$i]["id_num"].'",
						"'.$pspmi[$i]["fname"].'",
						"'.$pspmi[$i]["mname"].'",
						"'.$pspmi[$i]["lname"].'",
						"'.$pspmi[$i]["company"].'",
						"'.$pspmi[$i]["date_hired"].'",
						"'.$buttons.'"
					],';
				}
				$jsonData = substr($jsonData, 0, -1);
				$jsonData .= '] 
			}';
		echo $jsonData;
	}

	
}

