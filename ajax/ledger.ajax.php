<?php
require_once "../controllers/pastdue.controller.php";
require_once "../models/pastdue.model.php";
require_once "../views/modules/session.php";
$pastdue = new ledgerTable();
if(isset($_REQUEST['idClient'])){
	$idClient = $_REQUEST['idClient'];
	$pastdue -> showLedgerTable($idClient);
}else{
	$pastdue -> showPastDueLedgerTable();
}





 
class ledgerTable{
	public function showLedgerTable($idClient){
		$pastdue_id = (new ControllerPastdue)->ctrGetAllPastDue($idClient);
		
		$branch_name = $pastdue_id[0]['branch_name'];
		$account_no = $pastdue_id[0]['account_no'];
  
		$check = (new ControllerPastdue)->ctrShowPastDueLedger($account_no, $branch_name);
		if(count($check) == 0){
			$jsonData = '{"data":[]}';
			echo $jsonData;
			return;
		}
		$jsonData = '{
			"data":[';
				for($i=0; $i < count($check); $i++){
                    
          
					
						$buttons =  "<div class='btn-group group-round m-1'><button data-toggle='tooltip' data-placement='top' title='Edit'  class='btn btn-sm btn-info waves-effect waves-light btnEditClient' idClient='".$check[$i]["id"]."'>EDIT</button><button data-toggle='tooltip' data-placement='top' title='Delete'  class='btn btn-sm btn-danger waves-effect waves-light btnDeleteClient' idClient='".$idClient."'  id='".$check[$i]["id"]."' account_no='".$check[$i]["account_no"]."' ><i style='font-size: 15px;'  class='fa fa-trash'></i></button></div>";
					$jsonData .='[	
                        "'.$check[$i]["account_no"].'",
                        "'.$check[$i]["date"].'",
                        "'.$check[$i]["refno"].'",
                        "'.$check[$i]["debit"].'",
						"'.$check[$i]["credit"].'",
						"'.$buttons.'"
					],';
				}
				$jsonData = substr($jsonData, 0, -1);
				$jsonData .= '] 
			}';
		echo $jsonData;
	}



	public function showPastDueLedgerTable(){
		$check = (new ControllerPastdue)->ctrShowAllLedger();
		if(count($check) == 0){
			$jsonData = '{"data":[]}';
			echo $jsonData;
			return;
		}
		$jsonData = '{
			"data":[';
				for($i=0; $i < count($check); $i++){
                    
					$buttons =  "<div class='btn-group group-round m-1'><button data-toggle='tooltip' data-placement='top' title='Edit'  class='btn btn-sm btn-info waves-effect waves-light btnEditClient' idClient='".$check[$i]["id"]."'>EDIT</button><button data-toggle='tooltip' data-placement='top' title='Delete'  class='btn btn-sm btn-danger waves-effect waves-light btnDeleteClient' idClient='".$check[$i]["id"]."' ><i style='font-size: 15px;'  class='fa fa-trash'></i></button></div>";
					$jsonData .='[	
                        "'.$check[$i]["account_no"].'",
                        "'.$check[$i]["branch_name"].'",
                        "'.$check[$i]["date"].'",
						"'.$check[$i]["refno"].'",
						"'.$check[$i]["debit"].'",
						"'.$check[$i]["credit"].'",
						"'.$buttons.'"
					],';
				}
				$jsonData = substr($jsonData, 0, -1);
				$jsonData .= '] 
			}';
		echo $jsonData;
	}
	
	

	
	
}

