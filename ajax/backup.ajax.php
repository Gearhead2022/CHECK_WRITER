<?php
require_once "../controllers/backup.controller.php";
require_once "../models/backup.model.php";
require_once "../views/modules/session.php";
$backupList= new backupTable();
$backupList -> showBackupTable();

class backupTable{
	
	public function showBackupTable(){
		$user_id = $_SESSION['user_id'];
		$backup = (new ControllerBackup)->ctrShowBackup($user_id);
		if(count($backup) == 0){
			$jsonData = '{"data":[]}';
			echo $jsonData;
			return;
		}
		$jsonData = '{
			"data":[';
				for($i=0; $i < count($backup); $i++){
					$datetime_str = $backup[$i]["date_time"];
					$datetime_timestamp = strtotime($datetime_str);
					$datetime_words = date('F j, Y \a\t g:i A', $datetime_timestamp);
					$type = $_SESSION['type'];

					$datedone_str = $backup[$i]["date_done"];
					$ddatedone_timestamp = strtotime($datedone_str);
					$datedone_words = date('F j, Y \a\t g:i A', $ddatedone_timestamp);
					if($datedone_str == ""){
						$datedone_words = $datedone_str;
					}
					

						$chk_status = $backup[$i]["status"];
						if($chk_status == "Received" || $chk_status == "R-Received"  ){
							$status  ="<p class='badge badge-success' style='font-size: 15px;'>".$backup[$i]["status"]."</p>";
						}else{	
							$status  ="<p class='badge badge-danger' style='font-size: 15px;'>".$backup[$i]["status"]."</p>";
						}

						if($type == "admin" || $type == "backup_admin"){
							$buttons =  "<div class='btn-group group-round m-1'><button class='btn btn-sm btn-success waves-effect waves-light btnShowRequest' data-toggle='tooltip' data-placement='top' title='View' idClient='".$backup[$i]["id"]."'>VIEW</button><button data-toggle='tooltip' data-placement='top' title='Edit'  class='btn btn-sm btn-info waves-effect waves-light btnEditClient' idClient='".$backup[$i]["id"]."'>EDIT</button><button data-toggle='tooltip' data-placement='top' title='Delete'  class='btn btn-sm btn-danger waves-effect waves-light btnDeleteClient' idClient='".$backup[$i]["id"]."' backup_id='".$backup[$i]["backup_id"]."'  ><i style='font-size: 15px;'  class='fa fa-trash'></i></button></div>";
						}else{
							$buttons =  "<div class='btn-group group-round m-1'><button class='btn btn-sm btn-success waves-effect waves-light btnShowRequest' data-toggle='tooltip' data-placement='top' title='View' idClient='".$backup[$i]["id"]."'>VIEW</button><button data-toggle='tooltip' data-placement='top' title='Edit'  class='btn btn-sm btn-info waves-effect waves-light btnEditClient' idClient='".$backup[$i]["id"]."'>EDIT</button></div>";		  			
						}

					$jsonData .='[
                       
						"'.ucwords($backup[$i]["branch_name"]).'",
						"'.$backup[$i]["subject"].'",
						"'.$datetime_words.'",
						"'.$datedone_words.'",
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

