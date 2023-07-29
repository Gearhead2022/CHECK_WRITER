<?php

require_once "../../../models/connection.php";

class printClientList{

    public $ref_id; 
public function getClientsPrinting(){

    $connection = new connection;
    $connection->connect();

    $report_id2 = $_REQUEST['report_id2'];
    
    $sql = "SELECT * FROM fp_report2 WHERE report_id2 = '$report_id2'";
        $stmt = $connection->connect()->query($sql);

     while($check = $stmt->fetch()){
        $data[] = $check;
        $report_id2= $check['report_id2'];
        $branch_name= $check['branch_name'];
        $branch_address1= $check['branch_address'];
        $branch_tele= $check['branch_tele'];
        $branch_phone= $check['branch_phone'];
        $name= $check['name'];
        $address= $check['address'];
        $amount_up= $check['amount_up'];
        $amount_promo= $check['amount_promo'];
        $date_now= $check['date_now'];
        $branch_ophead= $check['branch_ophead'];
     }

     

        $branch = $branch_name;
         //Formating//
         $new_branch = strtoupper($branch);


        $branch_address = $branch_address1;
        $branch_tel  = $branch_tele;
        $branch_cel  = $branch_phone;
        $time = time();
        $date=date("M-d-y", $time);
        $pen_name = $name;
        $pen_address = 'Pensioner Address';

        $address1 = $address;

        
        $amount = $amount_up;
        $amount_incentive = $amount_promo;

        $branch_head = $branch_ophead;

        $branch_contact_number = $branch_phone;

        $abbreviation_of_branch = 'EMB';

        $subject_body = 'We are glad to inform you that you are qualified to renew for up to <u style="color:red;">'.$amount.'</u> and avail our cash incentive
        promo worth <u style="color:red;">'.$amount_incentive.'</u>.<br><br>Simply visit or call <u style="color:red;">'.$branch_contact_number.'</u> and look for <u style="color:red;">'.$branch_head.'</u>.';


        $terms_and_condition = 'Terms & Conditions: Your account must be valid and current at the time of availment
        fot the transaction to be completed successfuly. Final transaction amount is subject to further validation 
        of your available credit limit at the time you accept this offer, and '.$abbreviation_of_branch.' reserves the right to render the
        final decision on the approved borrowing amount';
       

        // $to = $clients['to'];
        // $ref_id = $clients['ref_id'];

        // $address = $clients['address']; 
        // $req_by = $clients['req_by']; 

        // $date = $clients['date'];
        // $subject = $clients['subject'];
        // $subject_body = $clients['subject_body'];
        // $chk_by = $clients['chk_by'];
        // $chk_by1 = $clients['chk_by1'];
        // $chk_by2 = $clients['chk_by2'];
        // $rec_app = $clients['rec_app'];
        // $app_by = $clients['app_by'];
        // $subject_body1 =str_replace("<br />", '',  $subject_body);

        // $new_subject = strtoupper($subject);
        // $new_branch = strtoupper($branch);
        // $new_t0 = strtoupper($to);
        // $new_req_by = strtoupper($req_by);

       

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
        <th style="width:140px;"></th>
        <td style="width:340px; text-align: center; font-size:1.0em;font-weight:bold;
        margin-left: 3000px; font-style: italic;">FOR QUALITY FULLY PAID ACCOUNT</td> 
    </tr> 
    <br> 
    <tr>
        <th style="width:140px;"></th>
        <td style="width:340px; text-align: center; font-size:1.0em;font-weight:bold;
         margin-left: 3000px;">$new_branch</td> 
    </tr>    
    <tr>
        <th style="width:140px;"></th>
        <td style="width:340px; color:red; text-align: center; font-size:1.0em;
        margin-left: 3000px;">$branch_address</td> 
    </tr>  
    <tr>
        <th style="width:140px;"></th>
        <td style="width:340px; color:red; text-align: center; font-size:1.0em;
        margin-left: 3000px;">$branch_tel</td> 
    </tr> 
    <tr>
        <th style="width:140px;"></th>
        <td style="width:340px; color:red; text-align: center; font-size:1.0em;
        margin-left: 3000px;">$branch_cel</td> 
    </tr>
    <tr>
    <th ></th>
    <td ></td>        
    </tr>
    <tr>
    <th style="width:600px; border-style:buttom; border-width: 0.5px;"></th>
    <td ></td>        
    </tr>    
    <tr>
        <th style="width:100px; padding-buttom: 20px; font-size:14px;">$newdateformat</th>
        
        <td style="width:260px; font-size:14px;"></td>
               
    </tr><br>
    
    <tr>
    <th ></th>
    <td ></td>        
    </tr>
    
      
    <tr>
        <th style="width:400px; font-size:14px; ">$name</th>
        
        <td style="width:350px; font-size:14px;font-weight: bold;"></td>       
    </tr>
    <tr>
        <th style="width:250px; font-size:14px;">$address1</th>
        <td></td>        
    </tr>
   
    <tr>
        <th style="width:200px;"></th>
        <td ></td>        
        </tr>  
    <br>
    <tr>
        <th style="width:200px; font-size:14px;">Dear Valued Client,</th>
       
        <td class="text-uppercase" style="width:140px; font-size:14px;"></td>  
        <td>,</td>     
    </tr>
    <tr>
    <th style="width:90px; font-size:14px;"></th>
    
    <td style="width:150px;"></td>       
</tr>
 
    <tr>
    <th  style="width:100%; font-size:14px; text-align: justify;">$subject_body</th>
    </tr> 
    <br>
    <tr>
    <th style="font-size:14px;">Sincerely yours,
    </th>
    </tr>
    <br>
    <br>
    <tr>
    <th style="font-size:14px; color:red;">$branch_ophead</th>
    </tr>
    <tr>
    <th style="width:200px; border-style:buttom; border-width: 1px; font-size:14px;">Branch Operations Head</th>
    <td></td> 
    </tr>
    <tr>
    <th style="font-size:14px; padding-top: -300px;">
    </th>
    </tr>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>

    <tfoot>
    <tr>
        <th style="width:650px; border-style:buttom; border-width: 0.5px; font-size:12px;">$terms_and_condition</th>
        <td ></td>        
    </tr>
  </tfoot>

   
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
    
    $pdf->Output('report2.pdf', 'I');
    
   }
  }  

  $clientsFormRequest = new printClientList();
  $clientsFormRequest -> getClientsPrinting();

?>