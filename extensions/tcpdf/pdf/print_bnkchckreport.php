<?php

require_once "../../../models/connection.php";
require_once "../../../views/modules/session.php";
require_once "../../../controllers/checkwriter.controller.php";
require_once "../../../models/checkwriter.model.php";

class printClientList{

    // public $ref_id; 
public function getClientsPrinting(){

    
require_once('tcpdf_include.php');

    $branch_name = $_SESSION['branch_name'];
    $date_from = $_GET['date_from']; /*start from entered date*/
    $formated_date_from = date('F d, Y', strtotime($date_from));

    $date_to = $_GET['date_to']; /*start from entered date*/
    $formated_date_to = date('F d, Y', strtotime($date_to));

    $selected_bank = $_GET['bnk_bank'];

    //   $pdf = new TCPDF('L', PDF_UN IT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
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
    $pdf->SetMargins(9,9);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, 10);

    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    $pdf->SetFont('dejavusans');
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

    // - - - - - - - - - - -
    if ($date_from == $date_to) {
        $report_date = "DATE COVERED : " . strtoupper(date("M j Y", strtotime($date_from)));
    } else {
        $report_date = "DATE COVERED : " . strtoupper(date("M j, Y", strtotime($date_from)) .' - '. date("M j, Y", strtotime($date_to))); 
    }
    
    // $reportName = "PDR Performance Summary ".$forTheMont . ".pdf";

    $header = "
    <style>
        table, tr, td {
            font-size:6.4rem;
        }
        table, tr, th {
            font-size:6.4rem;
        }
    </style>

    <table>
        <tr>
            <td colspan=\"13\" style=\"text-align:left;font-weight:bold;border:none;font-size: 11px;\">DETAILED CHECK WRITER REPORT</td>
        </tr>
        <tr>
            <td style=\"text-align:left;font-weight:medium;border:none;font-size: 10px;\" colspan=\"13\">" . $report_date . "</td>
        </tr>
        <tr>
            <td colspan=\"13\" style=\"border:none;\"></td>
        </tr>
        <tr>
            <th style=\"text-align:left;\" colspan=\"12\">Branch : <span style=\"font-weight:bold;\">" . $branch_name . "</span></th>
        </tr>
        <tr>
            <td colspan=\"13\" style=\"border:none;\"></td>
        </tr>
    </table>";

    if ($selected_bank === 'All') {

        $bank_list = new ControllerCheckWriter();
        $banks = $bank_list->ctrShowAllBank();

        $grand_total_debit = 0;
        $grand_total_credit = 0;
        $grand_total_cur_bal = 0;
        $grand_total_prev_bal = 0;

        foreach ($banks as $key => $row) {
            $bnkcd = $row['bnkcd'];
            $BNKCHCKREPORT = (new ControllerCheckWriter)->ctrShowFilterTransaction($date_from, $date_to, $bnkcd);

            if (!empty($BNKCHCKREPORT)) {
               
                $total_debit = 0;
                $total_credit = 0;

                $title_bank_name = $BNKCHCKREPORT[0]['bb_bnk_name'];
                $title_bank_code = $BNKCHCKREPORT[0]['bl_bnkcd'];

                $header .= "
                <style>
                    table, tr, td {
                        font-size:6.4rem;
                    }
                    table, tr, th {
                        font-size:6.4rem;
                    }
                </style>
                <table>
                    <tr>
                        <th style=\"text-align:center; width: 90px;\"></th>
                        <th style=\"text-align:left; border-bottom: 1px double black; width: 90px;\"></th>
                        <th style=\"text-align:center; border-bottom: 1px double black; width: 220px;\"></th>
                        <th style=\"text-align:right; border-bottom: 1px double black; width: 95px;\"></th>
                        <th style=\"text-align:right; border-bottom: 1px double black; width: 95px;\"></th>
                        <th style=\"text-align:right; border-bottom: 1px double black; width: 95px;\"></th>
                    </tr>
                    <tr>
                        <th style=\"text-align:center; width: 90px;\"><b>" . $title_bank_name . " (" . $title_bank_code . ")</b></th>
                        <th style=\"text-align:center; border-bottom: 1px double black; width: 220px;\">PAY TO</th>
                        <th style=\"text-align:right; border-bottom: 1px double black; width: 90px;\">PREV BAL</th>
                        <th style=\"text-align:right; border-bottom: 1px double black; width: 95px;\">CUR BAL</th>
                        <th style=\"text-align:right; border-bottom: 1px double black; width: 95px;\">DISBURSEMENT</th>
                        <th style=\"text-align:right; border-bottom: 1px double black; width: 95px;\">END BALANCE</th>
                    </tr>
                </table>";

                foreach ($BNKCHCKREPORT as $key => $bnkrow) {
    
                    $debit = 0;
                    $credit = 0;

                    if ($bnkrow["bl_action"] === 'Print Check') {
                        $debit = $bnkrow["bl_prev_bal"];
                        $credit = $bnkrow["bl_amount"];
                    }else if ( $bnkrow["bl_action"] == 'Add Bank Balance'){
                        $debit = $bnkrow['bl_amount'];
                    }

                    $FormatedPrevDateNJ = strtoupper(date('F j, Y', strtotime($bnkrow["bl_date"])));

                    if ($bnkrow["bl_action"] === 'Add Bank Balance') {
                        $payto = "Bank balance as of &nbsp;" . $FormatedPrevDateNJ;
                    } else{
                        $payto = $bnkrow["b_payto"];
                    }

                    $total_debit = $total_debit + $debit;
                    $total_credit = $total_credit + $credit;

                    // $payto = $bnkrow["b_payto"] != '' ?  $bnkrow["b_payto"] : '';

                    $bank_name = $bnkrow["bb_bnk_name"];
                    $bank_date = date('F j, Y' ,strtotime($bnkrow["bl_date"]));
                    $bank_code = $bnkrow["bl_bnkcd"];
                    $bank_docno = number_format(floatVal($bnkrow["bl_prev_bal"]), 2, '.', ',');
                    $bank_payto = $payto;
                    $bank_debit = number_format(floatVal($debit), 2, '.', ',');
                    $bank_credit = number_format(floatVal($credit), 2, '.', ',');
                    $bank_balance = number_format(floatval($bnkrow["bl_cur_bal"]), 2, '.', ',');

                    $header .= "
                        <table>
                            <tr>
                                <td colspan=\"13\"></td>
                            </tr>
                        </table>
                        <table>
                            <tr>
                                <td style=\"text-align: center; width: 90px;\">" . $bank_date . "</td>
                                <td style=\"text-align: left; width: 220px;\">" . $bank_payto . "</td>
                                <td style=\"text-align: right; width: 90px;\">" . $bank_docno . "</td>
                                <td style=\"text-align: right; width: 95px;\">" . $bank_debit . "</td>
                                <td style=\"text-align: right; width: 95px;\">" . $bank_credit . "</td>
                                <td style=\"text-align: right; width: 95px;\">" . $bank_balance . "</td>
                            </tr>
                        </table>";

                } 

                $FormatedPrevDate = strtoupper(date('F j, Y', strtotime('-1 day', strtotime($date_from)))); 

                $grand_total_debit = $grand_total_debit + $total_debit;
                $grand_total_credit = $grand_total_credit + $total_credit;

                if ($total_debit > 0) {
                    $formatted_total_debit = number_format(floatval($total_debit), 2, '.', ',');
                } else {
                    $formatted_total_debit = '0.00';
                }
                if ($total_credit > 0) {
                    $formatted_total_credit = number_format(floatval($total_credit), 2, '.', ',');
                } else {
                    $formatted_total_credit = '0.00';
                }
                
                $begBal = (new ControllerCheckWriter)->ctrGetBegBal($date_from, $bank_code);
                $endBal = (new ControllerCheckWriter)->ctrGetEndBal($date_to, $bank_code);
        
                if ($begBal && isset($begBal['cur_bal'])) {
                    $prevBal = number_format(floatval($begBal["cur_bal"]), 2, '.', ',');
                    $grand_total_prev_bal = floatval($grand_total_prev_bal) + floatval($begBal['cur_bal']);
                } else {
                    $prevBal = '0.00';
                    $grand_total_prev_bal = floatval($grand_total_prev_bal);
                }
                if ($endBal && isset($endBal['cur_bal'])) {
                    $curBal = number_format(floatval($endBal["cur_bal"]), 2, '.', ',');
                    $grand_total_cur_bal = floatval($grand_total_cur_bal) + floatval($endBal['cur_bal']);
                } else {
                    $curBal = '0.00';
                    $grand_total_cur_bal = floatval($grand_total_cur_bal);
                }

                if ($grand_total_prev_bal > 0) {
                    $formatted_total_prev_bal = number_format(floatval($prevBal), 2, '.', ',');
                } else {
                    $formatted_total_prev_bal = '0.00';
                }
                if ($grand_total_cur_bal > 0) {
                    $formatted_total_cur_bal = number_format(floatval($curBal), 2, '.', ',');
                } else {
                    $formatted_total_cur_bal = '0.00';
                }

                $header .= "
                    <table>
                        <tr>
                            <td></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td style=\"text-align: left; width: 405px;\"></td>
                            <td style=\"text-align: right; width: 85px;\"></td>
                            <td style=\"text-align: left; width: 10px;\"></td>
                            <td style=\"text-align: right; width: 85px; border-bottom: 1px double black;\"></td>
                            <td style=\"text-align: left; width: 10px;\"></td>
                            <td style=\"text-align: right; width: 85px; border-bottom: 1px double black;\"></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td style=\"text-align: left; width: 60px;\"></td>
                            <td style=\"text-align: right; width: 225px;\"></td>
                            <td style=\"text-align: left; width: 95px;\"></td>
                            <td style=\"text-align: right; width: 100px;\"><b>Sub Total : </b></td>
                            <td style=\"text-align: right; width: 15px;\"><b></b></td>
                            <td style=\"text-align: right; width: 95px;\"><b>" . $formatted_total_credit . "</b></td>
                            <td style=\"text-align: right; width: 95px;\"><b>" . $curBal . "</b></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td colspan=\"13\"></td>
                        </tr>
                    </table>";
                } else {
                    $header .= "";
                }

            }
            if ($grand_total_debit > 0) {
                $formatted_grand_total_debit = number_format(floatval($grand_total_debit), 2, '.', ',');
            } else {
                $formatted_grand_total_debit = '0.00';
            }

            if ($grand_total_credit > 0) {
                $formatted_grand_total_credit = number_format(floatval($grand_total_credit), 2, '.',',');
            }else{
                $formatted_grand_total_credit = '0.00';
            }

            if ($grand_total_prev_bal > 0) {
                $formatted_grand_total_prev_bal = number_format(floatval($grand_total_prev_bal), 2, '.',',');
            }else{
                $formatted_grand_total_prev_bal = '0.00';
            }

            if ($grand_total_cur_bal > 0) {
                $formatted_grand_total_cur_bal = number_format(floatval($grand_total_cur_bal), 2, '.',',');
            }else{
                $formatted_grand_total_cur_bal = '0.00';
            }

            $header .= "
                <table>
                    <tr>
                        <td style=\"text-align: left; width: 405px;\"></td>
                        <td style=\"text-align: right; width: 85px;\"></td>
                        <td style=\"text-align: left; width: 10px;\"></td>
                        <td style=\"text-align: right; width: 85px; border-bottom: 1px double black;\"></td>
                        <td style=\"text-align: left; width: 10px;\"></td>
                        <td style=\"text-align: right; width: 85px; border-bottom: 1px double black;\"></td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td style=\"text-align: left; width: 60px;\"></td>
                        <td style=\"text-align: right; width: 225px; font-weight: bold;\"></td>
                        <td style=\"text-align: left; width: 95px;\"></td>
                        <td style=\"text-align: right; width: 100px;\"><b>Total : </b></td>
                        <td style=\"text-align: right; width: 15px;\"><b></b></td>
                        <td style=\"text-align: right; width: 95px;\"><b>" . $formatted_grand_total_credit . "</b></td>
                        <td style=\"text-align: right; width: 95px;\"><b>" . $formatted_grand_total_cur_bal . "</b></td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td colspan=\"13\"></td>
                    </tr>
                </table>";
        
    } else {

        $bnkcd = $selected_bank;
            
        $BNKCHCKREPORT = (new ControllerCheckWriter)->ctrShowFilterTransaction($date_from, $date_to, $bnkcd);

        $total_debit = 0;
        $total_credit = 0;

        if (!empty($BNKCHCKREPORT)) {

            $title_bank_name = $BNKCHCKREPORT[0]['bb_bnk_name'];
            $title_bank_code = $BNKCHCKREPORT[0]['bl_bnkcd'];

            $header .= "
                <style>
                    table, tr, td {
                        font-size:6.4rem;
                    }
                    table, tr, th {
                        font-size:6.4rem;
                    }
                </style>
                <table>
                   <tr>
                        <th style=\"text-align:center; width: 90px;\"></th>
                        <th style=\"text-align:left; border-bottom: 1px double black; width: 90px;\"></th>
                        <th style=\"text-align:center; border-bottom: 1px double black; width: 220px;\"></th>
                        <th style=\"text-align:right; border-bottom: 1px double black; width: 95px;\"></th>
                        <th style=\"text-align:right; border-bottom: 1px double black; width: 95px;\"></th>
                        <th style=\"text-align:right; border-bottom: 1px double black; width: 95px;\"></th>
                    </tr>
                    <tr>
                        <th style=\"text-align:center; width: 90px;\"><b>" . $title_bank_name . " (" . $title_bank_code . ")</b></th>
                        <th style=\"text-align:center; border-bottom: 1px double black; width: 220px;\">PAY TO</th>
                        <th style=\"text-align:right; border-bottom: 1px double black; width: 90px;\">PREV BAL</th>
                        <th style=\"text-align:right; border-bottom: 1px double black; width: 95px;\">CUR BAL</th>
                        <th style=\"text-align:right; border-bottom: 1px double black; width: 95px;\">DISBURSEMENT</th>
                        <th style=\"text-align:right; border-bottom: 1px double black; width: 95px;\">END BALANCE</th>
                    </tr>
                </table>";
            
            foreach ($BNKCHCKREPORT as $key => $bnkrow) {

                $debit = 0;
                $credit = 0;
                
                if ($bnkrow["bl_action"] === 'Print Check') {
                    $debit = $bnkrow["bl_prev_bal"];
                    $credit = $bnkrow["bl_amount"];
                }else if ( $bnkrow["bl_action"] == 'Add Bank Balance'){
                    $debit = $bnkrow['bl_amount'];
                }

                $FormatedPrevDateNJ = strtoupper(date('F j, Y', strtotime($bnkrow["bl_date"])));

                if ($bnkrow["bl_action"] === 'Add Bank Balance') {
                    $payto = "Bank balance as of &nbsp;" . $FormatedPrevDateNJ;
                } else{
                    $payto = $bnkrow["b_payto"];
                }

                $total_debit = $total_debit + $debit;
                $total_credit = $total_credit + $credit;

                $bank_name = $bnkrow["bb_bnk_name"];
                $bank_date = date('F j, Y' ,strtotime($bnkrow["bl_date"]));
                $bank_code = $bnkrow["bl_bnkcd"];
                $bank_docno = number_format(floatVal($bnkrow["bl_prev_bal"]), 2, '.', ',');
                $bank_payto = $payto;
                $bank_debit = number_format(floatVal($debit), 2, '.', ',');
                $bank_credit = number_format(floatVal($credit), 2, '.', ',');
                $bank_balance = number_format(floatval($bnkrow["bl_cur_bal"]), 2, '.', ',');

                $header .= "
                    <table>
                        <tr>
                            <td colspan=\"13\"></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td style=\"text-align: center; width: 90px;\">" . $bank_date . "</td>
                            <td style=\"text-align: left; width: 220px;\">" . $bank_payto . "</td>
                            <td style=\"text-align: right; width: 90px;\">" . $bank_docno . "</td>
                            <td style=\"text-align: right; width: 95px;\">" . $bank_debit . "</td>
                            <td style=\"text-align: right; width: 95px;\">" . $bank_credit . "</td>
                            <td style=\"text-align: right; width: 95px;\">" . $bank_balance . "</td>
                        </tr>
                    </table>";
                
            }

            $FormatedPrevDate = strtoupper(date('F j, Y', strtotime('-1 day', strtotime($date_from)))); 

            $formatted_total_debit = ($total_debit > 0) ? number_format(floatval($total_debit), 2, '.', ',') : '0.00';
            $formatted_total_credit = ($total_credit > 0) ? number_format(floatval($total_credit), 2, '.', ',') : '0.00';

            $begBal = (new ControllerCheckWriter)->ctrGetBegBal($date_from, $bnkcd);
            $endBal = (new ControllerCheckWriter)->ctrGetEndBal($date_to, $bank_code);

            if ($begBal && isset($begBal['cur_bal'])) {
                $prevBal = number_format(floatval($begBal["cur_bal"]), 2, '.', ',');
            } else {
                $prevBal = '0.00';
            }

            if ($endBal && isset($endBal['cur_bal'])) {
                $curBal = number_format(floatval($endBal["cur_bal"]), 2, '.', ',');
            } else {
                $curBal = '0.00';
            }

            $header .= "
                <table>
                    <tr>
                        <td></td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td style=\"text-align: left; width: 405px;\"></td>
                        <td style=\"text-align: right; width: 85px;\"></td>
                        <td style=\"text-align: left; width: 10px;\"></td>
                        <td style=\"text-align: right; width: 85px; border-bottom: 1px double black;\"></td>
                        <td style=\"text-align: left; width: 10px;\"></td>
                        <td style=\"text-align: right; width: 85px; border-bottom: 1px double black;\"></td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td style=\"text-align: left; width: 60px;\"></td>
                        <td style=\"text-align: right; width: 225px;\"><i></i></td>
                        <td style=\"text-align: left; width: 95px;\"></td>
                        <td style=\"text-align: right; width: 100px;\"><b>Total : </b></td>
                        <td style=\"text-align: right; width: 15px;\"><b></b></td>
                        <td style=\"text-align: right; width: 95px;\"><b>" . $formatted_total_credit . "</b></td>
                        <td style=\"text-align: right; width: 95px;\"><b>" . $curBal . "</b></td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td colspan=\"13\"></td>
                    </tr>
                </table>";

        }else{
            $header .= "";
        }   
    }
 
    $pdf->writeHTML($header, false, false, false, false, '');
    
    $pdf->Output('SOA REPORT', 'I');
    
   }
  }  

  $clientsFormRequest = new printClientList();
  $clientsFormRequest -> getClientsPrinting();

?>
