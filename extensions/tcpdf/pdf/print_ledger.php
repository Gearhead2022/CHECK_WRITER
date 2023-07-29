<?php

require_once "../../../models/connection.php";
require_once "../../../views/modules/session.php";

class printClientList{

    public $ref_id; 
    public function getClientsPrinting(){

    $account_no = $_REQUEST['account_no'];
    $branch_name = $_REQUEST['branch_name'];
    $connection = new connection;
    $connection->connect();
//  GET DATA IN PASTDUE   
    $sql = "SELECT * FROM past_due 
    WHERE account_no = '$account_no' AND branch_name = '$branch_name'";

$stmt = $connection->connect()->query($sql);

while($info = $stmt->fetch()){
    $last_name= $info['last_name'];
    $first_name= $info['first_name'];
    $age = $info['age'];
    $account_no = $info['account_no'];
    $original_balance = $info['balance'];
    $address = $info['address'];
    $refdate = $info['refdate'];
    $class = $info['class'];

    
    //  $credit = $info['credit'];

    if($class == "D"){
        $class = "DECEASED";
    }
    elseif ($class == "F"){
        $class = "FULLY PAID";
    }
    elseif ($class == "P"){
        $class = "POLICE ACTION";
    }
    elseif ($class == "W"){
        $class = "WRITE OFF";
    }
    elseif ($class == "L"){
        $class = "LITIGATION";
    }
    
    
}

$sql2 = "SELECT * FROM past_due_ledger
WHERE account_no = '$account_no' AND  branch_name = '$branch_name' limit  1";

$stmt2 = $connection->connect()->query($sql2);

while($info2 = $stmt2->fetch()){
    $amount = $info2['amount'];
    $id = $info2['id'];
    $debit = $info2['debit'];
    if($info2['debit'] ==""){
        $debit = 0;
    }
}


    $positive_balance = -1 * $original_balance;

    $formatted_positive_balance = abs($positive_balance);
    $formatted_positive_balance = number_format($formatted_positive_balance, 2, '.',',');


    // LEDGER
   
     
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
table, tr ,th{
    font-size:9rem;
}

</style>

<table class="first-table">
    <tr>
        <th style="width:210px;">PASTDUE / $class</th>
        <th colspan="2">NAME: $last_name $first_name</th>
        <th></th>
        <th></th>
        <th></th>
    </tr>

    <tr>
        <td style="height:10px;padding:0;">ACCT# : $account_no</td>
        <td colspan="3">ADDRESS: $address</td>
    </tr>
    <tr>
        <td>AGE: $age</td>
    </tr>
    <hr>
    <tr>
        <td></td>
    </tr>

    
    <tr>
        <td style="width:80px;">$refdate</td>
        <td style="width:120px;">Beginning Balance</td>    
        <td style="width:40px;"></td>

        <td>$formatted_positive_balance</td>  <!-- BEGINNING BALANCE -->
        
        <td></td>  
    </tr>
    </table>

EOF; 

    $sql1 = "SELECT * FROM past_due_ledger
WHERE account_no = '$account_no' AND branch_name = '$branch_name'";




$stmt1 = $connection->connect()->query($sql1);

while($info1 = $stmt1->fetch()){
$date = $info1['date'];
$refno = $info1['refno'];
$credit = $info1['credit'];
$debit = $info1['debit'];

if($debit != ""){
    $amount = $debit;
}else{
    $amount = $credit;
}


    $total = $amount + $positive_balance;
    $final_total = $total;
    $positive_balance = $final_total;

// 3453434343
$roundedTotal = round($positive_balance, 2); // Round to 2 decimal places

if ($roundedTotal <0) {
    $final_total2 = abs($roundedTotal);
}else{
    $final_total2 = -1 * $roundedTotal;

}

$formatted_amount = number_format($amount, 2, '.',',');

$formatted_total = number_format($final_total2, 2, '.', ',');

$header .= <<<EOF
<table>

<tr>
    <td style="width:80px;">$date</td>
    <td style="width:80px;">$refno</td>  
    <td style="width:80px;">$formatted_amount</td>  
    <td style="width:80px;">$formatted_total</td>
    <td></td>  
</tr>
   
EOF;
$header .= <<<EOF
</table>
EOF;
}
 
    $pdf->writeHTML($header, false, false, false, false, '');
    
    $pdf->Output('Fully Paid Reports.pdf', 'I');
    
   }
  }  

  $clientsFormRequest = new printClientList();
  $clientsFormRequest -> getClientsPrinting();

?>