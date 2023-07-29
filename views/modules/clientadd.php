<?php 
  $type = $_REQUEST['type'];

  $link="";
  if($type == "EMB"){
    $link="clients";
  }elseif($type == "FCH"){
    $link="fch";
  }elseif($type == "PSPMI"){
    $link="pspmi";
  }
?>
<div class="clearfix"></div>
	
<div class="content-wrapper">
  <div class="container-fluid">
   <div class="row pt-2 pb-2">
     <div class="col-sm-12">
  	    <h4 class="page-title">APPLICATION FORM</h4>
     </div>
   </div> 

    <div class="row">
      <div class="col-lg-12">
        <form  method="POST" enctype="multipart/form-data" autocomplete="nope">
          <div class="card">
            <div class="card-body">
                 <div class="row">
                    <div class="col-sm-2 form-group">
                          <label for="input-1">ID Number</label>
                          <input type="text" class="form-control" id="id_num" placeholder="Enter ID Number" name="id_num" autocomplete="nope" required>
                      </div> 
                      <div class="col-sm-3 form-group">
                          <label for="input-1">First Name</label>
                          <input type="text" class="form-control" id="fname" placeholder="Enter First Name" name="fname" autocomplete="nope" required>
                      </div>                   

                      <div class="col-sm-3 form-group">
                          <label for="input-2">Middle Name</label>
                          <input type="text" class="form-control" id="mname" placeholder="Enter Middle Name"  name="mname" >
                      </div>
                      <div class="col-sm-3 form-group">
                          <label for="input-2">Last Name</label>
                          <input type="text" class="form-control" id="lname" placeholder="Enter Last Name"  name="lname" required>
                      </div>
                  </div>                                                

                  <div class="row">
                  <div class="col-sm-2 form-group">
                          <label for="input-6">Company</label>
                          <input type="text" class="form-control" id="company" value="<?php echo $type; ?>"  name="company" readonly>

                      </div>
                      <div class="col-sm-2 form-group">
                          <label for="input-6">Blood Type</label>
                          <input type="text" class="form-control" id="blood_type" placeholder="Enter Blood Type" name="blood_type" autocomplete="nope" >
                      </div>

                      <div class="col-sm-2 form-group">
                          <label for="input-6">Date Of Birth</label>
                          <input type="date" class="form-control" id="birth_date"  placeholder="Enter Account Number" name="birth_date" autocomplete="nope" required>
                      </div>
                      <div class="col-sm-6 form-group">
                          <label for="input-6">Home Address</label>
                          <input type="text" class="form-control" id="home_address" placeholder="Enter Home Address" name="home_address" autocomplete="nope" required>
                      </div>
                     
                  </div>
                  <div class="row">
                      <div class="col-sm-3 form-group">
                          <label for="input-6">SSS Number</label>
                          <input type="text" class="form-control" id="sss_num" placeholder="Enter SSS Number" name="sss_num" autocomplete="nope">
                      </div>
                      <div class="col-sm-3 form-group">
                          <label for="input-6">TIN Number</label>
                          <input type="text" class="form-control" id="tin_num" placeholder="Enter TIN Number" name="tin_num" autocomplete="nope">
                      </div>
                      <div class="col-sm-3 form-group">
                          <label for="input-6">Philhealth Number</label>
                          <input type="text" class="form-control" id="phil_num" placeholder="Enter Philhealth Number" name="phil_num" autocomplete="nope">
                      </div>
                      <div class="col-sm-3 form-group">
                          <label for="input-6">PAGIBIG Number</label>
                          <input type="text" class="form-control" id="pagibig_num" placeholder="Enter Pag-ibig Number" name="pagibig_num" autocomplete="nope">
                      </div>
                  </div> 
                  <div class="row">
                  <div class="col-sm-3 form-group">
                          <label for="input-6">Date Hired</label>
                          <input type="date" class="form-control" id="date_hired" placeholder="Enter Pag-ibig Number" name="date_hired" autocomplete="nope" required>
                    </div>
                    <div class="col-sm-3 form-group">
                    <label for="input-6">Status</label>
                       <select name="status" id="status" class="form-control"  required>
                            <option value="">< - - - SELECT STATUS - - - ></option>
                            <option value="Active">Active</option>
                            <option value="Resigned">Resigned</option>
                            <option value="Probationary">Probationary</option>
                            <option value="Trainee">Trainee</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                    <label for="input-6">ID Picture</label>
                      <input type="file" class="form-control" name="fileToUpload" id="fileToUpload">
                    </div>
                    <div class="col-sm-3">
                    <label for="input-6">Attachment</label>
                      <input type="file" class="form-control" name="image[]" id="attachment" multiple>
                    </div>
                  </div>
                  <div class="row">
                      <div class="col-sm-12 mt-3">
                      <h5 class="">IN CASE OF EMERGENCY PLEASE NOTIFY:</h5>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-sm-4 form-group">
                          <label for="input-1">First Name</label>
                          <input type="text" class="form-control" id="em_fname" placeholder="Enter First Name" name="em_fname" autocomplete="nope" required>
                      </div>                   

                      <div class="col-sm-4 form-group">
                          <label for="input-2">Middle Name</label>
                          <input type="text" class="form-control" id="em_mname" placeholder="Enter Middle Name"  name="em_mname" >
                      </div>
                      <div class="col-sm-4   form-group">
                          <label for="input-2">Last Name</label>
                          <input type="text" class="form-control" id="em_lname" placeholder="Enter Last Name"  name="em_lname" required>
                      </div>
                  </div> 
                  <div class="row">
                      <div class="col-sm-4 form-group">
                          <label for="input-2">Tel. No./CP. NO.</label>
                          <input type="text" class="form-control" id="em_phone" placeholder="Enter Telephone Or Phone Number"  name="em_phone">
                      </div>
                      <div class="col-sm-8   form-group">
                          <label for="input-2">Address</label>
                          <input type="text" class="form-control" id="em_address" placeholder="Enter Address"  name="em_address" required>
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
                   
                   <button type="button" class="btn btn-light btn-round px-5" onClick="location.href='<?php echo $link; ?>'"><i class="fa fa-list"></i>&nbsp;&nbsp;Listing</button>                           
                  </div>
                </div>
              </div>
            </div>  <!-- footer -->

          </div>    <!-- card -->
        </form>

        <?php
                    $createClient = new ControllerClients();
                    $createClient -> ctrFilter();
                    ?>
      </div>
    </div><!--End Row-->

  <div class="overlay toggle-menu"></div>
  </div>    <!-- container-fluid -->
</div>      <!-- content-wrapper -->