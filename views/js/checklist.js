$('.checklistTable').DataTable({
    "ajax": "ajax/checklist.ajax.php", 
    "deferRender": true,
    "retrieve": true,
    "processing": true
  });


   
  $(".checklistTable").on("click", "tbody .btnViewChecklist", function(){
    var idClient = $(this).attr("idClient");
    var chk_date = $(this).attr("chk_date");
    window.location = "index.php?route=checklistadd&idClient="+idClient+"&chk_date="+chk_date;
  })

  $(".checklistTable").on("click", "tbody .btnEditClient", function(){
    var idClient = $(this).attr("idClient");
    var type = "Checklist";
     $('#chacklistEditModal .modal-body').empty();

        $.ajax({
          url: 'ajax/checklistedit.ajax.php',
          data: {
            idClient: idClient,
            type: type
          },
          dataType: 'json',
          success: function(data) {
            
              $.each(data, function(index, item) {
                  var card = item.card;
                  $('#chacklistEditModal .modal-body').append(card);
              });
              $('#chacklistEditModal').modal('show');

              
            
          },
          error: function() {
              alert('Error fetching data');
          }
      });
  
  })
  
  $(".btnDeleteReport").on("click", function(){
    var chk_id = $(this).attr("chk_id");
    var idClient = $(this).attr("idClient");
    var chk_date = $(this).attr("chk_date");
   
    swal({
          title: 'Do you want to delete this report?',
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'cancel',
          confirmButtonText: 'Yes'
        }).then(function(result){
          if (result.value) {
              window.location = "index.php?route=checklistadd&idClient="+chk_id+"&chk_date="+chk_date+"&id="+idClient;
          }
    })

  })

  $(".boxID").on("change", function(){
    var select1 = document.getElementById('boxID');
    var selectedValue = select1.value;
    $(".chkboxReports").empty();
  
    
       $.ajax({
                url: 'ajax/copy.ajax.php',
                data: {
                  selectedValue: selectedValue
                },
                dataType: 'json',
                success: function(data) {
                   
                    $.each(data, function(index, item) {
                        var card = item.card;
                        $('.chkboxReports').append(card);
                    });

                    var element = document.getElementById("showCheckBox");
                  
    
                    // Set the hidden attribute to false to show the element
                    element.hidden = false;
                  
                },
                error: function() {
                    alert('Error fetching data');
                }
            });
          
  })

  $(".btnEditReport").on("click", function(){
    var idClient = $(this).attr("idClient");
    var chk_id = $(this).attr("chk_id");
    var type = "ChecklistReport";

     $('#editChecklistReportModal .modal-body').empty();

        $.ajax({
          url: 'ajax/checklistedit.ajax.php',
          data: {
            idClient: idClient,
            type: type,
            chk_id: chk_id
          },
          dataType: 'json',
          success: function(data) {
            
              $.each(data, function(index, item) {
                  var card = item.card;
                  $('#editChecklistReportModal .modal-body').append(card);
              });
              $('#editChecklistReportModal').modal('show');

              
            
          },
          error: function() {
              alert('Error fetching data');
          }
      });

  })
  

  $(".checklistTable").on("click", "tbody .btnDeleteClient", function(){
    var idClient = $(this).attr("idClient");
    var chk_id = $(this).attr("chk_id");
  
    swal({
          title: 'Do you want to delete this checklist?',
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'cancel',
          confirmButtonText: 'Yes'
        }).then(function(result){
          if (result.value) {
              window.location = "index.php?route=checklist&idClient="+idClient+"&chk_id="+chk_id;
          }
    })
  })

  $(".showPrint12").on("click", function(){
    var chk_id = $(this).attr("chk_id");
    var reportDate = $(this).attr("reportDate");
    window.open("extensions/tcpdf/pdf/checklistreport.php?chk_id="+chk_id+"&reportDate="+reportDate);
  })