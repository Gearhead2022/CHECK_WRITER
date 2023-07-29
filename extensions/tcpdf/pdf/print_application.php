<?php



require_once "../../../models/connection.php";


class printClientList_2{

    public $idClient;
    public $type;

    
public function getClientsPrinting_2(){

    $connection = new connection;
    $connection->connect();


    $idClient = $_REQUEST['id_num'];
    $type = $_REQUEST['company'];
    $company_name="";

    if($type == "EMB"){
    

    $sql = "SELECT * FROM application_form WHERE id_num = $idClient";
        $stmt = $connection->connect()->query($sql);
        $company_name = "EMB CAPITAL LENDING CORPORATION";

    }elseif($type == "FCH"){

        $sql = "SELECT * FROM fch_form WHERE id_num = $idClient";
        $stmt = $connection->connect()->query($sql);
        $company_name = "FCH FINANCE CORPORATION";

    }elseif($type == "PSPMI"){

        $sql = "SELECT * FROM pspmi_form WHERE id_num = $idClient";
        $stmt = $connection->connect()->query($sql);
        $company_name = "PUER SANCTUS PROPERTY MANAGEMENT, INC.";

    }elseif($type == "RLC"){

        $sql = "SELECT * FROM rlc_form WHERE id_num = $idClient";
        $stmt = $connection->connect()->query($sql);
        $company_name = "RAMSGATE LENDING CORPORATION";

    }

     while($clients = $stmt->fetch()){
    $data[] = $clients;


$id_num = $clients['id_num'];
$fname = $clients['fname']; 
$mname = $clients['mname'];
$lname = $clients['lname'];
$company = $clients['company'];
$blood_type = $clients['blood_type'];
$birth_date = $clients['birth_date'];
$home_address = $clients['home_address'];
$sss_num = $clients['sss_num'];
$tin_num = $clients['tin_num'];
$phil_num = $clients['phil_num'];
$pagibig_num = $clients['pagibig_num'];
$date_hired = $clients['date_hired'];
$em_fname = $clients['em_fname'];
$em_mname = $clients['em_mname'];
$em_lname = $clients['em_lname'];
$em_phone = $clients['em_phone'];
$em_address = $clients['em_address'];
$picture = $clients['picture'];
$img_name = "";
if($picture==""){
    $img_name ="blank.jpg";
}else{
    $img_name ="$picture";
}
$b_date = date('F d Y', strtotime($birth_date));
$d_date = date('F d Y', strtotime($date_hired));
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
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}


 
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
$pdf->Image('../../../views/files/'.$img_name.'', 165, 15, 30, 25, 'JPG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 1, false, false, false);

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -



    $header = <<<EOF
    <table style="width:100%; margin-top: -30px;" >

    <tr>
     
      <td style="width:1140px;text-align:center;font-size:10px;float: right;"></td>
    </tr>  
    <tr>
        <td style="width:640px;text-align:center;font-size:1.0em;font-weight:bold;">$company_name</td> 
    </tr>

    <tr>
        <td style="width:640px;text-align:center;font-size:0.8em;font-weight: 200;">ID APPLICATION FORM</td> 
    </tr>     
    <tr>
        <td></td> 
    </tr>  
    <tr>
        <td></td> 
    </tr>   
    <tr>
        <th style="width:150px; padding-buttom: 20px; font-size:14px;">NAME</th>
        <td style="width:150px;">&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td style="width:260px; font-size:14px;">$fname $mname $lname</td>
               
    </tr>
      
    <tr>
        <th style="width:150px; font-size:12px;">ID NO.</th>
        <td style="width:150px;">&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td style="width:260px; font-size:14px; border-style:buttom;">$id_num</td>       
    </tr>
     
    <tr>
        <th style="width:150px; font-size:12px;">BLOOD TYPE.</th>
        <td style="width:150px;">&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td style="width:260px; font-size:14px; border-style:buttom;">$blood_type</td>       
    </tr>
    
    <tr>
        <th style="width:150px; font-size:12px;">DATE OF BIRTH</th>
        <td style="width:150px;">&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td style="width:260px; font-size:14px; border-style:buttom;">$b_date</td>       
    </tr>
      
    <tr>
        <th style="width:150px; font-size:12px;">HOME ADDRESS</th>
        <td style="width:150px;">&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td style="width:260px; font-size:14px; border-style:buttom;">$home_address</td>       
    </tr>
      
    <tr>
        <th style="width:150px; font-size:12px;">SSS NO.</th>
        <td style="width:150px;">&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td style="width:260px; font-size:14px; border-style:buttom;">$sss_num</td>       
    </tr>
      
    <tr>
        <th style="width:150px; font-size:12px;">TIN NO.</th>
        <td style="width:150px;">&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td style="width:260px; font-size:14px; border-style:buttom;">$tin_num</td>       
    </tr>
      
    <tr>
        <th style="width:150px; font-size:12px;">PHILHEALTH NO.</th>
        <td style="width:150px;">&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td style="width:260px; font-size:14px; border-style:buttom;">$phil_num</td>      
    </tr>
      
    <tr>
        <th style="width:150px; font-size:12px;">PAGIBIG NO.</th>
        <td style="width:150px;">&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td style="width:260px; font-size:14px; border-style:buttom;">$pagibig_num</td>       
    </tr>
      
    <tr>
        <th style="width:150px; font-size:12px;">DATE HIRED</th>
        <td style="width:150px;">&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td style="width:260px; font-size:14px; border-style:buttom;">$d_date</td>       
    </tr>
      
    <tr>
    <th style="width:150px; font-size:14px;"></th>
    <td style="width:150px;"></td>
    <td style="width:260px; border-style:buttom;"></td>
        
    </tr>  
    <tr>
    <th style="width:400px; font-weight: bold;">IN CASE OF EMERGENCY PLEASE NOTIFY:</th>
           
    </tr> 
    <tr>
        <td style="width:20px;"></td>
        
    </tr>
       
    <tr>
        <th style="width:150px; font-size:12px;">NAME</th>
        <td style="width:150px;">&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td style="width:260px; font-size:14px;">$em_fname $em_mname $em_lname</td>       
    </tr>
      
    <tr>
        <th style="width:150px; font-size:12px;">TEL NO/CP NO.</th>
       <td style="width:150px;">&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td style="width:260px; font-size:14px; border-style:buttom;">$em_phone</td>       
    </tr>
      
    <tr>
        <th style="width:150px; font-size:12px;">ADDRESS</th>
        <td style="width:150px;">&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td style="width:260px; font-size:14px; border-style:buttom;">$em_address</td>       
    </tr>
      
    <tr>
    <th style="width:150px;"></th>
    <td style="width:150px;"></td>
    <td style="width:260px; font-size:14px; border-style:buttom;"></td>
        
    </tr>
    <br>   
    <tr>
    <th style="width:150px;"></th>
    <td style="width:150px;"></td>
    <td style="width:200px; font-size:12px;font-weight: bold;">KINDLY SIGN INSIDE THE BOX</td>       
    </tr> 
    <tr>
    <th style="width:150px;font-size:12px;">SIGNATURE</th>
    <td style="width:80px;"></td>
    <td style="width:330px;height:100px; border: 0px 0px 0px 0px #000; border: 1px solid #000;
    "></td>       
    </tr>
    <tr> 
    <th style="width:150px;font-size:12px; font-weight: bold;">Endorse by:</th>
    <td style="width:80px;"></td>
          
    </tr> 
  
    <br>
    <br>
    <tr> 
    <th style="width:180px;font-size:12px; border-style: bottom;"></th>
    </tr>
    <tr> 
    <th style="width:180px;font-size:12px; font-style: italic;">Immediate Supervisor</th>
    <td style="width:80px; font-style: italic;"></td>
          
    </tr>
    <br>
    <br>
    <tr> 
    <th style="width:150px;font-size:12px; font-weight: bold;">Noted by:</th>
    <td style="width:80px;"></td>
          
    </tr> 
    <br>
    <br>
    <tr> 
    <th style="width:150px;font-size:12px; ">Christelle Luise G. Lachica</th>
    <td style="width:80px;"></td>
          
    </tr> 
    <br>
    <br>
    <tr> 
    <th style="width:150px;font-size:12px; ">Ma. Rizza T. Montaño</th>
    <td style="width:80px;"></td>
          
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
    
    $pdf->Output('client_list.pdf', 'I');
    
   }
  }  

  $clientsForm = new printClientList_2();
  $clientsForm -> getClientsPrinting_2();

?>