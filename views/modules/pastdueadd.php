<style>
    textarea#wp_req_for {
    height: 100px;
}
input[type="text"] {
      text-transform: uppercase;
    }
</style>
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
<div class="clearfix"></div>
	
<div class="content-wrapper">
  <div class="container-fluid">
   <div class="row pt-2 pb-2">
     <div class="col-sm-12">
  	    <h4 class="page-title">ADD PAST DUE ACCOUNT</h4>
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
                    <input type="text"   class="form-control" id="last_name" placeholder="Enter Last Name" name="last_name" autocomplete="nope" required >
                    <input type="text" hidden   value="<?php echo $id_holder; ?>" class="form-control" id="due_id"  name="due_id" autocomplete="nope" >
                    <input type="text" hidden  value="<?php echo $user_id; ?>" class="form-control" id="user_id"  name="user_id" autocomplete="nope" >
                </div>
                <div class="col-sm-3 form-group">
                        <label for="input-1">FIRST NAME </label>
                        <input type="text" class="form-control" id="first_name" placeholder="Enter First Name" name="first_name" autocomplete="nope" required>
                    </div> 
                    <div class="col-sm-2 form-group">
                        <label for="input-1">MIDDLE INITIAL </label>
                        <input type="text" class="form-control" id="middle_name" placeholder="Enter Middle Initial" name="middle_name" autocomplete="nope">
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
                
                    </div>   
                </div>
            

            <div class="row"> 
                <div class="col-sm-2 form-group">
                <label for="input-1">ACCOUNT NUMBER</label>
                    <input type="text"   class="form-control" id="account_no" placeholder="Enter Account Number" name="account_no" autocomplete="nope" required>
                </div>
                <div class="col-sm-2 form-group">
                        <label for="input-1">AGE</label>
                        <input type="text" class="form-control" id="age" placeholder="Enter Age" name="age" autocomplete="nope" required>
                    </div> 
                <!-- <div class="col-sm-2 form-group">
                    <label for="input-1">STATUS</label>
                    <input type="text" class="form-control" id="status" placeholder="Enter Status" name="status" autocomplete="nope">
                </div>  -->
                    <div class="col-sm-8 form-group">
                        <label for="input-1">ADDRESS</label>
                        <input type="text" class="form-control" id="address" placeholder="Enter Address" name="address" autocomplete="nope" required>
                    </div>   
            </div>
             
            <div class="row">
                <div class="col-sm-2 form-group">
                   <label for="input-1">BALANCE</label>
                    <input type="text" class="form-control" id="balance" placeholder="Enter Balance" name="balance" autocomplete="nope">
                </div>   
                 
                <div class="col-sm-3 form-group">
                      <label   label for="input-6">TYPE</label>
                    <select class="form-control" name="type" id="type" required>
                      <option value=""><  - - SELECT TYPE - - ></option>
                      <option value="E">E - 17 Months Above</option>
                      <option value="S">S - 17 Months Below</option>
                    </select>
                </div> 
                <div class="col-sm-3 form-group">
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
                <div class="col-sm-2 form-group">
                   <label for="input-1">BANK</label>
                    <input type="text" class="form-control" id="bank" placeholder="Enter Bank" name="bank" autocomplete="nope" required>
                </div>   
                <div class="col-sm-2 form-group">
                   <label for="input-1">ENDORSED DATE</label>
                    <input type="date" class="form-control" id="refdate" placeholder="Enter Branch / Department" name="refdate" autocomplete="nope" required>
                </div> 
                  
            </div>   
           
                                                        
            <div class="card-footer">
              <div class="row">
                <div class="col-lg-3">
                </div>
                <div class="col-lg-9">
                  <div class="float-sm-right">
                   <button type="submit" name="addPastDueAccount" class="btn btn-light btn-round px-5"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
                   
                   <button type="button" class="btn btn-light btn-round px-5" onClick="location.href='pastdue'"><i class="fa fa-list"></i>&nbsp;&nbsp;Listing</button>                           
                  </div>
                </div>
              </div>
            </div>  <!-- footer -->

          </div>    <!-- card -->
        </form>

        <?php
                    $addPastDue = new ControllerPastdue();
                    $addPastDue -> ctrAddPastDueAccounts();
                    ?>
      </div>
    </div><!--End Row-->

  <div class="overlay toggle-menu"></div>
  </div>    <!-- container-fluid -->
</div>      <!-- content-wrapper -->