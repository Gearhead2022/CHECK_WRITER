<?php
require_once "connection.php";

class ModelBackup{
    static public function get_id($backup_id)
            {
                $pdo = (new Connection)->connect();
			    $pdo->beginTransaction();
                $sql = 'SELECT id 
                        FROM backup 
                        WHERE backup_id = :backup_id';
                $statement = $pdo->prepare($sql);

                $statement->bindParam(':backup_id', $backup_id, PDO::PARAM_STR);
                if ($statement->execute()) {
                    $row = $statement->fetch(PDO::FETCH_ASSOC);
                    return $row !== false ? $row['id'] : false;
                }
                return false;
            }


            static public function mdlAddBackupFiles($table1, $data1){ 
                try{
                    $pdo = (new Connection)->connect();
                    $pdo->beginTransaction();
        
                    $stmt = $pdo->prepare("INSERT INTO $table1(user_id, backup_id,  file_name, add_time) VALUES (:user_id, :backup_id, :file_name, :add_time)");
                    $stmt->bindParam(":user_id", $data1["user_id"], PDO::PARAM_STR);
                    $stmt->bindParam(":backup_id", $data1["backup_id"], PDO::PARAM_STR);
                    $stmt->bindParam(":file_name", $data1["file_name"], PDO::PARAM_STR);
                    $stmt->bindParam(":add_time", $data1["add_time"], PDO::PARAM_STR);
                    
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
	static public function mdlAddBackup($table, $data){
		try{
			$pdo = (new Connection)->connect();
			$pdo->beginTransaction();
            $backup_id =  $data["backup_id"];
            $backup_id1= (new ModelBackup)->get_id($backup_id);
            $last_id = $backup_id1 + 1;
            $id_holder = "BU" . str_repeat("0",5-strlen($last_id)).$last_id;   

            if (!$backup_id1) {
                $id_holder = $backup_id;
            }

			date_default_timezone_set('Asia/Manila');
			$wp_date = $data["wp_date"];
			$date_now1 =date('Y-m-d'); 
			if($wp_date == $date_now1){
				$date_now =date('Y-m-d H:i:s');
			}else{
				$date_now = $wp_date ;
			}
			$stmt = $pdo->prepare("INSERT INTO $table(backup_id, user_id, branch_name, date_time, `subject`) VALUES (:backup_id, :user_id, :branch_name, :date_time, :subject)");
			$stmt->bindParam(":backup_id", $id_holder, PDO::PARAM_STR);
			$stmt->bindParam(":user_id", $data["user_id"], PDO::PARAM_STR);
			$stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
            $stmt->bindParam(":date_time", $date_now, PDO::PARAM_STR);
			$stmt->bindParam(":subject", $data["subject"], PDO::PARAM_STR);
			$stmt->execute();
			$pdo->commit();
			return $id_holder;
 
		}catch(PDOException $exception){
            $pdo->rollBack();
            return "error";     
		}
		$stmt->close();
		$stmt = null;
	} 

	static public function mdlDoneBackup($table, $data){
		date_default_timezone_set('Asia/Manila');
		$status = $data["status"];
		if($status == "P-Revised"){
			$result = "R-Received";
		}else{
			$result = "Received";
		}
		$date_done =date('Y-m-d H:i:s');
		$stmt = (new Connection)->connect()->prepare("UPDATE $table Set status =:result, date_done =:date_done WHERE backup_id = :backup_id");
		$stmt ->bindParam(":backup_id", $data["backup_id"], PDO::PARAM_STR);
		$stmt ->bindParam(":date_done", $date_done, PDO::PARAM_STR);
		$stmt ->bindParam(":result", $result, PDO::PARAM_STR);
		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";	
		}
		$stmt -> close();
		$stmt = null;

	}
	
	static public function mdlEditBackup($table, $data){
		$status = $data["status"];
		if($status == "Pending"){
			$result = "Pending";
		}else{
			$result = "P-Revised";
		}
		$stmt = (new Connection)->connect()->prepare("UPDATE $table SET `subject` = :subject, `status` = :result, date_time = :new_date WHERE backup_id = :backup_id");

		$stmt->bindParam(":subject", $data["subject"], PDO::PARAM_STR);	
		$stmt->bindParam(":backup_id", $data["backup_id"], PDO::PARAM_STR);	
		$stmt->bindParam(":new_date", $data["new_date"], PDO::PARAM_STR);	
		$stmt ->bindParam(":result", $result, PDO::PARAM_STR);

		if($stmt->execute()){
			return "ok";
		}else{
			return "error";
		}

		$stmt->close();
		$stmt = null;
	}
    
	static public function mdlShowBackup($user_id){
		$type = $_SESSION['type'];
		if($type == "admin" || $type == "backup_admin"  ){
			$stmt = (new Connection)->connect()->prepare("SELECT * FROM backup ORDER BY id DESC");

		}else{
			$stmt = (new Connection)->connect()->prepare("SELECT * FROM backup WHERE user_id = '$user_id' ORDER BY id DESC");
		}
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}	
	static public function mdlGetAllBranch(){
		
		$stmt = (new Connection)->connect()->prepare("SELECT DISTINCT branch_name FROM `backup` ORDER BY branch_name");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}	
	static public function mdlGetBackup($table, $data){
		
		$stmt = (new Connection)->connect()->prepare("SELECT *  FROM $table WHERE id = '$data'");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}	
	
	static public function mdlCheckDate($date_now){
		$user_id = $_SESSION['user_id'];
		$stmt = (new Connection)->connect()->prepare("SELECT date_time FROM backup WHERE user_id = '$user_id' AND date_time  LIKE '%$date_now%' ORDER BY id");
	
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}	
	static public function mdlShowFilter($filter){
		if($filter == "All"){
			$stmt = (new Connection)->connect()->prepare("SELECT * FROM backup  group by branch_name");
		}else{
			$stmt = (new Connection)->connect()->prepare("SELECT * FROM backup WHERE branch_name = '$filter' group by branch_name");
		}
		
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}	
	static public function mdlShowFilterYear($filterYear, $branch_name){
		if($branch_name == "All"){
			$stmt = (new Connection)->connect()->prepare("SELECT * FROM backup  group by branch_name");
		}else{
			$stmt = (new Connection)->connect()->prepare("SELECT * FROM `backup`  
			WHERE branch_name = '$branch_name' AND date_time  LIKE '%$filterYear%' GROUP BY MONTH(date_time)");
		}
		
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}	
	static public function mdlShowFilterMonth($filterYear, $branch_name, $filterMonth){
		if($branch_name == "All"){
			$stmt = (new Connection)->connect()->prepare("SELECT * FROM backup  group by branch_name");
		}elseif($branch_name != "All" && $filterYear ==""){
			$stmt = (new Connection)->connect()->prepare("SELECT * FROM backup WHERE branch_name = '$branch_name' group by branch_name");
		}
		elseif($branch_name != "All" && $filterYear !="" && $filterMonth =="" ){
			$stmt = (new Connection)->connect()->prepare("SELECT * FROM `backup`  
			WHERE branch_name = '$branch_name' AND date_time  LIKE '%$filterYear%' GROUP BY MONTH(date_time)");
		}elseif($branch_name != "All" || $filterYear !="" || $filterMonth !="" ){
			$stmt = (new Connection)->connect()->prepare("SELECT * FROM `backup`  
			WHERE branch_name = '$branch_name' AND date_time  LIKE '%$filterYear%' AND MONTH(date_time) = '$filterMonth' ORDER BY date_time");
		}
		
		
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}	
	static public function mdlShowFiles($table, $backup_id){
		$stmt = (new Connection)->connect()->prepare("SELECT * FROM $table WHERE backup_id = '$backup_id'");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}
	static public function mdlDeleteImg($table, $data){
		$stmt = (new Connection)->connect()->prepare("DELETE  FROM $table WHERE id =:id");
	
		$stmt -> bindParam(":id", $data, PDO::PARAM_STR);
		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";	
		}
		$stmt -> close();
		$stmt = null;
	}

	static public function mdlDeleteAll($table1, $backup_id){
		$stmt = (new Connection)->connect()->prepare("DELETE  FROM $table1 WHERE backup_id =:backup_id");
	
		$stmt -> bindParam(":backup_id", $backup_id, PDO::PARAM_STR);
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}
	static public function mdlDeleteBackup($table, $data){
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


	static public function mdlCheckBackup($dateSlct){
		
			$stmt = (new Connection)->connect()->prepare("SELECT a.user_id, a.full_name
			FROM accounts a
			LEFT JOIN backup b 
				ON a.user_id = b.user_id AND b.date_time LIKE '$dateSlct%'
			WHERE b.user_id IS NULL AND a.full_name LIKE 'EMB%' OR a.full_name LIKE 'FCH%' OR a.full_name LIKE 'RLC%' OR a.full_name LIKE 'ELC%'
			ORDER BY a.full_name;");

		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}


}