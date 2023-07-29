<div class="clearfix"></div>
  
<div class="content-wrapper">
   <div class="container-fluid">
     <div class="row pt-2 pb-2">
        <div class="col-sm-12">
          <h4 class="page-title">Product List</h4>
        </div>
     </div>

      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header float-sm-right">
              <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1" onClick="location.href='productadd'"><i class="fa fa-plus"></i> <span>&nbsp;ADD PRODUCT</span> </button>
            </div>            

            <div class="card-body">
              <div class="table-responsive">
              <table id="default-datatable" class="table table-bordered table-hover table-striped tables">
                <thead>
                    <tr>
                      <th>Product ID</th>
                      <th>Description</th>
                      <th>Abbr</th>
                      <th>Unit Cost</th>
                      <th>Mark-up</th>
                      <th>Unit Price</th>
                      <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                  <?php
                    $products = (new ControllerProducts)->ctrShowProducts();
                    foreach ($products as $key => $value) {
                      echo '<tr>
                              <td>'.$value["prodid"].'</td>
                              <td>'.$value["prodname"].'</td>
                              <td>'.$value["abbr"].'</td>  
                              <td>'.$value["ucost"].'</td>
                              <td>'.$value["mrk"].'</td> 
                              <td>'.$value["uprice"].'</td>           
                              <td>
                                <div class="btn-group group-round m-1">
                                  <button class="btn btn-sm btn-light waves-effect waves-light btnEditProduct" idProduct="'.$value["id"].'"><i class="fa fa-pencil"></i></button>
                                  <button class="btn btn-sm btn-light waves-effect waves-light btnDeleteProduct" idProduct="'.$value["id"].'"><i class="fa fa-times"></i></button>
                                </div>  
                              </td>
                            </tr>';
                      }
                  ?>
                </tbody>

              </table>
            </div>
            </div>
          </div>
        </div>
      </div>    <!-- row -->

    <div class="overlay toggle-menu"></div>
  </div>        <!-- container-fluid -->
</div>          <!-- content-wrapper -->

<?php
  $deleteProduct = new ControllerProducts();
  $deleteProduct -> ctrDeleteProduct();
?>