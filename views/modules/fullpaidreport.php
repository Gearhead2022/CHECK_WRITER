
<style>
  .modal-content {
    width: 1000px;
    margin-left: -221px;
}
</style>
<div class="clearfix"></div>
  
<div class="content-wrapper">
   <div class="container-fluid">
     <div class="row pt-2 pb-2">
        <div class="col-sm-12">
          <h4 class="page-title">FULLY PAID REPORTS</h4>
        </div>
     </div>

      <div class="row">
        <div class="col-lg-12">
        
          <div class="card">
            <div class="card-header float-sm-right">
              <div class="row">
              <div class="col-sm-2 form-group">
                        <label for="input-6">FROM</label>
                        <input type="date" class="form-control dateFrom" id="dateFrom"  placeholder="Enter PRR Date"  name="dateFrom" autocomplete="nope" >
                </div>
                <div class="col-sm-2 form-group">
                        <label for="input-6">TO</label>
                        <input type="date" class="form-control dateTo" id="dateTo"  placeholder="Enter PRR Date"  name="dateTo" autocomplete="nope">
                </div>


                  <div class="col-sm-2 form-group">
                  
                    <label for="input-6">Status</label>
                      <select class="form-control reportStatus" id="reportStatus" name="clientCategory">
                        <option value="" >&lt;Select Status&gt;</option>
                        <option value="Claimed">Claimed</option>
                        <option value="Unclaimed">Unclaimed</option>
                      </select>
 
                      <!-- <div class="input-group-append">
                        <button class="btn btn-light" type="button" id="clrCategory"><i class="fa fa-undo"></i> </button>
                      </div>   -->
                    </div>
                    <div class="col-sm-2 form-group mt-4">
                        
                    <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1 generateReport "><i class="fa fa-print"></i> <span>&nbsp;GENERATE</span> </button>
                    </div>
              </div>
            </div>            

            <div class="card-body">
              <div class="float-right">
                <button type="button" id="showPrint" hidden class="btn btn-light btn-round waves-effect waves-light m-1 showPrint1 "><i class="fa fa-print"></i> <span>&nbsp;PRINT</span> </button>
              </div>
            <div id="showTable" class="table-responsive" hidden>
            <table class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>OUT DATE</th>
                        <th>BANK</th>
                        <th>ATM STATUS</th>
                        <th>DATE Claimed</th>
                        <th>REMARKS</th>
                        </tr>
                    </thead>
                    <tbody class="reportTable">
                        
                    </tbody>
            </table>
              
            </div>
            <div class="card-footer">
              <div class="row">
                <div class="col-lg-3">
                </div>
                <div class="col-lg-9">
                  <div class="float-sm-right">
                   <button type="button" class="btn btn-light btn-round px-5" onClick="location.href='fullypaid'"><i class="fa fa-list"></i>&nbsp;&nbsp;Listing</button>                           
                  </div>
                </div>
              </div>
            </div>
            </div>
          </div>

        </div>
      </div>    <!-- row -->
</div>

    <div class="overlay toggle-menu"></div>


  </div>        <!-- container-fluid -->
</div>          <!-- content-wrapper -->

<?php
  $deleteRecord = new ControllerFullypaid();
  $deleteRecord  -> ctrDeleteRecord();
 
?>