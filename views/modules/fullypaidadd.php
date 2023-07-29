
<style>
    textarea#wp_req_for {
    height: 100px;
}
</style>
<?php 
 $backup = (new Connection)->connect()->query("SELECT * from fully_paid ORDER BY id Desc limit 1")->fetch(PDO::FETCH_ASSOC);
          if(empty($backup)){
            $id = 0;
          }else{
            $id = $backup['id'];
          }
         $last_id = $id + 1;
         
          $id_holder = "FP" . str_repeat("0",5-strlen($last_id)).$last_id;     

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
  	    <h4 class="page-title">ADD RECORDS</h4>
     </div>
   </div> 
    <div class="row">
      <div class="col-lg-12">
        <form method="POST" enctype="multipart/form-data" >   
          <div class="card">
            <div class="card-body">
             <div class="row mb-4"> 
             <div class="col-sm-4">
                    <label for="input-6">Branch Name</label>
                    <input type="text" class="form-control" value="<?php echo $branch_name; ?>" readonly name="branch_name" id="branch_name">
              </div>
              <div class="col-sm-4">
                <label for="input-6">Date</label>
                <input type="text" class="form-control" value="<?php echo $date_now; ?>" readonly>
              </div>
            </div>
        
            <div class="row mb-2">
                  <div class="col-sm-4">
                    <input hidden type="text" name="id" value="<?php echo $id; ?>" >
                    <input hidden type="text" name="user_id" value="<?php echo $user_id; ?>" >
                    <label for="input-6">Attachment</label>
                    <input type="file" class="form-control" name="file" id="file" value="Import">
                  </div>
            </div>
                                                        
            <div class="card-footer">
              <div class="row">
                <div class="col-lg-3">
                </div>
                <div class="col-lg-9">
                  <div class="float-sm-right">
                   <button type="submit" name="submit" class="btn btn-light btn-round px-5"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
                   
                   <button type="button" class="btn btn-light btn-round px-5" onClick="location.href='fullypaid'"><i class="fa fa-list"></i>&nbsp;&nbsp;Listing</button>                           
                  </div>
                </div>
              </div>
            </div>  <!-- footer -->

          </div>    <!-- card -->
        </form>

        <?php
                    $createClient = new ControllerFullypaid();
                    $createClient -> addRecords();
                    ?>
      </div>
    </div><!--End Row-->

  <div class="overlay toggle-menu"></div>
  </div>    <!-- container-fluid -->
</div>      <!-- content-wrapper -->