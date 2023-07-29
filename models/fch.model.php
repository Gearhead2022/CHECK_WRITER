<?php
require_once "connection.php";
class ModelFch{  
    static public function mdlShowFch(){
		$stmt = (new Connection)->connect()->prepare("SELECT * FROM fch_form ORDER BY fname");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}	
    static public function mdlDeleteFch($table, $data){
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