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
  $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
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
$pdf->SetMargins(10,10);
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

$reportName = "PDR Performance Summary.pdf";

$Operation = new ControllerOperation();


$from = $_GET['from'];
$to = $_GET['to'];

$formatted_to = date("m/d/Y", strtotime($to));

$prev = date("Y-m-d", strtotime("-1 day", strtotime($from)));

$formatted_prev = date("m/d/Y", strtotime($prev));
$combDate =  strtoupper(date("M d", strtotime($from)) . " - " . date("d", strtotime($to)));

$prev = date("Y-m-d", strtotime("-1 day", strtotime($from)));
    
$header = <<<EOF
        <h5>EMB & FCH</h5>
        <h5>BRANCH WEEKLY OUTGOING ACCOUNTS</h5>
        <h6>FOR THE PERIOD $combDate</h6>
        <style>
            tr,th{
            border:1px solid black;
            font-size:7rem;
            text-align:center;
        }
             tr, td{
            border:1px solid black;
            font-size:6.9rem;
            text-align:center;
        }
        </style>
        <table>
        <thead>
            <tr>
                <th style="text-align: center; width: 90px; vertical-align: middle;font-size:7.9rem;border:1px solid black;padding:5rem;font-weight:bold;" rowspan="2"><span style="color:white;">d</span><br>BRANCH<br><span style="color:white;">ds</span></th>
                <th rowspan="2" style="text-align:center; font-size: 10px;"><span style="color:white;">s</span><br>as of $formatted_prev</th>
                <th style="text-align:center;">FULLY PAID<br></th>
                <th>DECEASED</th>
                <th>GAWAD</th>
                <th>BAD ACCT</th>
                <th>TRANSFER</th>
                <th>TOTAL IN</th>
                <th>CUM. TOTAL</th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th>as of $formatted_to</th>
            </tr>
            <tr><td colspan="9" style="border:none;font-weight:bold;text-align:left;">EMB:</td></tr>
            </thead>
            <tbody>
      
        EOF;
        $grand_totalCumi = 0;
        $grand_totalFully_paid = 0;
        $grand_totalDeceased = 0;
        $grand_totalGawad = 0;
        $grand_totalBadAccounts = 0;
        $grand_totalTransfer = 0;
        $grand_totalOutgoing = 0;
        $grand_totalFinaCumi = 0;
        $getEMB = $Operation ->ctrGetAllEMBBranches();
        foreach ($getEMB as $emb) { 
            $branch_name = $emb['full_name'];
            $type = "outgoing";
            $get_outgoingBal = $Operation ->ctrGetGrossinBal($branch_name, $type);
            if(!empty($get_outgoingBal)){
                foreach ($get_outgoingBal as $outgoingBal){
                    $amount = $outgoingBal['amount'];
                }
            }else{
                $amount = 0;
            }
                $getOutgoingCumi = $Operation->ctrGetOutgoingCumi($prev, $branch_name);
                if(!empty($getOutgoingCumi)){
                $total_OutgoingCumi = $getOutgoingCumi[0]['total_cumi'];
                }else{
                $total_OutgoingCumi = 0;
                }
                $final_outgoingCumi = $amount + $total_OutgoingCumi;

            $get_outgoingData = $Operation->ctrGetOutgoingData($branch_name, $from, $to);

            if(!empty($get_outgoingData)){
                foreach($get_outgoingData as $outgoingData){
                    $fully_paid = $outgoingData['fully_paid'];
                    $deceased = $outgoingData['deceased'];
                    $gawad = $outgoingData['gawad'];
                    $bad_accounts = $outgoingData['bad_accounts'];
                    $transfer = $outgoingData['transfer'];
                }
                if($fully_paid == 0){
                    $fully_paid = 0; 
                }
                if($deceased == 0){
                    $deceased = 0; 
                }
                if($gawad == 0){
                    $gawad = 0; 
                }
                if($bad_accounts == 0){
                    $bad_accounts = 0; 
                }
                if($transfer == 0){
                    $transfer = 0; 
                }
            }else{
                $fully_paid = 0; 
                $deceased = 0;
                $gawad = 0;
                $bad_accounts = 0;
                $transfer = 0;
            }
            $total_outgoing_cumi = $final_outgoingCumi + $fully_paid + $deceased + $gawad + $bad_accounts + $transfer;
            $total_outgoing = $fully_paid + $deceased + $gawad + $bad_accounts + $transfer;

            $new_branch_name = str_replace("EMB", "", $branch_name);
       
        $header .= <<<EOF
            <tr>
            <td style="width: 90px; text-align: left;">&nbsp;&nbsp;$new_branch_name</td>
            <td>$final_outgoingCumi</td>
            <td>$fully_paid</td>
            <td>$deceased</td>
            <td>$gawad</td>
            <td>$bad_accounts</td>
            <td>$transfer</td>
            <td>$total_outgoing</td>
            <td>$total_outgoing_cumi</td>
        </tr>
        EOF;
    
        $grand_totalCumi += $final_outgoingCumi;
        $grand_totalFully_paid+= $fully_paid;
        $grand_totalDeceased += $deceased;
        $grand_totalGawad+= $gawad;
        $grand_totalBadAccounts+= $bad_accounts;
        $grand_totalTransfer += $transfer;
        $grand_totalOutgoing+= $total_outgoing;
        $grand_totalFinaCumi += $total_outgoing_cumi;


}

$header .= <<<EOF
        <tr style=" font-weight: bold;">
            <td>TOTAL</td>
            <td>$grand_totalCumi</td>
            <td>$grand_totalFully_paid</td>
            <td>$grand_totalDeceased</td>
            <td>$grand_totalGawad</td>
            <td>$grand_totalBadAccounts</td>
            <td>$grand_totalTransfer</td>
            <td>$grand_totalOutgoing</td>
            <td>$grand_totalFinaCumi</td>
        </tr>
      
EOF;

$header .= <<<EOF
<tr><td colspan="9" style="border:none;"></td></tr>
<tr><td colspan="9" style="border:none;"></td></tr>
<tr><td colspan="9" style="border:none;"></td></tr>
EOF;

$grand_totalCumi = 0;
$grand_totalFully_paid = 0;
$grand_totalDeceased = 0;
$grand_totalGawad = 0;
$grand_totalBadAccounts = 0;
$grand_totalTransfer = 0;
$grand_totalOutgoing = 0;
$grand_totalFinaCumi = 0;
$getFCH = $Operation ->ctrGetAllFCHBranches();
foreach ($getFCH as $fch) { 
    $branch_name = $fch['full_name'];
    $type = "outgoing";
    $get_outgoingBal = $Operation ->ctrGetGrossinBal($branch_name, $type);
    if(!empty($get_outgoingBal)){
        foreach ($get_outgoingBal as $outgoingBal){
            $amount = $outgoingBal['amount'];
        }
    }else{
        $amount = 0;
    }
        $getOutgoingCumi = $Operation->ctrGetOutgoingCumi($prev, $branch_name);
        if(!empty($getOutgoingCumi)){
        $total_OutgoingCumi = $getOutgoingCumi[0]['total_cumi'];
        }else{
        $total_OutgoingCumi = 0;
        }
        $final_outgoingCumi = $amount + $total_OutgoingCumi;

    $get_outgoingData = $Operation->ctrGetOutgoingData($branch_name, $from, $to);

    if(!empty($get_outgoingData)){
        foreach($get_outgoingData as $outgoingData){
            $fully_paid = $outgoingData['fully_paid'];
            $deceased = $outgoingData['deceased'];
            $gawad = $outgoingData['gawad'];
            $bad_accounts = $outgoingData['bad_accounts'];
            $transfer = $outgoingData['transfer'];
        }
        if($fully_paid == 0){
            $fully_paid = 0; 
        }
        if($deceased == 0){
            $deceased = 0; 
        }
        if($gawad == 0){
            $gawad = 0; 
        }
        if($bad_accounts == 0){
            $bad_accounts = 0; 
        }
        if($transfer == 0){
            $transfer = 0; 
        }
    }else{
        $fully_paid = 0; 
        $deceased = 0;
        $gawad = 0;
        $bad_accounts = 0;
        $transfer = 0;
    }
    $total_outgoing_cumi = $final_outgoingCumi + $fully_paid + $deceased + $gawad + $bad_accounts + $transfer;
    $total_outgoing = $fully_paid + $deceased + $gawad + $bad_accounts + $transfer;

$header .= <<<EOF
    <tr>
    <td style="width: 90px; text-align: left;" >&nbsp;&nbsp;$branch_name</td>
    <td>$final_outgoingCumi</td>
    <td>$fully_paid</td>
    <td>$deceased</td>
    <td>$gawad</td>
    <td>$bad_accounts</td>
    <td>$transfer</td>
    <td>$total_outgoing</td>
    <td>$total_outgoing_cumi</td>
</tr>
EOF;

$grand_totalCumi += $final_outgoingCumi;
$grand_totalFully_paid+= $fully_paid;
$grand_totalDeceased += $deceased;
$grand_totalGawad+= $gawad;
$grand_totalBadAccounts+= $bad_accounts;
$grand_totalTransfer += $transfer;
$grand_totalOutgoing+= $total_outgoing;
$grand_totalFinaCumi += $total_outgoing_cumi;


}

$header .= <<<EOF
<tr style=" font-weight: bold;">
    <td>TOTAL</td>
    <td>$grand_totalCumi</td>
    <td>$grand_totalFully_paid</td>
    <td>$grand_totalDeceased</td>
    <td>$grand_totalGawad</td>
    <td>$grand_totalBadAccounts</td>
    <td>$grand_totalTransfer</td>
    <td>$grand_totalOutgoing</td>
    <td>$grand_totalFinaCumi</td>
</tr>


EOF;

$header .= <<<EOF
</tbody>
</table>
EOF;

$header .= <<<EOF
        <h5 style="color:white;">dfsdfsdfsdfsdfsdf</h5>
        <h6>RLC & ELC<br>BRANCH WEEKLY OUTGOING ACCOUNTS</h6>
        <table>
            <thead>
            <tr>
                <th style="text-align: center; width: 90px; vertical-align: middle;font-size:7.9rem;border:1px solid black;padding:5rem;font-weight:bold;" rowspan="2"><span style="color:white;">d</span><br>BRANCH<br><span style="color:white;">ds</span></th>
                <th rowspan="2" style="text-align:center; font-size: 10px;"><span style="color:white;">s</span><br>as of $formatted_prev</th>
                <th>FULLY PAID <br></th>
                <th>DECEASED</th>
                <th>GAWAD</th>
                <th>BAD ACCT</th>
                <th>TRANSFER</th>
                <th>TOTAL IN</th>
                <th>CUM. TOTAL</th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th>as of $formatted_to</th>
            </tr>
        </thead>
        <tbody>
        EOF;
        $grand_totalCumi = 0;
        $grand_totalFully_paid = 0;
        $grand_totalDeceased = 0;
        $grand_totalGawad = 0;
        $grand_totalBadAccounts = 0;
        $grand_totalTransfer = 0;
        $grand_totalOutgoing = 0;
        $grand_totalFinaCumi = 0;
        $getRLC = $Operation ->ctrGetAllRLCBranches();
        foreach ($getRLC as $rlc) { 
            $branch_name = $rlc['full_name'];
            $type = "outgoing";
            $get_outgoingBal = $Operation ->ctrGetGrossinBal($branch_name, $type);
            if(!empty($get_outgoingBal)){
                foreach ($get_outgoingBal as $outgoingBal){
                    $amount = $outgoingBal['amount'];
                }
            }else{
                $amount = 0;
            }
                $getOutgoingCumi = $Operation->ctrGetOutgoingCumi($prev, $branch_name);
                if(!empty($getOutgoingCumi)){
                $total_OutgoingCumi = $getOutgoingCumi[0]['total_cumi'];
                }else{
                $total_OutgoingCumi = 0;
                }
                $final_outgoingCumi = $amount + $total_OutgoingCumi;

            $get_outgoingData = $Operation->ctrGetOutgoingData($branch_name, $from, $to);

            if(!empty($get_outgoingData)){
                foreach($get_outgoingData as $outgoingData){
                    $fully_paid = $outgoingData['fully_paid'];
                    $deceased = $outgoingData['deceased'];
                    $gawad = $outgoingData['gawad'];
                    $bad_accounts = $outgoingData['bad_accounts'];
                    $transfer = $outgoingData['transfer'];
                }
                if($fully_paid == 0){
                    $fully_paid = 0; 
                }
                if($deceased == 0){
                    $deceased = 0; 
                }
                if($gawad == 0){
                    $gawad = 0; 
                }
                if($bad_accounts == 0){
                    $bad_accounts = 0; 
                }
                if($transfer == 0){
                    $transfer = 0; 
                }
            }else{
                $fully_paid = 0; 
                $deceased = 0;
                $gawad = 0;
                $bad_accounts = 0;
                $transfer = 0;
            }
            $total_outgoing_cumi = $final_outgoingCumi + $fully_paid + $deceased + $gawad + $bad_accounts + $transfer;
            $total_outgoing = $fully_paid + $deceased + $gawad + $bad_accounts + $transfer;
       
        $header .= <<<EOF
            <tr>
            <td style="width: 90px; text-align: left;" >&nbsp;&nbsp;$branch_name</td>
            <td>$final_outgoingCumi</td>
            <td>$fully_paid</td>
            <td>$deceased</td>
            <td>$gawad</td>
            <td>$bad_accounts</td>
            <td>$transfer</td>
            <td>$total_outgoing</td>
            <td>$total_outgoing_cumi</td>
        </tr>
        EOF;
    
        $grand_totalCumi += $final_outgoingCumi;
        $grand_totalFully_paid+= $fully_paid;
        $grand_totalDeceased += $deceased;
        $grand_totalGawad+= $gawad;
        $grand_totalBadAccounts+= $bad_accounts;
        $grand_totalTransfer += $transfer;
        $grand_totalOutgoing+= $total_outgoing;
        $grand_totalFinaCumi += $total_outgoing_cumi;


}

$header .= <<<EOF
        <tr style=" font-weight: bold;">
            <td>TOTAL</td>
            <td>$grand_totalCumi</td>
            <td>$grand_totalFully_paid</td>
            <td>$grand_totalDeceased</td>
            <td>$grand_totalGawad</td>
            <td>$grand_totalBadAccounts</td>
            <td>$grand_totalTransfer</td>
            <td>$grand_totalOutgoing</td>
            <td>$grand_totalFinaCumi</td>
        </tr>
EOF;

$header .= <<<EOF
        <tr>
            <td colspan="9" style="border:none;"></td>
          
        </tr>

        </tbody>
        </table>
EOF;

$header .= <<<EOF
        <table>
            <thead>
            <tr>
                <th style="text-align: center; width: 90px; vertical-align: middle;font-size:7.9rem;border:1px solid black;padding:5rem;font-weight:bold;" rowspan="2"><span style="color:white;">d</span><br>BRANCH<br><span style="color:white;">ds</span></th>
                <th rowspan="2" style="text-align:center; font-size: 10px;"><span style="color:white;">s</span><br>as of $formatted_prev</th>
                <th>FULLY PAID<br></th>
                <th>DECEASED</th>
                <th>GAWAD</th>
                <th>BAD ACCT</th>
                <th>TRANSFER</th>
                <th>TOTAL IN</th>
                <th>CUM. TOTAL</th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th>as of $formatted_to</th>
            </tr>
        </thead>
        <tbody>
        EOF;
        $grand_totalCumi = 0;
        $grand_totalFully_paid = 0;
        $grand_totalDeceased = 0;
        $grand_totalGawad = 0;
        $grand_totalBadAccounts = 0;
        $grand_totalTransfer = 0;
        $grand_totalOutgoing = 0;
        $grand_totalFinaCumi = 0;
        $getELC = $Operation ->ctrGetAllELCBranches();
        foreach ($getELC as $elc) { 
            $branch_name = $elc['full_name'];
            $type = "outgoing";
            $get_outgoingBal = $Operation ->ctrGetGrossinBal($branch_name, $type);
            if(!empty($get_outgoingBal)){
                foreach ($get_outgoingBal as $outgoingBal){
                    $amount = $outgoingBal['amount'];
                }
            }else{
                $amount = 0;
            }
                $getOutgoingCumi = $Operation->ctrGetOutgoingCumi($prev, $branch_name);
                if(!empty($getOutgoingCumi)){
                $total_OutgoingCumi = $getOutgoingCumi[0]['total_cumi'];
                }else{
                $total_OutgoingCumi = 0;
                }
                $final_outgoingCumi = $amount + $total_OutgoingCumi;

            $get_outgoingData = $Operation->ctrGetOutgoingData($branch_name, $from, $to);

            if(!empty($get_outgoingData)){
                foreach($get_outgoingData as $outgoingData){
                    $fully_paid = $outgoingData['fully_paid'];
                    $deceased = $outgoingData['deceased'];
                    $gawad = $outgoingData['gawad'];
                    $bad_accounts = $outgoingData['bad_accounts'];
                    $transfer = $outgoingData['transfer'];
                }
                if($fully_paid == 0){
                    $fully_paid = 0; 
                }
                if($deceased == 0){
                    $deceased = 0; 
                }
                if($gawad == 0){
                    $gawad = 0; 
                }
                if($bad_accounts == 0){
                    $bad_accounts = 0; 
                }
                if($transfer == 0){
                    $transfer = 0; 
                }
            }else{
                $fully_paid = 0; 
                $deceased = 0;
                $gawad = 0;
                $bad_accounts = 0;
                $transfer = 0;
            }
            $total_outgoing_cumi = $final_outgoingCumi + $fully_paid + $deceased + $gawad + $bad_accounts + $transfer;
            $total_outgoing = $fully_paid + $deceased + $gawad + $bad_accounts + $transfer;
       
        $header .= <<<EOF
            <tr>
            <td style="width: 90px; text-align: left;" >&nbsp;&nbsp;$branch_name</td>
            <td>$final_outgoingCumi</td>
            <td>$fully_paid</td>
            <td>$deceased</td>
            <td>$gawad</td>
            <td>$bad_accounts</td>
            <td>$transfer</td>
            <td>$total_outgoing</td>
            <td>$total_outgoing_cumi</td>
        </tr>
        EOF;
    
        $grand_totalCumi += $final_outgoingCumi;
        $grand_totalFully_paid+= $fully_paid;
        $grand_totalDeceased += $deceased;
        $grand_totalGawad+= $gawad;
        $grand_totalBadAccounts+= $bad_accounts;
        $grand_totalTransfer += $transfer;
        $grand_totalOutgoing+= $total_outgoing;
        $grand_totalFinaCumi += $total_outgoing_cumi;


}

$header .= <<<EOF
        <tr style=" font-weight: bold;">
            <td>TOTAL</td>
            <td>$grand_totalCumi</td>
            <td>$grand_totalFully_paid</td>
            <td>$grand_totalDeceased</td>
            <td>$grand_totalGawad</td>
            <td>$grand_totalBadAccounts</td>
            <td>$grand_totalTransfer</td>
            <td>$grand_totalOutgoing</td>
            <td>$grand_totalFinaCumi</td>
        </tr>
EOF;

$header .= <<<EOF
      
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
