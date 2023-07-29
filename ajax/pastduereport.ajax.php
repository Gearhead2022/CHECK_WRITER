<?php
require_once "../controllers/pastdue.controller.php";
require_once "../models/pastdue.model.php";
require_once "../views/modules/session.php";

$filterBackup= new reportTable();
// if(isset($_GET['filterYear'])){
// $filterBackup -> showFilterMonth();
// }elseif(isset($_GET['backup_id'])){
//     $filterBackup -> showFilter();
// }
$type = $_GET['type'];
if($type == "summaryReport"){
    $filterBackup -> showSummaryReport();
}else{
    $filterBackup -> showFilter();
}




class reportTable{
	public function showFilter(){
 
        $dateFrom = $_GET['dateFrom'];
        $dateTo = $_GET['dateTo'];
        $branch_name = $_GET['branch_name'];
        $class = $_GET['class'];
        
        

        $table = "past_due";
        $data = (new ControllerPastdue)->ctrShowFilterPastDueReport($table, $dateFrom, $dateTo, $branch_name, $class);

        $data2 = (new ControllerPastdue)->ctrShowFilterAllClass($table, $branch_name, $class);

        $i = 1;
        $grand_totalOrig = 0;
        $grand_totalPrev = 0;
        $grand_totalDebit = 0;
        $grand_totalCredit= 0;
        $grand_totalOut = 0;
        foreach ($data2 as &$item) {
           
            $account_no = $item['account_no'];
            $fullname = $item["last_name"].", ".$item["first_name"]." ".$item["middle_name"];
            $type = $item['type'];
            $bank = $item['bank'];
            $refdate = $item['refdate'];
            $balance = $item['balance'];
            $branch_name1 = $item['branch_name'];
            $preBal = (new ControllerPastdue)->ctrShowGetPrevBalance($branch_name1, $account_no, $dateFrom, $dateTo);
            $debitAndCredit = (new ControllerPastdue)->ctrShowGetDebitAndCredit($branch_name1, $account_no, $dateFrom, $dateTo);
            $total_debit = $preBal[0]['total_debit'];
            $total_credit = $preBal[0]['total_credit'];
            if($balance != 0){
                $total_preBal = ($balance - $total_credit) - $total_debit;
                $org_total_prebal= $total_preBal;
            }else{

                $total_preBal = $total_debit + $total_credit;
                $org_total_prebal= $total_preBal;
                if($total_preBal<0){
                    $total_preBal = abs($total_preBal);
                }else{
                    $total_preBal = -1 * $total_preBal;
                }
            }


            $debitAndCredit = (new ControllerPastdue)->ctrShowGetDebitAndCredit($branch_name1, $account_no, $dateFrom, $dateTo);
            $get_debit = $debitAndCredit[0]['get_debit'];
            $get_credit = $debitAndCredit[0]['get_credit'];

            $total_outbal = $org_total_prebal + $get_debit +$get_credit;

            if($total_outbal<0){
                $total_outbal = abs($total_outbal);
            }else{
                $total_outbal = -1 * $total_outbal;
            }
        
            $formatted_preBal = number_format(round($total_preBal, 2), 2, '.', ',');
            $formatted_outbal  = number_format(round($total_outbal, 2), 2, '.', ',');
            $formatted_Bal = number_format(round($balance, 2), 2, '.', ',');

            if($get_credit != 0){
                $formatted_credit = number_format(round($get_credit, 2), 2, '.', ',');
            }else{
                $formatted_credit = "";
            }

            
            if($get_debit != 0){
                $formatted_debit = number_format(round($get_debit, 2), 2, '.', ',');
            }else{
                $formatted_debit = "";
            }
        


            $item['card'] ='
                <tr>
                    <td>'.$i.'</td>
                    <td>'.$fullname.'</td>
                    <td>'.$type.'</td>
                    <td>'.$account_no.'</td>
                    <td>'.$bank.'</td>
                    <td>'.$refdate.'</td>
                    <td>'.$formatted_Bal.'</td>
                    <td>'.$formatted_preBal.'</td>
                    <td>'.$formatted_debit.'</td>
                    <td>'.$formatted_credit.'</td>
                    <td>'.$formatted_outbal.'</td>
                </tr>
            ';

            $i++;

            $grand_totalOrig = $grand_totalOrig  + $balance;
            $grand_totalPrev = $grand_totalPrev  + $org_total_prebal;
            $grand_totalDebit = $grand_totalDebit + $get_debit;
            $grand_totalCredit = $grand_totalCredit + $get_credit;
            $grand_totalOut = $grand_totalOut + $total_outbal;
            

           
        }

        $formatted_grand_totalOrig = number_format(round($grand_totalOrig, 2), 2, '.', ',');
        $formatted_grand_totalDebit = number_format(round($grand_totalDebit, 2), 2, '.', ',');
        $formatted_grand_totalPrev = number_format(abs(round($grand_totalPrev, 2)), 2, '.', ',');
        $formatted_grand_totalCredit = number_format(round($grand_totalCredit, 2), 2, '.', ',');
        $formatted_grand_totalOut = number_format(round($grand_totalOut, 2), 2, '.', ',');


        $item['card'] .='
        <tr>
            <td>TOTALS</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>'.$formatted_grand_totalOrig.'</td>
            <td>'.$formatted_grand_totalPrev.'</td>
            <td>'.$formatted_grand_totalDebit.'</td>
            <td>'.$formatted_grand_totalCredit.'</td>
            <td>'.$formatted_grand_totalOut.'</td>
        </tr>
    ';

        echo json_encode($data2);
    }

    public function showSummaryReport(){
            $slcMonth = $_GET['slcMonth'];
            $month = date("Y-m-d", strtotime($slcMonth . "-01"));
            $endDate = date("j", strtotime("last day of " . $month));
            $range = date("F", strtotime($month)) . " 1-" . $endDate . " " .date("Y", strtotime($month)) ;

            $lastMonth = date('F d, Y', strtotime($month . ' -1 day'));
            $endMonth = date("F d, Y", strtotime("last day of " . $month));
        
            $data = (new ControllerPastdue)->ctrShowEMBBranches();
            $html = '';
        
            $html .= '<thead>
                <tr>
                    <th style="border: none;"></th>
                    <th style="border: none;"></th>
                    <th style="border: none;"></th>
                    <th style="text-align: Center;" colspan="8">'.$range.'</th>
                </tr>
                <tr>
                <th style="text-align: center; vertical-align: middle; font-size: 20px; margin-bottom: 20px;" rowspan="2">BRANCH</th>
                    <th style="text-align: Center;" colspan= "2">TOTAL BAD ACCTS. <br> As of '.$lastMonth.'</th>
                    <th style="text-align: Center;" colspan= "2">PDR ENDORSE <br>(GOOD TO BAD ACCT.)</th>
                    <th style="text-align: Center;" colspan= "2">PDR <br> (MISCELLANEOUS)</th>
                    <th style="text-align: Center;" colspan= "2">PDR COLLECTION / <br> FULLY PAID</th>
                    <th style="text-align: Center;" colspan= "2">PDR <br> WRITTEN OFF</th>
                    <th style="text-align: Center;" colspan= "2">TOTAL BAD ACCTS. <br> As of '.$endMonth.' </th>
            </tr>
            <tr>
                <th></th>
                <th style="text-align: Center;">TOTAL PDR</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th>SSP #</th>
                <th>TOTAL</th>
           </tr>
            
            </thead>
            <tbody>';
        
            foreach ($data as $item) {
                $branch_name = $item['full_name'];
                $badAccountslastMonth = (new ControllerPastdue)->ctrGetAllBadAccounts($branch_name, $lastMonth);
                foreach ($badAccountslastMonth as $item2) {
                    $count = $item2['total_Bad'];
                    $result = $item2['result'];
                }

                $result1 = round($result, 2); // Round to 2 decimal places

                    if ($result1 <0) {
                        $final_total2 = abs($result1);
                    }else{
                        $final_total2 = -1 * $result1;

                    }

                    $formatted_amount = number_format($final_total2, 2, '.',',');

                $html .= '<tr>
                            <td>'.$branch_name.'</td>
                            <td style="text-align: right;">'.$count.'</td>
                            <td style="text-align: right;">'.$formatted_amount.'</td>
                        </tr>';
            }
        
            $html .= '</tbody>';
        
            echo json_encode(['card' => $html]);
        }
        
    }
   
