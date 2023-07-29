<?php
require_once "connection.php";
class ModelBlacklist{
	static public function mdlAddBlacklist($table, $data){
		try{
			$pdo = (new Connection)->connect();
			$pdo->beginTransaction();
			$stmt = $pdo->prepare("INSERT INTO $table(clientid, first_name, middle_name, last_name, bank, account_number, 
			remarks, status, lending_firm) VALUES (:clientid, :first_name, :middle_name, :last_name, :bank, :account_number, :remarks, :status, :lending_firm)");
			$stmt->bindParam(":clientid", $data["clientid"], PDO::PARAM_STR);
			$stmt->bindParam(":first_name", $data["first_name"], PDO::PARAM_STR);
			$stmt->bindParam(":middle_name", $data["middle_name"], PDO::PARAM_STR);
			$stmt->bindParam(":last_name", $data["last_name"], PDO::PARAM_STR);
			$stmt->bindParam(":bank", $data["bank"], PDO::PARAM_STR);
			$stmt->bindParam(":account_number", $data["account_number"], PDO::PARAM_STR);
			$stmt->bindParam(":remarks", $data["remarks"], PDO::PARAM_STR);
			$stmt->bindParam(":status", $data["status"], PDO::PARAM_STR);
			$stmt->bindParam(":lending_firm", $data["lending_firm"], PDO::PARAM_STR);
			$stmt->execute();
			$pdo->commit();
			return "ok";
 
		}catch(PDOException $exception){
            $pdo->rollBack();
            return "error";     
		}
		$stmt->close();
		$stmt = null;
	} 
	static public function mdlAddBlacklistImg($table1, $data1){
		try{
			$pdo = (new Connection)->connect();
			$pdo->beginTransaction();

			$stmt = $pdo->prepare("INSERT INTO $table1(clientid, image_name, image_time) VALUES (:clientid, :image_name, :image_time)");
			$stmt->bindParam(":clientid", $data1["clientid"], PDO::PARAM_STR);
			$stmt->bindParam(":image_name", $data1["image_name"], PDO::PARAM_STR);
			$stmt->bindParam(":image_time", $data1["image_time"], PDO::PARAM_STR);
			
			$stmt->execute();
			$pdo->commit();
			return "ok";

		}catch(PDOException $exception){
            $pdo->rollBack();
            return "error";     
		}
		$stmt->close();
		$stmt = null;
	}
	
	// static public function mdlAddAnotherClient($table2, $data){

	// 	$stmt = (new Connection)->connect()->prepare("INSERT INTO $table(clientid, cfname, clname, status, address, email, mobile) VALUES (:clientid, :cfname, :clname, :status, :address, :email, :mobile)");

	// 	$stmt->bindParam(":clientid", $data["clientid"], PDO::PARAM_STR);
	// 	$stmt->bindParam(":cfname", $data["cfname"], PDO::PARAM_STR);
	// 	$stmt->bindParam(":clname", $data["clname"], PDO::PARAM_STR);
	// 	$stmt->bindParam(":status", $data["status"], PDO::PARAM_INT);
	// 	$stmt->bindParam(":address", $data["address"], PDO::PARAM_STR);
	// 	$stmt->bindParam(":email", $data["email"], PDO::PARAM_STR);
	// 	$stmt->bindParam(":mobile", $data["mobile"], PDO::PARAM_STR);

	// 	if($stmt->execute()){
	// 		return "ok";
	// 	}else{
	// 		return "error";
	// 	}
	// 	$stmt->close();
	// 	$stmt = null;

	// }

	static public function mdlShowBlacklist(){
		$stmt = (new Connection)->connect()->prepare("SELECT * FROM clients ORDER BY last_name");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}	
	static public function mdlShowImg($clientid){
		$stmt = (new Connection)->connect()->prepare("SELECT * FROM images WHERE clientid = '$clientid'");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}	


	
	static public function mdlShowLendingFirm(){
		$stmt = (new Connection)->connect()->prepare("SELECT * FROM lending_firm ORDER BY branches");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}	
	
	

	static public function mdlChangeProfile($table, $data){
		$stmt = (new Connection)->connect()->prepare("UPDATE $table SET  upload_files = :upload_files WHERE id = :id");
		$stmt->bindParam(":id", $data["id"], PDO::PARAM_INT);
		$stmt->bindParam(":upload_files", $data["image_name"], PDO::PARAM_STR);
		

		if($stmt->execute()){
			return "ok";
		}else{
			return "error";
		}

		$stmt->close();
		$stmt = null;

	}	

	static public function mdlEditBlacklist($table, $data){
		$stmt = (new Connection)->connect()->prepare("UPDATE $table SET first_name = :first_name, middle_name = :middle_name, 
		last_name = :last_name, bank = :bank, account_number = :account_number, remarks = :remarks, status = :status, lending_firm = :lending_firm WHERE id = :id");
		
		$stmt->bindParam(":id", $data["id"], PDO::PARAM_INT);
		$stmt->bindParam(":first_name", $data["first_name"], PDO::PARAM_STR);
		$stmt->bindParam(":middle_name", $data["middle_name"], PDO::PARAM_STR);
		$stmt->bindParam(":last_name", $data["last_name"], PDO::PARAM_STR);
		$stmt->bindParam(":bank", $data["bank"], PDO::PARAM_STR);
		$stmt->bindParam(":account_number", $data["account_number"], PDO::PARAM_STR);
		$stmt->bindParam(":remarks", $data["remarks"], PDO::PARAM_STR);
		$stmt->bindParam(":status", $data["status"], PDO::PARAM_STR);
		$stmt->bindParam(":lending_firm", $data["lending_firm"], PDO::PARAM_STR);
	

		if($stmt->execute()){
			return "ok";
		}else{
			return "error";
		}

		$stmt->close();
		$stmt = null;

	}	

	static public function mdlDeleteBlacklist($table, $data){
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
	static public function mdlDeleteImg($table, $data){
		$stmt = (new Connection)->connect()->prepare("DELETE  FROM $table WHERE image_name = :image_name");
		$stmt -> bindParam(":image_name", $data, PDO::PARAM_STR);
		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";	
		}
		$stmt -> close();
		$stmt = null;
	}	
	static public function mdlDeleteAll($table1, $clientid){
		$stmt = (new Connection)->connect()->prepare("DELETE  FROM $table1 WHERE clientid = :clientid");
		$stmt -> bindParam(":clientid", $clientid, PDO::PARAM_STR);
		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";	
		}
		$stmt -> close();
		$stmt = null;
	}	

	static public function mdlPrint($table, $data){
		$stmt = (new Connection)->connect()->prepare("SELECT * FROM $table WHERE category = :category ORDER by cname");
		$stmt->bindParam(":category", $data, PDO::PARAM_STR);
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
}

}