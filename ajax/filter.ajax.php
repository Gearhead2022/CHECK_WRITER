<?php
require_once "../controllers/backup.controller.php";
require_once "../models/backup.model.php";
require_once "../views/modules/session.php";

$filterBackup= new backupTable();
if(isset($_GET['filterYear'])){
$filterBackup -> showFilterMonth();
}elseif(isset($_GET['backup_id'])){
    $filterBackup -> showFilter();
}


class backupTable{
	public function showFilter(){

        $backup_id = $_GET['backup_id'];
        $date_time = $_GET['new_date'];
        $branch_name = $_GET['branch_name'];
        $new_date = date("F j, Y", strtotime($date_time));
        $year = date('Y', strtotime($new_date));
        $month = date('F', strtotime($new_date));
        $table = "backup_files";
        $data = (new ControllerBackup)->ctrShowBackupFiles($table, $backup_id);

        
        foreach ($data as &$item) {
            $file_name = $item['file_name'];
            $item['card'] =' <div class="col-sm-4">
            <div class="card" style="width: 18rem;">
                <div class="card-header">
                <div class="d-flex">
                <div class="btn-group">
                    <button type="button" class="btn btn-light new" data-toggle="tooltip" data-placement="top" title="'.$file_name.'" style="width: 200px;"> <p class="text-truncate" style="max-width: 180px;  text-align: center; font-size: 14px;"><i class="fa fa-files-o"> </i>&nbsp;&nbsp;'.$file_name.'</p></button>
                    <button type="button" class="btn btn-light btn-sm" id="dropdownMenuReference" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-reference="parent">
                    <span><i class="fa fa-ellipsis-v"></i></span>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuReference"> 
                        <a class="dropdown-item" href="views/files/Backup/'.$branch_name.'/'.$year.'/'.$month.'/'.$new_date.'/'.$file_name.'" Download="'.$file_name.'">Download</a>
                    </div>
                </div>
                </div>
                </div>
                <div class="card-body image-container">
                   <img src="views/img/code3.png" alt="">
                </div>
            </div>
            </div>';
        }
        echo json_encode($data);
    }
    public function showFilterYear(){

        $filterYear = $_GET['filterYear'];
        $branch_name = $_GET['branch_name'];
        $data = (new ControllerBackup)->ctrShowFilterYear($filterYear, $branch_name);
        foreach ($data as &$item) {
                $new_date = $item['date_time'];
				$month = date('F', strtotime($new_date));
            $item['button'] =' <button type="button" class="btn btn-light new m-2" style="width: 200px;"> <p class="text-truncate" style="max-width: 180px;  text-align: center; font-size: 14px;"><i class="fa fa-files-o"> </i>&nbsp;&nbsp;'.$month.'</p></button>';
            ;
        }
        echo json_encode($data);
    }
    public function showFilterMonth(){
 
        $filterYear = $_GET['filterYear']; 
        $branch_name = $_GET['branch_name'];
        $filterMonth = $_GET['filterMonth'];
        $data = (new ControllerBackup)->ctrShowFilterMonth($filterYear, $branch_name, $filterMonth);
        foreach ($data as &$item) {
                $new_date = $item['date_time'];
                $backup_id = $item['backup_id'];
				$date_now = date('F j, Y', strtotime($new_date));
                $month = date('F', strtotime($new_date));
                $monthNum = date('m', strtotime($new_date));
                if($branch_name == "All" || $branch_name != "All" && $filterYear =="" ){
               
                    $item['button'] =' <button type="button"  class="btn btn-light new m-2 clk_name" branch_name ="'.$item['branch_name'].'" style="width: 200px; height: 47px;"> <p class="text-truncate" style="max-width: 180px;  text-align: left; font-size: 16px;"><i class="fa fa-folder"> </i>&nbsp;&nbsp;'.$item['branch_name'].'</p></button>';
                }elseif($branch_name != "All" && $filterYear !="" && $filterMonth =="" ){
                  
                    $item['button'] =' <button  monthNum="'.$monthNum.'" class="btn btn-light new m-2 clk_month" style="width: 200px; height: 47px;"> <p class="text-truncate" style="max-width: 180px;  text-align: left; font-size: 16px;"><i class="fa fa-folder"> </i>&nbsp;&nbsp;'.$month.'</p></button>';
                }elseif($branch_name != "All" || $filterYear !="" || $filterMonth !="" ){
                 
                    $item['button'] ="<div class='btn-group'><button class='btn btn-light new mt-2 ml-2 mb-2 preview_file2' backup_id='".$backup_id."' branch_name='".$branch_name."' new_date='".$new_date."' id='wowoww'  style='width: 200px; height: 47px;'> <p class='text-truncate' style='max-width: 180px;  text-align: left; font-size: 16px;'><i class='fa fa-folder'> </i>&nbsp;&nbsp;".$date_now."</p></button>
                    <button type='button' class='btn btn-light btn-sm mt-2' style='height: 47px;' id='dropdownMenuReference' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' data-reference='parent'>
                            <span><i class='fa fa-ellipsis-v'></i></span>
                            </button>
                            <div class='dropdown-menu' aria-labelledby='dropdownMenuReference'> 
                                <a class='dropdown-item toDownload' new_date='".$new_date."'  id='toDownload' >Download</a>
                            </div>
                    </div>";
                }
            // $item['button'] =' <button type="button" class="btn btn-light new m-2" style="width: 200px;"> <p class="text-truncate" style="max-width: 180px;  text-align: center; font-size: 14px;"><i class="fa fa-files-o"> </i>&nbsp;&nbsp;'.$date_now.'</p></button>';
            ;
        }
        echo json_encode($data);
    }
}