<?php
require_once "../controllers/account.controller.php";
require_once "../models/account.model.php";
require_once "../views/modules/session.php";
$activatAccount = new accountTable();
$activatAccount -> showAccountTable();


 
class accountTable{
	public function showAccountTable(){
		$account = (new ControllerAccounts)->ctrShowAccount();
		if(count($account) == 0){
			$jsonData = '{"data":[]}';
			echo $jsonData;
			return;
		}
		$jsonData = '{
			"data":[';
				for($i=0; $i < count($account); $i++){
				$newtype =$account[$i]["type"];

					if($newtype=="admin"){
						$type = "Admin";
					}elseif($newtype=="pdr_admin"){
						$type = "PDR-Admin";
					}elseif($newtype=="pdr_user"){
						$type = "PDR-User";
					}elseif($newtype=="hr_admin"){
						$type = "HR-Admin";
					}elseif($newtype=="hr_user"){
						$type = "HR-User";
					}elseif($newtype=="wp_admin"){
						$type = "WP-Admin";
					}elseif($newtype=="wp_user"){
						$type = "WP-User";
					} elseif($newtype=="wp_approve"){
						$type = "WP-Approval";
					}elseif($newtype=="backup_user"){
						$type = "Backup-User";
					  }elseif($newtype=="backup_admin"){
					  $type = "Backup-Admin";
					  }  
				 
						$buttons =  "<div class='btn-group group-round m-1'><button data-toggle='tooltip' data-placement='top' title='Edit'  class='btn btn-sm btn-info waves-effect waves-light btnEditClient' idClient='".$account[$i]["id"]."'>EDIT</button><button data-toggle='tooltip' data-placement='top' title='Delete'  class='btn btn-sm btn-danger waves-effect waves-light btnDeleteClient' idClient='".$account[$i]["id"]."'><i style='font-size: 15px;'  class='fa fa-trash'></i></button></div>";		  			
					 
					$jsonData .='[	
                        "'.$account[$i]["user_id"].'",
						"'.$account[$i]["full_name"].'",
						"'.$type.'",
						"'.$account[$i]["username"].'",
						"'.$buttons.'"
					],';
				}
				$jsonData = substr($jsonData, 0, -1);
				$jsonData .= '] 
			}';
		echo $jsonData;
	}
	
	
}

