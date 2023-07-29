
<?php 
$idClient = $_GET['idClient'];
$full_id1 = $_GET['full_id'];

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
$date_claimed= $clients['date_claimed'];
$remarks= $clients['remarks'];
$dateObject = DateTime::createFromFormat('Ymd', $out_date1);
$out_date = $dateObject->format('F j, Y');
$date = date('F d, Y');

$report = (new Connection)->connect()->query("SELECT * from fp_report2 ORDER BY id Desc limit 1")->fetch(PDO::FETCH_ASSOC);
          if(empty($report)){
            $id = 0;
          }else{
            $id = $report['id'];
          }
         $last_id = $id + 1;
         
          $id_holder = "RPP" . str_repeat("0",5-strlen($last_id)).$last_id;     

        $check = (new Connection)->connect()->query("SELECT * FROM fp_report2 WHERE full_id = '$full_id1'")->fetch(PDO::FETCH_ASSOC);
            if(!empty($check)){
                    $report_id2= $check['report_id2'];
                    $branch_name= $check['branch_name'];
                    $branch_address= $check['branch_address'];
                    $branch_tele= $check['branch_tele'];
                    $branch_phone= $check['branch_phone'];
                    $amount_up= $check['amount_up'];
                    $amount_promo= $check['amount_promo'];
                    $date_now= $check['date_now'];
                    $branch_ophead= $check['branch_ophead'];
                    $print = "true";
                    $name1 = "e_report2";
                    $createReport1= new ControllerFullypaid();
                    $createReport1 -> ctrEditReport2FullyPaid();
                 
                   
            }else{
                $branch_name="";
                $branch_address="";
                $branch_tele="";
                $branch_phone="";
                $amount_up="";
                $amount_promo="";
                $date_now= $date;
                $branch_ophead="";
                $print="false";
                $name1="s_report2";
                $createReport1= new ControllerFullypaid();
                $createReport1 -> ctrReport2FullyPaid();
           
            }


?>  
<div class="clearfix"></div>
	
<div class="content-wrapper">
  <div class="container-fluid">
   <div class="row pt-2 pb-2">
     <div class="col-sm-12">
  	    <h4 class="page-title">REPORT 2</h4>
     </div>
   </div> 
    <div class="row">
      <div class="col-lg-12">
        <form  method="POST" enctype="multipart/form-data" >   
          <div class="card">
            <div class="card-body">
                <div class="row mb-3 m-1">
                  <button type="button" class="btn btn-light  px-5" id="report_id2" <?php if($print =="false"){ echo "Disabled";} ?> report_id2 ="<?php echo $report_id2; ?>" ><i class="fa fa-print"></i>&nbsp;&nbsp;PRINT</button>
                </div>
             <div class="row">
                <div class="col-sm-4 form-group">
                <label for="input-1">BRANCH NAME</label>
                <input type="text"  hidden value="<?php echo $idClient; ?>" class="form-control" id="idClient" placeholder="Enter To" name="idClient" autocomplete="nope" >
                <input type="text"  hidden value="<?php echo $full_id; ?>" class="form-control" id="full_id" placeholder="Enter To" name="full_id" autocomplete="nope" >
                <input type="text"  hidden value="<?php echo $name; ?>" class="form-control" id="name" placeholder="Enter To" name="name" autocomplete="nope" >
                <input type="text"  hidden value="<?php echo $address; ?>" class="form-control" id="address" placeholder="Enter To" name="address" autocomplete="nope" >


                    <input type="text"  hidden value="<?php echo $id_holder; ?>" class="form-control" id="report_id2" placeholder="Enter To" name="report_id2" autocomplete="nope" >
                    <input type="text"  class="form-control" id="branch_name" value="<?php echo $branch_name; ?>" placeholder="Enter Branch Name" name="branch_name" autocomplete="nope" >
                </div>
                    <div class="col-sm-5 form-group">
                        <label for="input-1">BRANCH ADDRESS</label>
                        <input type="text" class="form-control"  id="branch_address" value="<?php echo $branch_address; ?>" placeholder="Enter Branch Address"  name="branch_address" autocomplete="nope" required>
                    </div>   
                <div class="col-sm-3 form-group">
                        <label for="input-6">BRANCH TELEPHONE#</label>
                        <input type="text" class="form-control"  id="branch_tele"  placeholder="Enter Telephone #" value="<?php echo $branch_tele; ?>"  name="branch_tele" autocomplete="nope" required>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-2 form-group">
                    <label for="input-1">BRANCH CELLPHONE#</label>
                    <input type="text" class="form-control" id="branch_phone" value="<?php echo $branch_phone; ?>" placeholder="Enter Cellphone #" name="branch_phone" autocomplete="nope" >
                </div>
                    <div class="col-sm-4 form-group">
                        <label for="input-1">Amount Renew</label>
                        <input type="text"  class="form-control" id="amount_up" placeholder="Enter Qualified Amount to Renew" value="<?php echo $amount_up; ?>" name="amount_up" autocomplete="nope" required>
                    </div>   
                <div class="col-sm-4 form-group">
                        <label for="input-6">Amount Promo</label>
                        <input type="text" class="form-control" id="amount_promo" value="<?php echo $amount_promo; ?>"  placeholder="Enter Cash Incentive Promo" name="amount_promo" autocomplete="nope" required>
                </div>
                <div class="col-sm-2 form-group">
                        <label for="input-6">DATE</label>
                        <input type="text" class="form-control" readonly id="date_now"  placeholder="Enter Date Claimed" value="<?php echo $date_now; ?>" name="date_now" autocomplete="nope" required>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 form-group">
                        <label for="input-6">BRANCH OPERATION HEAD</label>
                        <input type="text" class="form-control"  id="branch_ophead"  placeholder="Enter Branch Operation Head" value="<?php echo $branch_ophead; ?>" name="branch_ophead" autocomplete="nope" required>
                </div>
               
            </div>
                                                        
            <div class="card-footer">
              <div class="row">
                <div class="col-lg-3">
                </div>
                <div class="col-lg-9">
                  <div class="float-sm-right">
                   <button type="submit" name="<?php echo $name1; ?>" class="btn btn-light btn-round px-5"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
                   <button type="button" class="btn btn-light btn-round px-5" onClick="location.href='index.php?route=showfullypaid&idClient=<?php echo $idClient;?>'"><i class="fa fa-times"></i>&nbsp;&nbsp;CANCEL</button>                           
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

      
      </div>
    </div><!--End Row-->

  <div class="overlay toggle-menu"></div>
  </div>    <!-- container-fluid -->
</div>      <!-- content-wrapper -->