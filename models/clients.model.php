<?php
require_once "connection.php";
class ModelClients{
	static public function mdlAddClient($table, $data){
		try{
			$pdo = (new Connection)->connect();
			$pdo->beginTransaction();
			$stmt = $pdo->prepare("INSERT INTO $table(id_num, fname, mname, lname, company, blood_type, 
			birth_date, home_address, sss_num, tin_num, phil_num, pagibig_num, date_hired, status, em_fname, em_mname,
			 em_lname, em_phone, em_address, picture) VALUES (:id_num, :fname, :mname, :lname, :company, :blood_type, 
			 :birth_date, :home_address, :sss_num, :tin_num, :phil_num, :pagibig_num, :date_hired, :status, :em_fname, :em_mname, 
			 :em_lname, :em_phone, :em_address, :upload_files)");
			$stmt->bindParam(":id_num", $data["id_num"], PDO::PARAM_INT);
			$stmt->bindParam(":fname", $data["fname"], PDO::PARAM_STR);
			$stmt->bindParam(":mname", $data["mname"], PDO::PARAM_STR);
			$stmt->bindParam(":lname", $data["lname"], PDO::PARAM_STR);
			$stmt->bindParam(":company", $data["company"], PDO::PARAM_STR);
			$stmt->bindParam(":blood_type", $data["blood_type"], PDO::PARAM_STR);
			$stmt->bindParam(":birth_date", $data["birth_date"], PDO::PARAM_STR);
			$stmt->bindParam(":home_address", $data["home_address"], PDO::PARAM_STR);
			$stmt->bindParam(":sss_num", $data["sss_num"], PDO::PARAM_STR);
			$stmt->bindParam(":tin_num", $data["tin_num"], PDO::PARAM_STR);
			$stmt->bindParam(":phil_num", $data["phil_num"], PDO::PARAM_STR);
			$stmt->bindParam(":pagibig_num", $data["pagibig_num"], PDO::PARAM_STR);
			$stmt->bindParam(":date_hired", $data["date_hired"], PDO::PARAM_STR);
			$stmt->bindParam(":status", $data["status"], PDO::PARAM_STR);
			$stmt->bindParam(":em_fname", $data["em_fname"], PDO::PARAM_STR);
			$stmt->bindParam(":em_mname", $data["em_mname"], PDO::PARAM_STR);
			$stmt->bindParam(":em_lname", $data["em_lname"], PDO::PARAM_STR);
			$stmt->bindParam(":em_phone", $data["em_phone"], PDO::PARAM_STR);
			$stmt->bindParam(":em_address", $data["em_address"], PDO::PARAM_STR);
			$stmt->bindParam(":upload_files", $data["upload_files"], PDO::PARAM_STR);
			
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

	static public function mdlShowImg($company, $id_num){
		$stmt = (new Connection)->connect()->prepare("SELECT * FROM files WHERE company = '$company' && id_num = '$id_num'");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
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

	static public function mdlShowClients(){
		$stmt = (new Connection)->connect()->prepare("SELECT * FROM application_form ORDER BY fname");
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
	static public function mdlAddClientImg($table1, $data1){ 
		try{
			$pdo = (new Connection)->connect();
			$pdo->beginTransaction();

			$stmt = $pdo->prepare("INSERT INTO $table1(company, id_num, file_name, image_time) VALUES (:company, :id_num, :file_name, :image_time)");
			$stmt->bindParam(":company", $data1["company"], PDO::PARAM_STR);
			$stmt->bindParam(":id_num", $data1["id_num"], PDO::PARAM_STR);
			$stmt->bindParam(":file_name", $data1["file_name"], PDO::PARAM_STR);
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
	
		

	static public function mdlEditClient($table, $data){
		$stmt = (new Connection)->connect()->prepare("UPDATE $table SET id_num = :id_num, fname = :fname, 
		mname = :mname, lname = :lname, company = :company, blood_type = :blood_type, birth_date = :birth_date, 
		home_address = :home_address, sss_num = :sss_num, tin_num = :tin_num, phil_num = :phil_num, pagibig_num = :pagibig_num,
		date_hired = :date_hired, status =:status, em_fname = :em_fname, em_mname = :em_mname, em_lname = :em_lname, em_phone = :em_phone, em_address = :em_address,
		picture = :upload_files WHERE id = :id");
		
		$stmt->bindParam(":id_num", $data["id_num"], PDO::PARAM_INT);
		$stmt->bindParam(":id", $data["id"], PDO::PARAM_INT);
		$stmt->bindParam(":fname", $data["fname"], PDO::PARAM_STR);
		$stmt->bindParam(":mname", $data["mname"], PDO::PARAM_STR);
		$stmt->bindParam(":lname", $data["lname"], PDO::PARAM_STR);
		$stmt->bindParam(":company", $data["company"], PDO::PARAM_STR);
		$stmt->bindParam(":blood_type", $data["blood_type"], PDO::PARAM_STR);
		$stmt->bindParam(":birth_date", $data["birth_date"], PDO::PARAM_STR);
		$stmt->bindParam(":home_address", $data["home_address"], PDO::PARAM_STR);
		$stmt->bindParam(":sss_num", $data["sss_num"], PDO::PARAM_STR);
		$stmt->bindParam(":tin_num", $data["tin_num"], PDO::PARAM_STR);
		$stmt->bindParam(":phil_num", $data["phil_num"], PDO::PARAM_STR);
		$stmt->bindParam(":pagibig_num", $data["pagibig_num"], PDO::PARAM_STR);
		$stmt->bindParam(":date_hired", $data["date_hired"], PDO::PARAM_STR);
		$stmt->bindParam(":status", $data["status"], PDO::PARAM_STR);
		$stmt->bindParam(":em_fname", $data["em_fname"], PDO::PARAM_STR);
		$stmt->bindParam(":em_mname", $data["em_mname"], PDO::PARAM_STR);
		$stmt->bindParam(":em_lname", $data["em_lname"], PDO::PARAM_STR);
		$stmt->bindParam(":em_phone", $data["em_phone"], PDO::PARAM_STR);
		$stmt->bindParam(":em_address", $data["em_address"], PDO::PARAM_STR);
		$stmt->bindParam(":upload_files", $data["upload_files"], PDO::PARAM_STR);
		

		if($stmt->execute()){
			return "ok";
		}else{
			return "error";
		}

		$stmt->close();
		$stmt = null;

	}	

	static public function mdlDeleteClient($table, $data){
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

	static public function mdlPrint($table, $data){
		$stmt = (new Connection)->connect()->prepare("SELECT * FROM $table WHERE category = :category ORDER by cname");
		$stmt->bindParam(":category", $data, PDO::PARAM_STR);
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
}
static public function mdlDeleteImg($table, $data){
	$stmt = (new Connection)->connect()->prepare("DELETE  FROM $table WHERE file_name = :file_name");
	$stmt -> bindParam(":file_name", $data, PDO::PARAM_STR);
	if($stmt -> execute()){
		return "ok";
	}else{
		return "error";	
	}
	$stmt -> close();
	$stmt = null;
}	
static public function mdlDeleteAll($company, $id_num){
	$stmt = (new Connection)->connect()->prepare("DELETE  FROM files WHERE company = :company AND id_num =:id_num");
	$stmt -> bindParam(":company", $company, PDO::PARAM_STR);
	$stmt -> bindParam(":id_num", $id_num, PDO::PARAM_STR);
	if($stmt -> execute()){
		return "ok";
	}else{
		return "error";	
	}
	$stmt -> close();
	$stmt = null;
}	



}