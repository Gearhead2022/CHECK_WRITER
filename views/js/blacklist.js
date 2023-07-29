$('.blacklistTable').DataTable({
  "ajax": "ajax/blacklist.ajax.php", 
  "deferRender": true,
  "retrieve": true,
  "processing": true
});

// $("#side").on("click", function(){
  
//   swal({
//         title: 'Are you sure you want to logout?',
//         type: 'warning',
//         showCancelButton: true,
//         confirmButtonColor: '#3085d6',
//         cancelButtonColor: '#d33',
//         cancelButtonText: 'cancel',
//         confirmButtonText: 'Yes'
//       }).then(function(result){
//         if (result.value) {
//             window.location = "logout";
//         }
//   })
// })

$(".blacklistTable").on("click", "tbody .btnDeleteClient", function(){
  var idClient = $(this).attr("idClient");
  var clientid = $(this).attr("clientid");
  var file_name = $(this).attr("file_name");
   
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
            window.location = "index.php?route=blacklist&idClient="+idClient+"&file_name="+file_name+"&clientid="+clientid;
        }
  })
})

$(".img_add").on("click", function(){

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
            window.location = "index.php?route=blacklistedit&idClient="+idClient+"&img_name="+img_name;
        }
  })
})
$(".blacklistTable").on("click", "tbody .btnEditClient", function(){
  var idClient = $(this).attr("idClient");
  window.location = "index.php?route=blacklistedit&idClient="+idClient;
})

$(".blacklistTable").on("click", "tbody .btnEditShowClient", function(){
  var idClient = $(this).attr("idClient");
  $.ajax({
    url: 'ajax/blacklist.show.php',
    type: 'post',
    data: {idClient: idClient},
    success: function(response){ 
       // Add response in Modal body
       $('.modal-body').html(response);

       // Display Modal
       $('#empModal').modal('show'); 
    }
 });
 
})

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})



