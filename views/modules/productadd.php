<?php
  $next_id = (new Connection)->connect()->query("SHOW TABLE STATUS LIKE 'products'")->fetch(PDO::FETCH_ASSOC)['Auto_increment'];
  $prodid = "PR" . str_repeat("0",4-strlen($next_id)).$next_id;
?>


<div class="clearfix"></div>
	
<div class="content-wrapper">
  <div class="container-fluid">
   <div class="row pt-2 pb-2">
     <div class="col-sm-12">
  	    <h4 class="page-title">PRODUCT INFORMATION</h4>
     </div>
   </div>

    <div class="row">
      <div class="col-lg-12">
        <form role="form" method="POST" autocomplete="nope" class="productForm">
          <div class="card">
            <div class="card-body">
                 <div class="row">
                      <div class="col-sm-11 form-group">
                          <label for="input-1">Description</label>
                          <input type="text" class="form-control" id="input-1" placeholder="Enter Product Name" name="newProdname" autocomplete="nope" required>
                      </div>                   

                      <div class="col-sm-1 form-group">
                          <label for="input-2">Prod ID</label>
                          <input type="text" class="form-control" id="input-2" name="newProdid" value="<?php echo $prodid;?>" readonly>
                      </div>
                  </div>                                                

                  <div class="row">
                      <div class="col-sm-3 form-group">
                          <label for="input-6">Abbreviation</label>
                          <input type="text" class="form-control" id="input-6" placeholder="Enter Abbreviation" name="newAbbr" autocomplete="nope">
                      </div>

                      <div class="col-sm-3 form-group">
                          <label for="input-6">Unit Cost</label>
                          <input type="text" class="form-control" id="ucost" placeholder="0" name="ucost" autocomplete="nope">
                      </div>

                      <div class="col-sm-3 form-group">
                          <label for="input-6">Mark-up</label>
                          <input type="text" class="form-control" id="mrk" placeholder="0" name="mrk" readonly>
                      </div>

                      <div class="col-sm-3 form-group">
                          <label for="input-6">Unit Price</label>
                          <input type="text" class="form-control" id="uprice" placeholder="0" name="uprice" autocomplete="nope">
                      </div>                                            
                  </div> 
            </div>

            <div class="card-footer">
              <div class="row">
                <div class="col-lg-3">
                </div>
                <div class="col-lg-9">
                  <div class="float-sm-right">
                   <button type="submit" class="btn btn-light btn-round px-5"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
                   
                   <button type="button" class="btn btn-light btn-round px-5" onClick="location.href='products'"><i class="fa fa-list"></i>&nbsp;&nbsp;Listing</button>                           
                  </div>
                </div>
              </div>
            </div>  <!-- footer -->

          </div>    <!-- card -->
        </form>


      </div>
    </div><!--End Row-->

  <div class="overlay toggle-menu"></div>
  </div>    <!-- container-fluid -->
</div>      <!-- content-wrapper -->