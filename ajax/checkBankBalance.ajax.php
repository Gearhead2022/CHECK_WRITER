<?php
require_once "../controllers/checkwriter.controller.php";
require_once "../models/checkwriter.model.php";
require_once "../views/modules/session.php";

$action = $_GET['action'];

$editInurance= new SOAAJAXModal();

if($action == "validate_balance"){
    $editInurance->CheckBankBalanceModal();   
}elseif($action == "update_balance"){
    $editInurance->updateBankBalanceModal();   
}

class SOAAJAXModal {
    public function CheckBankBalanceModal() {
        $bnkname = $_GET['bank_type']; // Correct parameter name
        $docno = $_GET['doc_no'];
        $coldate = $_GET['col_date'];
        $dataList = (new ControllerCheckWriter)->ctrShowBNKCHKDetails($docno, $coldate);

        foreach ($dataList as &$record) {
            $bnkcd = $record['BANKCD'];
            $chkamt = $record['CHKAMT'];

            $data = array(
                "bnkcd" => $record['BANKCD'],
                "docno" => $record['DOCNO'],
                "vchrno" => $record['VCHRNO'],
                "cdate" => $record['CDATE'],
                "payto" => str_replace('¥', 'Ñ', iconv('ISO-8859-1', 'UTF-8', $record["PAYTO"])),
                "chkamt" => $record['CHKAMT'],
                "chkstat" => $record['CHKSTAT'],
                "doctype" => $record['DOCTYPE'],
                "remarks" => $record['REMARKS'],
                "prtflag" => $record['PRTFLAG']
            );
        }

        $check = (new ModelCheckWriter)->mdlCheckBankExist($bnkcd);
        $bnk_name = $check[1];
        $rem_bal = (new ControllerCheckWriter)->ctrGetBankBalance($bnkcd);
        if (!empty($rem_bal)) {
            $pres_bal = floatval($rem_bal[0]['bnk_bal']);
            $pres_bal_left = floatval($rem_bal[0]['bnk_bal']) - floatval($chkamt);
            $mnt_bal = $rem_bal[0]['mnt_bal'];
        }else{
            $pres_bal = 0;
            $pres_bal_left = 0.00;
            $mnt_bal = 0;
        }
        // $sample = floatval($rem_bal);

        $remark = $pres_bal_left > $mnt_bal && $pres_bal_left != 0.00 ? 'allowed' : 'disallowed';

        if ($remark == 'allowed') {
            (new ModelCheckWriter)->mdlUpdateCHCKWRTRRecords($data);
            (new ControllerCheckWriter)->ctrDeductToBankAmountBalance($bnkcd, $chkamt);
            (new ControllerCheckWriter)->ctrBnkChckLogs($bnkcd, $docno, $chkamt, $pres_bal, $pres_bal_left, 'Print Check');
        } 
        if($remark == "allowed"){
            $pres_bal_left1 = number_format(floatval($pres_bal_left), 2, '.', ',');
            $message = "Check no. $docno has been successfully printed. The remaining bank balance is <h3><u style= 'color:#0648bb;'>₱$pres_bal_left1</u></h3>.";
            $balance = $pres_bal_left1;
        }else{
            $pres_bal1 = number_format(floatval($pres_bal), 2, '.', ',');
            $message = "The bank balance is less than the amount in the check you want to print. The total remaining bank balance is :<h3><u style= 'color:#0648bb;'>₱$pres_bal1</u></h3>.";
            $balance = $pres_bal1;
        }
        // Return the response as JSON
        echo json_encode(array(
            'remark' => $remark,
            'pres_bal' => $pres_bal,
            'bnkcd' => $bnkcd,
            'bnk_name' => $bnk_name,
            'doc_no' => $docno,
            'col_date' => $coldate,
            'message' => $message,
            'balance'=>$balance,
            'mnt_bal'=>$mnt_bal
        ));
    }

    public function updateBankBalanceModal() {
        $banks = (new ControllerCheckWriter)->ctrShowAllBank();
        $all_data = array();
    
        if (!empty($banks)) {
            foreach ($banks as $key => $bank) {
            $bnkcd = $bank['bnkcd'];
                $bnk_name = $bank['bnk_name'];
                $balances = (new ControllerCheckWriter)->ctrGetBankBalance($bnkcd);
    
                if (!empty($balances)) {
                    $bal = number_format(floatval($balances[0]['bnk_bal']), 2, '.', ',');
                } else {
                    $bal = '0.00';
                }
    
                $all_data["bank$key"] = array("bank_name" => $bnk_name, "bank_balance" => $bal, "bnkcd" => $bnkcd);
            }
        } else {
            $all_data["bank0"] = array("bank_name" => 'N/A', "bank_balance" => '0.00', "bnkcd" =>"");
        }
    
        echo json_encode($all_data);
    }
      
}
?>
