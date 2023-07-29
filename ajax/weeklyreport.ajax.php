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
$filterBackup -> showFilter();

class reportTable{
	public function showFilter(){
      
        $weekfrom = $_GET['weekfrom'];
        $weekto = $_GET['weekto'];

        
        $startDate = new DateTime($weekfrom);
        $endDate = new DateTime($weekto);

        $currentDate = clone $startDate;

        $date = date('Y-m', strtotime($weekfrom));

        $month = date('F', strtotime($weekfrom));
        $dateRange = array();

        while ($currentDate <= $endDate) {
            $dateRange[] = $currentDate->format('Y-m-d');
            $currentDate->modify('+1 day');
         }
            $day1 = $dateRange[0];
            $day2 = $dateRange[1];
            $day3 = $dateRange[2];
            $day4 = $dateRange[3];
            $day5 = $dateRange[4];

            $formatted_day1 = (new DateTime($day1))->format('F d');
            $formatted_day2 = (new DateTime($day2))->format('F d');
            $formatted_day3 = (new DateTime($day3))->format('F d');
            $formatted_day4 = (new DateTime($day4))->format('F d');
            $formatted_day5 = (new DateTime($day5))->format('F d');

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
                $combinedDates = $date1 . '-' . $date2;
            
             


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


        foreach ($data1 as &$item) {
           
            $item['card'] ='
            <thead>

            <tr>
              <th>EMB BRANCHES</th>
              <th>BRANCH</th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th colspan="3">CLASSIFICATION OF PDR PAYMENT PER ENDORSEMENT DATE</th>
            </tr>

            <tr>
              <th></th>
              <th>TARGETS</th>
              <th>CUM AS OF '.$combinedDates.'</th>
              <th>'.$formatted_day1.'</th>
              <th>'.$formatted_day2.'</th>
              <th>'.$formatted_day3.'</th>
              <th>'.$formatted_day4.'</th>
              <th>'.$formatted_day5.'</th>
              <th>TOTAL</th>
              <th>BELOW 6 MONTHS</th>
              <th>6 MONTHS 1 YEAR</th>
              <th>1 YEAR AND ABOVE</th>
            </tr>

            <tr>
              <th></th>
              <th>FOR '.$month.'</th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
            </tr>
            <tbody>
            ';
        
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
            $getDay1 = (new ControllerPastdue)->ctrGetDay1($full_name, $day1);
            $getDay2 = (new ControllerPastdue)->ctrGetDay2($full_name, $day2);
            $getDay3 = (new ControllerPastdue)->ctrGetDay3($full_name, $day3);
            $getDay4 = (new ControllerPastdue)->ctrGetDay3($full_name, $day4);
            $getDay5 = (new ControllerPastdue)->ctrGetDay3($full_name, $day5);

            $getBelow6 = (new ControllerPastdue)->ctrGetBelow6($full_name, $day1, $day5);
            $getBelow6And1 = (new ControllerPastdue)->ctrGet6And1year($full_name, $day1, $day5);
            $getAbove1 = (new ControllerPastdue)->ctrGetAbove1($full_name, $day1, $day5);
            $getCumTotal =  (new ControllerPastdue)->ctrGetCumTotal($full_name, $minRange, $maxRange);

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
                    if($day1_total1 !=""){
                        $day1_total = number_format((float)$day1_total1, 2, '.', ',');
                        $footer_totalDay1 += $day1_total1;
                    }else{

                        $day1_total ="";
                    }
                }
            }else{
                $day1_total =""; 
            }

             if(!empty($getDay2)){
                foreach ($getDay2 as $key => $value2) {
                    $day2_total2  = $value2['total_day1'];
                    if($day2_total2 !=""){
                        $day2_total = number_format((float)$day2_total2, 2, '.', ',');
                        $footer_totalDay2 += $day2_total2;
                    }else{

                        $day2_total ="";
                    }
                }
            }else{
                $day2_total =""; 
            }

            if(!empty($getDay3)){
                foreach ($getDay3 as $key => $value3) {
                    $day3_total3  = $value3['total_day1'];
                    if($day3_total3 !=""){
                        $day3_total = number_format((float)$day3_total3, 2, '.', ',');
                        $footer_totalDay3 += $day3_total3;
                    }else{

                        $day3_total ="";
                    }
                }
            }else{
                $day3_total =""; 
            }
            if(!empty($getDay4)){
                foreach ($getDay4 as $key => $value4) {
                    $day4_total4  = $value4['total_day1'];
                    if($day4_total4 !=""){
                        $day4_total = number_format((float)$day4_total4, 2, '.', ',');
                        $footer_totalDay4 += $day4_total4;
                    }else{

                        $day4_total ="";
                    }
                }
            }else{
                $day4_total =""; 
            }

            if(!empty($getDay5)){
                foreach ($getDay5 as $key => $value5) {
                    $day5_total5  = $value5['total_day1'];
                    if($day5_total5 !=""){
                        $day5_total = number_format((float)$day5_total5, 2, '.', ',');
                        $footer_totalDay5 += $day5_total5;
                    }else{

                        $day5_total ="";
                    }
                }
            }else{
                $day5_total =""; 
            }

            $total1 = $day1_total1 + $day2_total2 + $day3_total3 +$day4_total4 +$day5_total5;

            $footer_totalTotal += $total1;

            if($total1 !=0){
                $total = number_format((float)$total1, 2, '.', ',');
            }else{
                $total = "";
            }

            
            if(!empty($getBelow6)){
                foreach ($getBelow6 as $key => $row) {
                    $below6  = $row['total_below6'];
                    $branch_name  = $row['branch_name'];
                    if($below6 !=""){
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
                    if($below6And1 !=""){
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
                    if($above1 !=""){
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
                    if($totalCumi1 !=""){
                        $totalCumi = number_format((float)$totalCumi1, 2, '.', ',');
                        $footer_totalCumi += $totalCumi1;
                    }else{

                        $totalCumi =" - ";
                    }
                }
            }else{
                $totalCumi =" - "; 
            }


        
          
            $item['card'] .='
            <tr>
                <td>'.$full_name.'</td>
                <td>'.$amount.'</td>
                <td>'.$totalCumi.'</td>
                <td>'.$day1_total.'</td>
                <td>'.$day2_total.'</td>
                <td>'.$day3_total.'</td>
                <td>'.$day4_total.'</td>
                <td>'.$day5_total.'</td>
                <td>'.$total.'</td>
                <td>'.$total_below6.'</td>
                <td>'.$total_below6And1.'</td>
                <td>'.$total_belowAbove1.'</td>
          </tr>

            ';
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
 
    $footer_totalTarget1 = number_format((float)$footer_totalTarget, 2, '.', ',');
    $footer_totalCumi1 = number_format((float)$footer_totalCumi, 2, '.', ',');
    $footer_totalDay11 = number_format((float)$footer_totalDay1, 2, '.', ',');
    $footer_totalDay22 = number_format((float)$footer_totalDay2, 2, '.', ',');
    $footer_totalDay33 = number_format((float)$footer_totalDay3, 2, '.', ',');
    $footer_totalDay44 = number_format((float)$footer_totalDay4, 2, '.', ',');
    $footer_totalDay55 = number_format((float)$footer_totalDay5, 2, '.', ',');
    $footer_totalTotal1 = number_format((float)$footer_totalTotal, 2, '.', ',');
    $footer_totalBelow66 = number_format((float)$footer_totalBelow6, 2, '.', ',');
    $footer_total6And11 = number_format((float)$footer_total6And1, 2, '.', ',');
    $footer_totalAbove11 = number_format((float)$footer_totalAbove1, 2, '.', ',');
        $item['card'] .='
        <tr>
        <th>TOTAL</th>
        <th>'.$footer_totalTarget1.'</th>
        <th>'.$footer_totalCumi1.'</th>
        <th>'.$footer_totalDay11.'</th>
        <th>'.$footer_totalDay22.'</th>
        <th>'.$footer_totalDay33.'</th>
        <th>'.$footer_totalDay44.'</th>
        <th>'.$footer_totalDay55.'</th>
        <th>'.$footer_totalTotal1.'</th>
        <th>'.$footer_totalBelow66.'</th>
        <th>'.$footer_total6And11.'</th>
        <th>'.$footer_totalAbove11.'</th>
  </tr>
        <tr>
            <th>FCH BRANCHES</th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        <tr>
            <td></td>
            <td>BRANCH</td>
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
        <tr>
            <td></td>
            <td>TARGETS</td>
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
        <tr>
            <td></td>
            <td>FOR '.$month.'</td>
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
                $getDay1 = (new ControllerPastdue)->ctrGetDay1($full_name, $day1);
                $getDay2 = (new ControllerPastdue)->ctrGetDay2($full_name, $day2);
                $getDay3 = (new ControllerPastdue)->ctrGetDay3($full_name, $day3);
                $getDay4 = (new ControllerPastdue)->ctrGetDay3($full_name, $day4);
                $getDay5 = (new ControllerPastdue)->ctrGetDay3($full_name, $day5);
    
                $getBelow6 = (new ControllerPastdue)->ctrGetBelow6($full_name, $day1, $day5);
                $getBelow6And1 = (new ControllerPastdue)->ctrGet6And1year($full_name, $day1, $day5);
                $getAbove1 = (new ControllerPastdue)->ctrGetAbove1($full_name, $day1, $day5);
                $getCumTotal =  (new ControllerPastdue)->ctrGetCumTotal($full_name, $minRange, $maxRange);
    
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
                        if($day1_total1 !=""){
                            $day1_total = number_format((float)$day1_total1, 2, '.', ',');
                            $footer_totalDay1 += $day1_total1;
                        }else{
    
                            $day1_total ="";
                        }
                    }
                }else{
                    $day1_total =""; 
                }
    
                 if(!empty($getDay2)){
                    foreach ($getDay2 as $key => $value2) {
                        $day2_total2  = $value2['total_day1'];
                        if($day2_total2 !=""){
                            $day2_total = number_format((float)$day2_total2, 2, '.', ',');
                            $footer_totalDay2 += $day2_total2;
                        }else{
    
                            $day2_total ="";
                        }
                    }
                }else{
                    $day2_total =""; 
                }
    
                if(!empty($getDay3)){
                    foreach ($getDay3 as $key => $value3) {
                        $day3_total3  = $value3['total_day1'];
                        if($day3_total3 !=""){
                            $day3_total = number_format((float)$day3_total3, 2, '.', ',');
                            $footer_totalDay3 += $day3_total3;
                        }else{
    
                            $day3_total ="";
                        }
                    }
                }else{
                    $day3_total =""; 
                }
                if(!empty($getDay4)){
                    foreach ($getDay4 as $key => $value4) {
                        $day4_total4  = $value4['total_day1'];
                        if($day4_total4 !=""){
                            $day4_total = number_format((float)$day4_total4, 2, '.', ',');
                            $footer_totalDay4 += $day4_total4;
                        }else{
    
                            $day4_total ="";
                        }
                    }
                }else{
                    $day4_total =""; 
                }
    
                if(!empty($getDay5)){
                    foreach ($getDay5 as $key => $value5) {
                        $day5_total5  = $value5['total_day1'];
                        if($day5_total5 !=""){
                            $day5_total = number_format((float)$day5_total5, 2, '.', ',');
                            $footer_totalDay5 += $day5_total5;
                        }else{
    
                            $day5_total ="";
                        }
                    }
                }else{
                    $day5_total =""; 
                }
    
                $total1 = $day1_total1 + $day2_total2 + $day3_total3 +$day4_total4 +$day5_total5;
    
                $footer_totalTotal += $total1;
    
                if($total1 !=0){
                    $total = number_format((float)$total1, 2, '.', ',');
                }else{
                    $total = "";
                }
    
                
                if(!empty($getBelow6)){
                    foreach ($getBelow6 as $key => $row) {
                        $below6  = $row['total_below6'];
                        $branch_name  = $row['branch_name'];
                        if($below6 !=""){
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
                        if($below6And1 !=""){
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
                        if($above1 !=""){
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
                        if($totalCumi1 !=""){
                            $totalCumi = number_format((float)$totalCumi1, 2, '.', ',');
                            $footer_totalCumi += $totalCumi1;
                        }else{
    
                            $totalCumi =" - ";
                        }
                    }
                }else{
                    $totalCumi =" - "; 
                }
    
    
            
              
                $item['card'] .='
                <tr>
                    <td>'.$full_name.'</td>
                    <td>'.$amount.'</td>
                    <td>'.$totalCumi.'</td>
                    <td>'.$day1_total.'</td>
                    <td>'.$day2_total.'</td>
                    <td>'.$day3_total.'</td>
                    <td>'.$day4_total.'</td>
                    <td>'.$day5_total.'</td>
                    <td>'.$total.'</td>
                    <td>'.$total_below6.'</td>
                    <td>'.$total_below6And1.'</td>
                    <td>'.$total_belowAbove1.'</td>
              </tr>
    
                ';
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

    $footer_totalTarget1 = number_format((float)$footer_totalTarget, 2, '.', ',');
    $footer_totalCumi1 = number_format((float)$footer_totalCumi, 2, '.', ',');
    $footer_totalDay11 = number_format((float)$footer_totalDay1, 2, '.', ',');
    $footer_totalDay22 = number_format((float)$footer_totalDay2, 2, '.', ',');
    $footer_totalDay33 = number_format((float)$footer_totalDay3, 2, '.', ',');
    $footer_totalDay44 = number_format((float)$footer_totalDay4, 2, '.', ',');
    $footer_totalDay55 = number_format((float)$footer_totalDay5, 2, '.', ',');
    $footer_totalTotal1 = number_format((float)$footer_totalTotal, 2, '.', ',');
    $footer_totalBelow66 = number_format((float)$footer_totalBelow6, 2, '.', ',');
    $footer_total6And11 = number_format((float)$footer_total6And1, 2, '.', ',');
    $footer_totalAbove11 = number_format((float)$footer_totalAbove1, 2, '.', ',');
        $item['card'] .='
        <tr>
        <th>TOTAL</th>
        <th>'.$footer_totalTarget1.'</th>
        <th>'.$footer_totalCumi1.'</th>
        <th>'.$footer_totalDay11.'</th>
        <th>'.$footer_totalDay22.'</th>
        <th>'.$footer_totalDay33.'</th>
        <th>'.$footer_totalDay44.'</th>
        <th>'.$footer_totalDay55.'</th>
        <th>'.$footer_totalTotal1.'</th>
        <th>'.$footer_totalBelow66.'</th>
        <th>'.$footer_total6And11.'</th>
        <th>'.$footer_totalAbove11.'</th>
  </tr>
        <tr>
            <th>RLC BRANCHES</th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        <tr>
            <td></td>
            <td>BRANCH</td>
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
        <tr>
            <td></td>
            <td>TARGETS</td>
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
        <tr>
            <td></td>
            <td>FOR '.$month.'</td>
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
                $getDay1 = (new ControllerPastdue)->ctrGetDay1($full_name, $day1);
                $getDay2 = (new ControllerPastdue)->ctrGetDay2($full_name, $day2);
                $getDay3 = (new ControllerPastdue)->ctrGetDay3($full_name, $day3);
                $getDay4 = (new ControllerPastdue)->ctrGetDay3($full_name, $day4);
                $getDay5 = (new ControllerPastdue)->ctrGetDay3($full_name, $day5);
    
                $getBelow6 = (new ControllerPastdue)->ctrGetBelow6($full_name, $day1, $day5);
                $getBelow6And1 = (new ControllerPastdue)->ctrGet6And1year($full_name, $day1, $day5);
                $getAbove1 = (new ControllerPastdue)->ctrGetAbove1($full_name, $day1, $day5);
                $getCumTotal =  (new ControllerPastdue)->ctrGetCumTotal($full_name, $minRange, $maxRange);
    
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
                        if($day1_total1 !=""){
                            $day1_total = number_format((float)$day1_total1, 2, '.', ',');
                            $footer_totalDay1 += $day1_total1;
                        }else{
    
                            $day1_total ="";
                        }
                    }
                }else{
                    $day1_total =""; 
                }
    
                 if(!empty($getDay2)){
                    foreach ($getDay2 as $key => $value2) {
                        $day2_total2  = $value2['total_day1'];
                        if($day2_total2 !=""){
                            $day2_total = number_format((float)$day2_total2, 2, '.', ',');
                            $footer_totalDay2 += $day2_total2;
                        }else{
    
                            $day2_total ="";
                        }
                    }
                }else{
                    $day2_total =""; 
                }
    
                if(!empty($getDay3)){
                    foreach ($getDay3 as $key => $value3) {
                        $day3_total3  = $value3['total_day1'];
                        if($day3_total3 !=""){
                            $day3_total = number_format((float)$day3_total3, 2, '.', ',');
                            $footer_totalDay3 += $day3_total3;
                        }else{
    
                            $day3_total ="";
                        }
                    }
                }else{
                    $day3_total =""; 
                }
                if(!empty($getDay4)){
                    foreach ($getDay4 as $key => $value4) {
                        $day4_total4  = $value4['total_day1'];
                        if($day4_total4 !=""){
                            $day4_total = number_format((float)$day4_total4, 2, '.', ',');
                            $footer_totalDay4 += $day4_total4;
                        }else{
    
                            $day4_total ="";
                        }
                    }
                }else{
                    $day4_total =""; 
                }
    
                if(!empty($getDay5)){
                    foreach ($getDay5 as $key => $value5) {
                        $day5_total5  = $value5['total_day1'];
                        if($day5_total5 !=""){
                            $day5_total = number_format((float)$day5_total5, 2, '.', ',');
                            $footer_totalDay5 += $day5_total5;
                        }else{
    
                            $day5_total ="";
                        }
                    }
                }else{
                    $day5_total =""; 
                }
    
                $total1 = $day1_total1 + $day2_total2 + $day3_total3 +$day4_total4 +$day5_total5;
    
                $footer_totalTotal += $total1;
    
                if($total1 !=0){
                    $total = number_format((float)$total1, 2, '.', ',');
                }else{
                    $total = "";
                }
    
                
                if(!empty($getBelow6)){
                    foreach ($getBelow6 as $key => $row) {
                        $below6  = $row['total_below6'];
                        $branch_name  = $row['branch_name'];
                        if($below6 !=""){
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
                        if($below6And1 !=""){
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
                        if($above1 !=""){
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
                        if($totalCumi1 !=""){
                            $totalCumi = number_format((float)$totalCumi1, 2, '.', ',');
                            $footer_totalCumi += $totalCumi1;
                        }else{
    
                            $totalCumi =" - ";
                        }
                    }
                }else{
                    $totalCumi =" - "; 
                }
    
    
            
              
                $item['card'] .='
                <tr>
                    <td>'.$full_name.'</td>
                    <td>'.$amount.'</td>
                    <td>'.$totalCumi.'</td>
                    <td>'.$day1_total.'</td>
                    <td>'.$day2_total.'</td>
                    <td>'.$day3_total.'</td>
                    <td>'.$day4_total.'</td>
                    <td>'.$day5_total.'</td>
                    <td>'.$total.'</td>
                    <td>'.$total_below6.'</td>
                    <td>'.$total_below6And1.'</td>
                    <td>'.$total_belowAbove1.'</td>
              </tr>
                ';
            }
        }
        
  
    

    $footer_totalTarget1 = number_format((float)$footer_totalTarget, 2, '.', ',');
    $footer_totalCumi1 = number_format((float)$footer_totalCumi, 2, '.', ',');
    $footer_totalDay11 = number_format((float)$footer_totalDay1, 2, '.', ',');
    $footer_totalDay22 = number_format((float)$footer_totalDay2, 2, '.', ',');
    $footer_totalDay33 = number_format((float)$footer_totalDay3, 2, '.', ',');
    $footer_totalDay44 = number_format((float)$footer_totalDay4, 2, '.', ',');
    $footer_totalDay55 = number_format((float)$footer_totalDay5, 2, '.', ',');
    $footer_totalTotal1 = number_format((float)$footer_totalTotal, 2, '.', ',');
    $footer_totalBelow66 = number_format((float)$footer_totalBelow6, 2, '.', ',');
    $footer_total6And11 = number_format((float)$footer_total6And1, 2, '.', ',');
    $footer_totalAbove11 = number_format((float)$footer_totalAbove1, 2, '.', ',');


        $item['card'] .='
        <tr>
        <th>TOTAL</th>
        <th>'.$footer_totalTarget1.'</th>
        <th>'.$footer_totalCumi1.'</th>
        <th>'.$footer_totalDay11.'</th>
        <th>'.$footer_totalDay22.'</th>
        <th>'.$footer_totalDay33.'</th>
        <th>'.$footer_totalDay44.'</th>
        <th>'.$footer_totalDay55.'</th>
        <th>'.$footer_totalTotal1.'</th>
        <th>'.$footer_totalBelow66.'</th>
        <th>'.$footer_total6And11.'</th>
        <th>'.$footer_totalAbove11.'</th>
    </tr>
    <tr>
            <th>ELC BRANCHES</th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        <tr>
            <td></td>
            <td>BRANCH</td>
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
        <tr>
            <td></td>
            <td>TARGETS</td>
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
        <tr>
            <td></td>
            <td>FOR '.$month.'</td>
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
                $getDay1 = (new ControllerPastdue)->ctrGetDay1($full_name, $day1);
                $getDay2 = (new ControllerPastdue)->ctrGetDay2($full_name, $day2);
                $getDay3 = (new ControllerPastdue)->ctrGetDay3($full_name, $day3);
                $getDay4 = (new ControllerPastdue)->ctrGetDay3($full_name, $day4);
                $getDay5 = (new ControllerPastdue)->ctrGetDay3($full_name, $day5);
    
                $getBelow6 = (new ControllerPastdue)->ctrGetBelow6($full_name, $day1, $day5);
                $getBelow6And1 = (new ControllerPastdue)->ctrGet6And1year($full_name, $day1, $day5);
                $getAbove1 = (new ControllerPastdue)->ctrGetAbove1($full_name, $day1, $day5);
                $getCumTotal =  (new ControllerPastdue)->ctrGetCumTotal($full_name, $minRange, $maxRange);
    
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
                        if($day1_total1 !=""){
                            $day1_total = number_format((float)$day1_total1, 2, '.', ',');
                            $footer_totalDay1 += $day1_total1;
                        }else{
    
                            $day1_total ="";
                        }
                    }
                }else{
                    $day1_total =""; 
                }
    
                 if(!empty($getDay2)){
                    foreach ($getDay2 as $key => $value2) {
                        $day2_total2  = $value2['total_day1'];
                        if($day2_total2 !=""){
                            $day2_total = number_format((float)$day2_total2, 2, '.', ',');
                            $footer_totalDay2 += $day2_total2;
                        }else{
    
                            $day2_total ="";
                        }
                    }
                }else{
                    $day2_total =""; 
                }
    
                if(!empty($getDay3)){
                    foreach ($getDay3 as $key => $value3) {
                        $day3_total3  = $value3['total_day1'];
                        if($day3_total3 !=""){
                            $day3_total = number_format((float)$day3_total3, 2, '.', ',');
                            $footer_totalDay3 += $day3_total3;
                        }else{
    
                            $day3_total ="";
                        }
                    }
                }else{
                    $day3_total =""; 
                }
                if(!empty($getDay4)){
                    foreach ($getDay4 as $key => $value4) {
                        $day4_total4  = $value4['total_day1'];
                        if($day4_total4 !=""){
                            $day4_total = number_format((float)$day4_total4, 2, '.', ',');
                            $footer_totalDay4 += $day4_total4;
                        }else{
    
                            $day4_total ="";
                        }
                    }
                }else{
                    $day4_total =""; 
                }
    
                if(!empty($getDay5)){
                    foreach ($getDay5 as $key => $value5) {
                        $day5_total5  = $value5['total_day1'];
                        if($day5_total5 !=""){
                            $day5_total = number_format((float)$day5_total5, 2, '.', ',');
                            $footer_totalDay5 += $day5_total5;
                        }else{
    
                            $day5_total ="";
                        }
                    }
                }else{
                    $day5_total =""; 
                }
    
                $total1 = $day1_total1 + $day2_total2 + $day3_total3 +$day4_total4 +$day5_total5;
    
                $footer_totalTotal += $total1;
    
                if($total1 !=0){
                    $total = number_format((float)$total1, 2, '.', ',');
                }else{
                    $total = "";
                }
    
                
                if(!empty($getBelow6)){
                    foreach ($getBelow6 as $key => $row) {
                        $below6  = $row['total_below6'];
                        $branch_name  = $row['branch_name'];
                        if($below6 !=""){
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
                        if($below6And1 !=""){
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
                        if($above1 !=""){
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
                        if($totalCumi1 !=""){
                            $totalCumi = number_format((float)$totalCumi1, 2, '.', ',');
                            $footer_totalCumi += $totalCumi1;
                        }else{
    
                            $totalCumi =" - ";
                        }
                    }
                }else{
                    $totalCumi =" - "; 
                }
    
    
            
              
                $item['card'] .='
                <tr>
                    <td>'.$full_name.'</td>
                    <td>'.$amount.'</td>
                    <td>'.$totalCumi.'</td>
                    <td>'.$day1_total.'</td>
                    <td>'.$day2_total.'</td>
                    <td>'.$day3_total.'</td>
                    <td>'.$day4_total.'</td>
                    <td>'.$day5_total.'</td>
                    <td>'.$total.'</td>
                    <td>'.$total_below6.'</td>
                    <td>'.$total_below6And1.'</td>
                    <td>'.$total_belowAbove1.'</td>
              </tr>
    
                ';
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
    
        $grandTotal_Target1 = number_format((float)$grandTotal_Target, 2, '.', ',');
        $grandTotal_Cumi1 = number_format((float)$grandTotal_Cumi, 2, '.', ',');
        $grandTotal_Day11 = number_format((float)$grandTotal_Day1, 2, '.', ',');
        $grandTotal_Day22 = number_format((float)$grandTotal_Day2, 2, '.', ',');
        $grandTotal_Day33 = number_format((float)$grandTotal_Day3, 2, '.', ',');
        $grandTotal_Day44 = number_format((float)$grandTotal_Day4, 2, '.', ',');
        $grandTotal_Day55 = number_format((float)$grandTotal_Day5, 2, '.', ',');
        $grandTotal_Total1 = number_format((float)$grandTotal_Total, 2, '.', ',');
        $grandTotal_Below66 = number_format((float)$grandTotal_Below6, 2, '.', ',');
        $grandTotal_6And11 = number_format((float)$grandTotal_6And1, 2, '.', ',');
        $grandTotal_Above11 = number_format((float)$grandTotal_Above1, 2, '.', ',');

        $footer_totalTarget1 = number_format((float)$footer_totalTarget, 2, '.', ',');
        $footer_totalCumi1 = number_format((float)$footer_totalCumi, 2, '.', ',');
        $footer_totalDay11 = number_format((float)$footer_totalDay1, 2, '.', ',');
        $footer_totalDay22 = number_format((float)$footer_totalDay2, 2, '.', ',');
        $footer_totalDay33 = number_format((float)$footer_totalDay3, 2, '.', ',');
        $footer_totalDay44 = number_format((float)$footer_totalDay4, 2, '.', ',');
        $footer_totalDay55 = number_format((float)$footer_totalDay5, 2, '.', ',');
        $footer_totalTotal1 = number_format((float)$footer_totalTotal, 2, '.', ',');
        $footer_totalBelow66 = number_format((float)$footer_totalBelow6, 2, '.', ',');
        $footer_total6And11 = number_format((float)$footer_total6And1, 2, '.', ',');
        $footer_totalAbove11 = number_format((float)$footer_totalAbove1, 2, '.', ',');


    
        $item['card'] .=' 
        <tr>
        <th>TOTAL</th>
        <th>'.$footer_totalTarget1.'</th>
        <th>'.$footer_totalCumi1.'</th>
        <th>'.$footer_totalDay11.'</th>
        <th>'.$footer_totalDay22.'</th>
        <th>'.$footer_totalDay33.'</th>
        <th>'.$footer_totalDay44.'</th>
        <th>'.$footer_totalDay55.'</th>
        <th>'.$footer_totalTotal1.'</th>
        <th>'.$footer_totalBelow66.'</th>
        <th>'.$footer_total6And11.'</th>
        <th>'.$footer_totalAbove11.'</th>
    </tr>  
        <tr>
        <th>GRAND TOTAL</th>
        <th></th>
        <th>'.$grandTotal_Cumi1.'</th>
        <th>'.$grandTotal_Day11.'</th>
        <th>'.$grandTotal_Day22.'</th>
        <th>'.$grandTotal_Day33.'</th>
        <th>'.$grandTotal_Day44.'</th>
        <th>'.$grandTotal_Day55.'</th>
        <th>'.$grandTotal_Total1.'</th>
        <th>'.$grandTotal_Below66.'</th>
        <th>'.$grandTotal_6And11.'</th>
        <th>'.$grandTotal_Above11.'</th>
    </tr>
    <tr>
        <th>TOTAL TARGET</th>
        <th>'.$grandTotal_Target1.'</th>
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
        </tbody>

        ';
        }
        echo json_encode($data1);
    }
   
}