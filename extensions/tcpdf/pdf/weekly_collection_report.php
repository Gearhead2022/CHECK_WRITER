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
$pdf->SetMargins(5,5);
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



$weekfrom = $_GET['weekfrom'];
$weekto = $_GET['weekto'];


$startDate = new DateTime($weekfrom);
$endDate = new DateTime($weekto);

$currentDate = clone $startDate;

$date = date('Y-m', strtotime($weekfrom));
$month = date('F', strtotime($weekfrom));
$month = strtoupper($month);
$dateRange = array();


$startFormatted = $startDate->format('F j');
$endFormatted = $endDate->format('j, Y');

$combinedDates1 = $startFormatted . '-' . $endFormatted;
$combinedDates1 = strtoupper($combinedDates1);

$reportName = "Weekly_PDR_Collection_".$combinedDates1 . ".pdf";


while ($currentDate <= $endDate) {
    $dateRange[] = $currentDate->format('Y-m-d');
    $currentDate->modify('+1 day');
 }
 $day1 = isset($dateRange[0]) ? $dateRange[0] : 0;
 $day2 = isset($dateRange[1]) ? $dateRange[1] : 0;
 $day3 = isset($dateRange[2]) ? $dateRange[2] : 0;
 $day4 = isset($dateRange[3]) ? $dateRange[3] : 0;
 $day5 = isset($dateRange[4]) ? $dateRange[4] : 0;

 $day1_param = isset($dateRange[0]) ? $dateRange[0] : 0;
 $day2_param = isset($dateRange[1]) ? $dateRange[1] : 0;
 $day3_param = isset($dateRange[2]) ? $dateRange[2] : 0;
 $day4_param = isset($dateRange[3]) ? $dateRange[3] : 0;
 $day5_param = isset($dateRange[4]) ? $dateRange[4] : 0;

 $formatted_day1 = ($day1 > 0) ? (new DateTime($day1))->format('F d') : null;
 $formatted_day2 = ($day2 > 0) ? (new DateTime($day2))->format('F d') : null;
 $formatted_day3 = ($day3 > 0) ? (new DateTime($day3))->format('F d') : null;
 $formatted_day4 = ($day4 > 0) ? (new DateTime($day4))->format('F d') : null;
 $formatted_day5 = ($day5 > 0) ? (new DateTime($day5))->format('F d') : null;

    $formatted_day1 = strtoupper($formatted_day1);
    $formatted_day2 = strtoupper($formatted_day2);
    $formatted_day3 = strtoupper($formatted_day3);
    $formatted_day4 = strtoupper($formatted_day4);
    $formatted_day5 = strtoupper($formatted_day5);

    $dataRange = $dateRange;

        $minDate = min($dataRange);
        $yearMonth = substr($minDate, 0, 7); // Extract the year and month from the minimum date

        $startDate = new DateTime($yearMonth . '-01'); // Set the start date to the first day of the same year and month as the minimum date
        $endDate = new DateTime($minDate);
        $endDate->modify('-1 day'); // Set the end date to 1 day before the minimum date

        $Range = array();

        while ($startDate <= $endDate) {
            $formattedDate = $startDate->format('Y-m-d');
            if (!in_array($formattedDate, $dataRange)) {
                $Range[] = $formattedDate;
            }
            $startDate->modify('+1 day'); // Increment the start date by 1 day
        }

        if (empty($Range)) {

            $timestamp = strtotime($weekfrom . ' -1 month');
 
               // Get the first day of the previous month
               $minRange = date('Y-m-01', $timestamp);
 
               // Get the last day of the previous month
             $maxRange = date('Y-m-t', $timestamp);
          
       }else{
  
          $minRange = min($Range);
          $maxRange = max($Range);
        }

        $date1 = date('F j', strtotime($minRange));
        $date2 = date('j', strtotime($maxRange));

        $dateRef = date('d', strtotime($weekfrom));      
    
        if($dateRef == '01'){  
            $date3 = date('F', strtotime($weekfrom));   
            $combinedDates = $date3;  
            $minRange = $day1;
        }elseif($dateRef == '02'){
            $combinedDates = $date1;    
         
        }else{
            $combinedDates = $date1 . '-' . $date2;
        }

// $Range now contains all the missing dates less than the minimum date in $dataRange within the same year and month, with the same date format 'Y-m-d'

// $dateFrom = $_GET['dateFrom'];
// $dateTo = $_GET['dateTo'];
// $selectedValue = $_GET['selectedValue'];
// $startDateFormatted = date('Ymd', strtotime($dateFrom));
// $dateTotDateFormatted = date('Ymd', strtotime($dateTo));


// $table = "fully_paid";
$data = (new ControllerPastdue)->ctrShowEMBBranches();
$dataFCH = (new ControllerPastdue)->ctrShowFCHBranches();
$dataRLC = (new ControllerPastdue)->ctrShowRLCBranches();
$dataELC = (new ControllerPastdue)->ctrShowELCBranches();
$data1 = [
    [
        'id' => 58,
        0 => 58,
        'user_id' => 'UI00058',
        1 => 'UI00058'
    ]
];

if ($day5_param > 0) {
    $colspan = '1017px';
}elseif ($day4_param > 0) {
    $colspan = '962PX';
}elseif($day3_param > 0){
    $colspan = '911px';
}elseif($day2_param > 0){
    $colspan = '863PX';
}elseif($day1_param > 0){
    $colspan = '821PX';
}


foreach ($data1 as &$item) {
   
    $header = <<<EOF
 
    <style>
        table, tr, th {
            font-size: 6.5rem;
            border: 1px solid black;
        }
    </style>
    <table style="border-bottom: 1px solid white;">
    <tr>
        <th  style="text-align:center; width:$colspan;">WEEKLY PDR COLLECTION REPORT</th>
    </tr>

    <tr>
        <th  style="text-align: center; text-transform:uppercase; width:$colspan;">$combinedDates1</th>
    </tr>
    </table>
    
    <table style="border-bottom: 1px solid white;">
       
     
        
        <tr>
            <th style="text-align:center;width:95px;">EMB BRANCHES</th>
            <th style="text-align:center; color:red;">BRANCH</th>
            <th></th>
EOF;
// Check and add the formatted day headers only if they are not null
if ($day1_param > 0) {
    $header .= '<th style="width:70px;"></th>';

}
if ($day2_param > 0) {
    $header .= '<th style="width:70px;"></th>';
}
if ($day3_param > 0) {
    $header .= '<th style="width:70px;"></th>';
}
if ($day4_param > 0) {
    $header .= '<th style="width:70px;"></th>';
}
if ($day5_param > 0) {
    $header .= '<th style="width:70px;"></th>';
}

$header .= <<<EOF
            <th style="width:79px"></th>
            <th colspan="3" style="text-align:center;width:323px;">CLASSIFICATION OF PDR PAYMENT PER ENDORSEMENT DATE</th>
        </tr>
    
        <tr>
            <th></th>
            <th style="text-align:center;color:red;">TARGETS FOR $month</th>
            <th style="text-align:center;">CUM AS OF $combinedDates</th>
EOF;

// Check and add the formatted day headers only if they are not null
if ($day1_param > 0) {
    $header .= '<th style="text-align:center;width:70px;">' . $formatted_day1 . '</th>';
}
if ($day2_param > 0) {
    $header .= '<th style="text-align:center;width:70px;">' . $formatted_day2 . '</th>';
}
if ($day3_param > 0) {
    $header .= '<th style="text-align:center;width:70px;">' . $formatted_day3 . '</th>';
}
if ($day4_param > 0) {
    $header .= '<th style="text-align:center;width:70px;">' . $formatted_day4 . '</th>';
}
if ($day5_param > 0) {
    $header .= '<th style="text-align:center;width:70px;">' . $formatted_day5 . '</th>';
}

$header .= <<<EOF
        <th style="text-align:center;width:79px;">TOTAL</th>
        <th style="text-align:center;font-size:6.1rem;">BELOW 6 MONTHS</th>
        <th style="text-align:center;font-size:6.1rem;">6 MONTHS 1 YEAR</th>
        <th style="font-size:6.1rem;text-align:center;">1 YEAR AND ABOVE</th>
    </tr>
    
    
EOF;


    if($date != ""){

$footer_totalTarget=0;
$footer_totalCumi=0;
$footer_totalDay1=0;
$footer_totalDay2=0;
$footer_totalDay3=0;
$footer_totalDay4=0;
$footer_totalDay5=0;
$footer_totalTotal=0;
$footer_totalBelow6=0;
$footer_total6And1=0;
$footer_totalAbove1=0;

$grandTotal_Target=0;
$grandTotal_Cumi=0;
$grandTotal_Day1=0;
$grandTotal_Day2=0;
$grandTotal_Day3=0;
$grandTotal_Day4=0;
$grandTotal_Day5=0;
$grandTotal_Total=0;
$grandTotal_Below6=0;
$grandTotal_6And1=0;
$grandTotal_Above1=0;

foreach ($data as &$item1) {
    $full_name = $item1['full_name'];

    $getTarget = (new ControllerPastdue)->ctrShowReportTarget($full_name, $date);

    if ($day1_param > 0) {
        $getDay1 = (new ControllerPastdue)->ctrGetDay1($full_name, $day1);
    } else {
        $getDay1 = "";
    }
    if ($day2_param > 0) {
        $getDay2 = (new ControllerPastdue)->ctrGetDay2($full_name, $day2);
    } else {
        $getDay2 = "";
    }
    if ($day3_param > 0) {
        $getDay3 = (new ControllerPastdue)->ctrGetDay3($full_name, $day3);
    } else {
        $getDay3 = "";
    }
    if ($day4_param > 0) {
        $getDay4 = (new ControllerPastdue)->ctrGetDay3($full_name, $day4);
    } else {
        $getDay4 = "";
    }
    if ($day5_param > 0) {
        $getDay5 = (new ControllerPastdue)->ctrGetDay3($full_name, $day5);
    } else {
        $getDay5 = "";
    }

    if ($day5_param > 0) {
       $day5 = $day5;
    }elseif($day4_param > 0) {
        $day5 = $day4;
    }elseif($day3_param > 0) {
        $day5 = $day3;
    }elseif($day2_param > 0) {
        $day5 = $day2;
    }elseif($day1_param > 0) {
        $day5 = $day1;
    }
    
    $getBelow6 = (new ControllerPastdue)->ctrGetBelow6($full_name, $minRange, $day5);
    $getBelow6And1 = (new ControllerPastdue)->ctrGet6And1year($full_name, $minRange, $day5);
    $getAbove1 = (new ControllerPastdue)->ctrGetAbove1($full_name, $minRange, $day5);

 
    $dateRef = date('d', strtotime($weekfrom));      
            
    if($dateRef == '01'){  
        $getCumTotal =  0;                       
     
    }else{
        
        $getCumTotal =  (new ControllerPastdue)->ctrGetCumTotal($full_name, $minRange, $maxRange);
    }
    if(!empty($getTarget)){
        foreach ($getTarget as $key => $value) {
            $amount1 = $value['amount'];
            $amount = number_format((float)$amount1, 2, '.', ',');
            $footer_totalTarget +=  $amount1;
            # code...
        }
    }else{
        $amount ="&#9;-";
    }

    if(!empty($getDay1)){
        foreach ($getDay1 as $key => $value1) {
            $day1_total1  = $value1['total_day1'];
            $total_debit1  = $value1['total_debit1'];

            if($total_debit1 !=""){
                $day1_total1 = $day1_total1 + $total_debit1;
            }
            if($day1_total1 !=""){
                $day1_total = number_format((float)$day1_total1, 2, '.', ',');
                $footer_totalDay1 += $day1_total1;
            }else{

                $day1_total ="";
                $day1_total1 = 0;
            }
        }
    }else{
        $day1_total =""; 
        $day1_total1 = 0;
    }

    if(!empty($getDay2)){
        foreach ($getDay2 as $key => $value2) {
            $day2_total2  = $value2['total_day1'];
            $total_debit1  = $value2['total_debit1'];

            if($total_debit1 !=""){
                $day2_total2 = $day2_total2 + $total_debit1;
            }
            if($day2_total2 !=""){
                $day2_total = number_format((float)$day2_total2, 2, '.', ',');
                $footer_totalDay2 += $day2_total2;
            }else{

                $day2_total ="";
                $day2_total2 = 0;
            }
        }
    }else{
        $day2_total =""; 
        $day2_total2 = 0;
    }

    if(!empty($getDay3)){
        foreach ($getDay3 as $key => $value3) {
            $day3_total3  = $value3['total_day1'];
            $total_debit1  = $value3['total_debit1'];

            if($total_debit1 !=""){
                $day3_total3 = $day3_total3 + $total_debit1;
            }
            if($day3_total3 !=""){
                $day3_total = number_format((float)$day3_total3, 2, '.', ',');
                $footer_totalDay3 += $day3_total3;
            }else{

                $day3_total ="";
                $day3_total3 = 0;
            }
        }
    }else{
        $day3_total ="";
        $day3_total3 = 0; 
    }

    if(!empty($getDay4)){
        foreach ($getDay4 as $key => $value4) {
            $day4_total4  = $value4['total_day1'];
            $total_debit1  = $value4['total_debit1'];

            if($total_debit1 !=""){
                $day4_total4 = $day4_total4 + $total_debit1;
            }
            if($day4_total4 !=""){
                $day4_total = number_format((float)$day4_total4, 2, '.', ',');
                $footer_totalDay4 += $day4_total4;
            }else{

                $day4_total ="";
                $day4_total4 = 0; 
            }
        }
    }else{
        $day4_total =""; 
        $day4_total4 = 0; 
    }

    if(!empty($getDay5)){
        foreach ($getDay5 as $key => $value5) {
            $day5_total5  = $value5['total_day1'];
            $total_debit1  = $value5['total_debit1'];

            if($total_debit1 !=""){
                $day5_total5 = $day5_total5 + $total_debit1;
            }
            if($day5_total5 !=""){
                $day5_total = number_format((float)$day5_total5, 2, '.', ',');
                $footer_totalDay5 += $day5_total5;
            }else{

                $day5_total ="";
                $day5_total5 = 0;
            }
        }
    }else{
        $day5_total =""; 
        $day5_total5 = 0;
    }

    

    
    if(!empty($getBelow6)){
        foreach ($getBelow6 as $key => $row) {
            $below6  = $row['total_below6'];
            $total_debit1  = $row['total_debit1'];

            if($total_debit1 !=""){
                $below6 = $below6 + $total_debit1;
            }
        
            if($below6 !=0){
                $total_below6 = number_format((float)$below6, 2, '.', ',');
                $footer_totalBelow6 += $below6;
            }else{

                $total_below6 ="";
            }
        }
    }else{
        $total_below6 =""; 
    }


    if(!empty($getBelow6And1)){
        foreach ($getBelow6And1 as $key => $row1) {
            $below6And1  = $row1['total_below6and1'];
            $total_debit1  = $row1['total_debit1'];
            if($total_debit1 !=""){
                $below6And1 = $below6And1 + $total_debit1;
            }

            if($below6And1 !=0){
                $total_below6And1 = number_format((float)$below6And1, 2, '.', ',');
                $footer_total6And1 += $below6And1;
            }else{

                $total_below6And1 ="";
            }
        }
    }else{
        $total_below6And1 =""; 
    }


    if(!empty($getAbove1)){
        foreach ($getAbove1 as $key => $row2) {
            $above1  = $row2['total_above1'];
            $total_debit1  = $row2['total_debit1'];
            if($total_debit1 !=""){
                $above1 = $above1 + $total_debit1;
            }
            if($above1 !=0){
                $total_belowAbove1 = number_format((float)$above1, 2, '.', ',');
                $footer_totalAbove1 += $above1;
            }else{

                $total_belowAbove1 ="";
            }
        }
    }else{
        $total_belowAbove1 =""; 
    }
    
    if(!empty($getCumTotal)){
        foreach ($getCumTotal as $key => $row3) {
            $totalCumi1  = $row3['total'];
            $total_debit  = $row3['total_debit'];
            if($total_debit !=""){
                $totalCumi1= $totalCumi1 + $total_debit;
            }

            if($totalCumi1 !=""){
                $totalCumi = number_format((float)$totalCumi1, 2, '.', ',');
                $footer_totalCumi += $totalCumi1;
            }else{

                $totalCumi =" - ";
                $totalCumi1 = 0; 
            }
        }
    }else{
        $totalCumi =" - "; 
        $totalCumi1 = 0;
    }

    $total1 = $day1_total1 + $day2_total2 + $day3_total3 +$day4_total4 +$day5_total5 + $totalCumi1;
            $footer_totalTotal += $total1;
            if($total1 !=0){
                $total = number_format((float)$total1, 2, '.', ',');
            }else{
                $total = "";
            }
          

            $full_name1 = str_replace("EMB", "", "$full_name");
  
    $header .= <<<EOF

    
    <tr style="border:1px solid black;">
        <td style="border:1px solid black;width:95px; text-align: center;">$full_name1</td>
        <td style="border:1px solid black;color:red; text-align: right;">$amount</td>
        <td style="border:1px solid black; text-align: right;">$totalCumi</td>
    EOF;
        // Check and add the formatted day headers only if they are not null
        if ($day1_param > 0) {
            $header .= '<td style="border:1px solid black;">'.$day1_total.'</td>';
        }
        if ($day2_param > 0) {
            $header .= '<td style="border:1px solid black;">'.$day2_total.'</td>';
        }
        if ($day3_param > 0) {
            $header .= '<td style="border:1px solid black;">'.$day3_total.'</td>';
        }
        if ($day4_param > 0) {
            $header .= '<td style="border:1px solid black;">'.$day4_total.'</td>';
        }
        if ($day5_param > 0) {
            $header .= '<td style="border:1px solid black;">'.$day5_total.'</td>';
        }
        
    $header .= <<<EOF
        <td style="border:1px solid black; text-align: right;">$total</td>
        <td style="border:1px solid black; text-align: right;">$total_below6</td>
        <td style="border:1px solid black; text-align: right;">$total_below6And1</td>
        <td style="border:1px solid black; text-align: right;">$total_belowAbove1</td>
  </tr>

EOF;
}
}

$grandTotal_Target += $footer_totalTarget;
$grandTotal_Cumi += $footer_totalCumi;
$grandTotal_Day1 += $footer_totalDay1;
$grandTotal_Day2 += $footer_totalDay2;
$grandTotal_Day3 += $footer_totalDay3;
$grandTotal_Day4 += $footer_totalDay4;
$grandTotal_Day5 += $footer_totalDay5;
$grandTotal_Total += $footer_totalTotal;
$grandTotal_Below6 += $footer_totalBelow6;
$grandTotal_6And1 += $footer_total6And1;
$grandTotal_Above1 += $footer_totalAbove1;

if($footer_totalCumi != 0){
    $footer_totalCumi1 = number_format((float)$footer_totalCumi, 2, '.', ',');
}else{
    $footer_totalCumi1 = "-";
}
if($footer_totalDay1 != 0){
    $footer_totalDay11 = number_format((float)$footer_totalDay1, 2, '.', ',');
}else{
    $footer_totalDay11 = "-";
}
if($footer_totalDay2 != 0){
    $footer_totalDay22 = number_format((float)$footer_totalDay2, 2, '.', ',');
}else{
    $footer_totalDay22 = "-";
}
if($footer_totalDay3 != 0){
    $footer_totalDay33 = number_format((float)$footer_totalDay3, 2, '.', ',');
}else{
    $footer_totalDay33 = "-";
}

if($footer_totalDay4 != 0){
    $footer_totalDay44 = number_format((float)$footer_totalDay4, 2, '.', ',');
}else{
    $footer_totalDay44 = "-";
}

if($footer_totalDay5 != 0){
    $footer_totalDay55 = number_format((float)$footer_totalDay5, 2, '.', ',');
}else{
    $footer_totalDay55 = "-";
}
if($footer_totalTotal != 0){
    $footer_totalTotal1 = number_format((float)$footer_totalTotal, 2, '.', ',');
}else{
    $footer_totalTotal1 = "-";
}
if($footer_totalBelow6 != 0){
    $footer_totalBelow66 = number_format((float)$footer_totalBelow6, 2, '.', ',');
}else{
    $footer_totalBelow66 = "-";
}
if($footer_total6And1 != 0){
    $footer_total6And11 = number_format((float)$footer_total6And1, 2, '.', ',');
}else{
    $footer_total6And11 = "-";
}
if($footer_totalAbove1 != 0){
    $footer_totalAbove11 = number_format((float)$footer_totalAbove1, 2, '.', ',');
}else{
    $footer_totalAbove11 = "-";
}
$footer_totalTarget1 = number_format((float)$footer_totalTarget, 2, '.', ',');
$header .= <<<EOF

<tr>
<th style="font-weight:bold; text-align: center;">TOTAL</th>
<th style="color:red;font-weight:bold; text-align: right;">$footer_totalTarget1</th>
<th style="font-weight:bold; text-align: right;" >$footer_totalCumi1</th>
EOF;
// Check and add the formatted day headers only if they are not null
if ($day1_param > 0) {
    $header .= '<th style="font-weight:bold">'.$footer_totalDay11.'</th>';
}
if ($day2_param > 0) {
    $header .= '<th style="font-weight:bold">'.$footer_totalDay22.'</th>';
}
if ($day3_param > 0) {
    $header .= '<th style="font-weight:bold">'.$footer_totalDay33.'</th>';
}
if ($day4_param > 0) {
    $header .= '<th style="font-weight:bold">'.$footer_totalDay44.'</th>';
}
if ($day5_param > 0) {
    $header .= '<th style="font-weight:bold">'.$footer_totalDay55.'</th>';
}

$header .= <<<EOF
<th style="font-weight:bold; text-align: right;" >$footer_totalTotal1</th>
<th style="font-weight:bold; text-align: right;" >$footer_totalBelow66</th>
<th style="font-weight:bold; text-align: right;" >$footer_total6And11</th>
<th style="font-weight:bold; text-align: right;" >$footer_totalAbove11</th>
</tr>

<tr>
<th></th>
<th></th>
<th></th>
EOF;
// Check and add the formatted day headers only if they are not null
if ($day1_param > 0) {
    $header .= '<th></th>';
}
if ($day2_param > 0) {
    $header .= '<th></th>';
}
if ($day3_param > 0) {
    $header .= '<th></th>';
}
if ($day4_param > 0) {
    $header .= '<th></th>';
}
if ($day5_param > 0) {
    $header .= '<th></th>';
}



$header .= <<<EOF
<th></th>
<th></th>
<th></th>
<th></th>
</tr>

<tr>
    <th style="border:1px solid black;font-weight:bold; text-align: center;">FCH BRANCHES</th>
    <th style="border:1px solid black;color:red;"></th>
    <th style="border:1px solid black;"></th>
EOF;
    // Check and add the formatted day headers only if they are not null
    if ($day1_param > 0) {
        $header .= '<th style="border:1px solid black;"></th>';
    }
    if ($day2_param > 0) {
        $header .= '<th style="border:1px solid black;"></th>';
    }
    if ($day3_param > 0) {
        $header .= '<th style="border:1px solid black;"></th>';
    }
    if ($day4_param > 0) {
        $header .= '<th style="border:1px solid black;"></th>';
    }
    if ($day5_param > 0) {
        $header .= '<th style="border:1px solid black;"></th>';
    }
    
    $header .= <<<EOF
    <th style="border:1px solid black;"></th>
    <th style="border:1px solid black;"></th>
    <th style="border:1px solid black;"></th>
    <th style="border:1px solid black;"></th>
</tr>
EOF;
if($date != ""){

    $footer_totalTarget=0;
    $footer_totalCumi=0;
    $footer_totalDay1=0;
    $footer_totalDay2=0;
    $footer_totalDay3=0;
    $footer_totalDay4=0;
    $footer_totalDay5=0;
    $footer_totalTotal=0;
    $footer_totalBelow6=0;
    $footer_total6And1=0;
    $footer_totalAbove1=0;
   
    foreach ($dataFCH as &$item2) {
        $full_name = $item2['full_name'];

       
        $getTarget = (new ControllerPastdue)->ctrShowReportTarget($full_name, $date);
        if ($day1_param > 0) {
            $getDay1 = (new ControllerPastdue)->ctrGetDay1($full_name, $day1);
        } else {
            $getDay1 = "";
        }
        if ($day2_param > 0) {
            $getDay2 = (new ControllerPastdue)->ctrGetDay2($full_name, $day2);
        } else {
            $getDay2 = "";
        }
        if ($day3_param > 0) {
            $getDay3 = (new ControllerPastdue)->ctrGetDay3($full_name, $day3);
        } else {
            $getDay3 = "";
        }
        if ($day4_param > 0) {
            $getDay4 = (new ControllerPastdue)->ctrGetDay3($full_name, $day4);
        } else {
            $getDay4 = "";
        }
        if ($day5_param > 0) {
            $getDay5 = (new ControllerPastdue)->ctrGetDay3($full_name, $day5);
        } else {
            $getDay5 = "";
        }
    
        if ($day5_param > 0) {
           $day5 = $day5;
        }elseif($day4_param > 0) {
            $day5 = $day4;
        }elseif($day3_param > 0) {
            $day5 = $day3;
        }elseif($day2_param > 0) {
            $day5 = $day2;
        }elseif($day1_param > 0) {
            $day5 = $day1;
        }
        
        $getBelow6 = (new ControllerPastdue)->ctrGetBelow6($full_name, $minRange, $day5);
        $getBelow6And1 = (new ControllerPastdue)->ctrGet6And1year($full_name, $minRange, $day5);
        $getAbove1 = (new ControllerPastdue)->ctrGetAbove1($full_name, $minRange, $day5);
        
    $dateRef = date('d', strtotime($weekfrom));      
            
    if($dateRef == '01'){  
        $getCumTotal =  0;                       
     
    }else{
        
        $getCumTotal =  (new ControllerPastdue)->ctrGetCumTotal($full_name, $minRange, $maxRange);
    }

        if(!empty($getTarget)){
            foreach ($getTarget as $key => $value) {
                $amount1 = $value['amount'];
                $amount = number_format((float)$amount1, 2, '.', ',');
                $footer_totalTarget +=  $amount1;
                # code...
            }
        }else{
            $amount ="&#9;-";
        }

        if(!empty($getDay1)){
            foreach ($getDay1 as $key => $value1) {
                $day1_total1  = $value1['total_day1'];
                $total_debit1  = $value1['total_debit1'];

                if($total_debit1 !=""){
                    $day1_total1 = $day1_total1 + $total_debit1;
                }
                if($day1_total1 !=""){
                    $day1_total = number_format((float)$day1_total1, 2, '.', ',');
                    $footer_totalDay1 += $day1_total1;
                }else{

                    $day1_total ="";
                    $day1_total1 = 0;
                }
            }
        }else{
            $day1_total =""; 
            $day1_total1 = 0;
        }

        if(!empty($getDay2)){
            foreach ($getDay2 as $key => $value2) {
                $day2_total2  = $value2['total_day1'];
                $total_debit1  = $value2['total_debit1'];

                if($total_debit1 !=""){
                    $day2_total2 = $day2_total2 + $total_debit1;
                }
                if($day2_total2 !=""){
                    $day2_total = number_format((float)$day2_total2, 2, '.', ',');
                    $footer_totalDay2 += $day2_total2;
                }else{

                    $day2_total ="";
                    $day2_total2 = 0;
                }
            }
        }else{
            $day2_total =""; 
            $day2_total2 = 0;
        }

         if(!empty($getDay3)){
                foreach ($getDay3 as $key => $value3) {
                    $day3_total3  = $value3['total_day1'];
                    $total_debit1  = $value3['total_debit1'];

                    if($total_debit1 !=""){
                        $day3_total3 = $day3_total3 + $total_debit1;
                    }
                    if($day3_total3 !=""){
                        $day3_total = number_format((float)$day3_total3, 2, '.', ',');
                        $footer_totalDay3 += $day3_total3;
                    }else{

                        $day3_total ="";
                        $day3_total3 = 0;
                    }
                }
            }else{
                $day3_total =""; 
                $day3_total3 = 0;
            }

            if(!empty($getDay4)){
                foreach ($getDay4 as $key => $value4) {
                    $day4_total4  = $value4['total_day1'];
                    $total_debit1  = $value4['total_debit1'];

                    if($total_debit1 !=""){
                        $day4_total4 = $day4_total4 + $total_debit1;
                    }
                    if($day4_total4 !=""){
                        $day4_total = number_format((float)$day4_total4, 2, '.', ',');
                        $footer_totalDay4 += $day4_total4;
                    }else{

                        $day4_total ="";
                        $day4_total4 = 0; 
                    }
                }
            }else{
                $day4_total =""; 
                $day4_total4 = 0; 
            }

            if(!empty($getDay5)){
                foreach ($getDay5 as $key => $value5) {
                    $day5_total5  = $value5['total_day1'];
                    $total_debit1  = $value5['total_debit1'];

                    if($total_debit1 !=""){
                        $day5_total5 = $day5_total5 + $total_debit1;
                    }
                    if($day5_total5 !=""){
                        $day5_total = number_format((float)$day5_total5, 2, '.', ',');
                        $footer_totalDay5 += $day5_total5;
                    }else{

                        $day5_total ="";
                        $day5_total5 = 0;
                    }
                }
            }else{
                $day5_total =""; 
                $day5_total5 = 0;
            }

      
        
        if(!empty($getBelow6)){
            foreach ($getBelow6 as $key => $row) {
                $below6  = $row['total_below6'];
                $total_debit1  = $row['total_debit1'];

                if($total_debit1 !=""){
                    $below6 = $below6 + $total_debit1;
                }
            
                if($below6 !=0){
                    $total_below6 = number_format((float)$below6, 2, '.', ',');
                    $footer_totalBelow6 += $below6;
                }else{

                    $total_below6 ="";
                }
            }
        }else{
            $total_below6 =""; 
        }


        if(!empty($getBelow6And1)){
            foreach ($getBelow6And1 as $key => $row1) {
                $below6And1  = $row1['total_below6and1'];
                $total_debit1  = $row1['total_debit1'];
                if($total_debit1 !=""){
                    $below6And1 = $below6And1 + $total_debit1;
                }

                if($below6And1 !=0){
                    $total_below6And1 = number_format((float)$below6And1, 2, '.', ',');
                    $footer_total6And1 += $below6And1;
                }else{

                    $total_below6And1 ="";
                }
            }
        }else{
            $total_below6And1 =""; 
        }


        if(!empty($getAbove1)){
            foreach ($getAbove1 as $key => $row2) {
                $above1  = $row2['total_above1'];
                $total_debit1  = $row2['total_debit1'];
                if($total_debit1 !=""){
                    $above1 = $above1 + $total_debit1;
                }
                if($above1 !=0){
                    $total_belowAbove1 = number_format((float)$above1, 2, '.', ',');
                    $footer_totalAbove1 += $above1;
                }else{

                    $total_belowAbove1 ="";
                }
            }
        }else{
            $total_belowAbove1 =""; 
        }
        
        if(!empty($getCumTotal)){
            foreach ($getCumTotal as $key => $row3) {
                $totalCumi1  = $row3['total'];
                $total_debit  = $row3['total_debit'];
                if($total_debit !=""){
                    $totalCumi1= $totalCumi1 + $total_debit;
                }

                if($totalCumi1 !=""){
                    $totalCumi = number_format((float)$totalCumi1, 2, '.', ',');
                    $footer_totalCumi += $totalCumi1;
                }else{

                    $totalCumi =" - ";
                    $totalCumi1 = 0; 
                }
            }
        }else{
            $totalCumi =" - "; 
            $totalCumi1 = 0;
        }


        $total1 = $day1_total1 + $day2_total2 + $day3_total3 +$day4_total4 +$day5_total5 + $totalCumi1;
            $footer_totalTotal += $total1;
            if($total1 !=0){
                $total = number_format((float)$total1, 2, '.', ',');
            }else{
                $total = "";
            }
          


            $full_name1 = str_replace("FCH", "", "$full_name");
      
        $header .= <<<EOF
        <tr>
            <td style="border:1px solid black; text-align: center;">$full_name1</td>
            <td style="border:1px solid black;color:red; text-align: right;">$amount</td>
            <td style="border:1px solid black; text-align: right;">$totalCumi</td>
        EOF;
            // Check and add the formatted day headers only if they are not null
            if ($day1_param > 0) {
                $header .= '<td style="border:1px solid black;">'.$day1_total.'</td>';
            }
            if ($day2_param > 0) {
                $header .= '<td style="border:1px solid black;">'.$day2_total.'</td>';
            }
            if ($day3_param > 0) {
                $header .= '<td style="border:1px solid black;">'.$day3_total.'</td>';
            }
            if ($day4_param > 0) {
                $header .= '<td style="border:1px solid black;">'.$day4_total.'</td>';
            }
            if ($day5_param > 0) {
                $header .= '<td style="border:1px solid black;">'.$day5_total.'</td>';
            }
            
        $header .= <<<EOF
            <td style="border:1px solid black; text-align: right;">$total</td>
            <td style="border:1px solid black; text-align: right;">$total_below6</td>
            <td style="border:1px solid black; text-align: right;">$total_below6And1</td>
            <td style="border:1px solid black; text-align: right;">$total_belowAbove1</td>
      </tr>

      EOF;
    }
}

$grandTotal_Target += $footer_totalTarget;
$grandTotal_Cumi += $footer_totalCumi;
$grandTotal_Day1 += $footer_totalDay1;
$grandTotal_Day2 += $footer_totalDay2;
$grandTotal_Day3 += $footer_totalDay3;
$grandTotal_Day4 += $footer_totalDay4;
$grandTotal_Day5 += $footer_totalDay5;
$grandTotal_Total += $footer_totalTotal;
$grandTotal_Below6 += $footer_totalBelow6;
$grandTotal_6And1 += $footer_total6And1;
$grandTotal_Above1 += $footer_totalAbove1;

if($footer_totalCumi != 0){
    $footer_totalCumi1 = number_format((float)$footer_totalCumi, 2, '.', ',');
}else{
    $footer_totalCumi1 = "-";
}
if($footer_totalDay1 != 0){
    $footer_totalDay11 = number_format((float)$footer_totalDay1, 2, '.', ',');
}else{
    $footer_totalDay11 = "-";
}
if($footer_totalDay2 != 0){
    $footer_totalDay22 = number_format((float)$footer_totalDay2, 2, '.', ',');
}else{
    $footer_totalDay22 = "-";
}
if($footer_totalDay3 != 0){
    $footer_totalDay33 = number_format((float)$footer_totalDay3, 2, '.', ',');
}else{
    $footer_totalDay33 = "-";
}

if($footer_totalDay4 != 0){
    $footer_totalDay44 = number_format((float)$footer_totalDay4, 2, '.', ',');
}else{
    $footer_totalDay44 = "-";
}

if($footer_totalDay5 != 0){
    $footer_totalDay55 = number_format((float)$footer_totalDay5, 2, '.', ',');
}else{
    $footer_totalDay55 = "-";
}
if($footer_totalTotal != 0){
    $footer_totalTotal1 = number_format((float)$footer_totalTotal, 2, '.', ',');
}else{
    $footer_totalTotal1 = "-";
}
if($footer_totalBelow6 != 0){
    $footer_totalBelow66 = number_format((float)$footer_totalBelow6, 2, '.', ',');
}else{
    $footer_totalBelow66 = "-";
}
if($footer_total6And1 != 0){
    $footer_total6And11 = number_format((float)$footer_total6And1, 2, '.', ',');
}else{
    $footer_total6And11 = "-";
}
if($footer_totalAbove1 != 0){
    $footer_totalAbove11 = number_format((float)$footer_totalAbove1, 2, '.', ',');
}else{
    $footer_totalAbove11 = "-";
}
$footer_totalTarget1 = number_format((float)$footer_totalTarget, 2, '.', ',');
$header .= <<<EOF
<tr>
<th style="border:1px solid black;font-weight:bold; text-align: center;">TOTAL</th>
<th style="border:1px solid black;font-weight:bold;color:red; text-align: right;">$footer_totalTarget1</th>
<th style="border:1px solid black;font-weight:bold; text-align: right;">$footer_totalCumi1</th>
EOF;
// Check and add the formatted day headers only if they are not null
if ($day1_param > 0) {
    $header .= '<th style="font-weight:bold">'.$footer_totalDay11.'</th>';
}
if ($day2_param > 0) {
    $header .= '<th style="font-weight:bold">'.$footer_totalDay22.'</th>';
}
if ($day3_param > 0) {
    $header .= '<th style="font-weight:bold">'.$footer_totalDay33.'</th>';
}
if ($day4_param > 0) {
    $header .= '<th style="font-weight:bold">'.$footer_totalDay44.'</th>';
}
if ($day5_param > 0) {
    $header .= '<th style="font-weight:bold">'.$footer_totalDay55.'</th>';
}

$header .= <<<EOF
<th style="border:1px solid black;font-weight:bold; text-align: right;">$footer_totalTotal1</th>
<th style="border:1px solid black;font-weight:bold; text-align: right;">$footer_totalBelow66</th>
<th style="border:1px solid black;font-weight:bold; text-align: right;">$footer_total6And11</th>
<th style="border:1px solid black;font-weight:bold; text-align: right;">$footer_totalAbove11</th>
</tr>

<tr>
<th></th>
<th></th>
<th></th>
EOF;
// Check and add the formatted day headers only if they are not null
if ($day1_param > 0) {
    $header .= '<th></th>';
}
if ($day2_param > 0) {
    $header .= '<th></th>';
}
if ($day3_param > 0) {
    $header .= '<th></th>';
}
if ($day4_param > 0) {
    $header .= '<th></th>';
}
if ($day5_param > 0) {
    $header .= '<th></th>';
}

$header .= <<<EOF
<th></th>
<th></th>
<th></th>
<th></th>
</tr>

<tr>
    <th style="border:1px solid black;font-weight:bold; text-align: center;">RLC BRANCHES</th>
    <th style="border:1px solid black;"></th>
    <th style="border:1px solid black;"></th>
EOF;
    // Check and add the formatted day headers only if they are not null
    if ($day1_param > 0) {
        $header .= ' <th style="border:1px solid black;"></th>';
    }
    if ($day2_param > 0) {
        $header .= ' <th style="border:1px solid black;"></th>';
    }
    if ($day3_param > 0) {
        $header .= ' <th style="border:1px solid black;"></th>';
    }
    if ($day4_param > 0) {
        $header .= ' <th style="border:1px solid black;"></th>';
    }
    if ($day5_param > 0) {
        $header .= ' <th style="border:1px solid black;"></th>';
    }

$header .= <<<EOF
    <th style="border:1px solid black;"></th>
    <th style="border:1px solid black;"></th>
    <th style="border:1px solid black;"></th>
    <th style="border:1px solid black;"></th>
</tr>

EOF;

if($date != ""){

    $footer_totalTarget=0;
    $footer_totalCumi=0;
    $footer_totalDay1=0;
    $footer_totalDay2=0;
    $footer_totalDay3=0;
    $footer_totalDay4=0;
    $footer_totalDay5=0;
    $footer_totalTotal=0;
    $footer_totalBelow6=0;
    $footer_total6And1=0;
    $footer_totalAbove1=0;
   
    foreach ($dataRLC as &$item2) {
        $full_name = $item2['full_name'];

       
        $getTarget = (new ControllerPastdue)->ctrShowReportTarget($full_name, $date);
        if ($day1_param > 0) {
            $getDay1 = (new ControllerPastdue)->ctrGetDay1($full_name, $day1);
        } else {
            $getDay1 = "";
        }
        if ($day2_param > 0) {
            $getDay2 = (new ControllerPastdue)->ctrGetDay2($full_name, $day2);
        } else {
            $getDay2 = "";
        }
        if ($day3_param > 0) {
            $getDay3 = (new ControllerPastdue)->ctrGetDay3($full_name, $day3);
        } else {
            $getDay3 = "";
        }
        if ($day4_param > 0) {
            $getDay4 = (new ControllerPastdue)->ctrGetDay3($full_name, $day4);
        } else {
            $getDay4 = "";
        }
        if ($day5_param > 0) {
            $getDay5 = (new ControllerPastdue)->ctrGetDay3($full_name, $day5);
        } else {
            $getDay5 = "";
        }
    
        if ($day5_param > 0) {
           $day5 = $day5;
        }elseif($day4_param > 0) {
            $day5 = $day4;
        }elseif($day3_param > 0) {
            $day5 = $day3;
        }elseif($day2_param > 0) {
            $day5 = $day2;
        }elseif($day1_param > 0) {
            $day5 = $day1;
        }
        $getBelow6 = (new ControllerPastdue)->ctrGetBelow6($full_name, $minRange, $day5);
        $getBelow6And1 = (new ControllerPastdue)->ctrGet6And1year($full_name, $minRange, $day5);
        $getAbove1 = (new ControllerPastdue)->ctrGetAbove1($full_name, $minRange, $day5);
        
    $dateRef = date('d', strtotime($weekfrom));      
            
    if($dateRef == '01'){  
        $getCumTotal =  0;                       
     
    }else{
        
        $getCumTotal =  (new ControllerPastdue)->ctrGetCumTotal($full_name, $minRange, $maxRange);
    }

        if(!empty($getTarget)){
            foreach ($getTarget as $key => $value) {
                $amount1 = $value['amount'];
                $amount = number_format((float)$amount1, 2, '.', ',');
                $footer_totalTarget +=  $amount1;
                # code...
            }
        }else{
            $amount ="&#9;-";
        }

        if(!empty($getDay1)){
            foreach ($getDay1 as $key => $value1) {
                $day1_total1  = $value1['total_day1'];
                $total_debit1  = $value1['total_debit1'];

                if($total_debit1 !=""){
                    $day1_total1 = $day1_total1 + $total_debit1;
                }
                if($day1_total1 !=""){
                    $day1_total = number_format((float)$day1_total1, 2, '.', ',');
                    $footer_totalDay1 += $day1_total1;
                }else{

                    $day1_total ="";
                    $day1_total1 = 0;
                }
            }
        }else{
            $day1_total =""; 
            $day1_total1 = 0;
        }

        if(!empty($getDay2)){
            foreach ($getDay2 as $key => $value2) {
                $day2_total2  = $value2['total_day1'];
                $total_debit1  = $value2['total_debit1'];

                if($total_debit1 !=""){
                    $day2_total2 = $day2_total2 + $total_debit1;
                }
                if($day2_total2 !=""){
                    $day2_total = number_format((float)$day2_total2, 2, '.', ',');
                    $footer_totalDay2 += $day2_total2;
                }else{

                    $day2_total ="";
                    $day2_total2 = 0;
                }
            }
        }else{
            $day2_total =""; 
            $day2_total2 = 0;
        }

          if(!empty($getDay3)){
                foreach ($getDay3 as $key => $value3) {
                    $day3_total3  = $value3['total_day1'];
                    $total_debit1  = $value3['total_debit1'];

                    if($total_debit1 !=""){
                        $day3_total3 = $day3_total3 + $total_debit1;
                    }
                    if($day3_total3 !=""){
                        $day3_total = number_format((float)$day3_total3, 2, '.', ',');
                        $footer_totalDay3 += $day3_total3;
                    }else{

                        $day3_total ="";
                        $day3_total3 = 0;
                    }
                }
            }else{
                $day3_total =""; 
                $day3_total3 = 0;
            }

            if(!empty($getDay4)){
                foreach ($getDay4 as $key => $value4) {
                    $day4_total4  = $value4['total_day1'];
                    $total_debit1  = $value4['total_debit1'];

                    if($total_debit1 !=""){
                        $day4_total4 = $day4_total4 + $total_debit1;
                    }
                    if($day4_total4 !=""){
                        $day4_total = number_format((float)$day4_total4, 2, '.', ',');
                        $footer_totalDay4 += $day4_total4;
                    }else{

                        $day4_total ="";
                        $day4_total4 = 0; 
                    }
                }
            }else{
                $day4_total =""; 
                $day4_total4 = 0; 
            }

            if(!empty($getDay5)){
                foreach ($getDay5 as $key => $value5) {
                    $day5_total5  = $value5['total_day1'];
                    $total_debit1  = $value5['total_debit1'];

                    if($total_debit1 !=""){
                        $day5_total5 = $day5_total5 + $total_debit1;
                    }
                    if($day5_total5 !=""){
                        $day5_total = number_format((float)$day5_total5, 2, '.', ',');
                        $footer_totalDay5 += $day5_total5;
                    }else{

                        $day5_total ="";
                        $day5_total5 = 0;
                    }
                }
            }else{
                $day5_total =""; 
                $day5_total5 = 0;
            }

      

        
        if(!empty($getBelow6)){
            foreach ($getBelow6 as $key => $row) {
                $below6  = $row['total_below6'];
                $total_debit1  = $row['total_debit1'];

                if($total_debit1 !=""){
                    $below6 = $below6 + $total_debit1;
                }
            
                if($below6 !=0){
                    $total_below6 = number_format((float)$below6, 2, '.', ',');
                    $footer_totalBelow6 += $below6;
                }else{

                    $total_below6 ="";
                }
            }
        }else{
            $total_below6 =""; 
        }


        if(!empty($getBelow6And1)){
            foreach ($getBelow6And1 as $key => $row1) {
                $below6And1  = $row1['total_below6and1'];
                $total_debit1  = $row1['total_debit1'];
                if($total_debit1 !=""){
                    $below6And1 = $below6And1 + $total_debit1;
                }

                if($below6And1 !=0){
                    $total_below6And1 = number_format((float)$below6And1, 2, '.', ',');
                    $footer_total6And1 += $below6And1;
                }else{

                    $total_below6And1 ="";
                }
            }
        }else{
            $total_below6And1 =""; 
        }


        if(!empty($getAbove1)){
            foreach ($getAbove1 as $key => $row2) {
                $above1  = $row2['total_above1'];
                $total_debit1  = $row2['total_debit1'];
                if($total_debit1 !=""){
                    $above1 = $above1 + $total_debit1;
                }
                if($above1 !=0){
                    $total_belowAbove1 = number_format((float)$above1, 2, '.', ',');
                    $footer_totalAbove1 += $above1;
                }else{

                    $total_belowAbove1 ="";
                }
            }
        }else{
            $total_belowAbove1 =""; 
        }
        
        if(!empty($getCumTotal)){
            foreach ($getCumTotal as $key => $row3) {
                $totalCumi1  = $row3['total'];
                $total_debit  = $row3['total_debit'];
                if($total_debit !=""){
                    $totalCumi1= $totalCumi1 + $total_debit;
                }

                if($totalCumi1 !=""){
                    $totalCumi = number_format((float)$totalCumi1, 2, '.', ',');
                    $footer_totalCumi += $totalCumi1;
                }else{

                    $totalCumi =" - ";
                    $totalCumi1 = 0; 
                }
            }
        }else{
            $totalCumi =" - "; 
            $totalCumi1 = 0;
        }

        $total1 = $day1_total1 + $day2_total2 + $day3_total3 +$day4_total4 +$day5_total5 + $totalCumi1;
            $footer_totalTotal += $total1;
            if($total1 !=0){
                $total = number_format((float)$total1, 2, '.', ',');
            }else{
                $total = "";
            }
          

            $full_name1 = str_replace("RLC", "", "$full_name");
      
        $header .= <<<EOF
        <tr>
            <td style="border:1px solid black; text-align: center;">$full_name1</td>
            <td style="border:1px solid black;color:red; text-align: right;">$amount</td>
            <td style="border:1px solid black; text-align: right;">$totalCumi</td>
        EOF;
            // Check and add the formatted day headers only if they are not null
            if ($day1_param > 0) {
                $header .= '<td style="border:1px solid black;">'.$day1_total.'</td>';
            }
            if ($day2_param > 0) {
                $header .= '<td style="border:1px solid black;">'.$day2_total.'</td>';
            }
            if ($day3_param > 0) {
                $header .= '<td style="border:1px solid black;">'.$day3_total.'</td>';
            }
            if ($day4_param > 0) {
                $header .= '<td style="border:1px solid black;">'.$day4_total.'</td>';
            }
            if ($day5_param > 0) {
                $header .= '<td style="border:1px solid black;">'.$day5_total.'</td>';
            }
            
        $header .= <<<EOF
            <td style="border:1px solid black; text-align: right;">$total</td>
            <td style="border:1px solid black; text-align: right;">$total_below6</td>
            <td style="border:1px solid black; text-align: right;">$total_below6And1</td>
            <td style="border:1px solid black; text-align: right;">$total_belowAbove1</td>
      </tr>

      EOF;
    }
}
$grandTotal_Target += $footer_totalTarget;
$grandTotal_Cumi += $footer_totalCumi;
$grandTotal_Day1 += $footer_totalDay1;
$grandTotal_Day2 += $footer_totalDay2;
$grandTotal_Day3 += $footer_totalDay3;
$grandTotal_Day4 += $footer_totalDay4;
$grandTotal_Day5 += $footer_totalDay5;
$grandTotal_Total += $footer_totalTotal;
$grandTotal_Below6 += $footer_totalBelow6;
$grandTotal_6And1 += $footer_total6And1;
$grandTotal_Above1 += $footer_totalAbove1;


if($footer_totalCumi != 0){
    $footer_totalCumi1 = number_format((float)$footer_totalCumi, 2, '.', ',');
}else{
    $footer_totalCumi1 = "-";
}
if($footer_totalDay1 != 0){
    $footer_totalDay11 = number_format((float)$footer_totalDay1, 2, '.', ',');
}else{
    $footer_totalDay11 = "-";
}
if($footer_totalDay2 != 0){
    $footer_totalDay22 = number_format((float)$footer_totalDay2, 2, '.', ',');
}else{
    $footer_totalDay22 = "-";
}
if($footer_totalDay3 != 0){
    $footer_totalDay33 = number_format((float)$footer_totalDay3, 2, '.', ',');
}else{
    $footer_totalDay33 = "-";
}

if($footer_totalDay4 != 0){
    $footer_totalDay44 = number_format((float)$footer_totalDay4, 2, '.', ',');
}else{
    $footer_totalDay44 = "-";
}

if($footer_totalDay5 != 0){
    $footer_totalDay55 = number_format((float)$footer_totalDay5, 2, '.', ',');
}else{
    $footer_totalDay55 = "-";
}
if($footer_totalTotal != 0){
    $footer_totalTotal1 = number_format((float)$footer_totalTotal, 2, '.', ',');
}else{
    $footer_totalTotal1 = "-";
}
if($footer_totalBelow6 != 0){
    $footer_totalBelow66 = number_format((float)$footer_totalBelow6, 2, '.', ',');
}else{
    $footer_totalBelow66 = "-";
}
if($footer_total6And1 != 0){
    $footer_total6And11 = number_format((float)$footer_total6And1, 2, '.', ',');
}else{
    $footer_total6And11 = "-";
}
if($footer_totalAbove1 != 0){
    $footer_totalAbove11 = number_format((float)$footer_totalAbove1, 2, '.', ',');
}else{
    $footer_totalAbove11 = "-";
}
$footer_totalTarget1 = number_format((float)$footer_totalTarget, 2, '.', ',');


$header .= <<<EOF
<tr>
<th style="font-weight:bold; text-align: center;">TOTAL</th>
<th style="font-weight:bold;color:red; text-align: right;">$footer_totalTarget1</th>
<th style="font-weight:bold; text-align: right;">$footer_totalCumi1</th>
EOF;
// Check and add the formatted day headers only if they are not null
if ($day1_param > 0) {
    $header .= '<th style="font-weight:bold">'.$footer_totalDay11.'</th>';
}
if ($day2_param > 0) {
    $header .= '<th style="font-weight:bold">'.$footer_totalDay22.'</th>';
}
if ($day3_param > 0) {
    $header .= '<th style="font-weight:bold">'.$footer_totalDay33.'</th>';
}
if ($day4_param > 0) {
    $header .= '<th style="font-weight:bold">'.$footer_totalDay44.'</th>';
}
if ($day5_param > 0) {
    $header .= '<th style="font-weight:bold">'.$footer_totalDay55.'</th>';
}

$header .= <<<EOF
<th style="font-weight:bold; text-align: right;">$footer_totalTotal1</th>
<th style="font-weight:bold; text-align: right;">$footer_totalBelow66</th>
<th style="font-weight:bold; text-align: right;">$footer_total6And11</th>
<th style="font-weight:bold; text-align: right;">$footer_totalAbove11</th>
</tr>

<tr>
<th colspan="12"></th>


</tr>

<tr>
<th style="font-weight:bold; text-align: center;"></th>
<th></th>
<th></th>
EOF;
// Check and add the formatted day headers only if they are not null
if ($day1_param > 0) {
    $header .= '<th></th>';
}
if ($day2_param > 0) {
    $header .= '<th></th>';
}
if ($day3_param > 0) {
    $header .= '<th></th>';
}
if ($day4_param > 0) {
    $header .= '<th></th>';
}
if ($day5_param > 0) {
    $header .= '<th></th>';
}

$header .= <<<EOF
<th></th>
<th></th>
<th></th>
<th></th>
</tr>




EOF;

if($date != ""){

    $footer_totalTarget=0;
    $footer_totalCumi=0;
    $footer_totalDay1=0;
    $footer_totalDay2=0;
    $footer_totalDay3=0;
    $footer_totalDay4=0;
    $footer_totalDay5=0;
    $footer_totalTotal=0;
    $footer_totalBelow6=0;
    $footer_total6And1=0;
    $footer_totalAbove1=0;
   
    foreach ($dataELC as &$item2) {
        $full_name = $item2['full_name'];

       
        $getTarget = (new ControllerPastdue)->ctrShowReportTarget($full_name, $date);
        if ($day1_param > 0) {
            $getDay1 = (new ControllerPastdue)->ctrGetDay1($full_name, $day1);
        } else {
            $getDay1 = "";
        }
        if ($day2_param > 0) {
            $getDay2 = (new ControllerPastdue)->ctrGetDay2($full_name, $day2);
        } else {
            $getDay2 = "";
        }
        if ($day3_param > 0) {
            $getDay3 = (new ControllerPastdue)->ctrGetDay3($full_name, $day3);
        } else {
            $getDay3 = "";
        }
        if ($day4_param > 0) {
            $getDay4 = (new ControllerPastdue)->ctrGetDay3($full_name, $day4);
        } else {
            $getDay4 = "";
        }
        if ($day5_param > 0) {
            $getDay5 = (new ControllerPastdue)->ctrGetDay3($full_name, $day5);
        } else {
            $getDay5 = "";
        }
    
        if ($day5_param > 0) {
           $day5 = $day5;
        }elseif($day4_param > 0) {
            $day5 = $day4;
        }elseif($day3_param > 0) {
            $day5 = $day3;
        }elseif($day2_param > 0) {
            $day5 = $day2;
        }elseif($day1_param > 0) {
            $day5 = $day1;
        }
        $getBelow6 = (new ControllerPastdue)->ctrGetBelow6($full_name, $minRange, $day5);
        $getBelow6And1 = (new ControllerPastdue)->ctrGet6And1year($full_name, $minRange, $day5);
        $getAbove1 = (new ControllerPastdue)->ctrGetAbove1($full_name, $minRange, $day5);
        
    $dateRef = date('d', strtotime($weekfrom));      
            
    if($dateRef == '01'){  
        $getCumTotal =  0;                       
     
    }else{
        
        $getCumTotal =  (new ControllerPastdue)->ctrGetCumTotal($full_name, $minRange, $maxRange);
    }

        if(!empty($getTarget)){
            foreach ($getTarget as $key => $value) {
                $amount1 = $value['amount'];
                $amount = number_format((float)$amount1, 2, '.', ',');
                $footer_totalTarget +=  $amount1;
                # code...
            }
        }else{
            $amount ="&#9;-";
        }

        if(!empty($getDay1)){
            foreach ($getDay1 as $key => $value1) {
                $day1_total1  = $value1['total_day1'];
                $total_debit1  = $value1['total_debit1'];

                if($total_debit1 !=""){
                    $day1_total1 = $day1_total1 + $total_debit1;
                }
                if($day1_total1 !=""){
                    $day1_total = number_format((float)$day1_total1, 2, '.', ',');
                    $footer_totalDay1 += $day1_total1;
                }else{

                    $day1_total ="";
                    $day1_total1 = 0;
                }
            }
        }else{
            $day1_total =""; 
            $day1_total1 = 0;
        }

        if(!empty($getDay2)){
            foreach ($getDay2 as $key => $value2) {
                $day2_total2  = $value2['total_day1'];
                $total_debit1  = $value2['total_debit1'];

                if($total_debit1 !=""){
                    $day2_total2 = $day2_total2 + $total_debit1;
                }
                if($day2_total2 !=""){
                    $day2_total = number_format((float)$day2_total2, 2, '.', ',');
                    $footer_totalDay2 += $day2_total2;
                }else{

                    $day2_total ="";
                    $day2_total2 = 0;
                }
            }
        }else{
            $day2_total =""; 
            $day2_total2 = 0;
        }

          if(!empty($getDay3)){
                foreach ($getDay3 as $key => $value3) {
                    $day3_total3  = $value3['total_day1'];
                    $total_debit1  = $value3['total_debit1'];

                    if($total_debit1 !=""){
                        $day3_total3 = $day3_total3 + $total_debit1;
                    }
                    if($day3_total3 !=""){
                        $day3_total = number_format((float)$day3_total3, 2, '.', ',');
                        $footer_totalDay3 += $day3_total3;
                    }else{

                        $day3_total ="";
                        $day3_total3 = 0;
                    }
                }
            }else{
                $day3_total =""; 
                $day3_total3 = 0;
            }

            if(!empty($getDay4)){
                foreach ($getDay4 as $key => $value4) {
                    $day4_total4  = $value4['total_day1'];
                    $total_debit1  = $value4['total_debit1'];

                    if($total_debit1 !=""){
                        $day4_total4 = $day4_total4 + $total_debit1;
                    }
                    if($day4_total4 !=""){
                        $day4_total = number_format((float)$day4_total4, 2, '.', ',');
                        $footer_totalDay4 += $day4_total4;
                    }else{

                        $day4_total ="";
                        $day4_total4 = 0; 
                    }
                }
            }else{
                $day4_total =""; 
                $day4_total4 = 0; ;
            }

            if(!empty($getDay5)){
                foreach ($getDay5 as $key => $value5) {
                    $day5_total5  = $value5['total_day1'];
                    $total_debit1  = $value5['total_debit1'];

                    if($total_debit1 !=""){
                        $day5_total5 = $day5_total5 + $total_debit1;
                    }
                    if($day5_total5 !=""){
                        $day5_total = number_format((float)$day5_total5, 2, '.', ',');
                        $footer_totalDay5 += $day5_total5;
                    }else{

                        $day5_total ="";
                        $day5_total5 = 0;
                    }
                }
            }else{
                $day5_total =""; 
                $day5_total5 = 0;
            }

      

        
        if(!empty($getBelow6)){
            foreach ($getBelow6 as $key => $row) {
                $below6  = $row['total_below6'];
                $total_debit1  = $row['total_debit1'];

                if($total_debit1 !=""){
                    $below6 = $below6 + $total_debit1;
                }
            
                if($below6 !=0){
                    $total_below6 = number_format((float)$below6, 2, '.', ',');
                    $footer_totalBelow6 += $below6;
                }else{

                    $total_below6 ="";
                }
            }
        }else{
            $total_below6 =""; 
        }


        if(!empty($getBelow6And1)){
            foreach ($getBelow6And1 as $key => $row1) {
                $below6And1  = $row1['total_below6and1'];
                $total_debit1  = $row1['total_debit1'];
                if($total_debit1 !=""){
                    $below6And1 = $below6And1 + $total_debit1;
                }

                if($below6And1 !=0){
                    $total_below6And1 = number_format((float)$below6And1, 2, '.', ',');
                    $footer_total6And1 += $below6And1;
                }else{

                    $total_below6And1 ="";
                }
            }
        }else{
            $total_below6And1 =""; 
        }


        if(!empty($getAbove1)){
            foreach ($getAbove1 as $key => $row2) {
                $above1  = $row2['total_above1'];
                $total_debit1  = $row2['total_debit1'];
                if($total_debit1 !=""){
                    $above1 = $above1 + $total_debit1;
                }
                if($above1 !=0){
                    $total_belowAbove1 = number_format((float)$above1, 2, '.', ',');
                    $footer_totalAbove1 += $above1;
                }else{

                    $total_belowAbove1 ="";
                }
            }
        }else{
            $total_belowAbove1 =""; 
        }
        
        if(!empty($getCumTotal)){
            foreach ($getCumTotal as $key => $row3) {
                $totalCumi1  = $row3['total'];
                $total_debit  = $row3['total_debit'];
                if($total_debit !=""){
                    $totalCumi1= $totalCumi1 + $total_debit;
                }

                if($totalCumi1 !=""){
                    $totalCumi = number_format((float)$totalCumi1, 2, '.', ',');
                    $footer_totalCumi += $totalCumi1;
                }else{

                    $totalCumi =" - ";
                    $totalCumi1 = 0; 
                }
            }
        }else{
            $totalCumi =" - "; 
            $totalCumi1 = 0;
        }
        
        $total1 = $day1_total1 + $day2_total2 + $day3_total3 +$day4_total4 +$day5_total5 + $totalCumi1;
            $footer_totalTotal += $total1;
            if($total1 !=0){
                $total = number_format((float)$total1, 2, '.', ',');
            }else{
                $total = "";
            }
          
            $full_name1 = str_replace("ELC", "", "$full_name");
      
        $header .= <<<EOF
        <tr>
            <td style="border:1px solid black; text-align: center;">$full_name1</td>
            <td style="border:1px solid black; color: red; text-align: right; text-align: right; text-align: right;">$amount</td>
            <td style="border:1px solid black; text-align: right; text-align: right; text-align: right;">$totalCumi</td>
        EOF;
            // Check and add the formatted day headers only if they are not null
            if ($day1_param > 0) {
                $header .= '<td style="border:1px solid black;">'.$day1_total.'</td>';
            }
            if ($day2_param > 0) {
                $header .= '<td style="border:1px solid black;">'.$day2_total.'</td>';
            }
            if ($day3_param > 0) {
                $header .= '<td style="border:1px solid black;">'.$day3_total.'</td>';
            }
            if ($day4_param > 0) {
                $header .= '<td style="border:1px solid black;">'.$day4_total.'</td>';
            }
            if ($day5_param > 0) {
                $header .= '<td style="border:1px solid black;">'.$day5_total.'</td>';
            }
            
        $header .= <<<EOF
            <td style="border:1px solid black; text-align: right; text-align: right; text-align: right;">$total</td>
            <td style="border:1px solid black; text-align: right; text-align: right; text-align: right;">$total_below6</td>
            <td style="border:1px solid black; text-align: right; text-align: right; text-align: right;">$total_below6And1</td>
            <td style="border:1px solid black; text-align: right; text-align: right; text-align: right;">$total_belowAbove1</td>
      </tr>

      EOF;
    }
} 

$grandTotal_Target += $footer_totalTarget;
$grandTotal_Cumi += $footer_totalCumi;
$grandTotal_Day1 += $footer_totalDay1;
$grandTotal_Day2 += $footer_totalDay2;
$grandTotal_Day3 += $footer_totalDay3;
$grandTotal_Day4 += $footer_totalDay4;
$grandTotal_Day5 += $footer_totalDay5;
$grandTotal_Total += $footer_totalTotal;
$grandTotal_Below6 += $footer_totalBelow6;
$grandTotal_6And1 += $footer_total6And1;
$grandTotal_Above1 += $footer_totalAbove1;

if($grandTotal_Day1 != 0){
    $grandTotal_Day11 = number_format((float)$grandTotal_Day1, 2, '.', ',');
}else{
    $grandTotal_Day11 = "-";
}
if($grandTotal_Day2 != 0){
    $grandTotal_Day22 = number_format((float)$grandTotal_Day2, 2, '.', ',');
}else{
    $grandTotal_Day22 = "-";
}
if($grandTotal_Day3 != 0){
    $grandTotal_Day33 = number_format((float)$grandTotal_Day3, 2, '.', ',');
}else{
    $grandTotal_Day33 = "-";
}
if($grandTotal_Day4 != 0){
    $grandTotal_Day44 = number_format((float)$grandTotal_Day4, 2, '.', ',');
}else{
    $grandTotal_Day44 = "-";
}
if($grandTotal_Day5 != 0){
    $grandTotal_Day55 = number_format((float)$grandTotal_Day5, 2, '.', ',');
}else{
    $grandTotal_Day55 = "-";
}


$grandTotal_Target1 = number_format((float)$grandTotal_Target, 2, '.', ',');
$grandTotal_Cumi1 = number_format((float)$grandTotal_Cumi, 2, '.', ',');
$grandTotal_Total1 = number_format((float)$grandTotal_Total, 2, '.', ',');
$grandTotal_Below66 = number_format((float)$grandTotal_Below6, 2, '.', ',');
$grandTotal_6And11 = number_format((float)$grandTotal_6And1, 2, '.', ',');
$grandTotal_Above11 = number_format((float)$grandTotal_Above1, 2, '.', ',');


if($footer_totalCumi != 0){
    $footer_totalCumi1 = number_format((float)$footer_totalCumi, 2, '.', ',');
}else{
    $footer_totalCumi1 = "-";
}
if($footer_totalDay1 != 0){
    $footer_totalDay11 = number_format((float)$footer_totalDay1, 2, '.', ',');
}else{
    $footer_totalDay11 = "-";
}
if($footer_totalDay2 != 0){
    $footer_totalDay22 = number_format((float)$footer_totalDay2, 2, '.', ',');
}else{
    $footer_totalDay22 = "-";
}
if($footer_totalDay3 != 0){
    $footer_totalDay33 = number_format((float)$footer_totalDay3, 2, '.', ',');
}else{
    $footer_totalDay33 = "-";
}

if($footer_totalDay4 != 0){
    $footer_totalDay44 = number_format((float)$footer_totalDay4, 2, '.', ',');
}else{
    $footer_totalDay44 = "-";
}

if($footer_totalDay5 != 0){
    $footer_totalDay55 = number_format((float)$footer_totalDay5, 2, '.', ',');
}else{
    $footer_totalDay55 = "-";
}
if($footer_totalTotal != 0){
    $footer_totalTotal1 = number_format((float)$footer_totalTotal, 2, '.', ',');
}else{
    $footer_totalTotal1 = "-";
}
if($footer_totalBelow6 != 0){
    $footer_totalBelow66 = number_format((float)$footer_totalBelow6, 2, '.', ',');
}else{
    $footer_totalBelow66 = "-";
}
if($footer_total6And1 != 0){
    $footer_total6And11 = number_format((float)$footer_total6And1, 2, '.', ',');
}else{
    $footer_total6And11 = "-";
}
if($footer_totalAbove1 != 0){
    $footer_totalAbove11 = number_format((float)$footer_totalAbove1, 2, '.', ',');
}else{
    $footer_totalAbove11 = "-";
}
$footer_totalTarget1 = number_format((float)$footer_totalTarget, 2, '.', ',');


$header .= <<<EOF
<tr>
    <th style="font-weight:bold; text-align: center;">TOTAL</th>
    <th style="font-weight:bold; color: red; text-align: right; text-align: right;">$footer_totalTarget1</th>
    <th style="font-weight:bold; text-align: right; text-align: right;">$footer_totalCumi1</th>
EOF;
    // Check and add the formatted day headers only if they are not null
    if ($day1_param > 0) {
        $header .= '<th style="font-weight:bold">'.$footer_totalDay11.'</th>';
    }
    if ($day2_param > 0) {
        $header .= '<th style="font-weight:bold">'.$footer_totalDay22.'</th>';
    }
    if ($day3_param > 0) {
        $header .= '<th style="font-weight:bold">'.$footer_totalDay33.'</th>';
    }
    if ($day4_param > 0) {
        $header .= '<th style="font-weight:bold">'.$footer_totalDay44.'</th>';
    }
    if ($day5_param > 0) {
        $header .= '<th style="font-weight:bold">'.$footer_totalDay55.'</th>';
    }
    
    $header .= <<<EOF
    <th style="font-weight:bold; text-align: right; text-align: right;">$footer_totalTotal1</th>
    <th style="font-weight:bold; text-align: right; text-align: right;">$footer_totalBelow66</th>
    <th style="font-weight:bold; text-align: right; text-align: right;">$footer_total6And11</th>
    <th style="font-weight:bold; text-align: right; text-align: right;">$footer_totalAbove11</th>
    </tr>

    <tr>
    <th colspan="12"></th>
    </tr>
<tr>
    <th style="font-weight:bold; text-align: center;">GRAND TOTAL</th>
    <th style="font-weight:bold;color:red;"></th>
    <th style="font-weight:bold; text-align: right;">$grandTotal_Cumi1</th>
EOF;
    // Check and add the formatted day headers only if they are not null
    if ($day1_param > 0) {
        $header .= ' <th style="font-weight:bold; text-align: right;">'.$grandTotal_Day11.'</th>';
    }
    if ($day2_param > 0) {
        $header .= ' <th style="font-weight:bold; text-align: right;">'.$grandTotal_Day22.'</th>';
    }
    if ($day3_param > 0) {
        $header .= ' <th style="font-weight:bold; text-align: right;">'.$grandTotal_Day33.'</th>';
    }
    if ($day4_param > 0) {
        $header .= ' <th style="font-weight:bold; text-align: right;">'.$grandTotal_Day44.'</th>';
    }
    if ($day5_param > 0) {
        $header .= ' <th style="font-weight:bold; text-align: right;">'.$grandTotal_Day55.'</th>';
    }

    $header .= <<<EOF
    <th style="font-weight:bold; text-align: right;">$grandTotal_Total1</th>
    <th style="font-weight:bold; text-align: right;">$grandTotal_Below66</th>
    <th style="font-weight:bold; text-align: right;">$grandTotal_6And11</th>
    <th style="font-weight:bold; text-align: right;">$grandTotal_Above11</th>
</tr>
<tr>
    <th style="font-weight:bold; text-align: center;">TOTAL TARGET</th>
    <th style="font-weight:bold;color:red; text-align: right;">$grandTotal_Target1</th>
    <td style="border-bottom:1px solid black;"></td>
EOF;
        // Check and add the formatted day headers only if they are not null
        if ($day1_param > 0) {
            $header .= '<td style="border-bottom:1px solid black;"></td>';
        }
        if ($day2_param > 0) {
            $header .= '<td style="border-bottom:1px solid black;"></td>';
        }
        if ($day3_param > 0) {
            $header .= '<td style="border-bottom:1px solid black;"></td>';
        }
        if ($day4_param > 0) {
            $header .= '<td style="border-bottom:1px solid black;"></td>';
        }
        if ($day5_param > 0) {
            $header .= '<td style="border-bottom:1px solid black;"></td>';
        }
        
    $header .= <<<EOF
    <td style="border-bottom:1px solid black;"></td>
    <td style="border-bottom:1px solid black;"></td>
    <td style="border-bottom:1px solid black;"></td>
    <td style="border-bottom:1px solid black;"></td>
</tr>



    <table style="border:none;">


    <tr>

    <th style="border:none;text-align:center;" colspan="2">Prepared by:</th>
    <th style="border:none;text-align:center;" colspan="2">Checked by:</th>
    <th style="border:none;text-align:center;" colspan="2">Noted by:</th>
EOF;
    // Check and add the formatted day headers only if they are not null
    if ($day1_param > 0) {
        $header .= '<th style="border:none;text-align:center;"></th>';
    }
    if ($day2_param > 0) {
        $header .= '<th style="border:none;text-align:center;"></th>';
    }
    if ($day3_param > 0) {
        $header .= '<th style="border:none;text-align:center;"></th>';
    }
    if ($day4_param > 0) {
        $header .= '<th style="border:none;text-align:center;"></th>';
    }
    if ($day5_param > 0) {
        $header .= '<th style="border:none;text-align:center;"></th>';
    }
    
$header .= <<<EOF
    <th style="border:none;text-align:center;"></th>
    <th style="border:none;text-align:center;"></th>
    <th style="border:none;text-align:center;"></th>

    </tr>

    <tr>
    <th style="border:none;" colspan="12"></th>
    </tr>

    <tr style="border:none;">

    <th style="border:none;text-align:center;font-weight:bold;" colspan="2">JASON R. ESTRELLANES</th>
    <th style="border:none;text-align:center;font-weight:bold;" colspan="2">JOHN REY D. PIAÑA <br><span style="font-weight:none;">CSR Dept. Head</span></th>
    <th style="border:none;text-align:center;font-weight:bold;" colspan="2">CHRISTINE G. NEPOMUCENO <br><span style="font-weight:none;">COMPTROLLER</span></th>
    <th style="border:none;text-align:center;font-weight:bold;" colspan="2">CHRISTOPHER M. JAMERO <br><span style="font-weight:none;">C.E.O</span></th>
    <th style="border:none;text-align:center;font-weight:bold;" colspan="2">DONALD M. JAMERO <br><span style="font-weight:none;">C.O.O</span></th>
    <th style="border:none;"></th>
    <th style="border:none;"></th>
    <th style="border:none;"></th>

    </tr>

    </table>
   
</tbody>
</table>

EOF;
}



    $pdf->writeHTML($header, false, false, false, false, '');
    
    $pdf->Output($reportName, 'I');
    
   }
  }  

  $clientsFormRequest = new printClientList();
  $clientsFormRequest -> getClientsPrinting();

?>
