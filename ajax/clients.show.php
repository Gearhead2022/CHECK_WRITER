<?php
require_once "../models/connection.php";
require_once "../controllers/clients.controller.php";
require_once "../models/clients.model.php";

$idClient = $_POST['idClient'];
$type = $_POST['type'];
if($type == "EMB"){
    $clients = (new Connection)->connect()->query("SELECT * FROM application_form WHERE id = $idClient")->fetch(PDO::FETCH_ASSOC);

}elseif($type == "FCH"){
    $clients = (new Connection)->connect()->query("SELECT * FROM fch_form WHERE id = $idClient")->fetch(PDO::FETCH_ASSOC);

}elseif($type == "PSPMI"){
    $clients = (new Connection)->connect()->query("SELECT * FROM pspmi_form WHERE id = $idClient")->fetch(PDO::FETCH_ASSOC);

}elseif($type == "RLC"){
    $clients = (new Connection)->connect()->query("SELECT * FROM rlc_form WHERE id = $idClient")->fetch(PDO::FETCH_ASSOC);

}


$id_num = $clients['id_num'];
$fname = $clients['fname']; 
$mname = $clients['mname'];
$lname = $clients['lname'];
$company = $clients['company'];
$blood_type = $clients['blood_type'];
$birth_date = $clients['birth_date'];
$home_address = $clients['home_address'];
$sss_num = $clients['sss_num'];
$tin_num = $clients['tin_num'];
$phil_num = $clients['phil_num'];
$pagibig_num = $clients['pagibig_num'];
$date_hired = $clients['date_hired'];
$em_fname = $clients['em_fname'];
$em_mname = $clients['em_mname'];
$em_lname = $clients['em_lname'];
$em_phone = $clients['em_phone'];
$em_address = $clients['em_address'];
$picture = $clients['picture'];
$status = $clients['status'];
$employee_name = "$fname $mname $lname";



$img_name = "";
if($picture==""){
    $img_name ="profile.png";
}else{
    $img_name ="$picture";
}
$b_date = date('F d Y', strtotime($birth_date));
$d_date = date('F d Y', strtotime($date_hired));

$attch = (new ControllerClients)->ctrShowImg($company, $id_num);



echo '<div class="row"><div class="col-sm-12"><img src="views/files/'.$img_name.'" 
style="width: 15%;height: 116px;"><a href="extensions/tcpdf/pdf/print_application.php?company='.$company.'&id_num='.$id_num.'" target="_blank"><button type="button"  class="btn btn-secondary ml-5">PRINT</button></a></div></div>
<div class="row mt-2"><div class="col-sm-3"><p>NAME</p></div><div class="col-sm-1"><p>:</p></div>
<div class="col-sm-7"><p>'.$fname.' '.$mname.' '.$lname.'</p></div></div>
<div class="row"><div class="col-sm-3"><p>ID NO.</p></div><div class="col-sm-1"><p>:</p></div>
<div class="col-sm-7"><p>'.$id_num.'</p></div></div>
<div class="row"><div class="col-sm-3"><p>BLOOD TYPE</p></div><div class="col-sm-1"><p>:</p></div>
<div class="col-sm-7"><p>'.$blood_type.'</p></div></div>
<div class="row"><div class="col-sm-3"><p>DATE OF BIRTH</p></div><div class="col-sm-1"><p>:</p></div>
<div class="col-sm-7"><p>'.$b_date.'</p></div></div>
<div class="row"><div class="col-sm-3"><p>HOME ADDRESS</p></div><div class="col-sm-1"><p>:</p></div>
<div class="col-sm-7"><p>'.$home_address.'</p></div></div>
<div class="row"><div class="col-sm-3"><p>SSS NO.</p></div><div class="col-sm-1"><p>:</p></div>
<div class="col-sm-7"><p>'.$sss_num.'</p></div></div>
<div class="row"><div class="col-sm-3"><p>TIN NO.</p></div><div class="col-sm-1"><p>:</p></div>
<div class="col-sm-7"><p>'.$tin_num.'</p></div></div>
<div class="row"><div class="col-sm-3"><p>PHILHEALTH NO.</p></div><div class="col-sm-1"><p>:</p></div>
<div class="col-sm-7"><p>'.$phil_num.'</p></div></div>
<div class="row"><div class="col-sm-3"><p>PAGIBIG NO.</p></div><div class="col-sm-1"><p>:</p></div>
<div class="col-sm-7"><p>'.$pagibig_num.'</p></div></div>
<div class="row"><div class="col-sm-3"><p>DATE HIRED</p></div><div class="col-sm-1"><p>:</p></div>
<div class="col-sm-7"><p>'.$d_date.'</p></div></div>
<div class="row"><div class="col-sm-3"><p>STATUS</p></div><div class="col-sm-1"><p>:</p></div>
<div class="col-sm-7"><p>'.$status.'</p></div></div>
<div class="row"><div class="col-sm-12"><h6>IN CASE OF EMERGENCY PLEASE NOTIFY:</h6></div></div>
<div class="row"><div class="col-sm-3"><p>NAME</p></div><div class="col-sm-1"><p>:</p></div>
<div class="col-sm-7"><p>'.$em_fname.' '.$em_mname.' '.$em_lname.'</p></div></div>
<div class="row"><div class="col-sm-3"><p>TEL. NO./CP. NO.</p></div><div class="col-sm-1"><p>:</p></div>
<div class="col-sm-7"><p>'.$em_phone.'</p></div></div>
<div class="row"><div class="col-sm-3"><p>ADDRESS</p></div><div class="col-sm-1"><p>:</p></div>
<div class="col-sm-7"><p>'.$em_address.'</p></div></div>
<div class="row"><div class="col-sm-12"><h6>Images</h6></div></div>
    <div class="row mt-2">';    foreach ($attch as $key => $value) {
                            $attch_name = $value["file_name"];
    echo' <div class="col-sm-1 mr-4" style="    margin-left: 11px;"><a class="pop"><img src="views/files/attachments/'.$attch_name.'" 
    style="width: 95px; height: 95px;  background-color: white;"></a></div>'; } echo' </div>';

    echo '<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" id="img_modal" style="width: 600px; background-color: white; margin-left: -34px;">              
      <div class="modal-body">
      	<button type="button" class="close" style="color: black; font-weight: bold; " id="x_modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <img src="" class="imagepreview" style="width: 100%; height: 450px;" >
      </div>
    </div>
  </div>
</div>';
echo'<div class="row">
        <div class="col-md-4">
            <button type="button" class="btn btn-light" company="'.$company.'" id_num="'.$id_num.'" employee_name="'.$employee_name.'" id="btnDocu"><i class="fa fa-file"></i> DOCUMENTS</button>
        </div>
</div>';
    echo"<script>
     $('.pop').click(function(){
        $('.imagepreview').attr('src', $(this).find('img').attr('src'));
        $('#imagemodal').modal('show');   
        })

        $('.close').click(function(){
        
            $('#imagemodal').modal('hide');   
            })
            function showDiv() {
                document.getElementById('actionDiv').style.display = 'block';
             }

             var readURL = function(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
              
                    reader.onload = function (e) {
                        $('.profile-pic').attr('src', e.target.result);
                    }
              
                    reader.readAsDataURL(input.files[0]);
                }
              }
              $('#btnDocu').on('click', function(){
                var company = $(this).attr('company');
                var id_num = $(this).attr('id_num');
                var employee_name = $(this).attr('employee_name');
                window.location = 'index.php?route=documentadd&company='+company+'&id_num='+id_num+'&employee_name='+employee_name;
              })
        
        </script>";