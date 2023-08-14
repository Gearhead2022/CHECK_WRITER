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
if(isset($_GET['type'])){
    $type = $_GET['type'];
    if($type == "summaryReport"){
        $filterBackup -> showSummaryReport();
    }
}
else{
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
            // Get the first day of the selected month
            $month = date("Y-m-d", strtotime($slcMonth . "-01"));
            // Get the last day of the selected month
            $lastDay = date("Y-m-d", strtotime("last day of " . $month));

            $endDate = date("j", strtotime("last day of " . $month));
            $range = date("F", strtotime($month)) . " 1-" . $endDate . " " .date("Y", strtotime($month)) ;

            $lastMonth = date('F d, Y', strtotime($month . ' -1 day'));
            $endMonth = date("F d, Y", strtotime("last day of " . $month));

        
            $data = (new ControllerPastdue)->ctrShowEMBBranches();
            $dataFCHN = (new ControllerPastdue)->ctrShowFCHNBranches();
            $dataFCHM = (new ControllerPastdue)->ctrShowFCHMBranches();
            $dataRLC = (new ControllerPastdue)->ctrShowRLCBranches();
            $dataELC = (new ControllerPastdue)->ctrShowELCBranches();
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


            $emb_subTotalAcc1 = 0;
            $emb_subTotalPDR = 0;
            $emb_subGtB = 0;
            $emb_subTotalAmountGB = 0;
            $emb_subTotalMisc= 0;
            $emb_subTotalWrittenOff= 0;
            $emb_subTotalAmountWrittenOff= 0;
            $emb_subTotalFullyPaid= 0;
            $emb_subtotalCollection= 0;
            $emb_subtotalSSP= 0;
            $emb_subtotalBadAccs= 0;

            $emb_grandTotalAcc1 = 0;
            $emb_grandTotalPDR = 0;
            $emb_grandGtB = 0;
            $emb_grandTotalAmountGB = 0;
            $emb_grandTotalMisc= 0;
            $emb_grandTotalWrittenOff= 0;
            $emb_grandTotalAmountWrittenOff= 0;
            $emb_grandTotalFullyPaid= 0;
            $emb_grandtotalCollection= 0;
            $emb_grandtotalSSP= 0;
            $emb_grandtotalBadAccs= 0;
        
            foreach ($data as $item) {
                $branch_name = $item['full_name'];
                

                $goodToBad = (new ControllerPastdue)->ctrGetAllGoodToBad($branch_name, $month, $lastDay);
                $total_debit = 0;
                foreach ($goodToBad as $item3) {
                    $account_no = $item3['account_no'];
                    $balance = $item3['balance'];
                    $refdate = $item3['refdate'];

                    if($balance == 0){
                        $goodToBad1 = (new ControllerPastdue)->ctrGetAllGoodToBad1($account_no, $branch_name, $refdate);
                        foreach ($goodToBad1 as $item4) {
                            $debit = $item4['debit'];
                        }
                        $total_debit += $debit;

                    }
                    
                }

                $getMisc = (new ControllerPastdue)->ctrGetMiscellaneous($branch_name, $month, $lastDay);
                if(!empty($getMisc)){
                    foreach ($getMisc as $item5) {
                        $mis_debit = $item5['debit'];
                        $mis_debit1 = abs($item5['debit']);
                    }
                }else{
                    $mis_debit = "";
                }
                if($mis_debit == 0){
                    $mis_debit = "";
                }else{
                    $mis_debit = number_format(abs($item5['debit']) , 2, '.',',');
                }

                $total_gb = count($goodToBad);
                $total_gb1 = count($goodToBad);

                if($total_gb == 0){
                    $total_gb = "";
                }   


                if($total_debit <0){
                    $total_amount_gb = abs($total_debit);
                    $emb_subTotalAmountGB += $total_amount_gb;
                }else{
                    $total_amount_gb = $total_debit * -1;
                    $emb_subTotalAmountGB += $total_amount_gb;
                }


                if($total_amount_gb != 0){
                    $formatted_total_amount_gb = number_format($total_amount_gb, 2, '.',',');
                }else{
                    $formatted_total_amount_gb ="";
                }

               


                    // Start For PDR WRITTEN OFF
                    $getPDRWrittenOff = (new ControllerPastdue)->ctrGetPDRWrittenOff($branch_name, $month, $lastDay);
                    if(!empty($getPDRWrittenOff)){
                    foreach ($getPDRWrittenOff as $item6) {
                        $total_w = $item6['total_w'];
                        $total_w1 = $item6['total_w'];
                        $total_pdr_written1 = abs($item6['result']);
                        $total_pdr_written = abs($item6['result']);
                    }

                    
                    if($total_pdr_written == 0){
                        $total_pdr_written ="";
                        $formatted_total_pdr_written = "";
                    }else{
                        $formatted_total_pdr_written = number_format($total_pdr_written1, 2, '.',',');
                    }
                        if($total_w == 0){
                            $total_w ="";
                        }
                }else{
                    $total_w ="";
                }
                // END PDR WRITTEN OFF

                // Start PDR FullyPaid 
                $getFullyPaid = (new ControllerPastdue)->ctrGetFullyPaid($branch_name, $month, $lastDay);
                if(!empty($getFullyPaid)){
                    foreach ($getFullyPaid as $item7) {
                        $total_f = $item7['total_f'];
                        $total_f1 = $item7['total_f'];
                        $total_collection =  $item7['total_collection'];
                        $total_collection1 =  $item7['total_collection'];
                    }

                    if($total_collection == 0){
                        $total_collection ="";
                        $formatted_total_collection = "";
                    }else{
                        $formatted_total_collection = number_format($total_collection, 2, '.',',');
                    }

                    if($total_f == 0){
                        $total_f ="";
                    }
                }
                else{
                    $total_f ="";
                }

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
                    // $count = $count + $total_w1 + $total_f1 ; 
                   

                $formatted_amount = number_format($final_total2, 2, '.',',');
                $total_ssp = $count + $total_gb1 - $total_f1 - $total_w1;
                $total_BadAcc= ($final_total2 +$total_amount_gb) + $mis_debit1 - $total_collection1 - $total_pdr_written1;
                $formatted_total_BadAcc = number_format($total_BadAcc, 2, '.',',');

                $emb_subTotalAcc1 += $count;
                $emb_subTotalPDR += $final_total2;
                $emb_subGtB += $total_gb1;
                $emb_subTotalMisc += $mis_debit1;
                $emb_subTotalWrittenOff += $total_w1;
                $emb_subTotalAmountWrittenOff += $total_pdr_written1;
                $emb_subTotalFullyPaid += $total_f1;
                $emb_subtotalCollection += $total_collection1;
                $emb_subtotalSSP += $total_ssp;
                $emb_subtotalBadAccs+= $total_BadAcc;






                $html .= '<tr>
                            <td>'.$branch_name.'</td>
                            <td style="text-align: right;">'.$count.'</td>
                            <td style="text-align: right;">'.$formatted_amount.'</td>
                            <td style="text-align: right;">'.$total_gb.'</td>
                            <td style="text-align: right;">'.$formatted_total_amount_gb.'</td>
                            <td style="text-align: right;"></td>
                            <td style="text-align: right;">'.$mis_debit.'</td>
                            <td style="text-align: right;">'.$total_f.'</td>
                            <td style="text-align: right;">'.$formatted_total_collection.'</td>
                            <td style="text-align: right;">'.$total_w.'</td>
                            <td style="text-align: right;">'.$formatted_total_pdr_written.'</td>
                            <td style="text-align: right;">'.$total_ssp.'</td>
                            <td style="text-align: right;">'.$formatted_total_BadAcc.'</td>
                        </tr>';

            }

            $formatted_subTotalAcc1 = number_format($emb_subTotalAcc1, 0, '.',',');
            $formatted_subTotalPDR = number_format($emb_subTotalPDR, 2, '.',',');
            $formatted_subGtB = number_format($emb_subGtB, 0, '.',',');
            $formatted_subTotalAmountGB = number_format($emb_subTotalAmountGB, 2, '.',',');
            $formatted_subTotalMisc = number_format($emb_subTotalMisc, 2, '.',',');
            $formatted_subTotalWrittenOf = number_format($emb_subTotalWrittenOff, 0, '.',',');
            $formatted_subTotalAmountWrittenOff = number_format($emb_subTotalAmountWrittenOff, 2, '.',',');
            $formatted_subTotalFullyPaid  = number_format($emb_subTotalFullyPaid, 0, '.',',');
            $formatted_subTotalCollection = number_format($emb_subtotalCollection, 2, '.',',');
            $formatted_subtotalSSP = number_format($emb_subtotalSSP, 0, '.',',');
            $formatted_subtotalBadAccs = number_format($emb_subtotalBadAccs, 2, '.',',');
            
            $html .= '
                <tr>
                    <td style="color: #e69797;">Sub Total - EMB</td>
                    <td style="text-align: right;">'.$formatted_subTotalAcc1.'</td>
                    <td style="text-align: right;">'.$formatted_subTotalPDR.'</td>
                    <td style="text-align: right;">'.$formatted_subGtB.'</td>
                    <td style="text-align: right;">'.$formatted_subTotalAmountGB.'</td>
                    <td style="text-align: right;"></td>
                    <td style="text-align: right;">'.$formatted_subTotalMisc.'</td>
                    <td style="text-align: right;">'.$formatted_subTotalFullyPaid.'</td>
                    <td style="text-align: right;">'.$formatted_subTotalCollection.'</td>
                    <td style="text-align: right;">'.$formatted_subTotalWrittenOf.'</td>
                    <td style="text-align: right;">'.$formatted_subTotalAmountWrittenOff.'</td>
                    <td style="text-align: right;">'.$formatted_subtotalSSP.'</td>
                    <td style="text-align: right;">'.$formatted_subtotalBadAccs.'</td>
                </tr>
                <tr>   
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                    ';
                    
            $emb_grandTotalAcc1 +=   $emb_subTotalAcc1;
            $emb_grandTotalPDR += $emb_subTotalPDR;
            $emb_grandGtB += $emb_subGtB;
            $emb_grandTotalAmountGB += $emb_subTotalAmountGB;
            $emb_grandTotalMisc+= $emb_subTotalMisc;
            $emb_grandTotalWrittenOff+= $emb_subTotalWrittenOff;
            $emb_grandTotalAmountWrittenOff+= $emb_subTotalAmountWrittenOff;
            $emb_grandTotalFullyPaid+= $emb_subTotalFullyPaid;
            $emb_grandtotalCollection+= $emb_subtotalCollection;
            $emb_grandtotalSSP+= $emb_subtotalSSP;
            $emb_grandtotalBadAccs+= $emb_subtotalBadAccs;


                    $emb_subTotalAcc1 = 0;
                    $emb_subTotalPDR = 0;
                    $emb_subGtB = 0;
                    $emb_subTotalAmountGB = 0;
                    $emb_subTotalMisc= 0;
                    $emb_subTotalWrittenOff= 0;
                    $emb_subTotalAmountWrittenOff= 0;
                    $emb_subTotalFullyPaid= 0;
                    $emb_subtotalCollection= 0;
                    $emb_subtotalSSP= 0;
                    $emb_subtotalBadAccs= 0;
                
                    foreach ($dataFCHN as $item8) {
                        $branch_name = $item8['full_name'];
                        
        
                        $goodToBad = (new ControllerPastdue)->ctrGetAllGoodToBad($branch_name, $month, $lastDay);
                        $total_debit = 0;
                        foreach ($goodToBad as $item3) {
                            $account_no = $item3['account_no'];
                            $balance = $item3['balance'];
                            $refdate = $item3['refdate'];
        
                            if($balance == 0){
                                $goodToBad1 = (new ControllerPastdue)->ctrGetAllGoodToBad1($account_no, $branch_name, $refdate);
                                foreach ($goodToBad1 as $item4) {
                                    $debit = $item4['debit'];
                                }
                                $total_debit += $debit;
        
                            }
                            
                        }
        
                        $getMisc = (new ControllerPastdue)->ctrGetMiscellaneous($branch_name, $month, $lastDay);
                        if(!empty($getMisc)){
                            foreach ($getMisc as $item5) {
                                $mis_debit = $item5['debit'];
                                $mis_debit1 = abs($item5['debit']);
                            }
                        }else{
                            $mis_debit = "";
                        }
                        if($mis_debit == 0){
                            $mis_debit = "";
                        }else{
                            $mis_debit = number_format(abs($item5['debit']) , 2, '.',',');
                        }
        
                        $total_gb = count($goodToBad);
                        $total_gb1 = count($goodToBad);
        
                        if($total_gb == 0){
                            $total_gb = "";
                        }   
        
        
                        if($total_debit <0){
                            $total_amount_gb = abs($total_debit);
                            $emb_subTotalAmountGB += $total_amount_gb;
                        }else{
                            $total_amount_gb = $total_debit * -1;
                            $emb_subTotalAmountGB += $total_amount_gb;
                        }
        
        
                        if($total_amount_gb != 0){
                            $formatted_total_amount_gb = number_format($total_amount_gb, 2, '.',',');
                        }else{
                            $formatted_total_amount_gb ="";
                        }
        
                       
        
        
                            // Start For PDR WRITTEN OFF
                            $getPDRWrittenOff = (new ControllerPastdue)->ctrGetPDRWrittenOff($branch_name, $month, $lastDay);
                            if(!empty($getPDRWrittenOff)){
                            foreach ($getPDRWrittenOff as $item6) {
                                $total_w = $item6['total_w'];
                                $total_w1 = $item6['total_w'];
                                $total_pdr_written1 = abs($item6['result']);
                                $total_pdr_written = abs($item6['result']);
                            }
        
                            
                            if($total_pdr_written == 0){
                                $total_pdr_written ="";
                                $formatted_total_pdr_written = "";
                            }else{
                                $formatted_total_pdr_written = number_format($total_pdr_written1, 2, '.',',');
                            }
                                if($total_w == 0){
                                    $total_w ="";
                                }
                        }else{
                            $total_w ="";
                        }
                        // END PDR WRITTEN OFF
        
                        // Start PDR FullyPaid 
                        $getFullyPaid = (new ControllerPastdue)->ctrGetFullyPaid($branch_name, $month, $lastDay);
                        if(!empty($getFullyPaid)){
                            foreach ($getFullyPaid as $item7) {
                                $total_f = $item7['total_f'];
                                $total_f1 = $item7['total_f'];
                                $total_collection =  $item7['total_collection'];
                                $total_collection1 =  $item7['total_collection'];
                            }
        
                            if($total_collection == 0){
                                $total_collection ="";
                                $formatted_total_collection = "";
                            }else{
                                $formatted_total_collection = number_format($total_collection, 2, '.',',');
                            }
        
                            if($total_f == 0){
                                $total_f ="";
                            }
                        }
                        else{
                            $total_f ="";
                        }
        
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
                            // $count = $count + $total_w1 + $total_f1 ; 
                            $final_total2 = $final_total2 + $total_pdr_written1;
        
                        $formatted_amount = number_format($final_total2, 2, '.',',');
                        $total_ssp = $count + $total_gb1 - $total_f1 - $total_w1;
                        $total_BadAcc= ($final_total2 +$total_amount_gb) + $mis_debit1 - $total_collection1 - $total_pdr_written1;
                        $formatted_total_BadAcc = number_format($total_BadAcc, 2, '.',',');
        
                        $emb_subTotalAcc1 += $count;
                        $emb_subTotalPDR += $final_total2;
                        $emb_subGtB += $total_gb1;
                        $emb_subTotalMisc += $mis_debit1;
                        $emb_subTotalWrittenOff += $total_w1;
                        $emb_subTotalAmountWrittenOff += $total_pdr_written1;
                        $emb_subTotalFullyPaid += $total_f1;
                        $emb_subtotalCollection += $total_collection1;
                        $emb_subtotalSSP += $total_ssp;
                        $emb_subtotalBadAccs+= $total_BadAcc;
        
                        $html .= '<tr>
                                    <td>'.$branch_name.'</td>
                                    <td style="text-align: right;">'.$count.'</td>
                                    <td style="text-align: right;">'.$formatted_amount.'</td>
                                    <td style="text-align: right;">'.$total_gb.'</td>
                                    <td style="text-align: right;">'.$formatted_total_amount_gb.'</td>
                                    <td style="text-align: right;"></td>
                                    <td style="text-align: right;">'.$mis_debit.'</td>
                                    <td style="text-align: right;">'.$total_f.'</td>
                                    <td style="text-align: right;">'.$formatted_total_collection.'</td>
                                    <td style="text-align: right;">'.$total_w.'</td>
                                    <td style="text-align: right;">'.$formatted_total_pdr_written.'</td>
                                    <td style="text-align: right;">'.$total_ssp.'</td>
                                    <td style="text-align: right;">'.$formatted_total_BadAcc.'</td>
                                </tr>';
        
                    }
        
                    $formatted_subTotalAcc1 = number_format($emb_subTotalAcc1, 0, '.',',');
                    $formatted_subTotalPDR = number_format($emb_subTotalPDR, 2, '.',',');
                    $formatted_subGtB = number_format($emb_subGtB, 0, '.',',');
                    $formatted_subTotalAmountGB = number_format($emb_subTotalAmountGB, 2, '.',',');
                    $formatted_subTotalMisc = number_format($emb_subTotalMisc, 2, '.',',');
                    $formatted_subTotalWrittenOf = number_format($emb_subTotalWrittenOff, 0, '.',',');
                    $formatted_subTotalAmountWrittenOff = number_format($emb_subTotalAmountWrittenOff, 2, '.',',');
                    $formatted_subTotalFullyPaid  = number_format($emb_subTotalFullyPaid, 0, '.',',');
                    $formatted_subTotalCollection = number_format($emb_subtotalCollection, 2, '.',',');
                    $formatted_subtotalSSP = number_format($emb_subtotalSSP, 0, '.',',');
                    $formatted_subtotalBadAccs = number_format($emb_subtotalBadAccs, 2, '.',',');
                    
                    $html .= '
                        <tr>
                            <td style="color: #e69797;">Sub Total - FCHN</td>
                            <td style="text-align: right;">'.$formatted_subTotalAcc1.'</td>
                            <td style="text-align: right;">'.$formatted_subTotalPDR.'</td>
                            <td style="text-align: right;">'.$formatted_subGtB.'</td>
                            <td style="text-align: right;">'.$formatted_subTotalAmountGB.'</td>
                            <td style="text-align: right;"></td>
                            <td style="text-align: right;">'.$formatted_subTotalMisc.'</td>
                            <td style="text-align: right;">'.$formatted_subTotalFullyPaid.'</td>
                            <td style="text-align: right;">'.$formatted_subTotalCollection.'</td>
                            <td style="text-align: right;">'.$formatted_subTotalWrittenOf.'</td>
                            <td style="text-align: right;">'.$formatted_subTotalAmountWrittenOff.'</td>
                            <td style="text-align: right;">'.$formatted_subtotalSSP.'</td>
                            <td style="text-align: right;">'.$formatted_subtotalBadAccs.'</td>
                        </tr>
                        <tr>   
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                            ';
                            $emb_grandTotalAcc1 +=   $emb_subTotalAcc1;
                            $emb_grandTotalPDR += $emb_subTotalPDR;
                            $emb_grandGtB += $emb_subGtB;
                            $emb_grandTotalAmountGB += $emb_subTotalAmountGB;
                            $emb_grandTotalMisc+= $emb_subTotalMisc;
                            $emb_grandTotalWrittenOff+= $emb_subTotalWrittenOff;
                            $emb_grandTotalAmountWrittenOff+= $emb_subTotalAmountWrittenOff;
                            $emb_grandTotalFullyPaid+= $emb_subTotalFullyPaid;
                            $emb_grandtotalCollection+= $emb_subtotalCollection;
                            $emb_grandtotalSSP+= $emb_subtotalSSP;
                            $emb_grandtotalBadAccs+= $emb_subtotalBadAccs;
                            
                    $emb_subTotalAcc1 = 0;
                    $emb_subTotalPDR = 0;
                    $emb_subGtB = 0;
                    $emb_subTotalAmountGB = 0;
                    $emb_subTotalMisc= 0;
                    $emb_subTotalWrittenOff= 0;
                    $emb_subTotalAmountWrittenOff= 0;
                    $emb_subTotalFullyPaid= 0;
                    $emb_subtotalCollection= 0;
                    $emb_subtotalSSP= 0;
                    $emb_subtotalBadAccs= 0;
                
                    foreach ($dataFCHM as $item9) {
                        $branch_name = $item9['full_name'];
                        
        
                        $goodToBad = (new ControllerPastdue)->ctrGetAllGoodToBad($branch_name, $month, $lastDay);
                        $total_debit = 0;
                        foreach ($goodToBad as $item3) {
                            $account_no = $item3['account_no'];
                            $balance = $item3['balance'];
                            $refdate = $item3['refdate'];
        
                            if($balance == 0){
                                $goodToBad1 = (new ControllerPastdue)->ctrGetAllGoodToBad1($account_no, $branch_name, $refdate);
                                foreach ($goodToBad1 as $item4) {
                                    $debit = $item4['debit'];
                                }
                                $total_debit += $debit;
        
                            }
                            
                        }
        
                        $getMisc = (new ControllerPastdue)->ctrGetMiscellaneous($branch_name, $month, $lastDay);
                        if(!empty($getMisc)){
                            foreach ($getMisc as $item5) {
                                $mis_debit = $item5['debit'];
                                $mis_debit1 = abs($item5['debit']);
                            }
                        }else{
                            $mis_debit = "";
                        }
                        if($mis_debit == 0){
                            $mis_debit = "";
                        }else{
                            $mis_debit = number_format(abs($item5['debit']) , 2, '.',',');
                        }
        
                        $total_gb = count($goodToBad);
                        $total_gb1 = count($goodToBad);
        
                        if($total_gb == 0){
                            $total_gb = "";
                        }   
        
        
                        if($total_debit <0){
                            $total_amount_gb = abs($total_debit);
                            $emb_subTotalAmountGB += $total_amount_gb;
                        }else{
                            $total_amount_gb = $total_debit * -1;
                            $emb_subTotalAmountGB += $total_amount_gb;
                        }
        
        
                        if($total_amount_gb != 0){
                            $formatted_total_amount_gb = number_format($total_amount_gb, 2, '.',',');
                        }else{
                            $formatted_total_amount_gb ="";
                        }
        
                       
        
        
                            // Start For PDR WRITTEN OFF
                            $getPDRWrittenOff = (new ControllerPastdue)->ctrGetPDRWrittenOff($branch_name, $month, $lastDay);
                            if(!empty($getPDRWrittenOff)){
                            foreach ($getPDRWrittenOff as $item6) {
                                $total_w = $item6['total_w'];
                                $total_w1 = $item6['total_w'];
                                $total_pdr_written1 = abs($item6['result']);
                                $total_pdr_written = abs($item6['result']);
                            }
        
                            
                            if($total_pdr_written == 0){
                                $total_pdr_written ="";
                                $formatted_total_pdr_written = "";
                            }else{
                                $formatted_total_pdr_written = number_format($total_pdr_written1, 2, '.',',');
                            }
                                if($total_w == 0){
                                    $total_w ="";
                                }
                        }else{
                            $total_w ="";
                        }
                        // END PDR WRITTEN OFF
        
                        // Start PDR FullyPaid 
                        $getFullyPaid = (new ControllerPastdue)->ctrGetFullyPaid($branch_name, $month, $lastDay);
                        if(!empty($getFullyPaid)){
                            foreach ($getFullyPaid as $item7) {
                                $total_f = $item7['total_f'];
                                $total_f1 = $item7['total_f'];
                                $total_collection =  $item7['total_collection'];
                                $total_collection1 =  $item7['total_collection'];
                            }
        
                            if($total_collection == 0){
                                $total_collection ="";
                                $formatted_total_collection = "";
                            }else{
                                $formatted_total_collection = number_format($total_collection, 2, '.',',');
                            }
        
                            if($total_f == 0){
                                $total_f ="";
                            }
                        }
                        else{
                            $total_f ="";
                        }
        
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
                            // $count = $count + $total_w1 + $total_f1 ; 
                            $final_total2 = $final_total2 + $total_pdr_written1;
        
                        $formatted_amount = number_format($final_total2, 2, '.',',');
                        $total_ssp = $count + $total_gb1 - $total_f1 - $total_w1;
                        $total_BadAcc= ($final_total2 +$total_amount_gb) + $mis_debit1 - $total_collection1 - $total_pdr_written1;
                        $formatted_total_BadAcc = number_format($total_BadAcc, 2, '.',',');
        
                        $emb_subTotalAcc1 += $count;
                        $emb_subTotalPDR += $final_total2;
                        $emb_subGtB += $total_gb1;
                        $emb_subTotalMisc += $mis_debit1;
                        $emb_subTotalWrittenOff += $total_w1;
                        $emb_subTotalAmountWrittenOff += $total_pdr_written1;
                        $emb_subTotalFullyPaid += $total_f1;
                        $emb_subtotalCollection += $total_collection1;
                        $emb_subtotalSSP += $total_ssp;
                        $emb_subtotalBadAccs+= $total_BadAcc;
        
                        $html .= '<tr>
                                    <td>'.$branch_name.'</td>
                                    <td style="text-align: right;">'.$count.'</td>
                                    <td style="text-align: right;">'.$formatted_amount.'</td>
                                    <td style="text-align: right;">'.$total_gb.'</td>
                                    <td style="text-align: right;">'.$formatted_total_amount_gb.'</td>
                                    <td style="text-align: right;"></td>
                                    <td style="text-align: right;">'.$mis_debit.'</td>
                                    <td style="text-align: right;">'.$total_f.'</td>
                                    <td style="text-align: right;">'.$formatted_total_collection.'</td>
                                    <td style="text-align: right;">'.$total_w.'</td>
                                    <td style="text-align: right;">'.$formatted_total_pdr_written.'</td>
                                    <td style="text-align: right;">'.$total_ssp.'</td>
                                    <td style="text-align: right;">'.$formatted_total_BadAcc.'</td>
                                </tr>';
        
                    }
        
                    $formatted_subTotalAcc1 = number_format($emb_subTotalAcc1, 0, '.',',');
                    $formatted_subTotalPDR = number_format($emb_subTotalPDR, 2, '.',',');
                    $formatted_subGtB = number_format($emb_subGtB, 0, '.',',');
                    $formatted_subTotalAmountGB = number_format($emb_subTotalAmountGB, 2, '.',',');
                    $formatted_subTotalMisc = number_format($emb_subTotalMisc, 2, '.',',');
                    $formatted_subTotalWrittenOf = number_format($emb_subTotalWrittenOff, 0, '.',',');
                    $formatted_subTotalAmountWrittenOff = number_format($emb_subTotalAmountWrittenOff, 2, '.',',');
                    $formatted_subTotalFullyPaid  = number_format($emb_subTotalFullyPaid, 0, '.',',');
                    $formatted_subTotalCollection = number_format($emb_subtotalCollection, 2, '.',',');
                    $formatted_subtotalSSP = number_format($emb_subtotalSSP, 0, '.',',');
                    $formatted_subtotalBadAccs = number_format($emb_subtotalBadAccs, 2, '.',',');
                    
                    $html .= '
                        <tr>
                            <td style="color: #e69797;">Sub Total - FCHM</td>
                            <td style="text-align: right;">'.$formatted_subTotalAcc1.'</td>
                            <td style="text-align: right;">'.$formatted_subTotalPDR.'</td>
                            <td style="text-align: right;">'.$formatted_subGtB.'</td>
                            <td style="text-align: right;">'.$formatted_subTotalAmountGB.'</td>
                            <td style="text-align: right;"></td>
                            <td style="text-align: right;">'.$formatted_subTotalMisc.'</td>
                            <td style="text-align: right;">'.$formatted_subTotalFullyPaid.'</td>
                            <td style="text-align: right;">'.$formatted_subTotalCollection.'</td>
                            <td style="text-align: right;">'.$formatted_subTotalWrittenOf.'</td>
                            <td style="text-align: right;">'.$formatted_subTotalAmountWrittenOff.'</td>
                            <td style="text-align: right;">'.$formatted_subtotalSSP.'</td>
                            <td style="text-align: right;">'.$formatted_subtotalBadAccs.'</td>
                        </tr>
                        <tr>   
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                            ';

                            $emb_grandTotalAcc1 +=   $emb_subTotalAcc1;
                            $emb_grandTotalPDR += $emb_subTotalPDR;
                            $emb_grandGtB += $emb_subGtB;
                            $emb_grandTotalAmountGB += $emb_subTotalAmountGB;
                            $emb_grandTotalMisc+= $emb_subTotalMisc;
                            $emb_grandTotalWrittenOff+= $emb_subTotalWrittenOff;
                            $emb_grandTotalAmountWrittenOff+= $emb_subTotalAmountWrittenOff;
                            $emb_grandTotalFullyPaid+= $emb_subTotalFullyPaid;
                            $emb_grandtotalCollection+= $emb_subtotalCollection;
                            $emb_grandtotalSSP+= $emb_subtotalSSP;
                            $emb_grandtotalBadAccs+= $emb_subtotalBadAccs;

                     $emb_subTotalAcc1 = 0;
                    $emb_subTotalPDR = 0;
                    $emb_subGtB = 0;
                    $emb_subTotalAmountGB = 0;
                    $emb_subTotalMisc= 0;
                    $emb_subTotalWrittenOff= 0;
                    $emb_subTotalAmountWrittenOff= 0;
                    $emb_subTotalFullyPaid= 0;
                    $emb_subtotalCollection= 0;
                    $emb_subtotalSSP= 0;
                    $emb_subtotalBadAccs= 0;
                
                    foreach ($dataRLC as $item10) {
                        $branch_name = $item10['full_name'];
                        
        
                        $goodToBad = (new ControllerPastdue)->ctrGetAllGoodToBad($branch_name, $month, $lastDay);
                        $total_debit = 0;
                        foreach ($goodToBad as $item3) {
                            $account_no = $item3['account_no'];
                            $balance = $item3['balance'];
                            $refdate = $item3['refdate'];
        
                            if($balance == 0){
                                $goodToBad1 = (new ControllerPastdue)->ctrGetAllGoodToBad1($account_no, $branch_name, $refdate);
                                foreach ($goodToBad1 as $item4) {
                                    $debit = $item4['debit'];
                                }
                                $total_debit += $debit;
        
                            }
                            
                        }
        
                        $getMisc = (new ControllerPastdue)->ctrGetMiscellaneous($branch_name, $month, $lastDay);
                        if(!empty($getMisc)){
                            foreach ($getMisc as $item5) {
                                $mis_debit = $item5['debit'];
                                $mis_debit1 = abs($item5['debit']);
                            }
                        }else{
                            $mis_debit = "";
                        }
                        if($mis_debit == 0){
                            $mis_debit = "";
                        }else{
                            $mis_debit = number_format(abs($item5['debit']) , 2, '.',',');
                        }
        
                        $total_gb = count($goodToBad);
                        $total_gb1 = count($goodToBad);
        
                        if($total_gb == 0){
                            $total_gb = "";
                        }   
        
        
                        if($total_debit <0){
                            $total_amount_gb = abs($total_debit);
                            $emb_subTotalAmountGB += $total_amount_gb;
                        }else{
                            $total_amount_gb = $total_debit * -1;
                            $emb_subTotalAmountGB += $total_amount_gb;
                        }
        
        
                        if($total_amount_gb != 0){
                            $formatted_total_amount_gb = number_format($total_amount_gb, 2, '.',',');
                        }else{
                            $formatted_total_amount_gb ="";
                        }
        
                       
        
        
                            // Start For PDR WRITTEN OFF
                            $getPDRWrittenOff = (new ControllerPastdue)->ctrGetPDRWrittenOff($branch_name, $month, $lastDay);
                            if(!empty($getPDRWrittenOff)){
                            foreach ($getPDRWrittenOff as $item6) {
                                $total_w = $item6['total_w'];
                                $total_w1 = $item6['total_w'];
                                $total_pdr_written1 = abs($item6['result']);
                                $total_pdr_written = abs($item6['result']);
                            }
        
                            
                            if($total_pdr_written == 0){
                                $total_pdr_written ="";
                                $formatted_total_pdr_written = "";
                            }else{
                                $formatted_total_pdr_written = number_format($total_pdr_written1, 2, '.',',');
                            }
                                if($total_w == 0){
                                    $total_w ="";
                                }
                        }else{
                            $total_w ="";
                        }
                        // END PDR WRITTEN OFF
        
                        // Start PDR FullyPaid 
                        $getFullyPaid = (new ControllerPastdue)->ctrGetFullyPaid($branch_name, $month, $lastDay);
                        if(!empty($getFullyPaid)){
                            foreach ($getFullyPaid as $item7) {
                                $total_f = $item7['total_f'];
                                $total_f1 = $item7['total_f'];
                                $total_collection =  $item7['total_collection'];
                                $total_collection1 =  $item7['total_collection'];
                            }
        
                            if($total_collection == 0){
                                $total_collection ="";
                                $formatted_total_collection = "";
                            }else{
                                $formatted_total_collection = number_format($total_collection, 2, '.',',');
                            }
        
                            if($total_f == 0){
                                $total_f ="";
                            }
                        }
                        else{
                            $total_f ="";
                        }
        
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
                            // $count = $count + $total_w1 + $total_f1 ; 
                            $final_total2 = $final_total2 + $total_pdr_written1;
        
                        $formatted_amount = number_format($final_total2, 2, '.',',');
                        $total_ssp = $count + $total_gb1 - $total_f1 - $total_w1;
                        $total_BadAcc= ($final_total2 +$total_amount_gb) + $mis_debit1 - $total_collection1 - $total_pdr_written1;
                        $formatted_total_BadAcc = number_format($total_BadAcc, 2, '.',',');
        
                        $emb_subTotalAcc1 += $count;
                        $emb_subTotalPDR += $final_total2;
                        $emb_subGtB += $total_gb1;
                        $emb_subTotalMisc += $mis_debit1;
                        $emb_subTotalWrittenOff += $total_w1;
                        $emb_subTotalAmountWrittenOff += $total_pdr_written1;
                        $emb_subTotalFullyPaid += $total_f1;
                        $emb_subtotalCollection += $total_collection1;
                        $emb_subtotalSSP += $total_ssp;
                        $emb_subtotalBadAccs+= $total_BadAcc;
        
                        $html .= '<tr>
                                    <td>'.$branch_name.'</td>
                                    <td style="text-align: right;">'.$count.'</td>
                                    <td style="text-align: right;">'.$formatted_amount.'</td>
                                    <td style="text-align: right;">'.$total_gb.'</td>
                                    <td style="text-align: right;">'.$formatted_total_amount_gb.'</td>
                                    <td style="text-align: right;"></td>
                                    <td style="text-align: right;">'.$mis_debit.'</td>
                                    <td style="text-align: right;">'.$total_f.'</td>
                                    <td style="text-align: right;">'.$formatted_total_collection.'</td>
                                    <td style="text-align: right;">'.$total_w.'</td>
                                    <td style="text-align: right;">'.$formatted_total_pdr_written.'</td>
                                    <td style="text-align: right;">'.$total_ssp.'</td>
                                    <td style="text-align: right;">'.$formatted_total_BadAcc.'</td>
                                </tr>';
        
                    }
        
                    $formatted_subTotalAcc1 = number_format($emb_subTotalAcc1, 0, '.',',');
                    $formatted_subTotalPDR = number_format($emb_subTotalPDR, 2, '.',',');
                    $formatted_subGtB = number_format($emb_subGtB, 0, '.',',');
                    $formatted_subTotalAmountGB = number_format($emb_subTotalAmountGB, 2, '.',',');
                    $formatted_subTotalMisc = number_format($emb_subTotalMisc, 2, '.',',');
                    $formatted_subTotalWrittenOf = number_format($emb_subTotalWrittenOff, 0, '.',',');
                    $formatted_subTotalAmountWrittenOff = number_format($emb_subTotalAmountWrittenOff, 2, '.',',');
                    $formatted_subTotalFullyPaid  = number_format($emb_subTotalFullyPaid, 0, '.',',');
                    $formatted_subTotalCollection = number_format($emb_subtotalCollection, 2, '.',',');
                    $formatted_subtotalSSP = number_format($emb_subtotalSSP, 0, '.',',');
                    $formatted_subtotalBadAccs = number_format($emb_subtotalBadAccs, 2, '.',',');
                    
                    $html .= '
                        <tr>
                            <td style="color: #e69797;">Sub Total - RLC</td>
                            <td style="text-align: right;">'.$formatted_subTotalAcc1.'</td>
                            <td style="text-align: right;">'.$formatted_subTotalPDR.'</td>
                            <td style="text-align: right;">'.$formatted_subGtB.'</td>
                            <td style="text-align: right;">'.$formatted_subTotalAmountGB.'</td>
                            <td style="text-align: right;"></td>
                            <td style="text-align: right;">'.$formatted_subTotalMisc.'</td>
                            <td style="text-align: right;">'.$formatted_subTotalFullyPaid.'</td>
                            <td style="text-align: right;">'.$formatted_subTotalCollection.'</td>
                            <td style="text-align: right;">'.$formatted_subTotalWrittenOf.'</td>
                            <td style="text-align: right;">'.$formatted_subTotalAmountWrittenOff.'</td>
                            <td style="text-align: right;">'.$formatted_subtotalSSP.'</td>
                            <td style="text-align: right;">'.$formatted_subtotalBadAccs.'</td>
                        </tr>
                        <tr>   
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                            ';
              $emb_grandTotalAcc1 +=   $emb_subTotalAcc1;
            $emb_grandTotalPDR += $emb_subTotalPDR;
            $emb_grandGtB += $emb_subGtB;
            $emb_grandTotalAmountGB += $emb_subTotalAmountGB;
            $emb_grandTotalMisc+= $emb_subTotalMisc;
            $emb_grandTotalWrittenOff+= $emb_subTotalWrittenOff;
            $emb_grandTotalAmountWrittenOff+= $emb_subTotalAmountWrittenOff;
            $emb_grandTotalFullyPaid+= $emb_subTotalFullyPaid;
            $emb_grandtotalCollection+= $emb_subtotalCollection;
            $emb_grandtotalSSP+= $emb_subtotalSSP;
            $emb_grandtotalBadAccs+= $emb_subtotalBadAccs;

                            $emb_subTotalAcc1 = 0;
                            $emb_subTotalPDR = 0;
                            $emb_subGtB = 0;
                            $emb_subTotalAmountGB = 0;
                            $emb_subTotalMisc= 0;
                            $emb_subTotalWrittenOff= 0;
                            $emb_subTotalAmountWrittenOff= 0;
                            $emb_subTotalFullyPaid= 0;
                            $emb_subtotalCollection= 0;
                            $emb_subtotalSSP= 0;
                            $emb_subtotalBadAccs= 0;
                        
                            foreach ($dataELC as $item11) {
                                $branch_name = $item11['full_name'];
                                
                
                                $goodToBad = (new ControllerPastdue)->ctrGetAllGoodToBad($branch_name, $month, $lastDay);
                                $total_debit = 0;
                                foreach ($goodToBad as $item3) {
                                    $account_no = $item3['account_no'];
                                    $balance = $item3['balance'];
                                    $refdate = $item3['refdate'];
                
                                    if($balance == 0){
                                        $goodToBad1 = (new ControllerPastdue)->ctrGetAllGoodToBad1($account_no, $branch_name, $refdate);
                                        foreach ($goodToBad1 as $item4) {
                                            $debit = $item4['debit'];
                                        }
                                        $total_debit += $debit;
                
                                    }
                                    
                                }
                
                                $getMisc = (new ControllerPastdue)->ctrGetMiscellaneous($branch_name, $month, $lastDay);
                                if(!empty($getMisc)){
                                    foreach ($getMisc as $item5) {
                                        $mis_debit = $item5['debit'];
                                        $mis_debit1 = abs($item5['debit']);
                                    }
                                }else{
                                    $mis_debit = "";
                                }
                                if($mis_debit == 0){
                                    $mis_debit = "";
                                }else{
                                    $mis_debit = number_format(abs($item5['debit']) , 2, '.',',');
                                }
                
                                $total_gb = count($goodToBad);
                                $total_gb1 = count($goodToBad);
                
                                if($total_gb == 0){
                                    $total_gb = "";
                                }   
                
                
                                if($total_debit <0){
                                    $total_amount_gb = abs($total_debit);
                                    $emb_subTotalAmountGB += $total_amount_gb;
                                }else{
                                    $total_amount_gb = $total_debit * -1;
                                    $emb_subTotalAmountGB += $total_amount_gb;
                                }
                
                
                                if($total_amount_gb != 0){
                                    $formatted_total_amount_gb = number_format($total_amount_gb, 2, '.',',');
                                }else{
                                    $formatted_total_amount_gb ="";
                                }
                
                               
                
                
                                    // Start For PDR WRITTEN OFF
                                    $getPDRWrittenOff = (new ControllerPastdue)->ctrGetPDRWrittenOff($branch_name, $month, $lastDay);
                                    if(!empty($getPDRWrittenOff)){
                                    foreach ($getPDRWrittenOff as $item6) {
                                        $total_w = $item6['total_w'];
                                        $total_w1 = $item6['total_w'];
                                        $total_pdr_written1 = abs($item6['result']);
                                        $total_pdr_written = abs($item6['result']);
                                    }
                
                                    
                                    if($total_pdr_written == 0){
                                        $total_pdr_written ="";
                                        $formatted_total_pdr_written = "";
                                    }else{
                                        $formatted_total_pdr_written = number_format($total_pdr_written1, 2, '.',',');
                                    }
                                        if($total_w == 0){
                                            $total_w ="";
                                        }
                                }else{
                                    $total_w ="";
                                }
                                // END PDR WRITTEN OFF
                
                                // Start PDR FullyPaid 
                                $getFullyPaid = (new ControllerPastdue)->ctrGetFullyPaid($branch_name, $month, $lastDay);
                                if(!empty($getFullyPaid)){
                                    foreach ($getFullyPaid as $item7) {
                                        $total_f = $item7['total_f'];
                                        $total_f1 = $item7['total_f'];
                                        $total_collection =  $item7['total_collection'];
                                        $total_collection1 =  $item7['total_collection'];
                                    }
                
                                    if($total_collection == 0){
                                        $total_collection ="";
                                        $formatted_total_collection = "";
                                    }else{
                                        $formatted_total_collection = number_format($total_collection, 2, '.',',');
                                    }
                
                                    if($total_f == 0){
                                        $total_f ="";
                                    }
                                }
                                else{
                                    $total_f ="";
                                }
                
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
                                    // $count = $count + $total_w1 + $total_f1 ; 
                                    $final_total2 = $final_total2 + $total_pdr_written1;
                
                                $formatted_amount = number_format($final_total2, 2, '.',',');
                                $total_ssp = $count + $total_gb1 - $total_f1 - $total_w1;
                                $total_BadAcc= ($final_total2 +$total_amount_gb) + $mis_debit1 - $total_collection1 - $total_pdr_written1;
                                $formatted_total_BadAcc = number_format($total_BadAcc, 2, '.',',');

           
                
                                $emb_subTotalAcc1 += $count;
                                $emb_subTotalPDR += $final_total2;
                                $emb_subGtB += $total_gb1;
                                $emb_subTotalMisc += $mis_debit1;
                                $emb_subTotalWrittenOff += $total_w1;
                                $emb_subTotalAmountWrittenOff += $total_pdr_written1;
                                $emb_subTotalFullyPaid += $total_f1;
                                $emb_subtotalCollection += $total_collection1;
                                $emb_subtotalSSP += $total_ssp;
                                $emb_subtotalBadAccs+= $total_BadAcc;
                
                                $html .= '<tr>
                                            <td  style="color: #e69797;">'.$branch_name.'</td>
                                            <td style="text-align: right;">'.$count.'</td>
                                            <td style="text-align: right;">'.$formatted_amount.'</td>
                                            <td style="text-align: right;">'.$total_gb.'</td>
                                            <td style="text-align: right;">'.$formatted_total_amount_gb.'</td>
                                            <td style="text-align: right;"></td>
                                            <td style="text-align: right;">'.$mis_debit.'</td>
                                            <td style="text-align: right;">'.$total_f.'</td>
                                            <td style="text-align: right;">'.$formatted_total_collection.'</td>
                                            <td style="text-align: right;">'.$total_w.'</td>
                                            <td style="text-align: right;">'.$formatted_total_pdr_written.'</td>
                                            <td style="text-align: right;">'.$total_ssp.'</td>
                                            <td style="text-align: right;">'.$formatted_total_BadAcc.'</td>
                                        </tr>';
                
                            }
                            $html .= ' 
                          
                                <tr>   
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                    ';
                                    $emb_grandTotalAcc1 +=   $emb_subTotalAcc1;
                                    $emb_grandTotalPDR += $emb_subTotalPDR;
                                    $emb_grandGtB += $emb_subGtB;
                                    $emb_grandTotalAmountGB += $emb_subTotalAmountGB;
                                    $emb_grandTotalMisc+= $emb_subTotalMisc;
                                    $emb_grandTotalWrittenOff+= $emb_subTotalWrittenOff;
                                    $emb_grandTotalAmountWrittenOff+= $emb_subTotalAmountWrittenOff;
                                    $emb_grandTotalFullyPaid+= $emb_subTotalFullyPaid;
                                    $emb_grandtotalCollection+= $emb_subtotalCollection;
                                    $emb_grandtotalSSP+= $emb_subtotalSSP;
                                    $emb_grandtotalBadAccs+= $emb_subtotalBadAccs;

                                    $formatted_grandTotalAcc1 = number_format($emb_grandTotalAcc1, 0, '.',',');
                                    $formatted_grandTotalPDR = number_format($emb_grandTotalPDR, 2, '.',',');
                                    $formatted_grandGtB = number_format($emb_grandGtB, 0, '.',',');
                                    $formatted_grandTotalAmountGB = number_format($emb_grandTotalAmountGB, 2, '.',',');
                                    $formatted_grandTotalMisc = number_format($emb_grandTotalMisc, 2, '.',',');
                                    $formatted_grandTotalWrittenOf = number_format($emb_grandTotalWrittenOff, 0, '.',',');
                                    $formatted_grandTotalAmountWrittenOff = number_format($emb_grandTotalAmountWrittenOff, 2, '.',',');
                                    $formatted_grandTotalFullyPaid  = number_format($emb_grandTotalFullyPaid, 0, '.',',');
                                    $formatted_grandTotalCollection = number_format($emb_grandtotalCollection, 2, '.',',');
                                    $formatted_grandtotalSSP = number_format($emb_grandtotalSSP, 0, '.',',');
                                    $formatted_grandtotalBadAccs = number_format($emb_grandtotalBadAccs, 2, '.',',');
                                    

                $html .= '   

                <tr>
                <td style="color: #9cccf2;">Total - JGC</td>
                <td style="text-align: right; color: #9cccf2;">'.$formatted_grandTotalAcc1.'</td>
                <td style="text-align: right; color: #9cccf2;">'.$formatted_grandTotalPDR.'</td>
                <td style="text-align: right; color: #9cccf2;">'.$formatted_grandGtB.'</td>
                <td style="text-align: right; color: #9cccf2;">'.$formatted_grandTotalAmountGB.'</td>
                <td style="text-align: right; color: #9cccf2;"></td>
                <td style="text-align: right; color: #9cccf2;">'.$formatted_grandTotalMisc.'</td>
                <td style="text-align: right; color: #9cccf2;">'.$formatted_grandTotalFullyPaid.'</td>
                <td style="text-align: right; color: #9cccf2;">'.$formatted_grandTotalCollection.'</td>
                <td style="text-align: right; color: #9cccf2;">'.$formatted_grandTotalWrittenOf.'</td>
                <td style="text-align: right; color: #9cccf2;">'.$formatted_grandTotalAmountWrittenOff.'</td>
                <td style="text-align: right; color: #9cccf2;">'.$formatted_grandtotalSSP.'</td>
                <td style="text-align: right; color: #9cccf2;">'.$formatted_grandtotalBadAccs.'</td>
            </tr>



            </tbody>';
        
            echo json_encode(['card' => $html]);
        }
        
    }
   
