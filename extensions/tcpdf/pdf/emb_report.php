<?php




class connection {

  private $host = "localhost";
  private $user = "root";
  private $password = "";
  private $dbname = "emb_appform";


  public function connect(){

      try {
          $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
          $pdo = new PDO($dsn, $this->user, $this->password);
          $pdo->setAttribute(PDO:: ATTR_DEFAULT_FETCH_MODE, PDO:: FETCH_ASSOC);
          return $pdo;
      } catch (PDOException $e) {
          echo 'Connection failed: ' . $e->getMessage();
      }

  }

}


class printClientList_2{

    
    public $type;

    
public function getClientsPrinting_2(){

    $connection = new connection;
    $connection->connect();


    
    $type = $_REQUEST['company'];
    $company_name="";

    if($type == "EMB"){

        $sql = "SELECT * FROM application_form ORDER BY lname";
        $stmt = $connection->connect()->query($sql);
        $company_name = "EMB CAPITAL LENDING CORPORATION";
        $report_name = "EMP_Employee_list.pdf";

    }elseif($type == "FCH"){

        $sql = "SELECT * FROM fch_form ORDER BY lname";
        $stmt = $connection->connect()->query($sql);
        $company_name = "FCH FINANCE CORPORATION";
        $report_name = "FCH_Employee_list.pdf";

    }elseif($type == "PSPMI"){

        $sql = "SELECT * FROM pspmi_form ORDER BY lname";
        $stmt = $connection->connect()->query($sql);
        $company_name = "PUER SANCTUS PROPERTY MANAGEMENT, INC.";
        $report_name = "PSPMI_Employee_list.pdf";

    }elseif($type == "RLC"){

        $sql = "SELECT * FROM rlc_form ORDER BY lname";
        $stmt = $connection->connect()->query($sql);
        $company_name = "RAMSGATE LENDING CORPORATION";
        $report_name = "RLC_Employee_list.pdf";

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
// $pdf->Image('../../../views/files/'.$img_name.'', 165, 15, 30, 25, 'JPG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 1, false, false, false);

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -



    $header = <<<EOF
    <table style="width:100%; margin-top: -30px;" >

    <tr>
     
      <td style="width:1140px;text-align:center;font-size:10px;float: right;">$date</td>
    </tr>  
    <tr>
        <td style="width:640px;text-align:center;font-size:1.0em;font-weight:bold;">$company_name</td> 
    </tr>

    <tr>
        <td style="width:640px;text-align:center;font-size:0.8em;font-weight: 200;">REPORT FORM</td> 
    </tr>     
    <tr>
        <td></td> 
    </tr>  
    <tr>
        <td></td> 
    </tr>   
   <tr>
        <td style="width:10px;"></td>

        <td style="text-indent:20px;border: 1px solid #666;width:200px;text-align:center;font-size:15px;color:white;background-color:black;"><strong>First Name</strong></td>

        <td style="text-indent:20px;border: 1px solid #680;width:200px;text-align:center;font-size:15px;color:white;background-color:black;"><strong>Middle Name</strong></td>
                                                            
        <td style="text-indent:20px;border: 1px solid #680;width:200px;text-align:center;font-size:15px;color:white;background-color:black;"><strong>Last Name</strong></td>

          
      </tr>
     

    </table>
EOF;
    $pdf->writeHTML($header, false, false, false, false, '');
    

//------------------------------------------------------------
  $i = 0;  
  while($clients = $stmt->fetch()){ 
    $data[] = $clients;
    $fname = $clients['fname']; 
    $mname = $clients['mname'];
    $lname = $clients['lname'];
    
    $content = <<<EOF
    <table style="margin-top: 2px;">  

      <tr style="padding-top: 2px;">
        <td style="width:10px;"></td>

        <td style="text-indent:30px;width:200px;text-align:left;font-size:12px; border: 1px solid #666;">$fname</td>

        <td style="text-indent:30px;width:200px;text-align:left;font-size:12px; border: 1px solid #666;">$mname</td>
                                                            
        <td style="text-indent:30px;width:200px;text-align:left;font-size:12px; border: 1px solid #666;">$lname</td>

          
      </tr>                 
    </table>
EOF;
      $pdf->writeHTML($content, false, false, false, false, '');      
  } 
    
    $pdf->Output($report_name, 'I');
    
   }
  }  

  $clientsForm = new printClientList_2();
  $clientsForm -> getClientsPrinting_2();

?>