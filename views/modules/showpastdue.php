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
 
   if($type =="E"){
     $type_name = "E - 17 Months Below";
   }elseif($type == "S"){
     $type_name = "S - 17 Months Above";
   }
   if($class =="D"){
     $class_name = "D - DECEASED";
   }elseif($class == "F"){
     $class_name = "F - FULLY PAID";
   }elseif($class == "L"){
     $class_name = "L - ";
   }elseif($class == "P"){
     $class_name = "P - POLICE ACTION";
   }elseif($class == "W"){
     $class_name = "W - WRITE OFF";
   }

 

?> 

<div class="clearfix"></div>
<div class="content-wrapper">
  <div class="container-fluid">
   <div class="row pt-2 pb-2">
     <div class="col-sm-12">
  	    <h4 class="page-title">PAST DUE ACCOUNT</h4>
     </div>
   </div> 

    <div class="row">
      <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                        <div class="div-sm-12">
                            <button type="button" class="btn btn-light btn-round px-5"  data-toggle="modal" data-target="#addLedgerModal"><i class="fa fa-plus"></i>&nbsp;&nbsp;ADD LEDGER</button>
                        </div>
                </div>
            <div class="row">
                    <div class="col-sm-2 form-group">
                            <p>ACCOUNT NUMBER</p>
                    </div>
                    <div class="col-sm-1 form-group">
                            <p>:</p>
                    </div>
                    <div class="col-sm-9 form-group">
                            <p><?php echo $account_no ?></p>
                    </div>
                 </div>
                 <div class="row">
                    <div class="col-sm-2 form-group">
                            <p>NAME</p>
                    </div>
                    <div class="col-sm-1 form-group">
                            <p>:</p>
                    </div>
                    <div class="col-sm-9 form-group">
                            <p><?php echo $last_name.", ".$first_name.$middle_name; ?></p>
                    </div>
                 </div>
                 <div class="row">
                    <div class="col-sm-2 form-group">
                            <p>AGE</p>
                    </div>
                    <div class="col-sm-1 form-group">
                            <p>:</p>
                    </div>
                    <div class="col-sm-9 form-group">
                            <p><?php echo $age ?></p>
                    </div>
                 </div>
                 <div class="row">
                    <div class="col-sm-2 form-group">
                            <p>BRANCH</p>
                    </div>
                    <div class="col-sm-1 form-group">
                            <p>:</p>
                    </div>
                    <div class="col-sm-9 form-group">
                            <p><?php echo $branch_name ?></p>
                    </div>
                 </div>
                 <div class="row">
                    <div class="col-sm-2 form-group">
                            <p>ADDRESS</p>
                    </div>
                    <div class="col-sm-1 form-group">
                            <p>:</p>
                    </div>
                    <div class="col-sm-9 form-group">
                            <p><?php echo $address ?></p>
                    </div>
                 </div>
                 <div class="row">
                    <div class="col-sm-2 form-group">
                            <p>BALANCE</p>
                    </div>
                    <div class="col-sm-1 form-group">
                            <p>:</p>
                    </div>
                    <div class="col-sm-9 form-group">
                            <p><?php echo $balance ?></p>
                    </div>
                 </div>
                 <div class="row">
                    <div class="col-sm-2 form-group">
                            <p>BANK</p>
                    </div>
                    <div class="col-sm-1 form-group">
                            <p>:</p>
                    </div>
                    <div class="col-sm-9 form-group">
                        <p><?php echo $bank ?></p>
                    </div>
                 </div>
                 <div class="row">
                    <div class="col-sm-2 form-group">
                            <p>TYPE</p>
                    </div>
                    <div class="col-sm-1 form-group">
                            <p>:</p>
                    </div>
                    <div class="col-sm-9 form-group">
                            <p><?php echo $type ?></p>
                    </div>
                 </div>
                 <div class="row">
                    <div class="col-sm-2 form-group">
                            <p>CLASS</p>
                    </div>
                    <div class="col-sm-1 form-group">
                            <p>:</p>
                    </div>
                    <div class="col-sm-9 form-group">
                            <p><?php echo $class ?></p>
                    </div>
                 </div>
                 <div class="row">
                    <div class="col-sm-2 form-group">
                            <p>ENDORSED DATE</p>
                    </div>
                    <div class="col-sm-1 form-group">
                            <p>:</p>
                    </div>
                    <div class="col-sm-9 form-group">
                            <p><?php echo $refdate; ?></p>
                    </div>
                 </div>
                </div>
            <div class="card-footer">
              <div class="row">
                <div class="col-lg-3">
                </div>
                <div class="col-lg-9">
                  <div class="float-sm-right">
                  <button type="button" class="btn btn-light btn-round px-5 viewLedger" account_no="<?php echo $account_no; ?>" id="<?php echo $idClient; ?>" ><i class="fa fa-eye"></i>&nbsp;&nbsp;View Ledger</button> 
                   <button type="button" class="btn btn-light btn-round px-5" onClick="location.href='pastdue'"><i class="fa fa-list"></i>&nbsp;&nbsp;Listing</button>                           
                  </div>
                </div>
              </div>
              
            </div>  <!-- footer -->

          </div>  
       
      </div>
    </div><!--End Row-->

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
                        <input type="text" class="form-control amount"  id="amount" placeholder="Enter Amount" name="amount" autocomplete="nope" required>
                    </div>  
                </div>
                <div class="row">
                  <div class="col-sm-6 form-group">
                    <input type="checkbox"  id="pay_mis" name="pay_mis" autocomplete="nope">
                    <label for="pay_mis">MISCELLANEOUS</label>
                  </div>
                  <div class="col-sm-6 form-group" id="include_week1" hidden>
                    <input type="checkbox"  id="include_week" name="include_week" autocomplete="nope">
                    <label for="pay_mis">INCLUDE IN WEEKLY</label>
                  </div>
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


  <div class="overlay toggle-menu"></div>
  </div>    <!-- container-fluid -->
</div>      <!-- content-wrapper -->

