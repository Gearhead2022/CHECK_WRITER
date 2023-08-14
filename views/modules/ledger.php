
<?php 
   $idClient = $_GET['idClient'];
   date_default_timezone_set('Asia/Manila');
   $date_now =date("Y-m-d"); 
 $pasdue = (new Connection)->connect()->query("SELECT * FROM past_due WHERE id = $idClient")->fetch(PDO::FETCH_ASSOC);
 
 $last_name = $pasdue['last_name'];
 $first_name = $pasdue['first_name'];
 $middle_name = $pasdue['middle_name'];
 $account_no = $pasdue['account_no'];
 $age = $pasdue['age'];
 $status = $pasdue['status'];
 $address = $pasdue['address'];
 $balance = $pasdue['balance'];
 $type = $pasdue['type'];
 $class = $pasdue['class'];
 $bank = $pasdue['bank'];
 $refdate = $pasdue['refdate'];
 $user_id = $pasdue['user_id'];
 $branch_name = $pasdue['branch_name'];
 $class_name ="";
 $type_name ="";
      
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
          <h4 class="page-title">LEDGER</h4>
        </div>
     </div>
 
      <div class="row">
        <div class="col-lg-12">
        
          <div class="card">
            <div class="card-header float-sm-right">
              <div class="row">
                <?php if($_SESSION['type']=="admin" || $_SESSION['type']=="pastdue_user" || $_SESSION['type']=="backup_admin"){?>
                    <button type="button"  class="btn btn-light btn-round waves-effect waves-light m-1"   data-toggle="modal" data-target="#addLedgerModal"><i class="fa fa-plus"></i>&nbsp;&nbsp;ADD LEDGER</button>
                    <button type="button" id="showPrint"  class="btn btn-light btn-round waves-effect waves-light m-1 printLedger " account_no="<?php echo $account_no;?>" branch_name="<?php echo $branch_name;?>" ><i class="fa fa-print"></i> <span>&nbsp;PRINT</span> </button>

              <?php  }?>
              </div>


                  <div class="col-sm-2 form-group" style="padding-top: 10px;margin-bottom: 6px;">
              </div>
            </div>            
            <div class="card-body">
              <div class="table-responsive">
              <table id="default-datatable" class="table table-bordered table-hover table-striped ledgerTable" idClient="<?php echo $idClient; ?>" >
                <thead>
                <tr>
                  <th>ACCOUNT NUMBER</th>
                  <th>DATE</th>
                  <th>REFFERENCE NUMBER</th>
                  <th>DEBIT</th>
                  <th>CREDIT</th>
                  <th>Action</th>
                </tr>
                </thead>
              </table>
            </div>
            </div>
          </div>

          <div class="card-footer">
              <div class="row">
                <div class="col-lg-3">
                </div>
                <div class="col-lg-9">
                  <div class="float-sm-right">
                   <button type="button" class="btn btn-light btn-round px-5" onclick="goBack()" ><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;BACK</button>  
                   <button type="button" class="btn btn-light btn-round px-5" onClick="location.href='pastdue'"><i class="fa fa-list"></i>&nbsp;&nbsp;Listing</button>                           
                         
                  </div>
                </div>
              </div>
            </div>
        </div>
                 
      </div>    <!-- row -->
      <div class="modal fade" id="addLedgerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label for="input-6">ACCOUNT NUMBER</label>
                        <input type="text" class="form-control" id="account_no" readonly value="<?php echo $account_no; ?>" placeholder="Enter Account Number" name="account_no" autocomplete="nope" required>
                        <input type="text" class="form-control" id="user_id" hidden value="<?php echo $user_id; ?>" placeholder="Enter Account Number" name="user_id" autocomplete="nope" required>
                        <input type="text" class="form-control" id="branch_name" hidden value="<?php echo $branch_name; ?>" placeholder="Enter Account Number" name="branch_name" autocomplete="nope" required>
                    </div>   
                    <div class="col-sm-6 form-group">
                        <label for="input-6">DATE</label>
                        <input type="date" class="form-control" id="date" value="<?php echo $date_now; ?>" placeholder="Enter Folder Name" name="date" autocomplete="nope" required>
                    </div>  
                </div>
                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label for="input-6">REFFERENCE NUMBER</label>
                        <input type="text" class="form-control" id="refno" placeholder="Enter Refference Number" name="refno" autocomplete="nope" required>
                    </div>   
                    <div class="col-sm-6 form-group">
                        <label for="input-6">AMOUNT</label>
                        <input type="text" class="form-control amount" id="amount" placeholder="Enter Amount" name="amount" autocomplete="nope" required>
                    </div>  
                </div>
                <div class="row">
                  <div class="col-sm-6 form-group">
                    <input type="checkbox" class="pay_mis" id="pay_mis" name="pay_mis" autocomplete="nope">
                    <label for="pay_mis">MISCELLANEOUS</label>
                  </div>
                  <div class="col-sm-6 form-group" id="include_week1" hidden>
                    <input type="checkbox"  id="include_week" name="include_week" autocomplete="nope">
                    <label for="pay_mis">INCLUDE IN WEEKLY</label>
                  </div>
                </div>
                <div class="modal-footer">
                        <button type="submit" name ="addLedgerAccount" class="btn btn-primary">Submit</button>
                        <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
              </form>
              <?php
                     $addLedger = new ControllerPastdue();
                    $addLedger -> ctrAddLedger();
                    ?>
           </div>
        </div>

       
</div>

<div class="modal fade" id="editLedgerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
             <div class="modal-content">
                <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLongTitle">EDIT LEDGER</h5>
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

    <div class="overlay toggle-menu"></div>
    <?php
                     $addLedger = new ControllerPastdue();
                     $addLedger -> ctrDeleteLedger();
                    ?>

  </div>        <!-- container-fluid -->
</div>          <!-- content-wrapper -->




  
