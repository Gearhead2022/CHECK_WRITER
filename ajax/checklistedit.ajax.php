<?php
require_once "../controllers/checklist.controller.php";
require_once "../models/checklist.model.php";
require_once "../views/modules/session.php";

$editChecklist= new checklistModal();

if(isset($_GET['type'])){
    $type = $_GET['type'];
    if($type == "Checklist"){
        $editChecklist -> showChecklistEditModal();
    }else if($type == "ChecklistReport"){
        $editChecklist -> showChecklistReportEditModal();
    }
}

class checklistModal{
	public function showChecklistEditModal(){
        $id = $_GET['idClient'];
      

        $data = (new ControllerChecklist)->ctrShowChecklistID($id);

        
        foreach ($data as &$item) {
          
            $id = $item['id'];
            $chk_date = $item['chk_date'];
          
            

            $item['card'] ='
                   

        <div class="row">
            <div class="col-sm-12 form-group">
                <label for="input-6">DATE</label>
                <input type="date" class="form-control" id="chk_date" value="'.$chk_date.'" name="chk_date" autocomplete="nope" required>
                <input type="text" hidden class="form-control" id="id"  name="id" value="'.$id.'" autocomplete="nope">
                
            </div>   
    </div> 
              
            ';
        }
        echo json_encode($data);
    }


    public function showChecklistReportEditModal(){
        $id = $_GET['idClient'];
        $chk_id = $_GET['chk_id'];
      

        $data = (new ControllerChecklist)->ctrShowChecklistReportID($chk_id,$id);

         
        foreach ($data as &$item) {
          
            $id = $item['id'];
            $chk_task = $item['chk_task'];
            $chk_prio = $item['chk_prio'];
            $chk_start = $item['chk_start'];
            $chk_end = $item['chk_end'];
            $chk_status = $item['chk_status'];
            $chk_notes = $item['chk_notes'];
          
            

            $item['card'] ='
            <div class="row mt-2">
            <div class="col-sm-12 form-group">
                <label for="input-6">TASK DETAILS / DESCRIPTION</label>
                <input type="text" hidden class="form-control"  name="id" id="id" value="'.$id.'">

                <textarea class="form-control" id="chk_task"  placeholder="Enter Task Details / Description" name="chk_task" autocomplete="nope" required>'.$chk_task.'</textarea>
            </div>   
       </div> 
       <div class="row">
          <div class="col-sm-3 form-group">
            <label for="input-6">PRIORITY</label>
            <select class="form-control" name="chk_prio" id="chk_prio">
              <option value="'.$chk_prio.'">'.$chk_prio.'</option>
              <option value="LOW">LOW</option>
              <option value="MEDIUM">MEDIUM</option>
              <option value="HIGH">HIGH</option>
              <option value="CRITICAL">CRITICAL</option>
            </select>
          </div>
          <div class="col-sm-3 form-group">
             <label for="input-6">STARTED</label>
             <input type="date" class="form-control" value="'.$chk_start.'" name="chk_start" id="chk_start">
          </div>
          <div class="col-sm-3 form-group">
            <label for="input-6">ACTUAL DATE END</label>
             <input type="date" class="form-control" value="'.$chk_end.'"  name="chk_end" id="chk_end">
          </div>
          <div class="col-sm-3 form-group">
              <label for="input-6">STATUS</label>
              <select class="form-control" name="chk_status" id="chk_status">
                <option value="'.$chk_status.'">'.$chk_status.'</option>
                <option value="PENDING">PENDING</option>
                <option value="ON GOING">ON GOING</option>
                <option value="DONE">DONE</option>
                <option value="IN DEVELOPMENT">IN DEVELOPMENT</option>
                <option value="DEPLOYED">DEPLOYED</option>
                <option value="FOR APPROVAL">FOR APPROVAL</option>
              </select>
          </div>
       </div>
       <div class="row mt-2">
            <div class="col-sm-12 form-group">
                <label for="input-6">NOTES</label>
                <textarea type="text" class="form-control" id="chk_notes" placeholder="Enter Notes" name="chk_notes" autocomplete="nope" >'.$chk_notes.'</textarea>
            </div>   
       </div> 

              
            ';
        }
        echo json_encode($data);
    }
   
}