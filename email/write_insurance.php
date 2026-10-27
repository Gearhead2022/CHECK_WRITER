<?php
// Your PHP code here
require '../vendor/autoload.php';
require_once "../controllers/insurance.controller.php";
require_once "../models/insurance.model.php";
require_once "../views/modules/session.php";

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Load the existing Excel file 'oona.xlsx'
$spreadsheet = IOFactory::load('oona.xlsx');

// Get the active worksheet
$activeWorksheet = $spreadsheet->getActiveSheet();

// Add your data to the loaded spreadsheet
$activeWorksheet->setCellValue('B5', '6556');
$activeWorksheet->setCellValue('C5', 'Last Name');
$activeWorksheet->setCellValue('D5', 'First Name');

// Set the HTTP headers to make the file downloadable with the correct filename
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="oona.xlsx"');
header('Cache-Control: max-age=0');

// Debugging: Output the data to check if it's set correctly
echo 'Debugging: Data added to the spreadsheet:';
echo '<pre>';
print_r($spreadsheet->getActiveSheet()->toArray());
echo '</pre>';

// Create a writer and save the modified spreadsheet to the same file
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
