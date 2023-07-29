<?php 
 $idClient = $_GET['idClient'];

 $clients = (new Connection)->connect()->query("SELECT * FROM fully_paid WHERE id = $idClient")->fetch(PDO::FETCH_ASSOC);
 $full_id = $clients['full_id'];
 $fpid = $clients['fpid'];
 $user_id = $clients['user_id'];
 $name = $clients['name']; 
 $out_date1 = $clients['out_date']; 
 $bank = $clients['bank'];
 $status = $clients['status'];
 $address = $clients['address'];
 $branch_name = $clients['branch_name'];
 $prrno = $clients['prrno'];
 $prrdate = $clients['prrdate'];
 $atm_status = $clients['atm_status'];
 $date_claimed1= $clients['date_claimed'];
 $remarks= $clients['remarks'];
 $dateObject = DateTime::createFromFormat('Ymd', $out_date1);
 $out_date = $dateObject->format('F j, Y');
 if(!empty($date_claimed1)){
    $date_claimed = date('F j, Y \a\t g:i A', strtotime($date_claimed1));
}else{
    $date_claimed = $date_claimed1;
}

 

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
  	    <h4 class="page-title">FULLY PAID ACCOUNT</h4>
     </div>
   </div> 

    <div class="row">
      <div class="col-lg-12">
        <form  method="POST" enctype="multipart/form-data" autocomplete="nope">
          <div class="card">
            <div class="card-body">
                <!-- <div class="row mb-3">
                        <div class="div-sm-12">
                        <a href="extensions/tcpdf/pdf/print_permit.php?ref_id='<?php echo $clients['ref_id'];?>'" target="_blank"><button type="button" class="btn btn-light btn-round px-5"><i class="fa fa-print"></i>&nbsp;&nbsp;Print</button></a>
                        </div>
                </div> -->
            <div class="row">
                    <div class="col-sm-2 form-group">
                            <p>ID</p>
                    </div>
                    <div class="col-sm-1 form-group">
                            <p>:</p>
                    </div>
                    <div class="col-sm-9 form-group">
                            <p><?php echo $fpid ?></p>
                    </div>
                 </div>
                 <div class="row">
                    <div class="col-sm-2 form-group">
                            <p>NAME</p>
                    </div>
                    <div class="col-sm-1 form-group">
                            <p>:</p>
                    </div>
                    <div class="col-sm-9 form-group">
                            <p><?php echo $name ?></p>
                    </div>
                 </div>
                 <div class="row">
                    <div class="col-sm-2 form-group">
                            <p>ADDRESS</p>
                    </div>
                    <div class="col-sm-1 form-group">
                            <p>:</p>
                    </div>
                    <div class="col-sm-9 form-group">
                            <p><?php echo $address ?></p>
                    </div>
                 </div>
                 <div class="row">
                    <div class="col-sm-2 form-group">
                            <p>OUT DATE</p>
                    </div>
                    <div class="col-sm-1 form-group">
                            <p>:</p>
                    </div>
                    <div class="col-sm-9 form-group">
                            <p><?php echo $out_date ?></p>
                    </div>
                 </div>
                 <div class="row">
                    <div class="col-sm-2 form-group">
                            <p>BANK </p>
                    </div>
                    <div class="col-sm-1 form-group">
                            <p>:</p>
                    </div>
                    <div class="col-sm-9 form-group">
                            <p><?php echo $bank ?></p>
                    </div>
                 </div>
                 <div class="row">
                    <div class="col-sm-2 form-group">
                            <p>STATUS</p>
                    </div>
                    <div class="col-sm-1 form-group">
                            <p>:</p>
                    </div>
                    <div class="col-sm-9 form-group">
                            <p><?php echo $status ?></p>
                    </div>
                 </div>
                 <div class="row">
                    <div class="col-sm-2 form-group">
                            <p>BRANCH NAME</p>
                    </div>
                    <div class="col-sm-1 form-group">
                            <p>:</p>
                    </div>
                    <div class="col-sm-9 form-group">
                            <p><?php echo $branch_name ?></p>
                    </div>
                 </div>
                 <div class="row">
                    <div class="col-sm-2 form-group">
                            <p>PRRNO</p>
                    </div>
                    <div class="col-sm-1 form-group">
                            <p>:</p>
                    </div>
                    <div class="col-sm-9 form-group">
                            <p><?php echo $prrno ?></p>
                    </div>
                 </div>
                 <div class="row">
                    <div class="col-sm-2 form-group">
                            <p>PRR DATE</p>
                    </div>
                    <div class="col-sm-1 form-group">
                            <p>:</p>
                    </div>
                    <div class="col-sm-9 form-group">
                            <p><?php echo $prrdate ?></p>
                    </div>
                 </div>
                 <div class="row">
                    <div class="col-sm-2 form-group">
                            <p>ATM STATUS</p>
                    </div>
                    <div class="col-sm-1 form-group">
                            <p>:</p>
                    </div>
                    <div class="col-sm-9 form-group">
                            <p><?php echo $atm_status ?></p>
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
                            <p><?php echo $remarks ?></p>
                    </div>
                 </div>
                 <div class="row">
                    <div class="col-sm-2 form-group">
                            <p>DATE CLAIMED</p>
                    </div>
                    <div class="col-sm-1 form-group">
                            <p>:</p>
                    </div>
                    <div class="col-sm-9 form-group">
                            <p><?php echo $date_claimed ?></p>
                    </div>
                 </div>
                 
                </div>
            <div class="card-footer">
              <div class="row">
                <div class="col-lg-3">
                </div>
                <div class="col-lg-9">
                  <div class="float-sm-right">
                   <button type="button" name="records" id="records" data-toggle="modal" data-target="#exampleModalCenter" class="btn btn-success btn-round px-5"><i class="fa fa-print"></i>&nbsp;&nbsp;PRINT</button>
                   <button type="button" class="btn btn-light btn-round px-5" onClick="location.href='fullypaid'"><i class="fa fa-list"></i>&nbsp;&nbsp;Listing</button>                           
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
                   <h5 class="modal-title" id="exampleModalLongTitle">GENERATE REPORTS</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6 form-group mx-auto">
                        <button type="button" id="fpReport1" full_id="<?php echo $full_id; ?>"  idClient="<?php echo $idClient; ?>" class="btn btn-light">Print 1</button>
                        <button type="button" id="fpReport2" full_id="<?php echo $full_id; ?>"  idClient="<?php echo $idClient; ?>" class="btn btn-light">Print 2</button>
                    </div>   
                 </div> 
                 
                </div>
                <div class="modal-footer">
                        <button type="button"  class="btn btn-light" data-dismiss="modal">Close</button>
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

