<?php
require_once "../../../models/connection.php";


class printClientList{

    public $ref_id; 
public function getClientsPrinting(){

    $connection = new connection;
    $connection->connect();

    $ref_id = $_REQUEST['ref_id'];
    
    $sql = "SELECT * FROM request_forms WHERE ref_id = $ref_id";
        $stmt = $connection->connect()->query($sql);

     while($clients = $stmt->fetch()){
        $data[] = $clients;

        $to = $clients['to'];
        $ref_id = $clients['ref_id'];

        $address = $clients['address']; 
        $req_by = $clients['req_by']; 
        $branch = $clients['branch'];
        $date = $clients['date'];
        $subject = $clients['subject'];
        $subject_body = $clients['subject_body'];
        $chk_by = $clients['chk_by'];
        $chk_by1 = $clients['chk_by1'];
        $chk_by2 = $clients['chk_by2'];
        $rec_app = $clients['rec_app'];
        $app_by = $clients['app_by'];
        $subject_body1 =str_replace("<br />", '',  $subject_body);

        $new_subject = strtoupper($subject);
        $new_branch = strtoupper($branch);
        $new_t0 = strtoupper($to);
        $new_req_by = strtoupper($req_by);

       

       $newdateformat = date('F d, Y',strtotime($date));

$a_chk_by = explode("<br />", $chk_by);
$new_chk =  strtoupper($a_chk_by[0]);
$cn_cb = count($a_chk_by);
$new_chk_1 ="";
if($cn_cb>1){
    $new_chk_1 = $a_chk_by[1];
}
$a_chk_by1 = explode("<br />", $chk_by1);
$new_chk1 = strtoupper($a_chk_by1[0]);
$cn_cb1 = count($a_chk_by1);
$new_chk11 ="";
if($cn_cb1>1){
    $new_chk11 = $a_chk_by1[1];
}
$a_chk_by2 = explode("<br />", $chk_by2);
$new_chk2 = strtoupper($a_chk_by2[0]);
$cn_cb2 = count($a_chk_by2);
$new_chk22 ="";
if($cn_cb2>1){
    $new_chk22 = $a_chk_by2[1];
}
$a_req_by = explode("<br />", $req_by);
$new_req_by= strtoupper($a_req_by[0]);
$cn_rb= count($a_req_by);
$new_req_by1 ="";
if($cn_rb>1){
    $new_req_by1= $a_req_by[1];
}
$a_rec_app = explode("<br />", $rec_app);
$new_rec_app= strtoupper($a_rec_app[0]);
$cn_ra= count($a_rec_app);
$new_rec_app1 ="";
if($cn_ra>1){
    $new_rec_app1= $a_rec_app[1];
}
$a_app_by = explode("<br />", $app_by);
$new_app_by = strtoupper($a_app_by[0]);
$cn_ab= count($a_app_by);
$new_app_by1 ="";
if($cn_ab>1){
    $new_app_by1 = $a_app_by[1];
}





// $b_date = date('F d Y', strtotime($birth_date));
// $d_date = date('F d Y', strtotime($date_hired));
}

  
$time = time();
$date=date("M-d-y", $time);

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
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_RIGHT);
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
    <table style="width:100%;" >

    <tr>
      <td style="width:1140px;text-align:center;font-size:10px;float: right;"></td>
    </tr>  
    <tr>
        <th style="width:140px;"></th>
        <td style="width:340px; text-align: center; font-size:1.0em;font-weight:bold;
         margin-left: 3000px;">$new_branch</td> 
    </tr>    
    <tr>
        <td></td> 
    </tr>  
    <tr>
        <td></td> 
    </tr>   
    <tr>
        <th style="width:140px; padding-buttom: 20px; font-size:14px;">REFERENCE NO. :</th>
        
        <td style="width:260px; font-size:14px;">$ref_id</td>
               
    </tr>
    <br>
    <tr>
        <th style="width:140px; padding-buttom: 20px; font-size:14px;">DATE :</th>
        
        <td style="width:260px; font-size:14px;">$newdateformat</td>
               
    </tr>
    <br>
      
    <tr>
        <th style="width:140px; font-size:14px;">TO :</th>
        
        <td style="width:350px; font-size:14px;font-weight: bold;">$new_t0</td>
               
    </tr>
    <tr>
    <th style="width:140px; font-size:14px;"></th>
    
    <td style="width:220px; font-size:14px;">$address</td>
           
        </tr>
    <br>
    <tr>
        <th style="width:100px; font-size:14px;">SUBJECT :</th>
       
        <td class="text-uppercase" style="width:560px; font-size:14px; text-transform: uppercase;">$new_subject</td>       
    </tr>
    <tr>
    <th style="width:150px; border-style:buttom; border-width: 2px;"></th>
    <td style="width:500px;border-style:buttom; border-width: 2px;"></td>        
    </tr> 
    <br>
    <tr>
    <th  style="width:100%;">$subject_body</th>
    </tr> 
    <br>
    <tr>
    <th ><b><u>$new_req_by</u></b></th>
    </tr>
    <tr>
    <th>$new_req_by1</th>
    </tr>
    <br>
    <tr>
    <th>Checked by:
    </th>
    </tr>
    <br>
    <tr>
    <th ><b><u>$new_chk</u></b></th>
    </tr>
    <tr>
    <th>$new_chk_1</th>
    </tr>
    <br>
    <tr>
    <th style="width: 300px;"><b><u>$new_chk1</u></b></th>
    <td ><b><u>$new_chk2</u></b></td>
    </tr>
    <tr>
    <th>$new_chk11</th>
    <td >$new_chk22</td>
    </tr>
    <br>
 
    <tr>
    <th>Recommending Approval:
    </th>
    </tr>
    <br>
    <br>
    <tr>
    <th ><b><u>$new_rec_app</u></b></th>
    </tr>
    <tr>
    <th>$new_rec_app1</th>
    </tr>
    <br>
    <tr>
    <th>Approved by:
    </th>
    </tr>
    <br>
    <tr>
    <th ><b><u>$new_app_by</u></b></th>
    </tr>
    <tr>
    <th>$new_app_by1</th>
    </tr>
   
   
     
  
    <br>
    <br>
   
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
    
    $pdf->Output('client_from_request.pdf', 'I');
    
   }
  }  

  $clientsFormRequest = new printClientList();
  $clientsFormRequest -> getClientsPrinting();

?>