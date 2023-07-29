<?php
require_once "connection.php";

class ModelFullyPaid{
    static public function mdlShowFullyPaid($user_id){
		$type = $_SESSION['type'];
		if($type == "admin" || $type == "backup_admin"  ){
			$stmt = (new Connection)->connect()->prepare("SELECT * FROM fully_paid WHERE status = 'F' ");

		}else{
			$stmt = (new Connection)->connect()->prepare("SELECT * FROM fully_paid WHERE user_id = '$user_id' AND status = 'F'");
		}
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

	static public function mdlShowFilterReport($table, $startDateFormatted, $dateTotDateFormatted, $selectedValue){
		$branch_name = $_SESSION['branch_name'];
		$type = $_SESSION['type'];
		if($type == "admin"){
			if($selectedValue ==""){
				$stmt = (new Connection)->connect()->prepare("SELECT * FROM $table WHERE out_date >= $startDateFormatted AND out_date <= $dateTotDateFormatted AND status = 'F' ORDER BY out_date");
			}else{
				$stmt = (new Connection)->connect()->prepare("SELECT * FROM $table WHERE out_date >= $startDateFormatted AND out_date <= $dateTotDateFormatted AND atm_status = '$selectedValue' AND status = 'F' ORDER BY out_date");

			}
		}else{
			if($selectedValue ==""){
				$stmt = (new Connection)->connect()->prepare("SELECT * FROM $table WHERE out_date >= $startDateFormatted AND out_date <= $dateTotDateFormatted AND status = 'F' AND branch_name = '$branch_name' ORDER BY out_date");
			}else{
				$stmt = (new Connection)->connect()->prepare("SELECT * FROM $table WHERE out_date >= $startDateFormatted AND out_date <= $dateTotDateFormatted AND atm_status = '$selectedValue' AND status = 'F' AND branch_name = '$branch_name'  ORDER BY out_date");

			}
		}

		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}
    static public function get_id($full_id)
    {
        $pdo = (new Connection)->connect();
        $pdo->beginTransaction();
        $sql = 'SELECT id 
                FROM fully_paid
                WHERE full_id = :full_id';
        $statement = $pdo->prepare($sql);
		$sql1 = 'SELECT id 
                FROM fully_paid ORDER BY id
                 Desc limit 1';
        $statement1 = $pdo->prepare($sql1);
		$statement1->execute();
		$row2 =$statement1->fetch(PDO::FETCH_ASSOC);


        $statement->bindParam(':full_id', $full_id, PDO::PARAM_STR);
        if ($statement->execute()) {
            $row = $statement->fetch(PDO::FETCH_ASSOC);
            return $row !== false ? $row2['id'] : false;
        }
        return false;
    }

    static public function mdlAddFullyPaid($table, $data)
    {
        try{
			$pdo = (new Connection)->connect();
			$pdo->beginTransaction();
			$full_id =  $data["full_id"];
            $full_id1= (new ModelFullyPaid)->get_id($full_id);
            $last_id = $full_id1 + 1;
            $id_holder = "FP" . str_repeat("0",5-strlen($last_id)).$last_id;   
            if (!$full_id1) {
                $id_holder = $full_id;
            }
          
			$stmt = $pdo->prepare("INSERT INTO $table(full_id, fpid, user_id, name, out_date, bank, status, address, branch_name) VALUES
             (:full_id, :fpid, :user_id, :name, :out_date, :bank, :status, :address, :branch_name)");
		
            $stmt->bindParam(":full_id", $id_holder, PDO::PARAM_STR);
			$stmt->bindParam(":fpid", $data["fpid"], PDO::PARAM_STR);
            $stmt->bindParam(":user_id", $data["user_id"], PDO::PARAM_STR);
			$stmt->bindParam(":name", $data["name"], PDO::PARAM_STR);
			$stmt->bindParam(":out_date", $data["out_date"], PDO::PARAM_STR);
			$stmt->bindParam(":bank", $data["bank"], PDO::PARAM_STR);
			$stmt->bindParam(":status", $data["status"], PDO::PARAM_STR);
			$stmt->bindParam(":address", $data["address"], PDO::PARAM_STR);
			$stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
		
		
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

	static public function mdlEditFullyPaid($table, $data){
		$stmt = (new Connection)->connect()->prepare("UPDATE $table SET `prrno` = :prrno, prrdate = :prrdate, 
		atm_status = :atm_status, `date_claimed` = :date_claimed, `remarks` = :remarks  WHERE id = :id");
		// Create a DateTime object from the string
		$date_claimed =  $data["date_claimed"];
		if($date_claimed!=""){
			$dateTime = DateTime::createFromFormat("F j, Y \a\\t g:i A", $date_claimed);
			// Format the DateTime object to the desired format
			$formattedClaimed = $dateTime->format("Y-m-d H:i");
		}else{
			$formattedClaimed="";
		}
		
		
		$stmt->bindParam(":id", $data["id"], PDO::PARAM_INT);
		$stmt->bindParam(":prrno", $data["prrno"], PDO::PARAM_STR);
		$stmt->bindParam(":prrdate", $data["prrdate"], PDO::PARAM_STR);
		$stmt->bindParam(":atm_status", $data["atm_status"], PDO::PARAM_STR);
		$stmt->bindParam(":date_claimed", $formattedClaimed, PDO::PARAM_STR);
		$stmt->bindParam(":remarks", $data["remarks"], PDO::PARAM_STR);
	
	
		if($stmt->execute()){
			return "ok";
		}else{
			return "error";
		}
	
		$stmt->close();
		$stmt = null;
	
	}	

	static public function mdlDelete($table, $data){
		$stmt = (new Connection)->connect()->prepare("UPDATE $table Set status ='1' WHERE id = :id");
		$stmt ->bindParam(":id", $data, PDO::PARAM_INT);
		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";	
		}
		$stmt -> close();
		$stmt = null;
	
	}
	static public function get_id1($report_id1)
	{
		$pdo = (new Connection)->connect();
		$pdo->beginTransaction();
		$sql = 'SELECT id 
				FROM fp_report1 
				WHERE report_id1 = :report_id1';
		$statement = $pdo->prepare($sql);

		$statement->bindParam(':report_id1', $report_id1, PDO::PARAM_STR);
		if ($statement->execute()) {
			$row = $statement->fetch(PDO::FETCH_ASSOC);
			return $row !== false ? $row['id'] : false;
		}
		return false;
	}

	static public function get_id2($report_id2)
	{
		$pdo = (new Connection)->connect();
		$pdo->beginTransaction();
		$sql = 'SELECT id 
				FROM fp_report2 
				WHERE report_id2 = :report_id2';
		$statement = $pdo->prepare($sql);

		$statement->bindParam(':report_id2', $report_id2, PDO::PARAM_STR);
		if ($statement->execute()) {
			$row = $statement->fetch(PDO::FETCH_ASSOC);
			return $row !== false ? $row['id'] : false;
		}
		return false;
	}
	static public function mdlAddReport1($table, $data)
    {
        try{
			$pdo = (new Connection)->connect();
			$pdo->beginTransaction();
			$report_id1 =  $data["report_id1"];
            $report_id11= (new ModelFullyPaid)->get_id1($report_id1);
            $last_id = $report_id11 + 1;
            $id_holder = "RP" . str_repeat("0",5-strlen($last_id)).$last_id;   
            if (!$report_id11) {
                $id_holder = $report_id1;
            }
          
			$stmt = $pdo->prepare("INSERT INTO $table(report_id1, full_id, branch_name, branch_address, branch_tele,
			 branch_phone, pens_name, pens_address, date_now, date_collect, branch_avail, branch_head) VALUES
             (:report_id1, :full_id, :branch_name, :branch_address, :branch_tele, :branch_phone, :pens_name, :pens_address,
			 :date_now, :date_collect, :branch_avail, :branch_head)");
		
            $stmt->bindParam(":report_id1", $id_holder, PDO::PARAM_STR);
			$stmt->bindParam(":full_id", $data["full_id"], PDO::PARAM_STR);
            $stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
			$stmt->bindParam(":branch_address", $data["branch_address"], PDO::PARAM_STR);
			$stmt->bindParam(":branch_tele", $data["branch_tele"], PDO::PARAM_STR);
			$stmt->bindParam(":branch_phone", $data["branch_phone"], PDO::PARAM_STR);
			$stmt->bindParam(":pens_name", $data["pens_name"], PDO::PARAM_STR);
			$stmt->bindParam(":pens_address", $data["pens_address"], PDO::PARAM_STR);
			$stmt->bindParam(":date_now", $data["date_now"], PDO::PARAM_STR);
			$stmt->bindParam(":date_collect", $data["date_collect"], PDO::PARAM_STR);
			$stmt->bindParam(":branch_avail", $data["branch_avail"], PDO::PARAM_STR);
			$stmt->bindParam(":branch_head", $data["branch_head"], PDO::PARAM_STR);
			
		
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
	static public function mdlEditReport1($table, $data){
		$stmt = (new Connection)->connect()->prepare("UPDATE $table SET `branch_name` = :branch_name, branch_address = :branch_address, 
		branch_tele = :branch_tele, `branch_phone` = :branch_phone, `pens_name` = :pens_name, `pens_address` = :pens_address
		, `date_now` = :date_now, `date_collect` = :date_collect, `branch_avail` = :branch_avail, `branch_head` = :branch_head  WHERE full_id = :full_id");
	
		$stmt->bindParam(":full_id", $data["full_id"], PDO::PARAM_STR);
		$stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
		$stmt->bindParam(":branch_address", $data["branch_address"], PDO::PARAM_STR);
		$stmt->bindParam(":branch_tele", $data["branch_tele"], PDO::PARAM_STR);
		$stmt->bindParam(":branch_phone", $data["branch_phone"], PDO::PARAM_STR);
		$stmt->bindParam(":pens_name", $data["pens_name"], PDO::PARAM_STR);
		$stmt->bindParam(":pens_address", $data["pens_address"], PDO::PARAM_STR);
		$stmt->bindParam(":date_now", $data["date_now"], PDO::PARAM_STR);
		$stmt->bindParam(":date_collect", $data["date_collect"], PDO::PARAM_STR);
		$stmt->bindParam(":branch_avail", $data["branch_avail"], PDO::PARAM_STR);
		$stmt->bindParam(":branch_head", $data["branch_head"], PDO::PARAM_STR);
		
	
	
		if($stmt->execute()){
			return "ok";
		}else{
			return "error";
		}
	
		$stmt->close();
		$stmt = null;
	
	}	
	static public function mdlAddReport2($table, $data)
    {
        try{
			$pdo = (new Connection)->connect();
			$pdo->beginTransaction();
			$report_id2 =  $data["report_id2"];
            $report_id22= (new ModelFullyPaid)->get_id2($report_id2);
            $last_id = $report_id22 + 1;
            $id_holder = "RPP" . str_repeat("0",5-strlen($last_id)).$last_id;   
            if (!$report_id22) {
                $id_holder = $report_id2;
            }
          
			$stmt = $pdo->prepare("INSERT INTO $table(report_id2, full_id, name, address, branch_name, branch_address, branch_tele,
			 branch_phone, amount_up, amount_promo, date_now, branch_ophead) VALUES
             (:report_id2, :full_id, :name, :address, :branch_name, :branch_address, :branch_tele, :branch_phone, :amount_up, :amount_promo,
			 :date_now, :branch_ophead)");
		
            $stmt->bindParam(":report_id2", $id_holder, PDO::PARAM_STR);
			$stmt->bindParam(":full_id", $data["full_id"], PDO::PARAM_STR);
			$stmt->bindParam(":name", $data["name"], PDO::PARAM_STR);
			$stmt->bindParam(":address", $data["address"], PDO::PARAM_STR);
            $stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
			$stmt->bindParam(":branch_address", $data["branch_address"], PDO::PARAM_STR);
			$stmt->bindParam(":branch_tele", $data["branch_tele"], PDO::PARAM_STR);
			$stmt->bindParam(":branch_phone", $data["branch_phone"], PDO::PARAM_STR);
			$stmt->bindParam(":amount_up", $data["amount_up"], PDO::PARAM_STR);
			$stmt->bindParam(":amount_promo", $data["amount_promo"], PDO::PARAM_STR);
			$stmt->bindParam(":date_now", $data["date_now"], PDO::PARAM_STR);
			$stmt->bindParam(":branch_ophead", $data["branch_ophead"], PDO::PARAM_STR);
		
		
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
	
	static public function mdlEditReport2($table, $data){
		$stmt = (new Connection)->connect()->prepare("UPDATE $table SET `branch_name` = :branch_name, branch_address = :branch_address, 
		branch_tele = :branch_tele, `branch_phone` = :branch_phone, `amount_up` = :amount_up, `amount_promo` = :amount_promo
		, `date_now` = :date_now, `branch_ophead` = :branch_ophead  WHERE full_id = :full_id");
	
			
			$stmt->bindParam(":full_id", $data["full_id"], PDO::PARAM_STR);
			$stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
			$stmt->bindParam(":branch_address", $data["branch_address"], PDO::PARAM_STR);
			$stmt->bindParam(":branch_tele", $data["branch_tele"], PDO::PARAM_STR);
			$stmt->bindParam(":branch_phone", $data["branch_phone"], PDO::PARAM_STR);
			$stmt->bindParam(":amount_up", $data["amount_up"], PDO::PARAM_STR);
			$stmt->bindParam(":amount_promo", $data["amount_promo"], PDO::PARAM_STR);
			$stmt->bindParam(":date_now", $data["date_now"], PDO::PARAM_STR);
			$stmt->bindParam(":branch_ophead", $data["branch_ophead"], PDO::PARAM_STR);
				
	
	
		if($stmt->execute()){
			return "ok";
		}else{
			return "error";
		}
	
		$stmt->close();
		$stmt = null;
	
	}
}