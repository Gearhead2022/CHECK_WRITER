<?php
require_once "connection.php";
class ModelRlc{  
    static public function mdlShowRlc(){
		$stmt = (new Connection)->connect()->prepare("SELECT * FROM rlc_form ORDER BY fname");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}	

}