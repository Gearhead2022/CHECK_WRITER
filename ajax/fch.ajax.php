<?php
require_once "../controllers/fch.controller.php";
require_once "../models/fch.model.php";
require_once "../views/modules/session.php";

	$activateFch = new fchTable();
	$activateFch -> showFchTable();



class fchTable{
	public function showFchTable(){
		$fch = (new ControllerFch)->ctrShowFch();
		if(count($fch) == 0){
			$jsonData = '{"data":[]}';
			echo $jsonData;
			return;
		} 
		$jsonData = '{
			"data":[';
				for($i=0; $i < count($fch); $i++){
					$type = $_SESSION['type'];
					if($type == "hr_admin" || $type == "admin"){
						$buttons =  "<div  class='btn-group group-round m-1'><button class='btn btn-sm btn-success waves-effect waves-light btnEditShowClient' data-toggle='tooltip' data-placement='top' title='View'  idClient='".$fch[$i]["id"]."' type='".$fch[$i]["company"]."'>View</button><button data-toggle='tooltip' data-placement='top' title='Edit'  class='btn btn-sm btn-info waves-effect waves-light btnEditClient' type='".$fch[$i]["company"]."' idClient='".$fch[$i]["id"]."' >EDIT</button><button data-toggle='tooltip' data-placement='top' title='Delete'  class='btn btn-sm btn-danger waves-effect waves-light btnDeleteClient' idClient='".$fch[$i]["id"]."' file_name='".$fch[$i]["picture"]."' id_num='".$fch[$i]["id_num"]."' company='".$fch[$i]["company"]."'  ><i style='font-size: 15px;'  class='fa fa-trash'></i></button></div>";
					}elseif($type == "hr_user"){
						$buttons =  "<div  class='btn-group group-round m-1'><button class='btn btn-sm btn-success waves-effect waves-light btnEditShowClient' data-toggle='tooltip' data-placement='top' title='View' idClient='".$fch[$i]["id"]."' type='".$fch[$i]["company"]."'><i  style='font-size: 15px;' class='fa fa-eye'></i></button></div>";		  			


					}
						$jsonData .='[
					"'.$fch[$i]["id_num"].'",
						"'.$fch[$i]["fname"].'",
						"'.$fch[$i]["mname"].'",
						"'.$fch[$i]["lname"].'",
						"'.$fch[$i]["company"].'",
						"'.$fch[$i]["date_hired"].'",
						"'.$buttons.'"
					],';
				}
				$jsonData = substr($jsonData, 0, -1);
				$jsonData .= '] 
			}';
		echo $jsonData;
	}

	public function showHrTable(){
		$fch = (new ControllerFch)->ctrShowFch();
		if(count($fch) == 0){
			$jsonData = '{"data":[]}';
			echo $jsonData;
			return;
		}
		$jsonData = '{
			"data":[';
				for($i=0; $i < count($fch); $i++){
				
						$buttons =  "<div  class='btn-group group-round m-1'><button class='btn btn-sm btn-success waves-effect waves-light btnEditShowClient' data-toggle='tooltip' data-placement='top' title='View' idClient='".$fch[$i]["id"]."' type='".$fch[$i]["company"]."'><i  style='font-size: 15px;' class='fa fa-eye'></i></button><button data-toggle='tooltip' data-placement='top' title='Edit'  class='btn btn-sm btn-info waves-effect waves-light btnEditClient' idClient='".$fch[$i]["id"]."' type='".$fch[$i]["company"]."'><i style='font-size: 15px;'  class='fa fa-pencil'></i></button></div>";		  			
					
					$jsonData .='[
					"'.$fch[$i]["id_num"].'",
						"'.$fch[$i]["fname"].'",
						"'.$fch[$i]["mname"].'",
						"'.$fch[$i]["lname"].'",
						"'.$fch[$i]["company"].'",
						"'.$fch[$i]["date_hired"].'",
						"'.$buttons.'"
					],';
				}
				$jsonData = substr($jsonData, 0, -1);
				$jsonData .= '] 
			}';
		echo $jsonData;
	}

	
	public function showUserFchTable(){
		$fch = (new ControllerFch)->ctrShowFch();
		if(count($fch) == 0){
			$jsonData = '{"data":[]}';
			echo $jsonData;
			return;
		}
		$jsonData = '{
			"data":[';
				for($i=0; $i < count($fch); $i++){
				
						$buttons =  "<div  class='btn-group group-round m-1'><button class='btn btn-sm btn-success waves-effect waves-light btnEditShowClient' data-toggle='tooltip' data-placement='top' title='View' idClient='".$fch[$i]["id"]."' type='".$fch[$i]["company"]."'><i  style='font-size: 15px;' class='fa fa-eye'></i></button></div>";		  			
					
					$jsonData .='[
						"'.$fch[$i]["id_num"].'",
						"'.$fch[$i]["fname"].'",
						"'.$fch[$i]["mname"].'",
						"'.$fch[$i]["lname"].'",
						"'.$fch[$i]["company"].'",
						"'.$fch[$i]["date_hired"].'",
						"'.$buttons.'"
					],';
				}
				$jsonData = substr($jsonData, 0, -1);
				$jsonData .= '] 
			}';
		echo $jsonData;
	}

	
}

