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

$clients = (new Connection)->connect()->query("SELECT * FROM fully_paid WHERE id = $idClient")->fetch(PDO::FETCH_ASSOC);
$full_id = $clients['full_id'];
$fpid = $clients['fpid'];
$user_id = $clients['user_id'];
$name = $clients['name']; 
$out_date1 = $clients['out_date']; 
$bank = $clients['bank'];
$status = $clients['status'];
$branch_name = $clients['branch_name'];
$prrno = $clients['prrno'];
$prrdate = $clients['prrdate'];
$atm_status = $clients['atm_status'];
$date_claimed= $clients['date_claimed'];
$remarks= $clients['remarks'];
$dateObject = DateTime::createFromFormat('Ymd', $out_date1);
$out_date = $dateObject->format('F j, Y');
if($date_claimed ==""){
  $date_words="";
}else{
  $date_timestamp = strtotime($date_claimed);
  $date_words = date('F j, Y \a\t g:i a', $date_timestamp);
}
?>  
<div class="clearfix"></div>
	
<div class="content-wrapper">
  <div class="container-fluid">
   <div class="row pt-2 pb-2">
     <div class="col-sm-12">
  	    <h4 class="page-title">EDIT RECORDS</h4>
     </div>
   </div> 
    <div class="row">
      <div class="col-lg-12">
        <form  method="POST" enctype="multipart/form-data" >   
          <div class="card">
            <div class="card-body">
             <div class="row">
                <div class="col-sm-2 form-group">
                <label for="input-1">ID</label>
                    <input type="text"  hidden value="<?php echo $idClient; ?>" class="form-control" id="id" placeholder="Enter To" name="id" autocomplete="nope" >
                    <input type="text" readonly  value="<?php echo $fpid; ?>" class="form-control" id="fpid" placeholder="Enter To" name="fpid" autocomplete="nope" >
                </div>
                    <div class="col-sm-4 form-group">
                        <label for="input-1">FULL NAME</label>
                        <input type="text" class="form-control" readonly id="name" placeholder="Enter Request To" value="<?php echo $name; ?>" name="name" autocomplete="nope" required>
                    </div>   
                <div class="col-sm-4 form-group">
                        <label for="input-6">OUT DATE</label>
                        <input type="text" class="form-control" readonly id="out_date"  placeholder="Enter Address" value="<?php echo $out_date; ?>" name="out_date" autocomplete="nope" required>
                </div>
                <div class="col-sm-2 form-group">
                        <label for="input-6">BANK</label>
                        <input type="text" class="form-control" readonly id="bank"  placeholder="Enter Address" value="<?php echo $bank; ?>" name="bank" autocomplete="nope" required>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 form-group">
                <label for="input-1">STATUS</label>
                    <input type="text" readonly  value="<?php echo $status; ?>" class="form-control" id="status" placeholder="Enter Status" name="status" autocomplete="nope" >
                </div>
                    <div class="col-sm-4 form-group">
                        <label for="input-1">BRANCH NAME</label>
                        <input type="text" readonly class="form-control" id="branch_name" placeholder="Enter Request To" value="<?php echo $branch_name; ?>" name="branch_name" autocomplete="nope" required>
                    </div>   
                <div class="col-sm-4 form-group">
                        <label for="input-6">PRR NO.</label>
                        <input type="text" class="form-control" id="prrno"  placeholder="Enter PRR No." value="<?php echo $prrno; ?>" name="prrno" autocomplete="nope" >
                </div>
            </div>
            <div class="row">
            <div class="col-sm-4 form-group">
                        <label for="input-6">PRR DATE</label>
                        <input type="date" class="form-control" id="prrdate"  placeholder="Enter PRR Date" value="<?php echo $prrdate; ?>" name="prrdate" autocomplete="nope" >
                </div>
                <div class="col-sm-4 form-group">
                        <label for="input-6">ATM STATUS</label>
                        <select name="atm_status" class="form-control"  id="atm_status" required> 
                            <option value="<?php echo $atm_status; ?>"><?php echo $atm_status; ?></option>
                            <option value="Claimed">CLAIMED</option>
                            <option value="Unclaimed">UNCLAIMED</option>
                        </select>                
                </div>
                <div class="col-sm-4 form-group">
                        <label for="input-6">DATE CLAIMED</label>
                        <input type="text" class="form-control" readonly id="date_claimed"  placeholder="Enter Date Claimed" value="<?php echo $date_words; ?>" name="date_claimed" autocomplete="nope" required>
                </div>
            </div>
            <div class="row">
                    <div class="col-sm-12 form-group">
                        <label for="input-1">REMARKS</label>
                        <textarea class="form-control"  placeholder="Enter Remarks" name="remarks" autocomplete="nope" ><?php echo $remarks; ?></textarea>
                    </div>   
                   
            </div> 
            
           
                                                        
            <div class="card-footer">
              <div class="row">
                <div class="col-lg-3">
                </div>
                <div class="col-lg-9">
                  <div class="float-sm-right">
                   <button type="submit" name="edit_fullpaid" class="btn btn-light btn-round px-5"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
                   
                   <button type="button" class="btn btn-light btn-round px-5" onClick="location.href='fullypaid'"><i class="fa fa-list"></i>&nbsp;&nbsp;Listing</button>                           
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
                       $createClient = new ControllerFullypaid();
                       $createClient -> ctrEditFullyPaid();
                     
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