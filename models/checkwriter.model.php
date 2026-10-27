<?php

require_once "connection.php";
class ModelCheckWriter {

    static public function mdlUpdateCHCKWRTRRecords($data){

		try{
			$pdo = (new Connection)->connect();
			$pdo->beginTransaction();
           
			$stmt = $pdo->prepare("INSERT INTO `bnkchck` (bnkcd, docno, vchrno, cdate, payto, chkamt, chkstat, doctype, remarks) VALUES (:bnkcd, :docno, :vchrno, :cdate, :payto, :chkamt, :chkstat, :doctype, :remarks)");
			
            
            $stmt->bindParam(":bnkcd", $data["bnkcd"], PDO::PARAM_STR);
            $stmt->bindParam(":docno", $data["docno"], PDO::PARAM_STR);
			$stmt->bindParam(":vchrno", $data["vchrno"], PDO::PARAM_STR);
			$stmt->bindParam(":cdate", $data["cdate"], PDO::PARAM_STR);
			$stmt->bindParam(":payto", $data["payto"], PDO::PARAM_STR);
			$stmt->bindParam(":chkamt", $data["chkamt"], PDO::PARAM_STR);
			$stmt->bindParam(":chkstat", $data["chkstat"], PDO::PARAM_STR);
			$stmt->bindParam(":doctype", $data["doctype"], PDO::PARAM_STR);
			$stmt->bindParam(":remarks", $data["remarks"], PDO::PARAM_STR);

			$stmt->execute();
			$pdo->commit();
			return "ok";
 
		}catch(PDOException $exception){
            if(isset($pdo)) {
                $pdo->rollBack();
                $pdo = null; // Close the connection
            }
            return "error";      
		}
		$stmt->close();
		$stmt = null;
        
    }

    static public function mdlShowAllBNKCHCKList($collDate, $branch_name){
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM `bnkchck` WHERE cdate = '$collDate' AND branch_name = '$branch_name'");
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt = null;
    }

    // static public function mdlBNKCHCKListChecker($cdate, $branch_name){
		
	//     $stmt = (new Connection)->connect()->prepare("SELECT * FROM bnkchck WHERE cdate = '$cdate' AND branch_name = '$branch_name'");
	// 	$stmt -> execute();
    //     $total = $stmt->rowCount();
    //     if($total > 0){
    //         return "exist";
    //     }else{
    //         return "not exist";
    //     }
	// }
    
	static public function mdlBNKCHCKListChecker($docno, $payto) {
	
        $stmt =  (new Connection)->connect()->prepare("SELECT * FROM `bnkchck` WHERE docno = :docno AND payto = :payto");
        $stmt->bindParam(':docno', $docno);
        $stmt->bindParam(':payto', $payto);
        $stmt->execute();

        $total = $stmt->rowCount();

        if($total > 0){
            return "exist";
		} else {
			return "not_exist";
		}
	}
	
    static public function mdlShowBNKCHKDetails($id, $cdate, $branch_name){
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM `bnkchck` WHERE id = '$id' and cdate = '$cdate' AND branch_name = '$branch_name'");
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt = null;
    }

    static public function mdlGetBankBalance($bnk_code){
        $stmt = (new Connection)->connect()->prepare("SELECT 
        *
    FROM 
        bnkchck_bal
    WHERE 
        bnkcd = '$bnk_code'");

		$stmt -> execute();
        return $stmt -> fetchAll();
        $stmt -> close();
		$stmt = null;
    }

    // static public function mdlGetBankValue($bnk_code){
    //     $stmt = (new Connection)->connect()->prepare("SELECT 
    //     bnk_bal
    // FROM 
    //     bnkchck_bal
    // WHERE 
    //     bnkcd = '$bnk_code'");

	// 	$stmt -> execute();
    //     return $stmt -> fetchAll();
    //     $stmt -> close();
	// 	$stmt = null;
    // }

    static public function mdlCheckBankExist($bnk_code){
        try {

            $stmt = (new Connection)->connect()->prepare("SELECT * FROM `bnkchck_bal` WHERE bnkcd = :bnk_code");
            $stmt->bindParam(':bnk_code', $bnk_code, PDO::PARAM_STR);
            $stmt->execute();
            $total = $stmt->rowCount();

            if($total > 0) {
                $info = $stmt->fetch(PDO::FETCH_ASSOC);
                $bnk_name = $info['bnk_name'];
                return array("yes", $bnk_name);
            } else {
                return array("no", 'PNB');
            }
        } catch (PDOException $e) {
            error_log("Error checking bank existence: " . $e->getMessage());
            return array("error", $e->getMessage());
        }
    }
    

    static public function mdlAddBankBalance($data){

        $bnk_code = $data["bnk_code"];

        $check = self::mdlCheckBankExist($bnk_code);

        if ($check[0] == "yes") {

            $stmt = (new Connection)->connect()->prepare("UPDATE `bnkchck_bal` SET bnk_bal = :bnk_bal WHERE bnkcd = :bnk_code");
            $stmt->bindParam(":bnk_code", $data["bnk_code"], PDO::PARAM_STR);
            $stmt->bindParam(":bnk_bal", $data["bnk_bal"], PDO::PARAM_STR);
        
            if($stmt->execute()){
                return "ok";
            }else{
                return "error";
            }
    
            $stmt->close();
            $stmt = null;

        }else{

            $bnk_name = $check[1];
            
            $stmt = (new Connection)->connect()->prepare("INSERT INTO `bnkchck_bal` (bnkcd, bnk_name, bnk_bal) 
            VALUES (:bnk_code, :bnk_name, :bnk_bal)");

            $stmt->bindParam(":bnk_code", $bnk_code, PDO::PARAM_STR);
            $stmt->bindParam(":bnk_name", $bnk_name, PDO::PARAM_STR);
            $stmt->bindParam(":bnk_bal", $data["bnk_bal"], PDO::PARAM_STR);
        
            if($stmt->execute()){
                return "ok";
            }else{
                return "error";
            }
    
            $stmt->close();
            $stmt = null;
        }
		
    }

    static public function mdlAddBank($data){
     
        $stmt = (new Connection)->connect()->prepare("INSERT INTO `bnkchck_bal` (bnkcd, bnk_name, mnt_bal) 
        VALUES (:bnk_code, :bnk_name, :mnt_bal)");

        $stmt->bindParam(":bnk_code", $data["bnk_code"], PDO::PARAM_STR);
        $stmt->bindParam(":bnk_name", $data["bnk_name"], PDO::PARAM_STR);
        $stmt->bindParam(":mnt_bal", $data["mnt_bal"], PDO::PARAM_STR);
     
        if($stmt->execute()){
            return "ok";
        }else{
            return "error";
        }

        $stmt->close();
        $stmt = null;
    
    }

    static public function mdlShowAllBank(){
		$stmt = (new Connection)->connect()->prepare("SELECT * FROM bnkchck_bal");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

    static public function mdlDeductToBankAmountBalance($bnk_code, $bnk_amt){

        $bal = self::mdlGetBankBalance($bnk_code);

        if (!empty($bal)) {
            $rem_bal = floatVal($bal[0]['bnk_bal']) - floatVal($bnk_amt);
          }else{
            $rem_bal = '0.00';
        }
     
        $stmt = (new Connection)->connect()->prepare("UPDATE `bnkchck_bal` SET bnk_bal = :bnk_bal WHERE bnkcd = :bnk_code");

        $stmt->bindParam(":bnk_code", $bnk_code, PDO::PARAM_STR);
        $stmt->bindParam(":bnk_bal", $rem_bal, PDO::PARAM_STR);
     
        if($stmt->execute()){
            return "ok";
        }else{
            return "error";
        }

        $stmt->close();
        $stmt = null;
    
    }

      //appended 06/04/24 //

    static public function mdlBnkChckLogs($bnkcd, $docno, $chkamt, $pres_bal, $pres_bal_left, $action){
     
        $stmt = (new Connection)->connect()->prepare("INSERT INTO `bnkchck_logs` (bnkcd, docno, prev_bal, amount, cur_bal, action) 
        VALUES (:bnkcd, :docno, :prev_bal, :amount, :cur_bal, :action)");

        $stmt->bindParam(":bnkcd", $bnkcd, PDO::PARAM_STR);
        $stmt->bindParam(":prev_bal", $pres_bal, PDO::PARAM_STR);
        $stmt->bindParam(":amount", $chkamt, PDO::PARAM_STR);
        $stmt->bindParam(":cur_bal", $pres_bal_left, PDO::PARAM_STR);
        $stmt->bindParam(":action", $action, PDO::PARAM_STR);
        $stmt->bindParam(":docno", $docno, PDO::PARAM_STR);
     
        if($stmt->execute()){
            return "ok";
        }else{
            return "error";
        }

        $stmt->close();
        $stmt = null;
    
    }

    static public function mdlShowAllBNKCHCKLOGS(){
		$stmt = (new Connection)->connect()->prepare("SELECT * FROM bnkchck_logs ORDER BY 'id' DESC");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}


    
	static public function mdlCheckPrint($docno){	
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM bnkchck WHERE docno = :docno limit 1");
		$stmt->bindParam(":docno", $docno, PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt = null;
    }


    static public function mdlCheckBankCheck($bnkcd){	
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM bnkchck_bal WHERE bnkcd = :bnkcd limit 1");
		$stmt->bindParam(":bnkcd", $bnkcd, PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt = null;
    }

    static public function ctrUpdateBank($bnkcd, $update_balance){	
        $stmt = (new Connection)->connect()->prepare("UPDATE bnkchck_bal SET bnk_bal = :update_balance WHERE bnkcd = :bnkcd");
		$stmt->bindParam(":bnkcd", $bnkcd, PDO::PARAM_STR);
		$stmt->bindParam(":update_balance", $update_balance, PDO::PARAM_STR);
        if($stmt->execute()){
            return "ok";
        }else{
            return "error";
        }
        $stmt->close();
        $stmt = null;
       
    }

    static public function mdlUpdateCheckAmount($docno, $chkamt){	
        $stmt = (new Connection)->connect()->prepare("UPDATE bnkchck SET chkamt = :chkamt WHERE docno = :docno");
		$stmt->bindParam(":docno", $docno, PDO::PARAM_STR);
		$stmt->bindParam(":chkamt", $chkamt, PDO::PARAM_STR);
        if($stmt->execute()){
            return "ok";
        }else{
            return "error";
        }
        $stmt->close();
        $stmt = null;
       
    }


    static public function mdlBankUpdateLogs($data){
     
        $stmt = (new Connection)->connect()->prepare("INSERT INTO `bnkchck_logs` (bnkcd, docno, prev_bal, amount, cur_bal, action) 
        VALUES (:bnkcd, :docno, :prev_bal, :amount, :cur_bal, :action)");

        $stmt->bindParam(":bnkcd", $data['bnkcd'], PDO::PARAM_STR);
        $stmt->bindParam(":docno", $data['docno'], PDO::PARAM_STR);
        $stmt->bindParam(":prev_bal", $data['prev_bal'], PDO::PARAM_STR);
        $stmt->bindParam(":amount", $data['amount'], PDO::PARAM_STR);
        $stmt->bindParam(":cur_bal", $data['cur_bal'], PDO::PARAM_STR);
        $stmt->bindParam(":action", $data['action'], PDO::PARAM_STR);
     
        if($stmt->execute()){
            return "ok";
        }else{
            return "error";
        }

        $stmt->close();
        $stmt = null;
    
    }

    static public function mdlGetLogsID($id){	
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM bnkchck_logs WHERE id = :id");
		$stmt->bindParam(":id", $id, PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt = null;
    }

    
    static public function mdlUpdateBankStatus($id){
        $stmt = (new Connection)->connect()->prepare("UPDATE bnkchck_logs SET status = 'CANCELLED' WHERE id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_STR);
     
        if($stmt->execute()){
            return "ok";
        }else{
            return "error";
        }

        $stmt->close();
        $stmt = null;
    
    }

    static public function mdlShowAllBranches(){
		$stmt = (new Connection)->connect()->prepare("SELECT * FROM accounting_branches");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}
    static public function mdlTransferBank($table, $data){
        try {
            $connection = (new Connection)->connect();
            // Begin a transaction
            $connection->beginTransaction();

            // Prepare and execute the first statement
            $stmt = $connection->prepare("INSERT INTO $table (bnkcd, payto, branch_name, docno, chkamt, cdate, remarks) 
                                          VALUES (:bnkcd, :payto, :branch_name, :docno, :chkamt, :cdate, :remarks)");
            
            $stmt->bindParam(":bnkcd", $data['bnkcd'], PDO::PARAM_STR);
            $stmt->bindParam(":payto", $data['payto'], PDO::PARAM_STR);
            $stmt->bindParam(":branch_name", $data['branch_name'], PDO::PARAM_STR);
            $stmt->bindParam(":docno", $data['docno'], PDO::PARAM_STR);
            $stmt->bindParam(":chkamt", $data['chkamt'], PDO::PARAM_STR);
            $stmt->bindParam(":cdate", $data['cdate'], PDO::PARAM_STR);
            $stmt->bindParam(":remarks", $data['remarks'], PDO::PARAM_STR);
            if($stmt->execute()){
                // Prepare and execute the second statement
                $stmt1 = $connection->prepare("UPDATE `bnkchck_bal` SET `bnk_bal` = :updatedBalance WHERE bnkcd=:bnkcd");
                $stmt1->bindParam(":updatedBalance", $data['updatedBalance'], PDO::PARAM_STR);
                $stmt1->bindParam(":bnkcd", $data['bnkcd'], PDO::PARAM_STR);
                if($stmt1->execute()){
                    // Commit the transaction
                    $stmt2 = (new Connection)->connect()->prepare("INSERT INTO `bnkchck_logs` (bnkcd, docno, prev_bal, amount, cur_bal, action) 
                    VALUES (:bnkcd, :docno, :prev_bal, :amount, :cur_bal, :action)");
                    $stmt2->bindParam(":bnkcd", $data['bnkcd'], PDO::PARAM_STR);
                    $stmt2->bindParam(":docno", $data['docno'], PDO::PARAM_STR);
                    $stmt2->bindParam(":prev_bal", $data['prev_bal'], PDO::PARAM_STR);
                    $stmt2->bindParam(":amount", $data['chkamt'], PDO::PARAM_STR);
                    $stmt2->bindParam(":cur_bal", $data['updatedBalance'], PDO::PARAM_STR);
                    $stmt2->bindParam(":action", $data['remarks'], PDO::PARAM_STR);
                    if($stmt2->execute()){
                        $connection->commit();
                        $stmt->closeCursor();
                        $stmt1->closeCursor();
                        $stmt2->closeCursor();
                        return "ok";
                    }else{
                        $connection->rollBack();
                        $stmt->closeCursor();
                        $stmt1->closeCursor();
                        return "error updating balance";
                    }
                
                } else {
                    // Roll back the transaction if the second statement fails
                    $connection->rollBack();
                    $stmt->closeCursor();
                    return "error updating balance";
                }
            } else {
                // Roll back the transaction if the first statement fails
                $connection->rollBack();
                $stmt->closeCursor();
                return "error inserting data";
            }
        } catch (PDOException $e) {
            // Roll back the transaction in case of any exception
            if ($connection->inTransaction()) {
                $connection->rollBack();
            }
            return "error: " . $e->getMessage();
        }
    }


    static public function mdlCancelBankUpdateLogs($data){
     
        $stmt = (new Connection)->connect()->prepare("INSERT INTO `bnkchck_logs` (bnkcd, docno, prev_bal, amount, cur_bal, action, status) 
        VALUES (:bnkcd, :docno, :prev_bal, :amount, :cur_bal, :action, :status)");

        $stmt->bindParam(":bnkcd", $data['bnkcd'], PDO::PARAM_STR);
        $stmt->bindParam(":docno", $data['docno'], PDO::PARAM_STR);
        $stmt->bindParam(":prev_bal", $data['prev_bal'], PDO::PARAM_STR);
        $stmt->bindParam(":amount", $data['amount'], PDO::PARAM_STR);
        $stmt->bindParam(":cur_bal", $data['cur_bal'], PDO::PARAM_STR);
        $stmt->bindParam(":action", $data['action'], PDO::PARAM_STR);
        $stmt->bindParam(":status", $data['status'], PDO::PARAM_STR);
     
        if($stmt->execute()){
            return "ok";
        }else{
            return "error";
        }

        $stmt->close();
        $stmt = null;
    
    }


    static public function mdlCheckDocno($docno){	
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM bnkchck_logs WHERE docno = :docno and status = 'CANCELLED'");
		$stmt->bindParam(":docno", $docno, PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt = null;
    }


    static public function mdlGetCheckID(){ 
		$stmt = (new Connection)->connect()->prepare("SELECT * from bnkchck_logs ORDER BY id Desc limit 1");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

    static public function mdlShowFilterTransaction($bnk_chck_from, $bnk_chck_to, $bnk_chck_bank){
        if ($bnk_chck_bank == 'All') {
            $stmt = (new Connection)->connect()->prepare("
                SELECT 
                    bl.id AS bl_id, bl.bnkcd AS bl_bnkcd, bl.docno AS bl_docno, bl.prev_bal AS bl_prev_bal, 
                    bl.amount AS bl_amount, bl.cur_bal AS bl_cur_bal, bl.action AS bl_action, 
                    bl.status AS bl_status, bl.date AS bl_date,
                    b.id AS b_id, b.bnkcd AS b_bnkcd, b.docno AS b_docno, b.vchrno AS b_vchrno,
                    b.cdate AS b_cdate, b.payto AS b_payto, b.chkamt AS b_chkamt, b.chkstat AS b_chkstat,
                    b.doctype AS b_doctype, b.remarks AS b_remarks, b.time AS b_time, b.branch_name AS b_branch_name,
                    bb.bnk_name AS bb_bnk_name
                FROM bnkchck_logs bl
                INNER JOIN bnkchck b ON bl.docno = b.docno
                INNER JOIN bnkchck_bal bb ON bl.bnkcd = bb.bnkcd
                INNER JOIN (
                    SELECT docno, status, MAX(id) as max_id
                    FROM bnkchck_logs
                    GROUP BY docno
                ) max_logs ON bl.docno = max_logs.docno AND bl.id = max_logs.max_id
                WHERE bl.date >= CAST(:date_from AS DATETIME)
                AND bl.date < CAST(DATE_ADD(:date_to, INTERVAL 1 DAY) AS DATETIME)
                AND bl.status != 'CANCELLED' AND max_logs.status != 'CANCELLED'
                
                UNION ALL
                
                SELECT 
                    bl.id AS bl_id, bl.bnkcd AS bl_bnkcd, bl.docno AS bl_docno, bl.prev_bal AS bl_prev_bal, 
                    bl.amount AS bl_amount, bl.cur_bal AS bl_cur_bal, bl.action AS bl_action, 
                    bl.status AS bl_status, bl.date AS bl_date,
                    NULL AS b_id, NULL AS b_bnkcd, NULL AS b_docno, NULL AS b_vchrno,
                    NULL AS b_cdate, NULL AS b_payto, NULL AS b_chkamt, NULL AS b_chkstat,
                    NULL AS b_doctype, NULL AS b_remarks, NULL AS b_time, b.branch_name AS b_branch_name,
                    bb.bnk_name AS bb_bnk_name
                FROM bnkchck_logs bl
                LEFT JOIN bnkchck b ON bl.docno = b.docno
                INNER JOIN bnkchck_bal bb ON bl.bnkcd = bb.bnkcd
                WHERE bl.date >= CAST(:date_from AS DATETIME)
                AND bl.date < CAST(DATE_ADD(:date_to, INTERVAL 1 DAY) AS DATETIME)
                AND bl.action = 'Add Bank Balance'
                ORDER BY bl_id;
            ");
            $stmt->bindParam(":date_from", $bnk_chck_from, PDO::PARAM_STR);
            $stmt->bindParam(":date_to", $bnk_chck_to, PDO::PARAM_STR);
        } else {
            $stmt = (new Connection)->connect()->prepare("
                SELECT 
                    bl.id AS bl_id, bl.bnkcd AS bl_bnkcd, bl.docno AS bl_docno, bl.prev_bal AS bl_prev_bal, 
                    bl.amount AS bl_amount, bl.cur_bal AS bl_cur_bal, bl.action AS bl_action, 
                    bl.status AS bl_status, bl.date AS bl_date,
                    b.id AS b_id, b.bnkcd AS b_bnkcd, b.docno AS b_docno, b.vchrno AS b_vchrno,
                    b.cdate AS b_cdate, b.payto AS b_payto, b.chkamt AS b_chkamt, b.chkstat AS b_chkstat,
                    b.doctype AS b_doctype, b.remarks AS b_remarks, b.time AS b_time, b.branch_name AS b_branch_name,
                    bb.bnk_name AS bb_bnk_name
                FROM bnkchck_logs bl
                INNER JOIN bnkchck b ON bl.docno = b.docno
                INNER JOIN bnkchck_bal bb ON bl.bnkcd = bb.bnkcd
                INNER JOIN (
                    SELECT docno, status, MAX(id) as max_id
                    FROM bnkchck_logs
                    GROUP BY docno
                ) max_logs ON bl.docno = max_logs.docno AND bl.id = max_logs.max_id
                WHERE bl.date >= CAST(:date_from AS DATETIME)
                AND bl.date < CAST(DATE_ADD(:date_to, INTERVAL 1 DAY) AS DATETIME)
                AND bl.status != 'CANCELLED' AND max_logs.status != 'CANCELLED'
                AND bl.bnkcd = :bnk_bank
                
                UNION ALL
                
                SELECT 
                    bl.id AS bl_id, bl.bnkcd AS bl_bnkcd, bl.docno AS bl_docno, bl.prev_bal AS bl_prev_bal, 
                    bl.amount AS bl_amount, bl.cur_bal AS bl_cur_bal, bl.action AS bl_action, 
                    bl.status AS bl_status, bl.date AS bl_date,
                    NULL AS b_id, NULL AS b_bnkcd, NULL AS b_docno, NULL AS b_vchrno,
                    NULL AS b_cdate, NULL AS b_payto, NULL AS b_chkamt, NULL AS b_chkstat,
                    NULL AS b_doctype, NULL AS b_remarks, NULL AS b_time, b.branch_name AS b_branch_name,
                    bb.bnk_name AS bb_bnk_name
                FROM bnkchck_logs bl
                LEFT JOIN bnkchck b ON bl.docno = b.docno
                INNER JOIN bnkchck_bal bb ON bl.bnkcd = bb.bnkcd
                WHERE bl.date >= CAST(:date_from AS DATETIME)
                AND bl.date < CAST(DATE_ADD(:date_to, INTERVAL 1 DAY) AS DATETIME)
                AND bl.action = 'Add Bank Balance'
                AND bl.bnkcd = :bnk_bank
                ORDER BY bl_id;
            ");
            $stmt->bindParam(":date_from", $bnk_chck_from, PDO::PARAM_STR);
            $stmt->bindParam(":date_to", $bnk_chck_to, PDO::PARAM_STR);
            $stmt->bindParam(":bnk_bank", $bnk_chck_bank, PDO::PARAM_STR);
        }
        
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt -> close();
        $stmt = null;
        // return $results;
    }

    static public function mdlGetBegBal($prevDate, $bnkcd) {
        try {
            $stmt = (new Connection)->connect()->prepare("
                SELECT * 
                FROM bnkchck_logs 
                WHERE bnkcd = :bnkcd 
                  AND date <= CAST(:prevDate AS DATETIME)
                ORDER BY id DESC 
                LIMIT 1
            ");
            $stmt->bindParam(":bnkcd", $bnkcd, PDO::PARAM_STR);
            $stmt->bindParam(":prevDate", $prevDate, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            return $result;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    static public function mdlGetEndBal($curDate, $bnkcd) {
        try {
            $stmt = (new Connection)->connect()->prepare("
                SELECT * 
                FROM bnkchck_logs 
                WHERE bnkcd = :bnkcd 
                AND DATE(date) <= :curDate
                ORDER BY id DESC 
                LIMIT 1
            ");
            $stmt->bindParam(":bnkcd", $bnkcd, PDO::PARAM_STR);
            $stmt->bindParam(":curDate", $curDate, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            return $result;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    static public function mdlShowLiaisonList(){
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM liaison_officers ORDER BY l_id");
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt -> close();
        $stmt = null;
    }

    static public function mdlAddNewLiaison($table, $data){
        try {
            $connection = (new Connection)->connect();
            // Begin a transaction
            $connection->beginTransaction();

            // Prepare and execute the first statement
            $stmt = $connection->prepare("INSERT INTO $table (full_name, address, contact_no, sex, type_of_id, id_no, birth_date, birth_place, nationality, citizenship) 
                                          VALUES (:full_name, :address, :contact_no, :sex, :type_of_id, :id_no, :birth_date, :birth_place, :nationality, :citizenship)");
            
            $stmt->bindParam(":full_name", $data['full_name'], PDO::PARAM_STR);
            $stmt->bindParam(":address", $data['address'], PDO::PARAM_STR);
            $stmt->bindParam(":contact_no", $data['contact_no'], PDO::PARAM_STR);
            $stmt->bindParam(":sex", $data['sex'], PDO::PARAM_STR);
            $stmt->bindParam(":type_of_id", $data['type_of_id'], PDO::PARAM_STR);
            $stmt->bindParam(":id_no", $data['id_no'], PDO::PARAM_STR);
            $stmt->bindParam(":birth_date", $data['birth_date'], PDO::PARAM_STR);
            $stmt->bindParam(":birth_place", $data['birth_place'], PDO::PARAM_STR);
            $stmt->bindParam(":nationality", $data['nationality'], PDO::PARAM_STR);
            $stmt->bindParam(":citizenship", $data['citizenship'], PDO::PARAM_STR);
            if($stmt->execute()){
                $connection->commit();
                $stmt->closeCursor();
                return "ok";
            } else {
                // Roll back the transaction if the first statement fails
                $connection->rollBack();
                $stmt->closeCursor();
                return "error inserting data";
            }
        } catch (PDOException $e) {
            // Roll back the transaction in case of any exception
            if ($connection->inTransaction()) {
                $connection->rollBack();
            }
            return "error: " . $e->getMessage();
        }
    }
    
	static public function mdlGetLiaisonInfo($l_id){

        $stmt = (new Connection)->connect()->prepare("SELECT * FROM liaison_officers WHERE l_id = '$l_id'");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
    }

    static public function mdlEditLiaison($table, $data){
		$stmt = (new Connection)->connect()->prepare("UPDATE $table SET `full_name` = :full_name, `address` = :address, 
		`contact_no` = :contact_no, `sex` = :sex, `type_of_id` = :type_of_id, `id_no` = :id_no, `birth_date` = :birth_date,
        `birth_place` = :birth_place, `nationality` = :nationality, `citizenship` = :citizenship WHERE `l_id`= :l_id");
			
		$stmt->bindParam(":l_id", $data["l_id"], PDO::PARAM_INT);
		$stmt->bindParam(":full_name", $data["full_name"], PDO::PARAM_STR);
        $stmt->bindParam(":address", $data['address'], PDO::PARAM_STR);
        $stmt->bindParam(":contact_no", $data['contact_no'], PDO::PARAM_STR);
        $stmt->bindParam(":sex", $data['sex'], PDO::PARAM_STR);
        $stmt->bindParam(":type_of_id", $data['type_of_id'], PDO::PARAM_STR);
        $stmt->bindParam(":id_no", $data['id_no'], PDO::PARAM_STR);
        $stmt->bindParam(":birth_date", $data['birth_date'], PDO::PARAM_STR);
        $stmt->bindParam(":birth_place", $data['birth_place'], PDO::PARAM_STR);
        $stmt->bindParam(":nationality", $data['nationality'], PDO::PARAM_STR);
        $stmt->bindParam(":citizenship", $data['citizenship'], PDO::PARAM_STR);
	
		if($stmt->execute()){
			return "ok";
		}else{
			return "error";
		}
	
		$stmt->close();
		$stmt = null;
	}	

    static public function mdlDeleteLiaison($table, $id){
		$stmt = (new Connection)->connect()->prepare("DELETE FROM $table WHERE l_id = :l_id");
		$stmt -> bindParam(":l_id", $id, PDO::PARAM_INT);
		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";	
		}
		$stmt -> close();
		$stmt = null;
	}	

}