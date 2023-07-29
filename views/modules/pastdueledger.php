<?php 
 $branch_list = new ControllerPastdue();
 $branch = $branch_list->ctrShowBranches();


 $permit = (new Connection)->connect()->query("SELECT * from past_due ORDER BY id Desc limit 1")->fetch(PDO::FETCH_ASSOC);
          if(empty($permit)){
            $id = 0;
          }else{
            $id = $permit['id'];
          }
         $last_id = $id + 1;
          $id_holder = "PD" . str_repeat("0",5-strlen($last_id)).$last_id;     

          date_default_timezone_set('Asia/Manila');
		      $date_now =date("F d Y"); 

          $user_id = $_SESSION['user_id'];
          $branch_name = $_SESSION['branch_name'];
?> 
<style>
  .modal-content {
    width: 1000px;
   
} 

</style>
<div class="clearfix"></div>
  
<div class="content-wrapper">
   <div class="container-fluid">
     <div class="row pt-2 pb-2">    
        <div class="col-sm-12">
          <h4 class="page-title">PAST DUE LEDGER</h4>
        </div>
     </div>

      <div class="row">
        <div class="col-lg-12">
        
          <div class="card">
            <div class="card-header float-sm-right">
              <div class="row">
                <?php if($_SESSION['type']=="admin" || $_SESSION['type']=="pastdue_user" || $_SESSION['type']=="backup_admin"){?>
                    <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1" data-toggle="modal" data-target="#exampleModalCenter"><i class="fa fa-plus"></i> <span>&nbsp;ADD DATABASE</span> </button>
                  <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1" data-toggle="modal" data-target="#ledgerModal"><i class="fa fa-book"></i> <span>&nbsp;ADD LEDGER</span> </button>
                  <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1" onClick="location.href='pastdueadd'"><i class="fa fa-user-plus"></i></i> <span>&nbsp;ADD ACCOUNTS</span> </button>
                  <button type="button" id="showPrint"  class="btn btn-light btn-round waves-effect waves-light m-1" onClick="location.href='pastduetarget'"><i class="fa fa-plus-circle"></i> <span>&nbsp;BRANCH TARGETS</span> </button>
                  <button type="button" id="showPrint"  class="btn btn-light btn-round waves-effect waves-light m-1" onClick="location.href='pastdueweeklyreport'"><i class="fa fa-print"></i> <span>&nbsp;GENERATE REPORTS</span> </button>
                  <button type="button" id="showPrint"  class="btn btn-light btn-round waves-effect waves-light m-1" onClick="location.href='pastdueclassreport'"><i class="fa fa-print"></i> <span>&nbsp;CLASS REPORT</span> </button>
                  <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1 pastdueChecker"><i class="fa fa-print"></i> <span>&nbsp;CHECKER</span> </button>
                  <button type="button" id="showPrint"  class="btn btn-light btn-round waves-effect waves-light m-1" onClick="location.href='pastdueledger'"><i class="fa fa-print"></i> <span>&nbsp;LEDGER</span> </button>


              <?php  }?>
              
                 
            </div>            
            <div class="card-body">
              <div class="table-responsive">
              <table id="default-datatable" class="table table-bordered table-hover table-striped pastdueledgerTable">
                <thead>
                <tr>
                  <th>ACCOUNT NUMBER</th>
                  <th>BRANCH NAME</th>
                  <th>DATE</th>
                  <th>REFERENCE NUMBER</th>
                  <th>DEBIT</th>
                  <th>CREDIT</th>
                  <th>ACTIONS</th>
                </tr>
                </thead>
              </table>
            </div>
            </div>
          </div>
        </div>
                
      </div>    <!-- row -->
      <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
             <div class="modal-content">
                <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLongTitle">ADD DATABASE</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                <form  method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-sm-12 form-group">
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
                
                    </div>   
            </div> 
                <div class="row">
                    <div class="col-sm-12 form-group">
                        <input type="text" hidden name="id" id="id" value="<?php echo $id; ?>">
                        <input type="text" hidden name="user_id" id="user_id" value="<?php echo $user_id; ?>">
                        <label for="input-6">DATABASE FILES</label>
                        <input type="file" class="form-control" id="file" placeholder="Enter Folder Name" name="file" value="Import">
                    </div>   
            </div> 
                </div>
                <div class="modal-footer">
                        <button type="submit" name ="addPastDue" class="btn btn-primary">Submit</button>
                        <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
              </form>
              <?php
                     $addPastDue = new ControllerPastdue();
                     $addPastDue -> addPastDueRecords();
                    ?>
           </div>
        </div>
     <!-- LEDGER MODAL -->
     <div class="modal fade" id="ledgerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
             <div class="modal-content">
                <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLongTitle">ADD LEDGER</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                <form  method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-sm-12 form-group">
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
                
                    </div>   
            </div> 
                <div class="row">
                    <div class="col-sm-12 form-group">
                        <input type="text" hidden name="user_id" id="user_id" value="<?php echo $user_id; ?>">
                        <label for="input-6">LEDGER FILES</label>
                        <input type="file" class="form-control" id="file" placeholder="Enter Folder Name" name="file" value="Import">
                    </div>   
            </div> 
                </div>
                <div class="modal-footer">
                        <button type="submit" name ="addLedger" class="btn btn-primary">Submit</button>
                        <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
              </form>
              <?php
                     $addLedger = new ControllerPastdue();
                     $addLedger -> addLedgerRecord();
                    ?>
           </div>
        </div>
     <!-- END LEDGER MODAL -->
     <!-- EDIT LEDGER MODAL -->

        <div class="modal fade" id="editLedgerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">ADD LEDGER</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                    <form  method="post">
                    <div class="modal-body">
                    
                    </div>
                    <div class="modal-footer">
                            <button type="submit" name ="editLedgerAccount" class="btn btn-primary">Submit</button>
                            <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
                </form>
                <?php
                        $addLedger = new ControllerPastdue();
                        $addLedger -> ctrEditLedger();
                        ?>
            </div>
            </div>

            <!-- END EDIT LEDGER MODAL -->

       
</div>

    <div class="overlay toggle-menu"></div>


  </div>        <!-- container-fluid -->
</div>          <!-- content-wrapper -->

<?php
 
  $deletePastDue = new ControllerPastdue();
  $deletePastDue  -> ctrDeletePastdue();
  
?>