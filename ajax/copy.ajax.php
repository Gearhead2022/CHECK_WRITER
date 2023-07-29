<?php
require_once "../controllers/checklist.controller.php";
require_once "../models/checklist.model.php";
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
 
        $chk_id = $_GET['selectedValue'];
      

        $data = (new ControllerChecklist)->ctrShowChecklistReport($chk_id);

        
        foreach ($data as &$item) {
            $chk_id = $item['chk_id'];
            $id = $item['id'];
            $chk_task = $item['chk_task'];
          
            

            $item['card'] ='
                   

                   <tr>
                    <td><input type="checkbox" class="form-control chk_data" id="chk_data" name="chk_data[]" value="'.$id.'"></td>
                    <td>'.$chk_task.'</td>
                    
                </tr>
              
            ';
        }
        echo json_encode($data);
    }
   
}