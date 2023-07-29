<style>
    textarea#subject_body {
    height: 180px;
}
i{
  font-size: 9px;
}
</style>
<?php 
 $request = (new Connection)->connect()->query("SELECT * from request_forms ORDER BY id Desc limit 1")->fetch(PDO::FETCH_ASSOC);
          if(empty($request)){
            $id = 0;
          }else{
            $id = $request['id'];
          }
         $last_id = $id + 1;
          $id_holder = "RI" . str_repeat("0",5-strlen($last_id)).$last_id;     
          date_default_timezone_set('Asia/Manila');
		  $date_now =date("F d Y"); 
      $user_id = $_SESSION['user_id'];
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
                    <input type="text" readonly  value="<?php echo $id_holder; ?>" class="form-control" id="ref_id" placeholder="Enter To" name="ref_id" autocomplete="nope" >
                    <input type="text" hidden  value="<?php echo $user_id; ?>" class="form-control" id="user_id" placeholder="Enter To" name="user_id" autocomplete="nope" >

                  </div>
                    <div class="col-sm-4 form-group">
                        <label for="input-1">To </label>
                        <input type="text" class="form-control" id="to" placeholder="Enter Request To" name="to" autocomplete="nope" required>
                    </div>   
                    <div class="col-sm-6 form-group">
                        <label for="input-6">Address</label>
                        <input type="text" class="form-control" id="address"  placeholder="Enter Address" name="address" autocomplete="nope" required>
                </div>
            </div>
            <div class="row">
                    <div class="col-sm-4 form-group">
                        <label for="input-1">Request By </label>
                        <textarea class="form-control" id="req_by" style="white-space: pre-wrap;"  placeholder="Enter Request by" name="req_by" autocomplete="nope" required></textarea>
                    </div>   
                    <div class="col-sm-6 form-group">
                        <label for="input-1">Branch</label>
                        <textarea class="form-control" id="branch" style="white-space: pre-wrap;"  placeholder="Enter Branch" name="branch" autocomplete="nope" required></textarea>
                    </div>
                    <div class="col-sm-2 form-group">
                        <label for="input-1">Date </label>
                        <input type="text" readonly class="form-control" value="<?php echo $date_now; ?>"  id="date" placeholder="Enter To" name="date" autocomplete="nope" required>
                    </div> 
            </div>    
            <div class="row">
              <div class="col-sm-12 form-group">
                  <label for="input-1">Subject</label>
                  <input type="text" class="form-control" id="subject" placeholder="Enter Subject" name="subject" autocomplete="nope" required></textarea>
              </div>
            </div>
            <div class="row">
                    <div class="col-sm-12 form-group">
                        <label for="input-1">Subject Content </label>
                        <textarea class="form-control" id="subject_body" style="white-space: pre-wrap;"  placeholder="Enter Subject Content" name="subject_body" autocomplete="nope" required></textarea>
                    </div>   
                   
            </div>
            <div class="row">
                <div class="col-sm-4 form-group">
                   <label for="input-1">Checked by</label>
                    <textarea class="form-control" id="chk_by" style="white-space: pre-wrap;"  placeholder="Enter Checked By" name="chk_by" autocomplete="nope" required></textarea>
                </div>   
                <div class="col-sm-4 form-group">
                        <label for="input-1">Checked by ( <i> Optional </i> )</label>
                        <textarea class="form-control" style="white-space: pre-wrap;"  id="chk_by1" placeholder="Enter Checked By ( Optional )" name="chk_by1" autocomplete="nope" ></textarea>
                </div> 
                <div class="col-sm-4 form-group">
                    <label for="input-1">Checked by ( <i> Optional </i> )</label>
                    <textarea  class="form-control"  style="white-space: pre-wrap;"   id="chk_by2" placeholder="Enter Checked By ( Optional )" name="chk_by2" autocomplete="nope"></textarea>
                </div>   
            </div>   
            <div class="row">
                  <div class="col-sm-4">
                    <label for="input-6">Attachment</label>
                    <input type="file" class="form-control" name="image[]" id="attachment" multiple>
                  </div>
                 <div class="col-sm-4 form-group">
                        <label for="input-6">Recommending Approval</label>
                        <textarea  class="form-control" style="white-space: pre-wrap;"   id="rec_app"  placeholder="Enter Recommending Approval" name="rec_app" autocomplete="nope" required></textarea>
                </div>
                <div class="col-sm-4 form-group">
                        <label for="input-6">Approved By</label>
                        <textarea class="form-control" style="white-space: pre-wrap;"   id="app_by"  placeholder="Enter Approved By" name="app_by" autocomplete="nope" required></textarea>
                </div>
            </div>
                                                        
            <div class="card-footer">
              <div class="row">
                <div class="col-lg-3">
                </div>
                <div class="col-lg-9">
                  <div class="float-sm-right">
                   <button type="submit" name="add_request" class="btn btn-light btn-round px-5"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
                   
                   <button type="button" class="btn btn-light btn-round px-5" onClick="location.href='request'"><i class="fa fa-list"></i>&nbsp;&nbsp;Listing</button>                           
                  </div>
                </div>
              </div>
            </div>  <!-- footer -->

          </div>    <!-- card -->
        </form>

        <?php
                    $createRequest = new ControllerRequest();
                    $createRequest -> ctrCreateRequest();
                    ?>
      </div>
    </div><!--End Row-->

  <div class="overlay toggle-menu"></div>
  </div>    <!-- container-fluid -->
</div>      <!-- content-wrapper -->