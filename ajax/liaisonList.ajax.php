<?php
require_once "../controllers/checkwriter.controller.php";
require_once "../models/checkwriter.model.php";
require_once "../views/modules/session.php";
$activatAccount = new accountTable();
$activatAccount -> showAccountTable();

class accountTable{
	public function showAccountTable(){
		$account = (new ControllerCheckWriter)->ctrShowLiaisonList();
		if(count($account) == 0){
			$jsonData = '{"data":[]}';
			echo $jsonData;
			return;
		}
		$jsonData = '{
			"data":[';
				for($i=0; $i < count($account); $i++){

					$buttons = "<div class='btn-group group-round m-1'><button data-toggle='tooltip' data-placement='top' title='Edit'  class='btn btn-sm btn-info waves-effect waves-light btnEditLiaison' l_id='".$account[$i]["l_id"]."'><i style='font-size: 15px;'  class='fa fa-pencil'></i></button><button data-toggle='tooltip' data-placement='top' title='Delete'  class='btn btn-sm btn-danger waves-effect waves-light btnDeleteLiaison' l_id='".$account[$i]["l_id"]."'><i style='font-size: 15px;'  class='fa fa-trash'></i></button></div>";		  			
					 
					$jsonData .='[	
						"'.$buttons.'",
                        "'.$account[$i]["l_id"].'",
						"'.$account[$i]["full_name"].'",
						"'.$account[$i]["address"].'",
						"'.$account[$i]["contact_no"].'"
					],';
				}
				$jsonData = substr($jsonData, 0, -1);
				$jsonData .= '] 
			}';
		echo $jsonData;
	}
	
	
}

