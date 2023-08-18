<?php 
$branch_name = $_SESSION['branch_name'];



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
                          <input type="date" class="form-control" id="input-2"  name="date" autocomplete="nope" required>
                          <input type="text" class="form-control" id="input-2" hidden value="<?php echo $branch_name; ?>"  name="branch_name" autocomplete="nope">

                      </div>
                      <div class="col-sm-2 form-group">
                          <label for="input-1">FINANCIALLLY STABLE</label>
                          <input type="number" class="form-control" id="input-1" placeholder="Enter Financially Stable" name="fin_stable" autocomplete="nope" >
                      </div>                   

                      <div class="col-sm-2 form-group">
                          <label for="input-2">APPROVAL WIFE AND CHILDREN</label>
                          <input type="number" class="form-control" id="input-2" placeholder="Enter Approval Wife and Children"  name="app_wc" autocomplete="nope">
                      </div>
                      <div class="col-sm-2 form-group">
                          <label for="input-2">LOW CASH OUT</label>
                          <input type="number" class="form-control" id="input-2" placeholder="Enter Low Cash Out"  name="low_cashout"  autocomplete="nope">
                      </div>
                      <div class="col-sm-2 form-group">
                          <label for="input-6">GUARDIANSHIP</label>
                          <input type="number" class="form-control" placeholder="Enter Guarduanship"  name="guardianship" autocomplete="nope" >
                      </div>
                   
                      <div class="col-sm-2 form-group">
                          <label for="input-6">SSP OVER AGE</label>
                          <input type="number" class="form-control" placeholder="Enter SSP Over Age"  name="ssp_overage" autocomplete="nope">
                      </div>
                  </div>                                                

                  
                  <div class="row">
                  <div class="col-sm-2 form-group">
                          <label for="input-6">LACK OF REQUIREMENTS</label>
                          <input type="number" class="form-control" placeholder="Enter Lack of Requirements"  name="lack_requirements" autocomplete="nope">
                      </div>
                      <div class="col-sm-2 form-group">
                          <label for="input-6">UNDECIDED</label>
                          <input type="number" class="form-control" id="ucost"  placeholder="Enter Undecided" name="undecided" autocomplete="nope">
                      </div>
                  
                      <div class="col-sm-2 form-group">
                          <label for="input-6">INQUIRED ONLY</label>
                          <input type="number" class="form-control" placeholder="Enter Inquired Only"  name="inquired_only" autocomplete="nope">
                      </div>
                      <div class="col-sm-2 form-group">
                          <label for="input-6">NEW POLICY</label>
                          <input type="number" class="form-control" placeholder="Enter New Policy"  name="new_policy" autocomplete="nope">
                      </div>
                      <div class="col-sm-2 form-group">
                          <label for="input-6">PLP</label>
                          <input type="number" class="form-control" placeholder="Enter PLP"  name="plp" autocomplete="nope">
                      </div>
                    
                      <div class="col-sm-2 form-group">
                          <label for="input-6">Scheduled TO APPLY LOAN</label>
                          <input type="number" class="form-control" placeholder="Enter Guardianship"  name="sched_applynow" autocomplete="nope" >
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-sm-3 form-group">
                          <label for="input-6">NOT IN GOOD CONDITION</label>
                          <input type="number" class="form-control" id="ucost"  placeholder="Enter Nnot in Good Condition" name="not_goodcondition" autocomplete="nope">
                      </div>
                      <div class="col-sm-3 form-group">
                          <label for="input-6">SSP NOT QUALIFIED</label>
                          <input type="number" class="form-control" placeholder="Enter SSP Not Qualified"  name="not_qualified" autocomplete="nope">
                      </div>
                      <div class="col-sm-3 form-group">
                          <label for="input-6">OTHER LENDING SCHED GAWAD</label>
                          <input type="number" class="form-control" placeholder="Enter Lending Sched Gawad"  name="other_sched_gawad" autocomplete="nope" >
                      </div>
                      <div class="col-sm-3 form-group">
                          <label for="input-6">OTHER LENDING RE-SCHED GAWAD</label>
                          <input type="number" class="form-control" id="ucost"  placeholder="Enter Lending Re-sched Gawad" name="other_resched_gawad" autocomplete="nope">
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-sm-3 form-group">
                          <label for="input-6">18 MOS SSSS LOAN</label>
                          <input type="number" class="form-control" id="ucost"  placeholder="Enter 18 MOS SSS Loan" name="eighteen_mos_sssloan" autocomplete="nope">
                      </div>
                      <div class="col-sm-3 form-group">
                          <label for="input-6">PENSION STILL ON PROGRESS</label>
                          <input type="number" class="form-control" placeholder="Enter Pension Stiil On Progress"  name="on_process" autocomplete="nope" >
                      </div>
                      <div class="col-sm-3 form-group">
                          <label for="input-6">REFUSE TO TRANSFER ACCOUNT / LOAN</label>
                          <input type="number" class="form-control" placeholder="Enter Refuse To Transfer Account / Loan"  name="refuse_transfer" autocomplete="nope" >
                      </div>
                      <div class="col-sm-3 form-group">
                          <label for="input-6">EXISTING LOAN TO OTHER LENDING</label>
                          <input type="number" class="form-control" id="input-6" placeholder="Enter Existing Load To Other Lending" name="existing_loan" autocomplete="nope" >
                      </div>
                     
                  </div>
            </div>

            <div class="card-footer">
              <div class="row">
                <div class="col-lg-3">
                </div>
                <div class="col-lg-9">
                  <div class="float-sm-right">
                   <button type="submit" name="add_lsor" class="btn btn-light btn-round px-5"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
                   
                   <button type="button" class="btn btn-light btn-round px-5" onClick="location.href='operationlsor'"><i class="fa fa-list"></i>&nbsp;&nbsp;Listing</button>                           
                  </div>
                </div>
              </div>
            </div>  <!-- footer -->

          </div>    <!-- card -->
        </form>

        <?php
                    $addLSOR = new ControllerOperation();
                    $addLSOR -> ctrAddLSOR();
                    ?>
      </div>
    </div><!--End Row-->

  <div class="overlay toggle-menu"></div>
  </div>    <!-- container-fluid -->
</div>      <!-- content-wrapper -->