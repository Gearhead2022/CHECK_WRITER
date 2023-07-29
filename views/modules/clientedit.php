<?php 
 $idClient = $_GET['idClient'];
 $type = $_GET['type'];
 $links = "";
 if($type == "EMB"){
  $clients = (new Connection)->connect()->query("SELECT * FROM application_form WHERE id = $idClient")->fetch(PDO::FETCH_ASSOC);
  $links ="clients";

 }elseif($type == "FCH"){
  $clients = (new Connection)->connect()->query("SELECT * FROM fch_form WHERE id = $idClient")->fetch(PDO::FETCH_ASSOC);
  $links ="fch";

 }elseif($type == "PSPMI"){
  $clients = (new Connection)->connect()->query("SELECT * FROM pspmi_form WHERE id = $idClient")->fetch(PDO::FETCH_ASSOC);
  $links ="pspmi";

 }elseif($type == "RLC"){
  $clients = (new Connection)->connect()->query("SELECT * FROM rlc_form WHERE id = $idClient")->fetch(PDO::FETCH_ASSOC);
  $links ="rlc";

 }


 $id_num = $clients['id_num'];
$fname = $clients['fname']; 
$mname = $clients['mname'];
$lname = $clients['lname'];
$company = $clients['company'];
$blood_type = $clients['blood_type'];
$birth_date = $clients['birth_date'];
$home_address = $clients['home_address'];
$sss_num = $clients['sss_num'];
$tin_num = $clients['tin_num'];
$phil_num = $clients['phil_num'];
$pagibig_num = $clients['pagibig_num'];
$date_hired = $clients['date_hired'];
$em_fname = $clients['em_fname'];
$em_mname = $clients['em_mname'];
$em_lname = $clients['em_lname'];
$em_phone = $clients['em_phone'];
$em_address = $clients['em_address'];
$picture = $clients['picture'];
$status = $clients['status'];


$attch = (new ControllerClients)->ctrShowImg($company, $id_num);
?> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>

<style>
  .bus_image {
		position: relative;
	}
  .img_add1{
		position: absolute;	
		color: black;
    margin-left: -16px;
	}.img_add1:hover{
	color: red;
	font-size: 18px;
}
</style>

<div class="clearfix"></div>
	
<div class="content-wrapper">
  <div class="container-fluid">
   <div class="row pt-2 pb-2">
     <div class="col-sm-12">
  	    <h4 class="page-title">UPDATE CLIENT</h4>
     </div>
   </div>

    <div class="row">
      <div class="col-lg-12">
        <form role="form" method="POST" enctype="multipart/form-data" autocomplete="nope">
          <div class="card">
            <div class="card-body">
            <div class="row">
                    <div class="col-sm-2 form-group">
                          <label for="input-1">ID Number</label>
                          <input type="text" class="inputText" name="id" value="<?php echo $idClient; ?>" hidden/>
                          <input type="text" class="form-control" id="id_num" placeholder="Enter ID Number" value="<?php echo $id_num; ?>" name="id_num" autocomplete="nope" required>
                      </div> 
                      <div class="col-sm-3 form-group">
                          <label for="input-1">First Name</label>
                          <input type="text" class="form-control" id="fname" placeholder="Enter First Name" value="<?php echo $fname; ?>"  name="fname" autocomplete="nope" required>
                      </div>                   

                      <div class="col-sm-3 form-group">
                          <label for="input-2">Middle Name</label>
                          <input type="text" class="form-control" id="mname" placeholder="Enter Middle Name" value="<?php echo $mname; ?>"  name="mname">
                      </div>
                      <div class="col-sm-3 form-group">
                          <label for="input-2">Last Name</label>
                          <input type="text" class="form-control" id="lname" placeholder="Enter Last Name" value="<?php echo $lname; ?>"  name="lname" required>
                      </div>
                  </div>                                                

                  <div class="row">
                  <div class="col-sm-2 form-group">
                          <label for="input-6">Company</label>
                          <input type="text" class="form-control" id="company"  value="<?php echo $company; ?>"  name="company" readonly>
                      </div>
                      <div class="col-sm-2 form-group">
                          <label for="input-6">Blood Type</label>
                          <input type="text" class="form-control" id="blood_type" value="<?php echo $blood_type; ?>" placeholder="Enter Blood Type" name="blood_type" autocomplete="nope">
                      </div>

                      <div class="col-sm-2 form-group">
                          <label for="input-6">Date Of Birth</label>
                          <input type="date" class="form-control" id="birth_date" value="<?php echo $birth_date; ?>"  placeholder="Enter Account Number" name="birth_date" autocomplete="nope" required>
                      </div>
                      <div class="col-sm-6 form-group">
                          <label for="input-6">Home Address</label>
                          <input type="text" class="form-control" id="home_address" value="<?php echo $home_address; ?>" placeholder="Enter Home Address" name="home_address" autocomplete="nope" required>
                      </div>
                      
                  </div>
                  <div class="row">
                      <div class="col-sm-3 form-group">
                          <label for="input-6">SSS Number</label>
                          <input type="text" class="form-control" id="sss_num" value="<?php echo $sss_num; ?>" placeholder="Enter SSS Number" name="sss_num" autocomplete="nope">
                      </div>
                      <div class="col-sm-3 form-group">
                          <label for="input-6">TIN Number</label>
                          <input type="text" class="form-control" id="tin_num" value="<?php echo $tin_num; ?>" placeholder="Enter TIN Number" name="tin_num" autocomplete="nope">
                      </div>
                      <div class="col-sm-3 form-group">
                          <label for="input-6">Philhealth Number</label>
                          <input type="text" class="form-control" id="phil_num" value="<?php echo $phil_num; ?>" placeholder="Enter Philhealth Number" name="phil_num" autocomplete="nope">
                      </div>
                      <div class="col-sm-3 form-group">
                          <label for="input-6">PAGIBIG Number</label>
                          <input type="text" class="form-control" id="pagibig_num" value="<?php echo $pagibig_num; ?>" placeholder="Enter Pag-ibig Number" name="pagibig_num" autocomplete="nope">
                      </div>
                  </div> 
                  <div class="row">
                  <div class="col-sm-3 form-group">
                          <label for="input-6">Date Hired</label>
                          <input type="date" class="form-control" id="date_hired" value="<?php echo $date_hired; ?>" name="date_hired" autocomplete="nope">
                    </div>
                    <div class="col-sm-3 form-group">
                    <label for="input-6">Status</label>
                       <select name="status" id="status" class="form-control"  required>
                            <option value="<?php echo $status; ?>"><?php echo $status; ?></option>
                            <option value="Active">Active</option>
                            <option value="Resigned">Resigned</option>
                            <option value="Probationary">Probationary</option>
                            <option value="Trainee">Trainee</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                    <label for="input-6">Add Image</label>
                    <input hidden type="text" value="<?php echo $picture; ?>" name="file_name" id="">
                      <input type="file" class="form-control" name="fileToUpload" id="fileToUpload">
                    </div>
                    <div class="col-sm-3">
                    <label for="input-6">Attachment</label>
                     
                      <input type="file" class="form-control" name="image[]" id="image" multiple>
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
                          <input type="text" class="form-control" id="em_fname" value="<?php echo $em_fname; ?>" placeholder="Enter First Name" name="em_fname" autocomplete="nope" required>
                      </div>                   

                      <div class="col-sm-4 form-group">
                          <label for="input-2">Middle Name</label>
                          <input type="text" class="form-control" id="em_mname" value="<?php echo $em_mname; ?>" placeholder="Enter Middle Name"  name="em_mname">
                      </div>
                      <div class="col-sm-4   form-group">
                          <label for="input-2">Last Name</label>
                          <input type="text" class="form-control" id="em_lname" value="<?php echo $em_lname; ?>" placeholder="Enter Last Name"  name="em_lname" required>
                      </div>
                  </div> 
                  <div class="row">
                      <div class="col-sm-4 form-group">
                          <label for="input-2">Tel. No./CP. NO.</label>
                          <input type="text" class="form-control" id="em_phone" value="<?php echo $em_phone; ?>" placeholder="Enter Telephone Or Phone Number"  name="em_phone">
                      </div>
                      <div class="col-sm-8   form-group">
                          <label for="input-2">Address</label>
                          <input type="text" class="form-control" id="em_address" value="<?php echo $em_address; ?>" placeholder="Enter Address"  name="em_address" required>
                      </div>
                  </div>    
                  <div class="row mt-3">
                    <div class="col-sm-12">
                    <label for="input-6">Attactments</label>
                    </div>
                  </div>
                  <div class="row mt-2">
                    <?php  foreach ($attch as $key => $value) { 
                       $attch_name = $value["file_name"]; ?>
                    <div class="col-sm-2 bus_image mt-2">
                    <a class="pop"> 
                      <img src="views/files/attachments/<?php echo $attch_name; ?>"  style="width: 100%;height: 116px; background-color: white;">
                    </a>
                    <span class="img_add1" img_name="<?php echo $attch_name?>" 
                    id_num = "<?php echo $id_num?>" type = "<?php echo $type?>"
                     idClient = "<?php echo $idClient?>"><i class="fa fa-times"></i></span> 
                    </div>
                    <?php } ?>
                  </div>    
            </div>

            <div class="card-footer">
              <div class="row">
                <div class="col-lg-3">
                </div>
                <div class="col-lg-9">
                  <div class="float-sm-right">
                   <button type="submit" name="edit_save" class="btn btn-light btn-round px-5"><i class="fa fa-save"></i>&nbsp;&nbsp;Update</button>
                   <button type="button" class="btn btn-light btn-round px-5" onClick="location.href='<?php echo $links; ?>'"><i class="fa fa-list"></i>&nbsp;&nbsp;Listing</button>                           
                  </div>
                </div>
              </div>
            </div>  <!-- footer -->

          </div>    <!-- card -->

          <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content" id="img_modal" style="width: 600px; background-color: white; margin-left: -34px;">              
                <div class="modal-body">
                  <button type="button" class="close" style="color: black; font-weight: bold; " id="x_modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                  <img src="" class="imagepreview" style="width: 100%; height: 450px;" >
                </div>
              </div>
            </div>
          </div>
        </form>
        <?php
          $editClient = new ControllerClients();
          $editClient -> ctrEditClient();
          $deleteImg = new ControllerClients();
          $deleteImg  -> ctrDeleteImg();
        ?>
      </div>

      <script>

$('.pop').click(function(){
   $('.imagepreview').attr('src', $(this).find('img').attr('src'));
   $('#imagemodal').modal('show');   
   })
   $('.close').click(function(){
   
   $('#imagemodal').modal('hide');   
   })
 </script>
    </div><!--End Row-->

  <div class="overlay toggle-menu"></div>
  </div>    <!-- container-fluid -->
</div>      <!-- content-wrapper -->