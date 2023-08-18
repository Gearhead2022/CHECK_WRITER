<?php 

$idClient = $_GET['idClient'];
$LSOR = (new Connection)->connect()->query("SELECT * from op_lsor WHERE id = $idClient")->fetch(PDO::FETCH_ASSOC);
$branch_name = $LSOR['branch_name'];
$date = $LSOR['date'];
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



?>
<div class="clearfix"></div>
	
<div class="content-wrapper">
  <div class="container-fluid">
   <div class="row pt-2 pb-2">
     <div class="col-sm-12">
  	    <h4 class="page-title">ADD LOST SALES OPPORTUNITIES</h4>
     </div>
   </div> 

    <div class="row">
      <div class="col-lg-12">
        <form  method="POST" enctype="multipart/form-data" autocomplete="nope">
          <div class="card">
            <div class="card-body">
                 <div class="row">
                    <div class="col-sm-2 form-group">
                          <label for="input-2">DATE</label>
                          <input type="date" class="form-control" id="input-2" value="<?php echo $date; ?>"  name="date" autocomplete="nope" required>
                          <input type="text" hidden class="form-control" id="input-2"  value="<?php echo $branch_name; ?>"  name="branch_name" autocomplete="nope">
                          <input type="text" hidden class="form-control" id="input-2"  value="<?php echo $idClient; ?>"  name="id" autocomplete="nope">

                      </div>
                      <div class="col-sm-2 form-group">
                          <label for="input-1">FINANCIALLLY STABLE</label>
                          <input type="number" class="form-control" id="input-1" value="<?php echo $fin_stable; ?>"  placeholder="Enter Financially Stable" name="fin_stable" autocomplete="nope" >
                      </div>                   

                      <div class="col-sm-2 form-group">
                          <label for="input-2">APPROVAL WIFE AND CHILDREN</label>
                          <input type="number" class="form-control" id="input-2" value="<?php echo $app_wc; ?>"  placeholder="Enter Approval Wife and Children"  name="app_wc" autocomplete="nope">
                      </div>
                      <div class="col-sm-2 form-group">
                          <label for="input-2">LOW CASH OUT</label>
                          <input type="number" class="form-control" id="input-2" value="<?php echo $low_cashout; ?>"  placeholder="Enter Low Cash Out"  name="low_cashout"  autocomplete="nope">
                      </div>
                      <div class="col-sm-2 form-group">
                          <label for="input-6">GUARDIANSHIP</label>
                          <input type="number" class="form-control" placeholder="Enter Guarduanship" value="<?php echo $guardianship; ?>"   name="guardianship" autocomplete="nope" >
                      </div>
                   
                      <div class="col-sm-2 form-group">
                          <label for="input-6">SSP OVER AGE</label>
                          <input type="number" class="form-control" placeholder="Enter SSP Over Age" value="<?php echo $ssp_overage; ?>"   name="ssp_overage" autocomplete="nope">
                      </div>
                  </div>                                                

                  
                  <div class="row">
                  <div class="col-sm-2 form-group">
                          <label for="input-6">LACK OF REQUIREMENTS</label>
                          <input type="number" class="form-control" placeholder="Enter Lack of Requirements" value="<?php echo $lack_requirements; ?>"   name="lack_requirements" autocomplete="nope">
                      </div>
                      <div class="col-sm-2 form-group">
                          <label for="input-6">UNDECIDED</label>
                          <input type="number" class="form-control" id="ucost"  placeholder="Enter Undecided" value="<?php echo $undecided; ?>"  name="undecided" autocomplete="nope">
                      </div>
                  
                      <div class="col-sm-2 form-group">
                          <label for="input-6">INQUIRED ONLY</label>
                          <input type="number" class="form-control" placeholder="Enter Inquired Only" value="<?php echo $inquired_only; ?>"   name="inquired_only" autocomplete="nope">
                      </div>
                      <div class="col-sm-2 form-group">
                          <label for="input-6">NEW POLICY</label>
                          <input type="number" class="form-control" placeholder="Enter New Policy" value="<?php echo $new_policy; ?>"  name="new_policy" autocomplete="nope">
                      </div>
                      <div class="col-sm-2 form-group">
                          <label for="input-6">PLP</label>
                          <input type="number" class="form-control" placeholder="Enter PLP" value="<?php echo $plp; ?>"   name="plp" autocomplete="nope">
                      </div>
                    
                      <div class="col-sm-2 form-group">
                          <label for="input-6">Scheduled TO APPLY LOAN</label>
                          <input type="number" class="form-control" placeholder="Enter Guardianship" value="<?php echo $sched_applynow; ?>"  name="sched_applynow" autocomplete="nope" >
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-sm-3 form-group">
                          <label for="input-6">NOT IN GOOD CONDITION</label>
                          <input type="number" class="form-control" id="ucost"  placeholder="Enter Nnot in Good Condition" value="<?php echo $not_goodcondition; ?>"  name="not_goodcondition" autocomplete="nope">
                      </div>
                      <div class="col-sm-3 form-group">
                          <label for="input-6">SSP NOT QUALIFIED</label>
                          <input type="number" class="form-control" placeholder="Enter SSP Not Qualified" value="<?php echo $not_qualified; ?>"   name="not_qualified" autocomplete="nope">
                      </div>
                      <div class="col-sm-3 form-group">
                          <label for="input-6">OTHER LENDING SCHED GAWAD</label>
                          <input type="number" class="form-control" placeholder="Enter Lending Sched Gawad"  value="<?php echo $other_sched_gawad; ?>"  name="other_sched_gawad" autocomplete="nope" >
                      </div>
                      <div class="col-sm-3 form-group">
                          <label for="input-6">OTHER LENDING RE-SCHED GAWAD</label>
                          <input type="number" class="form-control" id="ucost"  placeholder="Enter Lending Re-sched Gawad" value="<?php echo $other_resched_gawad; ?>"  name="other_resched_gawad" autocomplete="nope">
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-sm-3 form-group">
                          <label for="input-6">18 MOS SSSS LOAN</label>
                          <input type="number" class="form-control" id="ucost"  placeholder="Enter 18 MOS SSS Loan" value="<?php echo $eighteen_mos_sssloan; ?>"  name="eighteen_mos_sssloan" autocomplete="nope">
                      </div>
                      <div class="col-sm-3 form-group">
                          <label for="input-6">PENSION STILL ON PROGRESS</label>
                          <input type="number" class="form-control" placeholder="Enter Pension Stiil On Progress" value="<?php echo $on_process; ?>"   name="on_process" autocomplete="nope" >
                      </div>
                      <div class="col-sm-3 form-group">
                          <label for="input-6">REFUSE TO TRANSFER ACCOUNT / LOAN</label>
                          <input type="number" class="form-control" placeholder="Enter Refuse To Transfer Account / Loan" value="<?php echo $refuse_transfer; ?>"   name="refuse_transfer" autocomplete="nope" >
                      </div>
                      <div class="col-sm-3 form-group">
                          <label for="input-6">EXISTING LOAN TO OTHER LENDING</label>
                          <input type="number" class="form-control" id="input-6" placeholder="Enter Existing Load To Other Lending" value="<?php echo $existing_loan; ?>"  name="existing_loan" autocomplete="nope" >
                      </div>
                     
                  </div>
            </div>

            <div class="card-footer">
              <div class="row">
                <div class="col-lg-3">
                </div>
                <div class="col-lg-9">
                  <div class="float-sm-right">
                   <button type="submit" name="edit_lsor" class="btn btn-light btn-round px-5"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
                   
                   <button type="button" class="btn btn-light btn-round px-5" onClick="location.href='operationlsor'"><i class="fa fa-list"></i>&nbsp;&nbsp;Listing</button>                           
                  </div>
                </div>
              </div>
            </div>  <!-- footer -->

          </div>    <!-- card -->
        </form>
        <?php
            $addLSOR = new ControllerOperation();
            $addLSOR -> ctrEditLSOR();
            ?>
      </div>
    </div><!--End Row-->

  <div class="overlay toggle-menu"></div>
  </div>    <!-- container-fluid -->
</div>      <!-- content-wrapper -->