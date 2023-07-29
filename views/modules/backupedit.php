<?php
$idClient = $_GET['idClient'];

$clients = (new Connection)->connect()->query("SELECT * FROM backup WHERE id = $idClient")->fetch(PDO::FETCH_ASSOC);
$backup_id = $clients['backup_id'];
$user_id = $clients['user_id'];
$branch_name = $clients['branch_name'];
$date_time = $clients['date_time'];
$subject = $clients['subject'];
$status = $clients['status'];

$new_date = date("F j, Y", strtotime($date_time));
$table = "backup_files";
$edit_date=date("Y-m-d", strtotime($date_time)); 

$attch = (new ControllerBackup)->ctrShowBackupFiles($table, $backup_id);
?>  
<style>
    .image-container{
        text-align: center;
    }
    .image-container img {
    display: block;
    margin: auto;
    width: 100px;
    height: 100;
}
</style>
<div class="clearfix"></div>
	
<div class="content-wrapper">
  <div class="container-fluid">
   <div class="row pt-2 pb-2">
     <div class="col-sm-12">
  	    <h4 class="page-title">DAILY BACKUP</h4>
     </div>
   </div> 
    <div class="row">
      <div class="col-lg-12">
        <form  method="POST" enctype="multipart/form-data" >   
          <div class="card">
            <div class="card-body">
             <div class="row"> 
                <div class="col-sm-4 form-group">
                <label for="input-1">BACKUP No. </label>
                    <input type="text" readonly  value="<?php echo $backup_id; ?>" class="form-control" id="backup_id" placeholder="Enter To" name="backup_id" autocomplete="nope" >
                    <input type="text" hidden  value="<?php echo $idClient; ?>" class="form-control" id="id" placeholder="Enter To" name="id" autocomplete="nope" >
                    <input type="text" hidden  value="<?php echo $user_id; ?>" class="form-control" id="user_id" placeholder="Enter To" name="user_id" autocomplete="nope" >
                    <input type="text" hidden  value="<?php echo $status; ?>" class="form-control" id="status" placeholder="Enter To" name="status" autocomplete="nope" >
                    <input type="text" hidden  value="<?php echo $edit_date; ?>" class="form-control" id="edit_date" placeholder="Enter To" name="edit_date" autocomplete="nope" >

                </div>
                <div class="col-sm-4 form-group">
                        <label for="input-1">BRANCH NAME </label>
                        <input type="text" class="form-control" id="branch_name" placeholder="Enter To" name="branch_name" value="<?php echo $branch_name; ?>" readonly>
                    </div> 
                    <div class="col-sm-4 form-group">
                        <label for="input-6">Date</label>
                        <input type="date" class="form-control" id="new_date"   name="new_date" value="<?php echo $edit_date; ?>" autocomplete="nope" required>
                </div>
            </div>
            <div class="row">
                 <div class="col-sm-4">
                    <label for="input-6">SUBJECT</label>
                    <textarea class="form-control"  placeholder="Enter Subject" name="subject" id="subject"><?php echo $subject; ?></textarea>
                  </div>
                  <div class="col-sm-4">
                    <label for="input-6">Attachment</label>
                    <input type="file" class="form-control" name="image[]" id="attachment" multiple>
                  </div>
            </div>
            <div class="row mt-3">
                    <div class="col-sm-12">
                    <label for="input-6">FILES</label>
                    </div>
                  </div>
                  <div class="row mt-2">
                    <?php  foreach ($attch as $key => $value) { 
                       $file_name = $value["file_name"];
                       $file_id = $value['id']; ?>
                    <div class="col-sm-4">
                    <div class="card" style="width: 18rem;">
                        <div class="card-header">
                        <div class="d-flex">
                        <div class="btn-group">
                            <button type="button" class="btn btn-light new" data-toggle="tooltip" data-placement="top" title="<?php echo $file_name ?>" style="width: 200px;"> <p class="text-truncate" style="max-width: 180px;  text-align: center; font-size: 14px;"><i class="fa fa-files-o"> </i>&nbsp;&nbsp;<?php echo $file_name; ?></p></button>
                            <button type="button" class="btn btn-light btn-sm dlt_file" idClient ="<?php echo $idClient; ?>" file_name ="<?php echo $file_name; ?>"
                            branch_name ="<?php echo $branch_name; ?> "new_date ="<?php echo $new_date; ?>"  file_id ="<?php echo $file_id; ?>" id="dropdownMenuReference">
                            <span><i class="fa fa-close"></i></span>
                            </button>
                            
                        </div>
                        </div>
                        </div>
                        <div class="card-body image-container">
                           <img src="views/img/code3.png" alt="">
                        </div>
                    </div>
                    </div>
                    <?php } ?>
                  </div>
                                                        
            <div class="card-footer">
              <div class="row">
                <div class="col-lg-3">
                </div>
                <div class="col-lg-9">
                  <div class="float-sm-right">
                   <button type="submit" name="edit_backup" class="btn btn-light btn-round px-5"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
                   
                   <button type="button" class="btn btn-light btn-round px-5" onClick="location.href='backups'"><i class="fa fa-list"></i>&nbsp;&nbsp;Listing</button>                           
                  </div>
                </div>
              </div>
            </div>  <!-- footer -->

          </div>    <!-- card -->
        </form>
 
        <?php
                    $editBackup = new ControllerBackup();
                    $editBackup -> ctrEditBackup();
                    $deleteImg = new ControllerBackup();
                    $deleteImg  -> ctrDeleteImg();
                    ?> 
      </div>
    </div>

  <div class="overlay toggle-menu"></div>
  </div>    <!-- container-fluid -->
</div>      <!-- content-wrapper -->