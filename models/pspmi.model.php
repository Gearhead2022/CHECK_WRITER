<?php
require_once "connection.php";
class ModelPspmi{  
    static public function mdlShowPspmi(){
		$stmt = (new Connection)->connect()->prepare("SELECT * FROM pspmi_form ORDER BY fname");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

    static public function mdlDeletePspmi($table, $data){
		$stmt = (new Connection)->connect()->prepare("DELETE FROM $table WHERE id = :id");
		$stmt -> bindParam(":id", $data, PDO::PARAM_INT);
		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";	
		}
		$stmt -> close();
		$stmt = null;
	}	

}