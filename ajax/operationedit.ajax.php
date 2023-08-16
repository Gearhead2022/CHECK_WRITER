<?php
require_once "../controllers/operation.controller.php";
require_once "../models/operation.model.php";
require_once "../views/modules/session.php";
$type = $_GET['type'];
$id = $_GET['idClient'];


$editOperation= new operationModal();

if($type == "grossin"){
    $editOperation->showGrossinOperationEditModal();    
}elseif($type == "outgoing"){
    $editOperation->OutgoingOperationEditModal();
}


class operationModal{
	public function showGrossinOperationEditModal(){
        $id = $_GET['idClient'];
        $data = (new ControllerOperation)->ctrShowGrossinIdOperation($id);
        foreach ($data as &$item) {
            $date = $item['date'];
            $type = $item['type'];
            $walkin = $item['walkin'];
            $sales_rep = $item['sales_rep'];
            $returnee = $item['returnee'];
            $gros_transfer = $item['transfer'];
            $runners_agent = $item['runners_agent'];
            $type_name = "WEEKLY GROSS IN";
            $item['card'] ='
                   
            <div class="row">
            <div class="col-sm-4">
                <label for="input-6">DATE</label>
                <input type="date" class="form-control" id="date" value="'.$date.'" placeholder="Enter Folder Name" name="date" autocomplete="nope" required>
                <input type="text"  hidden class="form-control" id="id"  name="id" value="'.$id.'" autocomplete="nope">
            </div> 
        <div class="col-sm-8 form-group">
            <label   label for="input-6">TYPE</label>
            <input type="text" readonly class="form-control" value="'.$type_name.'" placeholder="Enter Walkin"  id="type1" name="type" >
        </div>
        </div>
        <div class="row addBox mt-2" id="grossin">
                <div class="col-sm-4 mt-3 mb-3">
                    <label for="vehicle1"> WALK IN</label>
                    <input type="number" class="form-control" value="'.$walkin.'" placeholder="Enter Walkin"  id="walkin" name="walkin" >
                    <label for="vehicle2"> SALES REP</label>
                    <input type="number" class="form-control" value="'.$sales_rep.'"  id="sales_rep" placeholder="Enter Sales Rep" name="sales_rep" >
                </div>
         <div class="col-sm-4 mt-3 mb-3">
                <label for="vehicle2"> RETURNEE</label>
                <input type="number"  class="form-control"  value="'.$returnee.'"  placeholder="Enter Returnee"  id="returnee" name="returnee">
                <label for="vehicle2"> TRANSFER</label>
                <input type="number"  class="form-control" value="'.$gros_transfer.'"   placeholder="Enter Transfer"  id="transfer" name="gros_transfer">
        </div>
        <div class="col-sm-4 mt-3 mb-3">
                <label for="vehicle2"> RUNNERS / AGENT</label>
                <input type="number"  class="form-control"  value="'.$runners_agent.'"  placeholder="Enter Runners / Agent"  id="runners_agent" name="runners_agent">
        </div>

        </div>
        <div class="modal-footer">
                <button type="submit" name ="editGrossin" id="addBeginning" class="btn btn-primary">Submit</button>
                <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
            ';
        }
        echo json_encode($data);
    }

    public function OutgoingOperationEditModal(){
        $id = $_GET['idClient'];
        $data = (new ControllerOperation)->ctrShowOutgoingIdOperation($id);
        foreach ($data as &$item) {
            $date = $item['date'];
            $type = $item['type'];
            $fully_paid = $item['fully_paid'];
            $deceased = $item['deceased'];
            $transfer = $item['transfer'];
            $gawad = $item['gawad'];
            $bad_accounts = $item['bad_accounts'];
            $type_name = "WEEKLY OUTGOING ACCOUNTS";
            $item['card'] ='
                   
            <div class="row">
            <div class="col-sm-4">
                <label for="input-6">DATE</label>
                <input type="date" class="form-control" id="date" value="'.$date.'" placeholder="Enter Folder Name" name="date" autocomplete="nope" required>
                <input type="text"  hidden class="form-control" id="id"  name="id" value="'.$id.'" autocomplete="nope">
            </div> 
        <div class="col-sm-8 form-group">
            <label   label for="input-6">TYPE</label>
            <input type="text" readonly class="form-control" value="'.$type_name.'" placeholder="Enter Walkin"  id="type1" name="type" >
        </div>
        </div>
        <div class="row addBox mt-2" id="outgoing">
        <div class="col-sm-4 mt-3 mb-3">
                    <label for="vehicle1">FULLY PAID</label>
                    <input type="number" class="form-control" value="'.$fully_paid.'" placeholder="Enter Fully Paid"  id="fully_paid" name="fully_paid" >
                    <label for="vehicle2">DECEASED</label>
                    <input type="number" class="form-control" value="'.$deceased.'"   id="deceased" placeholder="Enter Deceased" name="deceased" >
                </div>
         <div class="col-sm-4 mt-3 mb-3">
                <label for="vehicle2">TRANSFER</label>
                <input type="number"  class="form-control" value="'.$transfer.'"   placeholder="Enter Transfer"  id="transfer" name="transfer">
                <label for="vehicle2">GAWAD</label>
                <input type="number"  class="form-control" value="'.$gawad.'"  placeholder="Enter Gawad"  id="gawad" name="gawad">
        </div>
        <div class="col-sm-4 mt-3 mb-3">
                <label for="vehicle2">BAD ACCOUNT</label>
                <input type="number"  class="form-control" value="'.$bad_accounts.'"   placeholder="Enter Bad Account"  id="bad_accounts" name="bad_accounts">
        </div>
        </div>
        <div class="modal-footer">
                <button type="submit" name ="editOutgoing" id="addBeginning" class="btn btn-primary">Submit</button>
                <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
            ';
        }
        echo json_encode($data);
    }

}