<?php
require_once "../controllers/clients.controller.php";
require_once "../models/clients.model.php";
require_once "../views/modules/session.php";


	$activateClients = new clientsTable();
	$activateClients -> showClientsTable();




class clientsTable{
	public function showClientsTable(){
		$clients = (new ControllerClients)->ctrShowClients();
		if(count($clients) == 0){
			$jsonData = '{"data":[]}';
			echo $jsonData;
			return;
		}
		$jsonData = '{
			"data":[';
				for($i=0; $i < count($clients); $i++){
					$type = $_SESSION['type'];
					if($type == "hr_admin" || $type == "admin"){
						$buttons =  "<div  class='btn-group group-round m-1'><button class='btn btn-sm btn-success waves-effect waves-light btnEditShowClient' data-toggle='tooltip' data-placement='top' title='View'  idClient='".$clients[$i]["id"]."' type='".$clients[$i]["company"]."'>View</button><button data-toggle='tooltip' data-placement='top' title='Edit'  class='btn btn-sm btn-info waves-effect waves-light btnEditClient' type='".$clients[$i]["company"]."' idClient='".$clients[$i]["id"]."' >EDIT</button><button data-toggle='tooltip' data-placement='top' title='Delete'  class='btn btn-sm btn-danger waves-effect waves-light btnDeleteClient' idClient='".$clients[$i]["id"]."' file_name='".$clients[$i]["picture"]."' id_num='".$clients[$i]["id_num"]."' company='".$clients[$i]["company"]."'  ><i style='font-size: 15px;'  class='fa fa-trash'></i></button></div>";
					}elseif($type == "hr_user"){
						$buttons =  "<div  class='btn-group group-round m-1'><button class='btn btn-sm btn-success waves-effect waves-light btnEditShowClient' data-toggle='tooltip' data-placement='top' title='View' idClient='".$clients[$i]["id"]."' type='".$clients[$i]["company"]."'><i  style='font-size: 15px;' class='fa fa-eye'></i></button></div>";		  			

					}
					
				 
					$jsonData .='[
					"'.$clients[$i]["id_num"].'",
						"'.$clients[$i]["fname"].'",
						"'.$clients[$i]["mname"].'",
						"'.$clients[$i]["lname"].'",
						"'.$clients[$i]["company"].'",
						"'.$clients[$i]["date_hired"].'",
						"'.$buttons.'"
					],';
				}
				$jsonData = substr($jsonData, 0, -1);
				$jsonData .= '] 
			}';
		echo $jsonData;
	}
	public function showHrTable(){
		$clients = (new ControllerClients)->ctrShowClients();
		if(count($clients) == 0){
			$jsonData = '{"data":[]}';
			echo $jsonData;
			return;
		} 
		$jsonData = '{
			"data":[';
				for($i=0; $i < count($clients); $i++){
				
						$buttons =  "<div  class='btn-group group-round m-1'><button class='btn btn-sm btn-success waves-effect waves-light btnEditShowClient' data-toggle='tooltip' data-placement='top' title='View'  idClient='".$clients[$i]["id"]."' type='".$clients[$i]["company"]."'><i  style='font-size: 15px;' class='fa fa-eye'></i></button><button data-toggle='tooltip' data-placement='top' title='Edit'  class='btn btn-sm btn-info waves-effect waves-light btnEditClient' type='".$clients[$i]["company"]."' idClient='".$clients[$i]["id"]."' ><i style='font-size: 15px;'  class='fa fa-pencil'></i></button></div>";		  			
					
					$jsonData .='[
					"'.$clients[$i]["id_num"].'",
						"'.$clients[$i]["fname"].'",
						"'.$clients[$i]["mname"].'",
						"'.$clients[$i]["lname"].'",
						"'.$clients[$i]["company"].'",
						"'.$clients[$i]["date_hired"].'",
						"'.$buttons.'"
					],';
				}
				$jsonData = substr($jsonData, 0, -1);
				$jsonData .= '] 
			}';
		echo $jsonData;
	}

	public function showUserClientsTable(){
		$clients = (new ControllerClients)->ctrShowClients();
		if(count($clients) == 0){
			$jsonData = '{"data":[]}';
			echo $jsonData;
			return;
		}
		$jsonData = '{
			"data":[';
				for($i=0; $i < count($clients); $i++){
				
						$buttons =  "<div  class='btn-group group-round m-1'><button class='btn btn-sm btn-success waves-effect waves-light btnEditShowClient' data-toggle='tooltip' data-placement='top' title='View' idClient='".$clients[$i]["id"]."' type='".$clients[$i]["company"]."'><i  style='font-size: 15px;' class='fa fa-eye'></i></button></div>";		  			
					
					$jsonData .='[
						"'.$clients[$i]["id_num"].'",
						"'.$clients[$i]["fname"].'",
						"'.$clients[$i]["mname"].'",
						"'.$clients[$i]["lname"].'",
						"'.$clients[$i]["company"].'",
						"'.$clients[$i]["date_hired"].'",
						"'.$buttons.'"
					],';
				}
				$jsonData = substr($jsonData, 0, -1);
				$jsonData .= '] 
			}';
		echo $jsonData;
	}

	
}

