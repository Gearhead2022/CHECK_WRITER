<?php

require_once "../../../models/connection.php";
require_once "../../../views/modules/session.php";
require_once "../../../controllers/pastdue.controller.php";
require_once "../../../models/pastdue.model.php";

class printClientList{

    public $ref_id; 
public function getClientsPrinting(){

    
  require_once('tcpdf_include.php');


//   $pdf = new TCPDF('L', PDF_UN IT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
  $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
  $pdf->startPageGroup();
  $pdf->setPrintHeader(false);  /*remove line on top of the page*/

  // set document information


// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 009', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(9,9);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 10);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);




$pdf->SetFont('Times');
$pdf->AddPage();

    // set JPEG quality
$pdf->setJPEGQuality(75);
// Example of Image from data stream ('PHP rules')
$imgdata = base64_decode('');

       // The '@' character is used to indicate that follows an image data stream and not an image file name
$pdf->Image('@'.$imgdata);




//rlwh//
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// Image example with resizing
// $pdf->Image('../../../views/files/'.$img_name.'', 165, 15, 30, 25, 'JPG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 1, false, false, false);

// - - - - - - - - - - -
$slcMonth = $_GET['slcMonth'];
// Get the first day of the selected month
$month = date("Y-m-d", strtotime($slcMonth . "-01"));
// Get the last day of the selected month
$lastDay = date("Y-m-d", strtotime("last day of " . $month));

$endDate = date("j", strtotime("last day of " . $month));
$range = date("F", strtotime($month)) . " 1-" . $endDate . " " .date("Y", strtotime($month)) ;

$lastMonth = date('F d, Y', strtotime($month . ' -1 day'));
$endMonth = date("F d, Y", strtotime("last day of " . $month));

$forTheMont = date("F Y", strtotime($slcMonth));


$data = (new ControllerPastdue)->ctrShowEMBBranches();
$dataFCHN = (new ControllerPastdue)->ctrShowFCHNBranches();
$dataFCHM = (new ControllerPastdue)->ctrShowFCHMBranches();
$dataRLC = (new ControllerPastdue)->ctrShowRLCBranches();
$dataELC = (new ControllerPastdue)->ctrShowELCBranches();

$reportName = "PDR Performance Summary ".$forTheMont . ".pdf";

$header = <<<EOF
    <style>
    table, tr, td{
        font-size:6.4rem;
        border:1px solid black;
    }
    table, tr, th{
        font-size:6.4rem;
        
        
    }
    </style>

    <table>

    <tr>
    <td colspan="13" style="text-align:center;font-weight:bold;border:none; font-size: 11px;">JAMERO GROUP OF COMPANIES</td>
    </tr>

    <tr>
    <td colspan="13" style="text-align:center;font-weight:bold;border:none;font-size: 11px;">PAST DUE PERFORMANCE SUMMARY</td>
    </tr>

    <tr>
        <td style="text-align:center;font-weight:bold;border:none;font-size: 10px;" colspan="13">For the Month $forTheMont</td>
    </tr>

    <tr>
    <td colspan="13" style="border:none;"></td>
    </tr>

    <tr>
    <td colspan="13" style="border:none;"></td>
    </tr>

    <tr>
    <td style="border:none;"></td>
    <td style="border:none;"></td>
    <td style="border:none;width:64px"></td>
    <td colspan="8" style="text-align:center;">$range</td>
    <td style="border:none;"></td>
    <td style="border:none;"></td>
   
    </tr>


    <tr>
    <th style="text-align: center;vertical-align: middle;font-size:7.9rem;border:1px solid black;width:100px;padding:5rem;font-weight:bold;" rowspan="2"><span style="color:white;">d</span><br>BRANCH<br><span style="color:white;">ds</span></th>
        <th style="text-align:center;border:1px solid black;width:116px;" colspan= "2">TOTAL BAD ACCTS. <br> As of $lastMonth</th>
        <th style="text-align:center;border:1px solid black;" colspan= "2">PDR ENDORSE <br>(GOOD TO BAD ACCT.)</th>
        <th style="text-align:center;border:1px solid black;" colspan= "2">PDR <br> (MISCELLANEOUS)</th>
        <th style="text-align:center;border:1px solid black;" colspan= "2">PDR COLLECTION / <br> FULLY PAID</th>
        <th style="text-align:center;border:1px solid black;" colspan= "2">PDR <br> WRITTEN OFF</th>
        <th style="text-align:center;border:1px solid black;" colspan= "2">TOTAL BAD ACCTS. <br> As of $endMonth </th>
    </tr>
<tr>
    <th style="width:40px;"></th>
    <th style="text-align: Center;border:1px solid black;width:76px;">TOTAL PDR</th>
    <th style="border:1px solid black;width:40px;"></th>
    <th style="border:1px solid black;width:112px;"></th>
    <th style="border:1px solid black;width:40px;"></th>
    <th style="border:1px solid black;width:112px;"></th>
    <th style="border:1px solid black;width:40px;"></th>
    <th style="border:1px solid black;width:112px;"></th>
    <th style="border:1px solid black;width:40px;"></th>
    <th style="border:1px solid black;width:112px;"></th>
    <th style="border:1px solid black;width:40px;text-align:center;"><span style="color:white;">sd</span>SSP #</th>
    <th style="border:1px solid black;width:112px;text-align:center;">TOTAL</th>
</tr>
    </table>
EOF;


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
    $total_BadAcc= ($final_total2 +$total_amount_gb) - $mis_debit1 - $total_collection1 - $total_pdr_written1;
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






    $header .= <<<EOF
                <table>
                    <tr>
                        <td style="width:100px;">$branch_name</td>
                        <td style="text-align: right;width:40px;">$count</td>
                        <td style="text-align: right;">$formatted_amount</td>
                        <td style="text-align: right;width:40px;">$total_gb</td>
                        <td style="text-align: right;width:112">$formatted_total_amount_gb</td>
                        <td style="text-align: right;width:40px;"></td>
                        <td style="text-align: right;width:112px;">$mis_debit</td>
                        <td style="text-align: right;width:40px;">$total_f</td>
                        <td style="text-align: right;width:112px;">$formatted_total_collection</td>
                        <td style="text-align: right;width:40px;">$total_w</td>
                        <td style="text-align: right;width:112px;">$formatted_total_pdr_written</td>
                        <td style="text-align: right;width:40px;">$total_ssp</td>
                        <td style="text-align: right;width:112px;">$formatted_total_BadAcc</td>
                    </tr>

                    </table>
        EOF;

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

$header .= <<<EOF
    <table>
        <tr>
            <td style="font-weight:bold;color: red;width:100px;">Sub Total - EMB</td>
            <td style="font-weight:bold;color: red;text-align: right;width:40px;">$formatted_subTotalAcc1</td>
            <td style="font-weight:bold;color: red;text-align: right;">$formatted_subTotalPDR</td>
            <td style="font-weight:bold;color: red;text-align: right;width:40px;">$formatted_subGtB</td>
            <td style="font-weight:bold;color: red;text-align: right;width:112px;">$formatted_subTotalAmountGB</td>
            <td style="font-weight:bold;color: red;text-align: right;width:40px;"></td>
            <td style="font-weight:bold;color: red;text-align: right;width:112px;">$formatted_subTotalMisc</td>
            <td style="font-weight:bold;color: red;text-align: right;width:40px;">$formatted_subTotalFullyPaid</td>
            <td style="font-weight:bold;color: red;text-align: right;width:112px;">$formatted_subTotalCollection</td>
            <td style="font-weight:bold;color: red;text-align: right;width:40px;">$formatted_subTotalWrittenOf</td>
            <td style="font-weight:bold;color: red;text-align: right;width:112px;">$formatted_subTotalAmountWrittenOff</td>
            <td style="font-weight:bold;color: red;text-align: right;width:40px;">$formatted_subtotalSSP</td>
            <td style="font-weight:bold;color: red;text-align: right;width:112px;">$formatted_subtotalBadAccs</td>
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
    </table>
    EOF;
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
                $total_BadAcc= ($final_total2 +$total_amount_gb) - $mis_debit1 - $total_collection1 - $total_pdr_written1;
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

                $header .= <<<EOF
                    <table>
                        <tr>
                            <td style="width:100px;">$branch_name</td>
                            <td style="text-align: right;width:40px;">$count</td>
                            <td style="text-align: right;">$formatted_amount</td>
                            <td style="text-align: right;width:40px;">$total_gb</td>
                            <td style="text-align: right;width:112">$formatted_total_amount_gb</td>
                            <td style="text-align: right;width:40px;"></td>
                            <td style="text-align: right;width:112px;">$mis_debit</td>
                            <td style="text-align: right;width:40px;">$total_f</td>
                            <td style="text-align: right;width:112px;">$formatted_total_collection</td>
                            <td style="text-align: right;width:40px;">$total_w</td>
                            <td style="text-align: right;width:112px;">$formatted_total_pdr_written</td>
                            <td style="text-align: right;width:40px;">$total_ssp</td>
                            <td style="text-align: right;width:112px;">$formatted_total_BadAcc</td>
                        </tr>

                    </table>
                    EOF;

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
            
            $header .= <<<EOF
                        <table>
                    <tr>
                        <td style="font-weight:bold;color: red;width:100px;">Sub Total - FCHN</td>
                        <td style="font-weight:bold;color: red;text-align: right;width:40px;">$formatted_subTotalAcc1</td>
                        <td style="font-weight:bold;color: red;text-align: right;">$formatted_subTotalPDR</td>
                        <td style="font-weight:bold;color: red;text-align: right;width:40px;">$formatted_subGtB</td>
                        <td style="font-weight:bold;color: red;text-align: right;width:112px;">$formatted_subTotalAmountGB</td>
                        <td style="font-weight:bold;color: red;text-align: right;width:40px;"></td>
                        <td style="font-weight:bold;color: red;text-align: right;width:112px;">$formatted_subTotalMisc</td>
                        <td style="font-weight:bold;color: red;text-align: right;width:40px;">$formatted_subTotalFullyPaid</td>
                        <td style="font-weight:bold;color: red;text-align: right;width:112px;">$formatted_subTotalCollection</td>
                        <td style="font-weight:bold;color: red;text-align: right;width:40px;">$formatted_subTotalWrittenOf</td>
                        <td style="font-weight:bold;color: red;text-align: right;width:112px;">$formatted_subTotalAmountWrittenOff</td>
                        <td style="font-weight:bold;color: red;text-align: right;width:40px;">$formatted_subtotalSSP</td>
                        <td style="font-weight:bold;color: red;text-align: right;width:112px;">$formatted_subtotalBadAccs</td>
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
                </table>
        EOF;

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
    $total_BadAcc= ($final_total2 +$total_amount_gb) - $mis_debit1 - $total_collection1 - $total_pdr_written1;
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

    $header .= <<<EOF
            <table>
                <tr>
                    <td style="width:100px;">$branch_name</td>
                    <td style="text-align: right;width:40px;">$count</td>
                    <td style="text-align: right;">$formatted_amount</td>
                    <td style="text-align: right;width:40px;">$total_gb</td>
                    <td style="text-align: right;width:112">$formatted_total_amount_gb</td>
                    <td style="text-align: right;width:40px;"></td>
                    <td style="text-align: right;width:112px;">$mis_debit</td>
                    <td style="text-align: right;width:40px;">$total_f</td>
                    <td style="text-align: right;width:112px;">$formatted_total_collection</td>
                    <td style="text-align: right;width:40px;">$total_w</td>
                    <td style="text-align: right;width:112px;">$formatted_total_pdr_written</td>
                    <td style="text-align: right;width:40px;">$total_ssp</td>
                    <td style="text-align: right;width:112px;">$formatted_total_BadAcc</td>
                </tr>

            </table>
        EOF;

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

$header .= <<<EOF
                <table>
                <tr>
                    <td style="font-weight:bold;color: red;width:100px;">Sub Total - FCHM</td>
                    <td style="font-weight:bold;color: red;text-align: right;width:40px;">$formatted_subTotalAcc1</td>
                    <td style="font-weight:bold;color: red;text-align: right;">$formatted_subTotalPDR</td>
                    <td style="font-weight:bold;color: red;text-align: right;width:40px;">$formatted_subGtB</td>
                    <td style="font-weight:bold;color: red;text-align: right;width:112px;">$formatted_subTotalAmountGB</td>
                    <td style="font-weight:bold;color: red;text-align: right;width:40px;"></td>
                    <td style="font-weight:bold;color: red;text-align: right;width:112px;">$formatted_subTotalMisc</td>
                    <td style="font-weight:bold;color: red;text-align: right;width:40px;">$formatted_subTotalFullyPaid</td>
                    <td style="font-weight:bold;color: red;text-align: right;width:112px;">$formatted_subTotalCollection</td>
                    <td style="font-weight:bold;color: red;text-align: right;width:40px;">$formatted_subTotalWrittenOf</td>
                    <td style="font-weight:bold;color: red;text-align: right;width:112px;">$formatted_subTotalAmountWrittenOff</td>
                    <td style="font-weight:bold;color: red;text-align: right;width:40px;">$formatted_subtotalSSP</td>
                    <td style="font-weight:bold;color: red;text-align: right;width:112px;">$formatted_subtotalBadAccs</td>
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
                </table>
    EOF;

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
$total_BadAcc= ($final_total2 +$total_amount_gb) - $mis_debit1 - $total_collection1 - $total_pdr_written1;
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

$header .= <<<EOF
        <table>
        <tr>
            <td style="width:100px;">$branch_name</td>
            <td style="text-align: right;width:40px;">$count</td>
            <td style="text-align: right;">$formatted_amount</td>
            <td style="text-align: right;width:40px;">$total_gb</td>
            <td style="text-align: right;width:112">$formatted_total_amount_gb</td>
            <td style="text-align: right;width:40px;"></td>
            <td style="text-align: right;width:112px;">$mis_debit</td>
            <td style="text-align: right;width:40px;">$total_f</td>
            <td style="text-align: right;width:112px;">$formatted_total_collection</td>
            <td style="text-align: right;width:40px;">$total_w</td>
            <td style="text-align: right;width:112px;">$formatted_total_pdr_written</td>
            <td style="text-align: right;width:40px;">$total_ssp</td>
            <td style="text-align: right;width:112px;">$formatted_total_BadAcc</td>
        </tr>

        </table>
    EOF;

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

$header .= <<<EOF
    <table>
    <tr>
        <td style="font-weight:bold;color: red;width:100px;">Sub Total - RLC</td>
        <td style="font-weight:bold;color: red;text-align: right;width:40px;">$formatted_subTotalAcc1</td>
        <td style="font-weight:bold;color: red;text-align: right;">$formatted_subTotalPDR</td>
        <td style="font-weight:bold;color: red;text-align: right;width:40px;">$formatted_subGtB</td>
        <td style="font-weight:bold;color: red;text-align: right;width:112px;">$formatted_subTotalAmountGB</td>
        <td style="font-weight:bold;color: red;text-align: right;width:40px;"></td>
        <td style="font-weight:bold;color: red;text-align: right;width:112px;">$formatted_subTotalMisc</td>
        <td style="font-weight:bold;color: red;text-align: right;width:40px;">$formatted_subTotalFullyPaid</td>
        <td style="font-weight:bold;color: red;text-align: right;width:112px;">$formatted_subTotalCollection</td>
        <td style="font-weight:bold;color: red;text-align: right;width:40px;">$formatted_subTotalWrittenOf</td>
        <td style="font-weight:bold;color: red;text-align: right;width:112px;">$formatted_subTotalAmountWrittenOff</td>
        <td style="font-weight:bold;color: red;text-align: right;width:40px;">$formatted_subtotalSSP</td>
        <td style="font-weight:bold;color: red;text-align: right;width:112px;">$formatted_subtotalBadAccs</td>
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
    </table>
EOF;

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
                    $total_BadAcc= ($final_total2 +$total_amount_gb) - $mis_debit1 - $total_collection1 - $total_pdr_written1;
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
    
                    $header .= <<<EOF
                        <table>
                        <tr>
                            <td style="font-weight:bold;color: red;width:100px;">$branch_name</td>
                            <td style="font-weight:bold;color: red;text-align: right;width:40px;">$count</td>
                            <td style="font-weight:bold;color: red;text-align: right;">$formatted_amount</td>
                            <td style="font-weight:bold;color: red;text-align: right;width:40px;">$total_gb</td>
                            <td style="font-weight:bold;color: red;text-align: right;width:112">$formatted_total_amount_gb</td>
                            <td style="font-weight:bold;color: red;text-align: right;width:40px;"></td>
                            <td style="font-weight:bold;color: red;text-align: right;width:112px;">$mis_debit</td>
                            <td style="font-weight:bold;color: red;text-align: right;width:40px;">$total_f</td>
                            <td style="font-weight:bold;color: red;text-align: right;width:112px;">$formatted_total_collection</td>
                            <td style="font-weight:bold;color: red;text-align: right;width:40px;">$total_w</td>
                            <td style="font-weight:bold;color: red;text-align: right;width:112px;">$formatted_total_pdr_written</td>
                            <td style="font-weight:bold;color: red;text-align: right;width:40px;">$total_ssp</td>
                            <td style="font-weight:bold;color: red;text-align: right;width:112px;">$formatted_total_BadAcc</td>
                        </tr>

                        </table>
                    EOF;
    
                }
                $header .= <<<EOF
                            <table>
                            <tr>
                                <td style="width:100px;"></td>
                                <td style="text-align: right;width:40px;"></td>
                                <td style="text-align: right;"></td>
                                <td style="text-align: right;width:40px;"></td>
                                <td style="text-align: right;width:112"></td>
                                <td style="text-align: right;width:40px;"></td>
                                <td style="text-align: right;width:112px;"></td>
                                <td style="text-align: right;width:40px;"></td>
                                <td style="text-align: right;width:112px;"></td>
                                <td style="text-align: right;width:40px;"></td>
                                <td style="text-align: right;width:112px;"></td>
                                <td style="text-align: right;width:40px;"></td>
                                <td style="text-align: right;width:112px;"></td>
                            </tr>
                                </table>
                EOF;
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
                        

    $header .= <<<EOF
    <table>
        <tr>
            <td style="font-weight:bold;color: blue; width:100px;">Total - JGC</td>
            <td style="font-weight:bold;text-align: right; color: blue; width:40px;">$formatted_grandTotalAcc1</td>
            <td style="font-weight:bold;text-align: right; color: blue;">$formatted_grandTotalPDR</td>
            <td style="font-weight:bold;text-align: right; color: blue; width:40px;">$formatted_grandGtB</td>
            <td style="font-weight:bold;text-align: right; color: blue; width:112px;">$formatted_grandTotalAmountGB</td>
            <td style="font-weight:bold;text-align: right; color: blue; width:40px;"></td>
            <td style="font-weight:bold;text-align: right; color: blue;width:112px;">$formatted_grandTotalMisc</td>
            <td style="font-weight:bold;text-align: right; color: blue;width:40px;">$formatted_grandTotalFullyPaid</td>
            <td style="font-weight:bold;text-align: right; color: blue;width:112px;">$formatted_grandTotalCollection</td>
            <td style="font-weight:bold;text-align: right; color: blue;width:40px;">$formatted_grandTotalWrittenOf</td>
            <td style="font-weight:bold;text-align: right; color: blue;width:112px;">$formatted_grandTotalAmountWrittenOff</td>
            <td style="font-weight:bold;text-align: right; color: blue;width:40px;">$formatted_grandtotalSSP</td>
            <td style="font-weight:bold;text-align: right; color: blue;width:112px;">$formatted_grandtotalBadAccs</td>
        </tr>

        
        <tr>
        <td style="border:none;font-size:7.6rem;" colspan="3">Prepared by:</td>
        <td style="border:none;font-size:7.6rem;" colspan="3 ">Checked by:</td>
        <td style="border:none;font-size:7.6rem;" colspan="3">Noted by:</td>
        </tr>
        
        <tr>
        <td style="border:none;" colspan="13"></td>
        </tr>
        
      

        <tr>
        <td style="border:none;font-weight:bold;font-size:7.6rem;" colspan="3">Jason R. Estrellanes</td>
        <td style="border:none;font-weight:bold;font-size:7.6rem;" colspan="3">Irish T. Canete</td>
        <td style="border:none;font-weight:bold;font-size:7.6rem;" colspan="3">Christine G. Nepomuceno<br><span style="font-weight:none;">Comptroller</span></td>
        </tr>

</table>
EOF;

    

    $pdf->writeHTML($header, false, false, false, false, '');
    
    $pdf->Output($reportName, 'I');
    
   }
  }  

  $clientsFormRequest = new printClientList();
  $clientsFormRequest -> getClientsPrinting();

?>
