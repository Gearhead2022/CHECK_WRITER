<?php

require_once "../../../models/connection.php";
require_once "../../../views/modules/session.php";

class printClientList{

    public $chk_id; 
    // public $prrdateto; 
    // public $clientCategory; 
   
public function getClientsPrinting(){
    $reportDate = $_REQUEST['reportDate'];
    $reportName= "$reportDate".".pdf";

    $connection = new connection;
    $connection->connect();
    $date = date('F j, Y');

    // $prrdatefrom = $_REQUEST['prrdatefrom'];
    // $prrdateto = $_REQUEST['prrdateto'];
    // $clientCategory = $_REQUEST['clientCategory'];

    // $prrdatefromTomon = date('Ymd',strtotime($prrdatefrom));
    // $prrdatetoTomon = date('Ymd',strtotime($prrdateto));
    // $from_year = date('Y',strtotime($prrdatefrom));
    // $to_year = date('Y',strtotime($prrdateto));
    // $curYear = date("Y");

    // $branch_name = $_SESSION['branch_name'];

    // $new_branch_name = strtoupper($branch_name);

    $chk_id = $_REQUEST['chk_id'];

    
    if ($chk_id !== "") {
        $sql = "SELECT * FROM checklist_report 
            WHERE chk_id = '$chk_id'";

        $stmt = $connection->connect()->query($sql);
        

        $sql_1 = "SELECT * FROM checklist 
            WHERE chk_id = '$chk_id'";

        $stmt_1 = $connection->connect()->query($sql_1);

    }

    while($info = $stmt_1->fetch()){
        $emp_fullname = $info['full_name'];
    }

  require_once('tcpdf_include.php');


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
$pdf->SetMargins(16,16);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


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



$header = <<<EOF
    <style>
    *{
        font-family:"Calibri", sans-serif;
    }
    </style>

    <table style="width: 100%;">
    <tr>
        <td style="width: 28%; background-color:green;"></td> <!-- Empty cell for spacing -->
        <td style="width: 45%; text-align: center; color: white; background-color:green;"><h1>DAILY CHECKLIST</h1></td> <!-- Centered cell -->
        <td style="width: 30%; background-color:green;"></td> <!-- Empty cell for spacing -->
    </tr>
    <tr>
        <td style="width: 28%;  background-color: rgb(76, 181, 115);"></td> <!-- Empty cell for spacing -->
        <td style="width: 45%; text-transform: uppercase; color: white; text-align: center;  background-color:rgb(76, 181, 115);"><p>$emp_fullname</p></td> <!-- Centered cell -->
        <td style="width: 30%;  background-color:rgb(76, 181, 115);"></td> <!-- Empty cell for spacing -->
        
    </tr>
    <tr style="border: 1px solid black;">
        <td style="width: 28%;  border-left: 1px solid black;"></td> <!-- Empty cell for spacing -->
        <td style="width: 45%;text-align: center; font-size: 13px"><p>$reportDate</p></td> <!-- Centered cell -->
        <td style="width: 30%; border-right: 1px solid black;"></td> <!-- Empty cell for spacing -->
    </tr>
       </table>
     <table>    
        <thead>
         <tr style="border: 1px solid #999;">

            <th style="width:280px;text-align:center;font-size:9px;color:white;background-color:rgb(66, 129, 245); font-weight: bold; border: 1px solid black;">&nbsp;TASK DETAILS / DESCRIPTION</th>

            <th style="width:100px;text-align:center;font-size:9px;color:white;background-color:rgb(66, 129, 245); font-weight: bold; border: 1px solid black;">&nbsp;PRIORITY</th>
                                                                
            <th style="width:60px;text-align:center;font-size:9px;color:white;background-color:rgb(66, 129, 245); font-weight: bold; border: 1px solid black;">&nbsp;STARTED</th>
    
            <th style="width:100px;text-align:center;font-size:9px;color:white;background-color:rgb(66, 129, 245); font-weight: bold; border: 1px solid black;">&nbsp;ACTUAL DATE END</th>
        
            <th style="width:100px;text-align:center;font-size:9px;color:white;background-color:rgb(66, 129, 245); font-weight: bold; border: 1px solid black;">&nbsp;STATUS</th>
                                                                
            <th style="width:327px;text-align:center;font-size:9px;color:white;background-color:rgb(66, 129, 245); font-weight: bold; border: 1px solid black;">&nbsp;NOTES</th>

        </tr>                 
    </thead>
    <tbody>
    
EOF;  


$num = 1;
while($check = $stmt->fetch()){
    $chk_id = $check['chk_id'];
    $chk_task = $check['chk_task'];
    $chk_prio = $check['chk_prio'];
    $chk_status = $check['chk_status'];
    $chk_notes = $check['chk_notes'];
    $chk_start = $check['chk_start'];
    $chk_end = $check['chk_end'];

    
    $count = intval($num++);


    if ($chk_prio == 'CRITICAL') {
        $prio_color = 'red';
        $prio_txt_color = 'white';
    } elseif ($chk_prio == 'HIGH'){
        $prio_color = 'rgb(252, 132, 3)';
        $prio_txt_color = 'white';
    } elseif ($chk_prio == 'MEDIUM'){
        $prio_color = 'blue';
        $prio_txt_color = 'white';
    } else{
        $prio_color = 'yellow';
        $prio_txt_color = 'black';
    }

    if ($chk_status == 'PENDING') {
        $status_color = 'rgb(140, 27, 27)';
        $status_txt_color = 'white';
    } elseif ($chk_status == 'ON GOING'){
        $status_color = 'yellow';
        $status_txt_color = 'white';
    } elseif ($chk_status == 'DONE'){
        $status_color = 'green';
        $status_txt_color = 'white';
    
    } elseif ($chk_status == 'IN DEVELOPMENT'){
        $status_color = 'rgb(99, 13, 99)';
        $status_txt_color = 'white';
    } elseif ($chk_status == 'DEPLOYED'){
        $status_color = 'rgb(13, 43, 99)';
        $status_txt_color = 'white';    
    } else{
        $status_color = 'gray';
        $status_txt_color = 'white';
    }
    
    

    if(!empty($chk_start)){
        $chk_startFormatted = date('F d, Y', strtotime($chk_start));
    }else{
        $chk_startFormatted="";
    }
    if(!empty($chk_end)){
        $chk_endFormatted = date('F d, Y', strtotime($chk_end));
    }else{
        $chk_endFormatted="";
    }
    


$header .= <<<EOF


    <tr  style="border: 1px solid #black;">
        <td style="width:280px;text-align:left;font-size:8px; border: 1px solid #black;">$count. $chk_task</td>

        <td style="width:100px;text-align:center;font-size:9px;  background-color: $prio_color; font-weight: bold; color: $prio_txt_color; border: 1px solid #black;">$chk_prio</td>
                                                            
        <td style="width:60px;text-align:left;font-size:8px;margin-right: 5px; border: 1px solid #black;">$chk_startFormatted</td>

        <td style="width:100px;text-align:left;font-size:8px; margin-right: 15px; border: 1px solid #black;">$chk_endFormatted</td>

        <td style="width:100px;text-align:center;font-size:9px; font-weight: bold; color:$status_txt_color; background-color: $status_color; border: 1px solid #black;">$chk_status</td>
                                                            
        <td style="width:327px;text-align:left;font-size:8px; text-align: center; margin-right: 5px; border: 1px solid #black;">$chk_notes</td>
    
    </tr>
    

EOF;

}


$header .= <<<EOF
</tbody>
</table>
<br>
<br>
<table style="margin-top: 5px;">    

<tr style="border: 1px solid #999;">

   <td style="width:150px;font-size:8px;color:black;">&nbsp;&nbsp;CHECKED BY: </td>

   <td style="width:40px;"></td>
                                                       
   <td style="width:80px;">&nbsp;</td>

   <td style="width:110px;font-size:8px;color:black;">&nbsp;APPROVED BY: </td>

   <td style="width:60px;">&nbsp;</td>
                                                       
   <td style="width:145px;">&nbsp;</td>

</tr>                 
</table>
<table style="margin-top: 5px;">    

<tr style="border: 1px solid #999;">

   <td style="width:200px;font-size:8px;color:black;">&nbsp;_________________________</td>

   <td style="width:40px;"></td>
                                                       
   <td style="width:30px;">&nbsp;</td>

   <td style="width:200px;font-size:8px;color:black;">&nbsp;_________________________</td>

   <td style="width:60px;">&nbsp;</td>
                                                       
   <td style="width:145px;">&nbsp;</td>

</tr>                 
</table>
<table style="margin-top: 5px;">    

<tr style="border: 1px solid #999;">

   <th style="width:120px;font-size:8px;color:black; font-weight: bold;" colspan="3">&nbsp;&nbsp;&nbsp;EDGARDO G. GUERERO <span style="font-weight:none; font-size: 7px; text-align: center;">MIS DEPARTMENT HEAD</span></th>

   <td style="width:60px; ">&nbsp;</td>
                                                       
   <td style="width:90px; ">&nbsp;</td>

   <th style="width:130px;font-size:8px;color:black; font-weight: bold;" colspan="3">&nbsp;CHRISTINE G. NEPOMUCENO <span style="font-weight:none; font-size: 7px; text-align: center;">COMPTROLLER / CFO</span></th>

   <td style="width:60px;">&nbsp;</td>
                                                       
   <td style="width:145px;">&nbsp;</td>

</tr>                 
</table>

EOF;



    $pdf->writeHTML($header, false, false, false, false, '');
    
    $pdf->Output('Fully Paid Reports', 'I'); 
    
   }
  }  

  $clientsFormRequest = new printClientList();
  $clientsFormRequest -> getClientsPrinting();

?>