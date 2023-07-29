<?php
require_once "connection.php";

class ModelPermit{
    static public function get_id($ref_id)
            {
                $pdo = (new Connection)->connect();
			    $pdo->beginTransaction();
                $sql = 'SELECT id 
                        FROM working_permit 
                        WHERE ref_id = :ref_id';
                $statement = $pdo->prepare($sql);

                $statement->bindParam(':ref_id', $ref_id, PDO::PARAM_STR);
                if ($statement->execute()) {
                    $row = $statement->fetch(PDO::FETCH_ASSOC);
                    return $row !== false ? $row['id'] : false;
                }
                return false;
            }
	static public function mdlAddPermit($table, $data){
		try{
			$pdo = (new Connection)->connect();
			$pdo->beginTransaction();
            $ref_id =  $data["ref_id"];
            $ref_id1= (new ModelPermit)->get_id($ref_id);
            $last_id = $ref_id1 + 1;
            $id_holder = "WP" . str_repeat("0",5-strlen($last_id)).$last_id;   
            if (!$ref_id1) {
                $id_holder = $ref_id;
            }
			date_default_timezone_set('Asia/Manila');
			$date_now =date("F d Y h:i:sa");
			$stmt = $pdo->prepare("INSERT INTO $table(ref_id, user_id, wp_to, wp_from, wp_date, wp_req_for, branch, 
			wp_req_by, wp_chk_by, wp_app_by, wp_app_by1) VALUES (:ref_id, :user_id, :wp_to, :wp_from, :wp_date, :wp_req_for, :branch, :wp_req_by, :wp_chk_by, :wp_app_by, :wp_app_by1)");
			$stmt->bindParam(":ref_id", $id_holder, PDO::PARAM_STR);
			$stmt->bindParam(":user_id", $data["user_id"], PDO::PARAM_STR);
			$stmt->bindParam(":wp_to", $data["wp_to"], PDO::PARAM_STR);
			$stmt->bindParam(":wp_from", $data["wp_from"], PDO::PARAM_STR);
            $stmt->bindParam(":wp_date", $date_now, PDO::PARAM_STR);
			$stmt->bindParam(":wp_req_for", $data["wp_req_for"], PDO::PARAM_STR);
			$stmt->bindParam(":branch", $data["branch"], PDO::PARAM_STR);
			$stmt->bindParam(":wp_req_by", $data["wp_req_by"], PDO::PARAM_STR);
			$stmt->bindParam(":wp_chk_by", $data["wp_chk_by"], PDO::PARAM_STR);
			$stmt->bindParam(":wp_app_by", $data["wp_app_by"], PDO::PARAM_STR);
			$stmt->bindParam(":wp_app_by1", $data["wp_app_by1"], PDO::PARAM_STR);
		
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
    static public function mdlShowPermit($user_id){
		$stmt = (new Connection)->connect()->prepare("SELECT * FROM working_permit WHERE user_id = '$user_id' ORDER BY `status` ASC");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}	
	static public function mdlShowPermitAdmin(){
		$stmt = (new Connection)->connect()->prepare("SELECT * FROM working_permit");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}	
	static public function mdlShowFolder($id_num){
		$stmt = (new Connection)->connect()->prepare("SELECT * FROM employee_folder WHERE id_num  = '$id_num'");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}	

	static public function mdlGetFolder($folderid){
		$stmt = (new Connection)->connect()->prepare("SELECT * FROM employee_folder WHERE folderid  = '$folderid'");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}	


	static public function mdlGetFiles($folderid){
		$stmt = (new Connection)->connect()->prepare("SELECT * FROM employee_files WHERE folderid  = '$folderid'");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}	

	
	


	
	
	static public function mdlEditPermit($table, $data){
		
		$stmt = (new Connection)->connect()->prepare("UPDATE $table SET wp_to = :wp_to, wp_from = :wp_from, 
		 wp_req_for = :wp_req_for, branch = :branch, wp_req_by = :wp_req_by, wp_chk_by = :wp_chk_by, 
		wp_app_by = :wp_app_by, wp_app_by1 = :wp_app_by1, wp_remarks = :wp_remarks WHERE id = :id");
		
		$stmt->bindParam(":id", $data["id"], PDO::PARAM_INT);
		$stmt->bindParam(":wp_to", $data["wp_to"], PDO::PARAM_STR);	
		$stmt->bindParam(":wp_from", $data["wp_from"], PDO::PARAM_STR);
	
		$stmt->bindParam(":wp_req_for", $data["wp_req_for"], PDO::PARAM_STR);
		$stmt->bindParam(":branch", $data["branch"], PDO::PARAM_STR);
		$stmt->bindParam(":wp_req_by", $data["wp_req_by"], PDO::PARAM_STR);
		$stmt->bindParam(":wp_chk_by", $data["wp_chk_by"], PDO::PARAM_STR);
		$stmt->bindParam(":wp_app_by", $data["wp_app_by"], PDO::PARAM_STR);
		$stmt->bindParam(":wp_app_by1", $data["wp_app_by1"], PDO::PARAM_STR);
		$stmt->bindParam(":wp_remarks", $data["wp_remarks"], PDO::PARAM_STR);
		
		

		if($stmt->execute()){
			return "ok";
		}else{
			return "error";
		}

		$stmt->close();
		$stmt = null;

	}	
	static public function mdlDeletePermit($table, $data){
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

	static public function mdlDone($table, $data, $wp_remarks){
		date_default_timezone_set('Asia/Manila');
		$date_done =date("F d Y h:i:sa");
		$stmt = (new Connection)->connect()->prepare("UPDATE $table Set status ='Done', date_done =:date_done, wp_remarks = :wp_remarks WHERE id = :id");
		$stmt ->bindParam(":id", $data, PDO::PARAM_INT);
		$stmt ->bindParam(":date_done", $date_done, PDO::PARAM_STR);
		$stmt ->bindParam(":wp_remarks", $wp_remarks, PDO::PARAM_STR);
		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";	
		}
		$stmt -> close();
		$stmt = null;

	}
	static public function mdlApprove($table, $data, $username){
		if($username == "CGN"){
			$stmt = (new Connection)->connect()->prepare("UPDATE $table Set status ='P-Approved', app ='1' WHERE id = :id");
		}else{
			$stmt = (new Connection)->connect()->prepare("UPDATE $table Set status ='P-Approved', app1 ='1' WHERE id = :id");
		}
		$stmt ->bindParam(":id", $data, PDO::PARAM_INT);
		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";	
		}
		$stmt -> close();
		$stmt = null;
	}
	static public function mdlCheck($table, $data){

		$stmt = (new Connection)->connect()->prepare("UPDATE $table Set chk ='Checked' WHERE id = :id");
		$stmt ->bindParam(":id", $data, PDO::PARAM_INT);
		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";	
		}
		$stmt -> close();
		$stmt = null;
	}
	static public function mdlAddPermitImg($table1, $data1){ 
		try{
			$pdo = (new Connection)->connect();
			$pdo->beginTransaction();

			$stmt = $pdo->prepare("INSERT INTO $table1(ref_id,  file_name, image_time) VALUES (:ref_id, :file_name, :image_time)");
			$stmt->bindParam(":ref_id", $data1["ref_id"], PDO::PARAM_STR);
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

	static public function mdlShowImg($table, $ref_id){
		$stmt = (new Connection)->connect()->prepare("SELECT * FROM $table WHERE ref_id = '$ref_id'");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

	static public function mdlDeleteAll($table1, $ref_id){
		$stmt = (new Connection)->connect()->prepare("DELETE  FROM $table1 WHERE ref_id =:ref_id");
	
		$stmt -> bindParam(":ref_id", $ref_id, PDO::PARAM_STR);
		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";	
		}
		$stmt -> close();
		$stmt = null;
	}

	static public function mdlDeleteFolder($table, $folder_id,$folderid){
		$stmt = (new Connection)->connect()->prepare("DELETE  FROM $table WHERE id =:folder_id");
	
		$stmt -> bindParam(":folder_id", $folder_id, PDO::PARAM_STR);
		if($stmt -> execute()){
			$stmt1 = (new Connection)->connect()->prepare("DELETE  FROM employee_files WHERE folderid =:folderid");
	
			$stmt1 -> bindParam(":folderid", $folderid, PDO::PARAM_STR);
			$stmt1 ->execute();
			return "ok";
		}else{
			return "error";	
		}
		$stmt -> close();
		$stmt = null;
	}

	static public function mdlAddFolder($table, $data){ 
		try{
			$pdo = (new Connection)->connect();
			$pdo->beginTransaction();

			$stmt = $pdo->prepare("INSERT INTO $table(folderid,  id_num, folder_name, employee_name, company) VALUES (:folderid, :id_num, :folder_name, :employee_name, :company)");
			$stmt->bindParam(":folderid", $data["folderid"], PDO::PARAM_STR);
			$stmt->bindParam(":id_num", $data["id_num"], PDO::PARAM_STR);
			$stmt->bindParam(":folder_name", $data["folder_name"], PDO::PARAM_STR);
			$stmt->bindParam(":employee_name", $data["employee_name"], PDO::PARAM_STR);
			$stmt->bindParam(":company", $data["company"], PDO::PARAM_STR);
			
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

	static public function mdlAddImg($table1, $data1){
		try{
			$pdo = (new Connection)->connect();
			$pdo->beginTransaction();

			$stmt = $pdo->prepare("INSERT INTO $table1(folderid, file_name) VALUES (:folderid, :image_name)");
			$stmt->bindParam(":folderid", $data1["folderid"], PDO::PARAM_STR);
			$stmt->bindParam(":image_name", $data1["image_name"], PDO::PARAM_STR);
		
			
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

	static public function mdlEditFolder($table, $data){
		
		$stmt = (new Connection)->connect()->prepare("UPDATE $table SET folder_name = :folder_name WHERE id = :id");
		
		$stmt->bindParam(":id", $data["id"], PDO::PARAM_INT);
		$stmt->bindParam(":folder_name", $data["folder_name"], PDO::PARAM_STR);
		

		if($stmt->execute()){
			return "ok";
		}else{
			return "error";
		}

		$stmt->close();
		$stmt = null;

	}
}