<?php
require_once "../../../models/connection.php";

class printClientList{

    public $ref_id; 
public function getClientsPrinting(){

    $connection = new connection;
    $connection->connect();

    $ref_id = $_REQUEST['ref_id'];
    
    $sql = "SELECT * FROM working_permit WHERE ref_id = $ref_id";
        $stmt = $connection->connect()->query($sql);

     while($clients = $stmt->fetch()){
        $data[] = $clients;

        $wp_to = $clients['wp_to'];
        $ref_id = $clients['ref_id'];
        $wp_from = $clients['wp_from'];
        $wp_date = date("F d, Y",strtotime($clients['wp_date'])); 
        $wp_req_for = $clients['wp_req_for'];
        $branch = $clients['branch'];
        $wp_req_by = $clients['wp_req_by'];
        $wp_chk_by = $clients['wp_chk_by'];
        $wp_app_by = $clients['wp_app_by'];
        $wp_app_by1 = $clients['wp_app_by1'];

        $wp_to = strtoupper($wp_to);
        $wp_from = strtoupper($wp_from);

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
      <td style="width:1140px;text-align:center;font-size:10px;float: right;">$date</td>
    </tr>  
    <tr>
        <td style="width:640px;text-align:center;font-size:1.0em;font-weight:bold;">WORKING PERMIT</td> 
    </tr>    
    <tr>
        <td></td> 
    </tr>  
    <tr>
        <td></td> 
    </tr>   
    <tr>
        <th style="width:150px; padding-buttom: 20px; font-size:14px;">Reference Id :</th>
        
        <td style="width:260px; font-size:14px;">$ref_id</td>
               
    </tr>
      
    <tr>
        <th style="width:150px; font-size:14px;">To :</th>
        
        <td style="width:350px; font-size:14px;font-weight: bold;">$wp_to</td>       
    </tr>
     
    <tr>
        <th style="width:150px; font-size:14px;">From :</th>
       
        <td style="width:360px; font-size:14px; font-weight: bold;">$wp_from</td>       
    </tr>
    
    <tr>
        <th style="width:150px; font-size:14px;">Date :</th>
        
        <td style="width:260px; font-size:14px; ">$wp_date</td>       
    </tr>
      
    <tr>
    <th style="width:150px; font-size:12px;"></th>
    
    <td style="width:200px;border-style:buttom;"></td>       
</tr>
    <tr>
        <th style="width:150px; font-size:14px;">Request for :</th>
        
        <td style="width:660px; font-size:14px;">$wp_req_for</td>       
    </tr>
    <tr>
    <th style="width:150px; font-size:12px;"></th>
    
    <td style="width:500px;border-style:buttom;"></td>       
   </tr>
    
    <tr>
        <th style="width:150px; font-size:14px;">Branch :</th>
        
        <td style="width:660px; font-size:14px;;">$branch</td>       
    </tr>

    <tr>
        <th style="width:150px; font-size:12px;"></th> 
        <td style="width:320px;border-style:buttom;"></td>       
    </tr>
    <tr>
        <th style="width:150px; font-size:12px;"></th>    
        <td style="width:260px; font-size:14px;"></td>       
    </tr> 
           
    <tr>
        <th style="width:150px; font-size:14px;">Requested by :</th>      
        <td style="width:260px; font-size:14px;">$wp_req_by</td>           
    </tr>
    <tr>  
        <th style="width:150px; font-size:12px;"></th>    
        <td style="width:260px; font-size:14px; border-style:buttom;"></td>            
    </tr>
    <tr>
        <th style="width:150px; font-size:12px;"></th>    
        <td style="width:260px; font-size:14px;"></td>       
    </tr>     
    <tr>
        <th style="width:150px; font-size:14px;">Checked by :</th>        
        <td style="width:260px; font-size:14px;">$wp_chk_by</td>       
    </tr>
    <tr>   
        <th style="width:150px; font-size:12px;"></th>        
        <td style="width:260px; font-size:14px; border-style:buttom;"></td>             
    </tr> 
    <tr>
        <th style="width:150px; font-size:12px;"></th>    
        <td style="width:260px; font-size:14px;"></td>       
    </tr>    
    <tr>
        <th style="width:150px; font-size:14px;">Approved by :</th>        
        <td style="width:260px; font-size:14px;"></td>       
    </tr>
    <tr>   
        <th style="width:150px; font-size:14px;"></th>  
        <td style="width:260px; font-size:14px; border-style:buttom;">$wp_app_by</td>            
    </tr>
    <tr>
        <th style="width:150px; font-size:14px;"></th>    
        <td style="width:260px; font-size:14px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Comptroller / FCO</td>       
    </tr>
    
    <tr>
        <th style="width:150px; font-size:14px;"></th>    
        <td style="width:260px; font-size:14px;"></td>       
    </tr>
    <tr>
        <th style="width:150px; font-size:14px;"></th>    
        <td style="width:260px; font-size:14px;"></td>       
    </tr>
    <tr>
        <th style="width:150px; font-size:12px;"></th>    
        <td style="width:260px; font-size:14px;"></td>       
    </tr>
    <tr>
    
        <th style="width:150px; font-size:14px;"></th>       
        <td style="width:260px; font-size:14px; border-style:buttom;">$wp_app_by1</td> 
             
    </tr>
    <tr>
        <th style="width:150px; font-size:12px;"></th>    
        <td style="width:260px; font-size:14px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MIS Head</td>       
    </tr>
      
    <tr>
    <th style="width:150px; font-size:14px;"></th>
    <td style="width:50px;"></td>
    <td style="width:260px; "></td>
        
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