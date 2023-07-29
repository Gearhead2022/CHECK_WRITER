<?php

require_once "../../../models/connection.php";
require_once "../../../views/modules/session.php";

class printClientList{


    public $datefrom;
    public $dateto;
    public $class_type;
    public $branch_name;
    public function getClientsPrinting(){

    $datefrom = $_REQUEST['dateFrom'];
    $dateTo = $_REQUEST['dateTo'];
    $branch_name = $_REQUEST['branch_name'];
    $class_type = $_REQUEST['class_type'];

    $connection = new connection;
    $connection->connect();
//  GET DATA IN PASTDUE   

    if($class_type == "D"){
        $class_types = "DECEASED";
    }
    elseif ($class_type == "F"){
        $class_types = "FULLY PAID";
    }
    elseif ($class_type == "P"){
        $class_types = "POLICE ACTION";
    }
    elseif ($class_type == "W"){
        $class_types = "WRITE OFF";
    }elseif ($class_type == "L"){
        $class_types = "LITIGATION";
    }

    $formated_date_from = date("m/d/Y" , strtotime($datefrom));
    $formated_date_to = date("m/d/Y" , strtotime($dateTo));



  require_once('tcpdf_include.php');


  $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
//$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
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
$pdf->SetMargins(3,3);
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
<style>
table tr, th{
    font-size:9rem;
}
</style>
<table>

    <tr>
    <th colspan="11" style="text-align:center;">EMB CAPITAL LENDING CORP.MAIN</th>
    </tr>

    <tr>
    <th colspan="11" style="text-align:center;">$class_types</th>
    </tr>

    <tr>
    <th colspan="11" style="text-align:center;"></th>
    </tr>

    <tr>
    <th colspan="7" style="text-align:right;">For the Period From $formated_date_from To $formated_date_to</th>
    
    </tr>

    <tr>
    <th colspan="11" style="text-align:center;">$branch_name</th>
    </tr>

    <tr>
    <th colspan="11" style="text-align:center;"></th>
    </tr>


</table>

EOF; 


$header .= <<<EOF
<table>
<tr>
    <th style="width:20px;">No.</th>
    <th style="width:170px;">NAME</th>
    <th style="width:30px;">Type</th>
    <th style="width:45px;">ACCT#</th>
    <th style="width:50px;">BANK</th>
    <th style="width:70px;">ENDORSED</th>
    <th style="width:70px;">ORIG.BAL.</th>
    <th style="width:70px;">PREV.BAL</th>
    <th style="width:60px;">DEBIT</th>
    <th style="width:60px;">CREDIT</th>
    <th style="width:80px;">OUTS.BAL.</th>
</tr>

</table>
EOF;


$sql = "SELECT * FROM past_due WHERE class = '$class_type' AND branch_name = '$branch_name' ORDER BY last_name";


$stmt = $connection->connect()->query($sql);

$i = 1;
$grand_totalOrig = 0;
$grand_totalPrev = 0;
$grand_totalDebit = 0;
$grand_totalCredit = 0;
$grand_totalOut = 0;
while($item = $stmt->fetch()){
    $account_no = $item['account_no'];
    $fullname = $item["last_name"].", ".$item["first_name"]." ".$item["middle_name"];
    $type = $item['type'];
    $bank = $item['bank'];
    $refdate = $item['refdate'];
    $balance = $item['balance'];
    $branch_name1 = $item['branch_name'];

    $sql2 = "SELECT SUM(debit) as total_debit, SUM(credit) as total_credit  FROM past_due_ledger 
    WHERE branch_name = '$branch_name1' AND account_no = '$account_no' AND date <= '$datefrom'";

    $stmt2 = $connection->connect()->query($sql2);

    while($item_info = $stmt2->fetch()){

        $total_debit = $item_info['total_debit'];
        $total_credit = $item_info['total_credit'];
    }

    $sql3 = "SELECT SUM(debit) as get_debit, SUM(credit) as get_credit  FROM past_due_ledger 
    WHERE branch_name = '$branch_name1'AND account_no = '$account_no' AND date >= '$datefrom' 
    AND date <= '$dateTo'";

    $stmt3 = $connection->connect()->query($sql3);

    while($item_info3 = $stmt3->fetch()){

        $total_debit_date = $item_info3['get_debit'];
        $total_credit_date = $item_info3['get_credit'];
    }
    
    if($balance != 0){
        $total_preBal = ($balance - $total_credit) - $total_debit;
        $org_total_prebal= $total_preBal;
    }else{

        $total_preBal = $total_debit + $total_credit;
        $org_total_prebal= $total_preBal;
        if($total_preBal<0){
            $total_preBal = abs($total_preBal);
        }else{
            $total_preBal = -1 * $total_preBal;
        }
    }

    $total_outbal = $org_total_prebal + $total_debit_date +$total_credit_date;

    if($total_outbal<0){
        $total_outbal = abs($total_outbal);
    }else{
        $total_outbal = -1 * $total_outbal;
    }

    $formatted_balance = number_format($balance, 2, '.',',');
    $formatted_total_preBal = number_format($total_preBal, 2, '.',',');
    $formatted_total_outbal = number_format($total_outbal, 2, '.',',');

    
    if ($total_debit_date == 0 ) {
        $formatted_total_debit = "";
    } else {
        $formatted_total_debit = number_format($total_debit_date, 2, '.',',');
    }

    if ($total_credit_date == 0 ) {
        $formatted_total_credit = "";
    } else {
        $formatted_total_credit = number_format($total_credit_date, 2, '.',',');
    }
    

$header .= <<<EOF
<table>
<tr>
    <td style="width:20px;">$i</td>
    <td style="width:165px;">$fullname</td>  
    <td style="width:40px; text-align:center;">$type</td>  
    <td style="width:40px; text-align:left;">$account_no</td>
    <td style="width:45px; text-align:left;">$bank</td>
    <td style="width:65px; text-align:center;">$refdate</td>
    <td style="width:70px; text-align:right;">$formatted_balance</td>
    <td style="width:65px; text-align:right;">$formatted_total_preBal</td>
    <td style="width:60px; text-align:center;">$formatted_total_debit</td>
    <td style="width:60px; text-align:center;">$formatted_total_credit</td>
    <td style="width:70px; text-align:right;">$formatted_total_outbal</td>
    <td></td>  
</tr>
   
</table>
EOF;

$i++;

$grand_totalOrig = $grand_totalOrig  + $balance;
$grand_totalPrev = $grand_totalPrev  + $org_total_prebal;
$grand_totalDebit = $grand_totalDebit + $total_debit_date;
$grand_totalCredit = $grand_totalCredit + $total_credit_date;
$grand_totalOut = $grand_totalOut + $total_outbal;


      
}

$formatted_grand_totalOrig = number_format(round($grand_totalOrig, 2), 2, '.', ',');
$formatted_grand_totalDebit = number_format(round($grand_totalDebit, 2), 2, '.', ',');
$formatted_grand_totalPrev = number_format(abs(round($grand_totalPrev, 2)), 2, '.', ',');
$formatted_grand_totalCredit = number_format(round($grand_totalCredit, 2), 2, '.', ',');
$formatted_grand_totalOut = number_format(round($grand_totalOut, 2), 2, '.', ',');


$header .= <<<EOF
<table>
<tr>
    <td style="width:50px;"></td>
    <td style="width:165px;"></td>  
    <td style="width:40px; text-align:center;"></td>  
    <td style="width:40px; text-align:left;"></td>
    <td style="width:50px; text-align:left;"></td>
    <td style="width:45px; text-align:center;"></td>
    <td style="width:55px; text-align:center; border-top: 1px solid black ;"></td>
    <td style="width:9px;"></td>
    <td style="width:55px; text-align:center; border-top: 1px solid black ;"></td>
    <td style="width:9px;"></td>
    <td style="width:55px; text-align:center; border-top: 1px solid black ;"></td>
    <td style="width:9px;"></td>
    <td style="width:55px; text-align:center; border-top: 1px solid black ;"></td>
    <td style="width:9px;"></td>
    <td style="width:55px; text-align:center; border-top: 1px solid black ;"></td>
    <td></td>  
</tr>
<tr>
    <td style="width:50px;">TOTALS</td>
    <td style="width:165px;"></td>  
    <td style="width:40px; text-align:center;"></td>  
    <td style="width:40px; text-align:left;"></td>
    <td style="width:50px; text-align:left;"></td>
    <td style="width:40px; text-align:center;"></td>
    <td style="width:65px; text-align:center;">$formatted_grand_totalOrig</td>
    <td style="width:65px; text-align:center;">$formatted_grand_totalPrev</td>
    <td style="width:65px; text-align:center;">$formatted_grand_totalDebit</td>
    <td style="width:65px; text-align:center;">$formatted_grand_totalCredit</td>
    <td style="width:65px; text-align:center;">$formatted_grand_totalOut</td>
    <td></td>  
</tr>
   
</table>
EOF;


 
    $pdf->writeHTML($header, false, false, false, false, '');
    
    $pdf->Output('Fully Paid Reports.pdf', 'I');
    
   }
  }  

  $clientsFormRequest = new printClientList();
  $clientsFormRequest -> getClientsPrinting();

?>