<?php 
 $client = (new Connection)->connect()->query("SELECT * from clients ORDER BY id Desc limit 1")->fetch(PDO::FETCH_ASSOC);
          if(empty($client)){
            $id = 0;
          }else{
            $id = $client['id'];
          } $last_id = $id + 1;
          $id_holder = "CI" . str_repeat("0",4-strlen($last_id)).$last_id; 
          
        
?>  
<div class="clearfix"></div>
	
<div class="content-wrapper">
  <div class="container-fluid">
   <div class="row pt-2 pb-2">
     <div class="col-sm-12">
  	    <h4 class="page-title">ADD ACCOUNT</h4>
     </div>
   </div> 

    <div class="row">
      <div class="col-lg-12">
        <form  method="POST" enctype="multipart/form-data" autocomplete="nope">
          <div class="card">
            <div class="card-body">
                 <div class="row">
                      <div class="col-sm-4 form-group">
                        <input type="text" name="clientid" hidden value="<?php echo $id_holder; ?>">
                          <label for="input-1">First Name</label>
                          <input type="text" class="form-control" id="input-1" placeholder="Enter First Name" name="first_name" autocomplete="nope" required>
                      </div>                   

                      <div class="col-sm-4 form-group">
                          <label for="input-2">Middle Name</label>
                          <input type="text" class="form-control" id="input-2" placeholder="Enter Middle Name"  name="middle_name" autocomplete="nope">
                      </div>
                      <div class="col-sm-4 form-group">
                          <label for="input-2">Last Name</label>
                          <input type="text" class="form-control" id="input-2" placeholder="Enter Last Name"  name="last_name" required autocomplete="nope">
                      </div>
                  </div>                                                

                  <div class="row">
                      <div class="col-sm-4 form-group">
                          <label for="input-6">Bank</label>
                          <input type="text" class="form-control" id="input-6" placeholder="Enter Bank" name="bank" autocomplete="nope" >
                      </div>

                      <div class="col-sm-4 form-group">
                          <label for="input-6">Account Number</label>
                          <input type="text" class="form-control" id="ucost"  placeholder="Enter Account Number" name="account_number" autocomplete="nope">
                      </div>
                      <div class="col-sm-4 form-group">
                          <label for="input-6">Lending Firm</label>
                          <input type="text" class="form-control" placeholder="Enter Lending Firm"  name="lending_firm" autocomplete="nope" required>
                      </div>
                  </div>
                  <div class="row">
                  <div class="col-sm-4 form-group">
                          <label for="input-6">Status</label>
                          <input type="text" class="form-control" placeholder="Enter Status"  name="status" autocomplete="nope">
                      </div>
                    <div class="col-sm-8">
                         <label for="input-6">Remarks</label>
                          <textarea class="form-control" id="ucost"  name="remarks" autocomplete="nope" ></textarea>
                    </div>
                  </div> 
                  <div class="row">
                    <div class="col-sm-4">
                    <label for="input-6">Add Image</label>
                      <input type="file" class="form-control" name="image[]" id="img_file" multiple>
                    </div>
                  </div>
            </div>

            <div class="card-footer">
              <div class="row">
                <div class="col-lg-3">
                </div>
                <div class="col-lg-9">
                  <div class="float-sm-right">
                   <button type="submit" name="add_records" class="btn btn-light btn-round px-5"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
                   
                   <button type="button" class="btn btn-light btn-round px-5" onClick="location.href='blacklist'"><i class="fa fa-list"></i>&nbsp;&nbsp;Listing</button>                           
                  </div>
                </div>
              </div>
            </div>  <!-- footer -->

          </div>    <!-- card -->
        </form>

        <?php
                    $createBlacklist = new ControllerBlacklist();
                    $createBlacklist -> ctrCreateBlacklist();
                    ?>
      </div>
    </div><!--End Row-->

  <div class="overlay toggle-menu"></div>
  </div>    <!-- container-fluid -->
</div>      <!-- content-wrapper -->