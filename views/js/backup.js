$('.backupTable').DataTable({
    "ajax": "ajax/backup.ajax.php", 
    "deferRender": true,
    "retrieve": true,
    "processing": true,
    "order": [4, 'asc'],
    "iDisplayLength": 25
  });
  $(".backupTable").on("click", "tbody .btnShowRequest", function(){
    var idClient = $(this).attr("idClient");
    window.location = "index.php?route=showbackup&idClient="+idClient;
  })
  $(".send").on("click", function () {
    var backup_id = $(this).attr("backup_id");
    var branch_name = $(this).attr("branch_name");
    var new_date = $(this).attr("new_date");
    var send = document.getElementById('send');

    swal({
      title: "Are you sure you want to send it to email?",
      type: "info",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      cancelButtonText: "cancel",
      confirmButtonText: "Yes",
    }).then(function (result) {
      if (result.value) {
        sendFiles(send);
        window.location = "email/send_file.php?backup_id="+backup_id+"&branch_name="+branch_name+"&new_date="+new_date;
      }
    });
  });
  function sendFiles(send)
{
  //alert('asdasd');
  send.disabled=true; 
  send.innerHTML='<i class="fa fa-save"></i> Sending...<i class="fa fa-spinner fa-spin fa-1x fa-fw"></i><span class="sr-only">Loading...</span>';
}

$(".dlt_file").on("click", function(){
  var idClient = $(this).attr("idClient");
  var branch_name = document.getElementById('branch_name').value;
  var file_name = $(this).attr("file_name");
  var file_id = $(this).attr("file_id");
  var new_date = document.getElementById('new_date').value;

  swal({
        title: 'Do you want to delete this file?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'cancel', 
        confirmButtonText: 'Yes' 
      }).then(function(result){
        if (result.value) {
            window.location = "index.php?route=backupedit&file_name="+file_name+"&idClient="+idClient+"&branch_name="+branch_name+"&new_date="+new_date+"&file_id="+file_id;
        }
  })
}) 

$(".toReceive").on("click", function(){
  var backup_id = $(this).attr("backup_id");
  var status = $(this).attr("status");
  swal({
        title: 'Are you sure you want to receive this file?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'cancel', 
        confirmButtonText: 'Yes'
      }).then(function(result){
        if (result.value) {
            window.location = "index.php?route=backups&answer=ok&backup_id="+backup_id+"&status="+status;
        }
  })
}) 
  
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
  
  $(".backupTable").on("click", "tbody .btnDeleteClient", function(){
    var idClient = $(this).attr("idClient");
    var backup_id = $(this).attr("backup_id");
  
    swal({
          title: 'Do you want to delete this backup?',
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'cancel',
          confirmButtonText: 'Yes' 
        }).then(function(result){
          if (result.value) {
              window.location = "index.php?route=backups&idClient="+idClient+"&backup_id="+backup_id;
          }
    })
  })
  
  
  $(".backupTable").on("click", "tbody .btnEditClient", function(){
    var idClient = $(this).attr("idClient");
    window.location = "index.php?route=backupedit&idClient="+idClient;
  })
  

  $(".dl_file").on("click", function(){
    var idClient = $(this).attr("idClient");
    var file_name = $(this).attr("file_name");
    var new_date = $(this).attr("new_date");
    var branch_name = document.getElementById('branch_name').value;
    
    swal({
          title: 'Do you want to download this file?',
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'cancel',
          confirmButtonText: 'Yes'
        }).then(function(result){
          if (result.value) {
              window.location = "index.php?route=showbackup&idClient="+idClient+"&file_name="+file_name+"&new_date="+new_date+"&branch_name="+branch_name;
          }
    })
  })     
   
  function filterBackup() {
    // Get the selected filter value
    $('#back-container').empty();
    var filterMonth = document.getElementById('filter_month').value;
    var branch_name = document.getElementById('filter').value;
    var filterYear = document.getElementById('filter_year').value;

    if(filterMonth !="" && filterYear !="" && branch_name !="All"){
      $('#back-container').html("<div class='col-sm-1'><button class='btn btn-light' id='back_month'><i class='fa fa-arrow-left'></i></button></div>");
      $('#back_month').click(function(){
        var $select = $('#filter_month');
        $select.val('');
        $('#filter').trigger('change');
      });
    }else if(branch_name !="All" && filterYear !="" && filterMonth ==""){
      $('#back-container').html("<div class='col-sm-1'><button class='btn btn-light' id='back_name'><i class='fa fa-arrow-left'></i></button></div>");
      $('#back_name').click(function(){
        var $branch = $('#filter');
        $branch.val("All");
        $('#filter').trigger('change');
      });
    } 
    $('#date-container').empty();
    // Make an AJAX request to the filter.php script with the selected filter value as a parameter
    $.ajax({
        url: 'ajax/filter.ajax.php',
        data: {
          filterYear: filterYear,
          branch_name: branch_name,
          filterMonth: filterMonth
        },
        dataType: 'json',
        success: function(data) {
            // Clear the button container
            $('#button-container').empty();
            if (Object.keys(data).length === 0) {
              $('#back-container').empty();
            }
            // Loop through the data and generate a button for each item
            $.each(data, function(index, item) {
              var button = item.button;
              var $success = item.success;
              $('#button-container').append(button);
            });
            
            $('.clk_name').click(function(){
              var branch_name1 = $(this).attr("branch_name");
              var $branch = $('#filter');
              var $filter_year = $('#filter_year');
              $filter_year.val("2023");
              $branch.val(branch_name1);
              $('#filter').trigger('change');
              $('#back-container').html("<div class='col-sm-1'><button class='btn btn-light' id='back_name'><i class='fa fa-arrow-left'></i></button></div>");
              $('#back_name').click(function(){
                $branch.val("All");
                $('#filter').trigger('change');
              });
            });
            $('.toDownload').click(function(){
              
              var new_date = $(this).attr("new_date");
           
              swal({
                title: 'Do you want to download this folder?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'cancel',
                confirmButtonText: 'Yes'
              }).then(function(result){
                if (result.value) {
                    window.location = "email/download3.php?branch_name="+branch_name+"&new_date="+new_date;
                }
          })
              
          });
            $('.preview_file2').click(function() {
              var backup_id = $(this).attr("backup_id");
              var new_date = $(this).attr("new_date");
              var branch_name = $(this).attr("branch_name");
              $('#back-container').empty();
              $.ajax({
                url: 'ajax/filter.ajax.php',
                data: {
                  backup_id: backup_id,
                  new_date: new_date,
                  branch_name: branch_name
                },
                dataType: 'json',
                success: function(data) {
                    // Clear the button container
                  
                    var dateInWords = moment(new_date).format("MMMM DD, YYYY");
                    $('#button-container').empty();
                    $('#date-container').html("<div class='col-sm-1'><button class='btn btn-light' id='bck_mnt'><i class='fa fa-arrow-left'></i></button></div><div class='col-sm-2>'><h5 class='mt-2'>"+dateInWords+"</h5></div>");
                    // Loop through the data and generate a button for each item
                    $('#bck_mnt').click(function(){
                      $('#filter').trigger('change');
                    });
                    
                 
                    $.each(data, function(index, item) {
                        var card = item.card;
                        $('#button-container').append(card);
                    });
                },
                error: function() {
                    alert('Error fetching data');
                }
            });
           
            });
            $('.clk_month').click(function(){
              var monthNum = $(this).attr("monthNum");
              var $select = $('#filter_month');
              $select.val(monthNum);
              $('#filter').trigger('change');
              $('#back-container').html("<div class='col-sm-1'><button class='btn btn-light' id='back_month'><i class='fa fa-arrow-left'></i></button></div>");
              change = 1;
              $('#back_month').click(function(){
                $select.val('');
                $('#filter').trigger('change');
              });
              
            });

        },
        error: function() {
            alert('Error fetching data');
        }
    });
  }
  

    // Trigger the filter select change event to generate the initial buttons
    $('#filter').trigger('change');

    $('.downloadFiles').click(function(){
              
      var new_date = $(this).attr("new_date");
      var branch_name = $(this).attr("branch_name");
   
      swal({
        title: 'Do you want to download this folder?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'cancel',
        confirmButtonText: 'Yes'
      }).then(function(result){
        if (result.value) {
            window.location = "email/download3.php?branch_name="+branch_name+"&new_date="+new_date;
        }
  })
      
  });
    
   
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })
  

  $(".backupChecker").on("click", function(){
    var input = document.getElementById('dateFrom');
    var dateFrom = input.value;
    
    $(".reportTable").empty();
       $.ajax({
                url: 'ajax/backupchecker.ajax.php',
                data: {
                  dateFrom: dateFrom
                },
                dataType: 'json',
                success: function(data) {
                    $.each(data, function(index, item) {
                        var card = item.card;
                        $('.reportTable').append(card);
                    });

                    // Get the element with the ID "showTable"
                var element = document.getElementById("showTable");
                var print = document.getElementById("showPrint");

                // Set the hidden attribute to false to show the element
                element.hidden = false;
                print.hidden = false;
                    
                },
                error: function() {
                    alert('Error fetching data');
                }
            });
          
  })

  
  $(".checkBackup").on("change", function(){ 

    var dateSlct1 = document.getElementById('checkBackup');
    var dateSlct = dateSlct1.value;
    
  swal({
    title: "Generating",
    text: "Please wait...",
    allowOutsideClick: false,
    allowEscapeKey: false,
    onOpen: () => {
      swal.showLoading();
    }
  });

    $(".reportTable").empty();
       $.ajax({
                url: 'ajax/backupchecker.ajax.php',
                data: {
                  dateSlct: dateSlct
                },
                dataType: 'json',
                success: function(data) {
                  setTimeout(() => {
                  swal.close();
              
                  
                    $.each(data, function(index, item) {
                        var card = item.card;
                        $('.reportTable').append(card);
                    });

                               // Get the element with the ID "showTable"
                var element = document.getElementById("showTable");
                var print = document.getElementById("showPrint");

                // Set the hidden attribute to false to show the element
                element.hidden = false;
                print.hidden = false;
              }, 1500) },
                error: function() {
                  swal.close();
                    alert('Error fetching data');
                }
            });

  })

  
  
  