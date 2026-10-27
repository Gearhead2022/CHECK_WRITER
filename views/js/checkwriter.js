
$(".updateCheckWriterFileRecords").on("click", function () {
  var collDate = document.getElementById('bnkchck_date').value;
  var branch_name = document.getElementById('bnkchck_branch_name').value;

  // Display loading screen
  swal({
    title: "Generating",
    text: "Please wait...",
    allowOutsideClick: false,
    allowEscapeKey: false,
    onOpen: () => {
      swal.showLoading();
    }
  });

  var table = $('.checkWriterTable').DataTable();

  // Clear the existing data
  table.clear().draw();

  $.ajax({
    url: 'ajax/checkWriterCollectionList.ajax.php',
    type: 'GET',
    data: { collDate: collDate, branch_name: branch_name },
    dataType: 'json',
    success: function (data) {
      swal.close();

      if (data.data.length > 0) {
        // Add new data to the table
        table.rows.add(data.data).draw();
      } else {
        // Show a message or handle empty data as needed
        swal({
          type: "warning",
          title: 'No Records Found in Transaction. Date<u> ' + collDate + '</u>',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'cancel',
          confirmButtonText: 'OK'
        }).then(function (result) {
          if (result.value) {

          }

        });
      }
    },
    error: function () {
      swal.close();
      swal({
        type: "warning",
        title: 'No Records Found in Coll. Date<u> ' + collDate + '</u>',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'cancel',
        confirmButtonText: 'OK'
      }).then(function (result) {
        if (result.value) {

        }

      });
    }
  });
});

var cdate1 = "";
var docno1 = "";
var type = "";
var chkamt = "";

$(".checkWriterTable").on("click", "tbody .btnSelectBank", function () {

  cdate1 = $(this).attr("cdate");
  docno1 = $(this).attr("docno");
  type = $(this).attr("action");
  chkamt = $(this).attr("chkamt");

  if (type === "btnPrintBNKCHK") {
    $("#btnPrintBNKCHK").removeAttr('hidden');
    $('#btnRePrintBNKCHK').attr('hidden', true);
  } else {
    $('#btnRePrintBNKCHK').removeAttr('hidden');
    $('#btnPrintBNKCHK').attr('hidden', true);
  }

  $('#bankSelection').modal('show');

});

// modified print cheque

updateBankAmountBalance();

$("#btnPrintBNKCHK").on("click", function () {
  var bank_type = document.getElementById('bank_type').value;
  var doc_no = docno1;
  var col_date = cdate1;
  swal({
    type: "info",
    title: 'Do you wish to continue using bank ' + bank_type + '?',
    text: 'Generate a printable cheque with document no. ' + doc_no,
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancel',
    confirmButtonText: 'Yes'
  }).then(function (result) {
    if (result.value) {
      $.ajax({
        url: 'ajax/checkBankBalance.ajax.php',
        type: 'GET',
        data: { action: 'validate_balance', bank_type: bank_type, doc_no: doc_no, col_date: col_date },
        dataType: 'json',
        success: function (data) {
          if (data.remark === 'allowed') {
            swal({
              type: "success",
              title: "Successfully Printed",
              html: data.message,
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'OK',
              // confirmButtonColor: '#35d630',
              // confirmButtonText: 'QR',
              cancelButtonColor: '#b2d630',
              cancelButtonText: 'QR'
            }).then(function (result) {
              if (result.value) {

                // Create the URL with parameters

                window.open("extensions/tcpdf/pdf/print_bnkchk.php?cdate=" + col_date + "&docno=" + doc_no + "&bank=" + bank_type, '_blank');

                // var pdfUrl = 'extensions/tcpdf/pdf/print_bnkchk.php?cdate=' + encodeURIComponent(col_date) + '&docno=' + encodeURIComponent(doc_no) + '&bank=' + encodeURIComponent(bank_type);

                // var iframe = document.createElement('iframe');
                // iframe.style.display = 'none';
                // iframe.src = pdfUrl;
                // document.body.appendChild(iframe);

                // iframe.onload = function () {
                //   iframe.contentWindow.focus();
                //   iframe.contentWindow.print();
                // };
                document.getElementById('bank_type_option').reset();
                $('#bankSelection').modal('hide');
                $(".updateCheckWriterFileRecords").trigger("click");
                updateBankAmountBalance();
                table.ajax.reload();
                updateDisplayBal(data);
              }
            });
          }
          else {
            swal({
              type: "warning",
              title: bank_type + " MAINTAINING BALANCE IS AT MAXIMUM!",
              html: data.message,
              showConfirmButton: false,
              showCancelButton: true,
              cancelButtonColor: '#d33',
              cancelButtonText: 'OK'
            }).then(function (result) {
              if (result.value) {
                document.getElementById('bank_type_option').reset();
              }
            });
          }

        }

      });
    }
  });
});

function updateDisplayBal(data) {
  var newContent = "(" + data.bnkcd + ") " + data.bnk_name + ":<u style='  color: #2bcb89;font-weight: bold;'> ₱" + data.balance + "</u>";
  $('#' + data.bnkcd).html(newContent);
}


function updateBankAmountBalance() {
  $.ajax({
    url: 'ajax/checkBankBalance.ajax.php',
    type: 'GET',
    data: { action: 'update_balance' },
    dataType: 'json',
    success: function (data) {
      var html = '';
      if (data) {
        for (var key in data) {
          if (data.hasOwnProperty(key)) {
            html += '<label for="inputName" class="col-form-label">' + data[key].bank_name + '(' + data[key].bnkcd + ') : ₱' + data[key].bank_balance + '</label><br>';
          }
        }
      } else {
        html = '<label for="inputName" class="col-form-label">No data available</label>';
      }
      $('#bankBalanceContainer').html(html); // Assuming you have a container to display the data
    }
  });
}


// Re-Print Cheque //
$("#btnRePrintBNKCHK").on("click", function () {
  var bank_type = document.getElementById('bank_type').value;
  var type = "reprint";
  swal({
    type: "info",
    title: 'Do you wish to continue using bank ' + bank_type + '?.',
    text: 'The cheque with document no. ' + docno1 + ' has already been printed.',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancel',
    confirmButtonText: 'Yes'
  }).then(function (result) {
    if (result.value) {
      $.ajax({
        url: 'ajax/checkwriter_processing.ajax.php',
        type: 'GET',
        data: { docno: docno1, type: type, chkamt: chkamt },
        dataType: 'json',
        success: function (data) {
          swal.close();
          if (data.success == true) {
            swal({
              type: "success",
              title: "Successfully Reprinted",
              html: data.message,
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'OK'
            }).then(function (result) {
              if (result.value) {
                window.open("extensions/tcpdf/pdf/print_bnkchk.php?cdate=" + cdate1 + "&docno=" + docno1 + "&bank=" + bank_type, '_blank');
                // var pdfUrl = 'extensions/tcpdf/pdf/print_bnkchk.php?cdate=' + encodeURIComponent(cdate1) + '&docno=' + encodeURIComponent(docno1) + '&bank=' + encodeURIComponent(bank_type);
                // var iframe = document.createElement('iframe');
                // iframe.style.display = 'none';
                // iframe.src = pdfUrl;
                // document.body.appendChild(iframe);

                // iframe.onload = function () {
                //   iframe.contentWindow.focus();
                //   iframe.contentWindow.print();
                // };

                // document.getElementById('bank_type_option').reset();
                // $('#bankSelection').modal('hide');
                // table.ajax.reload();
                // updateDisplayBal(data);
                // $(".updateCheckWriterFileRecords").trigger("click");
              }
            });
          } else {
            swal.close();
            swal({
              type: "warning",
              title: 'Error Printing',
              html: data.message,
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'OK'
            }).then(function (result) {
              if (result.value) {

              }

            });
          }
        },
        error: function () {
          swal.close();
          swal({
            type: "warning",
            title: 'Erro in re-printing the check no. <u> ' + docno1 + '</u>',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'cancel',
            confirmButtonText: 'OK'
          }).then(function (result) {
            if (result.value) {

            }

          });
        }
      });


    }
  });
});



var confirm_action = "";

$('.trigger-confirm-action').click(function () {
  confirm_action = $(this).attr("confirm_action");
});

$('#conf_pass').click(function () {
  var pass = $('#bnk_pass').val();

  if (pass == "ORAETLABORA") {

    if (confirm_action == 'addbal') {
      $('#bnk_pass').val('');
      $('#bank_password').modal('hide');
      $('#bank_bal').modal('show');
    } else if (confirm_action == 'addbnk') {
      $('#bnk_pass').val('');
      $('#bank_password').modal('hide');
      $('#add_bank').modal('show');
    }

  } else {
    swal({
      title: 'The password you entered is incorrect!',
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'cancel',
      confirmButtonText: 'Yes'
    }).then(function (result) {
      if (result.value) {

      }
    })
  }
})

$("#btnPreAddBankBal").on("click", function (event) {
  event.preventDefault(); // Prevent the form from submitting immediately
  var bnk_amount = document.getElementById('bnk_amount').value;

  swal({
    title: 'Do you wish to continue?',
    text: "Adding amount: " + parseFloat(bnk_amount).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + " to the selected bank.",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'cancel',
    confirmButtonText: 'Yes'
  }).then(function (result) {
    if (result.value) {
      $(".btnAddBankBal").trigger("click");
    }
  });
});


$("#btnPreAddBank").on("click", function (event) {
  event.preventDefault(); // Prevent the form from submitting immediately

  var bnkname = document.getElementById('bnk_name').value;
  var bnkcode = document.getElementById('bnk_code1').value;

  swal({
    title: 'Do you wish to continue?',
    text: "Add bank name : " + bnkname + " with bank code : " + bnkcode + ".",
    type: 'question',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'cancel',
    confirmButtonText: 'Yes'
  }).then(function (result) {
    if (result.value) {
      $(".btnAddBank").trigger("click");
    }
  });
});

var table = $('.checkWriterTableLogs').DataTable({
  "ajax": "ajax/checkWriterLogs.ajax.php",
  "deferRender": true,
  "retrieve": true,
  "processing": true,
  "order": [0, 'desc'],
});

$(".checkWriterTableLogs").on("click", "tbody .btnCancel", function () {
  var id = $(this).attr("idCancel");
  var type = "cancel";
  $('#bank_logs').modal('hide');
  $('#cancel_password').modal('show');
  $("#cancel_pass").on("click", function (event) {
    var cnPass = $('#cancel_bnk_pass').val();
    if (cnPass == "ORAETLABORA") {
      $.ajax({
        url: "ajax/checkwriter_processing.ajax.php",
        type: 'GET',
        data: { id: id, type: type },
        dataType: 'json',
        success: function (data) {
          if (data.success == true) {
            swal({
              type: "success",
              title: "Successfully Cancelled",
              html: data.message,
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'OK'
            }).then(function (result) {
              if (result.value) {
                table.ajax.reload();
                $('#bank_logs').modal('show');
                $('#cancel_password').modal('hide');
                $('#cancel_bnk_pass').val("");
                updateDisplayBal(data);
              }
            });
          } else {
            swal.close();
            swal({
              type: "warning",
              title: 'Error Processing',
              html: data.message,
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'OK'
            }).then(function (result) {
              if (result.value) {
                $('#cancel_bnk_pass').val("");
                $('#bank_logs').modal('show');
                $('#cancel_password').modal('hide');
                updateDisplayBal(data);
              }
            });
          }
        },
        error: function () { }
      })
    } else {
      swal({
        title: 'The password you entered is incorrect!',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'cancel',
        confirmButtonText: 'Yes'
      }).then(function (result) {
        if (result.value) { }
      })
    }

  })
  // Listen for the hidden event on the cancel_password modal
  $('#cancel_password').on('hidden.bs.modal', function () {
    // Show the bank_logs modal when cancel_password modal is hidden
    $('#bank_logs').modal('show');
  });

})

$("#bnkSubmit").on("click", function () {
  var bnk_from = $("#bnk_from").val();
  var bnk_to = $("#bnk_to").val();

  alert(bnk_to);
})

// added 07-01-24 //
$(".btnEnableTableWrapper").on("click", function () {
  var table2 = $('.checkWriterTableReport').DataTable();
  table2.clear().draw();
});

$(".generateCheckWriterReport").on("click", function () {
  var bnk_chck_from = document.getElementById('bnkchck_date_from').value;
  var bnk_chck_to = document.getElementById('bnkchck_date_to').value;
  var bnk_chck_bank = document.getElementById('bnkchck_bank').value;

  if (bnk_chck_from != "" && bnk_chck_to != "" && bnk_chck_bank != "") {

    // Display loading screen
    swal({
      title: "Generating",
      text: "Please wait...",
      allowOutsideClick: false,
      allowEscapeKey: false,
      onOpen: () => {
        swal.showLoading();
      }
    });
    var table = $('.checkWriterTableReport').DataTable();
    // Clear the existing data
    table.clear().draw();

    $.ajax({
      url: 'ajax/checkWriterTransactionList.ajax.php',
      type: 'GET',
      data: { bnk_chck_from: bnk_chck_from, bnk_chck_to: bnk_chck_to, bnk_chck_bank: bnk_chck_bank },
      dataType: 'json',
      success: function (data) {
        swal.close();
        console.log(data); // Log the data to see its structure

        if (data.data.length > 0) {
          // Add new data to the table
          table.rows.add(data.data).draw();
        } else {
          // Show a message or handle empty data as needed
          swal({
            type: "warning",
            title: 'No Records Found in Transaction. Date From<u> ' + bnk_chck_from + ' Date To ' + bnk_chck_to + '</u>',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'cancel',
            confirmButtonText: 'OK'
          }).then(function (result) {
            if (result.value) { }
          });
        }
      },
      error: function () {
        swal.close();
        swal({
          type: "warning",
          title: 'No Records Found in Coll. Date From<u> ' + bnk_chck_from + ' Date To ' + bnk_chck_to + '</u>',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'cancel',
          confirmButtonText: 'OK'
        }).then(function (result) {
          if (result.value) { }
        });
      }
    });
  } else {

    swal({
      type: "warning",
      title: 'Oopss!',
      text: 'Please select date range & generate list first!.',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'cancel',
      confirmButtonText: 'OK'
    }).then(function (result) {
      if (result.value) { }
    });
  }
});

// added 07-01-24 //
$("#exportCheckWriterReport").on("click", function () {
  var fdate = document.getElementById('bnkchck_date_from');
  var date_from = fdate.value;

  var tdate = document.getElementById('bnkchck_date_to');
  var date_to = tdate.value;

  var bnk = document.getElementById('bnkchck_bank');
  var bnk_bank = bnk.value;

  if (date_from != "" && date_to != "" && bnk_bank != "") {
    // window.open("email/export_branch_soa_report.php?date_from=" + date_from + "&date_to=" + date_to, '_blank');
    window.open("extensions/tcpdf/pdf/print_bnkchckreport.php?date_from=" + date_from + "&date_to=" + date_to + "&bnk_bank=" + bnk_bank, '_blank');
    // var exportCheckWriterReport = 'extensions/tcpdf/pdf/print_bnkchckreport.php?date_from=' + encodeURIComponent(date_from) + '&date_to=' + encodeURIComponent(date_to) + '&bnk_bank=' + encodeURIComponent(bnk_bank);

    // var iframe = document.createElement('iframe');
    // iframe.style.display = 'none';
    // iframe.src = exportCheckWriterReport;
    // document.body.appendChild(iframe);

    // iframe.onload = function() {
    //     iframe.contentWindow.focus();
    //     iframe.contentWindow.print();
    // };
  } else {

    swal({
      type: "warning",
      title: 'Oopss!',
      text: 'Please select date range & generate list first!.',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'cancel',
      confirmButtonText: 'OK'
    }).then(function (result) {
      if (result.value) { }
    });
  }
});


var liaisonTable = $('.checkWriterLiaisonTable').DataTable({
  ajax: "ajax/liaisonList.ajax.php",
  deferRender: true,
  processing: true,
  autoWidth: false
});

$('#liaison_table').on('shown.bs.modal', function () {
  liaisonTable.columns.adjust();
});

// Edit liaison
$(".checkWriterLiaisonTable").on("click", "tbody .btnEditLiaison", function () {

  var l_id = $(this).attr("l_id");

  $('#liaison_edit .modal-body').empty();

  $.ajax({
    url: 'ajax/editLiaison.ajax.php',
    data: {
      l_id: l_id
    },
    dataType: 'json',
    success: function (data) {

      $.each(data, function (index, item) {
        var card = item.card;
        $('#liaison_edit .modal-body').append(card);
      });
      $('#liaison_edit').modal('show');

    },
    error: function () {
      alert('Error fetching data');
    }
  });

})

$(".checkWriterLiaisonTable").on("click", "tbody .btnDeleteLiaison", function () {
  var l_id = $(this).attr("l_id");

  swal({
    title: 'Do you want to delete this record?',
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'cancel',
    confirmButtonText: 'Yes'
  }).then(function (result) {
    if (result.value) {
      window.location = "index.php?route=checkWriter&l_id=" + l_id;
    }
  })
})


