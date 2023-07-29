<?php 
 $idClient = $_GET['idClient'];

 $clients = (new Connection)->connect()->query("SELECT * FROM working_permit WHERE id = $idClient")->fetch(PDO::FETCH_ASSOC);
 $wp_to = $clients['wp_to'];
 $ref_id = $clients['ref_id'];
 $wp_from = $clients['wp_from'];
 $wp_date = $clients['wp_date']; 
 $status = $clients['status']; 
 $wp_req_for = $clients['wp_req_for'];
 $branch = $clients['branch'];
 $wp_req_by = $clients['wp_req_by'];
 $wp_chk_by = $clients['wp_chk_by'];
 $wp_app_by = $clients['wp_app_by'];
 $wp_app_by1 = $clients['wp_app_by1'];
 $app = $clients['app'];
 $app1 = $clients['app1'];
 $wp_remarks= $clients['wp_remarks'];
 $wp_date = date('F d Y h:i:sa', strtotime($wp_date));
$table = "permit_files";
 $attch = (new ControllerPermits)->ctrShowImg($table, $ref_id);
 $user = $_SESSION['type'];

 

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
}    textarea#wp_remarks {
    height: 100px;
}.app {
    content: "\f00c";
    color: #14abef;
    font-size: 28px;
}

</style>
<div class="clearfix"></div>
<div class="content-wrapper">
  <div class="container-fluid">
   <div class="row pt-2 pb-2">
     <div class="col-sm-12">
  	    <h4 class="page-title">WORKING PERMIT</h4>
     </div>
   </div> 

    <div class="row">
      <div class="col-lg-12">
        <form  method="POST" enctype="multipart/form-data" autocomplete="nope">
          <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                        <div class="div-sm-12">
                        <a href="extensions/tcpdf/pdf/print_permit.php?ref_id='<?php echo $clients['ref_id'];?>'" target="_blank"><button type="button" class="btn btn-light btn-round px-5"><i class="fa fa-print"></i>&nbsp;&nbsp;Print</button></a>
                        </div>
                </div>
            <div class="row">
                    <div class="col-sm-2 form-group">
                            <p>REFERENCE NO.</p>
                    </div>
                    <div class="col-sm-1 form-group">
                            <p>:</p>
                    </div>
                    <div class="col-sm-9 form-group">
                            <p><?php echo $ref_id ?></p>
                    </div>
                 </div>
                 <div class="row">
                    <div class="col-sm-2 form-group">
                            <p>TO</p>
                    </div>
                    <div class="col-sm-1 form-group">
                            <p>:</p>
                    </div>
                    <div class="col-sm-9 form-group">
                            <p><?php echo $wp_to ?></p>
                    </div>
                 </div>
                 <div class="row">
                    <div class="col-sm-2 form-group">
                            <p>FROM</p>
                    </div>
                    <div class="col-sm-1 form-group">
                            <p>:</p>
                    </div>
                    <div class="col-sm-9 form-group">
                            <p><?php echo $wp_from ?></p>
                    </div>
                 </div>
                 <div class="row">
                    <div class="col-sm-2 form-group">
                            <p>DATE </p>
                    </div>
                    <div class="col-sm-1 form-group">
                            <p>:</p>
                    </div>
                    <div class="col-sm-9 form-group">
                            <p><?php echo $wp_date ?></p>
                    </div>
                 </div>
                 <div class="row">
                    <div class="col-sm-2 form-group">
                            <p>REQUEST FOR</p>
                    </div>
                    <div class="col-sm-1 form-group">
                            <p>:</p>
                    </div>
                    <div class="col-sm-9 form-group">
                            <p><?php echo $wp_req_for ?></p>
                    </div>
                 </div>
                 <div class="row">
                    <div class="col-sm-2 form-group">
                            <p>BRANCH</p>
                    </div>
                    <div class="col-sm-1 form-group">
                            <p>:</p>
                    </div>
                    <div class="col-sm-9 form-group">
                            <p><?php echo $branch ?></p>
                    </div>
                 </div>
                 <div class="row">
                    <div class="col-sm-2 form-group">
                            <p>REQUESTED BY</p>
                    </div>
                    <div class="col-sm-1 form-group">
                            <p>:</p>
                    </div>
                    <div class="col-sm-9 form-group">
                            <p><?php echo $wp_req_by ?></p>
                    </div>
                 </div>
                 <div class="row">
                    <div class="col-sm-2 form-group">
                            <p>CHECKED BY</p>
                    </div>
                    <div class="col-sm-1 form-group">
                            <p>:</p>
                    </div>
                    <div class="col-sm-9 form-group">
                            <p><?php echo $wp_chk_by ?></p>
                    </div>
                 </div>
                 <div class="row">
                    <div class="col-sm-2 form-group">
                            <p>APPROVED BY</p>
                    </div>
                    <div class="col-sm-1 form-group">
                            <p>:</p>
                    </div>
                    <div class="col-sm-9 form-group">
                            <p><?php if($app>0){ ?><i  class="fa fa-check app"></i> <?php }echo $wp_app_by ?></p><br>
                            <p><?php if($app1>0){ ?><i class="fa fa-check app"></i> <?php } echo $wp_app_by1 ?></p>
                    </div>
                 </div>
                 <div class="row">
                    <div class="col-sm-2 form-group">
                            <p>REMARKS</p>
                    </div>
                    <div class="col-sm-1 form-group">
                            <p>:</p>
                    </div>
                    <div class="col-sm-9 form-group">
                            <p><?php echo $wp_remarks ?></p>
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
                  <?php if($user == "wp_check"){ ?>
                   <button type="button" name="check_records" id="check_records" idClient="<?php echo $idClient; ?>" user="<?php echo $user; ?>"  class="btn btn-success btn-round px-5"><i class="fa fa-check"></i>&nbsp;&nbsp;CHECK</button>
                   <?php } ?>
                  <?php if($user == "wp_approve"){ ?>
                   <button type="button" name="approve_records" id="approve_records" idClient="<?php echo $idClient; ?>" user="<?php echo $user; ?>"  class="btn btn-success btn-round px-5"><i class="fa fa-check"></i>&nbsp;&nbsp;Approve</button>
                   <?php } ?>
                <?php if($user == "wp_admin" || $user == "admin"){ ?>
                   <button type="button" name="records" id="records" data-toggle="modal" data-target="#exampleModalCenter" <?php if($status =="Done"){ echo "Disabled";} ?> class="btn btn-success btn-round px-5"><i class="fa fa-check"></i>&nbsp;&nbsp;Done</button>
                   <?php } ?>
                   <button type="button" class="btn btn-light btn-round px-5" onClick="location.href='workingpermit'"><i class="fa fa-list"></i>&nbsp;&nbsp;Listing</button>                           
                  </div>
                </div>
              </div>
            </div>  <!-- footer -->

          </div>  
          <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
             <div class="modal-content">
                <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLongTitle">ADD Remarks</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 form-group">
                       
                        <textarea class="form-control"  style="white-space: pre-wrap;" id="wp_remarks" placeholder="Enter Remarks" name="wp_remarks" autocomplete="nope" required></textarea>
                    </div>   
            </div> 
                </div>
                <div class="modal-footer">
                        <button type="button" name ="done_records" idClient="<?php echo $idClient; ?>" status="<?php echo $status;?>" id="done_records"  class="btn btn-primary">Submit</button>
                        <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
           </div>
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
                    $createPermit = new ControllerPermits();
                    $createPermit -> ctrDone();
                    $createPermit -> ctrApprove();
                    $createPermit -> ctrCheck();
               
                   
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

