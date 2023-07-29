<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>

<?php 
 $idClient = $_GET['idClient'];

 $clients = (new Connection)->connect()->query("SELECT * FROM clients WHERE id = $idClient")->fetch(PDO::FETCH_ASSOC);
 $clientid = $clients['clientid'];
 $first_name = $clients['first_name'];
 $middle_name = $clients['middle_name']; 
 $last_name = $clients['last_name'];
 $bank = $clients['bank'];
 $account_number = $clients['account_number'];
 $remarks = $clients['remarks'];
 $status = $clients['status'];
 $lending_firm = $clients['lending_firm'];
 $upload_files = $clients['upload_files'];  

 $img = (new ControllerBlacklist)->ctrShowImg($clientid);
?> 
<style>
  .bus_image {
		position: relative;
	}
  .img_add{
		position: absolute;	
		color: black;
    margin-left: -16px;
	}.img_add:hover{
	color: red;
	font-size: 18px;
}
</style>

<div class="clearfix"></div>
	
<div class="content-wrapper">
  <div class="container-fluid">
   <div class="row pt-2 pb-2">
     <div class="col-sm-12">
  	    <h4 class="page-title">UPDATE ACCOUNT</h4>
     </div>
   </div>

    <div class="row">
      <div class="col-lg-12">
        <form role="form" method="POST" enctype="multipart/form-data" autocomplete="nope">
          <div class="card">
            <div class="card-body">
            <div class="row">
                      <div class="col-sm-4 form-group">
                      <input type="text" class="inputText" name="clientid" value="<?php echo $clientid; ?>" hidden/>
                      <input type="text" class="inputText" name="id" value="<?php echo $idClient; ?>" hidden/>
                          <label for="input-1">First Name</label>
                          <input type="text" class="form-control" id="input-1" placeholder="Enter First Name" value="<?php echo $first_name; ?>" name="first_name" autocomplete="nope" required>
                      </div>                   

                      <div class="col-sm-4 form-group">
                          <label for="input-2">Middle Name</label>
                          <input type="text" class="form-control" id="input-2" placeholder="Enter Middle Name" value="<?php echo $middle_name; ?>"  name="middle_name" >
                      </div>
                      <div class="col-sm-4 form-group">
                          <label for="input-2">Last Name</label>
                          <input type="text" class="form-control" id="input-2" placeholder="Enter Last Name" value="<?php echo $last_name; ?>"  name="last_name">
                      </div>
                  </div>                                                

                  <div class="row">
                      <div class="col-sm-4 form-group">
                          <label for="input-6">Bank</label>
                          <input type="text" class="form-control" id="input-6" placeholder="Enter Bank" value="<?php echo $bank; ?>" name="bank" autocomplete="nope">
                      </div>

                      <div class="col-sm-4 form-group">
                          <label for="input-6">Account Number</label>
                          <input type="text" class="form-control" id="ucost"  placeholder="Enter Account Number" value="<?php echo $account_number; ?>" name="account_number" autocomplete="nope">
                      </div>
                      <div class="col-sm-4 form-group">
                          <label for="input-6">Lending Firm</label>
                          <input type="text" class="form-control" placeholder="Enter Lending Firm" value="<?php echo  $lending_firm; ?>" name="lending_firm" autocomplete="nope" required>
                      </div>
                  </div>
                  <div class="row">
                  <div class="col-sm-4 form-group">
                          <label for="input-6">Status</label>
                          <input type="text" class="form-control" placeholder="Enter Status" value="<?php echo  $status; ?>"  name="status" autocomplete="nope" required>
                      </div>
                    <div class="col-sm-8">
                         <label for="input-6">Remarks</label>
                          <textarea class="form-control" id="ucost"  name="remarks" autocomplete="nope"><?php echo $remarks?></textarea>
                    </div>
                  </div>  
                  <div class="row">
                    <div class="col-sm-4">
                    <label for="input-6">Add Image</label>
                    <input type="file" class="form-control" name="image[]" id="img_file" multiple>
                    </div>
                  </div>  
                  
                  <div class="row mt-3">
                    <div class="col-sm-12">
                    <label for="input-6">Images</label>
                    </div>
                  </div>
                  <div class="row mt-2">
                    <?php  foreach ($img as $key => $value) { 
                       $img_name1 = $value["image_name"]; ?>
                    <div class="col-sm-2 bus_image">
                    <a class="pop"> 
                      <img src="views/files/<?php echo $img_name1; ?>"  style="width: 100%;height: 116px; background-color: white;">
                    </a>
                    <span class="img_add" img_name="<?php echo $img_name1?>" idClient = "<?php echo $idClient?>"><i class="fa fa-times"></i></span> 
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
                   <button type="button" class="btn btn-light btn-round px-5" onClick="location.href='blacklist'"><i class="fa fa-list"></i>&nbsp;&nbsp;Listing</button>                           
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
          $editBlacklist = new ControllerBlacklist();
          $editBlacklist -> ctrEditBlacklist();

          $deleteImg = new ControllerBlacklist();
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