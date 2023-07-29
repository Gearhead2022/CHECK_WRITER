
<style>
    textarea#wp_req_for {
    height: 100px;
}
</style>
<?php 
 $backup = (new Connection)->connect()->query("SELECT * from backup ORDER BY id Desc limit 1")->fetch(PDO::FETCH_ASSOC);
          if(empty($backup)){
            $id = 0;
          }else{
            $id = $backup['id'];
          }
         $last_id = $id + 1;
         
          $id_holder = "BU" . str_repeat("0",5-strlen($last_id)).$last_id;     

          date_default_timezone_set('Asia/Manila');
		      $date_now =date('Y-m-d'); 

          $user_id = $_SESSION['user_id'];
          $branch_name = $_SESSION['branch_name'];
?>  
<div class="clearfix"></div>
	
<div class="content-wrapper">
  <div class="container-fluid">
   <div class="row pt-2 pb-2">
     <div class="col-sm-12">
  	    <h4 class="page-title">DAILY BACKUP</h4>
     </div>
   </div> 
    <div class="row">
      <div class="col-lg-12">
        <form  method="POST" enctype="multipart/form-data" >   
          <div class="card">
            <div class="card-body">
             <div class="row"> 
                <div class="col-sm-4 form-group">
                <label for="input-1">BACKUP No. </label>
                    <input type="text" readonly  value="<?php echo $id_holder; ?>" class="form-control" id="backup_id" placeholder="Enter To" name="backup_id" autocomplete="nope" >
                    <input type="text" hidden  value="<?php echo $user_id; ?>" class="form-control" id="user_id" placeholder="Enter To" name="user_id" autocomplete="nope" >
                </div>
                <div class="col-sm-4 form-group">
                        <label for="input-1">BRANCH NAME </label>
                        <input type="text" class="form-control" id="branch_name" placeholder="Enter To" name="branch_name" autocomplete="nope" value="<?php echo $branch_name; ?>" readonly>
                    </div> 
                     
                    <div class="col-sm-4 form-group">
                        <label for="input-6">Date</label>
                        <input type="date" class="form-control" id="wp_date" placeholder="Enter Pag-ibig Number" name="wp_date" value="<?php echo $date_now; ?>" autocomplete="nope" required>
                </div>
        </div>
        
            <div class="row mb-2">
                  <div class="col-sm-4">
                    <label for="input-6">SUBJECT</label>
                    <textarea class="form-control"  placeholder="Enter Subject" name="subject" id="subject"></textarea>
                  </div>
                  <div class="col-sm-4">
                    <label for="input-6">Attachment</label>
                    <input type="file" class="form-control" name="image[]" id="attachment" multiple>
                  </div>
            </div>
                                                        
            <div class="card-footer">
              <div class="row">
                <div class="col-lg-3">
                </div>
                <div class="col-lg-9">
                  <div class="float-sm-right">
                   <button type="submit" name="add_backup" class="btn btn-light btn-round px-5"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
                   
                   <button type="button" class="btn btn-light btn-round px-5" onClick="location.href='backups'"><i class="fa fa-list"></i>&nbsp;&nbsp;Listing</button>                           
                  </div>
                </div>
              </div>
            </div>  <!-- footer -->

          </div>    <!-- card -->
        </form>

        <?php
                    $createClient = new ControllerBackup();
                    $createClient -> ctrCreateBackup();
                    ?>
      </div>
    </div><!--End Row-->

  <div class="overlay toggle-menu"></div>
  </div>    <!-- container-fluid -->
</div>      <!-- content-wrapper -->