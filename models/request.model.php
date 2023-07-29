<?php
require_once "connection.php";

class ModelRequest{
    static public function get_id($ref_id)
            {
                $pdo = (new Connection)->connect();
			    $pdo->beginTransaction();
                $sql = 'SELECT id 
                        FROM request_forms 
                        WHERE ref_id = :ref_id';
                $statement = $pdo->prepare($sql);

                $statement->bindParam(':ref_id', $ref_id, PDO::PARAM_STR);
                if ($statement->execute()) {
                    $row = $statement->fetch(PDO::FETCH_ASSOC);
                    return $row !== false ? $row['id'] : false;
                }
                return false;
            }
	static public function mdlAddRequest($table, $data){
		try{
			$pdo = (new Connection)->connect();
			$pdo->beginTransaction();

            $ref_id =  $data["ref_id"];
            $ref_id1= (new ModelRequest)->get_id($ref_id);
            $last_id = $ref_id1 + 1;
            $id_holder = "RI" . str_repeat("0",5-strlen($last_id)).$last_id;   
            if (!$ref_id1) {
                $id_holder = $ref_id;
            }
			date_default_timezone_set('Asia/Manila');
			$date_now =date("F d Y h:i:sa");

			$stmt = $pdo->prepare("INSERT INTO $table(ref_id, user_id, `to`, `address`,req_by, branch, `date`, `subject`, 
			subject_body, chk_by, chk_by1, chk_by2, rec_app, app_by) VALUES (:ref_id, :user_id, :to, :address, :req_by, :branch, :date, :subject, :subject_body, :chk_by, :chk_by1, :chk_by2, :rec_app, :app_by)");
			$stmt->bindParam(":ref_id", $id_holder, PDO::PARAM_STR);
			$stmt->bindParam(":user_id", $data["user_id"], PDO::PARAM_STR);
			$stmt->bindParam(":to", $data["to"], PDO::PARAM_STR);
			$stmt->bindParam(":address", $data["address"], PDO::PARAM_STR);
            $stmt->bindParam(":req_by", $data["req_by"], PDO::PARAM_STR);
			$stmt->bindParam(":branch", $data["branch"], PDO::PARAM_STR);
            $stmt->bindParam(":date", $date_now, PDO::PARAM_STR);
			$stmt->bindParam(":subject", $data["subject"], PDO::PARAM_STR);
			$stmt->bindParam(":subject_body", $data["subject_body"], PDO::PARAM_STR);
			$stmt->bindParam(":chk_by", $data["chk_by"], PDO::PARAM_STR);
			$stmt->bindParam(":chk_by1", $data["chk_by1"], PDO::PARAM_STR);
			$stmt->bindParam(":chk_by2", $data["chk_by2"], PDO::PARAM_STR);
            $stmt->bindParam(":rec_app", $data["rec_app"], PDO::PARAM_STR);
			$stmt->bindParam(":app_by", $data["app_by"], PDO::PARAM_STR);
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
    static public function mdlShowRequest($user_id){
		$stmt = (new Connection)->connect()->prepare("SELECT * FROM request_forms WHERE user_id = '$user_id' ORDER BY id DESC");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}	
	static public function mdlShowRequestAll(){
		$stmt = (new Connection)->connect()->prepare("SELECT * FROM request_forms ORDER BY id DESC");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}	
	
	
	
	static public function mdlEditRequest($table, $data){
		
		$stmt = (new Connection)->connect()->prepare("UPDATE $table SET ref_id = :ref_id, `to` = :to, 
		 `address` = :address, req_by = :req_by, branch = :branch,
         `subject` = :subject, subject_body = :subject_body,  chk_by = :chk_by, chk_by1 = :chk_by1,
         chk_by2 = :chk_by2, rec_app = :rec_app, app_by = :app_by WHERE id = :id");

		 $stmt->bindParam(":id", $data["id"], PDO::PARAM_INT);
        $stmt->bindParam(":ref_id", $data["ref_id"], PDO::PARAM_STR);
        $stmt->bindParam(":to", $data["to"], PDO::PARAM_STR);
        $stmt->bindParam(":address", $data["address"], PDO::PARAM_STR);
        $stmt->bindParam(":req_by", $data["req_by"], PDO::PARAM_STR);
        $stmt->bindParam(":branch", $data["branch"], PDO::PARAM_STR);
        $stmt->bindParam(":subject", $data["subject"], PDO::PARAM_STR);
        $stmt->bindParam(":subject_body", $data["subject_body"], PDO::PARAM_STR);
        $stmt->bindParam(":chk_by", $data["chk_by"], PDO::PARAM_STR);
        $stmt->bindParam(":chk_by1", $data["chk_by1"], PDO::PARAM_STR);
        $stmt->bindParam(":chk_by2", $data["chk_by2"], PDO::PARAM_STR);
        $stmt->bindParam(":rec_app", $data["rec_app"], PDO::PARAM_STR);
        $stmt->bindParam(":app_by", $data["app_by"], PDO::PARAM_STR);

		if($stmt->execute()){
			return "ok";
		}else{
			return "error";
		}

		$stmt->close();
		$stmt = null;

	}	
	static public function mdlDeleteRequest($table, $data){
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

	static public function mdlDone($table, $data){
		date_default_timezone_set('Asia/Manila');
		$date_done =date("F d Y h:i:sa");
		$stmt = (new Connection)->connect()->prepare("UPDATE $table Set status ='Done', date_done =:date_done WHERE id = :id");
		$stmt ->bindParam(":id", $data, PDO::PARAM_INT);
		$stmt ->bindParam(":date_done", $date_done, PDO::PARAM_STR);
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
}