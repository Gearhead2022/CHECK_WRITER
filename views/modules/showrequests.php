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
 $branch = $clients['branch'];
 $date = $clients['date'];
 $subject = $clients['subject'];
 $subject_body = $clients['subject_body'];
 $chk_by = $clients['chk_by'];
 $chk_by1 = $clients['chk_by1'];
 $chk_by2 = $clients['chk_by2'];
 $rec_app = $clients['rec_app'];
 $app_by = $clients['app_by'];
 $status = $clients['status'];
 $subject_body1 =str_replace("<br />", '',  $subject_body);
 $user = $_SESSION['type'];

$a_chk_by = explode("<br />", $chk_by);
$new_chk = $a_chk_by[0];
$a_chk_by1 = explode("<br />", $chk_by1);
$new_chk1 = $a_chk_by1[0];
$a_chk_by2 = explode("<br />", $chk_by2);
$new_chk2 = $a_chk_by2[0];

$a_req_by = explode("<br />", $req_by);
$new_req_by= $a_req_by[0];
$a_rec_app = explode("<br />", $rec_app);
$new_rec_app= $a_rec_app[0];
$a_app_by = explode("<br />", $app_by);
$new_app_by = $a_app_by[0];

$under_chk = str_replace($new_chk, "<b><u>$new_chk</u></b>", $chk_by);
$under_chk1 = str_replace($new_chk1, "<b><u>$new_chk1</b></u>", $chk_by1);
$under_chk2 = str_replace($new_chk2, "<b><u>$new_chk2</u></b>", $chk_by2);

$under_req_by = str_replace($new_req_by, "<b><u>$new_req_by</u></b>", $req_by);
$under_rec_app = str_replace($new_rec_app, "<b><u>$new_rec_app</u></b>", $rec_app);
$under_app_by = str_replace($new_app_by, "<b><u>$new_app_by</u></b>", $app_by);


 


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
  	    <h4 class="page-title">REQUEST</h4>
     </div>
   </div> 

    <div class="row">
      <div class="col-lg-12">
        <form  method="POST" enctype="multipart/form-data" autocomplete="nope">
          <div class="card">
            <div class="card-body">
                 <div class="row">
                    <div class="col-sm-12">
                        <a href="extensions/tcpdf/pdf/print_request.php?ref_id='<?php echo $clients['ref_id'];?>'" target="_blank"><button type="button" class="btn btn-light btn-round px-5"><i class="fa fa-print"></i>&nbsp;&nbsp;Print</button></a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <h6 class="text-uppercase text-center"><?php echo $branch ?></h6>
                        </div>
                    </div>
                    <div class="row mt-4">
                    <div class="col-sm-2">
                            <p>REFERENCE NO.:</p>
                        </div>
                        <div class="col-sm-10">
                            <p class=""><?php echo $ref_id ?></p>
                        </div>
                    </div>
                    <div class="row">
                    <div class="col-sm-2">
                            <p>DATE:</p>
                        </div>
                        <div class="col-sm-10">
                            <p class=""><?php echo $date ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            <p>TO:</p>
                        </div>
                        <div class="col-sm-3">
                            <b><p class="text-uppercase"><?php echo $to ?></p></b>
                            <p class="text-uppercase"><?php echo $address ?></p>
                        </div>
                    </div>
                    <div class="row" >
                        <div class="col-sm-2">
                            <p>SUBJECT:</p>
                        </div>
                        <div class="col-sm-10">
                           <p class="text-uppercase"><?php echo $subject ?></p>
                        </div>
                    </div>
                    <div class="row mb-4" style="height: 2px; background-color: white;">
                        <div class="col-sm-12">

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <p><?php echo $subject_body ?></p>
                        </div>
                       
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <p class="text-uppercase" ><?php echo $under_req_by ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                              <p>Checked by:</p>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-sm-12">
                              <p class="text-uppercase" ><?php echo $under_chk ?></p>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-sm-4">
                              <p class="text-uppercase"  ><?php echo $under_chk1 ?></p>
                        </div>
                        <div class="col-sm-4">
                              <p class="text-uppercase" ><?php echo $under_chk2 ?></p>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-sm-12 mt-2">
                              <p>Recommending Approval:</p>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-sm-12">
                            <p class="text-uppercase" ><?php echo $under_rec_app ?> </p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-12">
                              <p>Approved by:</p>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-sm-12">
                           <p class="text-uppercase"  ><?php echo $under_app_by ?> </p>
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
                    
                    </div>
                    <?php } ?>
                  </div>  
             
            <div class="card-footer">
              <div class="row">
                <div class="col-lg-3">
                </div>
                <div class="col-lg-9">
                  <div class="float-sm-right">
                   <button type="button"  idClient="<?php echo $idClient; ?>" status="<?php echo $status; ?>" name="request_done" id="request_done" <?php if($status =="Done"){ echo "Disabled";} ?>  class="btn btn-success btn-round px-5"><i class="fa fa-check"></i>&nbsp;&nbsp;Done</button>
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
          </div>  <!-- card -->
        </form>

        <?php
                    $createRequest = new ControllerRequest();
                    $createRequest -> ctrDone();
               
                   
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

