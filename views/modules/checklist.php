<?php 
 $client = (new Connection)->connect()->query("SELECT * from checklist ORDER BY id Desc limit 1")->fetch(PDO::FETCH_ASSOC);
          if(empty($client)){
            $id = 0;
          }else{
            $id = $client['id'];
          } $last_id = $id + 1;
          $id_holder = "CK" . str_repeat("0",4-strlen($last_id)).$last_id; 
          
       $full_name = $_SESSION['branch_name'];
?> 
<style>
  .modal-content {
    width: 1000px;
   
} 

</style>
<div class="clearfix"></div>
  
<div class="content-wrapper">
   <div class="container-fluid">
     <div class="row pt-2 pb-2">
        <div class="col-sm-12">
          <h4 class="page-title">DAILY CHECKLIST</h4>
        </div>
     </div>

      <div class="row">
        <div class="col-lg-12">
        
          <div class="card">
            <div class="card-header float-sm-right">
              <div class="row">
                <?php if($_SESSION['type']=="admin" || $_SESSION['type']=="backup_user" || $_SESSION['type']=="backup_admin"){?>
                  <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1" data-toggle="modal" data-target="#exampleModalCenter"><i class="fa fa-plus"></i> <span>&nbsp;ADD CHECKLIST</span> </button>
              <?php  }?>
              


                  <div class="col-sm-2 form-group" style="padding-top: 10px;margin-bottom: 6px;">
              </div>
            </div>            
            <div class="card-body">
              <div class="table-responsive">
              <table id="default-datatable" class="table table-bordered table-hover table-striped checklistTable">
                <thead>
                <tr>
                   <th>ID</th>
                  <th>NAME</th>
                  <th>DATE<E/th>
                  <th>Action</th>
                </tr>
                </thead>
              </table>
            </div>
            </div>
          </div>
        </div>
                
      </div>    <!-- row -->
      <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
             <div class="modal-content">
                <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLongTitle">ADD CHECKLIST</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                <form  method="post">
                <div class="row">
                    <div class="col-sm-12 form-group">
                        <label for="input-6">DATE</label>
                        <input type="date" class="form-control" id="chk_date" placeholder="Enter Folder Name" name="chk_date" autocomplete="nope" required>
                        <input type="text" hidden class="form-control" id="chk_id"  name="chk_id" value="<?php echo $id_holder ?>" autocomplete="nope">
                        <input type="text" hidden class="form-control" id="full_name"  name="full_name" value="<?php echo $full_name; ?>" autocomplete="nope">
                       

                    </div>   
            </div> 
                </div>
                <div class="modal-footer">
                        <button type="submit" name ="addChecklist" class="btn btn-primary">Submit</button>
                        <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
              </form>
              <?php
                     $createChecklist = new ControllerChecklist();
                    $createChecklist -> ctrCreateChecklist();
                    ?>
           </div>
        </div>



        <div class="modal fade" id="chacklistEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
             <div class="modal-content">
                <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLongTitle">EDIT CHECKLIST</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <form  method="post">
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                        <button type="submit" name ="editChecklist" class="btn btn-primary">Submit</button>
                        <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
              </form>
              <?php
                     $createChecklist = new ControllerChecklist();
                    $createChecklist -> ctrCreateEditChecklist();
                    ?>
           </div>
        </div>
</div>

    <div class="overlay toggle-menu"></div>


  </div>        <!-- container-fluid -->
</div>          <!-- content-wrapper -->

<?php
 
  $deleteChecklist = new ControllerChecklist();
  $deleteChecklist  -> ctrDeleteChecklist();
  
?>


  
