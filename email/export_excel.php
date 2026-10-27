<?php
// Your PHP code here
require '../vendor/autoload.php';
require_once "../controllers/insurance.controller.php";
require_once "../models/insurance.model.php";
require_once "../views/modules/session.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$activeWorksheet = $spreadsheet->getActiveSheet();

$spreadsheet->getDefaultStyle()
    ->getFont()
    ->setName('Arial')
    ->setSize(10);

    // Heading 
$activeWorksheet->setCellValue('A1', 'Item Number');
$activeWorksheet->setCellValue('B1', 'Last Name');
$activeWorksheet->setCellValue('C1', 'First Name');
$activeWorksheet->setCellValue('D1', 'Middle Name');
$activeWorksheet->setCellValue('E1', 'Birthdate');
$activeWorksheet->setCellValue('F1', 'Age');
$activeWorksheet->setCellValue('G1', 'Occupation');
$activeWorksheet->setCellValue('H1', 'Civil Status');
$activeWorksheet->setCellValue('I1', 'Gender');
$activeWorksheet->setCellValue('J1', 'Terms of Loan (in Months)');
$activeWorksheet->setCellValue('K1', 'Actual Date of Receipt');
$activeWorksheet->setCellValue('L1', 'Loan Release Date');
$activeWorksheet->setCellValue('M1', 'PERIL');
$activeWorksheet->setCellValue('N1', 'Amount of Loan');
$activeWorksheet->setCellValue('O1', 'Gross Premium');

$spreadsheet->getActiveSheet()->getStyle('A1:O1')->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->getStyle('A1:O1')->getFont()->setSize(10);
$spreadsheet->getActiveSheet()->getStyle('A1:O1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$spreadsheet->getActiveSheet()->getStyle('A:O')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

// Setting Column Width 
$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(11);
$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(14);
$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);
$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(14);
$spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(13);
$spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(6);
$spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(13);
$spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(13);
$spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(9);
$spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(14);
$spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(13);
$spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(14);
$spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(9);
$spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(14);
$spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth(15);

$spreadsheet->getActiveSheet()->getStyle('A')->getAlignment()->setWrapText(true);
$spreadsheet->getActiveSheet()->getStyle('J')->getAlignment()->setWrapText(true);
$spreadsheet->getActiveSheet()->getStyle('K')->getAlignment()->setWrapText(true);
$spreadsheet->getActiveSheet()->getStyle('L')->getAlignment()->setWrapText(true);
$spreadsheet->getActiveSheet()->getStyle('N')->getAlignment()->setWrapText(true);

// Content 
$ins = (new ControllerInsurance)->ctrShowInsurance();

$row = 2;
$id = 1;
foreach($ins as $insurance){
    $name = $insurance['name'];
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


    $spreadsheet->getActiveSheet()
    ->setCellValue('A'.$row, $id)
    ->setCellValue('B'.$row, $last_name)
    ->setCellValue('C'.$row, $first_name)
    ->setCellValue('D'.$row, $middle_name)
    ->setCellValue('E'.$row, $insurance['birth_date'])
    ->setCellValue('F'.$row, $insurance['age'])
    ->setCellValue('G'.$row, $insurance['occupation'])
    ->setCellValue('H'.$row, $insurance['civil_status'])
    ->setCellValue('I'.$row, $insurance['gender'])
    ->setCellValue('J'.$row, $insurance['terms'])
    ->setCellValue('K'.$row, $insurance['avail_date'])
    ->setCellValue('L'.$row, $insurance['avail_date'])
    ->setCellValue('M'.$row, "LR")
    ->setCellValue('N'.$row, $insurance['amount_loan'])
    ->setCellValue('O'.$row, $insurance['amount']);
    $row ++;
    $id ++;
}



// Set the HTTP headers to make the file downloadable
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Insurance_Summary.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);

// Output the file directly to the browser
$writer->save('php://output');
