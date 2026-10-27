<?php
require_once "../controllers/checkwriter.controller.php";
require_once "../models/checkwriter.model.php";
require_once "../views/modules/session.php";
$activateClients = new pdrRecords();
$type = $_REQUEST['type'];
if ($type == "reprint") {
    $activateClients->reprintCheck();
} else if ($type == "cancel") {
    $activateClients->cancelCheck();
}
class pdrRecords
{
    public function reprintCheck()
    {
        $docno = $_REQUEST['docno'];
        $chkamt = $_REQUEST['chkamt'];
        $conCheck = new ControllerCheckWriter();
        $checkPrinted = $conCheck->ctrCheckPrint($docno);
        if (!empty($checkPrinted)) {
            // Get the last printed check
            foreach ($checkPrinted as $chkPrnt) {
                $old_chkamt = $chkPrnt['chkamt'];
                $bnkcd = $chkPrnt['bnkcd'];
            }
            // Get the bank balance
            $getBankBalance = $conCheck->ctrCheckBankCheck($bnkcd);
            foreach ($getBankBalance as $chkBnkBal) {
                $bnk_bal = $chkBnkBal['bnk_bal'];
                $bnk_name = $chkBnkBal['bnk_name'];
                $mnt_bal = $chkBnkBal['mnt_bal'];
            }
            $updated_balance = $bnk_bal + $old_chkamt;
            $chkMnt = $updated_balance - $chkamt;
            if ($updated_balance < $chkamt || $mnt_bal > $chkMnt) {
                $formated_amount1 = number_format(floatVal($bnk_bal), 2, '.', ',');
                echo json_encode(array("success" => false, "message" => "The bank balance is less than the amount in the check you want to print. The total remaining bank balance is <h3><u style= 'color:red;'>₱$formated_amount1</u></h3>."));
            } else {
                $update_balance = ($bnk_bal + $old_chkamt) - $chkamt;
                $updateBank = $conCheck->ctrUpdateBank($bnkcd, $update_balance);
                if ($updateBank == "ok") {
                    $updateCheckAmount = $conCheck->ctrUpdateCheckAmount($docno, $chkamt);
                    if ($updateCheckAmount == "ok") {
                        $formated_amount = number_format(floatVal($update_balance), 2, '.', ',');
                        $data = array(
                            "bnkcd" => $bnkcd,
                            "docno" => $docno,
                            "prev_bal" => $bnk_bal,
                            "amount" => $old_chkamt,
                            "cur_bal" => $updated_balance,
                            "action" => "Add Bank Balance"
                        );
                        // $updateLogs = $conCheck->ctrBankUpdateLogs($data);
                        // if($updateLogs == "ok"){
                        //         $data =array("bnkcd"=>$bnkcd,
                        //         "docno"=> $docno,
                        //         "prev_bal" =>$updated_balance,
                        //         "amount"=>$chkamt, 
                        //         "cur_bal"=> $update_balance,
                        //         "action"=>"Re-print Check");
                        //     $updateLogs1 = $conCheck->ctrBankUpdateLogs($data);
                        // }
                        echo json_encode(array("success" => true, 'bnkcd' => $bnkcd, 'bnk_name' => $bnk_name, "balance" => $formated_amount, "message" => "Check no. $docno has been successfully reprinted. The remaining bank balance is <h3><u style= 'color:#0648bb;'>₱$formated_amount</u></h3>."));
                    }
                } else {
                    echo json_encode(array("success" => false, "message" => "Error updating the bank balance."));
                }
            }
        }
    }
    public function cancelCheck()
    {
        $id = $_REQUEST['id'];
        $conCheck = new ControllerCheckWriter();
        $getLogs = $conCheck->ctrGetLogsID($id);
        if (!empty($getLogs)) {
            // Get the logs data
            foreach ($getLogs as $chkPrnt) {
                $bnkcd = $chkPrnt['bnkcd'];
                $docno = $chkPrnt['docno'];
                $old_chkamt = $chkPrnt['amount'];
                $action = $chkPrnt['action'];
            }
            $checker = $conCheck->ctrCheckDocno($docno);
            if (empty($checker)) {
                // Get the bank balance
                $getBankBalance = $conCheck->ctrCheckBankCheck($bnkcd);
                foreach ($getBankBalance as $chkBnkBal) {
                    $bnk_bal = $chkBnkBal['bnk_bal'];
                    $bnk_name = $chkBnkBal['bnk_name'];
                }
                if ($action == "Add Bank Balance") {
                    $update_balance = $bnk_bal - $old_chkamt;
                    $action = "Deduct Bank Balance";
                } else if ($action == "Print Check") {
                    $update_balance = $bnk_bal + $old_chkamt;
                    $action = "Cancelled Check";
                } else {
                    $update_balance = $bnk_bal + $old_chkamt;
                    $action = "Cancelled Check";
                }
                $updateBank = $conCheck->ctrUpdateBank($bnkcd, $update_balance);
                if ($updateBank == "ok") {
                    $formated_amount = number_format(floatVal($update_balance), 2, '.', ',');
                    $data = array(
                        "bnkcd" => $bnkcd,
                        "docno" => $docno,
                        "prev_bal" => $bnk_bal,
                        "amount" => $old_chkamt,
                        "cur_bal" => $update_balance,
                        "status" => "CANCELLED",
                        "action" => $action
                    );
                    $updateLogs1 = $conCheck->ctrCancelBankUpdateLogs($data);

                    echo json_encode(array("success" => true, 'bnkcd' => $bnkcd, 'bnk_name' => $bnk_name, "balance" => $formated_amount, "message" => "Check no. $docno has been successfully cancelled. The remaining bank balance is <h3><u style= 'color:#0648bb;'>₱$formated_amount</u></h3>."));

                } else {
                    echo json_encode(array("success" => false, "message" => "Error updating the bank balance."));
                }

            } else {
                echo json_encode(array("success" => false, "message" => "Check number $docno has already been cancelled."));
            }
        }
    }
}

