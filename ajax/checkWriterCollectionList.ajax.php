<?php
require_once "../controllers/checkwriter.controller.php";
require_once "../models/checkwriter.model.php";
require_once "../views/modules/session.php";

	$activateClients = new pdrRecords();
	$activateClients -> showPDRDataList();

class pdrRecords{
	public function showPDRDataList(){

		if (isset($_GET['collDate'])) {
			$collDate = date('Y-m-d', strtotime($_GET['collDate']));
		} else {
			$collDate = '';
		}

		if (isset($_GET['branch_name'])) {
          
            $branch_name = $_GET['branch_name'];

        } else {
            $branch_name = '';

        }


		// echo $collDate;
		// echo $branch_name;

		$BNKCHCK = (new ControllerCheckWriter)->ctrShowAllBNKCHCKList($collDate, $branch_name);

		// print_r($BNKCHCK);
		if(empty($BNKCHCK)){
			$jsonData = '{"data":[]}';
			echo $jsonData;
			return;
		}
		$jsonData = '{
			"data":[';
				for($i=0; $i < count($BNKCHCK); $i++){

					$docno = trim($BNKCHCK[$i]["DOCNO"]);
					$payto = str_replace('¥', 'Ñ', iconv('ISO-8859-1', 'UTF-8', $BNKCHCK[$i]["PAYTO"]));

					$bnkchker = (new ModelCheckWriter)->mdlBNKCHCKListChecker($docno, $payto);

					if ($bnkchker === 'not_exist') {
						$buttons =  "<div class='btn-group group-round m-1'><button type='button' data-toggle='tooltip' data-placement='top' title='Edit' class='btn btn-sm border border-info border-3 btn-transparent w-5 text-info waves-effect waves-light btnSelectBank' cdate='".$BNKCHCK[$i]['CDATE']."' docno='".$BNKCHCK[$i]['DOCNO']."' chkamt='".$BNKCHCK[$i]['CHKAMT']."' action='btnPrintBNKCHK'>PRINT</button></div>";
					} else {
						$buttons =  "<div class='btn-group group-round m-1'><button type='button' data-toggle='tooltip' data-placement='top' title='Edit' class='btn btn-sm border border-warning border-3 btn-transparent w-5 text-warning waves-effect waves-light btnSelectBank' cdate='".$BNKCHCK[$i]['CDATE']."' docno='".$BNKCHCK[$i]['DOCNO']."' chkamt='".$BNKCHCK[$i]['CHKAMT']."' action='btnRePrintBNKCHK'>RE-PRINT</button></div>";
					}
					
					$jsonData .='[
						"'.$buttons.'",
						"'.$BNKCHCK[$i]["BANKCD"].'",
                        "'.$BNKCHCK[$i]["DOCNO"].'",
						"'.$BNKCHCK[$i]["VCHRNO"].'",
						"'.$BNKCHCK[$i]["CDATE"].'",
						"'.str_replace('¥', 'Ñ', iconv('ISO-8859-1', 'UTF-8', $BNKCHCK[$i]["PAYTO"])).'",
						"'.number_format(floatval($BNKCHCK[$i]["CHKAMT"]), 2, '.', '').'",
						"'.$BNKCHCK[$i]["CHKSTAT"].'",
						"'.$BNKCHCK[$i]["DOCTYPE"].'",
						"'.$BNKCHCK[$i]["REMARKS"].'"
					],';
				}
				$jsonData = substr($jsonData, 0, -1);
				$jsonData .= '] 
			}';
		echo $jsonData;
	}
	
}

