<?php
require_once "../controllers/request.controller.php";
require_once "../models/request.model.php";
require_once "../views/modules/session.php";
$type = $_SESSION['type'];
if($type=="wp_user"){
	$activateRequest = new requestTable();
	$activateRequest -> showRequestTable();
}elseif($type=="admin" || $type=="wp_admin"){
	$activateRequest = new requestTable();
	$activateRequest -> showAdminRequestTable();
}
// elseif($type=="user"){
// 	$activateRlc = new rlcTable();
// 	$activateRlc -> showUserRlcTable();
// }elseif($type=="HR"){
// 	$activateRlc = new rlcTable();
// 	$activateRlc -> showHrTable();
// }


class requestTable{
	public function showRequestTable(){
		$user_id = $_SESSION['user_id'];
		$request = (new ControllerRequest)->ctrShowRequest($user_id);
		if(count($request) == 0){
			$jsonData = '{"data":[]}';
			echo $jsonData;
			return;
		}
		$jsonData = '{
			"data":[';
				for($i=0; $i < count($request); $i++){
					if($request[$i]["status"] == "Pending"){
						$status  ="<p class='badge badge-danger' style='font-size: 15px;'>".$request[$i]["status"]."</p>";
						$buttons =  "<div  class='btn-group group-round m-1'><button class='btn btn-sm btn-success waves-effect waves-light btnShowRequest' data-toggle='tooltip' data-placement='top' title='View' idClient='".$request[$i]["id"]."'>VIEW</button><button data-toggle='tooltip' data-placement='top' title='Edit'  class='btn btn-sm btn-info waves-effect waves-light btnEditClient' idClient='".$request[$i]["id"]."' >EDIT</button></div>";
					}else{
						$status  ="<p class='badge badge-success' style='font-size: 15px;'>".$request[$i]["status"]."</p>";
						$buttons =  "<div  class='btn-group group-round m-1'><button class='btn btn-sm btn-success waves-effect waves-light btnShowRequest' data-toggle='tooltip' data-placement='top' title='View' idClient='".$request[$i]["id"]."'>VIEW</div>";
					}
					$req_by1  = $request[$i]["req_by"];
					$a_req_by1 = explode("<br />", $req_by1);
					$req_by = $a_req_by1[0];
						$jsonData .='[
						"'.$request[$i]["ref_id"].'",
						"'.$req_by.'",
				    	"'.$request[$i]["to"].'",
						"'.$request[$i]["date"].'",
                        "'.$request[$i]["date_done"].'",
						"'.$status.'",
						"'.$buttons.'"
					],';
				}
				$jsonData = substr($jsonData, 0, -1);
				$jsonData .= '] 
			}';
		echo $jsonData;
	}
	public function showAdminRequestTable(){
		$request = (new ControllerRequest)->ctrShowRequestAll();
		if(count($request) == 0){
			$jsonData = '{"data":[]}';
			echo $jsonData;
			return;
		}
		$jsonData = '{
			"data":[';
				for($i=0; $i < count($request); $i++){

					if($request[$i]["status"] == "Pending"){
						$status  ="<p class='badge badge-danger' style='font-size: 15px;'>".$request[$i]["status"]."</p>";
					}else{
						$status  ="<p class='badge badge-success' style='font-size: 15px;'>".$request[$i]["status"]."</p>";
					}
				
						$buttons =  "<div  class='btn-group group-round m-1'><button class='btn btn-sm btn-success waves-effect waves-light btnShowRequest' data-toggle='tooltip' data-placement='top' title='View' idClient='".$request[$i]["id"]."'>VIEW</div>";
						$req_by1  = $request[$i]["req_by"];
						$a_req_by1 = explode("<br />", $req_by1);
						$req_by = $a_req_by1[0];
							$jsonData .='[
							"'.$request[$i]["ref_id"].'",
							"'.$req_by.'",
							"'.$request[$i]["to"].'",
							"'.$request[$i]["date"].'",
							"'.$request[$i]["date_done"].'",
							"'.$status.'",
							"'.$buttons.'"
						],';
				}
				$jsonData = substr($jsonData, 0, -1);
				$jsonData .= '] 
			}';
		echo $jsonData;
	}
	 
}

