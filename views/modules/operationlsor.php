<?php 
$branch_name = $_SESSION['branch_name'];
$currentDate = date("Y-m-d");
$previousDate = date("Y-m-d", strtotime("-1 day"));
$dayRep = strtoupper(date("F d", strtotime($currentDate)));
$Operation = new ControllerOperation();

$getLSOR = $Operation->ctrGetLSOR($branch_name, $currentDate);
$getBeginLSOR = $Operation->ctrGetBeginLSOR($branch_name);
if(!empty($getBeginLSOR)){
  $LSORBegin = $getBeginLSOR[0]['amount'];
}else{
  $LSORBegin = 0;
}

foreach($getLSOR as $LSOR){
  $fin_stable = $LSOR['fin_stable'];
  $app_wc = $LSOR['app_wc'];
  $low_cashout = $LSOR['low_cashout'];
  $existing_loan = $LSOR['existing_loan'];
  $other_resched_gawad = $LSOR['other_resched_gawad'];
  $other_sched_gawad = $LSOR['other_sched_gawad'];
  $sched_applynow = $LSOR['sched_applynow'];
  $ssp_overage = $LSOR['ssp_overage'];
  $lack_requirements = $LSOR['lack_requirements'];
  $undecided = $LSOR['undecided'];
  $refuse_transfer = $LSOR['refuse_transfer'];
  $inquired_only = $LSOR['inquired_only'];
  $new_policy = $LSOR['new_policy'];
  $not_goodcondition = $LSOR['not_goodcondition'];
  $guardianship = $LSOR['guardianship'];
  $plp = $LSOR['plp'];
  $not_qualified = $LSOR['not_qualified'];
  $eighteen_mos_sssloan = $LSOR['eighteen_mos_sssloan'];
  $on_process = $LSOR['on_process'];
}

$total = $fin_stable + $app_wc + $low_cashout + $existing_loan + $other_resched_gawad + $other_sched_gawad + $sched_applynow + $ssp_overage + $lack_requirements +
$undecided + $refuse_transfer + $inquired_only + $new_policy + $not_goodcondition + $guardianship + $plp + $not_qualified + $eighteen_mos_sssloan + $on_process;


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
          <h4 class="page-title">LOST SALES OPPORTUNITIES REPORT</h4>
        </div>
     </div>

      <div class="row">

        <div class="col-lg-12">
        
          <div class="card">
            <div class="card-header float-sm-right">
              <div class="row">
                <?php if($_SESSION['type']=="admin" || $_SESSION['type']=="backup_user" || $_SESSION['type']=="backup_admin"){?>
                  <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1" data-toggle="modal" data-target="#exampleModalCenter"><i class="fa fa-plus"></i> <span>&nbsp;ADD BEGINNING BALANCE</span> </button>
                  <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1" onClick="location.href='operationlsoradd'"><i class="fa fa-plus"></i> <span>&nbsp;ADD LSOR</span> </button>
                  <button type="button"  class="btn btn-light btn-round waves-effect waves-light m-1" onClick="location.href='operationlsorreport'"><i class="fa fa-print"></i> <span>&nbsp;GENERATE REPORTS</span> </button>
                  <?php }?>
                  <div class="col-sm-2 form-group" style="padding-top: 10px;margin-bottom: 6px;">
              </div>
            </div>            
            <div class="card-body">
              <div class="table-responsive">
              <table id="default-datatable" class="table table-bordered table-hover table-striped operationlsorTable">
                <thead>
                <tr>
                  <th>Branch Name</th>
                  <th>DATE</th>
                  <th>Action</th>
                </tr>
                </thead>
              </table>
            </div>
             <!-- Start WEEKLY Gross In -->
   <?php  
        if($branch_name !== "admin"){?>                 
    <hr/>
    <div class="table-responsive">
        <p id="per">FOR THE PERIOD OF <?php echo $dayRep; ?></p>
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th rowspan="2" style="text-align: center; vertical-align: middle; font-size: 15px; margin-bottom: 20px;">BRANCH</th>
                    <th rowspan="2" style="text-align: center; vertical-align: middle; font-size: 12px; margin-bottom: 20px;">as of <?php echo $previousDate; ?></th>
                    <th>FINANCIALLY STABLE</th>
                    <th>APPROVAL WIFE AND CHILDREN</th>
                    <th>LOW CASH OUT</th>
                    <th>EXISTING LOAN TO OTHER LENDING</th>
                    <th>OTHER LENDING RE-SCHED GAWAD</th>
                    <th>OTHER LENDING SCHED GAWAD</th>
                    <th>SCHEDULED TO APPLY LOAN</th>
                    <th>SSP OVER AGE</th>
                    <th>LACK OF REQUIREMENTS</th>
                    <th>UNDECIDED</th>
                    <th>REFUSE TO TRANSFER ACCOUNT/LOAN</th>
                    <th>INQUIRED ONLY</th>
                    <th>NEW POLICY</th>
                    <th>NOT IN GOOD CONDITION</th>
                    <th>GUARDIANSHIP</th>
                    <th>PLP</th>
                    <th>SSP NOT QUALIFIED</th>
                    <th>18 MOS SSSS LOAN</th>
                    <th>PENSION STILL ON PROCESS</th>
                    <th>TOTAL</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                   <td><?php echo $branch_name; ?></td>
                   <td><?php echo $LSORBegin; ?></td>
                   <td><?php echo $fin_stable; ?></td>
                   <td><?php echo $app_wc; ?></td>
                   <td><?php echo $low_cashout; ?></td>
                   <td><?php echo $existing_loan; ?></td>
                   <td><?php echo $other_resched_gawad; ?></td>
                   <td><?php echo $other_sched_gawad; ?></td>
                   <td><?php echo $sched_applynow; ?></td>
                   <td><?php echo $ssp_overage; ?></td>
                   <td><?php echo $lack_requirements; ?></td>
                   <td><?php echo $undecided; ?></td>
                   <td><?php echo $refuse_transfer; ?></td>
                   <td><?php echo $inquired_only; ?></td>
                   <td><?php echo $new_policy; ?></td>
                   <td><?php echo $not_goodcondition; ?></td>
                   <td><?php echo $guardianship; ?></td>
                   <td><?php echo $plp; ?></td>
                   <td><?php echo $not_qualified; ?></td>
                   <td><?php echo $eighteen_mos_sssloan; ?></td>
                   <td><?php echo $on_process; ?></td>
                   <td><?php echo $total; ?></td>
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
                    <div class="col-sm-6 mt-2">
                        <label for="input-6">FROM</label>
                        <input type="month" class="form-control" id="date" placeholder="Enter Folder Name" name="datefrom" autocomplete="nope" required>
                        <input type="text" hidden  class="form-control" id="branch_name"  name="branch_name" value="<?php echo $branch_name; ?>" autocomplete="nope">
                    </div>
                    <div class="col-sm-6 mt-2">
                        <label for="input-6">TO</label>
                        <input type="month" class="form-control" id="date" placeholder="Enter Folder Name" name="dateto" autocomplete="nope" required>
                    </div>
            </div> 
            <div class="row">
            <div class="col-sm-6">
                        <label for="input-6">TOTAL</label>
                        <input type="text" class="form-control" id="amount" placeholder="Enter Total Amount" name="amount" autocomplete="nope" required>
                    </div>
            </div>
                </div>
                <div class="modal-footer">
                        <button type="submit" name ="addLSORBeginning" class="btn btn-primary">Submit</button>
                        <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
              </form>
              <?php
                 
                    $Operation -> ctrAddLSORBeginningBalance();
                    ?>
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
 

  $Operation  -> ctrDeleteLSOR();
  
?>


  
