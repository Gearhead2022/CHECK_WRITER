<?php
require_once "../controllers/fullypaid.controller.php";
require_once "../models/fullypaid.model.php";
require_once "../views/modules/session.php";

$filterBackup= new reportTable();
// if(isset($_GET['filterYear'])){
// $filterBackup -> showFilterMonth();
// }elseif(isset($_GET['backup_id'])){
//     $filterBackup -> showFilter();
// }
$filterBackup -> showFilter();

class reportTable{
	public function showFilter(){
 
        $dateFrom = $_GET['dateFrom'];
        $dateTo = $_GET['dateTo'];
        $selectedValue = $_GET['selectedValue'];
        $startDateFormatted = date('Ymd', strtotime($dateFrom));
        $dateTotDateFormatted = date('Ymd', strtotime($dateTo));
        

        $table = "fully_paid";
        $data = (new ControllerFullypaid)->ctrShowFilterReport($table, $startDateFormatted, $dateTotDateFormatted, $selectedValue);

         
        foreach ($data as &$item) {
            $out_date = $item['out_date'];
            $name = $item['name'];
            $fpid = $item['fpid'];
            $bank = $item['bank'];
            $atm_status = $item['atm_status'];
            $date_claimed = $item['date_claimed'];
            $remarks = $item['remarks'];
            $timestamp = strtotime($out_date);
            $formattedDate = date("F d, Y", $timestamp);
            

            $item['card'] ='
           
                <tr>
                    <td>'.$fpid.'</td>
                    <td>'.$name.'</td>
                    <td>'.$formattedDate.'</td>
                    <td>'.$bank.'</td>
                    <td>'.$atm_status.'</td>
                    <td>'.$date_claimed.'</td>
                    <td>'.$remarks.'</td>
                </tr>
            ';
        }
        echo json_encode($data);
    }
   
}