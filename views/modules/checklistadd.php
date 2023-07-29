<?php 
$chk_date = $_REQUEST['chk_date'];
$chk_id = $_REQUEST['idClient'];

$formattedDate = date("F d, Y", strtotime($chk_date));

$chk = (new ControllerChecklist)->ctrShowChecklist();



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
          <h4 class="page-title">CHECKLIST REPORTS</h4>
        </div>
     </div>

      <div class="row">
        <div class="col-lg-12">
              
          <div class="card">
            <div class="card-header float-sm-right">
            <h4><?php echo $formattedDate; ?></h4>
            </div>            

            <div class="card-body">
              <div class="row">

                <div class="float-right">
                <button type="button" id="showPrint"  class="btn btn-light btn-round waves-effect waves-light m-1 "  data-toggle="modal" data-target="#exampleModalCenter12"><i class="fa fa-plus"></i> <span>&nbsp;ADD REPORT</span> </button>
                <button type="button" id="showPrint"  class="btn btn-light btn-round waves-effect waves-light m-1 "  data-toggle="modal" data-target="#copyModal"><i class="fa fa-copy"></i> <span>&nbsp;COPY REPORT</span> </button>
                <button type="button" id="showPrint"  class="btn btn-light btn-round waves-effect waves-light m-1 showPrint12 " reportDate="<?php echo $formattedDate;?>" chk_id="<?php echo $chk_id;?>"><i class="fa fa-print"></i> <span>&nbsp;PRINT</span> </button>                </div>
              </div>
             
            <div id="showTable" class="table-responsive mt-2" >
            <table class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                        <th>TASK DETAILS / DESCRIPTION</th>
                        <th>PRIORITY</th>
                        <th>STARTED</th>
                        <th>ACTUAl DATE END</th>
                        <th>STATUS</th>
                        <th>NOTES</th>
                        <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                      
                        <?php 
                        $showChecklistReport = (new ControllerChecklist)->ctrShowChecklistReport($chk_id);

                          foreach ($showChecklistReport as $key => $row){
                            $chk_task = $row["chk_task"];
                            $id = $row["id"];
                            $chk_prio = $row["chk_prio"];
                            $chk_start1 = $row["chk_start"];
                            $chk_end1 = $row["chk_end"];
                            $chk_status = $row["chk_status"];
                            $chk_notes = $row["chk_notes"];

                            $chk_start = date("F d, Y", strtotime($chk_start1));
                            $chk_end = date("F d, Y", strtotime($chk_end1));

                            if($chk_prio =="LOW"){
                              $html_chk_prio  ="<p class='badge badge-secondary' style='font-size: 15px;'>".$chk_prio."</p>";
                            }else if($chk_prio =="MEDIUM"){
                              $html_chk_prio  ="<p class='badge badge-primary' style='font-size: 15px;'>".$chk_prio."</p>";
                            }
                            else if($chk_prio =="HIGH"){
                              $html_chk_prio  ="<p class='badge badge-warning' style='font-size: 15px;'>".$chk_prio."</p>";
                            }
                            else if($chk_prio =="CRITICAL"){
                              $html_chk_prio  ="<p class='badge badge-danger' style='font-size: 15px;'>".$chk_prio."</p>";
                            }


                            if($chk_status == "PENDING"){
                              $html_chk_status  ="<p class='badge badge-danger' style='font-size: 15px;'>".$chk_status."</p>";
                            }else if($chk_status =="ON GOING"){
                              $html_chk_status  ="<p class='badge badge-warning' style='font-size: 15px;'>".$chk_status."</p>";
                            }
                            else if($chk_status =="DONE"){
                              $html_chk_status  ="<p class='badge badge-success' style='font-size: 15px;'>".$chk_status."</p>";
                            }
                            else if($chk_status =="IN DEVELOPMENT"){
                              $html_chk_status  ="<p class='badge badge-info' style='font-size: 15px;'>".$chk_status."</p>";
                            }
                            else if($chk_status =="DEPLOYED"){
                              $html_chk_status  ="<p class='badge badge-primary' style='font-size: 15px;'>".$chk_status."</p>";
                            }
                            else if($chk_status =="FOR APPROVAL"){
                              $html_chk_status  ="<p class='badge badge-secondary' style='font-size: 15px;'>".$chk_status."</p>";
                            }
                           
                          ?>
                          <tr>
                            <td><?php echo $chk_task; ?></td>
                            <td><?php echo $html_chk_prio; ?></td>
                            <td><?php echo $chk_start; ?></td>
                            <td><?php echo $chk_end; ?></td>
                            <td><?php echo $html_chk_status; ?></td>
                            <td><?php echo $chk_notes; ?></td>
                            <td>
                              <div class="btn-group group-round m-1">
                                <button data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-sm btn-info waves-effect waves-light btnEditReport"
                                 idClient="<?php echo $id ?>" chk_id="<?php echo $chk_id ?>" >EDIT</button>
                                <button data-toggle="tooltip" data-placement="top" title="Delete"  class="btn btn-sm btn-danger waves-effect waves-light btnDeleteReport"
                                idClient="<?php echo $id ?>"  chk_id="<?php echo $chk_id ?>"  chk_date="<?php echo $chk_date ?>"><i style="font-size: 15px;"  class="fa fa-trash"></i>
                              </button>
                            </div>
                        </td>
                          </tr>
                     <?php }   ?>
                    </tbody>
            </table>
              
            </div>
            </div>
            <div class="card-footer">
              <div class="row">
                <div class="col-lg-3">
                </div>
                <div class="col-lg-9">
                  <div class="float-sm-right">
                   <button type="button" class="btn btn-light btn-round px-5" onClick="location.href='checklist'"><i class="fa fa-list"></i>&nbsp;&nbsp;Listing</button>                           
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>    <!-- row -->


      <div class="modal fade" id="exampleModalCenter12" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-dialog modal-xl " role="document">
             <div class="modal-content">
                <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLongTitle">ADD REPORT</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                <form  method="post">
                <div class="row mt-2">
                    <div class="col-sm-12 form-group">
                        <label for="input-6">TASK DETAILS / DESCRIPTION</label>
                        <input type="text" hidden class="form-control"  name="chk_id" id="chk_id" value="<?php echo $chk_id; ?>">

                        <textarea class="form-control" id="chk_task" placeholder="Enter Task Details / Description" name="chk_task" autocomplete="nope" required></textarea>
                    </div>   
               </div> 
               <div class="row">
                  <div class="col-sm-3 form-group">
                    <label for="input-6">PRIORITY</label>
                    <select class="form-control" name="chk_prio" id="chk_prio">
                      <option value="">< - - - SELECT PRIORITY - - - > </option>
                      <option value="LOW">LOW</option>
                      <option value="MEDIUM">MEDIUM</option>
                      <option value="HIGH">HIGH</option>
                      <option value="CRITICAL">CRITICAL</option>
                    </select>
                  </div>
                  <div class="col-sm-3 form-group">
                     <label for="input-6">STARTED</label>
                     <input type="date" class="form-control"  name="chk_start" id="chk_start">
                  </div>
                  <div class="col-sm-3 form-group">
                    <label for="input-6">ACTUAL DATE END</label>
                     <input type="date" class="form-control"  name="chk_end" id="chk_end">
                  </div>
                  <div class="col-sm-3 form-group">
                      <label for="input-6">STATUS</label>
                      <select class="form-control" name="chk_status" id="chk_status">
                        <option value="">< - - - SELECT STATUS - - - > </option>
                        <option value="PENDING">PENDING</option>
                        <option value="ON GOING">ON GOING</option>
                        <option value="DONE">DONE</option>
                        <option value="IN DEVELOPMENT">IN DEVELOPMENT</option>
                        <option value="DEPLOYED">DEPLOYED</option>
                        <option value="FOR APPROVAL">FOR APPROVAL</option>
                      </select>
                  </div>
               </div>
               <div class="row mt-2">
                    <div class="col-sm-12 form-group">
                        <label for="input-6">NOTES</label>
                        <textarea type="text" class="form-control" id="chk_notes" placeholder="Enter Notes" name="chk_notes" autocomplete="nope" ></textarea>
                    </div>   
               </div> 
                </div>
                <div class="modal-footer">
                        <button type="submit" name ="addChecklistReport" class="btn btn-primary">Submit</button>
                        <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div> 
              </div>
              </form>
              <?php
                     $createChecklistReport = new ControllerChecklist();
                      $createChecklistReport -> ctrCreateChecklistReport();
                      $createChecklistReport -> ctrDeleteReport();
                     
                    ?>
           </div>
        </div>

        <div class="modal fade" id="copyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-dialog modal-lg " role="document">
             <div class="modal-content">
                <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLongTitle">COPY REPORT</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                <form  method="post">
               <div class="row">
                  <div class="col-sm-4 form-group">
                    <label for="input-6">Checklist Date</label>
                    <select class="form-control boxID" name="boxID" id="boxID">
                      <option value="">< - - - SELECT DATE - - - > </option>
                      <?php 
                          foreach ($chk as $key => $row1) {
                            $copy_chk_id = $row1["chk_id"];
                            $copy_chk_date1 = $row1["chk_date"];
                            $copy_chk_date = date("F d, Y", strtotime($copy_chk_date1));
                     ?>

                      <option value="<?php echo $copy_chk_id ?>"><?php echo $copy_chk_date ?></option>
                    <?php }?>
                    </select>
                  </div>
               </div>
                <div id="showCheckBox" class="table-responsive" hidden>
                  <table class="table table-bordered table-hover table-striped">
                          <thead>
                              <tr>
                              <th></th>
                              <th>TASK DETAILS / DESCRIPTION</th>
                              </tr>
                          </thead>
                          <tbody class="chkboxReports">
                              
                          </tbody>
                  </table>
              
            </div>
               
                </div>
                <div class="modal-footer">
                        <button type="submit" name ="copyChecklistReport" class="btn btn-primary">Copy</button>
                        <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div> 
              </div>
              </form>
              <?php
                      $createChecklistReport->ctrCopyChecklistReport();
                    ?>
           </div>
        </div>



        <div class="modal fade" id="editChecklistReportModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-dialog modal-xl " role="document">
             <div class="modal-content">
                <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLongTitle">EDIT REPORT</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <form  method="post">
                <div class="modal-body">

                
                </div>
                <div class="modal-footer">
                        <button type="submit" name ="editChecklistReport" class="btn btn-primary">Submit</button>
                        <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div> 
              </div>
              </form>
              <?php
                     $editChecklistReport = new ControllerChecklist();
                     $editChecklistReport -> ctrCreateEditChecklistReport()
                     
                     
                    ?>
           </div>
        </div>


</div>

    <div class="overlay toggle-menu"></div>
                

  </div>        <!-- container-fluid -->
</div>          <!-- content-wrapper -->

