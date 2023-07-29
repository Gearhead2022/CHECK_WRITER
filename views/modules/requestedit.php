<style>
    textarea#subject_body {
    height: 180px;
}
i{
  font-size: 9px;
}
.bus_image {
		position: relative;
	}
  .dlt_req_img{
		position: absolute;	
		color: black;
    margin-left: -16px;
	}.dlt_req_img:hover{
	color: red;
	font-size: 18px;
}
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<?php 
 $idClient = $_GET['idClient'];

 $clients = (new Connection)->connect()->query("SELECT * FROM request_forms WHERE id = $idClient")->fetch(PDO::FETCH_ASSOC);
 $ref_id = $clients['ref_id'];
 $to = $clients['to'];
 $address = $clients['address']; 
 $req_by = $clients['req_by']; 
 $branch1 = $clients['branch'];
 $date = $clients['date'];
 $subject = $clients['subject'];
 $subject_body = $clients['subject_body'];
 $chk_bys = $clients['chk_by'];
 $chk_by1 = $clients['chk_by1'];
 $chk_by2 = $clients['chk_by2'];
 $rec_app = $clients['rec_app'];
 $app_by = $clients['app_by'];
 $subject_body1 =str_replace("<br />", '',  $subject_body);
 $chk_by =str_replace("<br />", '',  $chk_bys);
 $branch =str_replace("<br />", '',  $branch1);
 $chk_by11 =str_replace("<br />", '',  $chk_by1);
 $chk_by22 =str_replace("<br />", '',  $chk_by2);
 $req_by1 =str_replace("<br />", '',  $req_by);
 $rec_app1 =str_replace("<br />", '',  $rec_app);
 $app_by1 =str_replace("<br />", '',  $app_by);
 


 $table ="permit_files";
 $wp_req_for1 =str_replace("<br />", '',  $subject_body);
 date_default_timezone_set('Asia/Manila');
  $date_now =date("F d Y");
  $attch = (new ControllerPermits)->ctrShowImg($table, $ref_id);
?>  
<div class="clearfix"></div>
	
<div class="content-wrapper">
  <div class="container-fluid">
   <div class="row pt-2 pb-2">
     <div class="col-sm-12">
  	    <h4 class="page-title">REQUEST FORM</h4>
     </div>
   </div> 
    <div class="row">
      <div class="col-lg-12">
        <form  method="POST" enctype="multipart/form-data" >   
          <div class="card">
            <div class="card-body">
             <div class="row">
                <div class="col-sm-2 form-group">
                <label for="input-1">REQUEST No. </label>
                    <input type="text"  hidden value="<?php echo $idClient; ?>" class="form-control" id="id" placeholder="Enter To" name="id" autocomplete="nope" >
                    <input type="text" readonly  value="<?php echo $ref_id; ?>" class="form-control" id="ref_id" placeholder="Enter To" name="ref_id" autocomplete="nope" >
                </div>
                    <div class="col-sm-4 form-group">
                        <label for="input-1">To </label>
                        <input type="text" class="form-control" id="to" placeholder="Enter Request To" value="<?php echo $to; ?>" name="to" autocomplete="nope" required>
                    </div>   
                    <div class="col-sm-6 form-group">
                        <label for="input-6">Address</label>
                        <input type="text" class="form-control" id="address"  placeholder="Enter Address" value="<?php echo $address; ?>" name="address" autocomplete="nope" required>
                </div>
            </div>
            <div class="row">
                    <div class="col-sm-4 form-group">
                        <label for="input-1">Request By </label>
                        <textarea class="form-control" id="req_by" style="white-space: pre-wrap;"   placeholder="Enter Request by"  name="req_by" autocomplete="nope" required><?php echo $req_by1; ?></textarea>
                    </div>   
                    <div class="col-sm-6 form-group">
                        <label for="input-1">Branch</label>
                        <textarea  class="form-control" id="branch" style="white-space: pre-wrap;"  placeholder="Enter Branch" name="branch" autocomplete="nope" required><?php echo $branch; ?></textarea>
                    </div>
                    <div class="col-sm-2 form-group">
                        <label for="input-1">Date </label>
                        <input type="text" readonly class="form-control" value="<?php echo $date; ?>"  id="date" placeholder="Enter To" name="date" autocomplete="nope" required>
                    </div> 
            </div>    
            <div class="row">
              <div class="col-sm-12 form-group">
                  <label for="input-1">Subject</label>
                  <input type="text" class="form-control" id="subject" placeholder="Enter Subject" value="<?php echo $subject; ?>" name="subject" autocomplete="nope" required></textarea>
              </div>
            </div>
            <div class="row">
                    <div class="col-sm-12 form-group">
                        <label for="input-1">Subject Content </label>
                        <textarea class="form-control" id="subject_body" style="white-space: pre-wrap;"   placeholder="Enter Subject Content" name="subject_body" autocomplete="nope" required><?php echo $subject_body1; ?></textarea>
                    </div>   
                   
            </div>
            <div class="row">
                <div class="col-sm-4 form-group">
                   <label for="input-1">Checked by</label>
                    <textarea class="form-control" id="chk_by" placeholder="Enter Checked By"  style="white-space: pre-wrap;" name="chk_by" autocomplete="nope" required><?php echo $chk_by; ?>  </textarea>
                </div>   
                <div class="col-sm-4 form-group">
                        <label for="input-1">Checked by ( <i> Optional </i> )</label>
                        <textarea class="form-control" id="chk_by1"  placeholder="Enter Checked By ( Optional )" style="white-space: pre-wrap;" name="chk_by1" autocomplete="nope"><?php echo $chk_by11; ?></textarea>
                </div> 
                <div class="col-sm-4 form-group">
                    <label for="input-1">Checked by ( <i> Optional </i> )</label>
                    <textarea  class="form-control"   id="chk_by2" placeholder="Enter Checked By ( Optional )" style="white-space: pre-wrap;" name="chk_by2" autocomplete="nope"><?php echo $chk_by22; ?></textarea>
                </div>   
            </div>   
            <div class="row">
                  <div class="col-sm-4">
                    <label for="input-6">Attachment</label>
                    <input type="file" class="form-control" name="image[]" id="attachment" multiple>
                  </div>
                 <div class="col-sm-4 form-group">
                        <label for="input-6">Recommending Approval</label>
                        <textarea class="form-control" style="white-space: pre-wrap;" id="rec_app"  placeholder="Enter Recommending Approval" name="rec_app" autocomplete="nope" required><?php echo $rec_app1; ?></textarea>
                </div>
                <div class="col-sm-4 form-group">
                        <label for="input-6">Approved By</label>
                        <textarea  class="form-control" style="white-space: pre-wrap;"  id="app_by"  placeholder="Enter Approved By" name="app_by" autocomplete="nope" required><?php echo $app_by1; ?></textarea>
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
                      <img src="views/files/request/<?php echo $attch_name; ?>"  style="width: 100%;height: 116px; background-color: white;">
                    </a>
                    <span class="dlt_req_img"
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
                   <button type="submit" name="edit_request" class="btn btn-light btn-round px-5"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
                   
                   <button type="button" class="btn btn-light btn-round px-5" onClick="location.href='request'"><i class="fa fa-list"></i>&nbsp;&nbsp;Listing</button>                           
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
          </div>    <!-- card -->
        </form>

        <?php
                       $createClient = new ControllerRequest();
                       $createClient -> ctrEditRequest();
                       $deleteImg = new ControllerRequest();
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