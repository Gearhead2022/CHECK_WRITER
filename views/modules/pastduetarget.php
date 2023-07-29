
<?php 
 $branch_list = new ControllerPastdue();
 $branch = $branch_list->ctrShowBranches();


  $user_id = $_SESSION['user_id'];
  $branch_name = $_SESSION['branch_name'];
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
          <h4 class="page-title">PAST DUE TARGETS</h4>
        </div>
     </div>

      <div class="row">
        <div class="col-lg-12">
        
          <div class="card">
            <div class="card-header float-sm-right">
              <div class="row">
                <?php if($_SESSION['type']=="admin" || $_SESSION['type']=="pastdue_user" || $_SESSION['type']=="backup_admin"){?>
                  <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1" data-toggle="modal" data-target="#exampleModalCenter"><i class="fa fa-plus"></i> <span>&nbsp;ADD TARGET</span> </button>
              <?php  }?>
              


                  <div class="col-sm-2 form-group" style="padding-top: 10px;margin-bottom: 6px;">
              </div>
            </div>            
            <div class="card-body">
              <div class="table-responsive">
              <table id="default-datatable" class="table table-bordered table-hover table-striped targetTable">
                <thead>
                <tr>
                  <th>BRANCH NAME</th>
                  <th>DATE</th>
                  <th>AMOUNT</th>
                  <th>Action</th>
                </tr>
                </thead>
              </table>
            </div>
            </div>
          </div>
        </div>
                
      </div>    <!-- row -->
     <!-- ADD TARGET MODAL -->
     <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
             <div class="modal-content">
                <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLongTitle">ADD TARGET</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                <form  method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-sm-12 form-group">
                    <label   label for="input-6">BRANCH NAME</label>
                    <select class="form-control" name="branch_name" id="branch_name" required>
                      <option value=""><  - - SELECT BRANCHES - - ></option>
                      <?php
                        foreach ($branch as $key => $row) {
                          # code...
                          $full_name = $row['full_name'];
                      ?>
                      <option value="<?php echo $full_name;?>"><?php echo $full_name;?></option>
                     <?php } ?>
                    </select>
                
                    </div>   
            </div> 
                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label for="input-6">MONTH</label>
                        <input type="month" class="form-control" id="date" placeholder="Enter Folder Name" name="date">
                    </div>  
                    <div class="col-sm-6 form-group">
                      <label for="input-6">AMOUNT</label>
                      <input type="text" class="form-control" id="amount" placeholder="Enter Target Amount" name="amount">
                   </div>   
            </div> 
                </div>
                <div class="modal-footer">
                        <button type="submit" name ="addTarget" class="btn btn-primary">Submit</button>
                        <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
              </form>
              <?php
                     $addPastDue = new ControllerPastdue();
                     $addPastDue -> ctrAddPastDueTarget();
                    ?>
           </div>
        </div>
     <!-- END ADD TARGET MODAL -->

     <!-- EDIT TARGET MODAL -->
     <div class="modal fade" id="editTargetModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
             <div class="modal-content">
                <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLongTitle">EDIT TARGET</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <form  method="post" enctype="multipart/form-data">
                <div class="modal-body">

                </div>         
                <div class="modal-footer">
                    <button type="submit" name ="editTarget" class="btn btn-primary">Submit</button>
                    <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
              </form>
              <?php
                     $editTarget = new ControllerPastdue();
                     $editTarget -> ctrEditTarget();
                    ?>
           </div>
        </div>
     <!-- END EDIT TARGET MODAL -->


       
</div>

    <div class="overlay toggle-menu"></div>


  </div>        <!-- container-fluid -->
</div>          <!-- content-wrapper -->

<?php
 
  $deletePastDue = new ControllerPastdue();
  $deletePastDue  -> ctrDeleteTarget();
  
?>


  
