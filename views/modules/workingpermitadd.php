<style>
    textarea#wp_req_for {
    height: 100px;
}
</style>
<?php 
 $permit = (new Connection)->connect()->query("SELECT * from working_permit ORDER BY id Desc limit 1")->fetch(PDO::FETCH_ASSOC);
          if(empty($permit)){
            $id = 0;
          }else{
            $id = $permit['id'];
          }
         $last_id = $id + 1;
          $id_holder = "WP" . str_repeat("0",5-strlen($last_id)).$last_id;     

          date_default_timezone_set('Asia/Manila');
		      $date_now =date("F d Y"); 

          $user_id = $_SESSION['user_id'];
?>  
<div class="clearfix"></div>
	
<div class="content-wrapper">
  <div class="container-fluid">
   <div class="row pt-2 pb-2">
     <div class="col-sm-12">
  	    <h4 class="page-title">WORKING PERMIT FORM</h4>
     </div>
   </div> 
    <div class="row">
      <div class="col-lg-12">
        <form  method="POST" enctype="multipart/form-data" >   
          <div class="card">
            <div class="card-body">
             <div class="row"> 
                <div class="col-sm-2 form-group">
                <label for="input-1">Reference No. </label>
                    <input type="text" readonly  value="<?php echo $id_holder; ?>" class="form-control" id="ref_id" placeholder="Enter To" name="ref_id" autocomplete="nope" >
                    <input type="text" hidden  value="<?php echo $user_id; ?>" class="form-control" id="user_id" placeholder="Enter To" name="user_id" autocomplete="nope" >
                </div>
                <div class="col-sm-4 form-group">
                        <label for="input-1">TO </label>
                        <input type="text" class="form-control" id="wp_to" placeholder="Enter To" name="wp_to" autocomplete="nope" required>
                    </div> 
                    <div class="col-sm-4 form-group">
                        <label for="input-1">FROM </label>
                        <input type="text" class="form-control" id="wp_from" placeholder="Enter From" name="wp_from" autocomplete="nope" required>
                    </div>   
                    <div class="col-sm-2 form-group">
                        <label for="input-6">Date</label>
                        <input type="text" class="form-control" id="wp_date" readonly placeholder="Enter Pag-ibig Number" name="wp_date" value="<?php echo $date_now; ?>" autocomplete="nope" required>
                </div>
            </div>
            <div class="row">
                    <div class="col-sm-12 form-group">
                        <label for="input-1">Request for </label>
                        <textarea class="form-control"  style="white-space: pre-wrap;" id="wp_req_for" placeholder="Enter Request For" name="wp_req_for" autocomplete="nope" required></textarea>
                    </div>   
                   
            </div>    
            <div class="row">
                <div class="col-sm-4 form-group">
                   <label for="input-1">Branch / Department </label>
                    <input type="text" class="form-control" id="branch" placeholder="Enter Branch / Department" name="branch" autocomplete="nope" required>
                </div>   
                <div class="col-sm-4 form-group">
                    <label for="input-1">Requested by </label>
                    <textarea class="form-control" style="white-space: pre-wrap;"  id="wp_req_by" placeholder="Enter Requested By" name="wp_req_by" autocomplete="nope" ></textarea>
                </div> 
                <div class="col-sm-4 form-group">
                    <label for="input-1">Checked by</label>
                    <textarea class="form-control" style="white-space: pre-wrap;"  id="wp_chk_by" placeholder="Enter Checked By" name="wp_chk_by" autocomplete="nope" ></textarea>
                </div>   
            </div>   
            <div class="row">
                  <div class="col-sm-4">
                    <label for="input-6">Attachment</label>
                    <input type="file" class="form-control" name="image[]" id="attachment" multiple>
                  </div>
                 <div class="col-sm-4 form-group">
                        <label for="input-6">Approved By</label>
                        <input type="text" class="form-control" readonly id="wp_app_by" value="Christine G. Nepomuceno" placeholder="Enter Approved By" name="wp_app_by" autocomplete="nope" required>
                </div>
                <div class="col-sm-4 form-group">
                        <label for="input-6">Approved By</label>
                        <input type="text" class="form-control" readonly id="wp_app_by1" value="Edgardo G. Guerrero Jr." placeholder="Enter Approved By" name="wp_app_by1" autocomplete="nope" required>
                </div>
            </div>
                                                        
            <div class="card-footer">
              <div class="row">
                <div class="col-lg-3">
                </div>
                <div class="col-lg-9">
                  <div class="float-sm-right">
                   <button type="submit" name="add_permit" class="btn btn-light btn-round px-5"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
                   
                   <button type="button" class="btn btn-light btn-round px-5" onClick="location.href='workingpermit'"><i class="fa fa-list"></i>&nbsp;&nbsp;Listing</button>                           
                  </div>
                </div>
              </div>
            </div>  <!-- footer -->

          </div>    <!-- card -->
        </form>

        <?php
                    $createClient = new ControllerPermits();
                    $createClient -> ctrCreatePermit();
                    ?>
      </div>
    </div><!--End Row-->

  <div class="overlay toggle-menu"></div>
  </div>    <!-- container-fluid -->
</div>      <!-- content-wrapper -->