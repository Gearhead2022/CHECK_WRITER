<?php
$request = (new Connection)->connect()->query("SELECT * from accounts ORDER BY id Desc limit 1")->fetch(PDO::FETCH_ASSOC);
if(empty($request)){
  $id = 0;
}else{
  $id = $request['id'];
}
$last_id = $id + 1;
$id_holder = "UI" . str_repeat("0",5-strlen($last_id)).$last_id;     
date_default_timezone_set('Asia/Manila');
$date_now =date("F d Y"); 
?>

<div class="clearfix"></div>
  <div class="content-wrapper">
  <?php if($_SESSION['type'] == "admin"){?>
     <div class="container-fluid">
      <div class="row " >
        <div class="col-sm-12">
          <h4 class="page-title">USER REGISTRATION</h4>
        </div>
      </div>
  
    <div class="row">
      <div class="col-lg-12">
      
          <div class="card">
            <div class="card-body"> 
             <div class="row">
              <div class="container-fluid">
                <div class="col-lg-12">
                  <form role="form" method="POST" autocomplete="nope">
                    <div class="card">
                      <div class="card-body">
                      <div class="row">
                          <div class="col-sm-6 form-group">
                              <label for="input-3">Type Of User</label>
                              <select name="type" class="form-control"  id="" required> 
                              <option value="">< - - - SELECT USER - - - ></option>
                                <option value="pdr_admin">PDR-Admin</option>
                                <option value="pdr_user">PDR-User</option>
                                <option value="hr_admin">HR-Admin</option>
                                <option value="hr_user">HR-User</option>
                                <option value="wp_admin">WP-Admin</option>
                                <option value="wp_user">WP-User</option>
                                <option value="wp_approve">WP-Approval</option>
                                <option value="wp_check">WP-Checker</option>
                                <option value="backup_user">Backup-User</option>
                                <option value="backup_admin">Backup-Admin</option>
                                <option value="backup_user">Backup-User</option>
                                <option value="pastdue_user">PastDue-User</option>
                                <option value="admin">Admin</option>
                              </select>
                          </div>
                          </div>
                          <div class="row">
                                <div class="col-sm-6 form-group">
                                    <label for="input-3">Name / Branch Name</label>
                                    <input type="text" hidden class="form-control" id="input-3"  value="<?php echo $id_holder;?>" name="user_id" autocomplete="nope">
                                    <input type="text" class="form-control" id="input-3" placeholder="Enter Full Name" name="full_name" autocomplete="nope">
                                </div>
                          </div>
                           <div class="row">
                                <div class="col-sm-6 form-group">
                                    <label for="input-3">Username</label>
                                    <input type="text" class="form-control" id="input-3" placeholder="Enter Username" name="username" autocomplete="nope">
                                </div>
                          </div>
                          <div class="row">
                                <div class="col-sm-6 form-group">
                                    <label for="input-4">Password</label> 
                                    <input type="password" class="form-control input-4" placeholder="Enter Password" name="password" type="password"  id="newPassword" required />
                                </div>
                          </div>
                          <div class="row">
                                 <div class="col-sm-6 form-group">
                                    <label for="input">Confirm Password</label>  
                                    <input type="password" class="form-control input-5" placeholder="Confirm Password" name="newConfirmPassword"  id="newConfirmPassword" required  />
                                    <span id="message"></span>
                                </div>
                          </div> 
                      </div>
                    </div>
                  </div>
                  <div class="card-footer">
                    <div class="row">
                      <div class="col-lg-3">
                      </div>
                      <div class="col-lg-9">
                        <div class="float-sm-right">
                         <button type="submit" id="start_button" name="signup" disabled="disable" class="btn btn-light btn-round px-5"><i class="fa fa-save" ></i>&nbsp;&nbsp;Save</button>
                         
                         <button type="button" class="btn btn-light btn-round px-5"  onClick="location.href='accounts'"><i class="fa fa-times"></i>&nbsp;&nbsp;Cancel</button> 

                        </div>

                      </div>
                    </div>
                  </div>  <!-- footer -->

              </div>    <!-- card -->
            </form>

            <?php 
              $createAccount = new ControllerAccounts();
              $createAccount -> ctrCreateAccounts();
             ?>
          </div>
        </div><!--End Row-->
          </div>
        </div>
      </div>
    </form>
  </div>
  <?php } ?>
</div>



  <!--   Core JS Files   -->

</body>

</html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script>



$('#newPassword, #newConfirmPassword').on('keyup', function () {
  if ($('#newPassword').val() == $('#newConfirmPassword').val()) {
    
    $('#message').html('Passsword Match').css('color', '#25e525');
    $('#start_button').prop('disabled', false);
   
  } else {
    $('#message').html('Passwords Does Not Match').css('color', '#e18b29');
    $('#start_button').prop('disabled', true);}
});


</script>