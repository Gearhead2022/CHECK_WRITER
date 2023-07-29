$('.clientsTable').DataTable({
  "ajax": "ajax/clients.ajax.php", 
  "deferRender": true,
  "retrieve": true,
  "processing": true,

});

$("#btn_add").on("click", function(){

  window.location = "index.php?route=clientadd&type=EMB";
})

$("#btn_emb").on("click", function(){

  var company = "EMB";

 window.open("extensions/tcpdf/pdf/emb_report.php?company="+company);
  
})

$("#logout").on("click", function(){
  
  swal({
        title: 'Are you sure you want to logout?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'cancel',
        confirmButtonText: 'Yes'
      }).then(function(result){
        if (result.value) {
            window.location = "logout";
        }
  })
})

$(".clientsTable").on("click", "tbody .btnDeleteClient", function(){
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
            window.location = "index.php?route=clients&idClient="+idClient+"&file_name="+file_name+"&company="+company+"&id_num="+id_num;
        }
  })
})
 
$(".clientsTable").on("click", "tbody .btnEditClient", function(){
  var idClient = $(this).attr("idClient");
  var type = $(this).attr("type");
  window.location = "index.php?route=clientedit&idClient="+idClient+"&type="+type;
})

$(".img_add1").on("click", function(){

  var img_name = $(this).attr("img_name");
  var idClient = $(this).attr("idClient");
  var id_num = $(this).attr("id_num");
  var type = $(this).attr("type");
  

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
            window.location = "index.php?route=clientedit&idClient="+idClient+"&img_name="+img_name+"&id_num="+id_num+"&type="+type;
        }
  })
})

$(".clientsTable").on("click", "tbody .btnEditShowClient", function(){
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

$(".editDocu").on("click", function(){
  var folder_name = $(this).attr("folder_name");
  var folder_id = $(this).attr("folder_id");
 
  $.ajax({
    url: 'ajax/employeefiles.ajax.php',
    type: 'post',
    data: {folder_id: folder_id, folder_name: folder_name},
    success: function(response){ 
       // Add response in Modal body
       $('.modal-body').html(response);

       // Display Modal
       $('#editDocument').modal('show'); 
    }
 });
 
})

$(".deleteDocu").on("click", function(){
  var folderid = $(this).attr("folderid");
  var folder_id = $(this).attr("folder_id");
  var company = $(this).attr("company");
  var id_num = $(this).attr("id_num");
  var employee_name = $(this).attr("employee_name");

  
  

  swal({
        title: 'Do you want to delete this folder?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'cancel',
        confirmButtonText: 'Yes'
      }).then(function(result){
        if (result.value) {
            window.location = "index.php?route=documentadd&company="+company+"&id_num="+id_num+"&employee_name="+employee_name+"&folder_id="+folder_id+"&folderid="+folderid;
        }
  })
})


$('.pop').on('click', function() {
  $('.imagepreview').attr('src', $(this).find('img').attr('src'));
  $('#imagemodal').modal('show');   
})


$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
