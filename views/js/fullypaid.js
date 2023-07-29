$('.fullpaidTable').DataTable({
    "ajax": "ajax/fullypaid.ajax.php", 
    "deferRender": true,
    "retrieve": true,
    "processing": true,
    "order": [[2, 'desc']],
    "iDisplayLength": 25,
  

  }); 
  $(".fullpaidTable").on("click", "tbody .btnShowRequest", function(){
    var idClient = $(this).attr("idClient");
    window.location = "index.php?route=showfullypaid&idClient="+idClient;
  })

  $(".fullpaidTable").on("click", "tbody .btnEditClient", function(){
    var idClient = $(this).attr("idClient");
    window.location = "index.php?route=fullypaidedit&idClient="+idClient;
  })



  $("#atm_status").on("change" , function(){
      // Create a new Date object
let now = new Date();

// Format the date and time
let formattedDate = now.toLocaleString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
let formattedTime = now.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true });

// Combine the formatted date and time
let dateTimeString = `${formattedDate} at ${formattedTime}`;
    var selectedOption = document.getElementById("atm_status").value;
    switch(selectedOption) {
      case "Claimed":
        document.getElementById("date_claimed").value = dateTimeString;
        break;
      case "Unclaimed":
        document.getElementById("date_claimed").value = "";
        break;
    }
  })  
 
   $(".fullpaidTable").on("click", "tbody .btnDeleteClient", function(){
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
              window.location = "index.php?route=fullypaid&idClient="+idClient;
          }
    })
  })

  $("#fpReport1").on("click", function(){
    var idClient = $(this).attr("idClient");
    var full_id = $(this).attr("full_id");
    window.location = "index.php?route=fullypaidreport1&idClient="+idClient+"&full_id="+full_id;
  })

  $("#report_id1").on("click", function(){
    var report_id1 = $(this).attr("report_id1");
 
    window.open("extensions/tcpdf/pdf/print_fullypaid_report1.php?report_id1="+report_id1);
  })

  $("#fpReport2").on("click", function(){
    var idClient = $(this).attr("idClient");
    var full_id = $(this).attr("full_id");
    window.location = "index.php?route=fullypaidreport2&idClient="+idClient+"&full_id="+full_id;
  })

  $("#report_id2").on("click", function(){
    var report_id2 = $(this).attr("report_id2");
 
    window.open("extensions/tcpdf/pdf/print_fullypaid_report2.php?report_id2="+report_id2);
  })
  $(".btnPrintFullyPaid").on("click", function(){

    window.open("extensions/tcpdf/pdf/print_fullypaid.php");
  })
  $(".generateReport").on("click", function(){
    var input = document.getElementById('dateFrom');
    var dateFrom = input.value;
    var input1 = document.getElementById('dateTo');
    var dateTo = input1.value;
    var select = document.getElementById('reportStatus');
    var selectedValue = select.value;
    $(".reportTable").empty();

  

       $.ajax({
                url: 'ajax/report.ajax.php',
                data: {
                  dateFrom: dateFrom,
                  dateTo: dateTo,
                  selectedValue: selectedValue
                },
                dataType: 'json',
                success: function(data) {
                    // // Clear the button container
                  
                    // var dateInWords = moment(new_date).format("MMMM DD, YYYY");
                    // $('#button-container').empty();
                    // $('#date-container').html("<div class='col-sm-1'><button class='btn btn-light' id='bck_mnt'><i class='fa fa-arrow-left'></i></button></div><div class='col-sm-2>'><h5 class='mt-2'>"+dateInWords+"</h5></div>");
                    // // Loop through the data and generate a button for each item
                    // $('#bck_mnt').click(function(){
                    //   $('#filter').trigger('change');
                    // });
                    
                 
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


  $(".showPrint1").on("click", function(){

   

    var input = document.getElementById('dateFrom');
    var prrdatefrom = input.value;
    var input1 = document.getElementById('dateTo');
    var prrdateto = input1.value;
    var select = document.getElementById('reportStatus');
    var clientCategory = select.value;

    window.open("extensions/tcpdf/pdf/print_fullypaid_report_by_category.php?prrdatefrom=" + prrdatefrom + "&prrdateto=" + prrdateto + "&clientCategory=" + clientCategory);
  })

  