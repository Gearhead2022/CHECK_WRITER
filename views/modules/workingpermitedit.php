<?php 
 $idClient = $_GET['idClient'];

 $clients = (new Connection)->connect()->query("SELECT * FROM working_permit WHERE id = $idClient")->fetch(PDO::FETCH_ASSOC);
 $wp_to = $clients['wp_to'];
 $wp_from = $clients['wp_from'];
 $wp_date = $clients['wp_date']; 
 $ref_id = $clients['ref_id']; 
 $wp_req_for = $clients['wp_req_for'];
 $branch = $clients['branch'];
 $wp_req_by1 = $clients['wp_req_by'];
 $wp_chk_by1 = $clients['wp_chk_by'];
 $wp_app_by = $clients['wp_app_by'];
 $wp_app_by1 = $clients['wp_app_by1'];
 $table ="permit_files"; 
 $wp_req_for1 =str_replace("<br />", '',  $wp_req_for);
 $wp_req_by =str_replace("<br />", '',  $wp_req_by1);
 $wp_chk_by =str_replace("<br />", '',  $wp_chk_by1);
 date_default_timezone_set('Asia/Manila');
  $date_now =date("F d Y");
  $attch = (new ControllerPermits)->ctrShowImg($table, $ref_id);
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>

<style>
  .bus_image {
		position: relative;
	}
  .dlt_img{
		position: absolute;	
		color: black;
    margin-left: -16px;
	}.dlt_img:hover{
	color: red;
	font-size: 18px;
}
textarea#wp_req_for {
    height: 100px;
}
</style>


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
                    <input type="text" readonly  value="<?php echo $ref_id; ?>" class="form-control" id="ref_id" placeholder="Enter To" name="ref_id" autocomplete="nope" >
                </div>
                <div class="col-sm-4 form-group">
                        <input type="text" hidden value="<?php echo $idClient; ?>" class="form-control" id="id" placeholder="Enter To" name="id" autocomplete="nope" >

                        <label for="input-1">TO: </label>
                        <input type="text" class="form-control" id="wp_to" value="<?php echo $wp_to; ?>" placeholder="Enter To" name="wp_to" autocomplete="nope" required>
                    </div> 
                    <div class="col-sm-4 form-group">
                        <label for="input-1">FROM: </label>
                        <input type="text" class="form-control" id="wp_from" value="<?php echo $wp_from; ?>" placeholder="Enter From" name="wp_from" autocomplete="nope" required>
                    </div>   
                    <div class="col-sm-2 form-group">
                        <label for="input-6">Date</label>
                        <input type="text" readonly class="form-control" id="wp_date" value="<?php echo $date_now; ?>" placeholder="Enter Pag-ibig Number" name="wp_date" autocomplete="nope" required>
                </div>
            </div>
            <div class="row">
                    <div class="col-sm-12 form-group">
                        <label for="input-1">Request for </label>
                        <textarea class="form-control" id="wp_req_for" style="white-space: pre-wrap;"  placeholder="Enter Request For" name="wp_req_for" autocomplete="nope" required><?php echo $wp_req_for1; ?></textarea>
                    </div>   
                   
            </div>    
            <div class="row">
                <div class="col-sm-4 form-group">
                   <label for="input-1">Branch </label>
                    <input type="text" class="form-control" id="branch" value="<?php echo $branch; ?>" placeholder="Enter Branch" name="branch" autocomplete="nope" required>
                </div>   
                <div class="col-sm-4 form-group">
                        <label for="input-1">Requested by </label>
                        <textarea class="form-control" style="white-space: pre-wrap;"  id="wp_req_by" placeholder="Enter Requested By" name="wp_req_by" autocomplete="nope" ><?php echo $wp_req_by; ?></textarea>
                </div> 
                <div class="col-sm-4 form-group">
                    <label for="input-1">Checked by</label>
                    <textarea class="form-control" style="white-space: pre-wrap;"  id="wp_chk_by" placeholder="Enter Checked By" name="wp_chk_by" autocomplete="nope" ><?php echo $wp_chk_by; ?></textarea>
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
            <div class="row mt-3">
                    <div class="col-sm-12">
                    <label for="input-6">Attactments</label>
                    </div>
                  </div>
                  <div class="row mt-2">
                    <?php  foreach ($attch as $key => $value) { 
                       $attch_name = $value["file_name"]; 
                       $img_id = $value["id"];?>
                    <div class="col-sm-2 bus_image mt-2">
                    <a class="pop"> 
                      <img src="views/files/permit/<?php echo $attch_name; ?>"  style="width: 100%;height: 116px; background-color: white;">
                    </a>
                    <span class="dlt_img"
                     idClient = "<?php echo $idClient?>" img_name = "<?php echo $attch_name?>"><i class="fa fa-times"></i></span> 
                    </div>
                    <?php } ?>
                  </div>
                                                         
            <div class="card-footer">
              <div class="row">
                <div class="col-lg-3">
                </div>
                <div class="col-lg-9">
                  <div class="float-sm-right">
                   <button type="submit" name="edit_permit" class="btn btn-light btn-round px-5"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
                   
                   <button type="button" class="btn btn-light btn-round px-5" onClick="location.href='workingpermit'"><i class="fa fa-list"></i>&nbsp;&nbsp;Listing</button>                           
                  </div>
                </div>
              </div>
            </div>  <!-- footer -->

          </div>  
          <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content" id="img_modal" style="width: 600px; background-color: white; margin-left: -34px;">              
                <div class="modal-body">
                  <button type="button" class="close" style="color: black; font-weight: bold; " id="x_modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                  <img src="" class="imagepreview" style="width: 100%; height: 450px;" >
                </div>
              </div>
            </div>
          </div>  <!-- card -->
        </form>

        <?php
                    $createClient = new ControllerPermits();
                    $createClient -> ctrEditPermit();
                    $deleteImg = new ControllerPermits();
                    $deleteImg  -> ctrDeleteImg($table);
                    ?>
      </div>
    </div><!--End Row-->
    <script>

$('.pop').click(function(){
   $('.imagepreview').attr('src', $(this).find('img').attr('src'));
   $('#imagemodal').modal('show');   
   })
   $('.close').click(function(){
   
   $('#imagemodal').modal('hide');   
   })
 </script>
  <div class="overlay toggle-menu"></div>
  </div>    <!-- container-fluid -->
</div>      <!-- content-wrapper -->