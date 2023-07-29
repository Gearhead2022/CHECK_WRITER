$('.permitTable').DataTable({
    "ajax": "ajax/permit.ajax.php", 
    "deferRender": true,
    "retrieve": true,
    "processing": true,
    "order": [2, 'decs']
  }); 
   
 
  $("#rlc_add").on("click", function(){

    window.location = "index.php?route=clientadd&type=RLC";
  })
  $(".permitTable").on("click", "tbody .btnShowRequest", function(){
    var idClient = $(this).attr("idClient");
    window.location = "index.php?route=showrequest&idClient="+idClient;
  })
  $(".permitTable").on("click", "tbody .btnEditShowClient", function(){
    var idClient = $(this).attr("idClient");
    window.location = "index.php?route=showrequest&idClient="+idClient;
  })

  $(".permitTable").on("click", "tbody .btnEditClient", function(){
    var idClient = $(this).attr("idClient");
    var type = $(this).attr("type");
    window.location = "index.php?route=workingpermitedit&idClient="+idClient;
  })

  $(".rlcTable").on("click", "tbody .btnEditShowClient", function(){
    var idClient = $(this).attr("idClient");
    var type = $(this).attr("type");
    $.ajax({
      url: 'ajax/clients.show.php',
      type: 'post',
      data: {idClient: idClient, type: type},
      success: function(response){ 
         // Add response in Modal body
         $('.modal-body').html(response);
  
         // Display Modal
         $('#empModal').modal('show'); 
      }
   });
   
  })

  $(".permitTable").on("click", "tbody .btnDeleteClient", function(){
    var idClient = $(this).attr("idClient");
    var ref_id = $(this).attr("ref_id");
    swal({ 
          title: 'Do you want to delete this account?',
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'cancel',
          confirmButtonText: 'Yes'
        }).then(function(result){
          if (result.value) { 
            window.location = "index.php?route=workingpermit&idClient="+idClient+"&ref_id="+ref_id;
          }


    })
  })
  $(".dlt_img").on("click", function(){
    var img_name = $(this).attr("img_name");
    var idClient = $(this).attr("idClient");
    swal({
          title: 'Do you want to delete this image?',
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'cancel',
          confirmButtonText: 'Yes'
        }).then(function(result){
          if (result.value) {
              window.location = "index.php?route=workingpermitedit&img_name="+img_name+"&idClient="+idClient;
          }
    })
  })
  $("#done_records").on("click", function(){
    var idClient = $(this).attr("idClient");
    var status = $(this).attr("status");
    var wp_remarks = document.getElementById("wp_remarks").value;
    swal({
          title: 'Are you sure that this request is already done?',
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'cancel',
          confirmButtonText: 'Yes'
        }).then(function(result){
          if (result.value) {
            window.location = "index.php?route=showrequest&idClient="+idClient+"&status="+status+"&wp_remarks="+wp_remarks;
          }
    })
  })
  $("#approve_records").on("click", function(){
    var idClient = $(this).attr("idClient");
    var user = $(this).attr("user");
    swal({
          title: 'Are you sure you want to approve this request?',
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'cancel',
          confirmButtonText: 'Yes'
        }).then(function(result){
          if (result.value) {
            window.location = "index.php?route=showrequest&idClient="+idClient+"&user="+user;
          }
    })
  })
  $("#check_records").on("click", function(){
    var idClient = $(this).attr("idClient");
    var user = $(this).attr("user");
    swal({
          title: 'Are you sure you want to check this request?',
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'cancel',
          confirmButtonText: 'Yes'
        }).then(function(result){
          if (result.value) {
            window.location = "index.php?route=showrequest&idClient="+idClient+"&chk=ok";
          }
    })
  })

  
  $("#btn_rlc").on("click", function(){

    var company = "RLC";
  
   window.open("extensions/tcpdf/pdf/emb_report.php?company="+company);
    
  })
