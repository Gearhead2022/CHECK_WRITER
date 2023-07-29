<?php

require_once "connection.php";

class ModelChecklist{

	static public function get_user_id($chk_id)
		{
			$pdo = (new Connection)->connect();
			$pdo->beginTransaction();
			$sql = 'SELECT id 
					FROM checklist 
					WHERE chk_id = :chk_id';
			$statement = $pdo->prepare($sql);

			$statement->bindParam(':chk_id', $chk_id, PDO::PARAM_STR);
			if ($statement->execute()) {
				$row = $statement->fetch(PDO::FETCH_ASSOC);
				return $row !== false ? $row['id'] : false;
			}
			return false;
		}
	static public function mdlAddChecklist($table, $data){

		try{
			
		$pdo = (new Connection)->connect();
		$pdo->beginTransaction();
		$chk_id =  $data["chk_id"];
		$chk_id1= (new ModelChecklist)->get_user_id($chk_id);
		$last_id = $chk_id1 + 1;
		$id_holder = "CK" . str_repeat("0",5-strlen($last_id)).$last_id;   
		if (!$chk_id1) {
			$id_holder = $chk_id;
		}
            $stmt = (new Connection)->connect()->prepare("INSERT INTO $table(chk_id, full_name, chk_date) VALUES (:chk_id, :full_name, :chk_date)");
            $stmt->bindParam(":chk_id", $id_holder, PDO::PARAM_STR);
            $stmt->bindParam(":full_name", $data["full_name"], PDO::PARAM_STR);
            $stmt->bindParam(":chk_date", $data["chk_date"], PDO::PARAM_STR);
            if($stmt->execute()){
                return "ok";
            }
            $stmt->close();
            $stmt = null;
				
			

		}catch(PDOException $exception){
			$pdo->rollBack();
			return "error"; 
		}	

	}
	static public function mdlAddChecklistReport($table, $data){

		try{
			
			$pdo = (new Connection)->connect();
			$pdo->beginTransaction();
		
            $stmt = (new Connection)->connect()->prepare("INSERT INTO $table(chk_id, chk_task, chk_prio, chk_start, chk_end, chk_status,chk_notes)
			 VALUES (:chk_id, :chk_task, :chk_prio, :chk_start, :chk_end, :chk_status, :chk_notes)");
            $stmt->bindParam(":chk_id", $data["chk_id"], PDO::PARAM_STR);
            $stmt->bindParam(":chk_task", $data["chk_task"], PDO::PARAM_STR);
			$stmt->bindParam(":chk_prio", $data["chk_prio"], PDO::PARAM_STR);
            $stmt->bindParam(":chk_start", $data["chk_start"], PDO::PARAM_STR);
			$stmt->bindParam(":chk_end", $data["chk_end"], PDO::PARAM_STR);
            $stmt->bindParam(":chk_status", $data["chk_status"], PDO::PARAM_STR);
			$stmt->bindParam(":chk_notes", $data["chk_notes"], PDO::PARAM_STR);
           
            if($stmt->execute()){
                return "ok";
            }
            $stmt->close();
            $stmt = null;
				
			

		}catch(PDOException $exception){
			$pdo->rollBack();
			return "error"; 
		}	

	}


static public function mdlShowChecklist(){
	$type = $_SESSION['type'];
	$branch_name = $_SESSION['branch_name'];
	if($type == "admin"){
		$stmt = (new Connection)->connect()->prepare("SELECT * FROM checklist  ORDER BY id");
	}else{
		$stmt = (new Connection)->connect()->prepare("SELECT * FROM checklist WHERE full_name = '$branch_name'  ORDER BY id");
	}
	$stmt -> execute();
	return $stmt -> fetchAll();
	$stmt -> close();
	$stmt = null;
}	


static public function mdlShowChecklistID($id){
	
	$stmt = (new Connection)->connect()->prepare("SELECT * FROM checklist WHERE id = '$id' ORDER BY id");

	$stmt -> execute();
	return $stmt -> fetchAll();
	$stmt -> close();
	$stmt = null;
}	

static public function mdlShowChecklistReport($chk_id){
	$stmt = (new Connection)->connect()->prepare("SELECT * FROM checklist_report WHERE chk_id ='$chk_id' ORDER BY id");
	$stmt -> execute();
	return $stmt -> fetchAll();
	$stmt -> close();
	$stmt = null;
}	

static public function mdlShowChecklistReportID($chk_id, $id){
	$stmt = (new Connection)->connect()->prepare("SELECT * FROM checklist_report WHERE chk_id ='$chk_id' AND id = $id ORDER BY id");
	$stmt -> execute();
	return $stmt -> fetchAll();
	$stmt -> close();
	$stmt = null;
}	
static public function mdlDeleteReport($table, $data){
	$stmt = (new Connection)->connect()->prepare("DELETE FROM $table WHERE id = :id");
	$stmt ->bindParam(":id", $data, PDO::PARAM_INT);
	if($stmt -> execute()){
		return "ok";
	}else{
		return "error";	
	}
	$stmt -> close();
	$stmt = null;

}

static public function mdlEditChecklist($table, $data){
	$stmt = (new Connection)->connect()->prepare("UPDATE $table SET `chk_date` = :chk_date WHERE id = :id");
	
	$stmt->bindParam(":id", $data["id"], PDO::PARAM_INT);
	$stmt->bindParam(":chk_date", $data["chk_date"], PDO::PARAM_STR);
	


	if($stmt->execute()){
		return "ok";
	}else{
		return "error";
	}

	$stmt->close();
	$stmt = null;

}	

static public function mdlEditChecklistReport($table, $data){
	$stmt = (new Connection)->connect()->prepare("UPDATE $table SET `chk_task` = :chk_task, `chk_prio` = :chk_prio,
	`chk_start` = :chk_start,`chk_end` = :chk_end, `chk_status` = :chk_status,`chk_notes` = :chk_notes WHERE id = :id");
	
	$stmt->bindParam(":id", $data["id"], PDO::PARAM_INT);
	$stmt->bindParam(":chk_task", $data["chk_task"], PDO::PARAM_STR);
	$stmt->bindParam(":chk_prio", $data["chk_prio"], PDO::PARAM_STR);
	$stmt->bindParam(":chk_start", $data["chk_start"], PDO::PARAM_STR);
	$stmt->bindParam(":chk_end", $data["chk_end"], PDO::PARAM_STR);
	$stmt->bindParam(":chk_status", $data["chk_status"], PDO::PARAM_STR);
	$stmt->bindParam(":chk_notes", $data["chk_notes"], PDO::PARAM_STR);
	


	if($stmt->execute()){
		return "ok";
	}else{
		return "error";
	}

	$stmt->close();
	$stmt = null;


	
}	

static public function mdlDeleteChecklist($table, $data, $chk_id){
	$stmt = (new Connection)->connect()->prepare("DELETE FROM $table WHERE id = :id");
	$stmt ->bindParam(":id", $data, PDO::PARAM_INT);
	if($stmt -> execute()){
		$stmt1 = (new Connection)->connect()->prepare("DELETE FROM checklist_report WHERE chk_id ='$chk_id'");
		if($stmt1 -> execute()){
			return "ok";	
		}else{
			return "error";	
		}
	}else{
		return "error";		
	}
	$stmt -> close();
	$stmt = null;

}



	
}