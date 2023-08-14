<?php
	
require_once "controllers/template.controller.php";

require_once "controllers/clients.controller.php";
require_once "models/clients.model.php";

require_once "controllers/blacklist.controller.php";
require_once "models/blacklist.model.php";

require_once "controllers/account.controller.php";
require_once "models/account.model.php";

require_once "controllers/fch.controller.php";
require_once "models/fch.model.php";

require_once "controllers/pspmi.controller.php";
require_once "models/pspmi.model.php";

require_once "controllers/rlc.controller.php";
require_once "models/rlc.model.php";

require_once "controllers/permit.controller.php";
require_once "models/permit.model.php";

require_once "controllers/request.controller.php";
require_once "models/request.model.php";

require_once "controllers/backup.controller.php";
require_once "models/backup.model.php";

require_once "controllers/fullypaid.controller.php";
require_once "models/fullypaid.model.php";

require_once "controllers/checklist.controller.php";
require_once "models/checklist.model.php";


require_once "controllers/pastdue.controller.php";
require_once "models/pastdue.model.php";

require_once "controllers/operation.controller.php";
require_once "models/operation.model.php";




require_once "views/modules/session.php";




if(isset($_SESSION['status'])){
    $template = new ControllerTemplate();
    $template -> ctrTemplate();
    
}else{
    $login = new ControllerTemplate();
    $login -> login();
}






