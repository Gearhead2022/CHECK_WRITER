<?php
require_once "../controllers/permit.controller.php";
require_once "../models/permit.model.php";
require_once "../views/modules/session.php";
$type = $_SESSION['type'];

if($type=="wp_user"){
	$activateRlc = new permitTable();
	$activateRlc -> showPermitTable();
}elseif($type=="admin" || $type=="wp_admin" || $type=="wp_approve" || $type=="wp_check"){
	$activateRlc = new permitTable();
	$activateRlc -> showAdminPermitTable();
}
// elseif($type=="user"){
// 	$activateRlc = new rlcTable();
// 	$activateRlc -> showUserRlcTable();
// }elseif($type=="HR"){
// 	$activateRlc = new rlcTable();
// 	$activateRlc -> showHrTable();
// }


class permitTable{
	public function showPermitTable(){
		$user_id = $_SESSION['user_id'];
		$permit = (new ControllerPermits)->ctrShowPermit($user_id);
		if(count($permit) == 0){
			$jsonData = '{"data":[]}';
			echo $jsonData;
			return;
		}
		$jsonData = '{
			"data":[';
				for($i=0; $i < count($permit); $i++){
					
					$chk_status = $permit[$i]["status"];
					$app = $permit[$i]["app"];
					$app1 = $permit[$i]["app1"];
					$chkby = $permit[$i]["chk"];
					if($app>0){
						$cgn  ="<p class='badge badge-success' style='font-size: 15px;'>Approved</p>";
					}else{
						$cgn  ="<p class='badge badge-danger' style='font-size: 15px;'>Pending</p>";
					}
					if($app1>0){
						$egg  ="<p class='badge badge-success' style='font-size: 15px;'>Approved</p>";
					}else{
						$egg  ="<p class='badge badge-danger' style='font-size: 15px;'>Pending</p>";
					}

					if($chkby!="Pending"){
						$chk  ="<p class='badge badge-success' style='font-size: 15px;'>Checked</p>";
					}else{
						$chk  ="<p class='badge badge-danger' style='font-size: 15px;'>Pending</p>";
					}


					if($permit[$i]["status"] == "Pending" || $permit[$i]["status"] == "P-Approved"){
						$status  ="<p class='badge badge-danger' style='font-size: 15px;'>".$permit[$i]["status"]."</p>";
						$buttons =  "<div  class='btn-group group-round m-1'><button class='btn btn-sm btn-success waves-effect waves-light btnEditShowClient' data-toggle='tooltip' data-placement='top' title='View' idClient='".$permit[$i]["id"]."'>VIEW</button><button data-toggle='tooltip' data-placement='top' title='Edit'  class='btn btn-sm btn-info waves-effect waves-light btnEditClient' idClient='".$permit[$i]["id"]."' >EDIT</button></div>";
					}else{
						$status  ="<p class='badge badge-success' style='font-size: 15px;'>".$permit[$i]["status"]."</p>";
						$buttons =  "<div  class='btn-group group-round m-1'><button class='btn btn-sm btn-success waves-effect waves-light btnShowRequest' data-toggle='tooltip' data-placement='top' title='View' idClient='".$permit[$i]["id"]."'>VIEW</div>";
					}
					$wp_req_by1  = $permit[$i]["wp_req_by"];
					$a_req_by1 = explode("<br />", $wp_req_by1);
					$wp_req_by = $a_req_by1[0];
					
						$jsonData .='[
							"'.$permit[$i]["ref_id"].'",
							"'.$wp_req_by.'",
							"'.$status.'",
							"'.$chk.'",
							"'.$cgn.'",
							"'.$egg.'",
							"'.$permit[$i]["wp_date"].'",
							"'.$permit[$i]["date_done"].'",
							"'.$buttons.'"
					],';
				}
				$jsonData = substr($jsonData, 0, -1);
				$jsonData .= '] 
			}';
		echo $jsonData;
	}
	public function showAdminPermitTable(){
		$permit = (new ControllerPermits)->ctrShowPermitAdmin();
		if(count($permit) == 0){
			$jsonData = '{"data":[]}';
			echo $jsonData;
			return;
		}
		$jsonData = '{
			"data":[';
				for($i=0; $i < count($permit); $i++){
					$chk_status = $permit[$i]["status"];
					$app = $permit[$i]["app"];
					$app1 = $permit[$i]["app1"];
					$chkby = $permit[$i]["chk"];
					if($app>0){
						$cgn  ="<p class='badge badge-success' style='font-size: 15px;'>Approved</p>";
					}else{
						$cgn  ="<p class='badge badge-danger' style='font-size: 15px;'>Pending</p>";
					}
					if($app1>0){
						$egg  ="<p class='badge badge-success' style='font-size: 15px;'>Approved</p>";
					}else{
						$egg  ="<p class='badge badge-danger' style='font-size: 15px;'>Pending</p>";
					}
					if($chkby!="Pending"){
						$chk  ="<p class='badge badge-success' style='font-size: 15px;'>Checked</p>";
					}else{
						$chk  ="<p class='badge badge-danger' style='font-size: 15px;'>Pending</p>";
					}

					if($permit[$i]["status"] == "Pending" || $permit[$i]["status"] == "P-Approved"){
						$status  ="<p class='badge badge-danger' style='font-size: 15px;'>".$permit[$i]["status"]."</p>";
					}else{
						$status  ="<p class='badge badge-success' style='font-size: 15px;'>".$permit[$i]["status"]."</p>";
					}
				
						$buttons =  "<div  class='btn-group group-round m-1'><button class='btn btn-sm btn-success waves-effect waves-light btnShowRequest' data-toggle='tooltip' data-placement='top' title='View' idClient='".$permit[$i]["id"]."'>VIEW</div>";
						$wp_req_by1  = $permit[$i]["wp_req_by"];
						$a_req_by1 = explode("<br />", $wp_req_by1);
						$wp_req_by = $a_req_by1[0];
						
							$jsonData .='[
							"'.$permit[$i]["ref_id"].'",
							"'.$wp_req_by.'",
							"'.$status.'",
							"'.$chk.'",
							"'.$cgn.'",
							"'.$egg.'",
							"'.$permit[$i]["wp_date"].'",
							"'.$permit[$i]["date_done"].'",
							"'.$buttons.'"
						],';
				}
				$jsonData = substr($jsonData, 0, -1);
				$jsonData .= '] 
			}';
		echo $jsonData;
	}
	
}

