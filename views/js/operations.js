$('.operationTable').DataTable({
    "ajax": "ajax/operation.ajax.php", 
    "deferRender": true,
    "retrieve": true,
    "processing": true
  });
  $('.operationlsorTable').DataTable({
    "ajax": "ajax/operationlsor.ajax.php", 
    "deferRender": true,
    "retrieve": true,
    "processing": true
  });

  $(".slcType").on("change", function(){
    var select1 = document.getElementById('type1');
    var selectedValue = select1.value;
    var showGrossing =  document.getElementById('grossin');
    var showOutgoing =  document.getElementById('outgoing');
    if(selectedValue === "grossin"){
        showGrossing.hidden = false;
        showOutgoing.hidden = true;
        $("#addBeginning").attr("name", "addGrossin");
    }else if(selectedValue === "outgoing"){
        showGrossing.hidden = true;
        showOutgoing.hidden = false;
        $("#addBeginning").attr("name", "addOutgoing");
    }  
    
  })

  
  $(".operationTable").on("click", "tbody .btnEditClient", function(){
    var idClient = $(this).attr("idClient");
    var type = $(this).attr("type");
 
    $('#editOperationModal .modal-body').empty();

        $.ajax({
          url: 'ajax/operationedit.ajax.php',
          data: {
            idClient: idClient,
            type: type
          },
          dataType: 'json',
          success: function(data) {
            
              $.each(data, function(index, item) {
                  var card = item.card;
                  $('#editOperationModal .modal-body').append(card);
              });
              $('#editOperationModal').modal('show');

          },
          error: function() {
              alert('Error fetching data');
          }
      });
   
  }) 

  $(".operationTable").on("click", "tbody .btnDeleteClient", function(){
    var idClient = $(this).attr("idClient");
    var type = $(this).attr("type");
    swal({
          title: 'Do you want to delete this record?',
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'cancel',
          confirmButtonText: 'Yes'
        }).then(function(result){
          if (result.value) {
              window.location = "index.php?route=operations&idClient="+idClient+"&type="+type;
          }
    }) 
  })

  $(".generateOperationReport").on("click",function(){
    var to1 = document.getElementById('to');
    var to = to1.value;
    var from1 = document.getElementById('from');
    var from = from1.value;
    var type1 = document.getElementById('type');
    var slcType = type1.value;
 
    swal({
      title: "Generating",
      text: "Please wait...",
      allowOutsideClick: false,
      allowEscapeKey: false,
      onOpen: () => {
        swal.showLoading();
      }
    });
  
    $.ajax({
      url: 'ajax/operationreport.ajax.php',
      data: {
        to: to,
        from: from,
        type: slcType
      },
      dataType: 'json',
      success: function(data) {
        swal.close();
        // Close loading screen
        $('.operationReport').html(data.card);
        var print = document.getElementById("printOperationReport");
        print.hidden = false;
      },
      error: function() {
        // Close loading screen
        swal.close();
  
        alert('Error fetching data');
      }
    });
   
  })


  $(".printOperationReport").on("click",function(){ 
    var to1 = document.getElementById('to');
    var to = to1.value;
    var from1 = document.getElementById('from');
    var from = from1.value;
    var type1 = document.getElementById('type');
    var slcType = type1.value;

    if(slcType === "grossin"){
      window.open("extensions/tcpdf/pdf/grossin_report.php?to="+to+"&from="+from);
    }else if(slcType === "outgoing"){
      window.open("extensions/tcpdf/pdf/outgoing_report.php?to="+to+"&from="+from);
    }
  
   
  })



  $(".btnLsorReport").on("click",function(){
    var month1 = document.getElementById('month');
    var month = month1.value;
    var type = "lsor";

    // swal({
    //   title: "Generating",
    //   text: "Please wait...",
    //   allowOutsideClick: false,
    //   allowEscapeKey: false,
    //   onOpen: () => {
    //     swal.showLoading();
    //   }
    // });
  
    $.ajax({
      url: 'ajax/operationreport.ajax.php',
      data: {
        month: month,
        type: type
      },
      dataType: 'json',
      success: function(data) {
        // Close loading screen
        $('.operationLsorReport').html(data.card);
        var print = document.getElementById("printOperationLsorReport");
        print.hidden = false;
      },
      error: function() {
        // Close loading screen

        alert('Error fetching data');
      }
    });
   
  })


  $(".printOperationLsorReport").on("click",function(){ 
    var month1 = document.getElementById('month');
    var month = month1.value;

    window.open("extensions/tcpdf/pdf/operation_LSOR.php?month="+month);
  })

   
  $(".operationlsorTable").on("click", "tbody .btnEditClient", function(){
    var idClient = $(this).attr("idClient");

    window.location = "index.php?route=operationlsoredit&idClient="+idClient;
  })

  $(".operationlsorTable").on("click", "tbody .btnDeleteClient", function(){
    var idClient = $(this).attr("idClient");

        swal({
          title: 'Do you want to delete this record?',
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'cancel',
          confirmButtonText: 'Yes'
        }).then(function(result){
          if (result.value) {
            window.location = "index.php?route=operationlsor&idClient="+idClient;
          }
    })


  })