<?php

require_once "../../../models/connection.php";
require_once "../../../views/modules/session.php";
require_once "../../../controllers/operation.controller.php";
require_once "../../../models/operation.model.php";

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
$pdf->SetMargins(4,4);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

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

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

$reportName = "LSOR.pdf";

$Operation = new ControllerOperation();
$month = $_GET['month'];
$conMonth = date("F Y", strtotime($month));
$prevMonth = date("M Y", strtotime("-1 month", strtotime($month)));
$firstMonth = date("M", strtotime("1st month", strtotime($month)));

// Get the first day of the month
$firstDay = date('Y-m-01', strtotime($month));
// Get the last day of the month
$lastDay = date('Y-m-t', strtotime($month));
            
   

$header = <<<EOF
            <style>
            tr,th{
                font-size:5.7rem;
                border:1px solid black;
                text-align:center;
                font-weight: bold;
            }
            tr,td{
                font-size:6.7rem;
                border:1px solid black;
                text-align:center;
            }
            </style>
        <table>
            <thead>
            
            <tr>
            <td colspan="22" style="border:none;text-align:left;font-weight:bold;font-size:8.4rem;">LOST OF SALES OPPORTUNITIES REPORT</td>
            </tr>

            <tr>
            <td colspan="22" style="border:none;text-align:left;font-weight:bold;font-size:6.8rem;">FOR THE MONTH OF MAY 2023</td>
            </tr>

            <tr>
                 <th style="text-align: center;width: 100px;font-size:7.9rem; font-weight:bold;" rowspan="2"><span style="color:white;">d</span><br><br>BRANCH<br><span style="color:white;">ds</span></th>
                <th rowspan="2" style="text-align: center;"><span style="color:white;">d</span><br><br> as of $firstMonth - $prevMonth</th>
                <th style="width:43rem;"><span style="color:white;">d</span><br><br> FINANCIALLY STABLE</th>
                <th style="width:43rem;"><span style="color:white;">d</span><br><br> APPROVAL WIFE AND CHILDREN <br></th>
                <th style="width:43rem;"><span style="color:white;">d</span><br><br> LOW CASH OUT</th>
                <th style="width:43rem;"><span style="color:white;">d</span><br> EXISTING LOAN TO OTHER LENDING <br></th>
                <th style="width:43rem;"><span style="color:white;">d</span><br> OTHER LENDING RE-SCHED GAWAD</th>
                <th style="width:43rem;"><span style="color:white;">d</span><br> OTHER LENDING SCHED GAWAD</th>
                <th style="width:43rem;"><span style="color:white;">d</span><br> SCHEDULED TO APPLY LOAN</th>
                <th style="width:43rem;"><span style="color:white;">d</span><br><br> SSP OVER AGE</th>
                <th style="width:43rem;"><span style="color:white;">d</span><br><br> LACK OF REQUIREMENTS</th>
                <th style="width:43rem;"><span style="color:white;">d</span><br><br> UNDECIDED</th>
                <th style="width:43rem;"><span style="color:white;">d</span><br> REFUSE TO TRANSFER ACCOUNT/LOAN</th>
                <th style="width:43rem;"><span style="color:white;">d</span><br><br> INQUIRED ONLY</th>
                <th style="width:43rem;"><span style="color:white;">d</span><br><br> NEW POLICY</th>
                <th style="width:43rem;"><span style="color:white;">d</span><br> NOT IN GOOD CONDITION</th>
                <th style="width:43rem;"><span style="color:white;">d</span><br><br> GUARDIANSHIP</th>
                <th style="width:43rem;"><span style="color:white;">d</span><br><br> PLP</th>
                <th style="width:43rem;"><span style="color:white;">d</span><br> SSP NOT QUALIFIED</th>
                <th style="width:43rem;"><span style="color:white;">d</span><br><br> 18 MOS SSSS LOAN</th>
                <th style="width:43rem;"><span style="color:white;">d</span><br> PENSION STILL ON PROCESS</th>
                <th><span style="color:white;">d</span><br><br> TOTAL</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="22" style="font-weight: bold;text-align:left;width:1010rem;background-color:#A4ACB1;"> EMB</td>
            </tr>
        EOF;
$getEMB = $Operation ->ctrGetAllEMBBranches();
$grandTotal_LSORBegin = 0;
$grandTotal_fin_stable = 0;
$grandTotal_app_wc = 0;
$grandTotal_low_cashout = 0;
$grandTotal_existing_loan = 0;
$grandTotal_other_resched_gawad = 0;
$grandTotal_other_sched_gawad = 0;
$grandTotal_sched_applynow= 0;
$grandTotal_ssp_overage = 0;
$grandTotal_lack_requirements = 0;
$grandTotal_undecided = 0;
$grandTotal_refuse_transfer = 0;
$grandTotal_inquired_only = 0;
$grandTotal_new_policy= 0;
$grandTotal_not_goodcondition = 0;
$grandTotal_guardianship= 0;
$grandTotal_plp = 0;
$grandTotal_not_qualified = 0;
$grandTotal_eighteen_mos_sssloan = 0;
$grandTotal_on_process = 0;
$grandTotal_total = 0;

$total_LSORBegin = 0;
$total_fin_stable = 0;
$total_app_wc = 0;
$total_low_cashout = 0;
$total_existing_loan = 0;
$total_other_resched_gawad = 0;
$total_other_sched_gawad = 0;
$total_sched_applynow= 0;
$total_ssp_overage = 0;
$total_lack_requirements = 0;
$total_undecided = 0;
$total_refuse_transfer = 0;
$total_inquired_only = 0;
$total_new_policy= 0;
$total_not_goodcondition = 0;
$total_guardianship= 0;
$total_plp = 0;
$total_not_qualified = 0;
$total_eighteen_mos_sssloan = 0;
$total_on_process = 0;
$grand_total = 0;
  foreach($getEMB as $emb){
    $branch_name = $emb['full_name'];
    $getLSOP = $Operation->ctrGetBeginLSORReport($branch_name, $month);
    if(!empty($getLSOP)){
        foreach($getLSOP as $begin){
            $LSORBegin = $begin['amount'];
        }
    }else{
        $LSORBegin = 0;
    }

    $getLSOR = $Operation->ctrGetAllLSOR($branch_name, $firstDay, $lastDay);
    foreach($getLSOR as $LSOR){
        $fin_stable = $LSOR['fin_stable'];
        $app_wc = $LSOR['app_wc'];
        $low_cashout = $LSOR['low_cashout'];
        $existing_loan = $LSOR['existing_loan'];
        $other_resched_gawad = $LSOR['other_resched_gawad'];
        $other_sched_gawad = $LSOR['other_sched_gawad'];
        $sched_applynow = $LSOR['sched_applynow'];
        $ssp_overage = $LSOR['ssp_overage'];
        $lack_requirements = $LSOR['lack_requirements'];
        $undecided = $LSOR['undecided'];
        $refuse_transfer = $LSOR['refuse_transfer'];
        $inquired_only = $LSOR['inquired_only'];
        $new_policy = $LSOR['new_policy'];
        $not_goodcondition = $LSOR['not_goodcondition'];
        $guardianship = $LSOR['guardianship'];
        $plp = $LSOR['plp'];
        $not_qualified = $LSOR['not_qualified'];
        $eighteen_mos_sssloan = $LSOR['eighteen_mos_sssloan'];
        $on_process = $LSOR['on_process'];
    }

    $fin_stable = $fin_stable ?? 0;
    $app_wc = $app_wc ?? 0;
    $low_cashout = $low_cashout ?? 0;
    $existing_loan = $existing_loan ?? 0;
    $other_resched_gawad = $other_resched_gawad ?? 0;
    $other_sched_gawad = $other_sched_gawad ?? 0;
    $sched_applynow = $sched_applynow ?? 0;
    $ssp_overage = $ssp_overage ?? 0;
    $lack_requirements = $lack_requirements ?? 0;
    $undecided = $undecided ?? 0;
    $refuse_transfer = $refuse_transfer ?? 0;
    $inquired_only = $inquired_only ?? 0;
    $new_policy = $new_policy ?? 0;
    $not_goodcondition = $not_goodcondition ?? 0;
    $guardianship = $guardianship ?? 0;
    $plp = $plp ?? 0;
    $not_qualified = $not_qualified ?? 0;
    $eighteen_mos_sssloan = $eighteen_mos_sssloan ?? 0;
    $on_process = $on_process ?? 0;

    $total = $fin_stable + $app_wc + $low_cashout + $existing_loan + $other_resched_gawad + $other_sched_gawad + $sched_applynow + $ssp_overage + $lack_requirements +
    $undecided + $refuse_transfer + $inquired_only + $new_policy + $not_goodcondition + $guardianship + $plp + $not_qualified + $eighteen_mos_sssloan + $on_process;
    
    $total_LSORBegin +=$LSORBegin;
    $total_fin_stable +=$fin_stable;
    $total_app_wc +=$app_wc;
    $total_low_cashout +=$low_cashout;
    $total_existing_loan +=$existing_loan;
    $total_other_resched_gawad +=$other_resched_gawad;
    $total_other_sched_gawad+=$other_sched_gawad;
    $total_sched_applynow +=$sched_applynow;
    $total_ssp_overage +=$ssp_overage;
    $total_lack_requirements +=$lack_requirements;
    $total_undecided +=$undecided;
    $total_refuse_transfer +=$refuse_transfer;
    $total_inquired_only +=$inquired_only;
    $total_new_policy +=$new_policy;
    $total_not_goodcondition +=$not_goodcondition;
    $total_guardianship +=$guardianship;
    $total_plp +=$plp;
    $total_not_qualified +=$not_qualified;
    $total_eighteen_mos_sssloan +=$eighteen_mos_sssloan;
    $total_on_process +=$on_process;
    $grand_total +=$total;



    

$header .= <<<EOF
            <tr>
                <td style="width:100rem;text-align:left;"> $branch_name</td>
                <td>$LSORBegin</td>
                <td style="width:43rem;">$fin_stable</td>
                <td style="width:43rem;">$app_wc</td>
                <td style="width:43rem;">$low_cashout</td>
                <td style="width:43rem;">$existing_loan</td>
                <td style="width:43rem;">$other_resched_gawad</td>
                <td style="width:43rem;">$other_sched_gawad</td>
                <td style="width:43rem;">$sched_applynow</td>
                <td style="width:43rem;">$ssp_overage</td>
                <td style="width:43rem;">$lack_requirements</td>
                <td style="width:43rem;">$undecided</td>
                <td style="width:43rem;">$refuse_transfer</td>
                <td style="width:43rem;">$inquired_only</td>
                <td style="width:43rem;">$new_policy</td>
                <td style="width:43rem;">$not_goodcondition</td>
                <td style="width:43rem;">$guardianship</td>
                <td style="width:43rem;">$plp</td>
                <td style="width:43rem;">$not_qualified</td>
                <td style="width:43rem;">$eighteen_mos_sssloan</td>
                <td style="width:43rem;">$on_process</td>
                <td style="width:47rem;">$total</td>
            </tr>
        EOF;

        }
        $grandTotal_LSORBegin += $total_LSORBegin;
        $grandTotal_fin_stable  += $total_fin_stable;
        $grandTotal_app_wc  += $total_app_wc;
        $grandTotal_low_cashout  += $total_low_cashout;
        $grandTotal_existing_loan  += $total_existing_loan;
        $grandTotal_other_resched_gawad  += $total_other_resched_gawad;
        $grandTotal_other_sched_gawad  += $total_other_sched_gawad;
        $grandTotal_sched_applynow += $total_sched_applynow;
        $grandTotal_ssp_overage  += $total_ssp_overage;
        $grandTotal_lack_requirements  += $total_lack_requirements;
        $grandTotal_undecided  += $total_undecided;
        $grandTotal_refuse_transfer  += $total_refuse_transfer;
        $grandTotal_inquired_only  += $total_inquired_only;
        $grandTotal_new_policy += $total_new_policy;
        $grandTotal_not_goodcondition  += $total_not_goodcondition;
        $grandTotal_guardianship += $total_guardianship;
        $grandTotal_plp  += $total_plp;
        $grandTotal_not_qualified  += $total_not_qualified;
        $grandTotal_eighteen_mos_sssloan  += $total_eighteen_mos_sssloan;
        $grandTotal_on_process  += $total_on_process;
        $grandTotal_total  += $grand_total;
    $header .= <<<EOF
            <tr>
                <td style="background-color:#A4ACB1;">TOTAL</td>
                <td style="background-color:#A4ACB1;">$total_LSORBegin</td>
                <td style="background-color:#A4ACB1;">$total_fin_stable</td>
                <td style="background-color:#A4ACB1;">$total_app_wc</td>
                <td style="background-color:#A4ACB1;">$total_low_cashout</td>
                <td style="background-color:#A4ACB1;">$total_existing_loan</td>
                <td style="background-color:#A4ACB1;">$total_other_resched_gawad</td>
                <td style="background-color:#A4ACB1;">$total_other_sched_gawad</td>
                <td style="background-color:#A4ACB1;">$total_sched_applynow</td>
                <td style="background-color:#A4ACB1;">$total_ssp_overage</td>
                <td style="background-color:#A4ACB1;">$total_lack_requirements</td>
                <td style="background-color:#A4ACB1;">$total_undecided</td>
                <td style="background-color:#A4ACB1;">$total_refuse_transfer</td>
                <td style="background-color:#A4ACB1;">$total_inquired_only</td>
                <td style="background-color:#A4ACB1;">$total_new_policy</td>
                <td style="background-color:#A4ACB1;">$total_not_goodcondition</td>
                <td style="background-color:#A4ACB1;">$total_guardianship</td>
                <td style="background-color:#A4ACB1;">$total_plp</td>
                <td style="background-color:#A4ACB1;">$total_not_qualified</td>
                <td style="background-color:#A4ACB1;">$total_eighteen_mos_sssloan</td>
                <td style="background-color:#A4ACB1;">$total_on_process</td>
                <td style="background-color:#A4ACB1;">$grand_total</td>
        </tr>   
            <tr> <td colspan="22" style="color:white;border:none;">d</td></tr>
        <tr>
          <td colspan="1" style="font-weight: bold;text-align:left;background-color:#A4ACB1;"> FCH</td>
          <td colspan="21"></td>
        </tr>
       
    EOF;

$getFCH= $Operation ->ctrGetAllFCHBranches();
$total_LSORBegin = 0;
$total_fin_stable = 0;
$total_app_wc = 0;
$total_low_cashout = 0;
$total_existing_loan = 0;
$total_other_resched_gawad = 0;
$total_other_sched_gawad = 0;
$total_sched_applynow= 0;
$total_ssp_overage = 0;
$total_lack_requirements = 0;
$total_undecided = 0;
$total_refuse_transfer = 0;
$total_inquired_only = 0;
$total_new_policy= 0;
$total_not_goodcondition = 0;
$total_guardianship= 0;
$total_plp = 0;
$total_not_qualified = 0;
$total_eighteen_mos_sssloan = 0;
$total_on_process = 0;
$grand_total = 0;
  foreach($getFCH as $fch){
    $branch_name = $fch['full_name'];
    $getLSOP = $Operation->ctrGetBeginLSORReport($branch_name, $month);
    if(!empty($getLSOP)){
        foreach($getLSOP as $begin){
            $LSORBegin = $begin['amount'];
        }
    }else{
        $LSORBegin = 0;
    }

    $getLSOR = $Operation->ctrGetAllLSOR($branch_name, $firstDay, $lastDay);
    foreach($getLSOR as $LSOR){
        $fin_stable = $LSOR['fin_stable'];
        $app_wc = $LSOR['app_wc'];
        $low_cashout = $LSOR['low_cashout'];
        $existing_loan = $LSOR['existing_loan'];
        $other_resched_gawad = $LSOR['other_resched_gawad'];
        $other_sched_gawad = $LSOR['other_sched_gawad'];
        $sched_applynow = $LSOR['sched_applynow'];
        $ssp_overage = $LSOR['ssp_overage'];
        $lack_requirements = $LSOR['lack_requirements'];
        $undecided = $LSOR['undecided'];
        $refuse_transfer = $LSOR['refuse_transfer'];
        $inquired_only = $LSOR['inquired_only'];
        $new_policy = $LSOR['new_policy'];
        $not_goodcondition = $LSOR['not_goodcondition'];
        $guardianship = $LSOR['guardianship'];
        $plp = $LSOR['plp'];
        $not_qualified = $LSOR['not_qualified'];
        $eighteen_mos_sssloan = $LSOR['eighteen_mos_sssloan'];
        $on_process = $LSOR['on_process'];
    }

    $fin_stable = $fin_stable ?? 0;
    $app_wc = $app_wc ?? 0;
    $low_cashout = $low_cashout ?? 0;
    $existing_loan = $existing_loan ?? 0;
    $other_resched_gawad = $other_resched_gawad ?? 0;
    $other_sched_gawad = $other_sched_gawad ?? 0;
    $sched_applynow = $sched_applynow ?? 0;
    $ssp_overage = $ssp_overage ?? 0;
    $lack_requirements = $lack_requirements ?? 0;
    $undecided = $undecided ?? 0;
    $refuse_transfer = $refuse_transfer ?? 0;
    $inquired_only = $inquired_only ?? 0;
    $new_policy = $new_policy ?? 0;
    $not_goodcondition = $not_goodcondition ?? 0;
    $guardianship = $guardianship ?? 0;
    $plp = $plp ?? 0;
    $not_qualified = $not_qualified ?? 0;
    $eighteen_mos_sssloan = $eighteen_mos_sssloan ?? 0;
    $on_process = $on_process ?? 0;

    $total = $fin_stable + $app_wc + $low_cashout + $existing_loan + $other_resched_gawad + $other_sched_gawad + $sched_applynow + $ssp_overage + $lack_requirements +
    $undecided + $refuse_transfer + $inquired_only + $new_policy + $not_goodcondition + $guardianship + $plp + $not_qualified + $eighteen_mos_sssloan + $on_process;
    
    $total_LSORBegin +=$LSORBegin;
    $total_fin_stable +=$fin_stable;
    $total_app_wc +=$app_wc;
    $total_low_cashout +=$low_cashout;
    $total_existing_loan +=$existing_loan;
    $total_other_resched_gawad +=$other_resched_gawad;
    $total_other_sched_gawad+=$other_sched_gawad;
    $total_sched_applynow +=$sched_applynow;
    $total_ssp_overage +=$ssp_overage;
    $total_lack_requirements +=$lack_requirements;
    $total_undecided +=$undecided;
    $total_refuse_transfer +=$refuse_transfer;
    $total_inquired_only +=$inquired_only;
    $total_new_policy +=$new_policy;
    $total_not_goodcondition +=$not_goodcondition;
    $total_guardianship +=$guardianship;
    $total_plp +=$plp;
    $total_not_qualified +=$not_qualified;
    $total_eighteen_mos_sssloan +=$eighteen_mos_sssloan;
    $total_on_process +=$on_process;
    $grand_total +=$total;



    

$header .= <<<EOF
            <tr>
                <td style="text-align:left;"> $branch_name</td>
                <td>$LSORBegin</td>
                <td>$fin_stable</td>
                <td>$app_wc</td>
                <td>$low_cashout</td>
                <td>$existing_loan</td>
                <td>$other_resched_gawad</td>
                <td>$other_sched_gawad</td>
                <td>$sched_applynow</td>
                <td>$ssp_overage</td>
                <td>$lack_requirements</td>
                <td>$undecided</td>
                <td>$refuse_transfer</td>
                <td>$inquired_only</td>
                <td>$new_policy</td>
                <td>$not_goodcondition</td>
                <td>$guardianship</td>
                <td>$plp</td>
                <td>$not_qualified</td>
                <td>$eighteen_mos_sssloan</td>
                <td>$on_process</td>
                <td>$total</td>
            </tr>
        EOF;

        }
        $grandTotal_LSORBegin += $total_LSORBegin;
        $grandTotal_fin_stable  += $total_fin_stable;
        $grandTotal_app_wc  += $total_app_wc;
        $grandTotal_low_cashout  += $total_low_cashout;
        $grandTotal_existing_loan  += $total_existing_loan;
        $grandTotal_other_resched_gawad  += $total_other_resched_gawad;
        $grandTotal_other_sched_gawad  += $total_other_sched_gawad;
        $grandTotal_sched_applynow += $total_sched_applynow;
        $grandTotal_ssp_overage  += $total_ssp_overage;
        $grandTotal_lack_requirements  += $total_lack_requirements;
        $grandTotal_undecided  += $total_undecided;
        $grandTotal_refuse_transfer  += $total_refuse_transfer;
        $grandTotal_inquired_only  += $total_inquired_only;
        $grandTotal_new_policy += $total_new_policy;
        $grandTotal_not_goodcondition  += $total_not_goodcondition;
        $grandTotal_guardianship += $total_guardianship;
        $grandTotal_plp  += $total_plp;
        $grandTotal_not_qualified  += $total_not_qualified;
        $grandTotal_eighteen_mos_sssloan  += $total_eighteen_mos_sssloan;
        $grandTotal_on_process  += $total_on_process;
        $grandTotal_total  += $grand_total;
    $header .= <<<EOF
            <tr>
                <td style="background-color:#A4ACB1;">TOTAL</td>
                <td style="background-color:#A4ACB1;">$total_LSORBegin</td>
                <td style="background-color:#A4ACB1;">$total_fin_stable</td>
                <td style="background-color:#A4ACB1;">$total_app_wc</td>
                <td style="background-color:#A4ACB1;">$total_low_cashout</td>
                <td style="background-color:#A4ACB1;">$total_existing_loan</td>
                <td style="background-color:#A4ACB1;">$total_other_resched_gawad</td>
                <td style="background-color:#A4ACB1;">$total_other_sched_gawad</td>
                <td style="background-color:#A4ACB1;">$total_sched_applynow</td>
                <td style="background-color:#A4ACB1;">$total_ssp_overage</td>
                <td style="background-color:#A4ACB1;">$total_lack_requirements</td>
                <td style="background-color:#A4ACB1;">$total_undecided</td>
                <td style="background-color:#A4ACB1;">$total_refuse_transfer</td>
                <td style="background-color:#A4ACB1;">$total_inquired_only</td>
                <td style="background-color:#A4ACB1;">$total_new_policy</td>
                <td style="background-color:#A4ACB1;">$total_not_goodcondition</td>
                <td style="background-color:#A4ACB1;">$total_guardianship</td>
                <td style="background-color:#A4ACB1;">$total_plp</td>
                <td style="background-color:#A4ACB1;">$total_not_qualified</td>
                <td style="background-color:#A4ACB1;">$total_eighteen_mos_sssloan</td>
                <td style="background-color:#A4ACB1;">$total_on_process</td>
                <td style="background-color:#A4ACB1;">$grand_total</td>
        </tr>   
            <tr> <td colspan="22" style="color:white;border:none;">d</td></tr>
        <tr>
            <td colspan="1" style="font-weight: bold;text-align:left;background-color:#A4ACB1;"> RLC</td>
            <td colspan="21"></td>
        </tr>
    EOF;
    
$getRLC= $Operation ->ctrGetAllRLCBranches();

$total_LSORBegin = 0;
$total_fin_stable = 0;
$total_app_wc = 0;
$total_low_cashout = 0;
$total_existing_loan = 0;
$total_other_resched_gawad = 0;
$total_other_sched_gawad = 0;
$total_sched_applynow= 0;
$total_ssp_overage = 0;
$total_lack_requirements = 0;
$total_undecided = 0;
$total_refuse_transfer = 0;
$total_inquired_only = 0;
$total_new_policy= 0;
$total_not_goodcondition = 0;
$total_guardianship= 0;
$total_plp = 0;
$total_not_qualified = 0;
$total_eighteen_mos_sssloan = 0;
$total_on_process = 0;
$grand_total = 0;
  foreach($getRLC as $rlc){
    $branch_name = $rlc['full_name'];
    $getLSOP = $Operation->ctrGetBeginLSORReport($branch_name, $month);
    if(!empty($getLSOP)){
        foreach($getLSOP as $begin){
            $LSORBegin = $begin['amount'];
        }
    }else{
        $LSORBegin = 0;
    }

    $getLSOR = $Operation->ctrGetAllLSOR($branch_name, $firstDay, $lastDay);
    foreach($getLSOR as $LSOR){
        $fin_stable = $LSOR['fin_stable'];
        $app_wc = $LSOR['app_wc'];
        $low_cashout = $LSOR['low_cashout'];
        $existing_loan = $LSOR['existing_loan'];
        $other_resched_gawad = $LSOR['other_resched_gawad'];
        $other_sched_gawad = $LSOR['other_sched_gawad'];
        $sched_applynow = $LSOR['sched_applynow'];
        $ssp_overage = $LSOR['ssp_overage'];
        $lack_requirements = $LSOR['lack_requirements'];
        $undecided = $LSOR['undecided'];
        $refuse_transfer = $LSOR['refuse_transfer'];
        $inquired_only = $LSOR['inquired_only'];
        $new_policy = $LSOR['new_policy'];
        $not_goodcondition = $LSOR['not_goodcondition'];
        $guardianship = $LSOR['guardianship'];
        $plp = $LSOR['plp'];
        $not_qualified = $LSOR['not_qualified'];
        $eighteen_mos_sssloan = $LSOR['eighteen_mos_sssloan'];
        $on_process = $LSOR['on_process'];
    }

    $fin_stable = $fin_stable ?? 0;
    $app_wc = $app_wc ?? 0;
    $low_cashout = $low_cashout ?? 0;
    $existing_loan = $existing_loan ?? 0;
    $other_resched_gawad = $other_resched_gawad ?? 0;
    $other_sched_gawad = $other_sched_gawad ?? 0;
    $sched_applynow = $sched_applynow ?? 0;
    $ssp_overage = $ssp_overage ?? 0;
    $lack_requirements = $lack_requirements ?? 0;
    $undecided = $undecided ?? 0;
    $refuse_transfer = $refuse_transfer ?? 0;
    $inquired_only = $inquired_only ?? 0;
    $new_policy = $new_policy ?? 0;
    $not_goodcondition = $not_goodcondition ?? 0;
    $guardianship = $guardianship ?? 0;
    $plp = $plp ?? 0;
    $not_qualified = $not_qualified ?? 0;
    $eighteen_mos_sssloan = $eighteen_mos_sssloan ?? 0;
    $on_process = $on_process ?? 0;

    $total = $fin_stable + $app_wc + $low_cashout + $existing_loan + $other_resched_gawad + $other_sched_gawad + $sched_applynow + $ssp_overage + $lack_requirements +
    $undecided + $refuse_transfer + $inquired_only + $new_policy + $not_goodcondition + $guardianship + $plp + $not_qualified + $eighteen_mos_sssloan + $on_process;
    
    $total_LSORBegin +=$LSORBegin;
    $total_fin_stable +=$fin_stable;
    $total_app_wc +=$app_wc;
    $total_low_cashout +=$low_cashout;
    $total_existing_loan +=$existing_loan;
    $total_other_resched_gawad +=$other_resched_gawad;
    $total_other_sched_gawad+=$other_sched_gawad;
    $total_sched_applynow +=$sched_applynow;
    $total_ssp_overage +=$ssp_overage;
    $total_lack_requirements +=$lack_requirements;
    $total_undecided +=$undecided;
    $total_refuse_transfer +=$refuse_transfer;
    $total_inquired_only +=$inquired_only;
    $total_new_policy +=$new_policy;
    $total_not_goodcondition +=$not_goodcondition;
    $total_guardianship +=$guardianship;
    $total_plp +=$plp;
    $total_not_qualified +=$not_qualified;
    $total_eighteen_mos_sssloan +=$eighteen_mos_sssloan;
    $total_on_process +=$on_process;
    $grand_total +=$total;



    

$header .= <<<EOF
            <tr>
                <td style="text-align:left;"> $branch_name</td>
                <td>$LSORBegin</td>
                <td>$fin_stable</td>
                <td>$app_wc</td>
                <td>$low_cashout</td>
                <td>$existing_loan</td>
                <td>$other_resched_gawad</td>
                <td>$other_sched_gawad</td>
                <td>$sched_applynow</td>
                <td>$ssp_overage</td>
                <td>$lack_requirements</td>
                <td>$undecided</td>
                <td>$refuse_transfer</td>
                <td>$inquired_only</td>
                <td>$new_policy</td>
                <td>$not_goodcondition</td>
                <td>$guardianship</td>
                <td>$plp</td>
                <td>$not_qualified</td>
                <td>$eighteen_mos_sssloan</td>
                <td>$on_process</td>
                <td>$total</td>
            </tr>
        EOF;

        }
        $grandTotal_LSORBegin += $total_LSORBegin;
        $grandTotal_fin_stable  += $total_fin_stable;
        $grandTotal_app_wc  += $total_app_wc;
        $grandTotal_low_cashout  += $total_low_cashout;
        $grandTotal_existing_loan  += $total_existing_loan;
        $grandTotal_other_resched_gawad  += $total_other_resched_gawad;
        $grandTotal_other_sched_gawad  += $total_other_sched_gawad;
        $grandTotal_sched_applynow += $total_sched_applynow;
        $grandTotal_ssp_overage  += $total_ssp_overage;
        $grandTotal_lack_requirements  += $total_lack_requirements;
        $grandTotal_undecided  += $total_undecided;
        $grandTotal_refuse_transfer  += $total_refuse_transfer;
        $grandTotal_inquired_only  += $total_inquired_only;
        $grandTotal_new_policy += $total_new_policy;
        $grandTotal_not_goodcondition  += $total_not_goodcondition;
        $grandTotal_guardianship += $total_guardianship;
        $grandTotal_plp  += $total_plp;
        $grandTotal_not_qualified  += $total_not_qualified;
        $grandTotal_eighteen_mos_sssloan  += $total_eighteen_mos_sssloan;
        $grandTotal_on_process  += $total_on_process;
        $grandTotal_total  += $grand_total;
    $header .= <<<EOF
            <tr>
                <td style="background-color:#A4ACB1;">TOTAL</td>
                <td style="background-color:#A4ACB1;">$total_LSORBegin</td>
                <td style="background-color:#A4ACB1;">$total_fin_stable</td>
                <td style="background-color:#A4ACB1;">$total_app_wc</td>
                <td style="background-color:#A4ACB1;">$total_low_cashout</td>
                <td style="background-color:#A4ACB1;">$total_existing_loan</td>
                <td style="background-color:#A4ACB1;">$total_other_resched_gawad</td>
                <td style="background-color:#A4ACB1;">$total_other_sched_gawad</td>
                <td style="background-color:#A4ACB1;">$total_sched_applynow</td>
                <td style="background-color:#A4ACB1;">$total_ssp_overage</td>
                <td style="background-color:#A4ACB1;">$total_lack_requirements</td>
                <td style="background-color:#A4ACB1;">$total_undecided</td>
                <td style="background-color:#A4ACB1;">$total_refuse_transfer</td>
                <td style="background-color:#A4ACB1;">$total_inquired_only</td>
                <td style="background-color:#A4ACB1;">$total_new_policy</td>
                <td style="background-color:#A4ACB1;">$total_not_goodcondition</td>
                <td style="background-color:#A4ACB1;">$total_guardianship</td>
                <td style="background-color:#A4ACB1;">$total_plp</td>
                <td style="background-color:#A4ACB1;">$total_not_qualified</td>
                <td style="background-color:#A4ACB1;">$total_eighteen_mos_sssloan</td>
                <td style="background-color:#A4ACB1;">$total_on_process</td>
                <td style="background-color:#A4ACB1;">$grand_total</td>
        </tr>   
       
    EOF;

$getELC= $Operation ->ctrGetAllELCBranches();

$total_LSORBegin = 0;
$total_fin_stable = 0;
$total_app_wc = 0;
$total_low_cashout = 0;
$total_existing_loan = 0;
$total_other_resched_gawad = 0;
$total_other_sched_gawad = 0;
$total_sched_applynow= 0;
$total_ssp_overage = 0;
$total_lack_requirements = 0;
$total_undecided = 0;
$total_refuse_transfer = 0;
$total_inquired_only = 0;
$total_new_policy= 0;
$total_not_goodcondition = 0;
$total_guardianship= 0;
$total_plp = 0;
$total_not_qualified = 0;
$total_eighteen_mos_sssloan = 0;
$total_on_process = 0;
$grand_total = 0;
  foreach($getELC as $elc){
    $branch_name = $elc['full_name'];
    $getLSOP = $Operation->ctrGetBeginLSORReport($branch_name, $month);
    if(!empty($getLSOP)){
        foreach($getLSOP as $begin){
            $LSORBegin = $begin['amount'];
        }
    }else{
        $LSORBegin = 0;
    }

    $getLSOR = $Operation->ctrGetAllLSOR($branch_name, $firstDay, $lastDay);
    foreach($getLSOR as $LSOR){
        $fin_stable = $LSOR['fin_stable'];
        $app_wc = $LSOR['app_wc'];
        $low_cashout = $LSOR['low_cashout'];
        $existing_loan = $LSOR['existing_loan'];
        $other_resched_gawad = $LSOR['other_resched_gawad'];
        $other_sched_gawad = $LSOR['other_sched_gawad'];
        $sched_applynow = $LSOR['sched_applynow'];
        $ssp_overage = $LSOR['ssp_overage'];
        $lack_requirements = $LSOR['lack_requirements'];
        $undecided = $LSOR['undecided'];
        $refuse_transfer = $LSOR['refuse_transfer'];
        $inquired_only = $LSOR['inquired_only'];
        $new_policy = $LSOR['new_policy'];
        $not_goodcondition = $LSOR['not_goodcondition'];
        $guardianship = $LSOR['guardianship'];
        $plp = $LSOR['plp'];
        $not_qualified = $LSOR['not_qualified'];
        $eighteen_mos_sssloan = $LSOR['eighteen_mos_sssloan'];
        $on_process = $LSOR['on_process'];
    }

    $fin_stable = $fin_stable ?? 0;
    $app_wc = $app_wc ?? 0;
    $low_cashout = $low_cashout ?? 0;
    $existing_loan = $existing_loan ?? 0;
    $other_resched_gawad = $other_resched_gawad ?? 0;
    $other_sched_gawad = $other_sched_gawad ?? 0;
    $sched_applynow = $sched_applynow ?? 0;
    $ssp_overage = $ssp_overage ?? 0;
    $lack_requirements = $lack_requirements ?? 0;
    $undecided = $undecided ?? 0;
    $refuse_transfer = $refuse_transfer ?? 0;
    $inquired_only = $inquired_only ?? 0;
    $new_policy = $new_policy ?? 0;
    $not_goodcondition = $not_goodcondition ?? 0;
    $guardianship = $guardianship ?? 0;
    $plp = $plp ?? 0;
    $not_qualified = $not_qualified ?? 0;
    $eighteen_mos_sssloan = $eighteen_mos_sssloan ?? 0;
    $on_process = $on_process ?? 0;

    $total = $fin_stable + $app_wc + $low_cashout + $existing_loan + $other_resched_gawad + $other_sched_gawad + $sched_applynow + $ssp_overage + $lack_requirements +
    $undecided + $refuse_transfer + $inquired_only + $new_policy + $not_goodcondition + $guardianship + $plp + $not_qualified + $eighteen_mos_sssloan + $on_process;
    
    $total_LSORBegin +=$LSORBegin;
    $total_fin_stable +=$fin_stable;
    $total_app_wc +=$app_wc;
    $total_low_cashout +=$low_cashout;
    $total_existing_loan +=$existing_loan;
    $total_other_resched_gawad +=$other_resched_gawad;
    $total_other_sched_gawad+=$other_sched_gawad;
    $total_sched_applynow +=$sched_applynow;
    $total_ssp_overage +=$ssp_overage;
    $total_lack_requirements +=$lack_requirements;
    $total_undecided +=$undecided;
    $total_refuse_transfer +=$refuse_transfer;
    $total_inquired_only +=$inquired_only;
    $total_new_policy +=$new_policy;
    $total_not_goodcondition +=$not_goodcondition;
    $total_guardianship +=$guardianship;
    $total_plp +=$plp;
    $total_not_qualified +=$not_qualified;
    $total_eighteen_mos_sssloan +=$eighteen_mos_sssloan;
    $total_on_process +=$on_process;
    $grand_total +=$total;



    

$header .= <<<EOF
            <tr> <td colspan="22" style="color:white;border:none;">d</td></tr>
            <tr>
                <td style="text-align:left;background-color:#A4ACB1;"> $branch_name</td>
                <td>$LSORBegin</td>
                <td>$fin_stable</td>
                <td>$app_wc</td>
                <td>$low_cashout</td>
                <td>$existing_loan</td>
                <td>$other_resched_gawad</td>
                <td>$other_sched_gawad</td>
                <td>$sched_applynow</td>
                <td>$ssp_overage</td>
                <td>$lack_requirements</td>
                <td>$undecided</td>
                <td>$refuse_transfer</td>
                <td>$inquired_only</td>
                <td>$new_policy</td>
                <td>$not_goodcondition</td>
                <td>$guardianship</td>
                <td>$plp</td>
                <td>$not_qualified</td>
                <td>$eighteen_mos_sssloan</td>
                <td>$on_process</td>
                <td>$total</td>
            </tr>
                <tr> <td colspan="22" style="color:white;border:none;">d</td></tr>
        EOF;

        }
        $grandTotal_LSORBegin += $total_LSORBegin;
        $grandTotal_fin_stable  += $total_fin_stable;
        $grandTotal_app_wc  += $total_app_wc;
        $grandTotal_low_cashout  += $total_low_cashout;
        $grandTotal_existing_loan  += $total_existing_loan;
        $grandTotal_other_resched_gawad  += $total_other_resched_gawad;
        $grandTotal_other_sched_gawad  += $total_other_sched_gawad;
        $grandTotal_sched_applynow += $total_sched_applynow;
        $grandTotal_ssp_overage  += $total_ssp_overage;
        $grandTotal_lack_requirements  += $total_lack_requirements;
        $grandTotal_undecided  += $total_undecided;
        $grandTotal_refuse_transfer  += $total_refuse_transfer;
        $grandTotal_inquired_only  += $total_inquired_only;
        $grandTotal_new_policy += $total_new_policy;
        $grandTotal_not_goodcondition  += $total_not_goodcondition;
        $grandTotal_guardianship += $total_guardianship;
        $grandTotal_plp  += $total_plp;
        $grandTotal_not_qualified  += $total_not_qualified;
        $grandTotal_eighteen_mos_sssloan  += $total_eighteen_mos_sssloan;
        $grandTotal_on_process  += $total_on_process;
        $grandTotal_total  += $grand_total;
    $header .= <<<EOF
        <tr style="font-weight: bold;"> 
            <td style="text-align:left;"> GRAND TOTAL</td>
            <td>$grandTotal_LSORBegin</td>
            <td>$grandTotal_fin_stable</td>
            <td>$grandTotal_app_wc</td>
            <td>$grandTotal_low_cashout</td>
            <td>$grandTotal_existing_loan</td>
            <td>$grandTotal_other_resched_gawad</td>
            <td>$grandTotal_other_sched_gawad</td>
            <td>$grandTotal_sched_applynow</td>
            <td>$grandTotal_ssp_overage</td>
            <td>$grandTotal_lack_requirements</td>
            <td>$grandTotal_undecided</td>
            <td>$grandTotal_refuse_transfer</td>
            <td>$grandTotal_inquired_only</td>
            <td>$grandTotal_new_policy</td>
            <td>$grandTotal_not_goodcondition</td>
            <td>$grandTotal_guardianship</td>
            <td>$grandTotal_plp</td>
            <td>$grandTotal_not_qualified</td>
            <td>$grandTotal_eighteen_mos_sssloan</td>
            <td>$grandTotal_on_process</td>
            <td>$grandTotal_total</td>
       </tr> 
       
     
       <tr>
       <td colspan="22" style="border:none;text-align:left;"></td>
       </tr>

       <tr>
       <td colspan="22" style="border:none;text-align:left;">PREPARED BY:</td>
       </tr>

        <tr>
       <td colspan="22" style="border:none;text-align:left;"></td>
       </tr>

       <tr>
       <td colspan="22" style="border:none;text-align:left;font-weight:bold;">GLORY MAE JUTANDO</td>
       </tr>

        </tbody>
      </table>
    EOF;

    $pdf->writeHTML($header, false, false, false, false, '');
    
    $pdf->Output($reportName, 'I');
    
   }
  }  

  $clientsFormRequest = new printClientList();
  $clientsFormRequest -> getClientsPrinting();

?>
