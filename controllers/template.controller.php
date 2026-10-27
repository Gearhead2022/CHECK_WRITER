<?php

class ControllerTemplate{
	static public function ctrTemplate(){
		include "views/template.php";
	}
	static public function login(){
		include "views/modules/login.php";
		// include "views/modules/fingerprint.php";
	}
}