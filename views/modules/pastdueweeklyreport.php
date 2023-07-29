<?php 
 $branch_list = new ControllerPastdue();
 $branch = $branch_list->ctrShowBranches();


  $user_id = $_SESSION['user_id'];
  $branch_name = $_SESSION['branch_name'];
?> 
<style>
  .modal-content {
    width: 1000px;
   
} 
.table thead th{
  font-size:.7rem;
}
.table thead th{
  font-size:.7rem;
}
.table thead th:nth-child(2){
  color:#e57b7a;
}
.table thead th:hover{
  color:#086259;
  background-color:#dae7e6;
}

</style>
<div class="clearfix"></div>
  
<div class="content-wrapper">
   <div class="container-fluid">
     <div class="row pt-2 pb-2">
        <div class="col-sm-12">
          <h4 class="page-title">WEEKLY REPORT</h4>
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
                        <label for="input-6">WEEKLY REPORT FROM</label>
                        <input type="date" class="form-control dateFrom" id="weekfrom"  placeholder="Enter PRR Date"  name="weekfrom" autocomplete="nope" >
                </div>
                <div class="col-sm-2 form-group">
                        <label for="input-6">WEEKLY REPORT TO</label>
                        <input type="date" class="form-control dateFrom" id="weekto"  placeholder="Enter PRR Date"  name="weekto" autocomplete="nope" >
                </div>
                <div class="col-sm-2 form-group mt-4">
                <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1 generateWeeklyReport "><i class="fa fa-print"></i> <span>&nbsp;GENERATE</span> </button>

                </div>
                  
            </div>  
            </div>          
            <div class="card-body">
            <div class="float-right">
                <button type="button" id="printWeeklyCollection" hidden class="btn btn-light btn-round waves-effect waves-light m-1 printWeeklyCollection "><i class="fa fa-print"></i> <span>&nbsp;PRINT</span> </button>
              </div>
              <div id="showWeeklyTable" class="table-responsive">
              <table class="table table-bordered table-hover table-striped weeklyreportTable">
                
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