<?php 


$branch_list = new ControllerPastdue();
$branch = $branch_list->ctrShowBranches();
?>
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
          <h4 class="page-title">PAST DUE REPORTS</h4>
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


                  <div class="col-sm-3 form-group">
                  
                  <label   label for="input-6">BRANCH NAME</label>
                      <select class="form-control" name="branch_name" id="branch_name" required>
                            <option value=""><  - - SELECT BRANCHES - - ></option>
                            <?php
                              foreach ($branch as $key => $row) {
                                # code...
                                $full_name = $row['full_name'];
                            ?>
                            <option value="<?php echo $full_name;?>"><?php echo $full_name;?></option>
                          <?php } ?>
                      </select>
                      <!-- <div class="input-group-append">
                        <button class="btn btn-light" type="button" id="clrCategory"><i class="fa fa-undo"></i> </button>
                      </div>   -->
                    </div>
                    <div class="col-sm-2 form-group">
                      <label   label for="input-6">CLASS</label>
                    <select class="form-control" name="class" id="class" required>
                      <option value=""><  - - SELECT CLASS - - ></option>
                      <option value="D">D - DECEASED</option>
                      <option value="F">F - FULLY PAID</option>
                      <option value="L">L - LITIGATION</option>
                      <option value="P">P - POLICE ACTION</option>
                      <option value="W">W - WRITE OFF</option>
                    </select>
                </div>
                    <div class="col-sm-2 form-group mt-4">
                        
                    <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1 generateClassReport"><i class="fa fa-print"></i> <span>&nbsp;GENERATE</span> </button>
                    </div>
              </div>
            </div>            

            <div class="card-body">
              <div class="float-right">
                <button type="button" id="showPrintClass" hidden class="btn btn-light btn-round waves-effect waves-light m-1 printPastDueClassReport "><i class="fa fa-print"></i> <span>&nbsp;PRINT</span> </button>
              </div>
            <div id="showTableClassReport" class="table-responsive" hidden>
            <table class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                        <th>NO.</th>
                        <th>NAME</th>
                        <th>TYPE</th>
                        <th>ACCT#</th>
                        <th>BANK</th>
                        <th>ENDORSED</th>
                        <th>ORIG. BAL.</th>
                        <th>PREV. BAL.</th>
                        <th>DEBIT</th>
                        <th>CREDIT</th>
                        <th>OUTS. BAL.</th>
                     </tr>
                    </thead>
                    <tbody class="reportClassTable">
                        
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
</div>    

<!-- content-wrapper --> 

<?php
  $deleteRecord = new ControllerFullypaid();
  $deleteRecord  -> ctrDeleteRecord();
 
?>