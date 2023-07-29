<?php
require_once "../controllers/pastdue.controller.php";
require_once "../models/pastdue.model.php";
require_once "../views/modules/session.php";
$pastdue = new pastdueTable();
$pastdue -> showPastDueTable();


 
class pastdueTable{
	public function showPastDueTable(){
        $user_id = $_SESSION['user_id'];
		$check = (new ControllerPastdue)->ctrShowPastDue($user_id);
		if(count($check) == 0){
			$jsonData = '{"data":[]}';
			echo $jsonData;
			return;
		}
		$jsonData = '{
			"data":[';
				for($i=0; $i < count($check); $i++){
                    
                    $fullname = $check[$i]["last_name"].", ".$check[$i]["first_name"]." ".$check[$i]["middle_name"];
					
					
						$buttons =  "<div class='btn-group group-round m-1'><button data-toggle='tooltip' data-placement='top' title='Edit'  class='btn btn-sm btn-success waves-effect waves-light btnViewPastDue'  idClient='".$check[$i]["id"]."' >VIEW</button><button data-toggle='tooltip' data-placement='top' title='Edit'  class='btn btn-sm btn-info waves-effect waves-light btnEditClient' idClient='".$check[$i]["id"]."' account_no='".$check[$i]["account_no"]."'>EDIT</button><button data-toggle='tooltip' data-placement='top' title='Delete'  class='btn btn-sm btn-danger waves-effect waves-light btnDeleteClient' idClient='".$check[$i]["id"]."' ><i style='font-size: 15px;'  class='fa fa-trash'></i></button></div>";
					$jsonData .='[	
                        "'.$check[$i]["account_no"].'",
                        "'.$fullname.'",
                        "'.$check[$i]["type"].'",
						"'.$check[$i]["class"].'",
                        "'.$check[$i]["bank"].'",
                        "'.$check[$i]["refdate"].'",
                        "'.$check[$i]["branch_name"].'",
						"'.$buttons.'"
					],';
				}
				$jsonData = substr($jsonData, 0, -1);
				$jsonData .= '] 
			}';
		echo $jsonData;
	}
	
	
}

