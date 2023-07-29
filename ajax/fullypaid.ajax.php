<?php
require_once "../controllers/fullypaid.controller.php";
require_once "../models/fullypaid.model.php";
require_once "../views/modules/session.php";
$fullypaidList= new fullypaidTable();
$fullypaidList -> showFullyPaidTable();


class fullypaidTable{
	
	public function showFullyPaidTable(){
		$user_id = $_SESSION['user_id'];
		$fullypaid = (new ControllerFullypaid)->ctrShowFullyPaid($user_id);
		if(count($fullypaid) == 0){
			$jsonData = '{"data":[]}';
			echo $jsonData;
			return;
		}
		$jsonData = '{
			"data":[';
				for($i=0; $i < count($fullypaid); $i++){
                    $type = $_SESSION['type'];
                    $date = $fullypaid[$i]["out_date"];
                    $dateObject = DateTime::createFromFormat('Ymd', $date);
					$newdate = date('n/j/y', strtotime($date));
                    $wordDate = $dateObject->format('F d, Y');
					$date_claim1 = $fullypaid[$i]["date_claimed"];
					if(!empty($date_claim1)){
						$date_claim = date('F d, Y \a\t g:i A', strtotime($date_claim1));
					}else{
						$date_claim = $date_claim1;
					}
				
                   $atm = $fullypaid[$i]["atm_status"];
                    if($atm!="Unclaimed"){
						$atm_status  ="<p class='badge badge-success' style='font-size: 15px;'>Claimed</p>";
					}else{
						$atm_status  ="<p class='badge badge-danger' style='font-size: 15px;'>Unclaimed</p>";
					}

						if($type == "admin" || $type == "backup_admin"){
							$buttons =  "<div class='btn-group group-round m-1'><button class='btn btn-sm btn-success waves-effect waves-light btnShowRequest' data-toggle='tooltip' data-placement='top' title='View' idClient='".$fullypaid[$i]["id"]."'>VIEW</button><button data-toggle='tooltip' data-placement='top' title='Edit'  class='btn btn-sm btn-info waves-effect waves-light btnEditClient' idClient='".$fullypaid[$i]["id"]."'>EDIT</button><button data-toggle='tooltip' data-placement='top' title='Delete'  class='btn btn-sm btn-danger waves-effect waves-light btnDeleteClient' idClient='".$fullypaid[$i]["id"]."'><i style='font-size: 15px;'  class='fa fa-trash'></i></button></div>";
						}else{
							$buttons =  "<div class='btn-group group-round m-1'><button class='btn btn-sm btn-success waves-effect waves-light btnShowRequest' data-toggle='tooltip' data-placement='top' title='View' idClient='".$fullypaid[$i]["id"]."'>VIEW</button><button data-toggle='tooltip' data-placement='top' title='Edit'  class='btn btn-sm btn-info waves-effect waves-light btnEditClient' idClient='".$fullypaid[$i]["id"]."'>EDIT</button></div>";		  			
						}

					$jsonData .='[
                       
						"'.$fullypaid[$i]["fpid"].'",
						"'.$fullypaid[$i]["name"].'",
						"'.$wordDate.'",
						"'.$fullypaid[$i]["bank"].'",
                        "'.$fullypaid[$i]["status"].'",
                        "'.$fullypaid[$i]["prrno"].'",
                        "'.$fullypaid[$i]["prrdate"].'",
                        "'.$atm_status.'",
                        "'.$date_claim.'",

						"'.$buttons.'"
					],';
				}
				$jsonData = substr($jsonData, 0, -1);
				$jsonData .= '] 
			}';
		echo $jsonData;
	}
	
	
}

