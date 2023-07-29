
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
          <h4 class="page-title">WORKING PERMIT REQUEST</h4>
        </div>
     </div>

      <div class="row">
        <div class="col-lg-12">
        
          <div class="card">
            <div class="card-header float-sm-right">
              <div class="row">
                <?php if($_SESSION['type']=="admin" || $_SESSION['type']=="wp_admin" || $_SESSION['type']=="wp_user" || $_SESSION['type']=="wp_approve" ){?>
                  <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1" onClick="location.href='workingpermitadd'"><i class="fa fa-plus"></i> <span>&nbsp;ADD REQUEST</span> </button>
              <?php  }?>
                  <!-- <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1 btnPrintClient"><i class="fa fa-print"></i> <span>&nbsp;PRINT LIST</span> </button> -->

                  <div class="col-sm-2 form-group" style="padding-top: 10px;margin-bottom: 6px;">
                    <!-- <div class="input-group">
                      <select class="form-control" id="clientCategory" name="clientCategory">
                        <option value="" selected hidden>&lt;Select Category&gt;</option>
                        <option value="Regular">Regular</option>
                        <option value="Walk-in">Walk-in</option>
                        <option value="VIP">VIP</option>
                      </select>
 
                      <div class="input-group-append">
                        <button class="btn btn-light" type="button" id="clrCategory"><i class="fa fa-undo"></i> </button>
                      </div>  
                    </div> -->
              </div>
            </div>            

            <div class="card-body">
              <div class="table-responsive">
              <table id="default-datatable" class="table table-bordered table-hover table-striped permitTable">
                <thead>
                <tr>
                  <th>REFERENCE NO.</th>
                  <th>Requested by</th>
                   <th>Status</th>
                   <th>Checked by MRA</th>
                  <th>Approved by CGN</th>
                  <th>Approved by EGG</th>
                  <th>DATE / TIME REQUESTED</th>
                  <th>DATE / TIME Done</th>
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
  $deleteBlacklist = new ControllerPermits();
  $deleteBlacklist  -> ctrDeletePermit();
?>