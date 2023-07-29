$('.accountTable').DataTable({
    "ajax": "ajax/account.ajax.php", 
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
  
  $(".accountTable").on("click", "tbody .btnDeleteClient", function(){
    var idClient = $(this).attr("idClient");
  
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
              window.location = "index.php?route=accounts&idClient="+idClient;
          }
    })
  })
  
  
  $(".accountTable").on("click", "tbody .btnEditClient", function(){
    var idClient = $(this).attr("idClient");
    window.location = "index.php?route=accountedit&idClient="+idClient;
  })
  
  
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })
  
  
  
  