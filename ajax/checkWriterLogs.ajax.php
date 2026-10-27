<?php
require_once "../controllers/checkwriter.controller.php";
require_once "../models/checkwriter.model.php";
require_once "../views/modules/session.php";

	$activateClients = new BNKCHCKRecords();
	$activateClients -> showBNKCHCKDataList();

class BNKCHCKRecords{
	public function showBNKCHCKDataList(){

		$BNKCHCKLOGS = (new ControllerCheckWriter)->ctrShowAllBNKCHCKLOGS();

		// print_r($BNKCHCK);
		if(empty($BNKCHCKLOGS)){
			$jsonData = '{"data":[]}';
			echo $jsonData;
			return;
		}
		$jsonData = '{
			"data":[';
				for($i=0; $i < count($BNKCHCKLOGS); $i++){
					$id = $BNKCHCKLOGS[$i]["id"];
					$status = $BNKCHCKLOGS[$i]["status"];

					$button = "<button type='button' class='btn btn-sm btn-danger waves-effect waves-light btnCancel' title='Cancel' id='btnCancel' idCancel='$id'><i class='fa fa-close'><p style='display:none;'>$id</p></i></button>";
					if($status=="SUCCESS"){
						$status ="<span class='badge badge-success'>$status</span>";
					}else{
						$status ="<span class='badge badge-danger'>$status</span>";
					}
					
					// $buttons =  "";
					$jsonData .='[
						"'.$button.'",
						"'.$BNKCHCKLOGS[$i]["bnkcd"].'",
						"'.$BNKCHCKLOGS[$i]["docno"].'",
                        "'.number_format(floatVal($BNKCHCKLOGS[$i]["prev_bal"]), 2, '.', ',').'",
                        "'.number_format(floatVal($BNKCHCKLOGS[$i]["amount"]), 2, '.', ',').'",	
                        "'.number_format(floatVal($BNKCHCKLOGS[$i]["cur_bal"]), 2, '.', ',').'",
                        "'.$BNKCHCKLOGS[$i]["action"].'",				
                        "'.$status.'",				
						"'.$BNKCHCKLOGS[$i]["date"].'"
					],';
				}
				$jsonData = substr($jsonData, 0, -1);
				$jsonData .= '] 
			}';
		echo $jsonData;
	}
	
}

