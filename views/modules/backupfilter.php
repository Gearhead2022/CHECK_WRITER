<?php 
$all_branch = (new ControllerBackup)->ctrGetAllBranch();

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
}.dropdown-item{
  cursor: pointer;
}
#filter{
  text-transform: capitalize;
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
       
          <div class="card">
            <div class="card-body">
             <div class="row">
              <div class="col-sm-12">
               <h5>SEARCH</h5>
              </div>
             </div>
                <div class="row">
                <div class="col-sm-3 form-group">
                <label for="input-1">BRANCH NAME</label>
                <select class="form-control"  onchange="filterBackup()" name="filter" id="filter">
                    <option value="All">ALL</option>
                  <?php 
                    foreach ($all_branch as $key => $value) {
                      $branch_name = $value['branch_name'];
                  ?>
                    <option value="<?php echo $branch_name; ?>" ><?php echo $branch_name; ?></option>
                  <?php  }?>


                </select>
                    
                </div>
                <div class="col-sm-2 form-group">
                <label for="input-1">YEAR</label>
                <select class="form-control" onchange="filterBackup()"  id="filter_year" name="branch_name" id="branch_name">
                   <option value="">Select Year</option>
                    <option value="2023">2023</option>
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                </select>
                    
                </div><div class="col-sm-2 form-group">
                <label for="input-1">MONTH</label>
                <select class="form-control" onchange="filterBackup()" name="branch_name" id="filter_month">
                    <option value="">Select Month</option>
                    <option value="01">January</option>
                    <option value="02">February</option>
                    <option value="03">March</option>
                    <option value="04">April</option>
                    <option value="05">May</option>
                    <option value="06">June</option>
                    <option value="07">July</option>
                    <option value="08">August</option>
                    <option value="09">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                </select>
                    </div>
                </div>
                <div class="row mt-2">
                  <div class="col-sm-12">
                   <h5>RESULTS</h5>
                  </div>
               </div>
                <div class="row mt-2 mb-2" id="date-container"></div>
                  <div class="row mt-2 mb-2" id="back-container"></div>
                <div class="row" id="button-container"></div>
            </div>
            <div class="card-footer">
              <div class="row">
                <div class="col-lg-3">
                </div>
                <div class="col-lg-9">
                  <div class="float-sm-right">
              

                   <button type="button" class="btn btn-light btn-round px-5" onClick="location.href='backups'"><i class="fa fa-list"></i>&nbsp;&nbsp;Listing</button>                           
                  </div>
                </div>
              </div>
            </div>  

          </div>  
      

        
        
        <?php
          $downloadFiles= new ControllerBackup();
          $downloadFiles -> ctrDownloadFiles();
        ?>
 
      </div>
    </div><!--End Row-->
  <div class="overlay toggle-menu"></div>
  </div>    <!-- container-fluid -->
</div>      <!-- content-wrapper -->

