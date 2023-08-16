<?php 
$full_name = $_SESSION['branch_name'];
$currentDate = date("Y-m-d");
$previousDate = date("Y-m-d", strtotime("-1 day"));
$dayRep = strtoupper(date("F d", strtotime($currentDate)));
$Operation = new ControllerOperation();

$grossin_bal = (new Connection)->connect()->query("SELECT * FROM op_beginning_bal WHERE branch_name = '$full_name' AND `type` = 'grossin'")->fetch(PDO::FETCH_ASSOC);
if(!empty($grossin_bal)){
    $amount_grossin = $grossin_bal['amount'];
}else{
    $amount_grossin = 0;
}
$getGrossinCumi = $Operation->ctrGetGrossinCumi($previousDate, $full_name);
if(!empty($getGrossinCumi)){
$total_GrossinCumi = $getGrossinCumi[0]['total_cumi'];
}else{
  $total_GrossinCumi = 0;
}


$outgoing_bal = (new Connection)->connect()->query("SELECT * FROM op_beginning_bal WHERE branch_name = '$full_name' AND `type` = 'outgoing'")->fetch(PDO::FETCH_ASSOC);
if(!empty($outgoing_bal)){
$amount_outgoing= $outgoing_bal['amount'];
}else{
    $amount_outgoing= 0;
}

$getOutgoingCumi = $Operation->ctrGetOutgoingCumi($previousDate, $full_name);
if(!empty($getOutgoingCumi)){
$total_OutgoingCumi = $getOutgoingCumi[0]['total_cumi'];
}else{
  $total_OutgoingCumi = 0;
}


$final_grossinCumi = $amount_grossin + $total_GrossinCumi;
$final_outgoingCumi = $amount_outgoing + $total_OutgoingCumi;
$grossin_weekly = (new Connection)->connect()->query("SELECT SUM(walkin) as walkin, SUM(sales_rep) as sales_rep , SUM(returnee) as returnee, SUM(runners_agent) as runners_agent,
 SUM(transfer) as transfer FROM `op_grossin` WHERE branch_name = '$full_name' AND date = '$currentDate' ")->fetch(PDO::FETCH_ASSOC);
 if(!empty($grossin_weekly)){
$walkin = $grossin_weekly['walkin'];
$sales_rep = $grossin_weekly['sales_rep'];
$returnee = $grossin_weekly['returnee'];
$runners_agent = $grossin_weekly['runners_agent'];
$gros_transfer = $grossin_weekly['transfer'];

$total_grossin_cumi = $final_grossinCumi + $walkin + $sales_rep + $returnee + $runners_agent + $gros_transfer;
$total_grossin = $walkin + $sales_rep + $returnee + $runners_agent +  $gros_transfer;
 }

$outgoing_weekly = (new Connection)->connect()->query("SELECT SUM(fully_paid) as fully_paid, SUM(deceased) as deceased , SUM(transfer) as transfer, SUM(gawad) as gawad,
 SUM(bad_accounts) as bad_accounts FROM `op_outgoing` WHERE branch_name = '$full_name' AND date = '$currentDate' ")->fetch(PDO::FETCH_ASSOC);
  if(!empty($outgoing_weekly)){
$fully_paid = $outgoing_weekly['fully_paid'];
$deceased = $outgoing_weekly['deceased'];
$transfer = $outgoing_weekly['transfer'];
$gawad = $outgoing_weekly['gawad'];
$bad_accounts = $outgoing_weekly['bad_accounts'];

$total_outgoing_cumi = $final_outgoingCumi + $fully_paid + $deceased + $transfer + $gawad + $bad_accounts;
$total_outgoing = $fully_paid + $deceased + $transfer + $gawad + $bad_accounts;

  }

?> 
<style>
  .modal-content {
    width: 1000px;
   
} .addBox {
    border-color: white;

    border-style: groove;
}
#per{
    font-size: 10px;
}

</style>
<div class="clearfix"></div>
  
<div class="content-wrapper">
   <div class="container-fluid">
     <div class="row pt-2 pb-2">
        <div class="col-sm-12">
          <h4 class="page-title">WEEKLY GROSS IN AND OUTGOING ACCOUNTS</h4>
        </div>
     </div>

      <div class="row">

        <div class="col-lg-12">
        
          <div class="card">
            <div class="card-header float-sm-right">
              <div class="row">
                <?php if($_SESSION['type']=="admin" || $_SESSION['type']=="backup_user" || $_SESSION['type']=="backup_admin"){?>
                  <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1" data-toggle="modal" data-target="#exampleModalCenter"><i class="fa fa-plus"></i> <span>&nbsp;ADD BEGINNING BALANCE</span> </button>
                  <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1" data-toggle="modal" data-target="#exampleModalCenter1"><i class="fa fa-plus"></i> <span>&nbsp;ADD</span> </button>
                  <button type="button"  class="btn btn-light btn-round waves-effect waves-light m-1" onClick="location.href='operationreport'"><i class="fa fa-print"></i> <span>&nbsp;GENERATE REPORTS</span> </button>
                <?php  }?>

                  <div class="col-sm-2 form-group" style="padding-top: 10px;margin-bottom: 6px;">
              </div>
            </div>            
            <div class="card-body">
              <div class="table-responsive">
              <table id="default-datatable" class="table table-bordered table-hover table-striped operationTable">
                <thead>
                <tr>
                  <th>Branch Name</th>
                  <th>TYPE</th>
                  <th>DATE</th>
                  <th>Action</th>
                </tr>
                </thead>
              </table>
            </div>
             <!-- Start WEEKLY Gross In -->
   <?php  
        if($full_name !== "admin"){?>                 
    <hr/>
    <div class="col-lg-12">
        <h6>BRANCH WEEKLY GROSS IN</h6>
        <p id="per">FOR THE PERIOD OF <?php echo $dayRep; ?></p>
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th rowspan="2" style="text-align: center; vertical-align: middle; font-size: 15px; margin-bottom: 20px;">BRANCH</th>
                    <th rowspan="2" style="text-align: center; vertical-align: middle; font-size: 12px; margin-bottom: 20px;">as of <?php echo $previousDate; ?></th>
                    <th>WALK IN</th>
                    <th>SALES REP</th>
                    <th>RETURNEE</th>
                    <th>RUNNERS / AGENT</th>
                    <th>TRANSFER</th>
                    <th>TOTAL IN</th>
                    <th>CUM. TOTAL</th>
                </tr>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>as of <?php echo $currentDate; ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo $full_name; ?></td>
                    <td><?php echo $final_grossinCumi;?></td>
                    <td><?php echo $walkin; ?></td>
                    <td><?php echo $sales_rep; ?></td>
                    <td><?php echo $returnee; ?></td>
                    <td><?php echo $runners_agent; ?></td>
                    <td><?php echo $gros_transfer; ?></td>
                    <td><?php echo $total_grossin; ?></td>
                    <td><?php echo $total_grossin_cumi; ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- END WEEKLY Gross In -->

    <!-- Start WEEKLY Gross In -->
    <div class="col-lg-12 mt-4">
        <h6>BRANCH WEEKLY OUTGOING ACCOUNTS</h6>
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th rowspan="2" style="text-align: center; vertical-align: middle; font-size: 15px; margin-bottom: 20px;">BRANCH</th>
                    <th rowspan="2" style="text-align: center; vertical-align: middle; font-size: 12px; margin-bottom: 20px;">as of <?php echo $previousDate; ?></th>
                    <th>FULLY PAID</th>
                    <th>DECEASED</th>
                    <th>GAWAD</th>
                    <th>BAD ACCOUNTS</th>
                    <th>TRANSFER</th>
                    <th>TOTAL OUT</th>
                    <th>CUM. TOTAL</th>
                </tr>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>as of <?php echo $currentDate; ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo $full_name; ?></td>
                    <td><?php echo $final_outgoingCumi; ?></td>
                    <td><?php echo $fully_paid; ?></td>
                    <td><?php echo $deceased; ?></td>
                    <td><?php echo $gawad; ?></td>
                    <td><?php echo $bad_accounts; ?></td>
                    <td><?php echo $transfer; ?></td>
                    <td><?php echo $total_outgoing; ?></td>
                    <td><?php echo $total_outgoing_cumi; ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- END WEEKLY Gross In -->
    <?php } ?>
            </div>
          </div>
        </div>
      </div> 

  

      <!-- START modal for add beginning balance-->
      <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
             <div class="modal-content">
                <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLongTitle">ADD BEGINNING BALANCE</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                <form  method="post">
                <div class="row">
                <div class="col-sm-12 form-group">
                    <label   label for="input-6">TYPE</label>
                    <select class="form-control" name="type" id="type" required>
                        <option value=""><  - - SELECT TYPE - - ></option>
                        <option value="grossin">WEEKLY GROSS IN</option>
                        <option value="outgoing">WEEKLY OUTGOING ACCOUNTS</option>
                    </select>
                </div>  
                    <div class="col-sm-6 mt-2">
                        <label for="input-6">DATE</label>
                        <input type="date" class="form-control" id="date" placeholder="Enter Folder Name" name="date" autocomplete="nope" required>
                        <input type="text" hidden  class="form-control" id="branch_name"  name="branch_name" value="<?php echo $full_name; ?>" autocomplete="nope">
                    </div>
                    <div class="col-sm-6">
                        <label for="input-6">TOTAL</label>
                        <input type="text" class="form-control" id="amount" placeholder="Enter Total Amount" name="amount" autocomplete="nope" required>
                    </div>
            </div> 
                </div>
                <div class="modal-footer">
                        <button type="submit" name ="addBeginning" class="btn btn-primary">Submit</button>
                        <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
              </form>
              <?php
                 
                    $Operation -> ctrAddBeginningBalance();
                    ?>
           </div>
        </div>
         <!-- END modal for add beginning balance-->

          <!-- START modal for add beginning balance-->
      <div class="modal fade" id="exampleModalCenter1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
             <div class="modal-content">
                <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLongTitle">ADD</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <form  method="post">
                <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4">
                        <label for="input-6">DATE</label>
                        <input type="date" class="form-control" id="date" placeholder="Enter Folder Name" name="date" autocomplete="nope" required>
                        <input type="text" hidden  class="form-control" id="branch_name"  name="branch_name" value="<?php echo $full_name; ?>" autocomplete="nope">
                    </div> 
                <div class="col-sm-8 form-group">
                    <label   label for="input-6">TYPE</label>
                    <select class="form-control slcType" name="type" id="type1" required>
                        <option value=""><  - - SELECT TYPE - - ></option>
                        <option value="grossin">WEEKLY GROSS IN</option>
                        <option value="outgoing">WEEKLY OUTGOING ACCOUNTS</option>
                    </select>
                </div>
                </div>
                <div class="row addBox mt-2" id="grossin">
                        <div class="col-sm-4 mt-3 mb-3">
                            <label for="vehicle1"> WALK IN</label>
                            <input type="number" class="form-control" placeholder="Enter Walkin"  id="walkin" name="walkin" >
                            <label for="vehicle2"> SALES REP</label>
                            <input type="number" class="form-control"  id="sales_rep" placeholder="Enter Sales Rep" name="sales_rep" >
                        </div>
                 <div class="col-sm-4 mt-3 mb-3">
                        <label for="vehicle2"> RETURNEE</label>
                        <input type="number"  class="form-control"  placeholder="Enter Returnee"  id="returnee" name="returnee">
                        <label for="vehicle2"> TRANSFER</label>
                        <input type="number"  class="form-control"  placeholder="Enter Transfer"  id="transfer" name="gros_transfer">
                </div>
                <div class="col-sm-4 mt-3 mb-3">
                        <label for="vehicle2"> RUNNERS / AGENT</label>
                        <input type="number"  class="form-control"  placeholder="Enter Runners / Agent"  id="runners_agent" name="runners_agent">
                </div>

                </div>

                <div class="row addBox mt-2" id="outgoing" hidden>
                <div class="col-sm-4 mt-3 mb-3">
                            <label for="vehicle1">FULLY PAID</label>
                            <input type="number" class="form-control" placeholder="Enter Fully Paid"  id="fully_paid" name="fully_paid" >
                            <label for="vehicle2">DECEASED</label>
                            <input type="number" class="form-control"  id="deceased" placeholder="Enter Deceased" name="deceased" >
                        </div>
                 <div class="col-sm-4 mt-3 mb-3">
                        <label for="vehicle2">TRANSFER</label>
                        <input type="number"  class="form-control"  placeholder="Enter Transfer"  id="transfer" name="transfer">
                        <label for="vehicle2">GAWAD</label>
                        <input type="number"  class="form-control"  placeholder="Enter Gawad"  id="gawad" name="gawad">
                </div>
                <div class="col-sm-4 mt-3 mb-3">
                        <label for="vehicle2">BAD ACCOUNT</label>
                        <input type="number"  class="form-control"  placeholder="Enter Bad Account"  id="bad_accounts" name="bad_accounts">
                </div>
                </div>
                <div class="modal-footer">
                        <button type="submit" name ="addBeginning" id="addBeginning" class="btn btn-primary">Submit</button>
                        <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
              </form>
                <?php $Operation -> ctrAddGrossin();?>
                <?php $Operation -> ctrAddOutGoing();?>
           </div>
        </div>
      </div>
         <!-- END modal for add beginning balance-->

     <!-- START Edit modal for add beginning balance-->
      <div class="modal fade" id="editOperationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
             <div class="modal-content">
                <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLongTitle">EDIT</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <form  method="post">
                <div class="modal-body">
                
              </div>
              </form>
                <?php $Operation -> ctrEditGrossin();
                 $Operation -> ctrEditOutGoing();

                ?>
             
           </div>
        </div>
      </div>
         <!-- END Edit modal for add beginning balance-->




    <div class="overlay toggle-menu"></div>


  </div>        <!-- container-fluid -->
</div>          <!-- content-wrapper -->
</div>

<?php
 

  $Operation  -> ctrDeleteOperation();
  
?>


  
