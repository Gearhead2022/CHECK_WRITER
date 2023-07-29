
<style>
  .modal-content {
    width: 1000px;
    margin-left: -221px;
} 

</style>
<div class="clearfix"></div>
  
<div class="content-wrapper">
   <div class="container-fluid">
     <div class="row pt-2 pb-2">
        <div class="col-sm-12">
          <h4 class="page-title">BACKUP LIST</h4>
        </div>
     </div>

      <div class="row">
        <div class="col-lg-12">
        
          <div class="card">
            <div class="card-header float-sm-right">
              <div class="row">
                <?php if($_SESSION['type']=="admin" || $_SESSION['type']=="backup_user" || $_SESSION['type']=="backup_admin"){?>
                  <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1" onClick="location.href='backupadd'"><i class="fa fa-plus"></i> <span>&nbsp;ADD BACKUP</span> </button>
              <?php  }?>
              <?php if($_SESSION['type']=="admin" || $_SESSION['type']=="backup_admin"){?>

              <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1" onClick="location.href='backupfilter'"><i class="fa fa-folder"></i> <span>&nbsp;ADMIN FOLDER</span> </button>
              <button type="button" id="showPrint"  class="btn btn-light btn-round waves-effect waves-light m-1" onClick="location.href='backupreport'"><i class="fa fa-print"></i> <span>&nbsp;BACKUP CHECKER</span> </button>

              <?php  }?>


                  <div class="col-sm-2 form-group" style="padding-top: 10px;margin-bottom: 6px;">
              </div>
            </div>            
            <div class="card-body">
              <div class="table-responsive">
              <table id="default-datatable" class="table table-bordered table-hover table-striped backupTable">
                <thead>
                <tr>
                  
                  <th>BRANCH NAME</th>
                  <th>Subject</th>
                  <th>DATE / TIME ENCODED</th>
                  <th>DATE / TIME RECEIVED</th>
                  <th>STATUS</th>
                  <th>Action</th>
                </tr>
                </thead>
              </table>
            </div>
            </div>
          </div>
        </div>
      
      </div>    <!-- row -->
      <div class="modal" id="empModal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
      <!-- Modal content-->
      <div class="modal-content">
        <form method="POST" enctype="multipart/form-data"  autocomplete="off">
          <div class="modal-header">
            <h4 class="modal-title">Clients Profile</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
        <div class="modal-body">
                  
        </div>
      </div>
      </form>
      </div>
   </div>
</div>

    <div class="overlay toggle-menu"></div>


  </div>        <!-- container-fluid -->
</div>          <!-- content-wrapper -->

<?php
  $doneBackup = new ControllerBackup();
  $doneBackup  -> doneBackup();

  $deleteBackup = new ControllerBackup();
  $deleteBackup  -> ctrDeleteBackup();
  
?>