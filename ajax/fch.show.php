<?php
require_once "../models/connection.php";
$idClient = $_POST['idClient'];

$clients = (new Connection)->connect()->query("SELECT * FROM application_form WHERE id = $idClient")->fetch(PDO::FETCH_ASSOC);

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
$img_name = "";
if($picture==""){
    $img_name ="profile.png";
}else{
    $img_name ="$picture";
}
$b_date = date('F d Y', strtotime($birth_date));
$d_date = date('F d Y', strtotime($date_hired));

echo '<div class="row"><div class="col-sm-12"><img src="views/files/'.$img_name.'" 
style="width: 15%;height: 116px;"></div></div>
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
<div class="row"><div class="col-sm-12"><h6>IN CASE OF EMERGENCY PLEASE NOTIFY:</h6></div></div>
<div class="row"><div class="col-sm-3"><p>NAME</p></div><div class="col-sm-1"><p>:</p></div>
<div class="col-sm-7"><p>'.$em_fname.' '.$em_mname.' '.$em_lname.'</p></div></div>
<div class="row"><div class="col-sm-3"><p>TEL. NO./CP. NO.</p></div><div class="col-sm-1"><p>:</p></div>
<div class="col-sm-7"><p>'.$em_phone.'</p></div></div>
<div class="row"><div class="col-sm-3"><p>ADDRESS</p></div><div class="col-sm-1"><p>:</p></div>
<div class="col-sm-7"><p>'.$em_address.'</p></div></div>';