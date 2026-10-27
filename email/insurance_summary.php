<?php
// Your PHP code here
require '../vendor/autoload.php';
require_once "../controllers/insurance.controller.php";
require_once "../models/insurance.model.php";
require_once "../views/modules/session.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$insurance = new ControllerInsurance();
$date = $_GET['date'];

$spreadsheet = new Spreadsheet();
$activeWorksheet = $spreadsheet->getActiveSheet();

$spreadsheet->getDefaultStyle()
    ->getFont()
    ->setName('Calibri')
    ->setSize(16);

    // Heading  Width
$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(25);
$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(15);

// HEADING SET VALUES 
$spreadsheet->getActiveSheet()->setCellValue('A1', 'DAILY CHECKLIST FOR INSURANCE (MAPFRE)');
$spreadsheet->getActiveSheet()->setCellValue('A4', 'EMB BRANCH');
$spreadsheet->getActiveSheet()->setCellValue('B4', $date);
$spreadsheet->getActiveSheet()->setCellValue('B5', 'COUNT');


$spreadsheet->getActiveSheet()->mergeCells("A1:C2");
$spreadsheet->getActiveSheet()->mergeCells("A4:A5");

$spreadsheet->getActiveSheet()->getStyle('A1:O1')->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
$spreadsheet->getActiveSheet()->getStyle('A4')->getFont()->setSize(16);
$spreadsheet->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$spreadsheet->getActiveSheet()->getStyle('B')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$spreadsheet->getActiveSheet()->getStyle('A4:B4')->getAlignment()
    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
    ->setVertical(Alignment::VERTICAL_CENTER);
    $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()
    ->setHorizontal(Alignment::HORIZONTAL_LEFT)
    ->setVertical(Alignment::VERTICAL_CENTER);

$style = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
];

$borderStyle = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
];

$style1 = [
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => [
            'rgb' => 'D0CECE', // Yellow color
        ],
    ],
];


$spreadsheet->getActiveSheet()->getStyle('A4:A5')->applyFromArray($style);
$spreadsheet->getActiveSheet()->getStyle('B4:B5')->applyFromArray($style);
$spreadsheet->getActiveSheet()->getStyle('B5')->applyFromArray($style1);






// Content 

$row = 6;
$getEMB = $insurance->ctrGetAllEMBBranches();
foreach ($getEMB as $emb) { 
    $branch_name = $emb['full_name'];
    $count = $insurance->ctrCountInsurance($branch_name, $date);
    foreach($count as $cnt){
        $ins_total = $cnt['ins_total'];
    }


    $spreadsheet->getActiveSheet()
    ->setCellValue('A'.$row, $branch_name)
    ->setCellValue('B'.$row, $ins_total);
    $spreadsheet->getActiveSheet()->getStyle("A$row:B$row")->applyFromArray($borderStyle);
    $row ++;
}

$row =33;
$getFCH = $insurance->ctrGetAllFCHBranches();
foreach ($getFCH as $fch) { 
    $branch_name = $fch['full_name'];
    $count = $insurance->ctrCountInsurance($branch_name, $date);
    foreach($count as $cnt){
        $ins_total = $cnt['ins_total'];
    }


    $spreadsheet->getActiveSheet()
    ->setCellValue('A'.$row, $branch_name)
    ->setCellValue('B'.$row, $ins_total);
    $spreadsheet->getActiveSheet()->getStyle("A$row:B$row")->applyFromArray($borderStyle);
    $row ++;
}

$row =42;
$getRLC = $insurance->ctrGetAllRLCBranches();
foreach ($getRLC as $rlc) { 
    $branch_name = $rlc['full_name'];
    $count = $insurance->ctrCountInsurance($branch_name, $date);
    foreach($count as $cnt){
        $ins_total = $cnt['ins_total'];
    }


    $spreadsheet->getActiveSheet()
    ->setCellValue('A'.$row, $branch_name)
    ->setCellValue('B'.$row, $ins_total);
    $spreadsheet->getActiveSheet()->getStyle("A$row:B$row")->applyFromArray($borderStyle);
    $row ++;
}

$row =47;
$getELC = $insurance->ctrGetAllELCBranches();
foreach ($getELC as $elc) { 
    $branch_name = $elc['full_name'];
    $count = $insurance->ctrCountInsurance($branch_name, $date);
    foreach($count as $cnt){
        $ins_total = $cnt['ins_total'];
    }


    $spreadsheet->getActiveSheet()
    ->setCellValue('A'.$row, $branch_name)
    ->setCellValue('B'.$row, $ins_total);
    $spreadsheet->getActiveSheet()->getStyle("A$row:B$row")->applyFromArray($borderStyle);
    $row ++;
}





// Set the HTTP headers to make the file downloadable
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Insurance Daily Checklist for '.$date.'.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);

// Output the file directly to the browser
$writer->save('php://output');
