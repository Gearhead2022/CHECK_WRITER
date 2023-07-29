<?php 
require_once "../views/modules/session.php";


$chk =$_POST['chk'];
if($chk == "on"){
    $_SESSION['mode'] = "dark";
}elseif($chk == "off"){
    $_SESSION['mode'] = "light";
}
