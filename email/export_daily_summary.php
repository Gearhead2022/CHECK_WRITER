<?php
// Your PHP code here
require '../vendor/autoload.php';
require_once "../controllers/insurance.controller.php";
require_once "../models/insurance.model.php";
require_once "../views/modules/session.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$date = $_GET['date'];
$branch = $_GET['branch'];
$branch_name = $_SESSION['branch_name'];
$type = $_SESSION['type'];

if($type == "admin"){
    $exName = $branch;
}else{
    $exName = $branch_name;
}
$spreadsheet = new Spreadsheet();
$activeWorksheet = $spreadsheet->getActiveSheet();

$spreadsheet->getDefaultStyle()
    ->getFont()
    ->setName('Calibri')
    ->setSize(11);

    // Heading 
$activeWorksheet->setCellValue('A5', 'Item Number');
$activeWorksheet->setCellValue('B5', 'ID #');
$activeWorksheet->setCellValue('C5', 'Last Name');
$activeWorksheet->setCellValue('D5', 'First Name');
$activeWorksheet->setCellValue('E5', 'Middle Name');
$activeWorksheet->setCellValue('F5', 'Birthdate');
$activeWorksheet->setCellValue('G5', 'Age');
$activeWorksheet->setCellValue('H5', 'Occupation');
$activeWorksheet->setCellValue('I5', 'Civil Status');
$activeWorksheet->setCellValue('J5', 'Gender');
$activeWorksheet->setCellValue('K5', 'Terms of Loan (in Months)');
$activeWorksheet->setCellValue('L5', 'Loan Release Date');
$activeWorksheet->setCellValue('M5', 'Amount of Loan');
$activeWorksheet->setCellValue('N5', 'Expiry Date');
$activeWorksheet->setCellValue('O5', '65 & Below');
$activeWorksheet->setCellValue('P5', '66 - 70');
$activeWorksheet->setCellValue('Q5', '71 - 75');
$activeWorksheet->setCellValue('R5', 'Insurance Premium');
$activeWorksheet->setCellValue('S5', 'BRANCH');

$spreadsheet->getActiveSheet()->getStyle('A5:S5')->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->getStyle('A5:S5')->getFont()->setSize(11);
// Set horizontal alignment to center for range 'A5:R5'
$spreadsheet->getActiveSheet()->getStyle('A5:S5')->getAlignment()
    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
    ->setVertical(Alignment::VERTICAL_CENTER);
$spreadsheet->getActiveSheet()->getStyle('A:S')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

// Setting Column Width 
$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(11);
$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(14);
$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);
$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(25);
$spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(13);
$spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(14);
$spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(13);
$spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(13);
$spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(14);
$spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(14);
$spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(15);
$spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(20);
$spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(15);
$spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(14);
$spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth(15);
$spreadsheet->getActiveSheet()->getColumnDimension('P')->setWidth(15);
$spreadsheet->getActiveSheet()->getColumnDimension('Q')->setWidth(15);
$spreadsheet->getActiveSheet()->getColumnDimension('R')->setWidth(15);
$spreadsheet->getActiveSheet()->getColumnDimension('S')->setWidth(25);

$spreadsheet->getActiveSheet()->getStyle('A5')->getAlignment()->setWrapText(true);
$spreadsheet->getActiveSheet()->getStyle('J')->getAlignment()->setWrapText(true);
$spreadsheet->getActiveSheet()->getStyle('K')->getAlignment()->setWrapText(true);
$spreadsheet->getActiveSheet()->getStyle('M')->getAlignment()->setWrapText(true);
$spreadsheet->getActiveSheet()->getStyle('R')->getAlignment()->setWrapText(true);

$spreadsheet->getActiveSheet()->setCellValue('A1', 'Daily Summary of Insurance Availment (MAPFRE)');
$spreadsheet->getActiveSheet()->setCellValue('A2', 'Branch: '.$exName.'');
$spreadsheet->getActiveSheet()->setCellValue('L4', 'ENCODE LOT DATE');

$spreadsheet->getActiveSheet()->getStyle('A1:A3')->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->getStyle('B3')->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->setCellValue('O3', "FILL UP THE  RATES (REFER TO INSURANCE TABLE) ACCDG TO SSP's ACTUAL AGE ");



$spreadsheet->getActiveSheet()->mergeCells("A1:C1");
$spreadsheet->getActiveSheet()->mergeCells("A2:C2");
$spreadsheet->getActiveSheet()->mergeCells("O3:Q4");

$spreadsheet->getActiveSheet()->getStyle('A1:C1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
$spreadsheet->getActiveSheet()->getStyle('A2:C2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
$spreadsheet->getActiveSheet()->getStyle('A3:B3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
$spreadsheet->getActiveSheet()->getStyle("O3:Q4")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$spreadsheet->getActiveSheet()->getStyle('O3')->getAlignment()->setWrapText(true);
$spreadsheet->getActiveSheet()->getStyle('O3')->getFont()->setBold(true);
$borderStyle = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
];

$fillStyle = [
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => [
            'rgb' => '9BC2E6', // Blue color
        ],
    ],
];

for ($row = 5; $row <= 5; $row++) {
    $spreadsheet->getActiveSheet()->getStyle("A$row:S$row")->applyFromArray($borderStyle);
    $spreadsheet->getActiveSheet()->getStyle("A$row:S$row")->applyFromArray($fillStyle);
}

$style = [
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => [
            'rgb' => 'FFFF00', // Yellow color
        ],
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
];

$spreadsheet->getActiveSheet()->getStyle('L4')->applyFromArray($style);
$spreadsheet->getActiveSheet()->getStyle('O5:Q5')->applyFromArray($style);
$spreadsheet->getActiveSheet()->getStyle('O3:Q4')->applyFromArray($style);

$style1 = [
    'font' => [
        'color' => ['rgb' => 'FF0000'], // RGB color code for red
    ],
];

// Apply the style to the range 'O3:Q4'
$spreadsheet->getActiveSheet()->getStyle('O3:Q4')->applyFromArray($style1);




// Content 
if($branch == "ALL" || $branch == ""){
    $ins = (new ControllerInsurance)->ctrShowFilterInsurance($date);
}else{
    $ins = (new ControllerInsurance)->ctrShowFilterInsuranceByBranch($date, $branch);
}




if(!empty($ins)){
$row = 6;
$id = 1;
foreach($ins as $insurance){
    $name = $insurance['name'];
    $ins_rate = $insurance['ins_rate'];
   $avail_date =  $insurance['avail_date'];
   $age =  $insurance['age'];
    // Split the full name by the comma
    $name_parts = explode(',', $name);

    // Extract the last name
    $last_name = $name_parts[0];
    $full_name = $name_parts[1];

    $lastLetter = substr($full_name, -1);
    if($lastLetter == "."){
        $middle_name = substr($full_name, -2, 2);
        $first_name = substr($full_name, 0, -2);
    }else{
        $middle_name = "";
        $first_name = $full_name;
    }

    if($age<=65){
        $below65 = $ins_rate;
    }else{
        $below65 = "";
    }

    if($age>65 && $age <=70){
        $between66_70 = $ins_rate;
    }else{
        $between66_70 = "";
    }

    if($age>70 && $age <=75){
        $between71_75 = $ins_rate;
    }else{
        $between71_75 = "";
    }
   


    $spreadsheet->getActiveSheet()
    ->setCellValue('A'.$row, $id)
    ->setCellValue('B'.$row, $insurance['account_id'])
    ->setCellValue('C'.$row, $last_name)
    ->setCellValue('D'.$row, $first_name)
    ->setCellValue('E'.$row, $middle_name)
    ->setCellValue('F'.$row, $insurance['birth_date'])
    ->setCellValue('G'.$row, $insurance['age'])
    ->setCellValue('H'.$row, $insurance['occupation'])
    ->setCellValue('I'.$row, $insurance['civil_status'])
    ->setCellValue('J'.$row, $insurance['gender'])
    ->setCellValue('K'.$row, $insurance['terms'])
    ->setCellValue('L'.$row, $insurance['avail_date'])
    ->setCellValue('M'.$row,  $insurance['amount_loan'])
    ->setCellValue('N'.$row, $insurance['expire_date'])
    ->setCellValue('O'.$row, $below65)
    ->setCellValue('P'.$row, $between66_70)
    ->setCellValue('Q'.$row, $between71_75)
    ->setCellValue('R'.$row, $insurance['amount'])
    ->setCellValue('S'.$row, $insurance['branch_name']);
    $spreadsheet->getActiveSheet()->getStyle("A$row:S$row")->applyFromArray($borderStyle);
    $row ++;
    $id ++;
  
}
$spreadsheet->getActiveSheet()->setCellValue('A3', 'DATE:');
$spreadsheet->getActiveSheet()->setCellValue('B3', $avail_date);
}

$fileName = "INSURANCE SUMMARY " . $date;

// Set the HTTP headers to make the file downloadable
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$fileName.'.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);

// Output the file directly to the browser
$writer->save('php://output');
