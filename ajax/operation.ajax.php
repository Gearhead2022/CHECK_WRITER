<?php
require_once "../controllers/operation.controller.php";
require_once "../models/operation.model.php";
require_once "../views/modules/session.php";
$operation = new operationTable();
$operation -> showOperationTable();

class operationTable{
	public function showOperationTable(){
        $branch_name = $_SESSION['branch_name'];
		$check = (new ControllerOperation)->ctrShowOperation($branch_name);
		if(count($check) == 0){
			$jsonData = '{"data":[]}';
			echo $jsonData;
			return;
		}
		$jsonData = '{
			"data":[';
				for($i=0; $i < count($check); $i++){
                    $type = $check[$i]["type"];
                    if($type === "grossin"){
                        $type = "WEEKLY GROSS IN";
                    }elseif($type === "outgoing"){
                        $type = "WEEKLY OUTGOING ACCOUNTS";
                    }
                  
				$buttons =  "<div class='btn-group group-round m-1'><button data-toggle='tooltip' data-placement='top' title='Edit'  class='btn btn-sm btn-info waves-effect waves-light btnEditClient' idClient='".$check[$i]["id"]."' type='".$check[$i]["type"]."'>EDIT</button><button data-toggle='tooltip' data-placement='top' title='Delete'  class='btn btn-sm btn-danger waves-effect waves-light btnDeleteClient' idClient='".$check[$i]["id"]."' type='".$check[$i]["type"]."' ><i style='font-size: 15px;'  class='fa fa-trash'></i></button></div>";
					$jsonData .='[	
                        "'.$check[$i]["branch_name"].'",
                        "'.$type.'",
						"'.$check[$i]["date"].'",
						"'.$buttons.'"
					],';
				}
				$jsonData = substr($jsonData, 0, -1);
				$jsonData .= '] 
			}';
		echo $jsonData;
	}
	
	
}

