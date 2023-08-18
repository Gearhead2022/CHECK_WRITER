<?php
require_once "../controllers/pastdue.controller.php";
require_once "../models/pastdue.model.php";
require_once "../views/modules/session.php";
$type = $_GET['type'];
$editPastDue= new pastdueModal();

if($type == "duplicate"){
    $editPastDue->showCheckerModal();    
}elseif($type == "checkLedger"){
    $editPastDue->showChecker1Modal();   
}elseif($type == "checkFullypaid"){
    $selectedbranch_name = $_GET['selectedbranch_name'];
    $editPastDue->showChecker2Modal($selectedbranch_name);   
}


class pastdueModal{
	public function showCheckerModal(){
       
    
        $data = (new ControllerPastdue)->ctrShowDuplicate();
    
        foreach ($data as &$item) {
            $branch_name = $item['branch_name'];
            $first_name = $item['first_name'];
            $last_name = $item['last_name'];
            $duplication_count  = $item['duplication_count'];
          
        
            $item['card'] ='
            <tr>
              <td>'.$branch_name.'</td>
              <td>'.$last_name.'</td>
              <td>'.$first_name.'</td>
              <td>'.$duplication_count.'</td>
            </tr>
       
              
            ';
        }
        echo json_encode($data);
    }

    public function showChecker1Modal(){
    
        $data = (new ControllerPastdue)->ctrCheckLedger();
    
        foreach ($data as &$item) {
            $branch_name = $item['branch_name'];
            $account_no = $item['account_no'];

            $item['card'] ='
            <tr>
              <td>'.$branch_name.'</td>
              <td>'.$account_no.'</td>
            </tr>
       
              
            ';
        }
        echo json_encode($data);
    }

    public function showChecker2Modal($selectedbranch_name){
        $i=0;
        $data1 = (new ControllerPastdue)->ctrGetAllPDRPerBranch($selectedbranch_name);
        foreach ($data1 as &$item) {
            $branch_name = $item['branch_name'];
            $account_no = $item['account_no'];
            $last_name = $item['last_name'];
            $item['card']='';
          

            $data = (new ControllerPastdue)->ctrCheckFullyPaid($branch_name, $account_no);
            foreach ($data as &$item1) {
           
                $result = $item1['result'];
                if($result == 0 && $result != ""){
                    $i++;
                    $item['card'] .='
                    <tr>
                      <td>'.$branch_name.'</td>
                      <td>'.$account_no.'</td>
                      <td>'.$last_name.'</td>
                      <td>'.$result.'</td>
                    </tr>
                    ';
               
                }

            }
        }
        $item['card'] .=' 
        <tr>
            <td>Total = '.$i.'</td>
            </tr>
        ';

        echo json_encode($data1);
    }

}