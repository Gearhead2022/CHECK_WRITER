
<style>
    textarea#wp_req_for {
    height: 100px;
}
.docuRow{
    height: 350px;;
}
.modal-dialog {
    max-width: 339px; /* Set the maximum width of the modal */
    margin: 1.75rem auto; /* Adjust the margin to center the modal horizontally */
  }

  #folders{
    width: 100%;
  }
  i#icnFolder {
    float: left;
    font-size: 17px;
}
</style>
<?php 
 $id_num = $_GET['id_num'];
 $employee_name = $_GET['employee_name'];
 $company = $_GET['company'];

 if($company=="EMB"){
  $route ="clients";
 }elseif($company=="FCH"){
  $route ="fch";
 }
 elseif($company=="PSPMI"){
  $route ="pspmi";
 }
 elseif($company=="RLC"){
  $route ="rlc";
 }

 $backup = (new Connection)->connect()->query("SELECT * from employee_folder ORDER BY id Desc limit 1")->fetch(PDO::FETCH_ASSOC);
          if(empty($backup)){
            $id = 0;
          }else{
            $id = $backup['id'];
          }
         $last_id = $id + 1;
         
          $id_holder = "FI" . str_repeat("0",5-strlen($last_id)).$last_id;     

          date_default_timezone_set('Asia/Manila');
		      $date_now =date('Y-m-d'); 

          $user_id = $_SESSION['user_id'];
          $branch_name = $_SESSION['branch_name'];

          $createFolder = new ControllerPermits();
          $folder = $createFolder->ctrShowFolders($id_num);


        
?>  
<div class="clearfix"></div>
	
<div class="content-wrapper">
  <div class="container-fluid">
   <div class="row pt-2 pb-2">
     <div class="col-sm-12">
  	    <h4 class="page-title"><?php echo $employee_name;?> Documents</h4>
     </div>
   </div> 
    <div class="row">
      <div class="col-lg-12">
        <form  method="POST" enctype="multipart/form-data" >   
          <div class="card">
            <div class="card-body">
                <h4>Folder</h4>
             <div class="row mb-5">
                <?php 
                    if(!empty($folder)){

                        foreach ($folder as $row) {
                          $folderid = $row['folderid'];
                          $folder_name = $row['folder_name'];
                          $folder_id =  $row['id'];
                            ?>
                            <div class="col-sm-2 mt-3 form-group">
                              <div class="btn-group">
                                  <button type="button" class="btn btn-light folders" folderid ="<?php echo $folderid; ?>" company ="<?php echo $company; ?>" 
                                  id_num ="<?php echo $id_num; ?>" employee_name ="<?php echo $employee_name; ?>"  data-toggle="tooltip"  
                                  data-placement="top" title="<?php echo $folder_name; ?>" id="folders"> <p class="text-truncate" style="max-width: 150px;  font-size: 13px;"><i class="fa fa-folder" id="icnFolder">&nbsp; &nbsp;</i><?php echo $folder_name; ?></p></button>
                                  <button type="button" class="btn btn-light btn-sm" id="dropdownMenuReference" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-reference="parent">
                                     <span><i class="fa fa-ellipsis-v"></i></span>
                                  </button>
                                  <div class="dropdown-menu" aria-labelledby="dropdownMenuReference"> 
                                      <a class="dropdown-item editDocu" id="editDocu" folder_name = "<?php echo $folder_name; ?>" folder_id = "<?php echo $folder_id; ?>">Edit</a>
                                      <a class="dropdown-item deleteDocu" id="deleteDocu" folderid ="<?php echo $folderid; ?>" folder_id ="<?php echo $folder_id; ?>" company ="<?php echo $company; ?>" 
                                  id_num ="<?php echo $id_num; ?>" employee_name ="<?php echo $employee_name; ?>">Delete</a>
                                  </div>
                             </div>
                          </div> 
                       <?php }
                    }else{?>
                        <div class="col-md-12 docuRow">

                        </div>
                   <?php } ?>
                        
                  
             
             </div>
           
                                                        
            <div class="card-footer">
              <div class="row">
                <div class="col-lg-3">
                </div>
                <div class="col-lg-9">
                  <div class="float-sm-right">
                   <button type="button" name="add_backup" class="btn btn-light btn-round px-5" data-toggle="modal" data-target="#exampleModalCenter"><i class="fa fa-plus"></i>&nbsp;&nbsp;ADD FOLDER</button>
                   
                   <button type="button" class="btn btn-light btn-round px-5" onClick="location.href='<?php echo $route; ?>'"><i class="fa fa-list"></i>&nbsp;&nbsp;Listing</button>                           
                  </div>
                </div>
              </div>
            </div>  <!-- footer -->

          </div>    <!-- card -->
        </form>

      
      </div>
    </div><!--End Row-->

    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
             <div class="modal-content">
                <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLongTitle">ADD Folder</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                <form  method="post">
                <div class="row">
                    <div class="col-sm-12 form-group">
                        <label for="input-6">Folder Name</label>
                        <input type="text" class="form-control" id="folder_name" placeholder="Enter Folder Name" name="folder_name" autocomplete="nope" required>
                        <input type="text" hidden class="form-control" id="folderid"  name="folderid" value="<?php echo $id_holder ?>" autocomplete="nope">
                        <input type="text" hidden class="form-control" id="employee_name"  name="employee_name" value="<?php echo $employee_name ?>" autocomplete="nope">
                        <input type="text" hidden class="form-control" id="id_num"  name="id_num" value="<?php echo $id_num ?>" autocomplete="nope">
                        <input type="text" hidden class="form-control" id="company"  name="company" value="<?php echo $company ?>" autocomplete="nope">

                    </div>   
            </div> 
                </div>
                <div class="modal-footer">
                        <button type="submit" name ="addFolder" class="btn btn-primary">Submit</button>
                        <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
              </form>
              <?php
                   
                    $createFolder -> addFolder();
                    ?>
           </div>
        </div>


        <div class="modal fade" id="editDocument" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
          <form  method="post">
             <div class="modal-content">
                <div class="modal-header">
              
                   <h5 class="modal-title" id="exampleModalLongTitle">Edit Folder Name</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                
               
                </div>
                <div class="modal-footer">
                        <button type="submit" name ="editFolder" class="btn btn-primary">Submit</button>
                        <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
              </form>
              <?php
                   
                    $createFolder -> editFolder();
                    $createFolder -> ctrDeleteFolder();
                    ?>
           </div>
        </div>

  <div class="overlay toggle-menu"></div>
  </div>    <!-- container-fluid -->
</div>      <!-- content-wrapper -->