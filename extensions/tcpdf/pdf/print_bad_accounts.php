<?php

require_once "../../../models/connection.php";
require_once "../../../views/modules/session.php";



//SELECT SUM(balance) AS total_balance FROM past_due WHERE branch_name = "EMB MAIN BRANCH" AND balance != 0 AND type ="S" AND class = "D";
class printClientList{

    public $ref_id; 
    public function getClientsPrinting(){

    $account_no = $_REQUEST['account_no'];
    $branch_name = $_REQUEST['branch_name'];
    $connection = new connection;
    $connection->connect();

  require_once('tcpdf_include.php');


  $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
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
table, tr,td{
    font-size:8rem;
}

</style>


<table>

 <tr>
    <td colspan="17" style="text-align:center;font-weight:bold;font-size:9rem;">EMB CAPITAL LENDING CORPORATION</td>
 </tr>

 
 <tr>
    <td colspan="17" style="text-align:center;font-weight:bold;font-size:9rem;">SUMMARY OF BAD ACCOUNTS</td>
 </tr>

 <tr>
 <td colspan="17" style="text-align:center;font-weight:bold;font-size:9rem;">AS OF JUNE 2023</td>
</tr>

<tr>
<td colspan="17"></td>
</tr>

<tr>
<td colspan="17"></td>
</tr>


<tr>
<td></td>
</tr>

<tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td style="width:72px;"></td>
    <td style="border:1px solid black;width:100px;text-align:center;">TOTAL</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td style="width:27px;"></td>
    <td style="border:1px solid blakc;width:92px;text-align:center;">TOTAL POLICE</td>
    <td></td>
    <td style="width:28px;"></td>
    <td style="width:1px;"></td>
    <td style="border:1px solid black;width:105px;text-align:center;">TOTAL</td>
</tr>

<tr>
    <td style="border:1px solid black;width:100px;text-align:center;">PARTICULAR</td>
    <td style="border:1px solid black;width:30px;text-align:center;">S</td>
    <td style="border:1px solid black;width:95px;text-align:center;">Amount</td>
    <td style="border:1px solid black;width:30px;text-align:center;">E.</td>
    <td style="border:1px solid black;width:90px;text-align:center;">Amount</td>
    <td style="border:1px solid black;width:30px;text-align:center;">No.</td>
    <td style="border:1px solid black;width:100px;text-align:center;">DECEASED</td>
    <td style="border:1px solid black;width:30px;text-align:center;">S</td>
    <td style="border:1px solid black;width:90px;text-align:center;">Amount</td>
    <td style="border:1px solid black;width:30px;text-align:center;">E</td>
    <td style="border:1px solid black;width:90px;text-align:center;">Amount</td>
    <td style="border:1px solid black;width:30px;text-align:center;">No.</td>
    <td style="border:1px solid black;width:92px;text-align:center;">ACTION</td>
    <td style="border:1px solid black;width:30px;text-align:center;">S</td>
    <td style="border:1px solid black;width:30px;text-align:center;">E</td>
    <td style="border:1px solid black;width:30px;text-align:center;">No.</td>
    <td style="border:1px solid black;width:105px;text-align:center;">PAST DUE</td>
</tr>

</table>

EOF;

$sql1 = "SELECT branch_name,
                SUM(CASE WHEN type = 'S' THEN 1 ELSE 0 END) AS total_S_type,
                SUM(CASE WHEN type = 'E' THEN 1 ELSE 0 END) AS total_E_type
         FROM past_due
         WHERE class = 'D'
         AND branch_name LIKE '%EMB%'
         AND refdate < '2023-07-01' -- Exclude July 2023 and beyond
         GROUP BY branch_name";

$stmt1 = $connection->connect()->query($sql1);
$sumOfDecease_S = 0;
$sumOfAmountDecease_S = 0;
$totalOfDeceased_ES = 0;
$totalOfPolice_ES = 0;
while($info1 = $stmt1->fetch()){
        $branch_name = $info1['branch_name'];
        $total_S_type = $info1['total_S_type'];
        $total_E_type = $info1['total_E_type'];

        $total_S = 0;
        $total_E = 0;

        $total_S += $total_S_type;
        $total_E += $total_E_type;
        $sumOfDecease_S += $total_S;
        $total_types = $total_S + $total_E;    

// ******************************************************************************************************


$sql2 = "SELECT
        (SELECT COUNT(type) FROM past_due WHERE branch_name LIKE '%EMB' AND type = 'S' AND class = 'D') AS total_S,
        (SELECT -SUM(balance) FROM past_due WHERE branch_name LIKE '%EMB') AS total_balance,
        (SELECT SUM(debit) FROM past_due_ledger a INNER JOIN past_due b ON a.account_no = b.account_no AND a.branch_name = b.branch_name WHERE a.branch_name = '$branch_name' AND b.type = 'S' AND b.class = 'D' ) AS total_debit,
        (SELECT SUM(a.credit) FROM past_due_ledger a INNER JOIN past_due b ON a.account_no = b.account_no AND a.branch_name = b.branch_name WHERE a.branch_name = '$branch_name' AND b.type = 'S' AND b.class = 'D' ) AS total_credit,
        (SELECT -SUM(balance) FROM past_due WHERE branch_name = '$branch_name') + (SELECT SUM(debit) FROM past_due_ledger a INNER JOIN past_due b ON a.account_no = b.account_no AND a.branch_name = b.branch_name WHERE a.branch_name = '$branch_name' AND b.type = 'S' AND b.class = 'D' ) + (SELECT SUM(credit) FROM past_due_ledger a INNER JOIN past_due b ON a.account_no = b.account_no AND a.branch_name = b.branch_name WHERE a.branch_name = '$branch_name' AND b.type = 'S' AND b.class = 'D' ) AS result";
        

$stmt2 = $connection->connect()->query($sql2);
    while($info2 = $stmt2->fetch()){
        $total_amount2 = abs($info2['result']);
        $total_amount_formatted2 = number_format($total_amount2, 2, '.',',');
    
    }
    $sumOfAmountDecease_S += $total_amount2;
// **********************************************************************************************************


$sql3 = "SELECT
        (SELECT COUNT(type) FROM past_due WHERE branch_name LIKE '%EMB' AND type = 'E' AND class = 'D') AS total_S,
        (SELECT -SUM(balance) FROM past_due WHERE branch_name LIKE '%EMB') AS total_balance,
        (SELECT SUM(debit) FROM past_due_ledger a INNER JOIN past_due b ON a.account_no = b.account_no AND a.branch_name = b.branch_name WHERE a.branch_name = '$branch_name' AND b.type = 'E' AND b.class = 'D' ) AS total_debit,
        (SELECT SUM(a.credit) FROM past_due_ledger a INNER JOIN past_due b ON a.account_no = b.account_no AND a.branch_name = b.branch_name WHERE a.branch_name = '$branch_name' AND b.type = 'E' AND b.class = 'D' ) AS total_credit,
        (SELECT -SUM(balance) FROM past_due WHERE branch_name = '$branch_name') + (SELECT SUM(debit) FROM past_due_ledger a INNER JOIN past_due b ON a.account_no = b.account_no AND a.branch_name = b.branch_name WHERE a.branch_name = '$branch_name' AND b.type = 'E' AND b.class = 'D' ) + (SELECT SUM(credit) FROM past_due_ledger a INNER JOIN past_due b ON a.account_no = b.account_no AND a.branch_name = b.branch_name WHERE a.branch_name = '$branch_name' AND b.type = 'E' AND b.class = 'D' ) AS result";
        
$stmt3 = $connection->connect()->query($sql3);
    while($info3 = $stmt3->fetch()){
        $total_amount3 = abs($info3['result']);
        // $total_branches3 = 0;    
        // $total_branches3 += $total_amount3;
        $total_amount_formatted3 = number_format($total_amount3, 2, '.',',');
    }

    $total_deceased = number_format($total_amount2 + $total_amount3 , 2,'.',',');
// **********************************************************************************************************



$sql4 = "SELECT branch_name,
                SUM(CASE WHEN type = 'S' THEN 1 ELSE 0 END) AS total_S_type_P,
                SUM(CASE WHEN type = 'E' THEN 1 ELSE 0 END) AS total_E_type_P
         FROM past_due
         WHERE class = 'P'
         AND branch_name LIKE '%EMB%'
         AND refdate < '2023-07-01' -- Exclude July 2023 and beyond
         GROUP BY branch_name = '$branch_name' ";
$stmt4 = $connection->connect()->query($sql4);

while($info4 = $stmt4->fetch()){
        $total_S_type_P = $info4['total_S_type_P'];
        $total_E_type_P = $info4['total_E_type_P'];

        $total_S_P = 0;
        $total_E_P = 0;

        $total_S_P += $total_S_type_P;
        $total_E_P += $total_E_type_P;
        $total_types_P = $total_S_P + $total_E_P;    

}
//************************************************************************************ */


$sql5 = "SELECT
        (SELECT COUNT(type) FROM past_due WHERE branch_name LIKE '%EMB' AND type = 'S' AND class = 'P') AS total_S,
        (SELECT -SUM(balance) FROM past_due WHERE branch_name LIKE '%EMB') AS total_balance,
        (SELECT SUM(debit) FROM past_due_ledger a INNER JOIN past_due b ON a.account_no = b.account_no AND a.branch_name = b.branch_name WHERE a.branch_name = '$branch_name' AND b.type = 'S' AND b.class = 'P' ) AS total_debit,
        (SELECT SUM(a.credit) FROM past_due_ledger a INNER JOIN past_due b ON a.account_no = b.account_no AND a.branch_name = b.branch_name WHERE a.branch_name = '$branch_name' AND b.type = 'S' AND b.class = 'P' ) AS total_credit,
        (SELECT -SUM(balance) FROM past_due WHERE branch_name = '$branch_name') + (SELECT SUM(debit) FROM past_due_ledger a INNER JOIN past_due b ON a.account_no = b.account_no AND a.branch_name = b.branch_name WHERE a.branch_name = '$branch_name' AND b.type = 'S' AND b.class = 'P' ) + (SELECT SUM(credit) FROM past_due_ledger a INNER JOIN past_due b ON a.account_no = b.account_no AND a.branch_name = b.branch_name WHERE a.branch_name = '$branch_name' AND b.type = 'S' AND b.class = 'P' ) AS result";
        

$stmt5 = $connection->connect()->query($sql5);
    while($info5 = $stmt5->fetch()){
        $total_amount5 = abs($info5['result']);
        $total_amount_formatted5 = number_format($total_amount5, 2, '.',',');
    }

//************************************************************************************ */
$sql6 = "SELECT
        (SELECT COUNT(type) FROM past_due WHERE branch_name LIKE '%EMB' AND type = 'E' AND class = 'P') AS total_S,
        (SELECT -SUM(balance) FROM past_due WHERE branch_name LIKE '%EMB') AS total_balance,
        (SELECT SUM(debit) FROM past_due_ledger a INNER JOIN past_due b ON a.account_no = b.account_no AND a.branch_name = b.branch_name WHERE a.branch_name = '$branch_name' AND b.type = 'E' AND b.class = 'P' ) AS total_debit,
        (SELECT SUM(a.credit) FROM past_due_ledger a INNER JOIN past_due b ON a.account_no = b.account_no AND a.branch_name = b.branch_name WHERE a.branch_name = '$branch_name' AND b.type = 'E' AND b.class = 'P' ) AS total_credit,
        (SELECT -SUM(balance) FROM past_due WHERE branch_name = '$branch_name') + (SELECT SUM(debit) FROM past_due_ledger a INNER JOIN past_due b ON a.account_no = b.account_no AND a.branch_name = b.branch_name WHERE a.branch_name = '$branch_name' AND b.type = 'E' AND b.class = 'P' ) + (SELECT SUM(credit) FROM past_due_ledger a INNER JOIN past_due b ON a.account_no = b.account_no AND a.branch_name = b.branch_name WHERE a.branch_name = '$branch_name' AND b.type = 'E' AND b.class = 'P' ) AS result";
        

$stmt6 = $connection->connect()->query($sql6);
    while($info6 = $stmt6->fetch()){
        $total_amount6 = abs($info6['result']);
        $total_amount_formatted6 = number_format($total_amount6, 2, '.',',');
    }
    $total_police_action = number_format($total_amount5 + $total_amount6 , 2,'.',',');





    $totalOfDeceased_ES = $total_S + $total_S_P;
    $totalOfPolice_ES = $total_E + $total_E_P;
    $totalOfDP_ES = $totalOfDeceased_ES + $totalOfPolice_ES;
//**************************************************************************************** */









$header .= <<<EOF
<table>
<tr>
    <td style="border:1px solid black;width:100px;text-align:left;">$branch_name</td>
    <td style="border:1px solid black;width:30px;text-align:center;">$total_S</td>
    <td style="border:1px solid black;width:95px;text-align:center;">$total_amount_formatted2</td>
    <td style="border:1px solid black;width:30px;text-align:center;">$total_E</td>
    <td style="border:1px solid black;width:90px;text-align:center;">$total_amount_formatted3</td>
    <td style="border:1px solid black;width:30px;text-align:center;">$total_types</td>
    <td style="border:1px solid black;width:100px;text-align:center;">$total_deceased</td>
    <td style="border:1px solid black;width:30px;text-align:center;">$total_S_P</td>
    <td style="border:1px solid black;width:90px;text-align:center;">$total_amount_formatted5</td>
    <td style="border:1px solid black;width:30px;text-align:center;">$total_E_P</td>
    <td style="border:1px solid black;width:90px;text-align:center;">$total_amount_formatted6</td>
    <td style="border:1px solid black;width:30px;text-align:center;">$total_types_P</td>
    <td style="border:1px solid black;width:92px;text-align:center;">$total_police_action</td>
    <td style="border:1px solid black;width:30px;text-align:center;">$totalOfDeceased_ES</td>
    <td style="border:1px solid black;width:30px;text-align:center;">$totalOfPolice_ES</td>
    <td style="border:1px solid black;width:30px;text-align:center;">$totalOfDP_ES</td>
    <td style="border:1px solid black;width:105px;text-align:center;"></td>
</tr>



</table>



EOF; 

}



$header .= <<<EOF

<table>
<tr>
<td style="border:1px solid black;width:100px;text-align:center;font-weight:bold;">Total</td>
<td style="border:1px solid black;width:30px;text-align:center;">$sumOfDecease_S</td>
<td style="border:1px solid black;width:95px;text-align:center;">$sumOfAmountDecease_S</td>
<td style="border:1px solid black;width:30px;text-align:center;"></td>
<td style="border:1px solid black;width:90px;text-align:center;"></td>
<td style="border:1px solid black;width:30px;text-align:center;"></td>
<td style="border:1px solid black;width:100px;text-align:center;"></td>
<td style="border:1px solid black;width:30px;text-align:center;"></td>
<td style="border:1px solid black;width:90px;text-align:center;"></td>
<td style="border:1px solid black;width:30px;text-align:center;"></td>
<td style="border:1px solid black;width:90px;text-align:center;"></td>
<td style="border:1px solid black;width:30px;text-align:center;"></td>
<td style="border:1px solid black;width:92px;text-align:center;"></td>
<td style="border:1px solid black;width:30px;text-align:center;"></td>
<td style="border:1px solid black;width:30px;text-align:center;"></td>
<td style="border:1px solid black;width:30px;text-align:center;"></td>
<td style="border:1px solid black;width:105px;text-align:center;"></td>
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












<?php

// $total_S_P_type = 0;
    // $total_E_P_type = 0;

    
    // $sql6 = "SELECT branch_name,
    //                 SUM(CASE WHEN type = 'S' THEN 1 ELSE 0 END) AS total_S_P_type,
    //                 SUM(CASE WHEN type = 'E' THEN 1 ELSE 0 END) AS total_E_P_type
    //          FROM past_due
    //          WHERE class = 'P'
    //          AND branch_name LIKE '%EMB%'
    //          AND refdate < '2023-07-01' -- Exclude July 2023 and beyond
    //          AND branch_name = :branch_name -- Add a parameter to filter by branch_name
    //          GROUP BY branch_name;";

    // // Prepare the statement for SQL6
    // $stmt6 = $connection->connect()->prepare($sql6);

  
    // $stmt6->bindParam(':branch_name', $branch_name, PDO::PARAM_STR);


    // $stmt6->execute();

    // // Loop through the results of SQL6
    // while ($info6 = $stmt6->fetch()) {
    //     // Update the total counts with each iteration
    //     $total_S_P_type += $info6['total_S_P_type'];
    //     $total_E_P_type += $info6['total_E_P_type'];
    //     $total_ES_total = $total_S_P_type + $total_E_P_type;
    // }

// *********************************************************************************************** total of type S
// $sql_total_DP_S = "SELECT branch_name,
//                 SUM(CASE WHEN class = 'D' THEN 1 ELSE 0 END) AS total_D_S,
//                 SUM(CASE WHEN class = 'P' THEN 1 ELSE 0 END) AS total_P_S
//                 FROM past_due
//                 WHERE type = 'S'
//                 AND branch_name LIKE '%EMB%'
//                 AND refdate < '2023-07-01' -- Exclude July 2023 and beyond
//                 AND branch_name = :branch_name -- Add a parameter to filter by branch_name
//                 GROUP BY branch_name;";

// $stmt_total_S = $connection->connect()->prepare($sql_total_DP_S);

// // Assuming you have set the $branch_name variable before this point
// $stmt_total_S->bindParam(':branch_name', $branch_name, PDO::PARAM_STR);

// $total_D_S = 0;
// $total_P_S = 0;

// $stmt_total_S->execute();

// while ($info_total_S = $stmt_total_S->fetch()) {
//     $total_D_S += $info_total_S['total_D_S'];
//     $total_P_S += $info_total_S['total_P_S'];
// }

// $total_S_DP_total = $total_D_S + $total_P_S;

// // *********************************************************************************************** total of type E
// $sql_total_DP_E = "SELECT branch_name,
//                 SUM(CASE WHEN class = 'D' THEN 1 ELSE 0 END) AS total_D_E,
//                 SUM(CASE WHEN class = 'P' THEN 1 ELSE 0 END) AS total_P_E
//                 FROM past_due
//                 WHERE type = 'E'
//                 AND branch_name LIKE '%EMB%'
//                 AND refdate < '2023-07-01' -- Exclude July 2023 and beyond
//                 AND branch_name = :branch_name -- Add a parameter to filter by branch_name
//                 GROUP BY branch_name;";

// $stmt_total_E = $connection->connect()->prepare($sql_total_DP_E);

// // Assuming you have set the $branch_name variable before this point
// $stmt_total_E->bindParam(':branch_name', $branch_name, PDO::PARAM_STR);

// $total_D_E = 0;
// $total_P_E = 0;

// $stmt_total_E->execute();

// while ($info_total_E = $stmt_total_E->fetch()) {
//     $total_D_E += $info_total_E['total_D_E'];
//     $total_P_E += $info_total_E['total_P_E'];
// }

// $total_E_DP_total = $total_D_E + $total_P_E;

// // *********************************************************************************************** total of type E
// $final_total_SE = $total_E_DP_total + $total_S_DP_total;

// $sql2 = "SELECT branch_name FROM past_due WHERE branch_name LIKE '%EMB%' ";


// ************** for S AND E OF DECEASED **************

// $sql3 = "SELECT branch_name,
//         SUM(CASE WHEN type = 'S' THEN 1 ELSE 0 END) AS total_S,
//         SUM(CASE WHEN type = 'E' THEN 1 ELSE 0 END) AS total_E
//         FROM past_due  WHERE branch_name = '$branch_name' AND refdate < '2023-07-01' AND class ='D'";

// $stmt3 = $connection->connect()->query($sql3);

// while($info3 = $stmt3->fetch()){
//     $total_S = $info3['total_S'];
//     $total_E = $info3['total_E'];
// }















// $sql3 = "SELECT SUM(debit) AS total_debit, SUM(credit) AS total_credit
// FROM past_due_ledger
// WHERE branch_name = '$branch_name' ";
// $total_deb = 0;
// $total_cred = 0;
// $stmt3 = $connection->connect()->query($sql3);

// while($info3 = $stmt3->fetch()){
//     $total_debit = $info3['total_debit'];
//     $total_credit = $info3['total_credit'];
// }


// $sql2 = "SELECT pd.branch_name, pd.balance
//         FROM past_due pd
//         INNER JOIN past_due_ledger pdl ON pd.account_no = pdl.account_no
//         WHERE pd.class = 'D' 
//         AND pd.branch_name = '$branch_name'
//         AND pd.type = 'S'";


//         $stmt2 = $connection->connect()->query($sql2);
    
//         while($info2 = $stmt2->fetch()){
//             $balance = $info2['balance'];

//             if ($balance != 0) {
//                 $total_preBal = ($balance - $total_credit) - $total_debit;
//                 $org_total_prebal = $total_preBal;
//             } else {
//                 $total_preBal = $total_debit + $total_credit;
//                 $org_total_prebal = $total_preBal;
//                 if ($total_preBal < 0) {
//                     $total_preBal = abs($total_preBal);
//                 } else {
//                     $total_preBal = -1 * $total_preBal;
//                 }
//             } 
        
//         }

?>