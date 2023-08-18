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

  
$header = <<<EOF

        <h5>EMB & FCH</h5>
        <h5>BRANCH WEEKLY GROSS IN</h5>
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
                <th>WALK IN</th>
                <th>SALES REP</th>
                <th>RETURNEE</th>
                <th>RUNNERS /<br> AGENT</th>
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
    $getEMB = $Operation ->ctrGetAllEMBBranches();
    $grand_totalCumi = 0;
    $grand_totalWalkin = 0;
    $grand_totalSalesrep = 0;
    $grand_totalReturnee = 0;
    $grand_totalRunners = 0;
    $grand_totalTransfer = 0;
    $grand_totalGrossin = 0;
    $grand_totalFinaCumi = 0;
    foreach ($getEMB as $emb) { 
        $branch_name = $emb['full_name'];
        $type = "grossin";
        $get_grossinBal = $Operation ->ctrGetGrossinBal($branch_name, $type);
        if(!empty($get_grossinBal)){
            foreach ($get_grossinBal as $grossinBal){
                $amount = $grossinBal['amount'];
            }
        }else{
            $amount = 0;
        }
            $getGrossinCumi = $Operation->ctrGetGrossinCumi($prev, $branch_name);
            if(!empty($getGrossinCumi)){
            $total_GrossinCumi = $getGrossinCumi[0]['total_cumi'];
            }else{
            $total_GrossinCumi = 0;
            }
            $final_grossinCumi = $amount + $total_GrossinCumi;

        $get_grossinData = $Operation->ctrGetGrossinData($branch_name, $from, $to);

        if(!empty($get_grossinData)){
            foreach($get_grossinData as $gossinData){
                $walkin = $gossinData['walkin'];
                $sales_rep = $gossinData['sales_rep'];
                $returnee = $gossinData['returnee'];
                $runners_agent = $gossinData['runners_agent'];
                $gros_transfer = $gossinData['transfer'];
            }
            if($walkin == 0){
                $walkin = 0; 
            }
            if($sales_rep == 0){
                $sales_rep = 0; 
            }
            if($returnee == 0){
                $returnee = 0; 
            }
            if($runners_agent == 0){
                $runners_agent = 0; 
            }
            if($gros_transfer == 0){
                $gros_transfer = 0; 
            }
        }else{
            $walkin = 0; 
            $sales_rep = 0;
            $returnee = 0;
            $runners_agent = 0;
            $gros_transfer = 0;
        }
        $total_grossin_cumi = $final_grossinCumi + $walkin + $sales_rep + $returnee + $runners_agent + $gros_transfer;
        $total_grossin = $walkin + $sales_rep + $returnee + $runners_agent +  $gros_transfer;

        $new_branch_name = str_replace("EMB", "", $branch_name);
       
        $header .= <<<EOF
            <tr>
            <td style="width: 90px; text-align: left;">&nbsp;&nbsp;$new_branch_name</td>
            <td>$final_grossinCumi</td>
            <td>$walkin</td>
            <td>$sales_rep</td>
            <td>$returnee</td>
            <td>$runners_agent</td>
            <td>$gros_transfer</td>
            <td>$total_grossin</td>
            <td>$total_grossin_cumi</td>
        </tr>
        EOF;
    
    $grand_totalCumi += $final_grossinCumi;
    $grand_totalWalkin += $walkin;
    $grand_totalSalesrep += $sales_rep;
    $grand_totalReturnee += $returnee;
    $grand_totalRunners += $runners_agent;
    $grand_totalTransfer += $gros_transfer;
    $grand_totalGrossin += $total_grossin;
    $grand_totalFinaCumi += $total_grossin_cumi;


}

$header .= <<<EOF
    <tr style=" font-weight: bold;">
        <td>TOTAL</td>
        <td>$grand_totalCumi</td>
        <td>$grand_totalWalkin</td>
        <td>$grand_totalSalesrep</td>
        <td>$grand_totalReturnee</td>
        <td>$grand_totalRunners</td>
        <td>$grand_totalTransfer</td>
        <td>$grand_totalGrossin</td>
        <td>$grand_totalFinaCumi</td>
    </tr>
EOF;

$header .= <<<EOF
      

        <tr><td colspan="9" style="border:none;"></td></tr>
        <tr><td colspan="9" style="border:none;"></td></tr>
        <tr><td colspan="9" style="border:none;"></td></tr>
EOF;
$grand_totalCumi = 0;
$grand_totalWalkin = 0;
$grand_totalSalesrep = 0;
$grand_totalReturnee = 0;
$grand_totalRunners = 0;
$grand_totalTransfer = 0;
$grand_totalGrossin = 0;
$grand_totalFinaCumi = 0;

$getFCH = $Operation ->ctrGetAllFCHBranches();
foreach ($getFCH as $fch) { 
    $branch_name = $fch['full_name'];
    $type = "grossin";
    $get_grossinBal = $Operation ->ctrGetGrossinBal($branch_name, $type);
    if(!empty($get_grossinBal)){
        foreach ($get_grossinBal as $grossinBal){
            $amount = $grossinBal['amount'];
        }
    }else{
        $amount = 0;
    }
        $getGrossinCumi = $Operation->ctrGetGrossinCumi($prev, $branch_name);
        if(!empty($getGrossinCumi)){
        $total_GrossinCumi = $getGrossinCumi[0]['total_cumi'];
        }else{
        $total_GrossinCumi = 0;
        }
        $final_grossinCumi = $amount + $total_GrossinCumi;

    $get_grossinData = $Operation->ctrGetGrossinData($branch_name, $from, $to);

    if(!empty($get_grossinData)){
        foreach($get_grossinData as $gossinData){
            $walkin = $gossinData['walkin'];
            $sales_rep = $gossinData['sales_rep'];
            $returnee = $gossinData['returnee'];
            $runners_agent = $gossinData['runners_agent'];
            $gros_transfer = $gossinData['transfer'];
        }
        if($walkin == 0){
            $walkin = 0; 
        }
        if($sales_rep == 0){
            $sales_rep = 0; 
        }
        if($returnee == 0){
            $returnee = 0; 
        }
        if($runners_agent == 0){
            $runners_agent = 0; 
        }
        if($gros_transfer == 0){
            $gros_transfer = 0; 
        }
    }else{
        $walkin = 0; 
        $sales_rep = 0;
        $returnee = 0;
        $runners_agent = 0;
        $gros_transfer = 0;
    }
    $total_grossin_cumi = $final_grossinCumi + $walkin + $sales_rep + $returnee + $runners_agent + $gros_transfer;
    $total_grossin = $walkin + $sales_rep + $returnee + $runners_agent +  $gros_transfer;
   
    $header .= <<<EOF
        <tr>
             <td style="width: 90px; text-align: left;" >&nbsp;&nbsp;$branch_name</td>
            <td>$final_grossinCumi</td>
            <td>$walkin</td>
            <td>$sales_rep</td>
            <td>$returnee</td>
            <td>$runners_agent</td>
            <td>$gros_transfer</td>
            <td>$total_grossin</td>
            <td>$total_grossin_cumi</td>
        </tr>
    EOF;

$grand_totalCumi += $final_grossinCumi;
$grand_totalWalkin += $walkin;
$grand_totalSalesrep += $sales_rep;
$grand_totalReturnee += $returnee;
$grand_totalRunners += $runners_agent;
$grand_totalTransfer += $gros_transfer;
$grand_totalGrossin += $total_grossin;
$grand_totalFinaCumi += $total_grossin_cumi;


}

$header .= <<<EOF
<tr style=" font-weight: bold;">
    <td>TOTAL</td>
    <td>$grand_totalCumi</td>
    <td>$grand_totalWalkin</td>
    <td>$grand_totalSalesrep</td>
    <td>$grand_totalReturnee</td>
    <td>$grand_totalRunners</td>
    <td>$grand_totalTransfer</td>
    <td>$grand_totalGrossin</td>
    <td>$grand_totalFinaCumi</td>
</tr>
EOF;

$header .= <<<EOF
    </tbody>
</table>
EOF;


$header .= <<<EOF
        <h5 style="color:white;">dfsdfsdfsdfsdfsdf</h5>
       
        <h6>RLC & ELC<br>BRANCH WEEKLY GROSS IN</h6>
        
        <table>
            <thead>
            <tr>
                <th style="text-align: center;width: 90px; vertical-align: middle;font-size:7.9rem;border:1px solid black;padding:5rem;font-weight:bold;" rowspan="2"><span style="color:white;">d</span><br>BRANCH<br><span style="color:white;">ds</span></th>
                <th rowspan="2" style="text-align:center; font-size: 10px;"><span style="color:white;">s</span><br>as of $formatted_prev</th>
                <th style="border:1px solid black;">WALK IN</th>
                <th>SALES REP</th>
                <th>RETURNEE</th>
                <th>RUNNERS /<br> AGENT</th>
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
    $getRLC = $Operation ->ctrGetAllRLCBranches();
    $grand_totalCumi = 0;
    $grand_totalWalkin = 0;
    $grand_totalSalesrep = 0;
    $grand_totalReturnee = 0;
    $grand_totalRunners = 0;
    $grand_totalTransfer = 0;
    $grand_totalGrossin = 0;
    $grand_totalFinaCumi = 0;
    foreach ($getRLC as $rlc) { 
        $branch_name = $rlc['full_name'];
        $type = "grossin";
        $get_grossinBal = $Operation ->ctrGetGrossinBal($branch_name, $type);
        if(!empty($get_grossinBal)){
            foreach ($get_grossinBal as $grossinBal){
                $amount = $grossinBal['amount'];
            }
        }else{
            $amount = 0;
        }
            $getGrossinCumi = $Operation->ctrGetGrossinCumi($prev, $branch_name);
            if(!empty($getGrossinCumi)){
            $total_GrossinCumi = $getGrossinCumi[0]['total_cumi'];
            }else{
            $total_GrossinCumi = 0;
            }
            $final_grossinCumi = $amount + $total_GrossinCumi;

        $get_grossinData = $Operation->ctrGetGrossinData($branch_name, $from, $to);

        if(!empty($get_grossinData)){
            foreach($get_grossinData as $gossinData){
                $walkin = $gossinData['walkin'];
                $sales_rep = $gossinData['sales_rep'];
                $returnee = $gossinData['returnee'];
                $runners_agent = $gossinData['runners_agent'];
                $gros_transfer = $gossinData['transfer'];
            }
            if($walkin == 0){
                $walkin = 0; 
            }
            if($sales_rep == 0){
                $sales_rep = 0; 
            }
            if($returnee == 0){
                $returnee = 0; 
            }
            if($runners_agent == 0){
                $runners_agent = 0; 
            }
            if($gros_transfer == 0){
                $gros_transfer = 0; 
            }
        }else{
            $walkin = 0; 
            $sales_rep = 0;
            $returnee = 0;
            $runners_agent = 0;
            $gros_transfer = 0;
        }
        $total_grossin_cumi = $final_grossinCumi + $walkin + $sales_rep + $returnee + $runners_agent + $gros_transfer;
        $total_grossin = $walkin + $sales_rep + $returnee + $runners_agent +  $gros_transfer;
       
        $header .= <<<EOF
            <tr>
            <td style="width: 90px; text-align: left;" >&nbsp;&nbsp;$branch_name</td>
            <td>$final_grossinCumi</td>
            <td>$walkin</td>
            <td>$sales_rep</td>
            <td>$returnee</td>
            <td>$runners_agent</td>
            <td>$gros_transfer</td>
            <td>$total_grossin</td>
            <td>$total_grossin_cumi</td>
        </tr>
        EOF;
    
    $grand_totalCumi += $final_grossinCumi;
    $grand_totalWalkin += $walkin;
    $grand_totalSalesrep += $sales_rep;
    $grand_totalReturnee += $returnee;
    $grand_totalRunners += $runners_agent;
    $grand_totalTransfer += $gros_transfer;
    $grand_totalGrossin += $total_grossin;
    $grand_totalFinaCumi += $total_grossin_cumi;


}

$header .= <<<EOF
    <tr style=" font-weight: bold;">
        <td>TOTAL</td>
        <td>$grand_totalCumi</td>
        <td>$grand_totalWalkin</td>
        <td>$grand_totalSalesrep</td>
        <td>$grand_totalReturnee</td>
        <td>$grand_totalRunners</td>
        <td>$grand_totalTransfer</td>
        <td>$grand_totalGrossin</td>
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
                <th style="text-align: center;width: 90px; vertical-align: middle;font-size:7.9rem;border:1px solid black;padding:5rem;font-weight:bold;" rowspan="2"><span style="color:white;">d</span><br>BRANCH<br><span style="color:white;">ds</span></th>
                <th rowspan="2" style="text-align:center; font-size: 10px;"><span style="color:white;">s</span><br>as of $formatted_prev</th>
                <th>WALK IN<br></th>
                <th>SALES REP</th>
                <th>RETURNEE</th>
                <th>RUNNERS /<br> AGENT</th>
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
    $grand_totalWalkin = 0;
    $grand_totalSalesrep = 0;
    $grand_totalReturnee = 0;
    $grand_totalRunners = 0;
    $grand_totalTransfer = 0;
    $grand_totalGrossin = 0;
    $grand_totalFinaCumi = 0;
    $getELC = $Operation ->ctrGetAllELCBranches();
    foreach ($getELC as $elc) { 
        $branch_name = $elc['full_name'];
        $type = "grossin";
        $get_grossinBal = $Operation ->ctrGetGrossinBal($branch_name, $type);
        if(!empty($get_grossinBal)){
            foreach ($get_grossinBal as $grossinBal){
                $amount = $grossinBal['amount'];
            }
        }else{
            $amount = 0;
        }
            $getGrossinCumi = $Operation->ctrGetGrossinCumi($prev, $branch_name);
            if(!empty($getGrossinCumi)){
            $total_GrossinCumi = $getGrossinCumi[0]['total_cumi'];
            }else{
            $total_GrossinCumi = 0;
            }
            $final_grossinCumi = $amount + $total_GrossinCumi;

        $get_grossinData = $Operation->ctrGetGrossinData($branch_name, $from, $to);

        if(!empty($get_grossinData)){
            foreach($get_grossinData as $gossinData){
                $walkin = $gossinData['walkin'];
                $sales_rep = $gossinData['sales_rep'];
                $returnee = $gossinData['returnee'];
                $runners_agent = $gossinData['runners_agent'];
                $gros_transfer = $gossinData['transfer'];
            }
            if($walkin == 0){
                $walkin = 0; 
            }
            if($sales_rep == 0){
                $sales_rep = 0; 
            }
            if($returnee == 0){
                $returnee = 0; 
            }
            if($runners_agent == 0){
                $runners_agent = 0; 
            }
            if($gros_transfer == 0){
                $gros_transfer = 0; 
            }
        }else{
            $walkin = 0; 
            $sales_rep = 0;
            $returnee = 0;
            $runners_agent = 0;
            $gros_transfer = 0;
        }
        $total_grossin_cumi = $final_grossinCumi + $walkin + $sales_rep + $returnee + $runners_agent + $gros_transfer;
        $total_grossin = $walkin + $sales_rep + $returnee + $runners_agent +  $gros_transfer;
       
        $header .= <<<EOF
            <tr>
            <td style="width: 90px; text-align: left;" >&nbsp;&nbsp;$branch_name</td>
            <td>$final_grossinCumi</td>
            <td>$walkin</td>
            <td>$sales_rep</td>
            <td>$returnee</td>
            <td>$runners_agent</td>
            <td>$gros_transfer</td>
            <td>$total_grossin</td>
            <td>$total_grossin_cumi</td>
        </tr>
        EOF;
    
    $grand_totalCumi += $final_grossinCumi;
    $grand_totalWalkin += $walkin;
    $grand_totalSalesrep += $sales_rep;
    $grand_totalReturnee += $returnee;
    $grand_totalRunners += $runners_agent;
    $grand_totalTransfer += $gros_transfer;
    $grand_totalGrossin += $total_grossin;
    $grand_totalFinaCumi += $total_grossin_cumi;


}

$header .= <<<EOF
    <tr style=" font-weight: bold;">
        <td>TOTAL</td>
        <td>$grand_totalCumi</td>
        <td>$grand_totalWalkin</td>
        <td>$grand_totalSalesrep</td>
        <td>$grand_totalReturnee</td>
        <td>$grand_totalRunners</td>
        <td>$grand_totalTransfer</td>
        <td>$grand_totalGrossin</td>
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
