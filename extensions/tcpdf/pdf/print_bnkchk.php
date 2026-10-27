<?php
require_once "../../../controllers/checkwriter.controller.php";
require_once "../../../models/checkwriter.model.php";
require_once "../../../models/connection.php";
require_once "../../../views/modules/session.php";

$clientsForm = new CheckWriter();
$clientsForm->printCheckWriter();

class CheckWriter {

    public function printCheckWriter() {

        $connection = new connection;
        $connection->connect();

        $docno = $_GET['docno'];
        $cdate = $_GET['cdate'];
        $bank_type = $_GET['bank'];

        require_once('tcpdf_include.php');
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->startPageGroup();
        $pdf->setPrintHeader(false);  /*remove line on top of the page*/
        $pdf->setPrintFooter(false);  /*remove line on top of the page*/

        // set document information
        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 009', PDF_HEADER_STRING);

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(1, 9, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(0);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        $pdf->AddPage();
        // cid0ct
        // Set font
        $pdf->SetFont('sanxmono', '', 12); // Set font to Arial

        // Set line height
        $lineHeight = 10; // Set your desired line height

        // set JPEG quality
        $pdf->setJPEGQuality(75);
        // Example of Image from data stream ('PHP rules')
        $imgdata = base64_decode('');

        // $img_file = K_PATH_IMAGES.'template14.jpg';
        // $pdf->Image($img_file, 0, 0, 190, 110, '', '', '', false, 300, '', false, false, 0);

        // The '@' character is used to indicate that follows an image data stream and not an image file name
        $pdf->Image('@' . $imgdata);

        //rlwh//
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

        // Image example with resizing
        // $pdf->Image('../../../views/files/'.$img_name.'', 165, 15, 30, 25, 'JPG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 1, false, false, false);

        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

        // $space = '  ';  // Two spaces
        // $format_date_month = date("F", strtotime($tdate));
        // $format_date_date = date("d", strtotime($tdate));
        // $format_date_year = date("y", strtotime($tdate));

        $time = time();
        $date = date("M-d-y", $time);
        $format_date_month = date("m", strtotime($cdate));
        $format_date_date = date("d", strtotime($cdate));
        $format_date_year = date("Y", strtotime($cdate));

        $dataList = (new ControllerCheckWriter)->ctrShowBNKCHKDetails($docno, $cdate);

        foreach ($dataList as &$record) {

            $data = array(
                "bnkcd" => $record['BANKCD'],
                "docno" => $record['DOCNO'],
                "vchrno" => $record['VCHRNO'],
                "cdate" => $record['CDATE'],
                "payto" => str_replace('¥', 'Ñ', iconv('ISO-8859-1', 'UTF-8', $record["PAYTO"])),
                "chkamt" => $record['CHKAMT'],
                "chkstat" => $record['CHKSTAT'],
                "doctype" => $record['DOCTYPE'],
                "remarks" => $record['REMARKS'],
                "prtflag" => $record['PRTFLAG']
            );

            (new ModelCheckWriter)->mdlUpdateCHCKWRTRRecords($data);
        }

        $amt = number_format(floatVal($data['chkamt']), 2, '.', ',');
        $nameFormat = $data['payto'];

        $array = explode(' ', $format_date_month);
        function convertToWords($number) {
            // Array containing words for numbers up to nineteen
            $ones = array(
                0 => '', 1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four', 5 => 'five',
                6 => 'six', 7 => 'seven', 8 => 'eight', 9 => 'nine', 10 => 'ten',
                11 => 'eleven', 12 => 'twelve', 13 => 'thirteen', 14 => 'fourteen',
                15 => 'fifteen', 16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen', 19 => 'nineteen'
            );
        
            // Array containing words for tens
            $tens = array(
                20 => 'twenty', 30 => 'thirty', 40 => 'forty', 50 => 'fifty',
                60 => 'sixty', 70 => 'seventy', 80 => 'eighty', 90 => 'ninety'
            );
        
            // Array containing words for larger denominations
            $thousands = array('', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion');
            
        
            // Splitting the number into dollars and cents
           $separetor = explode('.', $number);
          
           $num_elements = count($separetor);
           if($num_elements >1){
            list($dollars, $cents) = explode('.', $number);
            $parts = explode('.', number_format($number, 2, '.', ''));
            $centConvert = $parts[1]; // Assigning the fractional part to $centConvert
           }else{
            list($dollars) = explode('.', $number);
            $cents =0;
           }
        
            // Converting dollars part to words
            $dollars_in_words = '';
        
            if ($dollars == 0) {
                $dollars_in_words = '';
            } else {
                $dollars_in_words = convertNumberToWords($dollars, $ones, $tens, $thousands);
            }
        
            // Converting cents part to words
            $cents_in_words = '';
           
            if ($cents == 0) {
                $cents_in_words = 'ONLY';
            } else {
                $cents_in_words = '& ' . $centConvert . '/100';
            }
        
            return ucwords($dollars_in_words . ' ' . $cents_in_words);
        }
        
        function convertNumberToWords($number, $ones, $tens, $thousands) {
            $result = '';
        
            $number_length = strlen($number);
        
            // Loop through the number in groups of three digits
            $group_count = ceil($number_length / 3);
            $number_chunks = str_split(str_pad($number, $group_count * 3, '0', STR_PAD_LEFT), 3);
        
            // Process each group of three digits
            foreach ($number_chunks as $key => $chunk) {
                $chunk_number = (int)$chunk;
                if ($chunk_number != 0) {
                    $result .= convertThreeDigitNumberToWords($chunk_number, $ones, $tens, $thousands[$group_count - $key - 1]);
                    if ($key < $group_count - 1) {
                        $result .= ' ' . $thousands[$group_count - $key - 1];
                    }
                    $result .= ' ';
                }
            }
        
            return trim($result);
        }
        
        function convertThreeDigitNumberToWords($number, $ones, $tens, $thousands) {
            $result = '';
        
            // Extracting hundreds
            $hundreds = floor($number / 100);
            if ($hundreds > 0) {
                $result .= $ones[$hundreds] . ' hundred';
            }
        
            // Extracting tens and ones
            $remainder = $number % 100;
            if ($remainder > 0) {
                if ($hundreds > 0) {
                    $result .= ' ';
                }
        
                if ($remainder < 20) {
                    $result .= $ones[$remainder];
                } else {
                    $tens_digit = floor($remainder / 10) * 10;
                    $result .= $tens[$tens_digit];
                    if (isset($ones[$remainder % 10])) {
                        if($remainder % 10 == 0){
                            $result .= ' ' . $ones[$remainder % 10];
                        }else{
                            $result .= '-' . $ones[$remainder % 10];
                            
                        }
                    }
                }
            }
        
            return $result;
        }
        

        // $amountInWords = (new ControllerCheckWriter)->convertAmountToWords($data['chkamt']);
        $amountInWords =   strtoupper(convertToWords($data['chkamt']));
      
    

        if ($bank_type === 'BDO') {

            $header = "
            <table style=\"width:100%;\">
                <tr style=\"line-height: 50px;\">
                    <th style=\"width:200px; font-size:8px;\"></th>
                    <th style=\"width:321px; \"></th>
                    <td style=\"width:170px; letter-spacing: 0.5em;\">{$format_date_month[0]} {$format_date_month[1]}&nbsp;&nbsp;{$format_date_date[0]} {$format_date_date[1]}&nbsp;&nbsp;&nbsp;{$format_date_year[0]} {$format_date_year[1]} {$format_date_year[2]} {$format_date_year[3]}</td>
                </tr>
                <tr style=\"line-height: 10px;\">
                    <th style=\"width:122px; \"></th>
                    <th style=\"width:420px; \"> $nameFormat </th>
                    <td style=\"width:300px; \"> $amt </td>
                </tr>
                <tr style=\"line-height: 45px;\">
                    <th style=\"width:15px; font-size:8px;\"></th>
                    <th style=\"width:100px; \"></th>
                    <td style=\"width:500px; font-weight: bold;\"><strong> $amountInWords </strong></td>
                </tr>
        
            </table>";

        } else if ($bank_type === 'CHINA BANK') {

            $header = "
            <table style=\"width:100%;\">
                <tr style=\"line-height: 50px;\">
                    <th style=\"width:200px; font-size:8px;\"></th>
                    <th style=\"width:321px; \"></th>
                    <td style=\"width:170px; letter-spacing: 0.5em;\">{$format_date_month[0]} {$format_date_month[1]}&nbsp;&nbsp;{$format_date_date[0]} {$format_date_date[1]}&nbsp;&nbsp;&nbsp;{$format_date_year[0]} {$format_date_year[1]} {$format_date_year[2]} {$format_date_year[3]}</td>
                </tr>
                <tr style=\"line-height: 10px;\">
                    <th style=\"width:122px; \"></th>
                    <th style=\"width:420px; \"> $nameFormat </th>
                    <td style=\"width:110px; \"> $amt </td>
                </tr>
                <tr style=\"line-height: 45px;\">
                    <th style=\"width:15px; font-size:8px;\"></th>
                    <th style=\"width:100px; \"></th>
                    <td style=\"width:500px; font-weight: bold;\"><strong> $amountInWords </strong></td>
                </tr>
        
            </table>";
        } else if ($bank_type === 'LAND BANK') {

            $header = "
            <table style=\"width:100%;\">
                <tr style=\"line-height: 50px;\">
                    <th style=\"width:200px; font-size:8px;\"></th>
                    <th style=\"width:321px; \"></th>
                    <td style=\"width:170px; letter-spacing: 0.5em;\">{$format_date_month[0]} {$format_date_month[1]}&nbsp;&nbsp;{$format_date_date[0]} {$format_date_date[1]}&nbsp;&nbsp;&nbsp;{$format_date_year[0]} {$format_date_year[1]} {$format_date_year[2]} {$format_date_year[3]}</td>
                </tr>
                <tr style=\"line-height: 10px;\">
                    <th style=\"width:122px; \"></th>
                    <th style=\"width:420px; \"> $nameFormat </th>
                    <td style=\"width:110px; \"> $amt </td>
                </tr>
                <tr style=\"line-height: 45px;\">
                    <th style=\"width:15px; font-size:8px;\"></th>
                    <th style=\"width:100px; \"></th>
                    <td style=\"width:500px; font-weight: bold;\"><strong> $amountInWords </strong></td>
                </tr>
        
            </table>";

        } else if ($bank_type === 'BACOM') {

            $header = "
            <table style=\"width:100%;\">
                <tr style=\"line-height: 50px;\">
                    <th style=\"width:200px; font-size:8px;\"></th>
                    <th style=\"width:321px; \"></th>
                    <td style=\"width:170px; letter-spacing: 0.5em;\">{$format_date_month[0]} {$format_date_month[1]}&nbsp;&nbsp;{$format_date_date[0]} {$format_date_date[1]}&nbsp;&nbsp;&nbsp;{$format_date_year[0]} {$format_date_year[1]} {$format_date_year[2]} {$format_date_year[3]}</td>
                </tr>
                <tr style=\"line-height: 10px;\">
                    <th style=\"width:122px; \"></th>
                    <th style=\"width:420px; \"> $nameFormat </th>
                    <td style=\"width:110px; \"> $amt </td>
                </tr>
                <tr style=\"line-height: 45px;\">
                    <th style=\"width:15px; font-size:8px;\"></th>
                    <th style=\"width:100px; \"></th>
                    <td style=\"width:500px; font-weight: bold;\"><strong> $amountInWords </strong></td>
                </tr>
        
            </table>";

        } else if ($bank_type === 'BPI') {

            $header = "
            <table style=\"width:100%;\">
                <tr style=\"line-height: 50px;\">
                    <th style=\"width:200px; font-size:8px;\"></th>
                    <th style=\"width:321px; \"></th>
                    <td style=\"width:170px; letter-spacing: 0.5em;\">{$format_date_month[0]} {$format_date_month[1]}&nbsp;&nbsp;{$format_date_date[0]} {$format_date_date[1]}&nbsp;&nbsp;&nbsp;{$format_date_year[0]} {$format_date_year[1]} {$format_date_year[2]} {$format_date_year[3]}</td>
                </tr>
                <tr style=\"line-height: 10px;\">
                    <th style=\"width:122px; \"></th>
                    <th style=\"width:420px; \"> $nameFormat </th>
                    <td style=\"width:110px; \"> $amt </td>
                </tr>
                <tr style=\"line-height: 45px;\">
                    <th style=\"width:15px; font-size:8px;\"></th>
                    <th style=\"width:100px; \"></th>
                    <td style=\"width:500px; font-weight: bold;\"><strong> $amountInWords </strong></td>
                </tr>
        
            </table>";

        } else if ($bank_type === 'METRO BANK') {

            $header = "
            <table style=\"width:100%;\">
                <tr style=\"line-height: 50px;\">
                    <th style=\"width:200px; font-size:8px;\"></th>
                    <th style=\"width:321px; \"></th>
                    <td style=\"width:170px; letter-spacing: 0.5em;\">{$format_date_month[0]} {$format_date_month[1]}&nbsp;&nbsp;{$format_date_date[0]} {$format_date_date[1]}&nbsp;&nbsp;&nbsp;{$format_date_year[0]} {$format_date_year[1]} {$format_date_year[2]} {$format_date_year[3]}</td>
                </tr>
                <tr style=\"line-height: 10px;\">
                    <th style=\"width:122px; \"></th>
                    <th style=\"width:420px; \"> $nameFormat </th>
                    <td style=\"width:110px; \"> $amt </td>
                </tr>
                <tr style=\"line-height: 45px;\">
                    <th style=\"width:15px; font-size:8px;\"></th>
                    <th style=\"width:100px; \"></th>
                    <td style=\"width:500px; font-weight: bold;\"><strong> $amountInWords </strong></td>
                </tr>
        
            </table>";

        } else if ($bank_type === 'PNB') {

            $header = "
            <table style=\"width:100%;\">
                <tr style=\"line-height: 50px;\">
                    <th style=\"width:200px; font-size:8px;\"></th>
                    <th style=\"width:321px; \"></th>
                    <td style=\"width:170px; letter-spacing: 0.5em;\">{$format_date_month[0]} {$format_date_month[1]}&nbsp;&nbsp;{$format_date_date[0]} {$format_date_date[1]}&nbsp;&nbsp;&nbsp;{$format_date_year[0]} {$format_date_year[1]} {$format_date_year[2]} {$format_date_year[3]}</td>
                </tr>
                <tr style=\"line-height: 10px;\">
                    <th style=\"width:122px; \"></th>
                    <th style=\"width:420px; \"> $nameFormat </th>
                    <td style=\"width:300px; \"> $amt </td>
                </tr>
                <tr style=\"line-height: 45px;\">
                    <th style=\"width:15px; font-size:8px;\"></th>
                    <th style=\"width:100px; \"></th>
                    <td style=\"width:500px; font-weight: bold;\"><strong> $amountInWords </strong></td>
                </tr>
        
            </table>";

        } else if ($bank_type === 'RCBC') {

            $header = "
            <table style=\"width:100%;\">
                <tr style=\"line-height: 50px;\">
                    <th style=\"width:200px; font-size:8px;\"></th>
                    <th style=\"width:321px; \"></th>
                    <td style=\"width:170px; letter-spacing: 0.5em;\">{$format_date_month[0]} {$format_date_month[1]}&nbsp;&nbsp;{$format_date_date[0]} {$format_date_date[1]}&nbsp;&nbsp;&nbsp;{$format_date_year[0]} {$format_date_year[1]} {$format_date_year[2]} {$format_date_year[3]}</td>
                </tr>
                <tr style=\"line-height: 10px;\">
                    <th style=\"width:122px; \"></th>
                    <th style=\"width:420px; \"> $nameFormat </th>
                    <td style=\"width:110px; \"> $amt </td>
                </tr>
                <tr style=\"line-height: 45px;\">
                    <th style=\"width:15px; font-size:8px;\"></th>
                    <th style=\"width:100px; \"></th>
                    <td style=\"width:500px; font-weight: bold;\"><strong> $amountInWords </strong></td>
                </tr>
        
            </table>";

        } else if ($bank_type === 'UNION BANK') {

            $header = "
            <table style=\"width:100%;\">
                <tr style=\"line-height: 50px;\">
                    <th style=\"width:200px; font-size:8px;\"></th>
                    <th style=\"width:321px; \"></th>
                    <td style=\"width:170px; letter-spacing: 0.5em;\">{$format_date_month[0]} {$format_date_month[1]}&nbsp;&nbsp;{$format_date_date[0]} {$format_date_date[1]}&nbsp;&nbsp;&nbsp;{$format_date_year[0]} {$format_date_year[1]} {$format_date_year[2]} {$format_date_year[3]}</td>
                </tr>
                <tr style=\"line-height: 10px;\">
                    <th style=\"width:122px; \"></th>
                    <th style=\"width:420px; \"> $nameFormat </th>
                    <td style=\"width:110px; \"> $amt </td>
                </tr>
                <tr style=\"line-height: 45px;\">
                    <th style=\"width:15px; font-size:8px;\"></th>
                    <th style=\"width:100px; \"></th>
                    <td style=\"width:500px; font-weight: bold;\"><strong> $amountInWords </strong></td>
                </tr>
        
            </table>";

        } else if ($bank_type === 'QUEEN BANK') {

            $header = "
            <table style=\"width:100%;\">
                <tr style=\"line-height: 50px;\">
                    <th style=\"width:200px; font-size:8px;\"></th>
                    <th style=\"width:321px; \"></th>
                    <td style=\"width:170px; letter-spacing: 0.5em;\">{$format_date_month[0]} {$format_date_month[1]}&nbsp;&nbsp;{$format_date_date[0]} {$format_date_date[1]}&nbsp;&nbsp;&nbsp;{$format_date_year[0]} {$format_date_year[1]} {$format_date_year[2]} {$format_date_year[3]}</td>
                </tr>
                <tr style=\"line-height: 10px;\">
                    <th style=\"width:122px; \"></th>
                    <th style=\"width:420px; \"> $nameFormat </th>
                    <td style=\"width:110px; \"> $amt </td>
                </tr>
                <tr style=\"line-height: 45px;\">
                    <th style=\"width:15px; font-size:8px;\"></th>
                    <th style=\"width:100px; \"></th>
                    <td style=\"width:500px; font-weight: bold;\"><strong> $amountInWords </strong></td>
                </tr>
        
            </table>";

        } else if ($bank_type === 'RURAL BANK') {

            $header = "
            <table style=\"width:100%;\">
                <tr style=\"line-height: 50px;\">
                    <th style=\"width:200px; font-size:8px;\"></th>
                    <th style=\"width:321px; \"></th>
                    <td style=\"width:170px; letter-spacing: 0.5em;\">{$format_date_month[0]} {$format_date_month[1]}&nbsp;&nbsp;{$format_date_date[0]} {$format_date_date[1]}&nbsp;&nbsp;&nbsp;{$format_date_year[0]} {$format_date_year[1]} {$format_date_year[2]} {$format_date_year[3]}</td>
                </tr>
                <tr style=\"line-height: 10px;\">
                    <th style=\"width:122px; \"></th>
                    <th style=\"width:420px; \"> $nameFormat </th>
                    <td style=\"width:110px; \"> $amt </td>
                </tr>
                <tr style=\"line-height: 45px;\">
                    <th style=\"width:15px; font-size:8px;\"></th>
                    <th style=\"width:100px; \"></th>
                    <td style=\"width:500px; font-weight: bold;\"><strong> $amountInWords </strong></td>
                </tr>
        
            </table>";

        } else if ($bank_type === 'FCB') {

            $header = "
            <table style=\"width:100%;\">
                <tr style=\"line-height: 50px;\">
                    <th style=\"width:200px; font-size:8px;\"></th>
                    <th style=\"width:321px; \"></th>
                    <td style=\"width:170px; letter-spacing: 0.5em;\">{$format_date_month[0]} {$format_date_month[1]}&nbsp;&nbsp;{$format_date_date[0]} {$format_date_date[1]}&nbsp;&nbsp;&nbsp;{$format_date_year[0]} {$format_date_year[1]} {$format_date_year[2]} {$format_date_year[3]}</td>
                </tr>
                <tr style=\"line-height: 10px;\">
                    <th style=\"width:122px; \"></th>
                    <th style=\"width:420px; \"> $nameFormat </th>
                    <td style=\"width:110px; \"> $amt </td>
                </tr>
                <tr style=\"line-height: 45px;\">
                    <th style=\"width:15px; font-size:8px;\"></th>
                    <th style=\"width:100px; \"></th>
                    <td style=\"width:500px; font-weight: bold;\"><strong> $amountInWords </strong></td>
                </tr>
        
            </table>";

        } else if ($bank_type === 'UCPB') {

            $header = "
            <table style=\"width:100%;\">
                <tr style=\"line-height: 50px;\">
                    <th style=\"width:200px; font-size:8px;\"></th>
                    <th style=\"width:321px; \"></th>
                    <td style=\"width:170px; letter-spacing: 0.5em;\">{$format_date_month[0]} {$format_date_month[1]}&nbsp;&nbsp;{$format_date_date[0]} {$format_date_date[1]}&nbsp;&nbsp;&nbsp;{$format_date_year[0]} {$format_date_year[1]} {$format_date_year[2]} {$format_date_year[3]}</td>
                </tr>
                <tr style=\"line-height: 10px;\">
                    <th style=\"width:122px; \"></th>
                    <th style=\"width:420px; \"> $nameFormat </th>
                    <td style=\"width:110px; \"> $amt </td>
                </tr>
                <tr style=\"line-height: 45px;\">
                    <th style=\"width:15px; font-size:8px;\"></th>
                    <th style=\"width:100px; \"></th>
                    <td style=\"width:500px; font-weight: bold;\"><strong> $amountInWords </strong></td>
                </tr>
        
            </table>";

        } else if ($bank_type === 'ONE NETWORK BANK') {

            $header = "
            <table style=\"width:100%;\">
                <tr style=\"line-height: 50px;\">
                    <th style=\"width:200px; font-size:8px;\"></th>
                    <th style=\"width:321px; \"></th>
                    <td style=\"width:170px; letter-spacing: 0.5em;\">{$format_date_month[0]} {$format_date_month[1]}&nbsp;&nbsp;{$format_date_date[0]} {$format_date_date[1]}&nbsp;&nbsp;&nbsp;{$format_date_year[0]} {$format_date_year[1]} {$format_date_year[2]} {$format_date_year[3]}</td>
                </tr>
                <tr style=\"line-height: 10px;\">
                    <th style=\"width:122px; \"></th>
                    <th style=\"width:420px; \"> $nameFormat </th>
                    <td style=\"width:110px; \"> $amt </td>
                </tr>
                <tr style=\"line-height: 45px;\">
                    <th style=\"width:15px; font-size:8px;\"></th>
                    <th style=\"width:100px; \"></th>
                    <td style=\"width:500px; font-weight: bold;\"><strong> $amountInWords </strong></td>
                </tr>
        
            </table>";

        } else if ($bank_type === 'PB COMMUNICATION') {

            $header = "
            <table style=\"width:100%;\">
                <tr style=\"line-height: 50px;\">
                    <th style=\"width:200px; font-size:8px;\"></th>
                    <th style=\"width:321px; \"></th>
                    <td style=\"width:170px; letter-spacing: 0.5em;\">{$format_date_month[0]} {$format_date_month[1]}&nbsp;&nbsp;{$format_date_date[0]} {$format_date_date[1]}&nbsp;&nbsp;&nbsp;{$format_date_year[0]} {$format_date_year[1]} {$format_date_year[2]} {$format_date_year[3]}</td>
                </tr>
                <tr style=\"line-height: 10px;\">
                    <th style=\"width:122px; \"></th>
                    <th style=\"width:420px; \"> $nameFormat </th>
                    <td style=\"width:110px; \"> $amt </td>
                </tr>
                <tr style=\"line-height: 45px;\">
                    <th style=\"width:15px; font-size:8px;\"></th>
                    <th style=\"width:100px; \"></th>
                    <td style=\"width:500px; font-weight: bold;\"><strong> $amountInWords </strong></td>
                </tr>
        
            </table>";

        } else if ($bank_type === 'AUB') {

            $header = "
            <table style=\"width:100%;\">
                <tr style=\"line-height: 50px;\">
                    <th style=\"width:200px; font-size:8px;\"></th>
                    <th style=\"width:321px; \"></th>
                    <td style=\"width:170px; letter-spacing: 0.5em;\">{$format_date_month[0]} {$format_date_month[1]}&nbsp;&nbsp;{$format_date_date[0]} {$format_date_date[1]}&nbsp;&nbsp;&nbsp;{$format_date_year[0]} {$format_date_year[1]} {$format_date_year[2]} {$format_date_year[3]}</td>
                </tr>
                <tr style=\"line-height: 10px;\">
                    <th style=\"width:122px; \"></th>
                    <th style=\"width:420px; \"> $nameFormat </th>
                    <td style=\"width:110px; \"> $amt </td>
                </tr>
                <tr style=\"line-height: 45px;\">
                    <th style=\"width:15px; font-size:8px;\"></th>
                    <th style=\"width:100px; \"></th>
                    <td style=\"width:500px; font-weight: bold;\"><strong> $amountInWords </strong></td>
                </tr>
        
            </table>";

        } else if ($bank_type === 'EAST WEST') {

            $header = "
            <table style=\"width:100%;\">
                <tr style=\"line-height: 50px;\">
                    <th style=\"width:200px; font-size:8px;\"></th>
                    <th style=\"width:321px; \"></th>
                    <td style=\"width:170px; letter-spacing: 0.5em;\">{$format_date_month[0]} {$format_date_month[1]}&nbsp;&nbsp;{$format_date_date[0]} {$format_date_date[1]}&nbsp;&nbsp;&nbsp;{$format_date_year[0]} {$format_date_year[1]} {$format_date_year[2]} {$format_date_year[3]}</td>
                </tr>
                <tr style=\"line-height: 10px;\">
                    <th style=\"width:122px; \"></th>
                    <th style=\"width:420px; \"> $nameFormat </th>
                    <td style=\"width:110px; \"> $amt </td>
                </tr>
                <tr style=\"line-height: 45px;\">
                    <th style=\"width:15px; font-size:8px;\"></th>
                    <th style=\"width:100px; \"></th>
                    <td style=\"width:500px; font-weight: bold;\"><strong> $amountInWords </strong></td>
                </tr>
        
            </table>";

        } else if ($bank_type === 'ASIA UNITED BANK') {

            $header = "
            <table style=\"width:100%;\">
                <tr style=\"line-height: 50px;\">
                    <th style=\"width:200px; font-size:8px;\"></th>
                    <th style=\"width:321px; \"></th>
                    <td style=\"width:170px; letter-spacing: 0.5em;\">{$format_date_month[0]} {$format_date_month[1]}&nbsp;&nbsp;{$format_date_date[0]} {$format_date_date[1]}&nbsp;&nbsp;&nbsp;{$format_date_year[0]} {$format_date_year[1]} {$format_date_year[2]} {$format_date_year[3]}</td>
                </tr>
                <tr style=\"line-height: 10px;\">
                    <th style=\"width:122px; \"></th>
                    <th style=\"width:420px; \"> $nameFormat </th>
                    <td style=\"width:110px; \"> $amt </td>
                </tr>
                <tr style=\"line-height: 45px;\">
                    <th style=\"width:15px; font-size:8px;\"></th>
                    <th style=\"width:100px; \"></th>
                    <td style=\"width:500px; font-weight: bold;\"><strong> $amountInWords </strong></td>
                </tr>
        
            </table>";

            
        } else if ($bank_type === 'DBP') {

            $header = "
            <table style=\"width:100%;\">
                <tr style=\"line-height: 50px;\">
                    <th style=\"width:200px; font-size:8px;\"></th>
                    <th style=\"width:321px; \"></th>
                    <td style=\"width:170px; letter-spacing: 0.5em;\">{$format_date_month[0]} {$format_date_month[1]}&nbsp;&nbsp;{$format_date_date[0]} {$format_date_date[1]}&nbsp;&nbsp;&nbsp;{$format_date_year[0]} {$format_date_year[1]} {$format_date_year[2]} {$format_date_year[3]}</td>
                </tr>
                <tr style=\"line-height: 10px;\">
                    <th style=\"width:122px; \"></th>
                    <th style=\"width:420px; \"> $nameFormat </th>
                    <td style=\"width:110px; \"> $amt </td>
                </tr>
                <tr style=\"line-height: 45px;\">
                    <th style=\"width:15px; font-size:8px;\"></th>
                    <th style=\"width:100px; \"></th>
                    <td style=\"width:500px; font-weight: bold;\"><strong> $amountInWords </strong></td>
                </tr>
        
            </table>";


        } else {

            $header = "
            <table style=\"width:100%;\">
                <tr style=\"line-height: 50px;\">
                    <th style=\"width:200px; font-size:8px;\"></th>
                    <th style=\"width:321px; \"></th>
                    <td style=\"width:170px; letter-spacing: 0.5em;\">{$format_date_month[0]} {$format_date_month[1]}&nbsp;&nbsp;{$format_date_date[0]} {$format_date_date[1]}&nbsp;&nbsp;&nbsp;{$format_date_year[0]} {$format_date_year[1]} {$format_date_year[2]} {$format_date_year[3]}</td>
                </tr>
                <tr style=\"line-height: 10px;\">
                    <th style=\"width:122px; \"></th>
                    <th style=\"width:420px; \"> $nameFormat </th>
                    <td style=\"width:110px; \"> $amt </td>
                </tr>
                <tr style=\"line-height: 45px;\">
                    <th style=\"width:15px; font-size:8px;\"></th>
                    <th style=\"width:100px; \"></th>
                    <td style=\"width:500px; font-weight: bold;\"><strong> $amountInWords </strong></td>
                </tr>
        
            </table>";

        }

        $pdf->writeHTML($header, false, false, false, false, '');

        $pdf->AddPage();

        $pdf->SetAutoPageBreak(false);
        $pdf->SetMargins(0, 0, 0);

        // 0.75 inch left margin
        $x = 75.05;
        $y = 12;

        $formWidth  = 57.15;
        $formHeight = 63.50;

        $right = $x + $formWidth;

        // Optional guide box
        // $pdf->Rect($x, $y, $formWidth, $formHeight);

        $pdf->SetFont('arialnarrow_b', '', 8);

        $row = 4.5;

        // Full Name
        $pdf->Text($x, $y, 'Full Name:');
        $pdf->Line($x + 14, $y + 3.3, $right, $y + 3.3);
        $y += $row;

        // Address line 1
        $pdf->Text($x, $y, 'Address:');
        $pdf->Line($x + 11, $y + 3.3, $right, $y + 3.3);
        $y += $row;

        // Address line 2
        $pdf->Line($x, $y + 3.3, $right, $y + 3.3);
        $y += $row;

        // Contact / Sex
        $pdf->Text($x, $y, 'Contact No.:');
        $pdf->Line($x + 16, $y + 3.3, $x + 32, $y + 3.3);

        $pdf->Text($x + 32, $y, 'Sex:');
        $pdf->Line($x + 39, $y + 3.3, $right, $y + 3.3);
        $y += $row;

        // Type of ID / ID No.
        $pdf->Text($x, $y, 'Type of ID:');
        $pdf->Line($x + 14, $y + 3.3, $x + 32, $y + 3.3);

        $pdf->Text($x + 32, $y, 'ID No.:');
        $pdf->Line($x + 43, $y + 3.3, $right, $y + 3.3);
        $y += $row;

        // Birth Date / Birth Place
        $pdf->Text($x, $y, 'Birth Date:');
        $pdf->Line($x + 14, $y + 3.3, $x + 32, $y + 3.3);

        $pdf->Text($x + 32, $y, 'Birth Place:');
        $pdf->Line($x + 47, $y + 3.3, $right, $y + 3.3);
        $y += $row;

        // Nationality / Citizenship
        $pdf->Text($x, $y, 'Nationality:');
        $pdf->Line($x + 14, $y + 3.3, $x + 32, $y + 3.3);

        $pdf->Text($x + 32, $y, 'Citizenship:');
        $pdf->Line($x + 47, $y + 3.3, $right, $y + 3.3);
        $y += $row;

        // Purpose
        $pdf->Text($x, $y, 'Purpose of Transaction:');
        $pdf->Line($x + 29, $y + 3.3, $right, $y + 3.3);
        $y += 7;


        // ==========================================================
        // PRIVACY CLAUSE
        // ==========================================================

        $pdf->SetFont('arialnarrow', '', 7);

        // Checkbox
        $pdf->Rect($x + 13, $y + 1, 2, 2);

        // Position text beside checkbox
        $pdf->SetXY($x + 15, $y);

        $privacy = "I/We consent to the collection and processing of personal data provided herein that will be used for facilitating the check encashment transaction. All personal data will be processed in accordance with the Bank's Data Privacy Policy provided in the Bank's website (www.pnb.com.ph) and applicable data privacy laws, rules and regulations as may be amended from time to time.";

        $pdf->MultiCell(
            43,      // adjust width until it matches your form
            2.8,     // line height
            $privacy,
            0,
            'J',     // <-- Justified
            false
        );

        $y = $pdf->GetY() + 3;

        // ==========================================================
        // SIGNATURE
        // ==========================================================

        // Small gap after privacy clause
        $y += 3;

        // "Received by:" (regular, not bold)
        $pdf->SetFont('arialnarrow_b', '', 8);
        $pdf->Text($x + 15, $y, 'Received by:');

        // Move down to signature line
        $y += 8;

        $lineStart = $x + 16;
        $lineEnd   = $x + 55;

        $pdf->Line(
            $lineStart,
            $y,
            $lineEnd,
            $y
        );

        // Caption
        $pdf->SetFont('arialnarrow_b', '', 8);
        $pdf->SetXY($lineStart, $y + 1);

        $pdf->Cell(
            $lineEnd - $lineStart,
            4,
            "Payee's Signature",
            0,
            0,
            'C'
        );

        $pdf->writeHTML( false, false, false, false, '');
            
        // ------------------------------------------------------------

        $pdf->Output('OR.pdf', 'I');
    }
}

?>
