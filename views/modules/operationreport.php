<?php 
 $branch_list = new ControllerPastdue();
 $branch = $branch_list->ctrShowBranches();


  $user_id = $_SESSION['user_id'];
  $branch_name = $_SESSION['branch_name'];
?> 
<style>
</style>
<div class="clearfix"></div>
  
<div class="content-wrapper">
   <div class="container-fluid">
     <div class="row pt-2 pb-2">
        <div class="col-sm-12">
          <h4 class="page-title">OPERATION REPORT</h4>
        </div>
     </div>

      <div class="row">
        <div class="col-lg-12">
        
          <div class="card">
            <div class="card-header float-sm-right">
              <div class="row">
              <!-- <div class="col-sm-2 form-group">
                        <label for="input-6">SELECT MONTH</label>
                        <input type="month" class="form-control dateFrom" id="date"  placeholder="Enter PRR Date"  name="date" autocomplete="nope" >
                </div> -->
                <div class="col-sm-2 form-group">
                        <label for="input-6">FROM</label>
                        <input type="date" class="form-control dateFrom" id="from"  placeholder="Enter PRR Date"  name="from" autocomplete="nope" >
                </div>
                <div class="col-sm-2 form-group">
                        <label for="input-6">TO</label>
                        <input type="date" class="form-control dateFrom" id="to"  placeholder="Enter PRR Date"  name="to" autocomplete="nope" >
                </div>
                 <div class="col-sm-3 form-group">
                 <label   label for="input-6">TYPE</label>
                    <select class="form-control" name="type" id="type" required>
                        <option value=""><  - - SELECT TYPE - - ></option>
                        <option value="grossin">WEEKLY GROSS IN</option>
                        <option value="outgoing">WEEKLY OUTGOING ACCOUNTS</option>
                    </select>
                 </div>   
                <div class="col-sm-2 form-group mt-4">
                <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1 generateOperationReport "><i class="fa fa-print"></i> <span>&nbsp;GENERATE</span> </button>

                </div>
                  
            </div>  
            </div>          
            <div class="card-body">
            <div class="float-right">
                <button type="button" id="printOperationReport" hidden class="btn btn-light btn-round waves-effect waves-light m-1 printOperationReport "><i class="fa fa-print"></i> <span>&nbsp;PRINT</span> </button>
              </div>


              <div id="operationTable" class="table-responsive">
              <table class="table table-bordered table-hover table-striped operationReport">
                
              </table>
            </div>
            </div>
          </div>
        </div>
                
      </div>    <!-- row -->
      
</div>

    <div class="overlay toggle-menu"></div>


  </div>        <!-- container-fluid -->
</div>          <!-- content-wrapper -->