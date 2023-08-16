<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
  <meta name="description" content=""/>
  <meta name="author" content=""/>
  <title>JGC</title>
  <link rel="icon" href="views/img/JGC.png" type="image/x-icon">
  <link href="views/assets/plugins/fullcalendar/css/fullcalendar.min.css" rel='stylesheet'/>

  <!-- simplebar CSS-->
  <link href="views/assets/plugins/simplebar/css/simplebar.css" rel="stylesheet"/>
  <link href="views/assets/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="views/assets/css/animate.css" rel="stylesheet" type="text/css"/>
  <link href="views/assets/css/icons.css" rel="stylesheet" type="text/css"/>
  <link href="views/assets/css/app-style.css" rel="stylesheet"/>
  <link href="views/assets/css/sidebar-menu.css" rel="stylesheet"/>
  <link href="views/assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet"/>
  <link href="views/assets/css/myowncss.css" rel="stylesheet"/>
  <link href="views/assets/css/index.css" rel="stylesheet"/>
  <link href="views/assets/css/components.min.css" rel="stylesheet" type="text/css">
 
  
  <link href="views/assets/plugins/bootstrap-datatable/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">
  <link href="views/assets/plugins/bootstrap-datatable/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css">

  <link href="views/assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">
  <link href="views/assets/plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.css" rel="stylesheet" type="text/css">
  <link href="views/assets/plugins/inputtags/css/bootstrap-tagsinput.css" rel="stylesheet" />
  <link href="views/assets/plugins/jquery-multi-select/multi-select.css" rel="stylesheet" type="text/css">
  <link href="views/assets/plugins/select2/css/select2.min.css" rel="stylesheet"/>
  <link href="views/assets/plugins/switchery/css/switchery.min.css" rel="stylesheet" />
  <link href="views/assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet"/>
  <script src="views/assets/plugins/sweetalert2/sweetalert2.all.js"></script>
</head>
<?php 
// Array of restriction routes
$wp_user = array('clients','clientedit','clientadd','fch','pspmi','rlc','registrations','blacklist','blacklistedit',
'blacklistadd','accounts','accountedit');

$hr_user = array('registrations','blacklist','blacklistedit',
'blacklistadd','accounts','accountedit','workingpermit','workingpermitedit','workingpermitadd','request','requestedit',
'requestadd','showrequest','showrequests');

$pdr_user = array('clients','clientedit','clientadd','fch','pspmi','rlc','registrations','accounts','accountedit','workingpermit','workingpermitedit','workingpermitadd','request','requestedit',
'requestadd','showrequest','showrequests');



$mode = $_SESSION['mode'];
if($mode=="dark"){?>
  <body class="bg-theme bg-theme9"> <?php
}else{ ?>

   <body class="bg-theme bg-theme7"> 
<?php } ?>

   <?php
    echo '<div id="wrapper">';  
      include "modules/header.php";
      include "modules/sidebar.php"; 
      if(isset($_GET["route"])){
             $user =  $_SESSION['type'];
             $pagenow =$_GET['route'];

            if(in_array( $pagenow, $wp_user )){
              // Now check the current user
              if ( $user == 'wp_user' || $user == 'wp_admin') {
                echo '<script>window.location = "404"</script>';
              }
            }

            if(in_array( $pagenow, $hr_user )){
              // Now check the current user
              if ( $user == 'hr_user' || $user == 'hr_admin') {
                echo '<script>window.location = "404"</script>';
              }
            }

            if(in_array( $pagenow, $pdr_user )){
              // Now check the current user
              if ( $user == 'pdr_user' || $user == 'pdr_admin') {
                echo '<script>window.location = "404"</script>';
              }
            }


        if ($_GET["route"] == 'home' || 
            $_GET["route"] == 'logout' ||
            $_GET["route"] == 'registrations' ||
            $_GET["route"] == 'clients' || 
            $_GET["route"] == 'login' ||        
            $_GET["route"] == 'clientadd' ||
            $_GET["route"] == 'pspmi' ||
            $_GET["route"] == 'fch' ||
            $_GET["route"] == 'rlc' ||
            $_GET["route"] == 'blacklist' || 
            $_GET["route"] == 'blacklistadd' ||
            $_GET["route"] == 'blacklistedit' ||
            $_GET["route"] == 'workingpermitadd' ||
            $_GET["route"] == 'workingpermit' ||
            $_GET["route"] == 'workingpermitedit' ||
            $_GET["route"] == 'showrequest' ||
            $_GET["route"] == 'showrequests' ||
            $_GET["route"] == 'requestadd' ||
            $_GET["route"] == 'request' ||
            $_GET["route"] == 'accounts' ||
            $_GET["route"] == 'accountedit' ||
            $_GET["route"] == 'requestedit' ||
            $_GET["route"] == 'showbackup' ||
            $_GET["route"] == 'backups' ||
            $_GET["route"] == 'backupedit' ||
            $_GET["route"] == 'backupadd' ||
            $_GET["route"] == 'backupfilter' ||
            $_GET["route"] == 'backupreport' ||
            $_GET["route"] == 'download' ||
            $_GET["route"] == 'try' ||
            $_GET["route"] == 'fullypaid' ||
            $_GET["route"] == 'showfullypaid' ||
            $_GET["route"] == 'fullypaidadd' ||
            $_GET["route"] == 'fullypaidedit' ||
            $_GET["route"] == 'fullypaidreport1' ||
            $_GET["route"] == 'fullypaidreport2' ||
            $_GET["route"] == 'fullpaidreport' ||
            $_GET["route"] == 'documentadd' ||
            $_GET["route"] == 'checklist' ||
            $_GET["route"] == 'pastdue' ||
            $_GET["route"] == 'pastdueadd' ||
            $_GET["route"] == 'pastdueedit' ||
            $_GET["route"] == 'pastduetarget' ||
            $_GET["route"] == 'pastdueledger' ||
            $_GET["route"] == 'pastduesummary' ||
            $_GET["route"] == 'pastdueclassreport' ||
            $_GET["route"] == 'showpastdue' ||
            $_GET["route"] == 'pastdueweeklyreport' ||
            $_GET["route"] == 'ledger' ||
            $_GET["route"] == 'operations' ||
            $_GET["route"] == 'operationreport' ||
            $_GET["route"] == 'checklistadd' ||
            $_GET["route"] == 'clientedit'){
          include "modules/".$_GET["route"].".php";
        }else{
           include "modules/404.php";
        }
      }else{
        include "modules/home.php";
      }
    echo '</div>';
  ?>

  <script src="views/assets/js/jquery.min.js"></script>
  <script src="views/assets/js/popper.min.js"></script>
  <script src="views/assets/js/bootstrap.min.js"></script>
  <script src="views/assets/js/sidebar-menu.js"></script>
  <script src="views/assets/js/app-script.js"></script>
  

  <script src="views/assets/js/myownjs.js"></script>
  <script src="views/assets/plugins/apexcharts/apexcharts.js"></script>
  <script src="views/assets/plugins/bootstrap-datatable/js/jquery.dataTables.min.js"></script>
  <script src="views/assets/plugins/bootstrap-datatable/js/dataTables.bootstrap4.min.js"></script>
  <script src="views/assets/plugins/bootstrap-datatable/js/dataTables.buttons.min.js"></script>
  <script src="views/assets/plugins/bootstrap-datatable/js/buttons.bootstrap4.min.js"></script>
  <script src="views/assets/plugins/bootstrap-datatable/js/jszip.min.js"></script>
  <script src="views/assets/plugins/bootstrap-datatable/js/pdfmake.min.js"></script>
  <script src="views/assets/plugins/bootstrap-datatable/js/vfs_fonts.js"></script>
  <script src="views/assets/plugins/bootstrap-datatable/js/buttons.html5.min.js"></script>
  <script src="views/assets/plugins/bootstrap-datatable/js/buttons.print.min.js"></script>
  <script src="views/assets/plugins/bootstrap-datatable/js/buttons.colVis.min.js"></script>


  <script src="views/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

  <script src="views/assets/plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.js"></script>
  <script src="views/assets/plugins/bootstrap-touchspin/js/bootstrap-touchspin-script.js"></script>  
  <script src="views/assets/plugins/bootstrap-switch/bootstrap-switch.min.js"></script>

  <script src="views/assets/plugins/Chart.js/Chart.min.js"></script>
  <script src="views/assets/plugins/Chart.js/Chart.extension.js"></script>
  <script src="views/assets/plugins/inputtags/js/bootstrap-tagsinput.js"></script>
  <script src="views/assets/plugins/jquery.easy-pie-chart/jquery.easypiechart.min.js"></script>

  <script src="views/assets/plugins/jquery-multi-select/jquery.multi-select.js"></script>
  <script src="views/assets/plugins/jquery-multi-select/jquery.quicksearch.js"></script>

  <script src="views/assets/plugins/jquery-knob/excanvas.js"></script>
  <script src="views/assets/plugins/jquery-knob/jquery.knob.js"></script>
  <script src="views/assets/plugins/number/jquery.number.js"></script>

  <script src="views/assets/plugins/select2/js/select2.min.js"></script>
  <script src="views/assets/plugins/simplebar/js/simplebar.js"></script>
  <script src="views/assets/plugins/sparkline-charts/jquery.sparkline.min.js"></script>
  <script src="views/assets/plugins/switchery/js/switchery.min.js"></script>
  <script src="views/assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js"></script>
  <script src="views/assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js"></script>

  <script src="views/js/backup.js"></script>
  <script src="views/js/checklist.js"></script>
  <script src="views/js/clients.js"></script>
  <script src="views/js/account.js"></script>
  <script src="views/js/request.js"></script>
  <script src="views/js/permit.js"></script>
  <script src="views/js/blacklist.js"></script>
  <script src="views/js/rlc.js"></script>
  <script src="views/js/pspmi.js"></script>
  <script src="views/js/fch.js"></script>
  <script src="views/js/index.js"></script>
  <script src="views/js/try.js"></script>
  <script src="views/js/fullypaid.js"></script>
  <script src="views/js/pastdue.js"></script>
  <script src="views/js/operations.js"></script>
  <script src="views/js/script.numeric_key_binding.js"></script>
  <script src="views/js/autologout.js"></script>

  <script>
     $(document).ready(function() {
      //Default data table
       $('#default-datatable').DataTable();


       var table = $('#example').DataTable( {
        lengthChange: false,
        buttons: [ 'copy', 'excel', 'pdf', 'print', 'colvis' ]
      } );
 
     table.buttons().container()
        .appendTo( '#example_wrapper .col-md-6:eq(0)' );
      
      } );
  </script> 

  <script>
      $(function() {
          $(".knob").knob();
      });
  </script> 

  <script>
    $('#default-datepicker').datepicker({
      todayHighlight: true
    });
    $('#autoclose-datepicker').datepicker({
      autoclose: true,
      todayHighlight: true
    });

    $('#inline-datepicker').datepicker({
       todayHighlight: true
    });

    $('#dateragne-picker .input-daterange').datepicker({
     });
  </script>

  <script>
      $(document).ready(function() {
          $('.single-select').select2();
          $('.multiple-select').select2();

          $('#my_multi_select1').multiSelect();
          $('#my_multi_select2').multiSelect({
              selectableOptgroup: true
          });

          $('#my_multi_select3').multiSelect({
              selectableHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
              selectionHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
              afterInit: function (ms) {
                  var that = this,
                      $selectableSearch = that.$selectableUl.prev(),
                      $selectionSearch = that.$selectionUl.prev(),
                      selectableSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selectable:not(.ms-selected)',
                      selectionSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selection.ms-selected';

                  that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
                      .on('keydown', function (e) {
                          if (e.which === 40) {
                              that.$selectableUl.focus();
                              return false;
                          }
                      });

                  that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                      .on('keydown', function (e) {
                          if (e.which == 40) {
                              that.$selectionUl.focus();
                              return false;
                          }
                      });
              },
              afterSelect: function () {
                  this.qs1.cache();
                  this.qs2.cache();
              },
              afterDeselect: function () {
                  this.qs1.cache();
                  this.qs2.cache();
              }
          });

       $('.custom-header').multiSelect({
            selectableHeader: "<div class='custom-header'>Selectable items</div>",
            selectionHeader: "<div class='custom-header'>Selection items</div>",
            selectableFooter: "<div class='custom-header'>Selectable footer</div>",
            selectionFooter: "<div class='custom-header'>Selection footer</div>"
          });

        });
  </script>  

  <!--Switchery Js-->
  <script>
    var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
    $('.js-switch').each(function() {
          new Switchery($(this)[0], $(this).data());
     });
  </script>
  
  <!--Bootstrap Switch Buttons-->
  <script>
    
    $(".bt-switch input[type='checkbox'], .bt-switch input[type='radio']").bootstrapSwitch();
    var radioswitch = function() {
        var bt = function() {
            $(".radio-switch").on("switch-change", function() {
                $(".radio-switch").bootstrapSwitch("toggleRadioState")
            }), $(".radio-switch").on("switch-change", function() {
                $(".radio-switch").bootstrapSwitch("toggleRadioStateAllowUncheck")
            }), $(".radio-switch").on("switch-change", function() {
                $(".radio-switch").bootstrapSwitch("toggleRadioStateAllowUncheck", !1)
            })
        };
        return {
            init: function() {
                bt()
            }
        }
    }();
    $(document).ready(function() {
        radioswitch.init()
    });
  </script>


<!--   Activating this JS file will result to:
    1. Go to top button visible only on home.php
    2. header remain transparent when scrolling page upward - except home.php --> 


  <script src='views/assets/plugins/fullcalendar/js/moment.min.js'></script>
  <script src='views/assets/plugins/fullcalendar/js/fullcalendar.min.js'></script>
  <script src="views/assets/plugins/fullcalendar/js/calendaring.js"></script>  
  <!-- <script src="views/js/calendaring.js"></script>   -->

  <script src="views/assets/js/data-widgets.js"></script>
</body>
</html>