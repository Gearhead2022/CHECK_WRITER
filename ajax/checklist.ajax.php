<?php
require_once "../controllers/checklist.controller.php";
require_once "../models/checklist.model.php";
require_once "../views/modules/session.php";
$checklist = new checklistTable();
$checklist -> showChecklistTable();


 
class checklistTable{
	public function showChecklistTable(){
		$check = (new ControllerChecklist)->ctrShowChecklist();
		if(count($check) == 0){
			$jsonData = '{"data":[]}';
			echo $jsonData;
			return;
		}
		$jsonData = '{
			"data":[';
				for($i=0; $i < count($check); $i++){
					$dateString = $check[$i]["chk_date"];
					$chk_date = date("F d, Y", strtotime($dateString));
						$buttons =  "<div class='btn-group group-round m-1'><button data-toggle='tooltip' data-placement='top' title='Edit'  class='btn btn-sm btn-success waves-effect waves-light btnViewChecklist'  idClient='".$check[$i]["chk_id"]."' chk_date='".$check[$i]["chk_date"]."'>VIEW</button><button data-toggle='tooltip' data-placement='top' title='Edit'  class='btn btn-sm btn-info waves-effect waves-light btnEditClient' idClient='".$check[$i]["id"]."'>EDIT</button><button data-toggle='tooltip' data-placement='top' title='Delete'  class='btn btn-sm btn-danger waves-effect waves-light btnDeleteClient' idClient='".$check[$i]["id"]."' chk_id='".$check[$i]["chk_id"]."'><i style='font-size: 15px;'  class='fa fa-trash'></i></button></div>";
					$jsonData .='[	
                        "'.$check[$i]["id"].'",
                        "'.$check[$i]["full_name"].'",
						"'.$chk_date.'",
						"'.$buttons.'"
					],';
				}
				$jsonData = substr($jsonData, 0, -1);
				$jsonData .= '] 
			}';
		echo $jsonData;
	}
	
	
}

