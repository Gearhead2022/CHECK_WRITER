<style>
    textarea#wp_req_for {
    height: 100px;
}input[type="text"] {
      text-transform: uppercase;
    }
</style>
<?php 
$branch_list = new ControllerPastdue();
$branch = $branch_list->ctrShowBranches();
  $idClient = $_GET['idClient'];
  date_default_timezone_set('Asia/Manila');
  $date_now =date("F d Y"); 

  $pasdue = (new Connection)->connect()->query("SELECT * FROM past_due WHERE id = $idClient")->fetch(PDO::FETCH_ASSOC);

  $last_name = $pasdue['last_name'];
  $first_name = $pasdue['first_name'];
  $middle_name = $pasdue['middle_name'];
  $branch_name = $pasdue['branch_name'];
  $account_no = $pasdue['account_no'];
  $age = $pasdue['age'];
  $status = $pasdue['status'];
  $address = $pasdue['address'];
  $balance = $pasdue['balance'];
  $type = $pasdue['type'];
  $class = $pasdue['class'];
  $bank = $pasdue['bank'];
  $refdate = $pasdue['refdate'];
  $date_change = $pasdue['date_change'];

  if($date_change !=""){
    $hidden = "";
  }else{
    $hidden = "hidden";

  }
 
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
  	    <h4 class="page-title">EDIT PAST DUE ACCOUNT</h4>
     </div>
   </div> 
    <div class="row">
      <div class="col-lg-12">
        <form  method="POST" enctype="multipart/form-data" >   
          <div class="card">
            <div class="card-body">
             <div class="row"> 
                <div class="col-sm-4 form-group">
                <label for="input-1">LAST NAME </label>
                    <input type="text"   class="form-control" id="last_name" value="<?php echo $last_name; ?>" placeholder="Enter Last Name" name="last_name" autocomplete="nope" required>
                    <input type="text" hidden   value="<?php echo $idClient; ?>" class="form-control" id="id"  name="id" autocomplete="nope" >

                </div>
                <div class="col-sm-3 form-group">
                        <label for="input-1">FIRST NAME </label>
                        <input type="text" class="form-control" id="first_name" value="<?php echo $first_name; ?>" placeholder="Enter First Name" name="first_name" autocomplete="nope" required>
                    </div> 
                    <div class="col-sm-2 form-group">
                        <label for="input-1">MIDDLE INITIAL </label>
                        <input type="text" class="form-control" id="middle_name" value="<?php echo $middle_name; ?>" placeholder="Enter Middle Initial" name="middle_name" autocomplete="nope">
                    </div>   
                    <div class="col-sm-3 form-group">
                    <label   label for="input-6">BRANCH NAME</label>
                      <select class="form-control" name="branch_name" id="branch_name" required>
                            <option value="<?php echo $branch_name;?>"><?php echo $branch_name;?></option>
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
                <div class="col-sm-2 form-group">
                <label for="input-1">ACCOUNT NUMBER</label>
                    <input type="text"  readonly class="form-control" id="account_no" value="<?php echo $account_no; ?>" placeholder="Enter Account Number" name="account_no" autocomplete="nope" >
                </div>
                <div class="col-sm-2 form-group">
                        <label for="input-1">AGE</label>
                        <input type="text" class="form-control" id="age" value="<?php echo $age; ?>" placeholder="Enter Age" name="age" autocomplete="nope" required>
                    </div> 
                <!-- <div class="col-sm-2 form-group">
                    <label for="input-1">STATUS</label>
                    <input type="text" class="form-control" id="status" value="<?php echo $status; ?>" placeholder="Enter Status" name="status" autocomplete="nope" required>
                </div>  -->
                    <div class="col-sm-8 form-group">
                        <label for="input-1">ADDRESS</label>
                        <input type="text" class="form-control" id="address" value="<?php echo $address; ?>" placeholder="Enter Address" name="address" autocomplete="nope" required>
                    </div>   
            </div>
             
            <div class="row">
                <div class="col-sm-2 form-group">
                   <label for="input-1">BALANCE</label>
                    <input type="text" class="form-control" id="balance" value="<?php echo $balance; ?>"  placeholder="Enter Balance" name="balance" autocomplete="nope">
                </div>   
                 
                <div class="col-sm-3 form-group">
                      <label   label for="input-6">TYPE</label>
                    <select class="form-control" name="type" id="type">
                      <option value="<?php echo $type; ?>"><?php echo $type_name; ?></option>
                      <option value="E">E - 17 Months Below</option>
                      <option value="S">S - 17 Months Above</option>
                    </select>
                </div> 
                <div class="col-sm-3 form-group">
                      <label   label for="input-6">CLASS</label>
                    <select class="form-control class" name="class" id="class">
                      <option value="<?php echo $class; ?>"><?php echo $class_name; ?></option>
                      <option value="D">D - DECEASED</option>
                      <option value="F">F - FULLY PAID</option>
                      <option value="L">L - LITIGATION</option>
                      <option value="P">P - POLICE ACTION</option>
                      <option value="W">W - WRITE OFF</option>
                    </select>
                </div>
                <div class="col-sm-2 form-group">
                   <label for="input-1">BANK</label>
                    <input type="text" class="form-control" id="bank" value="<?php echo $bank; ?>" placeholder="Enter Bank" name="bank" autocomplete="nope" required>
                </div>   
                <div class="col-sm-2 form-group">
                   <label for="input-1">ENDORSED DATE</label>
                    <input type="date" class="form-control" value="<?php echo $refdate; ?>" id="refdate" placeholder="Enter Branch / Department" name="refdate" autocomplete="nope" required>
                </div> 
            </div>   
            <div class="row dateChange" <?php echo $hidden; ?> id="dateChange"> 
              <div class="col-sm-5">
              </div>
                <div class="col-sm-3 form-group">
                <label for="input-1">DATE CHANGE</label>
                    <input type="date"   class="form-control" id="date_change" value="<?php echo $date_change; ?>"  placeholder="Enter Account Number" name="date_change" autocomplete="nope" >
                </div>
            </div>
           
                                                        
            <div class="card-footer">
              <div class="row">
                <div class="col-lg-3">
                </div>
                <div class="col-lg-9">
                  <div class="float-sm-right">
                   <button type="submit" name="editPastDueAccount" class="btn btn-light btn-round px-5"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
                   
                   <button type="button" class="btn btn-light btn-round px-5" onClick="location.href='pastdue'"><i class="fa fa-list"></i>&nbsp;&nbsp;Listing</button>                           
                  </div>
                </div>
              </div>
            </div>  <!-- footer -->

          </div>    <!-- card -->
        </form>

        <?php
                    $editPastDue = new ControllerPastdue();
                    $editPastDue -> ctrEditPastDueAccounts();
                    ?>
      </div>
    </div><!--End Row-->

  <div class="overlay toggle-menu"></div>
  </div>    <!-- container-fluid -->
</div>      <!-- content-wrapper -->