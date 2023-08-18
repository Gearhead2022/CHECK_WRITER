<?php
require_once "../controllers/backup.controller.php";
require_once "../models/backup.model.php";
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
 
        $dateSlct = $_GET['dateSlct'];
        $data = (new ControllerBackup)->ctrCheckBackup($dateSlct);
        
        $i = 1;
        foreach ($data as &$item) {
           
            $branch_name = $item['full_name'];
            $item['card'] ='
                <tr>
                    <td>'.$i.'</td>
                    <td>'.$branch_name.'</td>
                </tr>
            ';
            $i++;
        }
        echo json_encode($data);
    }
   
}