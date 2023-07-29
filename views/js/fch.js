$('.fchTable').DataTable({
    "ajax": "ajax/fch.ajax.php", 
    "deferRender": true,
    "retrieve": true,
    "processing": true
  });

  $("#fch_add").on("click", function(){

    window.location = "index.php?route=clientadd&type=FCH";
  })

  $(".fchTable").on("click", "tbody .btnEditClient", function(){
    var idClient = $(this).attr("idClient");
    var type = $(this).attr("type");
    window.location = "index.php?route=clientedit&idClient="+idClient+"&type="+type;
  })
  $(".fchTable").on("click", "tbody .btnEditShowClient", function(){
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
  $(".fchTable").on("click", "tbody .btnDeleteClient", function(){
    var idClient = $(this).attr("idClient");
    var file_name = $(this).attr("file_name");
    var company = $(this).attr("company");
    var id_num = $(this).attr("id_num");
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
            window.location = "index.php?route=fch&idClient="+idClient+"&file_name="+file_name+"&company="+company+"&id_num="+id_num;
          } 
    })
  })

  $("#btn_fch").on("click", function(){

    var company = "FCH";
  
   window.open("extensions/tcpdf/pdf/emb_report.php?company="+company);
    
  })