<?php
require_once "../controllers/checkwriter.controller.php";
require_once "../models/checkwriter.model.php";
require_once "../views/modules/session.php";

$activateClients = new chckRecords();
$activateClients -> showTransactionList();

class chckRecords{
	public function showTransactionList(){

		if (isset($_GET['bnk_chck_from'])) {
			$bnk_chck_from = date('Y-m-d', strtotime($_GET['bnk_chck_from']));
		}
		if (isset($_GET['bnk_chck_to'])) {
            $bnk_chck_to = date('Y-m-d', strtotime($_GET['bnk_chck_to']));
        }

		if (isset($_GET['bnk_chck_bank'])) {
			if ($_GET['bnk_chck_bank'] === 'All') {
				$bnk_chck_bank = 'All';
			} else {
				$bnk_chck_bank = $_GET['bnk_chck_bank'];
			}
		} else {
			$bnk_chck_bank = 'All';
		}
		
		$BNKCHCKREPORT = (new ControllerCheckWriter)->ctrShowFilterTransaction($bnk_chck_from, $bnk_chck_to, $bnk_chck_bank);

		if(empty($BNKCHCKREPORT)){
			$jsonData = '{"data":[]}';
			echo $jsonData;
			return;
		}
		$jsonData = '{
			"data":[';
               
				for($i=0; $i < count($BNKCHCKREPORT); $i++){

                    $debit = 0;
                    $credit = 0;

                    // if ($BNKCHCKREPORT[$i]["bl_action"] === 'Print Check' || $BNKCHCKREPORT[$i]["b_branch_name"] != '') {
                    //     $credit = $BNKCHCKREPORT[$i]["bl_amount"];
                    // } else {
                    //     $debit = $BNKCHCKREPORT[$i]["bl_amount"];
                    // }

					// if ($BNKCHCKREPORT[$i]["b_payto"] != '') {
					// 	$payto = $BNKCHCKREPORT[$i]["b_payto"];
					// } else {
					// 	$payto = '';
					// }

					if ($BNKCHCKREPORT[$i]["bl_action"] === 'Print Check') {
						$debit = $BNKCHCKREPORT[$i]["bl_prev_bal"];
						$credit = $BNKCHCKREPORT[$i]["bl_amount"];
					}else if ( $BNKCHCKREPORT[$i]["bl_action"] == 'Add Bank Balance'){
						$debit = $BNKCHCKREPORT[$i]["bl_amount"];
					}
		
					$FormatedPrevDateNJ = strtoupper(date('F j, Y', strtotime($BNKCHCKREPORT[$i]["bl_date"])));

					if ($BNKCHCKREPORT[$i]["bl_action"] === 'Add Bank Balance') {
						$payto = "Bank balance as of &nbsp;" . $FormatedPrevDateNJ;
					} else{
						$payto = $BNKCHCKREPORT[$i]["b_payto"];
					}
					
					$jsonData .='[
						"'.date('m d Y' ,strtotime($BNKCHCKREPORT[$i]["bl_date"])).'",
						"'.$BNKCHCKREPORT[$i]["bb_bnk_name"].' ('.$BNKCHCKREPORT[$i]["bl_bnkcd"].')",
						"'.$BNKCHCKREPORT[$i]["bl_docno"].'",
                        "'.$payto.'",
						"'.number_format(floatVal($BNKCHCKREPORT[$i]["bl_prev_bal"]), 2, '.', ',').'",
						"'.number_format(floatVal($debit), 2, '.', ',').'",
						"'.number_format(floatVal($credit), 2, '.', ',').'",
						"'.number_format(floatval($BNKCHCKREPORT[$i]["bl_cur_bal"]), 2, '.', ',').'"
					],';
				}
				$jsonData = substr($jsonData, 0, -1);
				$jsonData .= '] 
			}';
		echo $jsonData;
	}
	
}

