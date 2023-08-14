<?php
require_once "../controllers/pastdue.controller.php";
require_once "../models/pastdue.model.php";
require_once "../views/modules/session.php";
$type = $_GET['type'];
$editPastDue= new pastdueModal();

if($type == "editLedger"){
    $editPastDue->showLedgerEditModal();    
}elseif($type == "editTarget"){
    $editPastDue->showTargetEditModal();
}




class pastdueModal{
	public function showLedgerEditModal(){
        $id = $_GET['idClient'];
        date_default_timezone_set('Asia/Manila');
        $date_now =date("Y-m-d"); 
    

        $data = (new ControllerPastdue)->ctrShowIDLedger($id);

        
        foreach ($data as &$item) {
          
            $id = $item['id'];
            $account_no = $item['account_no'];
            $refno = $item['refno'];
            $credit = $item['credit'];
            $debit = $item['debit'];
            $pay_mis = $item['pay_mis'];
            $include_week = $item['include_week'];
            $date = $item['date'];

            if($pay_mis == 1){
                $status = "checked";
            }else{
                $status = "";
            }

            if($include_week == 1){
                $status1 = "checked";
            }else{
                $status1 = "";
            }

            
            if($credit != "" ){
                $amount = $credit;
            }else{
                $amount = $debit;
            }

        
            $item['card'] ='
                   

            <div class="row">
            <div class="col-sm-6 form-group">
                <label for="input-6">ACCOUNT NUMBER</label>
                <input type="text" class="form-control" id="account_no" readonly value="'.$account_no.'" placeholder="Enter Account Number" name="account_no" autocomplete="nope" required>
                <input type="text" class="form-control" id="id" hidden value="'.$id.'" placeholder="Enter Account Number" name="id" autocomplete="nope" required>
            </div>   
            <div class="col-sm-6 form-group">
                <label for="input-6">DATE</label>
                <input type="date" class="form-control" id="date" value="'.$date.'" placeholder="Enter Folder Name" name="date" autocomplete="nope" required>
            </div>  
        </div>
        <div class="row">
            <div class="col-sm-6 form-group">
                <label for="input-6">REFFERENCE NUMBER</label>
                <input type="text" class="form-control" id="refno" value="'.$refno.'"   placeholder="Enter Refference Number" name="refno" autocomplete="nope" required>
            </div>   
            <div class="col-sm-6 form-group">
                <label for="input-6">AMOUNT</label>
                <input type="text" class="form-control amount" id="amount" value="'.$amount.'"  placeholder="Enter Amount" name="amount" autocomplete="nope" required>
            </div>  
        </div>
        <div class="row">
                  <div class="col-sm-6 form-group">
                    <input type="checkbox" '.$status.'  id="pay_mis" name="pay_mis" autocomplete="nope">
                    <label for="pay_mis">MISCELLANEOUS</label>
                  </div>
                  <div class="col-sm-6 form-group include_week1" id="include_week1">
                    <input type="checkbox" '.$status1.'  id="include_week" value name="include_week" autocomplete="nope">
                    <label for="pay_mis">INCLUDE IN WEEKLY</label>
                  </div>
                </div>
    
              
            ';
        }
        echo json_encode($data);
    }


    public function showTargetEditModal(){
        $id = $_GET['idClient'];
      
        $data = (new ControllerPastdue)->ctrShowIDTarget($id);

        $branch = (new ControllerPastdue)->ctrShowBranches();

        
        foreach ($data as &$item) {
          
            $id1 = $item['id'];
            $branch_name = $item['branch_name'];
            $date = $item['date'];
            $amount = $item['amount'];

          
            

            $item['card'] ='
                   
        <div class="row">
            <div class="col-sm-12 form-group">
            <label   label for="input-6">BRANCH NAME</label>
            <select class="form-control" name="branch_name" id="branch_name" required>
              <option value="'.$branch_name.'">'.$branch_name.'</option>';


            
                foreach ($branch as $key => $row){
                  # code...
                  $full_name = $row['full_name'];
        $item['card'] .='
              <option value="'.$full_name.'">'.$full_name.'</option>
              ';
             } 
    $item['card'] .='  
            </select>
            <input type="text" class="form-control" id="id" hidden value="'.$id1.'" placeholder="Enter Account Number" name="id" autocomplete="nope" required>
            </div>   
    </div> 
        <div class="row">
            <div class="col-sm-6 form-group">
                <label for="input-6">MONTH</label>
                <input type="month" class="form-control" value="'.$date.'" id="date" placeholder="Enter Folder Name" name="date">
            </div>  
            <div class="col-sm-6 form-group">
              <label for="input-6">AMOUNT</label>
              <input type="text" class="form-control" id="amount" value="'.$amount.'" placeholder="Enter Target Amount" name="amount">
           </div>   
    </div>
            ';
        }
        echo json_encode($data);
    }




}