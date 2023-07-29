$('.requestTable').DataTable({
    "ajax": "ajax/request.ajax.php", 
    "deferRender": true,
    "retrieve": true,
    "processing": true,
    "order": [5, 'decs']
  });

  $("#rlc_add").on("click", function(){

    window.location = "index.php?route=clientadd&type=RLC";
  })
  $(".requestTable").on("click", "tbody .btnShowRequest", function(){
    var idClient = $(this).attr("idClient");
    window.location = "index.php?route=showrequests&idClient="+idClient;
  })
  $(".requestTable").on("click", "tbody .btnEditShowClient", function(){
    var idClient = $(this).attr("idClient");
    window.location = "index.php?route=showrequest&idClient="+idClient;
  })

  $(".requestTable").on("click", "tbody .btnEditClient", function(){
    var idClient = $(this).attr("idClient");
    var type = $(this).attr("type");
    window.location = "index.php?route=requestedit&idClient="+idClient;
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

  $(".requestTable").on("click", "tbody .btnDeleteClient", function(){
    var idClient = $(this).attr("idClient");
    var ref_id = $(this).attr("ref_id");
    swal({
          title: 'Do you want to delete this request?',
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'cancel',
          confirmButtonText: 'Yes'
        }).then(function(result){
          if (result.value) { 
            window.location = "index.php?route=request&idClient="+idClient+"&ref_id="+ref_id;
          }


    })
  })
 
  $("#request_done").on("click", function(){
    var idClient = $(this).attr("idClient");
    var status = $(this).attr("status");
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
            window.location = "index.php?route=showrequests&idClient="+idClient+"&status="+status;
          }
    })
  })
  $(".dlt_req_img").on("click", function(){
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
              window.location = "index.php?route=requestedit&img_name="+img_name+"&idClient="+idClient;
          }
    })
  })

  
  $("#btn_rlc").on("click", function(){

    var company = "RLC";
  
   window.open("extensions/tcpdf/pdf/emb_report.php?company="+company);
    
  })
