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
 $year = date('Y', strtotime($date_time));
$month = date('F', strtotime($date_time));
 $attch = (new ControllerBackup)->ctrShowBackupFiles($table, $backup_id);
 
 $type = $_SESSION['type'];
 
 ?> 
<!-- <style>.dropdown-toggle::before {
  content: ":";
  margin-left: 5px;
  vertical-align: middle;
}
</style> -->
<style>
    .image-container{
        text-align: center;
    }.dropdown-item{
  cursor: pointer;
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
  	    <h4 class="page-title">BACKUP</h4>
     </div>
   </div> 

    <div class="row">
      <div class="col-lg-12">
        <form  method="POST" enctype="multipart/form-data" autocomplete="nope">
          <div class="card">
            <div class="card-body">
               <div class="btn-group">
                    <button type="button" class="btn btn-light new mt-2  mb-2"  style="width: 221px; height: 47px;">
                     <p class="text-truncate" style="max-width: 180px;  text-align: left; font-size: 16px;">
                    </i>&nbsp;&nbsp; <?php echo $new_date; ?></p>
                    </button>
                    <button type="button" class="btn btn-light btn-sm mt-2" style="height: 47px;" id="dropdownMenuReference" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-reference="parent">
                            <span><i class="fa fa-ellipsis-v"></i></span>
                    </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuReference"> 
                                <a class="dropdown-item downloadFiles"  new_date="<?php echo $new_date; ?>"  branch_name = "<?php echo $branch_name; ?>"  id='toDownload' >Download All</a>
                            </div>
                    </div>

                    <div class="row mt-3">
                    <div class="col-sm-12">
                    <h3 class="page-title">FILES</h3>
                    </div>
                  </div>
                <div class="row mt-2">
                    <input type="text" hidden value="<?php echo $branch_name;?>" name="branch_name" id="branch_name">
                    <?php foreach ($attch as $key => $value) { 
                            $file_name = $value["file_name"];
                     ?>
                   <div class="col-sm-3">
                    <div class="card" style="width: 16rem;">
                        <div class="card-header">
                        <div class="d-flex">
                        <div class="btn-group">
                            <button type="button" class="btn btn-light new" data-toggle="tooltip" data-placement="top" title="<?php echo $file_name ?>" style="width: 180px;"> <p class="text-truncate" style="max-width: 180px;  text-align: center; font-size: 14px;"><i class="fa fa-files-o"> </i>&nbsp;&nbsp;<?php echo $file_name; ?></p></button>
                            <button type="button" class="btn btn-light btn-sm" id="dropdownMenuReference" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-reference="parent">
                            <span><i class="fa fa-ellipsis-v"></i></span>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuReference"> 
                                <a class="dropdown-item" href="views/files/Backup/<?php echo $branch_name;?>/<?php echo $year;?>/<?php echo $month;?>/<?php echo $new_date;?>/<?php echo $file_name;?>" Download="<?php echo $file_name;?>">Download</a>
                            </div>
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
              
            </div>
            <div class="card-footer">
              <div class="row">
                <div class="col-lg-3">
                </div>
                <div class="col-lg-9">
                  <div class="float-sm-right">
                      <?php if($type == "admin" || $type == "backup_admin"  ){ ?>
                        <button type="button" class="btn btn-light btn-round px-5 toReceive" status ="<?php echo $status; ?>"  backup_id ="<?php echo $backup_id; ?>"><i class="fa fa-inbox"></i>&nbsp;&nbsp;Receive</button>                           
                        <?php } ?>
                   <button type="button" class="btn btn-light btn-round px-5" onClick="location.href='backups'"><i class="fa fa-list"></i>&nbsp;&nbsp;Listing</button>                           
                  </div>
                </div>
              </div>
            </div>  

          </div>  
      

        
        </form>
        <?php
          $downloadFiles= new ControllerBackup();
          $downloadFiles -> ctrDownloadFiles();
        ?>
 
      </div>
    </div><!--End Row-->
  <div class="overlay toggle-menu"></div>
  </div>    <!-- container-fluid -->
</div>      <!-- content-wrapper -->

