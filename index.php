<?php
	
require_once "controllers/template.controller.php";


require_once "controllers/account.controller.php";
require_once "models/account.model.php";


require_once "controllers/checkwriter.controller.php";
require_once "models/checkwriter.model.php";


require_once "views/modules/session.php";


if(isset($_SESSION['status'])){
    $template = new ControllerTemplate();
    $template -> ctrTemplate();
    
}else{
    $login = new ControllerTemplate();
    $login -> login();

}






