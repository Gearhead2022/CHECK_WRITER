
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

.image-upload>input {
    display: none;
    }
    #menuSubmit {
    background: #1a1814;
    border: 0;
    margin: 0px 3px;
    color: #fff;
    padding: 6px 23px 7px 25px;
    transition: 0.4s;
    border-radius: 9px;
    border: 1px solid #cda45e;
    font-size: 13px;
}img#img1 {
    width: 171px;
    height: 145px;
    border: 1px solid #454035;
}
img#fileImg {
  width: 171px;
    height: 145px;

    /* background: black; */
    border: 1px solid #454035;
}
img#img1:hover {
    transform: scale(1.1);
}
</style>
<?php 
 $id_num = $_GET['id_num'];
 $employee_name = $_GET['employee_name'];
 $company = $_GET['company'];
 $folderid = $_GET['folderid'];


 $backup = (new Connection)->connect()->query("SELECT * from employee_folder WHERE id_num = '$id_num' ORDER BY id Desc limit 1")->fetch(PDO::FETCH_ASSOC);
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
          $getFile = $createFolder->ctrGetFolder($folderid);

          foreach ($getFile as $row2) {
            # code...
            $folder_name1 =  $row2['folder_name'];
          }

          $getFiles = $createFolder->ctrGetfiles($folderid);
        
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
            <div class="row ml-2">
                <button type="button" class="btn btn-light"  company ="<?php echo $company; ?>" id_num ="<?php echo $id_num; ?>" employee_name ="<?php echo $employee_name; ?>"
                  id="btnBack"><i class="fa fa-arrow-left"></i></button>
                <h5 class="ml-4"> <?php echo $folder_name1; ?> </h5>
            </div>
             <div class="row mb-5">

            <div class="col-md-12 mt-3 image-upload">
                            <input type="text" name="folderid" id="busid" value="<?php echo $folderid; ?>">
                            <label for="file-input">
                                <img id="fileImg" src="views/img/add.png"/>
                            </label>
                            <input id="file-input" name="image[]"  type="file"  multiple />
                                <?php 
                                if(!empty($getFiles)){
                                    foreach ($getFiles as $getGallerys) {
                                        # code...
                                        $img_name = $getGallerys['file_name'];
                                    ?>
                                    <a href="#" class="pop">
                                    <img id="img1" class="m-1" src="views/files/employees/<?php echo $img_name; ?>">
                                    </a>
                                <?php  }
                                }
                                ?>
                            
                        </div>
                        
                  
             
             </div>
           
                                                        
            <div class="card-footer">
              <div class="row">
                <div class="col-lg-3">
                </div>
                <div class="col-lg-9">
                  <div class="float-sm-right">
                   <button type="submit" name="add_files" class="btn btn-light btn-round px-5"><i class="fa fa-plus"></i>&nbsp;&nbsp;ADD Files</button>
                   
                   <button type="button" class="btn btn-light btn-round px-5" onClick="location.href='clients'"><i class="fa fa-list"></i>&nbsp;&nbsp;Listing</button>                           
                  </div>
                </div>
              </div>
            </div>  <!-- footer -->

          </div>    <!-- card -->
        </form>
               <?php
               $addFiles = $createFolder->ctrAddFiles();
                
               ?>                
      
      </div>
    </div><!--End Row-->

    <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div  class="modal-dialog modal-dialog-centered "  >
      <div class="modal-content" style="width: 600px;" >              
        <div class="modal-body"  style="width: 600px;" >
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <img src="" class="imagepreview" style="width: 100%;" >
        </div>
      </div>
    </div>
</div>


  <div class="overlay toggle-menu"></div>
  </div>    <!-- container-fluid -->
</div>      <!-- content-wrapper -->

