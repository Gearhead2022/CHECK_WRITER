<?php

require_once "../../../models/connection.php";


class printClientList{

    public $ref_id; 
public function getClientsPrinting(){

    $connection = new connection;
    $connection->connect();

    $report_id1 = $_REQUEST['report_id1'];
    
    $sql = "SELECT * FROM fp_report1 WHERE report_id1 = '$report_id1'";
        $stmt = $connection->connect()->query($sql);

     while($check = $stmt->fetch()){
        $data[] = $check;
        $report_id1= $check['report_id1'];
        $branch_name= $check['branch_name'];
        $branch_address1= $check['branch_address'];
        $branch_tele= $check['branch_tele'];
        $branch_phone= $check['branch_phone'];
        $pens_name= $check['pens_name'];
        $pens_address= $check['pens_address'];
        $date_now= $check['date_now'];
        $date_collect= $check['date_collect'];
        $branch_avail= $check['branch_avail'];
        $branch_head= $check['branch_head'];
}
$name = explode(",", $pens_name);
$lastname = trim($name[0]);
     

        $branch = $branch_name;
         //Formating//
         $new_branch = strtoupper($branch);


        $branch_address = $branch_address1;
        $branch_tel  = $branch_tele;
        $branch_cel  = $branch_phone;
        $date= $date_now;
        $pen_name = $pens_name;
        $pen_address = $pens_address;

        $last_date_collection = date('F d, Y',strtotime($date_collect));

        $branch_lended = $branch_avail;

        $subject_body = '<b style="color:red;">'.$branch.'</b> is pleased to inform you that as of <u style="color:red;">'.$last_date_collection.'</u>, you have fully settled
        your account. In this regard, we would like to inform you that you may claim your Automated Teller Machine (ATM)
        card at our <u style="color:red;">('.$branch_lended.') branch.</u><br>
        
        <br>We have resorted to write this letter of notice since all means have been exhausted to inform you regarding 
        this matter but received no action coming from you.<br>
        
        <br>Hereafter, <b style="color:red;">'.$branch.'</b> shall not be liable for any and all manner action, causes of action, sum of money, or any other compensation
        or money claim, damages, liability, responsibility, obligation, claims and demand whatsoever in law or equity, if any,
        arising, directly or indirectly.<br>
        
        <br>Please contact our office beforehand and set an appointment as to the day time of claiming of our ATM so we can do the
        nessesary processing ahead of time.';
       

       

       

       $newdateformat = date('F d, Y',strtotime($date));



  require_once('tcpdf_include.php');
  $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
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
$pdf->SetMargins(22,22);
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



    $header = <<<EOF
    <table style="width:100%;" >

    <tr>
      <td style="width:1140px;text-align:center;font-size:10px;float: right;"></td>
    </tr>  
    <tr>
        <th style="width:55px;"></th>
        <td style="width:500px; text-align: center;  font-size:16;font-weight:bold;
         margin-left: 3000px;">$new_branch</td> 
    </tr>    
    <tr>
        <th style="width:130px;"></th>
        <td style="width:340px; text-align: center; color:red; font-size:1.0em;
        margin-left: 3000px;">$branch_address</td> 
    </tr>  
    <tr>
        <th style="width:130px;"></th>
        <td style="width:340px; text-align: center; color:red; font-size:1.0em;
        margin-left: 3000px;">$branch_tel</td> 
    </tr> 
    <tr>
        <th style="width:130px;"></th>
        <td style="width:340px; text-align: center; color:red;  font-size:1.0em;
        margin-left: 3000px;">$branch_cel</td> 
    </tr>
    <tr>
    <th ></th>
    <td ></td>        
    </tr>
    <tr>
    <th style="width:580px; border-style:buttom; border-width: 0.5px;"></th>
    <td ></td>        
    </tr>    
    <tr>
        <th style="width:100px; padding-buttom: 20px; color:red; font-size:16px;">$newdateformat</th>
        
        <td style="width:260px; font-size:16px;"></td>
               
    </tr>
    <tr>
    <th style="width:250px; border-style:buttom; border-width: 1px;"></th>
    <td ></td>        
    </tr>
    <tr>
    <th ></th>
    <td ></td>        
    </tr><br>
    
      
    <tr>
        <th style="width:500px; font-size:16px; color:red; ">$pens_name</th>
        
        <td style="width:350px; font-size:16px;font-weight: bold;"></td>       
    </tr>

    <tr>
    <th style="width:250px; border-style:buttom; border-width: 1px;"></th>
    <td ></td>        
    </tr>
    <tr>
    <th style="width:400px; font-size:16px; color:red;">$pens_address</th>
    
    <td style="width:350px; font-size:16px;font-weight: bold;"></td>       
</tr>
<tr>
    <th style="width:250px; border-style:buttom; border-width: 1px;"></th>
    <td ></td>        
    </tr>
  
<br>
<br>
    <tr>
        <th style="width:100px; font-size:16px;">Dear Mr./Mrs.</th>
       
        <td class="text-uppercase" style="width:140px; font-size:16px;">$lastname</td>  
        <td>,</td>     
    </tr>
    <tr>
    <th style="width:90px; font-size:16px;"></th>
    
    <td style="width:150px; font-size:16px;font-weight: bold; border-style:buttom; border-width: 1px;"></td>       
</tr>
 
    <tr>
    <th  style="width:100%; font-size:16px; text-align: justify;">$subject_body</th>
    </tr> 
    <br>
    <tr>
    <th>Thank you.
    </th>
    </tr>
    <br>
    <br>
    <tr>
    <th style="font-size:16px;">Very truly yours,
    </th>
    </tr>
    <br>
    <tr>
    <th style="color:red;">$branch_head</th>
    </tr>
    <tr>
    <th style="width:200px; border-style:buttom; border-width: 1px;">Branch Head</th>
    <td></td> 
    </tr>

    </table>
EOF;
    $pdf->writeHTML($header, false, false, false, false, '');
    

// ------------------------------------------------------------
//   $i = 0;  
//   while($rows = $stmt->fetch()){ 
//     $data[] = $rows;
//     // $cname = $rows["full_name"];
//     // $email = $rows["user_email"];
//     // $user_name = $rows["user_name"];
//     // $category = $rows["mobile"];
//     // $phone = $rows['user_phone'];
//     // $user_address = $rows['posts'];
    
//     $content = <<<EOF
//     <table style="border: none;margin-top: 5px;">    
//       <tr>
//         <th style="width:100px;"></th>
//         <th>NAME</th>
//         <td> Sample name </td>
                                                   
//       </tr>                 
//     </table>
// EOF;
//       $pdf->writeHTML($content, false, false, false, false, '');      
//   } 
    
    $pdf->Output('report1.pdf', 'I');
    
   }
  }  

  $clientsFormRequest = new printClientList();
  $clientsFormRequest -> getClientsPrinting();

?>