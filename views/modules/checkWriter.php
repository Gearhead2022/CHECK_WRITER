
<style>
    textarea#wp_req_for {
    height: 100px;
}
[type="checkbox"] {
/* Style the color of the message that says 'No file chosen' */
  background: green;
  height: 19px !important;
  width: 19px !important;
}

modal-content, .modal-footer{
    background-color: #C9E0DC;
}
.modal-title{
    color: black;
}

.modal-body{
    background-color: #F0FAF9;
}
.modal-form-header{
    background-color: #F0FAF9;"
}

.btn-soa{
    background-color: #08655D;
    color: white;
}
.form-control[readonly]{
    background-color: #efebf5;
    border: solid black 1px;
    color: black;
}

.form-control:focus{
    background-color: #efebf5 !important;
    border: solid black 1px;
    color: black;
}

input::placeholder{
    color: green;
}
.form-control{
    background-color: white;
    border: solid black 1px;
}

.col-form-label {
    color:#074D47;
}

option::selected {
    background-color: #007BFF;
    color: #ffffff;
}
.form-control::placeholder {
  color: green !important;
  /* font-style: italic !important; */
}
.modal-content, .modal-footer{
    background-color: #C9E0DC;
}

.btn-soa{
    background-color: #08655D;
    color: white;
}

select option{
  background-color: #465745;
  color: white;
}

/* DataTables custom styles for dark mode */
#bank_logs .dataTables_wrapper .dataTables_filter input {
  background-color: #fff;
    color: black;
    border: 1px solid black;
}

#bank_logs .dataTables_wrapper .dataTables_filter .form-control select option {
  
    color: black !important;
}

select.form-control.form-control-sm {
  color: black !important;
}
input.form-control.form-control-sm{
  color: black !important;
}

#bank_logs .dataTables_wrapper .dataTables_length select {
    background-color: #fff;
    border: 1px solid black;
}

#bank_logs .dataTables_wrapper .dataTables_filter label,
#bank_logs .dataTables_wrapper .dataTables_length label {
    color: black;
}
#bank_logs tbody tr td {
    padding: 0 5px;
    padding-top: 10px;
    margin: 0px;
    text-align: center;
}
#bank_logs div#default-datatable_info {
    COLOR: BLACK;
}
#bank_logs .table-hover tbody tr:hover {
    background-color: rgba(0, 0, 0, .20);
    color: #000;
    cursor: pointer;
}
/* Bank Report Modal Style */
#bank_report .dataTables_wrapper .dataTables_filter input {
  background-color: #fff;
    color: black;
    border: 1px solid black;
}
#bank_report .dataTables_wrapper .dataTables_filter .form-control select option {
  
  color: black !important;
}
#bank_report .dataTables_wrapper .dataTables_filter label,
#bank_report .dataTables_wrapper .dataTables_length label {
    color: black;
}
#bank_logs .page-link {
    color: black;
}

/* DataTables custom styles for dark mode */
#bank_logs .dataTables_wrapper .dataTables_filter input {
  background-color: #fff;
    color: black;
    border: 1px solid black;
}

#bank_logs .dataTables_wrapper .dataTables_filter .form-control select option {
    color: black !important;
}

/* LIAISON TABLE */
select.form-control.form-control-sm {
  color: black !important;
}
input.form-control.form-control-sm{
  color: black !important;
}

#liaison_table .dataTables_wrapper .dataTables_length select {
    background-color: #fff;
    border: 1px solid black;
}

#liaison_table .dataTables_wrapper .dataTables_filter label,
#liaison_table .dataTables_wrapper .dataTables_length label {
    color: black;
}
#liaison_table tbody tr td {
    padding: 0 5px;
    padding-top: 10px;
    margin: 0px;
    text-align: center;
}
#liaison_table div#default-datatable_info {
    COLOR: BLACK;
}
#liaison_table .table-hover tbody tr:hover {
    background-color: rgba(0, 0, 0, .20);
    color: #000;
    cursor: pointer;
}
#liaison_table .page-link {
    color: black;
}
#liaison_table .dataTables_wrapper .dataTables_filter input {
  background-color: #fff;
    color: black;
    border: 1px solid black;
}
#liaison_table .dataTables_wrapper .dataTables_filter .form-control select option {
    color: black !important;
}

.liaison_button {
    background-color: #971e1e;
}
.liaison_button:hover {
    background-color: #530e0e;
}
</style>
<?php 

    $branch_name = $_SESSION['branch_name'];
    
    $bank_list = new ControllerCheckWriter();
    $banks = $bank_list->ctrShowAllBank();

    $branch_list = $bank_list->ctrShowAllBranches();

?>   
<div class="clearfix"></div>
	
<div class="content-wrapper">
  <div class="container-fluid">
   <div class="row pt-2 pb-2">
     <div class="col-sm-12">
  	    <h4 class="page-title">CHECK WRITER</h4>
     </div>
   </div> 
    <div class="row">
    
      <div class="col-lg-12">
        <form method="POST" enctype="multipart/form-data" >   
          <div class="card">
            <div class="card-header ml-4">
                <div class="row">
                <?php
                    foreach ($banks as $key => $row) {
                    # code...
                    $bnkcd = $row['bnkcd'];
                    $bnk_name = $row['bnk_name'];
                    $bnk_bal = $row['bnk_bal'];
                    $formated_amount = number_format(floatVal($bnk_bal), 2, '.', ',');
                    ?>
                    <div class="div-lg-2 mr-4">
                    <h5><?php echo '<span id="'.$bnkcd.'">('.$bnkcd.') '.$bnk_name.':<u style="  color: #2bcb89;font-weight: bold;"> ₱'.$formated_amount.'</u></span>'?></h5>
                    </div>
                    
                    <?php } ?>

                    <div class="col-lg-6 d-flex justify-content-end">
                        <button
                            type="button"
                            id="liaison_button"
                            class="liaison_button btn btn-round text-white border border-6 border-dark waves-effect waves-light m-1 btnEnableLiaisonTableWrapper"
                            style="opacity: 80%;"
                            data-toggle="modal"
                            data-target="#liaison_table">
                            <i class="fa fa-user"></i>
                            <span>&nbsp;LIAISON</span>
                        </button>
                    </div>
                </div>
                <div class="row mt-3 ml-2">
                  <div class="col-1.2">
                        <label for="inputIdNo" class="col-form-label text-white">TRANSACTION DATE :</label>
                  </div>
                  <div class="col-2">
                      <input type="date" class="form-control text-success" id="bnkchck_date" name="bnkchck_date" placeholder="Enter Date"  autocomplete="nope" required>
                  </div>
                  <div class="col-sm-2 form-group">  
                    <button type="button" name="updateCheckWriterFileRecords" id="updateCheckWriterFileRecords" class="btn btn-transparent btn-round text-white border border-white waves-effect waves-light m-1 updateCheckWriterFileRecords"><i class="fa fa-refresh"></i> <span>&nbsp;GENERATE</span> </button>
                  </div>
                  <div class="">
                    <input type="hidden" class="form-control" id="bnkchck_branch_name" name="bnkchck_branch_name" value="<?php echo $branch_name;?>" autocomplete="nope" required>
                  </div>
                  <div class="col-4.8">
                    <button type="button" name=""  id="" class="btn btn-white btn-round text-dark border border-dark waves-effect waves-light m-1 trigger-confirm-action" data-toggle="modal" data-target="#bank_bal"><i class="fa fa-money"></i> <span>&nbsp;BANK BALANCE</span> </button>
                    <button type="button" name=""  id="" class="btn btn-white btn-round text-dark border border-dark waves-effect waves-light m-1 trigger-confirm-action" data-toggle="modal" data-target="#add_bank"><i class="fa fa-bank"></i> <span>&nbsp;ADD BANK</span> </button>
                    <!-- <button type="button" name="" id="" class="btn btn-white btn-round text-dark border border-dark waves-effect waves-light m-1 trigger-confirm-action" data-toggle="modal" data-target="#bankTransfer"><i class="fa fa-exchange"></i> <span>&nbsp;TRANSFER</span> </button> -->
                    <!-- <button type="button" name="" id="" class="btn btn-white btn-round text-dark border border-dark waves-effect waves-light m-1" data-toggle="modal" data-target="#bank_reset"><i class="fa fa-refresh"></i> <span>&nbsp;RESET BALANCE</span> </button> -->
                  </div>
                  <div class="col-2.1">
                    <button type="button" name="" confirm_action="addbnk" id="" class="btn btn-warning btn-round text-white border border-dark waves-effect waves-light m-1 trigger-confirm-action" data-toggle="modal" data-target="#bank_logs"><i class="fa fa-history"></i><span>&nbsp;LOGS</span></button>
                  </div>
                  <div class="col-2 ml-3">
                    <button type="button" name="" id="" class="btn btn-success btn-round text-white border border-dark waves-effect waves-light m-1 btnEnableTableWrapper" data-toggle="modal" data-target="#bank_report"><i class="fa fa-file-excel-o"></i><span>&nbsp;REPORT</span></button>
                  </div>
                
                </div>  
              
            </div>   
            <div class="card-body">
            <div class="table-responsive">
              <table id="default-datatable" class="table table-bordered table-hover table-striped checkWriterTable">
                <thead>
                <tr>
                  <th>Action</th>
                  <th>BANK CODE</th>
                  <th>DOC #</th>
                  <th>VOUCHER #</th>
                  <th>TRANSACTION DATE</th>
                  <th>PAY TO</th>
                  <th>AMOUNT</th>
                  <th>STATUS</th>
                  <th>DOC TYPE</th>
                  <th>REMARKS</th>
                </tr>
                </thead>
              </table>
            </div>
            </div>
                         
            <div class="card-footer">
              <div class="row">
                <div class="col-lg-3">
                </div>
                <div class="col-lg-9">
                  <div class="float-sm-right">
                   <!-- <button type="submit" name="submit" class="btn btn-light btn-round px-5"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button> -->
                   <!--<button type="button" class="btn btn-light btn-round px-5" onClick="location.href='fullypaid'"><i class="fa fa-list"></i>&nbsp;&nbsp;Listing</button>                            -->
                  </div>
                </div>
              </div>
            </div>  <!-- footer -->

          </div>    <!-- card -->
        </form>
      </div>
    </div><!--End Row-->

  <!-- PROCCESS MODAL -->
  <div class="modal fade" id="bankSelection"  tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
          <div class="modal-content"  style="background-color:#C9E0DC;">>
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">PRINTING SELECTION</h5>
                <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                  </button>
            </div>
            <form method="post" id="bank_type_option" enctype="multipart/form-data">
            <div class="modal-body mb-0" >
            <div class="row">
               <div class="col-12">
                  <select class="form-control text-success" name="bank_type" id="bank_type" required>
                      <option value=""  selected disabled><- - SELECT BANK - -></option>
                      <?php

                        foreach ($banks as $key => $row) {
                          # code...
                          $bnkcd = $row['bnkcd'];
                          $bnk_name = $row['bnk_name'];
                        ?>
                        <option value="<?php echo $bnk_name;?>"><?php echo '('.$bnkcd.') '.$bnk_name?></option>
                        <?php } ?>
                  </select>
              </div>
            </div>
          
            </div>
            <div class="modal-footer">
            <button type="button" name="btnPrintBNKCHK" id="btnPrintBNKCHK" hidden class="btn btn-soa">PRINT</button>
            <button type="button" name="btnRePrintBNKCHK" id="btnRePrintBNKCHK" hidden class="btn btn-soa">RE-PRINT</button>
            <button type="button" class="btn btn-soa"  data-dismiss="modal">CANCEL</button>
            </div>
          </div>
        </form>
        </div>
    </div>
     <!-- END PROCESS MODAL1 -->

     <!-- START ADD BANK BALANCE MODAL -->
  <div class="modal fade" id="bank_bal"  tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-md" role="document">
          <div class="modal-content"  style="background-color:#C9E0DC;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">BANK BALANCE</h5>
                <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                  </button>
            </div>
            <form method="post" enctype="multipart/form-data">
            <div class="modal-body mb-0">
            <div class="row">
                <div class="col-12">

                 <!-- Container for bank balances -->
                <div id="bankBalanceContainer"></div>
                </div>
               
              </div>
              <div class="row mt-3">
                <div class="col-12">
                    <label for="inputName" class="col-form-label">BANK NAME</label>
                </div>
                <div class="col-12">
                  <select class="form-control text-success" name="bnk_code" id="bnk_code" required>
                        <option value=""  selected disabled><- - SELECT BANK - -></option>
                        <?php

                        foreach ($banks as $key => $row) {
                          # code...
                          $bnkcd = $row['bnkcd'];
                          $bnk_name = $row['bnk_name'];
                        ?>
                       <option value="<?php echo $bnkcd;?>"><?php echo '('.$bnkcd.') '.$bnk_name?></option>
                     <?php } ?>
                    </select>
                </div>
                <div class="col-12">
                    <label for="inputName" class="col-form-label">AMOUNT :</label>
                </div>
                <div class="col-12">
                    <input type="number" step="any" id="bnk_amount" required name="bnk_amount" class="form-control text-success" placeholder="Enter Balacnce">
                </div>
              </div>
            </div>
            <div class="modal-footer">
            <button type="submit" name="btnPreAddBankBal" id="btnPreAddBankBal" class="btn btn-soa">SUBMIT</button>
            <button type="submit" hidden name="btnAddBankBal" id="btnAddBankBal" class="btn btn-soa btnAddBankBal">SUBMIT</button>
            <button type="button" class="btn btn-soa"  data-dismiss="modal">CANCEL</button>
            </div>
          </div>
        </form>
            <?php
                  $updateBankBal = new ControllerCheckWriter();
                  $updateBankBal -> ctrAddBankBal();
            ?>
        </div>
    </div>
    <!-- END ADD BANK BALANCE MODAL -->

      <!--START ADD BANK MODAL -->
  <div class="modal fade" id="add_bank"  tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-md" role="document">
          <div class="modal-content"  style="background-color:#C9E0DC;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">ADD BANK</h5>
                <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                  </button>
            </div>
            <form method="post" id="" enctype="multipart/form-data">
            <div class="modal-body mb-0">
              <div class="row">
                <div class="col-12">
                    <label for="inputName" class="col-form-label">BANK NAME</label>
                </div>
                <div class="col-12">
                  <select class="form-control text-success" name="bnk_name" id="bnk_name" required>
                        <option value=""  selected disabled><- - SELECT BANK - -></option>
                        <option value="BACOM">BACOM</option>
                        <option value="FCB">FCB</option>
                        <option value="BDO">BDO</option>
                        <option value="PNB">PNB</option>
                        <option value="RCBC">RCBC</option>
                        <option value="CHINA BANK">CHINA BANK</option>
                        <option value="LAND BANK">LAND BANK</option>
                        <option value="BPI">BPI</option>
                        <option value="METRO BANK">METRO BANK</option>
                        <option value="UNION BANK">UNION BANK</option>
                        <option value="QUEEN BANK">QUEEN BANK</option>
                        <option value="RURAL BANK">RURAL BANK</option>
                        <option value="UCPB">UCPB</option>
                        <option value="ONE NETWORK BANK">ONE NETWORK BANK</option>
                        <option value="PB COMMUNICATION">PB COMMUNICATION</option>
                        <option value="AUB">AUB</option>
                        <option value="EAST WEST">EAST WEST</option>
                        <option value="ASIA UNITED BANK">ASIA UNITED BANK</option>
                        <option value="DBP">DBP</option>
                    </select>
                </div>
                <div class="col-12 mt-2">
                    <label for="inputName" class="col-form-label">BANK CODE :</label>
                </div>
                <div class="col-12">
                    <input type="text" id="bnk_code1" required name="bnk_code1" class="form-control text-success" placeholder="Enter Bank Code">
                </div>
                <div class="col-12 mt-2">
                    <label for="inputName" class="col-form-label">BANK MAINTAINING BALANCE :</label>
                </div>
                <div class="col-12">
                    <input type="number" id="mnt_bal" step="any" required name="mnt_bal" class="form-control text-success" placeholder="Enter Bank Maintaining Balance">
                </div>
              </div>
            </div>
            <div class="modal-footer">
            <button type="submit" name="btnPreAddBank" id="btnPreAddBank" class="btn btn-soa">SUBMIT</button>
            <button type="submit" hidden name="btnAddBank" id="btnAddBank" class="btn btn-soa btnAddBank">SUBMIT</button>
            <button type="button" class="btn btn-soa"  data-dismiss="modal">CANCEL</button>
            </div>
          </div>
        </form>
            <?php
                  $updateBankBal = new ControllerCheckWriter();
                  $updateBankBal -> ctrAddBank();
            ?>
        </div>
    </div>
    <!--END ADD BANK MODAL -->

    <!-- START ADD BANK PASSCODE MODAL -->
   <div class="modal fade" id="bank_password" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content" style="background-color:#C9E0DC;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">CONFIRM ACCESS</h5>
                <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" id="">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 form-group">
                          <input type="password" style="border: 1px solid #08655d;" class="form-control text-success"  id="bnk_pass" placeholder="Enter password" name="pass">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-soa" id="conf_pass">Proceed</button>
                <button type="button" class="btn btn-soa" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
   <!-- END ADD BANK PASSCODE MODAL -->

      <!-- START CANCE BANK PASSCODE MODAL -->
      <div class="modal fade" id="cancel_password" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content" style="background-color:#C9E0DC;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">CONFIRM ACCESS</h5>
                <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" id="">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 form-group">
                          <input type="password" style="border: 1px solid #08655d;" class="form-control text-success"  id="cancel_bnk_pass" placeholder="Enter password" name="pass">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-soa" id="cancel_pass">Proceed</button>
                <button type="button" class="btn btn-soa" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
   <!-- END ADD BANK PASSCODE MODAL -->

  <!-- START TRANSACTION LOGS MODAL -->
  <div class="modal fade" id="bank_logs" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content" style="background-color:#C9E0DC;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">LOGS</h5>
                <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" id="">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="background-color: #F0FAF9;">
            <div class="table-responsive">
              <table id="default-datatable" class="table table-bordered text-dark table-hover table-striped checkWriterTableLogs">
                <thead>
                <tr>
                  <th>Action</th>
                  <th>BANK CODE</th>
                  <th>CHECK NUMBER</th>
                  <th>PREV BAL</th>
                  <th>TRANS AMT</th>
                  <th>CUR BAL</th>
                  <th>Remarks</th>
                  <th>Status</th>
                  <th>DATETIME</th>
                  
                </tr>
                </thead>
              </table>
            </div>
            </div>
            <div class="modal-footer">
             
            </div>
        </div>
    </div>
</div>
 <!-- END TRANSACTION LOGS MODAL -->
      <!-- START Generate report MODAL -->
      <div class="modal fade" id="bankReport" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content" style="background-color:#C9E0DC;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">GENERATE REPORT</h5>
                <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" id="">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6 form-group">
                         <label for="inputIdNo" class="col-form-label">FROM</label>
                          <input type="date" style="border: 1px solid #08655d;" class="form-control text-success"  id="bnk_from" placeholder="Enter password" name="pass">
                    </div>
                    <div class="col-sm-6 form-group">
                          <label for="bnk_to" class="col-form-label">TO</label>
                          <input type="date" style="border: 1px solid #08655d;" class="form-control text-success"  id="bnk_to" placeholder="Enter password" name="pass">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-soa" id="bnkSubmit">Proceed</button>
                <button type="button" class="btn btn-soa" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
   <!-- END Generate report MODAL -->

    <!-- START Transfer MODAL -->
    <div class="modal fade" id="bankTransfer" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content" style="background-color:#C9E0DC;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Transfer Transcation</h5>
                <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" id="">&times;</span>
                </button>
            </div>
          <form method="post" enctype="multipart/form-data">
            <div class="modal-body">
                <div class="row">
                <div class="col-sm-3 form-group">
                  <label for="tbank_type" class="col-form-label">Bank</label>
                  <select class="form-control text-success" name="tbnkcd" id="tbnkcd" required>
                      <option value=""  selected disabled><- - SELECT BANK - -></option>
                      <?php
                        foreach ($banks as $key => $row) {
                          # code...
                          $bnkcd = $row['bnkcd'];
                          $bnk_name = $row['bnk_name'];
                        ?>
                        <option value="<?php echo $bnkcd;?>"><?php echo '('.$bnkcd.') '.$bnk_name?></option>
                        <?php } ?>
                  </select>
                  </div>
                  
                    <div class="col-sm-5 form-group">
                         <label for="inputIdNo" class="col-form-label">PAY TO</label>
                          <input type="text" required style="border: 1px solid #08655d;" class="form-control text-success"  id="tpayto" placeholder="Enter pay to" name="tpayto">
                    </div>
                    <div class="col-sm-4 form-group">
                          <label for="bnk_to" class="col-form-label">BRANCH NAME</label>
                          <select class="form-control text-success" name="tbranch_name" id="tbranch_name" required>
                      <option value=""  selected disabled><- - SELECT BRANCH - -></option>
                      <?php
                        foreach ($branch_list as $key => $row) {
                          # code...
                          $branch_name = $row['branch_name'];
                         
                        ?>
                        <option value="<?php echo $branch_name;?>"><?php echo $branch_name; ?></option>
                        <?php } ?>
                  </select>
                    </div>
                  </div>
                    <div class="row">
                      <div class="col-sm-4 form-group">
                          <label for="inputIdNo" class="col-form-label">JV / LOT NO.</label>
                            <input type="text" required style="border: 1px solid #08655d;" class="form-control text-success"  id="tdocno" placeholder="Enter doc no." name="tdocno">
                      </div>
                      <div class="col-sm-4 form-group">
                          <label for="inputIdNo" class="col-form-label">AMOUNT</label>
                            <input type="number" required step="0.01"  style="border: 1px solid #08655d;" class="form-control text-success"  id="tchkamt" placeholder="Enter amount" name="tchkamt">
                      </div>
                      <div class="col-sm-4 form-group">
                           <label for="inputIdNo" class="col-form-label">DATE</label>
                            <input type="date" required style="border: 1px solid #08655d;" class="form-control text-success"  value="<?php echo date('Y-m-d') ?>" id="tcdate" placeholder="Enter pay to" name="tcdate">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-12 form-group">
                           <label for="inputIdNo" class="col-form-label">REMARKS</label>
                          <textarea name="tremarks"  class="form-control text-success"  id="tremarks"></textarea>
                      </div>
                    </div>
             </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-soa" name="bnkTransfer" id="">Proceed</button>
                <button type="button" class="btn btn-soa" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
    </div> 
    </form>
    <?php 
        $conn = new ControllerCheckWriter();
        $transfer_bank = $conn->ctrTransferBank();
        $deleteBlacklist = $conn-> ctrDeleteLiaison();
    ?> 
</div>
   <!-- END Transfer MODAL-->

      <!-- START TRANSACTION REPORT MODAL -->
  <div class="modal fade" id="bank_report" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content" style="background-color:#C9E0DC;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">VIEW REPORT</h5>
                <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" id="">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="background-color: #F0FAF9;">
              <div class="row mt-2">
                  <div class="ml-3">
                      <label for="inputName" class="col-form-label">DATE FROM :</label>
                  </div>
                  <div class="col-2">
                      <input type="date" id="bnkchck_date_from" required name="bnkchck_date_from" class="form-control text-success" placeholder="Enter Bank Maintaining Balance">
                  </div>
                  <div class="ml-2">
                      <label for="inputName" class="col-form-label">DATE TO :</label>
                  </div>
                  <div class="col-2">
                      <input type="date" id="bnkchck_date_to" required name="bnkchck_date_to" class="form-control text-success" placeholder="Enter Bank Maintaining Balance">
                  </div>
                  <div class="ml-4">
                      <label for="inputName" class="col-form-label">SELECT BANK :</label>
                  </div>
                  <div class="col-2">
                  <select class="form-control text-success" name="bnkchck_bank" id="bnkchck_bank" required>
                        <option value="All"  selected>All</option>
                        <?php

                        foreach ($banks as $key => $row) {
                          # code...
                          $bnkcd = $row['bnkcd'];
                          $bnk_name = $row['bnk_name'];
                        ?>
                       <option value="<?php echo $bnkcd;?>"><?php echo '('.$bnkcd.') '.$bnk_name?></option>
                     <?php } ?>
                    </select>
                  </div>
                  <div class="col-sm-2 form-group">  
                    <button type="button" name="" id="" class="btn btn-dark btn-round text-white border border-dark waves-effect waves-light generateCheckWriterReport"><i class="fa fa-refresh"></i> <span>&nbsp;GENERATE</span> </button>
                  </div>
              </div>
              <div class="row mt-3">
                <div class="table-responsive">
                  <table id="default-datatable" class="table table-bordered text-dark table-hover table-striped checkWriterTableReport">
                    <thead>
                    <tr>
                      <th>DATE</th>
                      <th>BANK CODE</th>
                      <th>DOC NO</th>
                      <th>PAY TO</th>
                      <th>PREV BAL</th>
                      <th>CUR BAL</th>
                      <th>DISBURSEMENT</th>
                      <th>END BAL</th>  
                    </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
            <div class="modal-footer">
                <button type="button" name="exportCheckWriterReport" id="exportCheckWriterReport" class="btn btn-danger btn-round text-white border border-dark waves-effect waves-light m-1 exportCheckWriterReport" ><i class="fa fa-print"></i><span>&nbsp;PRINT</span></button>       
            </div>
        </div>
    </div>
</div>



<!-- START LIASON TABLE MODAL -->
 <div class="modal fade" id="liaison_table" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content" style="background-color:#C9E0DC;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">LIAISON LIST</h5>
                <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" id="">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="background-color: #F0FAF9;">
                <div class="row mt-2">
                    <div class="col-lg-12 d-flex justify-content-end">  
                        <button type="button" name="" id="" data-toggle="modal" data-target="#liaison_add" class="btn btn-dark btn-round text-white border border-dark waves-effect waves-light"><i class="fa fa-plus"></i> <span>&nbsp;ADD NEW</span> </button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="default-datatable" class="table table-bordered text-dark table-hover table-striped checkWriterLiaisonTable">
                        <thead>
                        <tr>
                        <th>Action</th>
                        <th>LIAISON ID</th>
                        <th>FULL NAME</th>
                        <th>ADDRESS</th>
                        <th>CONTACT NO.</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>

<!-- START ADD LIASON MODAL -->
 <div class="modal fade" id="liaison_add" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content" style="background-color:#C9E0DC;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">LIAISON ADD</h5>
                <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" id="">&times;</span>
                </button>
            </div>
        <form method="post" enctype="multipart/form-data">
            <div class="modal-body" style="background-color: #F0FAF9;">
                <div class="row">
                    <div class="col-sm-12 form-group">
                        <label for="full_name" class="col-form-label">FULL NAME</label>
                        <input type="text" required style="border: 1px solid #08655d;" class="form-control text-success" id="full_name" placeholder="Enter liaison fullname" name="full_name">
                    </div>
                </div>
                 <div class="row">
                    <div class="col-sm-12 form-group">
                        <label for="address" class="col-form-label">ADDRESS</label>
                        <input type="text" required style="border: 1px solid #08655d;" class="form-control text-success" id="address" placeholder="Enter address" name="address">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label for="contact_no" class="col-form-label">CONRACT NO.</label>
                        <input type="text" required style="border: 1px solid #08655d;" class="form-control text-success" id="contact_no" placeholder="Enter contact number" name="contact_no">
                    </div>
                     <div class="col-sm-4 form-group">
                        <label for="sex" class="col-form-label">SEX</label>
                        <select name="sex" id="sex" style="border: 1px solid #08655d;" class="form-control text-success">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-sm-6 form-group">
                        <label for="type_of_id" class="col-form-label">TYPE OF ID</label>
                        <select name="type_of_id" id="type_of_id" style="border: 1px solid #08655d;" class="form-control text-success">
                            <option value="TIN">TIN</option>
                            <option value="SSS">SSS Card</option>
                            <option value="GSIS">GSIS</option>
                            <option value="PC">Philhealth Card</option>
                            <option value="SCC">Senior Citizen Card</option>
                            <option value="UMID">UMID</option>
                            <option value="SEC">SEC Rwgistration number</option>
                            <option value="DTI">DTI Registration number</option>
                            <option value="CDA">CDA Registration Number</option>
                            <option value="CID">Cooperative ID</option>
                            <option value="PID">Passport</option>
                            <option value="LTO">LTO Driver`s License</option>
                            <option value="PWD">PWD ID</option>
                            <option value="NID">National ID</option>
                            <option value="VID">Voter`s ID</option>
                            <option value="VC">Voter`s Certification</option>
                        </select>
                    </div>
                     <div class="col-sm-6 form-group">
                        <label for="id_no" class="col-form-label">ID NO</label>
                        <input type="text" required style="border: 1px solid #08655d;" class="form-control text-success"  id="id_no" placeholder="Enter ID number..." name="id_no">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label for="birth_date" class="col-form-label">BIRTH DATE</label>
                        <input type="date" required style="border: 1px solid #08655d;" class="form-control text-success"  id="birth_date" placeholder="Enter birth date..." name="birth_date">
                    </div>
                     <div class="col-sm-6 form-group">
                        <label for="birth_place" class="col-form-label">BIRTH PLACE</label>
                        <input type="text" required style="border: 1px solid #08655d;" class="form-control text-success"  id="birth_place" placeholder="Enter birth place" name="birth_place">
                    </div>
                </div>
                 <div class="row">
                    <div class="col-sm-6 form-group">
                        <label for="nationality" class="col-form-label">NATIONALITY</label>
                        <input type="text" required style="border: 1px solid #08655d;" class="form-control text-success"  id="nationality" placeholder="Enter nationality" name="nationality">
                    </div>
                     <div class="col-sm-6 form-group">
                        <label for="citizenship" class="col-form-label">CITIZENSHIP</label>
                        <input type="text" required style="border: 1px solid #08655d;" class="form-control text-success"  id="citizenship" placeholder="Enter citezenship" name="citizenship">
                    </div>
                </div>
            </div>
             <div class="modal-footer">
                <button type="submit" class="btn btn-soa" name="addLiaison" id="">Proceed</button>
                <button type="button" class="btn btn-soa" data-dismiss="modal">Close</button>
            </div>
        </div>
        </form>
        <?php 
        $conn = new ControllerCheckWriter();
        $add_liaison = $conn->ctrAddNewLiaison();
        
        ?> 
    </div>
</div>

<!-- EDIT DTR MODAL -->
<div class="modal fade" id="liaison_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">LIAISON EDIT</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form  method="post"  enctype="multipart/form-data">
        <div class="modal-body" >

        </div>
        <div class="modal-footer">
            <button type="submit" name ="editLiaison" class="btn btn-primary">Submit</button>
            <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </form>
        <?php
            $conn = new ControllerCheckWriter();
            $edit_liaison = $conn-> ctrEditLiaison();
        ?>
        </div> 
    </div>
</div>
<!-- END EDIT DTR MODAL -->  


 <!-- END TRANSACTION REPORT MODAL -->

    <!-- START TRANSACTION REPORT MODAL -->
    <!-- <div class="modal fade" id="bank_reset" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content" style="background-color:#C9E0DC;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">VIEW REPORT</h5>
                <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" id="">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="background-color: #F0FAF9;">
              <div class="row mt-2">
                  <div class="ml-2">
                      <label for="inputName" class="col-form-label">SELECT BANK :</label>
                  </div>
                  <div class="col-12">
                  <select class="form-control text-success" name="bnkchck_bank" id="bnkchck_bank" required>
                        <option value="All"  selected>All</option>
                        <?php

                        foreach ($banks as $key => $row) {
                          # code...
                          $bnkcd = $row['bnkcd'];
                          $bnk_name = $row['bnk_name'];
                        ?>
                       <option value="<?php echo $bnkcd;?>"><?php echo '('.$bnkcd.') '.$bnk_name?></option>
                     <?php } ?>
                    </select>
                  </div>
              </div>
              <div class="row mt-3">
              <div class="col-12 d-flex justify-content-center form-group">
                  <button type="button" name="" id="" class="btn btn-soa btn-round text-white border border-dark waves-effect waves-light">
                      <i class="fa fa-refresh"></i>
                      <span>&nbsp;RESET</span>
                  </button>
              </div>
              </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-soa" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div> -->
 <!-- END TRANSACTION REPORT MODAL -->

  <div class="overlay toggle-menu"></div>
  </div>    <!-- container-fluid -->
</div>      <!-- content-wrapper -->