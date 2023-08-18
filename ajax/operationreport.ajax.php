<?php
require_once "../controllers/operation.controller.php";
require_once "../models/operation.model.php";
require_once "../views/modules/session.php";

$filterBackup= new reportTable();
$type = $_GET['type'];
if($type == "grossin"){
    $filterBackup -> showGrossinReport();
}elseif($type == "outgoing"){
    $filterBackup -> showOutGoingReport();
}elseif($type == "lsor"){
    $filterBackup -> showLsorReport();
}


class reportTable{

    public function showGrossinReport(){
        $Operation = new ControllerOperation();


        $from = $_GET['from'];
        $to = $_GET['to'];

        $prev = date("Y-m-d", strtotime("-1 day", strtotime($from)));
            $html = '';

        
            $html .= ' <thead>
            <tr>
                <th rowspan="2" style="text-align: center; vertical-align: middle; font-size: 15px; margin-bottom: 20px;">BRANCH</th>
                <th rowspan="2" style="text-align: center; vertical-align: middle; font-size: 12px; margin-bottom: 20px;">as of '.$prev.'</th>
                <th>WALK IN</th>
                <th>SALES REP</th>
                <th>RETURNEE</th>
                <th>RUNNERS / AGENT</th>
                <th>TRANSFER</th>
                <th>TOTAL IN</th>
                <th>CUM. TOTAL</th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th>as of '.$to.'</th>
            </tr>
        </thead>
            <tbody>';
            $getEMB = $Operation ->ctrGetAllEMBBranches();
            $grand_totalCumi = 0;
            $grand_totalWalkin = 0;
            $grand_totalSalesrep = 0;
            $grand_totalReturnee = 0;
            $grand_totalRunners = 0;
            $grand_totalTransfer = 0;
            $grand_totalGrossin = 0;
            $grand_totalFinaCumi = 0;
            foreach ($getEMB as $emb) { 
                $branch_name = $emb['full_name'];
                $type = "grossin";
                $get_grossinBal = $Operation ->ctrGetGrossinBal($branch_name, $type);
                if(!empty($get_grossinBal)){
                    foreach ($get_grossinBal as $grossinBal){
                        $amount = $grossinBal['amount'];
                    }
                }else{
                    $amount = 0;
                }
                    $getGrossinCumi = $Operation->ctrGetGrossinCumi($prev, $branch_name);
                    if(!empty($getGrossinCumi)){
                    $total_GrossinCumi = $getGrossinCumi[0]['total_cumi'];
                    }else{
                    $total_GrossinCumi = 0;
                    }
                    $final_grossinCumi = $amount + $total_GrossinCumi;

                $get_grossinData = $Operation->ctrGetGrossinData($branch_name, $from, $to);

                if(!empty($get_grossinData)){
                    foreach($get_grossinData as $gossinData){
                        $walkin = $gossinData['walkin'];
                        $sales_rep = $gossinData['sales_rep'];
                        $returnee = $gossinData['returnee'];
                        $runners_agent = $gossinData['runners_agent'];
                        $gros_transfer = $gossinData['transfer'];
                    }
                    if($walkin == 0){
                        $walkin = 0; 
                    }
                    if($sales_rep == 0){
                        $sales_rep = 0; 
                    }
                    if($returnee == 0){
                        $returnee = 0; 
                    }
                    if($runners_agent == 0){
                        $runners_agent = 0; 
                    }
                    if($gros_transfer == 0){
                        $gros_transfer = 0; 
                    }
                }else{
                    $walkin = 0; 
                    $sales_rep = 0;
                    $returnee = 0;
                    $runners_agent = 0;
                    $gros_transfer = 0;
                }
                $total_grossin_cumi = $final_grossinCumi + $walkin + $sales_rep + $returnee + $runners_agent + $gros_transfer;
                $total_grossin = $walkin + $sales_rep + $returnee + $runners_agent +  $gros_transfer;
               
            $html .= '
            <tr>
            <td>'.$branch_name.'</td>
            <td>'.$final_grossinCumi.'</td>
            <td>'.$walkin.'</td>
            <td>'.$sales_rep.'</td>
            <td>'.$returnee.'</td>
            <td>'.$runners_agent.'</td>
            <td>'.$gros_transfer.'</td>
            <td>'.$total_grossin.'</td>
            <td>'.$total_grossin_cumi.'</td>
        </tr>
            ';
            
            $grand_totalCumi += $final_grossinCumi;
            $grand_totalWalkin+= $walkin;
            $grand_totalSalesrep += $sales_rep;
            $grand_totalReturnee += $returnee;
            $grand_totalRunners += $runners_agent;
            $grand_totalTransfer += $gros_transfer;
            $grand_totalGrossin += $total_grossin;
            $grand_totalFinaCumi += $total_grossin_cumi;


        }

        $html .= '
            <tr style=" font-weight: bold;">
                <td>TOTAL</td>
                <td>'.$grand_totalCumi.'</td>
                <td>'.$grand_totalWalkin.'</td>
                <td>'.$grand_totalSalesrep.'</td>
                <td>'.$grand_totalReturnee.'</td>
                <td>'.$grand_totalRunners.'</td>
                <td>'.$grand_totalTransfer.'</td>
                <td>'.$grand_totalGrossin.'</td>
                <td>'.$grand_totalFinaCumi.'</td>
            </tr>
        ';

        $html .= '
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
        ';


        $getFCH= $Operation ->ctrGetAllFCHBranches();
        $grand_totalCumi = 0;
        $grand_totalWalkin = 0;
        $grand_totalSalesrep = 0;
        $grand_totalReturnee = 0;
        $grand_totalRunners = 0;
        $grand_totalTransfer = 0;
        $grand_totalGrossin = 0;
        $grand_totalFinaCumi = 0;
        foreach ($getFCH as $fch) { 
            $branch_name = $fch['full_name'];
            $type = "grossin";
            $get_grossinBal = $Operation ->ctrGetGrossinBal($branch_name, $type);
            if(!empty($get_grossinBal)){
                foreach ($get_grossinBal as $grossinBal){
                    $amount = $grossinBal['amount'];
                }
            }else{
                $amount = 0;
            }
                $getGrossinCumi = $Operation->ctrGetGrossinCumi($prev, $branch_name);
                if(!empty($getGrossinCumi)){
                $total_GrossinCumi = $getGrossinCumi[0]['total_cumi'];
                }else{
                $total_GrossinCumi = 0;
                }
                $final_grossinCumi = $amount + $total_GrossinCumi;

            $get_grossinData = $Operation->ctrGetGrossinData($branch_name, $from, $to);

            if(!empty($get_grossinData)){
                foreach($get_grossinData as $gossinData){
                    $walkin = $gossinData['walkin'];
                    $sales_rep = $gossinData['sales_rep'];
                    $returnee = $gossinData['returnee'];
                    $runners_agent = $gossinData['runners_agent'];
                    $gros_transfer = $gossinData['transfer'];
                }
                if($walkin == 0){
                    $walkin = 0; 
                }
                if($sales_rep == 0){
                    $sales_rep = 0; 
                }
                if($returnee == 0){
                    $returnee = 0; 
                }
                if($runners_agent == 0){
                    $runners_agent = 0; 
                }
                if($gros_transfer == 0){
                    $gros_transfer = 0; 
                }
            }else{
                $walkin = 0; 
                $sales_rep = 0;
                $returnee = 0;
                $runners_agent = 0;
                $gros_transfer = 0;
            }
            $total_grossin_cumi = $final_grossinCumi + $walkin + $sales_rep + $returnee + $runners_agent + $gros_transfer;
            $total_grossin = $walkin + $sales_rep + $returnee + $runners_agent +  $gros_transfer;
           
        $html .= '
        <tr>
        <td>'.$branch_name.'</td>
        <td>'.$final_grossinCumi.'</td>
        <td>'.$walkin.'</td>
        <td>'.$sales_rep.'</td>
        <td>'.$returnee.'</td>
        <td>'.$runners_agent.'</td>
        <td>'.$gros_transfer.'</td>
        <td>'.$total_grossin.'</td>
        <td>'.$total_grossin_cumi.'</td>
    </tr>
        ';
        
        $grand_totalCumi += $final_grossinCumi;
        $grand_totalWalkin+= $walkin;
        $grand_totalSalesrep += $sales_rep;
        $grand_totalReturnee += $returnee;
        $grand_totalRunners += $runners_agent;
        $grand_totalTransfer += $gros_transfer;
        $grand_totalGrossin += $total_grossin;
        $grand_totalFinaCumi += $total_grossin_cumi;


    }

    $html .= '
        <tr style=" font-weight: bold;">
            <td>TOTAL</td>
            <td>'.$grand_totalCumi.'</td>
            <td>'.$grand_totalWalkin.'</td>
            <td>'.$grand_totalSalesrep.'</td>
            <td>'.$grand_totalReturnee.'</td>
            <td>'.$grand_totalRunners.'</td>
            <td>'.$grand_totalTransfer.'</td>
            <td>'.$grand_totalGrossin.'</td>
            <td>'.$grand_totalFinaCumi.'</td>
        </tr>
       
    ';
    $html .= '
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
';

    $getRLC= $Operation ->ctrGetAllRLCBranches();
        $grand_totalCumi = 0;
        $grand_totalWalkin = 0;
        $grand_totalSalesrep = 0;
        $grand_totalReturnee = 0;
        $grand_totalRunners = 0;
        $grand_totalTransfer = 0;
        $grand_totalGrossin = 0;
        $grand_totalFinaCumi = 0;
        foreach ($getRLC as $rlc) { 
            $branch_name = $rlc['full_name'];
            $type = "grossin";
            $get_grossinBal = $Operation ->ctrGetGrossinBal($branch_name, $type);
            if(!empty($get_grossinBal)){
                foreach ($get_grossinBal as $grossinBal){
                    $amount = $grossinBal['amount'];
                }
            }else{
                $amount = 0;
            }
                $getGrossinCumi = $Operation->ctrGetGrossinCumi($prev, $branch_name);
                if(!empty($getGrossinCumi)){
                $total_GrossinCumi = $getGrossinCumi[0]['total_cumi'];
                }else{
                $total_GrossinCumi = 0;
                }
                $final_grossinCumi = $amount + $total_GrossinCumi;

            $get_grossinData = $Operation->ctrGetGrossinData($branch_name, $from, $to);

            if(!empty($get_grossinData)){
                foreach($get_grossinData as $gossinData){
                    $walkin = $gossinData['walkin'];
                    $sales_rep = $gossinData['sales_rep'];
                    $returnee = $gossinData['returnee'];
                    $runners_agent = $gossinData['runners_agent'];
                    $gros_transfer = $gossinData['transfer'];
                }
                if($walkin == 0){
                    $walkin = 0; 
                }
                if($sales_rep == 0){
                    $sales_rep = 0; 
                }
                if($returnee == 0){
                    $returnee = 0; 
                }
                if($runners_agent == 0){
                    $runners_agent = 0; 
                }
                if($gros_transfer == 0){
                    $gros_transfer = 0; 
                }
            }else{
                $walkin = 0; 
                $sales_rep = 0;
                $returnee = 0;
                $runners_agent = 0;
                $gros_transfer = 0;
            }
            $total_grossin_cumi = $final_grossinCumi + $walkin + $sales_rep + $returnee + $runners_agent + $gros_transfer;
            $total_grossin = $walkin + $sales_rep + $returnee + $runners_agent +  $gros_transfer;
           
        $html .= '
        <tr>
        <td>'.$branch_name.'</td>
        <td>'.$final_grossinCumi.'</td>
        <td>'.$walkin.'</td>
        <td>'.$sales_rep.'</td>
        <td>'.$returnee.'</td>
        <td>'.$runners_agent.'</td>
        <td>'.$gros_transfer.'</td>
        <td>'.$total_grossin.'</td>
        <td>'.$total_grossin_cumi.'</td>
    </tr>
        ';
        
        $grand_totalCumi += $final_grossinCumi;
        $grand_totalWalkin+= $walkin;
        $grand_totalSalesrep += $sales_rep;
        $grand_totalReturnee += $returnee;
        $grand_totalRunners += $runners_agent;
        $grand_totalTransfer += $gros_transfer;
        $grand_totalGrossin += $total_grossin;
        $grand_totalFinaCumi += $total_grossin_cumi;


    }

    $html .= '
        <tr style=" font-weight: bold;">
            <td>TOTAL</td>
            <td>'.$grand_totalCumi.'</td>
            <td>'.$grand_totalWalkin.'</td>
            <td>'.$grand_totalSalesrep.'</td>
            <td>'.$grand_totalReturnee.'</td>
            <td>'.$grand_totalRunners.'</td>
            <td>'.$grand_totalTransfer.'</td>
            <td>'.$grand_totalGrossin.'</td>
            <td>'.$grand_totalFinaCumi.'</td>
        </tr>
     
    ';

    $html .= '
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
';
    $getELC= $Operation ->ctrGetAllELCBranches();
        $grand_totalCumi = 0;
        $grand_totalWalkin = 0;
        $grand_totalSalesrep = 0;
        $grand_totalReturnee = 0;
        $grand_totalRunners = 0;
        $grand_totalTransfer = 0;
        $grand_totalGrossin = 0;
        $grand_totalFinaCumi = 0;
        foreach ($getELC as $elc) { 
            $branch_name = $elc['full_name'];
            $type = "grossin";
            $get_grossinBal = $Operation ->ctrGetGrossinBal($branch_name, $type);
            if(!empty($get_grossinBal)){
                foreach ($get_grossinBal as $grossinBal){
                    $amount = $grossinBal['amount'];
                }
            }else{
                $amount = 0;
            }
                $getGrossinCumi = $Operation->ctrGetGrossinCumi($prev, $branch_name);
                if(!empty($getGrossinCumi)){
                $total_GrossinCumi = $getGrossinCumi[0]['total_cumi'];
                }else{
                $total_GrossinCumi = 0;
                }
                $final_grossinCumi = $amount + $total_GrossinCumi;

            $get_grossinData = $Operation->ctrGetGrossinData($branch_name, $from, $to);

            if(!empty($get_grossinData)){
                foreach($get_grossinData as $gossinData){
                    $walkin = $gossinData['walkin'];
                    $sales_rep = $gossinData['sales_rep'];
                    $returnee = $gossinData['returnee'];
                    $runners_agent = $gossinData['runners_agent'];
                    $gros_transfer = $gossinData['transfer'];
                }
                if($walkin == 0){
                    $walkin = 0; 
                }
                if($sales_rep == 0){
                    $sales_rep = 0; 
                }
                if($returnee == 0){
                    $returnee = 0; 
                }
                if($runners_agent == 0){
                    $runners_agent = 0; 
                }
                if($gros_transfer == 0){
                    $gros_transfer = 0; 
                }
            }else{
                $walkin = 0; 
                $sales_rep = 0;
                $returnee = 0;
                $runners_agent = 0;
                $gros_transfer = 0;
            }
            $total_grossin_cumi = $final_grossinCumi + $walkin + $sales_rep + $returnee + $runners_agent + $gros_transfer;
            $total_grossin = $walkin + $sales_rep + $returnee + $runners_agent +  $gros_transfer;
           
        $html .= '
        <tr>
        <td>'.$branch_name.'</td>
        <td>'.$final_grossinCumi.'</td>
        <td>'.$walkin.'</td>
        <td>'.$sales_rep.'</td>
        <td>'.$returnee.'</td>
        <td>'.$runners_agent.'</td>
        <td>'.$gros_transfer.'</td>
        <td>'.$total_grossin.'</td>
        <td>'.$total_grossin_cumi.'</td>
    </tr>
        ';
        
        $grand_totalCumi += $final_grossinCumi;
        $grand_totalWalkin+= $walkin;
        $grand_totalSalesrep += $sales_rep;
        $grand_totalReturnee += $returnee;
        $grand_totalRunners += $runners_agent;
        $grand_totalTransfer += $gros_transfer;
        $grand_totalGrossin += $total_grossin;
        $grand_totalFinaCumi += $total_grossin_cumi;


    }

    $html .= '
        <tr style=" font-weight: bold;">
            <td>TOTAL</td>
            <td>'.$grand_totalCumi.'</td>
            <td>'.$grand_totalWalkin.'</td>
            <td>'.$grand_totalSalesrep.'</td>
            <td>'.$grand_totalReturnee.'</td>
            <td>'.$grand_totalRunners.'</td>
            <td>'.$grand_totalTransfer.'</td>
            <td>'.$grand_totalGrossin.'</td>
            <td>'.$grand_totalFinaCumi.'</td>
        </tr>
        </tbody>        
    ';


            echo json_encode(['card' => $html]);
        }


        public function showOutGoingReport(){
            $Operation = new ControllerOperation();
    
    
            $from = $_GET['from'];
            $to = $_GET['to'];
    
            $prev = date("Y-m-d", strtotime("-1 day", strtotime($from)));
                $html = '';
    
            
                $html .= ' <thead>
                <tr>
                    <th rowspan="2" style="text-align: center; vertical-align: middle; font-size: 15px; margin-bottom: 20px;">BRANCH</th>
                    <th rowspan="2" style="text-align: center; vertical-align: middle; font-size: 12px; margin-bottom: 20px;">as of '.$prev.'</th>
                    <th>FULLY PAID</th>
                    <th>DECEASED</th>
                    <th>GAWAD</th>
                    <th>BAD ACCT</th>
                    <th>TRANSFER</th>
                    <th>TOTAL IN</th>
                    <th>CUM. TOTAL</th>
                </tr>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>as of '.$to.'</th>
                </tr>
            </thead>
                <tbody>';

                $grand_totalCumi = 0;
                $grand_totalFully_paid = 0;
                $grand_totalDeceased = 0;
                $grand_totalGawad = 0;
                $grand_totalBadAccounts = 0;
                $grand_totalTransfer = 0;
                $grand_totalOutgoing = 0;
                $grand_totalFinaCumi = 0;
                $getEMB = $Operation ->ctrGetAllEMBBranches();
                foreach ($getEMB as $emb) { 
                    $branch_name = $emb['full_name'];
                    $type = "outgoing";
                    $get_outgoingBal = $Operation ->ctrGetGrossinBal($branch_name, $type);
                    if(!empty($get_outgoingBal)){
                        foreach ($get_outgoingBal as $outgoingBal){
                            $amount = $outgoingBal['amount'];
                        }
                    }else{
                        $amount = 0;
                    }
                        $getOutgoingCumi = $Operation->ctrGetOutgoingCumi($prev, $branch_name);
                        if(!empty($getOutgoingCumi)){
                        $total_OutgoingCumi = $getOutgoingCumi[0]['total_cumi'];
                        }else{
                        $total_OutgoingCumi = 0;
                        }
                        $final_outgoingCumi = $amount + $total_OutgoingCumi;
    
                    $get_outgoingData = $Operation->ctrGetOutgoingData($branch_name, $from, $to);
    
                    if(!empty($get_outgoingData)){
                        foreach($get_outgoingData as $outgoingData){
                            $fully_paid = $outgoingData['fully_paid'];
                            $deceased = $outgoingData['deceased'];
                            $gawad = $outgoingData['gawad'];
                            $bad_accounts = $outgoingData['bad_accounts'];
                            $transfer = $outgoingData['transfer'];
                        }
                        if($fully_paid == 0){
                            $fully_paid = 0; 
                        }
                        if($deceased == 0){
                            $deceased = 0; 
                        }
                        if($gawad == 0){
                            $gawad = 0; 
                        }
                        if($bad_accounts == 0){
                            $bad_accounts = 0; 
                        }
                        if($transfer == 0){
                            $transfer = 0; 
                        }
                    }else{
                        $fully_paid = 0; 
                        $deceased = 0;
                        $gawad = 0;
                        $bad_accounts = 0;
                        $transfer = 0;
                    }
                    $total_outgoing_cumi = $final_outgoingCumi + $fully_paid + $deceased + $gawad + $bad_accounts + $transfer;
                    $total_outgoing = $fully_paid + $deceased + $gawad + $bad_accounts + $transfer;
                   
                $html .= '
                <tr>
                <td>'.$branch_name.'</td>
                <td>'.$final_outgoingCumi.'</td>
                <td>'.$fully_paid.'</td>
                <td>'.$deceased.'</td>
                <td>'.$gawad.'</td>
                <td>'.$bad_accounts.'</td>
                <td>'.$transfer.'</td>
                <td>'.$total_outgoing.'</td>
                <td>'.$total_outgoing_cumi.'</td>
            </tr>
                ';
                $grand_totalCumi += $final_outgoingCumi;
                $grand_totalFully_paid+= $fully_paid;
                $grand_totalDeceased += $deceased;
                $grand_totalGawad+= $gawad;
                $grand_totalBadAccounts+= $bad_accounts;
                $grand_totalTransfer += $transfer;
                $grand_totalOutgoing+= $total_outgoing;
                $grand_totalFinaCumi += $total_outgoing_cumi;
            }
        
            $html .= '
                <tr style=" font-weight: bold;">
                    <td>TOTAL</td>
                    <td>'.$grand_totalCumi.'</td>
                    <td>'.$grand_totalFully_paid.'</td>
                    <td>'.$grand_totalDeceased.'</td>
                    <td>'.$grand_totalGawad.'</td>
                    <td>'.$grand_totalBadAccounts.'</td>
                    <td>'.$grand_totalTransfer.'</td>
                    <td>'.$grand_totalOutgoing.'</td>
                    <td>'.$grand_totalFinaCumi.'</td>
                </tr>
            ';
            $html .= '
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
    ';
            $grand_totalCumi = 0;
            $grand_totalFully_paid = 0;
            $grand_totalDeceased = 0;
            $grand_totalGawad = 0;
            $grand_totalBadAccounts = 0;
            $grand_totalTransfer = 0;
            $grand_totalOutgoing = 0;
            $grand_totalFinaCumi = 0;
            $getFCH = $Operation ->ctrGetAllFCHBranches();
            foreach ($getFCH as $fch) { 
                $branch_name = $fch['full_name'];
                $type = "outgoing";
                $get_outgoingBal = $Operation ->ctrGetGrossinBal($branch_name, $type);
                if(!empty($get_outgoingBal)){
                    foreach ($get_outgoingBal as $outgoingBal){
                        $amount = $outgoingBal['amount'];
                    }
                }else{
                    $amount = 0;
                }
                    $getOutgoingCumi = $Operation->ctrGetOutgoingCumi($prev, $branch_name);
                    if(!empty($getOutgoingCumi)){
                    $total_OutgoingCumi = $getOutgoingCumi[0]['total_cumi'];
                    }else{
                    $total_OutgoingCumi = 0;
                    }
                    $final_outgoingCumi = $amount + $total_OutgoingCumi;

                $get_outgoingData = $Operation->ctrGetOutgoingData($branch_name, $from, $to);

                if(!empty($get_outgoingData)){
                    foreach($get_outgoingData as $outgoingData){
                        $fully_paid = $outgoingData['fully_paid'];
                        $deceased = $outgoingData['deceased'];
                        $gawad = $outgoingData['gawad'];
                        $bad_accounts = $outgoingData['bad_accounts'];
                        $transfer = $outgoingData['transfer'];
                    }
                    if($fully_paid == 0){
                        $fully_paid = 0; 
                    }
                    if($deceased == 0){
                        $deceased = 0; 
                    }
                    if($gawad == 0){
                        $gawad = 0; 
                    }
                    if($bad_accounts == 0){
                        $bad_accounts = 0; 
                    }
                    if($transfer == 0){
                        $transfer = 0; 
                    }
                }else{
                    $fully_paid = 0; 
                    $deceased = 0;
                    $gawad = 0;
                    $bad_accounts = 0;
                    $transfer = 0;
                }
                $total_outgoing_cumi = $final_outgoingCumi + $fully_paid + $deceased + $gawad + $bad_accounts + $transfer;
                $total_outgoing = $fully_paid + $deceased + $gawad + $bad_accounts + $transfer;
               
            $html .= '
            <tr>
            <td>'.$branch_name.'</td>
            <td>'.$final_outgoingCumi.'</td>
            <td>'.$fully_paid.'</td>
            <td>'.$deceased.'</td>
            <td>'.$gawad.'</td>
            <td>'.$bad_accounts.'</td>
            <td>'.$transfer.'</td>
            <td>'.$total_outgoing.'</td>
            <td>'.$total_outgoing_cumi.'</td>
        </tr>
            ';
            $grand_totalCumi += $final_outgoingCumi;
            $grand_totalFully_paid+= $fully_paid;
            $grand_totalDeceased += $deceased;
            $grand_totalGawad+= $gawad;
            $grand_totalBadAccounts+= $bad_accounts;
            $grand_totalTransfer += $transfer;
            $grand_totalOutgoing+= $total_outgoing;
            $grand_totalFinaCumi += $total_outgoing_cumi;
        }
    
        $html .= '
            <tr style=" font-weight: bold;">
                <td>TOTAL</td>
                <td>'.$grand_totalCumi.'</td>
                <td>'.$grand_totalFully_paid.'</td>
                <td>'.$grand_totalDeceased.'</td>
                <td>'.$grand_totalGawad.'</td>
                <td>'.$grand_totalBadAccounts.'</td>
                <td>'.$grand_totalTransfer.'</td>
                <td>'.$grand_totalOutgoing.'</td>
                <td>'.$grand_totalFinaCumi.'</td>
            </tr>
        ';

        $html .= '
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
';
        $grand_totalCumi = 0;
        $grand_totalFully_paid = 0;
        $grand_totalDeceased = 0;
        $grand_totalGawad = 0;
        $grand_totalBadAccounts = 0;
        $grand_totalTransfer = 0;
        $grand_totalOutgoing = 0;
        $grand_totalFinaCumi = 0;
        $getRLC = $Operation ->ctrGetAllRLCBranches();
        foreach ($getRLC as $rlc) { 
            $branch_name = $rlc['full_name'];
            $type = "outgoing";
            $get_outgoingBal = $Operation ->ctrGetGrossinBal($branch_name, $type);
            if(!empty($get_outgoingBal)){
                foreach ($get_outgoingBal as $outgoingBal){
                    $amount = $outgoingBal['amount'];
                }
            }else{
                $amount = 0;
            }
                $getOutgoingCumi = $Operation->ctrGetOutgoingCumi($prev, $branch_name);
                if(!empty($getOutgoingCumi)){
                $total_OutgoingCumi = $getOutgoingCumi[0]['total_cumi'];
                }else{
                $total_OutgoingCumi = 0;
                }
                $final_outgoingCumi = $amount + $total_OutgoingCumi;

            $get_outgoingData = $Operation->ctrGetOutgoingData($branch_name, $from, $to);

            if(!empty($get_outgoingData)){
                foreach($get_outgoingData as $outgoingData){
                    $fully_paid = $outgoingData['fully_paid'];
                    $deceased = $outgoingData['deceased'];
                    $gawad = $outgoingData['gawad'];
                    $bad_accounts = $outgoingData['bad_accounts'];
                    $transfer = $outgoingData['transfer'];
                }
                if($fully_paid == 0){
                    $fully_paid = 0; 
                }
                if($deceased == 0){
                    $deceased = 0; 
                }
                if($gawad == 0){
                    $gawad = 0; 
                }
                if($bad_accounts == 0){
                    $bad_accounts = 0; 
                }
                if($transfer == 0){
                    $transfer = 0; 
                }
            }else{
                $fully_paid = 0; 
                $deceased = 0;
                $gawad = 0;
                $bad_accounts = 0;
                $transfer = 0;
            }
            $total_outgoing_cumi = $final_outgoingCumi + $fully_paid + $deceased + $gawad + $bad_accounts + $transfer;
            $total_outgoing = $fully_paid + $deceased + $gawad + $bad_accounts + $transfer;
           
        $html .= '
        <tr>
        <td>'.$branch_name.'</td>
        <td>'.$final_outgoingCumi.'</td>
        <td>'.$fully_paid.'</td>
        <td>'.$deceased.'</td>
        <td>'.$gawad.'</td>
        <td>'.$bad_accounts.'</td>
        <td>'.$transfer.'</td>
        <td>'.$total_outgoing.'</td>
        <td>'.$total_outgoing_cumi.'</td>
    </tr>
        ';
        $grand_totalCumi += $final_outgoingCumi;
        $grand_totalFully_paid+= $fully_paid;
        $grand_totalDeceased += $deceased;
        $grand_totalGawad+= $gawad;
        $grand_totalBadAccounts+= $bad_accounts;
        $grand_totalTransfer += $transfer;
        $grand_totalOutgoing+= $total_outgoing;
        $grand_totalFinaCumi += $total_outgoing_cumi;
    }

    $html .= '
        <tr style=" font-weight: bold;">
            <td>TOTAL</td>
            <td>'.$grand_totalCumi.'</td>
            <td>'.$grand_totalFully_paid.'</td>
            <td>'.$grand_totalDeceased.'</td>
            <td>'.$grand_totalGawad.'</td>
            <td>'.$grand_totalBadAccounts.'</td>
            <td>'.$grand_totalTransfer.'</td>
            <td>'.$grand_totalOutgoing.'</td>
            <td>'.$grand_totalFinaCumi.'</td>
        </tr>
    ';

    $html .= '
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
';
    $grand_totalCumi = 0;
    $grand_totalFully_paid = 0;
    $grand_totalDeceased = 0;
    $grand_totalGawad = 0;
    $grand_totalBadAccounts = 0;
    $grand_totalTransfer = 0;
    $grand_totalOutgoing = 0;
    $grand_totalFinaCumi = 0;
    $getELC = $Operation ->ctrGetAllELCBranches();
    foreach ($getELC as $elc) { 
        $branch_name = $elc['full_name'];
        $type = "outgoing";
        $get_outgoingBal = $Operation ->ctrGetGrossinBal($branch_name, $type);
        if(!empty($get_outgoingBal)){
            foreach ($get_outgoingBal as $outgoingBal){
                $amount = $outgoingBal['amount'];
            }
        }else{
            $amount = 0;
        }
            $getOutgoingCumi = $Operation->ctrGetOutgoingCumi($prev, $branch_name);
            if(!empty($getOutgoingCumi)){
            $total_OutgoingCumi = $getOutgoingCumi[0]['total_cumi'];
            }else{
            $total_OutgoingCumi = 0;
            }
            $final_outgoingCumi = $amount + $total_OutgoingCumi;

        $get_outgoingData = $Operation->ctrGetOutgoingData($branch_name, $from, $to);

        if(!empty($get_outgoingData)){
            foreach($get_outgoingData as $outgoingData){
                $fully_paid = $outgoingData['fully_paid'];
                $deceased = $outgoingData['deceased'];
                $gawad = $outgoingData['gawad'];
                $bad_accounts = $outgoingData['bad_accounts'];
                $transfer = $outgoingData['transfer'];
            }
            if($fully_paid == 0){
                $fully_paid = 0; 
            }
            if($deceased == 0){
                $deceased = 0; 
            }
            if($gawad == 0){
                $gawad = 0; 
            }
            if($bad_accounts == 0){
                $bad_accounts = 0; 
            }
            if($transfer == 0){
                $transfer = 0; 
            }
        }else{
            $fully_paid = 0; 
            $deceased = 0;
            $gawad = 0;
            $bad_accounts = 0;
            $transfer = 0;
        }
        $total_outgoing_cumi = $final_outgoingCumi + $fully_paid + $deceased + $gawad + $bad_accounts + $transfer;
        $total_outgoing = $fully_paid + $deceased + $gawad + $bad_accounts + $transfer;
       
    $html .= '
    <tr>
    <td>'.$branch_name.'</td>
    <td>'.$final_outgoingCumi.'</td>
    <td>'.$fully_paid.'</td>
    <td>'.$deceased.'</td>
    <td>'.$gawad.'</td>
    <td>'.$bad_accounts.'</td>
    <td>'.$transfer.'</td>
    <td>'.$total_outgoing.'</td>
    <td>'.$total_outgoing_cumi.'</td>
</tr>
    ';
    $grand_totalCumi += $final_outgoingCumi;
    $grand_totalFully_paid+= $fully_paid;
    $grand_totalDeceased += $deceased;
    $grand_totalGawad+= $gawad;
    $grand_totalBadAccounts+= $bad_accounts;
    $grand_totalTransfer += $transfer;
    $grand_totalOutgoing+= $total_outgoing;
    $grand_totalFinaCumi += $total_outgoing_cumi;
}

$html .= '
    <tr style=" font-weight: bold;">
        <td>TOTAL</td>
        <td>'.$grand_totalCumi.'</td>
        <td>'.$grand_totalFully_paid.'</td>
        <td>'.$grand_totalDeceased.'</td>
        <td>'.$grand_totalGawad.'</td>
        <td>'.$grand_totalBadAccounts.'</td>
        <td>'.$grand_totalTransfer.'</td>
        <td>'.$grand_totalOutgoing.'</td>
        <td>'.$grand_totalFinaCumi.'</td>
    </tr>
    </tbody>        
';

    
        
    
                echo json_encode(['card' => $html]);
            }



            public function showLsorReport(){
                $Operation = new ControllerOperation();
        
        
                $month = $_GET['month'];
                $conMonth = date("F Y", strtotime($month));
                $prevMonth = date("M Y", strtotime("-1 month", strtotime($month)));
                $firstMonth = date("M", strtotime("1st month", strtotime($month)));

                // Get the first day of the month
                $firstDay = date('Y-m-01', strtotime($month));
                // Get the last day of the month
                $lastDay = date('Y-m-t', strtotime($month));
                            
                    $html = '';
        
                    $html .= '
                     
                    <thead>
                    <tr>
                        <th style="border-style: none;"><h5>FOR THE MONTH OF '.$conMonth.'</h5></th>
                     </tr>
                 
                    <tr>
                        <th rowspan="2" style="text-align: center; vertical-align: middle; font-size: 15px; margin-bottom: 20px;">BRANCH</th>
                        <th rowspan="2" style="text-align: center; vertical-align: middle; font-size: 12px; margin-bottom: 20px;">as of '.$firstMonth.' - '.$prevMonth.'</th>
                        <th>FINANCIALLY STABLE</th>
                        <th>APPROVAL WIFE AND CHILDREN</th>
                        <th>LOW CASH OUT</th>
                        <th>EXISTING LOAN TO OTHER LENDING</th>
                        <th>OTHER LENDING RE-SCHED GAWAD</th>
                        <th>OTHER LENDING SCHED GAWAD</th>
                        <th>SCHEDULED TO APPLY LOAN</th>
                        <th>SSP OVER AGE</th>
                        <th>LACK OF REQUIREMENTS</th>
                        <th>UNDECIDED</th>
                        <th>REFUSE TO TRANSFER ACCOUNT/LOAN</th>
                        <th>INQUIRED ONLY</th>
                        <th>NEW POLICY</th>
                        <th>NOT IN GOOD CONDITION</th>
                        <th>GUARDIANSHIP</th>
                        <th>PLP</th>
                        <th>SSP NOT QUALIFIED</th>
                        <th>18 MOS SSSS LOAN</th>
                        <th>PENSION STILL ON PROCESS</th>
                        <th>TOTAL</th>
                    </tr>
                </thead>
                <tbody>';
                $getEMB = $Operation ->ctrGetAllEMBBranches();
                $html .=' 
                    <tr>
                        <td colspan="22" style="font-weight: bold;">EMB</td>
                    </tr>
                
                ';

                $grandTotal_LSORBegin = 0;
                $grandTotal_fin_stable = 0;
                $grandTotal_app_wc = 0;
                $grandTotal_low_cashout = 0;
                $grandTotal_existing_loan = 0;
                $grandTotal_other_resched_gawad = 0;
                $grandTotal_other_sched_gawad = 0;
                $grandTotal_sched_applynow= 0;
                $grandTotal_ssp_overage = 0;
                $grandTotal_lack_requirements = 0;
                $grandTotal_undecided = 0;
                $grandTotal_refuse_transfer = 0;
                $grandTotal_inquired_only = 0;
                $grandTotal_new_policy= 0;
                $grandTotal_not_goodcondition = 0;
                $grandTotal_guardianship= 0;
                $grandTotal_plp = 0;
                $grandTotal_not_qualified = 0;
                $grandTotal_eighteen_mos_sssloan = 0;
                $grandTotal_on_process = 0;
                $grandTotal_total = 0;

                $total_LSORBegin = 0;
                $total_fin_stable = 0;
                $total_app_wc = 0;
                $total_low_cashout = 0;
                $total_existing_loan = 0;
                $total_other_resched_gawad = 0;
                $total_other_sched_gawad = 0;
                $total_sched_applynow= 0;
                $total_ssp_overage = 0;
                $total_lack_requirements = 0;
                $total_undecided = 0;
                $total_refuse_transfer = 0;
                $total_inquired_only = 0;
                $total_new_policy= 0;
                $total_not_goodcondition = 0;
                $total_guardianship= 0;
                $total_plp = 0;
                $total_not_qualified = 0;
                $total_eighteen_mos_sssloan = 0;
                $total_on_process = 0;
                $grand_total = 0;
                  foreach($getEMB as $emb){
                    $branch_name = $emb['full_name'];
                    $getLSOP = $Operation->ctrGetBeginLSORReport($branch_name, $month);
                    if(!empty($getLSOP)){
                        foreach($getLSOP as $begin){
                            $LSORBegin = $begin['amount'];
                        }
                    }else{
                        $LSORBegin = 0;
                    }

                    $getLSOR = $Operation->ctrGetAllLSOR($branch_name, $firstDay, $lastDay);
                    foreach($getLSOR as $LSOR){
                        $fin_stable = $LSOR['fin_stable'];
                        $app_wc = $LSOR['app_wc'];
                        $low_cashout = $LSOR['low_cashout'];
                        $existing_loan = $LSOR['existing_loan'];
                        $other_resched_gawad = $LSOR['other_resched_gawad'];
                        $other_sched_gawad = $LSOR['other_sched_gawad'];
                        $sched_applynow = $LSOR['sched_applynow'];
                        $ssp_overage = $LSOR['ssp_overage'];
                        $lack_requirements = $LSOR['lack_requirements'];
                        $undecided = $LSOR['undecided'];
                        $refuse_transfer = $LSOR['refuse_transfer'];
                        $inquired_only = $LSOR['inquired_only'];
                        $new_policy = $LSOR['new_policy'];
                        $not_goodcondition = $LSOR['not_goodcondition'];
                        $guardianship = $LSOR['guardianship'];
                        $plp = $LSOR['plp'];
                        $not_qualified = $LSOR['not_qualified'];
                        $eighteen_mos_sssloan = $LSOR['eighteen_mos_sssloan'];
                        $on_process = $LSOR['on_process'];
                    }

                    // $fin_stable = $fin_stable ?? 0;
                    // $app_wc = $app_wc ?? 0;
                    // $low_cashout = $low_cashout ?? 0;
                    // $existing_loan = $existing_loan ?? 0;
                    // $other_resched_gawad = $other_resched_gawad ?? 0;
                    // $other_sched_gawad = $other_sched_gawad ?? 0;
                    // $sched_applynow = $sched_applynow ?? 0;
                    // $ssp_overage = $ssp_overage ?? 0;
                    // $lack_requirements = $lack_requirements ?? 0;
                    // $undecided = $undecided ?? 0;
                    // $refuse_transfer = $refuse_transfer ?? 0;
                    // $inquired_only = $inquired_only ?? 0;
                    // $new_policy = $new_policy ?? 0;
                    // $not_goodcondition = $not_goodcondition ?? 0;
                    // $guardianship = $guardianship ?? 0;
                    // $plp = $plp ?? 0;
                    // $not_qualified = $not_qualified ?? 0;
                    // $eighteen_mos_sssloan = $eighteen_mos_sssloan ?? 0;
                    // $on_process = $on_process ?? 0;

                    $total = $fin_stable + $app_wc + $low_cashout + $existing_loan + $other_resched_gawad + $other_sched_gawad + $sched_applynow + $ssp_overage + $lack_requirements +
                    $undecided + $refuse_transfer + $inquired_only + $new_policy + $not_goodcondition + $guardianship + $plp + $not_qualified + $eighteen_mos_sssloan + $on_process;
                    
                    $total_LSORBegin +=$LSORBegin;
                    $total_fin_stable +=$fin_stable;
                    $total_app_wc +=$app_wc;
                    $total_low_cashout +=$low_cashout;
                    $total_existing_loan +=$existing_loan;
                    $total_other_resched_gawad +=$other_resched_gawad;
                    $total_other_sched_gawad+=$other_sched_gawad;
                    $total_sched_applynow +=$sched_applynow;
                    $total_ssp_overage +=$ssp_overage;
                    $total_lack_requirements +=$lack_requirements;
                    $total_undecided +=$undecided;
                    $total_refuse_transfer +=$refuse_transfer;
                    $total_inquired_only +=$inquired_only;
                    $total_new_policy +=$new_policy;
                    $total_not_goodcondition +=$not_goodcondition;
                    $total_guardianship +=$guardianship;
                    $total_plp +=$plp;
                    $total_not_qualified +=$not_qualified;
                    $total_eighteen_mos_sssloan +=$eighteen_mos_sssloan;
                    $total_on_process +=$on_process;
                    $grand_total +=$total;


             
                    

                $html .='
                            <tr>
                                <td>'.$branch_name.'</td>
                                <td>'.$LSORBegin.'</td>
                                <td>'.$fin_stable.'</td>
                                <td>'.$app_wc.'</td>
                                <td>'.$low_cashout.'</td>
                                <td>'.$existing_loan.'</td>
                                <td>'.$other_resched_gawad.'</td>
                                <td>'.$other_sched_gawad.'</td>
                                <td>'.$sched_applynow.'</td>
                                <td>'.$ssp_overage.'</td>
                                <td>'.$lack_requirements.'</td>
                                <td>'.$undecided.'</td>
                                <td>'.$refuse_transfer.'</td>
                                <td>'.$inquired_only.'</td>
                                <td>'.$new_policy.'</td>
                                <td>'.$not_goodcondition.'</td>
                                <td>'.$guardianship.'</td>
                                <td>'.$plp.'</td>
                                <td>'.$not_qualified.'</td>
                                <td>'.$eighteen_mos_sssloan.'</td>
                                <td>'.$on_process.'</td>
                                <td>'.$total.'</td>
                            </tr>';

                        }
                        $grandTotal_LSORBegin += $total_LSORBegin;
                        $grandTotal_fin_stable  += $total_fin_stable;
                        $grandTotal_app_wc  += $total_app_wc;
                        $grandTotal_low_cashout  += $total_low_cashout;
                        $grandTotal_existing_loan  += $total_existing_loan;
                        $grandTotal_other_resched_gawad  += $total_other_resched_gawad;
                        $grandTotal_other_sched_gawad  += $total_other_sched_gawad;
                        $grandTotal_sched_applynow += $total_sched_applynow;
                        $grandTotal_ssp_overage  += $total_ssp_overage;
                        $grandTotal_lack_requirements  += $total_lack_requirements;
                        $grandTotal_undecided  += $total_undecided;
                        $grandTotal_refuse_transfer  += $total_refuse_transfer;
                        $grandTotal_inquired_only  += $total_inquired_only;
                        $grandTotal_new_policy += $total_new_policy;
                        $grandTotal_not_goodcondition  += $total_not_goodcondition;
                        $grandTotal_guardianship += $total_guardianship;
                        $grandTotal_plp  += $total_plp;
                        $grandTotal_not_qualified  += $total_not_qualified;
                        $grandTotal_eighteen_mos_sssloan  += $total_eighteen_mos_sssloan;
                        $grandTotal_on_process  += $total_on_process;
                        $grandTotal_total  += $grand_total;
                $html .='
                            <tr>
                                <td>TOTAL</td>
                                <td>'.$total_LSORBegin.'</td>
                                <td>'.$total_fin_stable.'</td>
                                <td>'.$total_app_wc.'</td>
                                <td>'.$total_low_cashout.'</td>
                                <td>'.$total_existing_loan.'</td>
                                <td>'.$total_other_resched_gawad.'</td>
                                <td>'.$total_other_sched_gawad.'</td>
                                <td>'.$total_sched_applynow.'</td>
                                <td>'.$total_ssp_overage.'</td>
                                <td>'.$total_lack_requirements.'</td>
                                <td>'.$total_undecided.'</td>
                                <td>'.$total_refuse_transfer.'</td>
                                <td>'.$total_inquired_only.'</td>
                                <td>'.$total_new_policy.'</td>
                                <td>'.$total_not_goodcondition.'</td>
                                <td>'.$total_guardianship.'</td>
                                <td>'.$total_plp.'</td>
                                <td>'.$total_not_qualified.'</td>
                                <td>'.$total_eighteen_mos_sssloan.'</td>
                                <td>'.$total_on_process.'</td>
                                <td>'.$grand_total.'</td>
                        </tr>   
                ';
                $getFCH= $Operation ->ctrGetAllFCHBranches();
                $html .=' 
                    <tr>
                        <td colspan="22" style="font-weight: bold;">FCH</td>
                    </tr>
                
                ';
                $total_LSORBegin = 0;
                $total_fin_stable = 0;
                $total_app_wc = 0;
                $total_low_cashout = 0;
                $total_existing_loan = 0;
                $total_other_resched_gawad = 0;
                $total_other_sched_gawad = 0;
                $total_sched_applynow= 0;
                $total_ssp_overage = 0;
                $total_lack_requirements = 0;
                $total_undecided = 0;
                $total_refuse_transfer = 0;
                $total_inquired_only = 0;
                $total_new_policy= 0;
                $total_not_goodcondition = 0;
                $total_guardianship= 0;
                $total_plp = 0;
                $total_not_qualified = 0;
                $total_eighteen_mos_sssloan = 0;
                $total_on_process = 0;
                $grand_total = 0;
                  foreach($getFCH as $fch){
                    $branch_name = $fch['full_name'];
                    $getLSOP = $Operation->ctrGetBeginLSORReport($branch_name, $month);
                    if(!empty($getLSOP)){
                        foreach($getLSOP as $begin){
                            $LSORBegin = $begin['amount'];
                        }
                    }else{
                        $LSORBegin = 0;
                    }

                    $getLSOR = $Operation->ctrGetAllLSOR($branch_name, $firstDay, $lastDay);
                    foreach($getLSOR as $LSOR){
                        $fin_stable = $LSOR['fin_stable'];
                        $app_wc = $LSOR['app_wc'];
                        $low_cashout = $LSOR['low_cashout'];
                        $existing_loan = $LSOR['existing_loan'];
                        $other_resched_gawad = $LSOR['other_resched_gawad'];
                        $other_sched_gawad = $LSOR['other_sched_gawad'];
                        $sched_applynow = $LSOR['sched_applynow'];
                        $ssp_overage = $LSOR['ssp_overage'];
                        $lack_requirements = $LSOR['lack_requirements'];
                        $undecided = $LSOR['undecided'];
                        $refuse_transfer = $LSOR['refuse_transfer'];
                        $inquired_only = $LSOR['inquired_only'];
                        $new_policy = $LSOR['new_policy'];
                        $not_goodcondition = $LSOR['not_goodcondition'];
                        $guardianship = $LSOR['guardianship'];
                        $plp = $LSOR['plp'];
                        $not_qualified = $LSOR['not_qualified'];
                        $eighteen_mos_sssloan = $LSOR['eighteen_mos_sssloan'];
                        $on_process = $LSOR['on_process'];
                    }

                    // $fin_stable = $fin_stable ?? 0;
                    // $app_wc = $app_wc ?? 0;
                    // $low_cashout = $low_cashout ?? 0;
                    // $existing_loan = $existing_loan ?? 0;
                    // $other_resched_gawad = $other_resched_gawad ?? 0;
                    // $other_sched_gawad = $other_sched_gawad ?? 0;
                    // $sched_applynow = $sched_applynow ?? 0;
                    // $ssp_overage = $ssp_overage ?? 0;
                    // $lack_requirements = $lack_requirements ?? 0;
                    // $undecided = $undecided ?? 0;
                    // $refuse_transfer = $refuse_transfer ?? 0;
                    // $inquired_only = $inquired_only ?? 0;
                    // $new_policy = $new_policy ?? 0;
                    // $not_goodcondition = $not_goodcondition ?? 0;
                    // $guardianship = $guardianship ?? 0;
                    // $plp = $plp ?? 0;
                    // $not_qualified = $not_qualified ?? 0;
                    // $eighteen_mos_sssloan = $eighteen_mos_sssloan ?? 0;
                    // $on_process = $on_process ?? 0;

                    $total = $fin_stable + $app_wc + $low_cashout + $existing_loan + $other_resched_gawad + $other_sched_gawad + $sched_applynow + $ssp_overage + $lack_requirements +
                    $undecided + $refuse_transfer + $inquired_only + $new_policy + $not_goodcondition + $guardianship + $plp + $not_qualified + $eighteen_mos_sssloan + $on_process;
                    
                    $total_LSORBegin +=$LSORBegin;
                    $total_fin_stable +=$fin_stable;
                    $total_app_wc +=$app_wc;
                    $total_low_cashout +=$low_cashout;
                    $total_existing_loan +=$existing_loan;
                    $total_other_resched_gawad +=$other_resched_gawad;
                    $total_other_sched_gawad+=$other_sched_gawad;
                    $total_sched_applynow +=$sched_applynow;
                    $total_ssp_overage +=$ssp_overage;
                    $total_lack_requirements +=$lack_requirements;
                    $total_undecided +=$undecided;
                    $total_refuse_transfer +=$refuse_transfer;
                    $total_inquired_only +=$inquired_only;
                    $total_new_policy +=$new_policy;
                    $total_not_goodcondition +=$not_goodcondition;
                    $total_guardianship +=$guardianship;
                    $total_plp +=$plp;
                    $total_not_qualified +=$not_qualified;
                    $total_eighteen_mos_sssloan +=$eighteen_mos_sssloan;
                    $total_on_process +=$on_process;
                    $grand_total +=$total;
                    

                $html .='
                            <tr>
                                <td>'.$branch_name.'</td>
                                <td>'.$LSORBegin.'</td>
                                <td>'.$fin_stable.'</td>
                                <td>'.$app_wc.'</td>
                                <td>'.$low_cashout.'</td>
                                <td>'.$existing_loan.'</td>
                                <td>'.$other_resched_gawad.'</td>
                                <td>'.$other_sched_gawad.'</td>
                                <td>'.$sched_applynow.'</td>
                                <td>'.$ssp_overage.'</td>
                                <td>'.$lack_requirements.'</td>
                                <td>'.$undecided.'</td>
                                <td>'.$refuse_transfer.'</td>
                                <td>'.$inquired_only.'</td>
                                <td>'.$new_policy.'</td>
                                <td>'.$not_goodcondition.'</td>
                                <td>'.$guardianship.'</td>
                                <td>'.$plp.'</td>
                                <td>'.$not_qualified.'</td>
                                <td>'.$eighteen_mos_sssloan.'</td>
                                <td>'.$on_process.'</td>
                                <td>'.$total.'</td>
                            </tr>';

                        }
                $html .='
                            <tr>
                                <td>TOTAL</td>
                                <td>'.$total_LSORBegin.'</td>
                                <td>'.$total_fin_stable.'</td>
                                <td>'.$total_app_wc.'</td>
                                <td>'.$total_low_cashout.'</td>
                                <td>'.$total_existing_loan.'</td>
                                <td>'.$total_other_resched_gawad.'</td>
                                <td>'.$total_other_sched_gawad.'</td>
                                <td>'.$total_sched_applynow.'</td>
                                <td>'.$total_ssp_overage.'</td>
                                <td>'.$total_lack_requirements.'</td>
                                <td>'.$total_undecided.'</td>
                                <td>'.$total_refuse_transfer.'</td>
                                <td>'.$total_inquired_only.'</td>
                                <td>'.$total_new_policy.'</td>
                                <td>'.$total_not_goodcondition.'</td>
                                <td>'.$total_guardianship.'</td>
                                <td>'.$total_plp.'</td>
                                <td>'.$total_not_qualified.'</td>
                                <td>'.$total_eighteen_mos_sssloan.'</td>
                                <td>'.$total_on_process.'</td>
                                <td>'.$grand_total.'</td>
                        </tr>   
                       
                ';
                         $grandTotal_LSORBegin += $total_LSORBegin;
                        $grandTotal_fin_stable  += $total_fin_stable;
                        $grandTotal_app_wc  += $total_app_wc;
                        $grandTotal_low_cashout  += $total_low_cashout;
                        $grandTotal_existing_loan  += $total_existing_loan;
                        $grandTotal_other_resched_gawad  += $total_other_resched_gawad;
                        $grandTotal_other_sched_gawad  += $total_other_sched_gawad;
                        $grandTotal_sched_applynow += $total_sched_applynow;
                        $grandTotal_ssp_overage  += $total_ssp_overage;
                        $grandTotal_lack_requirements  += $total_lack_requirements;
                        $grandTotal_undecided  += $total_undecided;
                        $grandTotal_refuse_transfer  += $total_refuse_transfer;
                        $grandTotal_inquired_only  += $total_inquired_only;
                        $grandTotal_new_policy += $total_new_policy;
                        $grandTotal_not_goodcondition  += $total_not_goodcondition;
                        $grandTotal_guardianship += $total_guardianship;
                        $grandTotal_plp  += $total_plp;
                        $grandTotal_not_qualified  += $total_not_qualified;
                        $grandTotal_eighteen_mos_sssloan  += $total_eighteen_mos_sssloan;
                        $grandTotal_on_process  += $total_on_process;
                        $grandTotal_total  += $grand_total;
                $getRLC= $Operation ->ctrGetAllRLCBranches();
                $html .=' 
                    <tr>
                        <td colspan="22" style="font-weight: bold;">RLC</td>
                    </tr>
                
                ';
                $total_LSORBegin = 0;
                $total_fin_stable = 0;
                $total_app_wc = 0;
                $total_low_cashout = 0;
                $total_existing_loan = 0;
                $total_other_resched_gawad = 0;
                $total_other_sched_gawad = 0;
                $total_sched_applynow= 0;
                $total_ssp_overage = 0;
                $total_lack_requirements = 0;
                $total_undecided = 0;
                $total_refuse_transfer = 0;
                $total_inquired_only = 0;
                $total_new_policy= 0;
                $total_not_goodcondition = 0;
                $total_guardianship= 0;
                $total_plp = 0;
                $total_not_qualified = 0;
                $total_eighteen_mos_sssloan = 0;
                $total_on_process = 0;
                $grand_total = 0;
                  foreach($getRLC as $rlc){
                    $branch_name = $rlc['full_name'];
                    $getLSOP = $Operation->ctrGetBeginLSORReport($branch_name, $month);
                    if(!empty($getLSOP)){
                        foreach($getLSOP as $begin){
                            $LSORBegin = $begin['amount'];
                        }
                    }else{
                        $LSORBegin = 0;
                    }

                    $getLSOR = $Operation->ctrGetAllLSOR($branch_name, $firstDay, $lastDay);
                    foreach($getLSOR as $LSOR){
                        $fin_stable = $LSOR['fin_stable'];
                        $app_wc = $LSOR['app_wc'];
                        $low_cashout = $LSOR['low_cashout'];
                        $existing_loan = $LSOR['existing_loan'];
                        $other_resched_gawad = $LSOR['other_resched_gawad'];
                        $other_sched_gawad = $LSOR['other_sched_gawad'];
                        $sched_applynow = $LSOR['sched_applynow'];
                        $ssp_overage = $LSOR['ssp_overage'];
                        $lack_requirements = $LSOR['lack_requirements'];
                        $undecided = $LSOR['undecided'];
                        $refuse_transfer = $LSOR['refuse_transfer'];
                        $inquired_only = $LSOR['inquired_only'];
                        $new_policy = $LSOR['new_policy'];
                        $not_goodcondition = $LSOR['not_goodcondition'];
                        $guardianship = $LSOR['guardianship'];
                        $plp = $LSOR['plp'];
                        $not_qualified = $LSOR['not_qualified'];
                        $eighteen_mos_sssloan = $LSOR['eighteen_mos_sssloan'];
                        $on_process = $LSOR['on_process'];
                    }

                    // $fin_stable = $fin_stable ?? 0;
                    // $app_wc = $app_wc ?? 0;
                    // $low_cashout = $low_cashout ?? 0;
                    // $existing_loan = $existing_loan ?? 0;
                    // $other_resched_gawad = $other_resched_gawad ?? 0;
                    // $other_sched_gawad = $other_sched_gawad ?? 0;
                    // $sched_applynow = $sched_applynow ?? 0;
                    // $ssp_overage = $ssp_overage ?? 0;
                    // $lack_requirements = $lack_requirements ?? 0;
                    // $undecided = $undecided ?? 0;
                    // $refuse_transfer = $refuse_transfer ?? 0;
                    // $inquired_only = $inquired_only ?? 0;
                    // $new_policy = $new_policy ?? 0;
                    // $not_goodcondition = $not_goodcondition ?? 0;
                    // $guardianship = $guardianship ?? 0;
                    // $plp = $plp ?? 0;
                    // $not_qualified = $not_qualified ?? 0;
                    // $eighteen_mos_sssloan = $eighteen_mos_sssloan ?? 0;
                    // $on_process = $on_process ?? 0;

                    $total = $fin_stable + $app_wc + $low_cashout + $existing_loan + $other_resched_gawad + $other_sched_gawad + $sched_applynow + $ssp_overage + $lack_requirements +
                    $undecided + $refuse_transfer + $inquired_only + $new_policy + $not_goodcondition + $guardianship + $plp + $not_qualified + $eighteen_mos_sssloan + $on_process;
                    
                    $total_LSORBegin +=$LSORBegin;
                    $total_fin_stable +=$fin_stable;
                    $total_app_wc +=$app_wc;
                    $total_low_cashout +=$low_cashout;
                    $total_existing_loan +=$existing_loan;
                    $total_other_resched_gawad +=$other_resched_gawad;
                    $total_other_sched_gawad+=$other_sched_gawad;
                    $total_sched_applynow +=$sched_applynow;
                    $total_ssp_overage +=$ssp_overage;
                    $total_lack_requirements +=$lack_requirements;
                    $total_undecided +=$undecided;
                    $total_refuse_transfer +=$refuse_transfer;
                    $total_inquired_only +=$inquired_only;
                    $total_new_policy +=$new_policy;
                    $total_not_goodcondition +=$not_goodcondition;
                    $total_guardianship +=$guardianship;
                    $total_plp +=$plp;
                    $total_not_qualified +=$not_qualified;
                    $total_eighteen_mos_sssloan +=$eighteen_mos_sssloan;
                    $total_on_process +=$on_process;
                    $grand_total +=$total;
                    

                $html .='
                            <tr>
                                <td>'.$branch_name.'</td>
                                <td>'.$LSORBegin.'</td>
                                <td>'.$fin_stable.'</td>
                                <td>'.$app_wc.'</td>
                                <td>'.$low_cashout.'</td>
                                <td>'.$existing_loan.'</td>
                                <td>'.$other_resched_gawad.'</td>
                                <td>'.$other_sched_gawad.'</td>
                                <td>'.$sched_applynow.'</td>
                                <td>'.$ssp_overage.'</td>
                                <td>'.$lack_requirements.'</td>
                                <td>'.$undecided.'</td>
                                <td>'.$refuse_transfer.'</td>
                                <td>'.$inquired_only.'</td>
                                <td>'.$new_policy.'</td>
                                <td>'.$not_goodcondition.'</td>
                                <td>'.$guardianship.'</td>
                                <td>'.$plp.'</td>
                                <td>'.$not_qualified.'</td>
                                <td>'.$eighteen_mos_sssloan.'</td>
                                <td>'.$on_process.'</td>
                                <td>'.$total.'</td>
                            </tr>';

                        }
                $html .='
                            <tr>
                                <td>TOTAL</td>
                                <td>'.$total_LSORBegin.'</td>
                                <td>'.$total_fin_stable.'</td>
                                <td>'.$total_app_wc.'</td>
                                <td>'.$total_low_cashout.'</td>
                                <td>'.$total_existing_loan.'</td>
                                <td>'.$total_other_resched_gawad.'</td>
                                <td>'.$total_other_sched_gawad.'</td>
                                <td>'.$total_sched_applynow.'</td>
                                <td>'.$total_ssp_overage.'</td>
                                <td>'.$total_lack_requirements.'</td>
                                <td>'.$total_undecided.'</td>
                                <td>'.$total_refuse_transfer.'</td>
                                <td>'.$total_inquired_only.'</td>
                                <td>'.$total_new_policy.'</td>
                                <td>'.$total_not_goodcondition.'</td>
                                <td>'.$total_guardianship.'</td>
                                <td>'.$total_plp.'</td>
                                <td>'.$total_not_qualified.'</td>
                                <td>'.$total_eighteen_mos_sssloan.'</td>
                                <td>'.$total_on_process.'</td>
                                <td>'.$grand_total.'</td>
                        </tr>   
                ';
                $grandTotal_LSORBegin += $total_LSORBegin;
                $grandTotal_fin_stable  += $total_fin_stable;
                $grandTotal_app_wc  += $total_app_wc;
                $grandTotal_low_cashout  += $total_low_cashout;
                $grandTotal_existing_loan  += $total_existing_loan;
                $grandTotal_other_resched_gawad  += $total_other_resched_gawad;
                $grandTotal_other_sched_gawad  += $total_other_sched_gawad;
                $grandTotal_sched_applynow += $total_sched_applynow;
                $grandTotal_ssp_overage  += $total_ssp_overage;
                $grandTotal_lack_requirements  += $total_lack_requirements;
                $grandTotal_undecided  += $total_undecided;
                $grandTotal_refuse_transfer  += $total_refuse_transfer;
                $grandTotal_inquired_only  += $total_inquired_only;
                $grandTotal_new_policy += $total_new_policy;
                $grandTotal_not_goodcondition  += $total_not_goodcondition;
                $grandTotal_guardianship += $total_guardianship;
                $grandTotal_plp  += $total_plp;
                $grandTotal_not_qualified  += $total_not_qualified;
                $grandTotal_eighteen_mos_sssloan  += $total_eighteen_mos_sssloan;
                $grandTotal_on_process  += $total_on_process;
                $grandTotal_total  += $grand_total;

                $getELC= $Operation ->ctrGetAllELCBranches();
                $html .=' 
                    <tr>
                        <td colspan="22" style="font-weight: bold;">ELC</td>
                    </tr>
                
                ';
                $total_LSORBegin = 0;
                $total_fin_stable = 0;
                $total_app_wc = 0;
                $total_low_cashout = 0;
                $total_existing_loan = 0;
                $total_other_resched_gawad = 0;
                $total_other_sched_gawad = 0;
                $total_sched_applynow= 0;
                $total_ssp_overage = 0;
                $total_lack_requirements = 0;
                $total_undecided = 0;
                $total_refuse_transfer = 0;
                $total_inquired_only = 0;
                $total_new_policy= 0;
                $total_not_goodcondition = 0;
                $total_guardianship= 0;
                $total_plp = 0;
                $total_not_qualified = 0;
                $total_eighteen_mos_sssloan = 0;
                $total_on_process = 0;
                $grand_total = 0;
                  foreach($getELC as $elc){
                    $branch_name = $elc['full_name'];
                    $getLSOP = $Operation->ctrGetBeginLSORReport($branch_name, $month);
                    if(!empty($getLSOP)){
                        foreach($getLSOP as $begin){
                            $LSORBegin = $begin['amount'];
                        }
                    }else{
                        $LSORBegin = 0;
                    }

                    $getLSOR = $Operation->ctrGetAllLSOR($branch_name, $firstDay, $lastDay);
                    foreach($getLSOR as $LSOR){
                        $fin_stable = $LSOR['fin_stable'];
                        $app_wc = $LSOR['app_wc'];
                        $low_cashout = $LSOR['low_cashout'];
                        $existing_loan = $LSOR['existing_loan'];
                        $other_resched_gawad = $LSOR['other_resched_gawad'];
                        $other_sched_gawad = $LSOR['other_sched_gawad'];
                        $sched_applynow = $LSOR['sched_applynow'];
                        $ssp_overage = $LSOR['ssp_overage'];
                        $lack_requirements = $LSOR['lack_requirements'];
                        $undecided = $LSOR['undecided'];
                        $refuse_transfer = $LSOR['refuse_transfer'];
                        $inquired_only = $LSOR['inquired_only'];
                        $new_policy = $LSOR['new_policy'];
                        $not_goodcondition = $LSOR['not_goodcondition'];
                        $guardianship = $LSOR['guardianship'];
                        $plp = $LSOR['plp'];
                        $not_qualified = $LSOR['not_qualified'];
                        $eighteen_mos_sssloan = $LSOR['eighteen_mos_sssloan'];
                        $on_process = $LSOR['on_process'];
                    }

                    // $fin_stable = $fin_stable ?? 0;
                    // $app_wc = $app_wc ?? 0;
                    // $low_cashout = $low_cashout ?? 0;
                    // $existing_loan = $existing_loan ?? 0;
                    // $other_resched_gawad = $other_resched_gawad ?? 0;
                    // $other_sched_gawad = $other_sched_gawad ?? 0;
                    // $sched_applynow = $sched_applynow ?? 0;
                    // $ssp_overage = $ssp_overage ?? 0;
                    // $lack_requirements = $lack_requirements ?? 0;
                    // $undecided = $undecided ?? 0;
                    // $refuse_transfer = $refuse_transfer ?? 0;
                    // $inquired_only = $inquired_only ?? 0;
                    // $new_policy = $new_policy ?? 0;
                    // $not_goodcondition = $not_goodcondition ?? 0;
                    // $guardianship = $guardianship ?? 0;
                    // $plp = $plp ?? 0;
                    // $not_qualified = $not_qualified ?? 0;
                    // $eighteen_mos_sssloan = $eighteen_mos_sssloan ?? 0;
                    // $on_process = $on_process ?? 0;

                    $total = $fin_stable + $app_wc + $low_cashout + $existing_loan + $other_resched_gawad + $other_sched_gawad + $sched_applynow + $ssp_overage + $lack_requirements +
                    $undecided + $refuse_transfer + $inquired_only + $new_policy + $not_goodcondition + $guardianship + $plp + $not_qualified + $eighteen_mos_sssloan + $on_process;
                    
                    $total_LSORBegin +=$LSORBegin;
                    $total_fin_stable +=$fin_stable;
                    $total_app_wc +=$app_wc;
                    $total_low_cashout +=$low_cashout;
                    $total_existing_loan +=$existing_loan;
                    $total_other_resched_gawad +=$other_resched_gawad;
                    $total_other_sched_gawad+=$other_sched_gawad;
                    $total_sched_applynow +=$sched_applynow;
                    $total_ssp_overage +=$ssp_overage;
                    $total_lack_requirements +=$lack_requirements;
                    $total_undecided +=$undecided;
                    $total_refuse_transfer +=$refuse_transfer;
                    $total_inquired_only +=$inquired_only;
                    $total_new_policy +=$new_policy;
                    $total_not_goodcondition +=$not_goodcondition;
                    $total_guardianship +=$guardianship;
                    $total_plp +=$plp;
                    $total_not_qualified +=$not_qualified;
                    $total_eighteen_mos_sssloan +=$eighteen_mos_sssloan;
                    $total_on_process +=$on_process;
                    $grand_total +=$total;
                    

                $html .='
                            <tr>
                                <td>'.$branch_name.'</td>
                                <td>'.$LSORBegin.'</td>
                                <td>'.$fin_stable.'</td>
                                <td>'.$app_wc.'</td>
                                <td>'.$low_cashout.'</td>
                                <td>'.$existing_loan.'</td>
                                <td>'.$other_resched_gawad.'</td>
                                <td>'.$other_sched_gawad.'</td>
                                <td>'.$sched_applynow.'</td>
                                <td>'.$ssp_overage.'</td>
                                <td>'.$lack_requirements.'</td>
                                <td>'.$undecided.'</td>
                                <td>'.$refuse_transfer.'</td>
                                <td>'.$inquired_only.'</td>
                                <td>'.$new_policy.'</td>
                                <td>'.$not_goodcondition.'</td>
                                <td>'.$guardianship.'</td>
                                <td>'.$plp.'</td>
                                <td>'.$not_qualified.'</td>
                                <td>'.$eighteen_mos_sssloan.'</td>
                                <td>'.$on_process.'</td>
                                <td>'.$total.'</td>
                            </tr>';

                        }
                        $grandTotal_LSORBegin += $total_LSORBegin;
                        $grandTotal_fin_stable  += $total_fin_stable;
                        $grandTotal_app_wc  += $total_app_wc;
                        $grandTotal_low_cashout  += $total_low_cashout;
                        $grandTotal_existing_loan  += $total_existing_loan;
                        $grandTotal_other_resched_gawad  += $total_other_resched_gawad;
                        $grandTotal_other_sched_gawad  += $total_other_sched_gawad;
                        $grandTotal_sched_applynow += $total_sched_applynow;
                        $grandTotal_ssp_overage  += $total_ssp_overage;
                        $grandTotal_lack_requirements  += $total_lack_requirements;
                        $grandTotal_undecided  += $total_undecided;
                        $grandTotal_refuse_transfer  += $total_refuse_transfer;
                        $grandTotal_inquired_only  += $total_inquired_only;
                        $grandTotal_new_policy += $total_new_policy;
                        $grandTotal_not_goodcondition  += $total_not_goodcondition;
                        $grandTotal_guardianship += $total_guardianship;
                        $grandTotal_plp  += $total_plp;
                        $grandTotal_not_qualified  += $total_not_qualified;
                        $grandTotal_eighteen_mos_sssloan  += $total_eighteen_mos_sssloan;
                        $grandTotal_on_process  += $total_on_process;
                        $grandTotal_total  += $grand_total;
                $html .='
                            <tr>
                                <td>TOTAL</td>
                                <td>'.$total_LSORBegin.'</td>
                                <td>'.$total_fin_stable.'</td>
                                <td>'.$total_app_wc.'</td>
                                <td>'.$total_low_cashout.'</td>
                                <td>'.$total_existing_loan.'</td>
                                <td>'.$total_other_resched_gawad.'</td>
                                <td>'.$total_other_sched_gawad.'</td>
                                <td>'.$total_sched_applynow.'</td>
                                <td>'.$total_ssp_overage.'</td>
                                <td>'.$total_lack_requirements.'</td>
                                <td>'.$total_undecided.'</td>
                                <td>'.$total_refuse_transfer.'</td>
                                <td>'.$total_inquired_only.'</td>
                                <td>'.$total_new_policy.'</td>
                                <td>'.$total_not_goodcondition.'</td>
                                <td>'.$total_guardianship.'</td>
                                <td>'.$total_plp.'</td>
                                <td>'.$total_not_qualified.'</td>
                                <td>'.$total_eighteen_mos_sssloan.'</td>
                                <td>'.$total_on_process.'</td>
                                <td>'.$grand_total.'</td>
                        </tr>   
                        <tr>
                            <td>GRAND TOTAL</td>
                            <td>'.$grandTotal_LSORBegin.'</td>
                            <td>'.$grandTotal_fin_stable.'</td>
                            <td>'.$grandTotal_app_wc.'</td>
                            <td>'.$grandTotal_low_cashout.'</td>
                            <td>'.$grandTotal_existing_loan.'</td>
                            <td>'.$grandTotal_other_resched_gawad.'</td>
                            <td>'.$grandTotal_other_sched_gawad.'</td>
                            <td>'.$grandTotal_sched_applynow.'</td>
                            <td>'.$grandTotal_ssp_overage.'</td>
                            <td>'.$grandTotal_lack_requirements.'</td>
                            <td>'.$grandTotal_undecided.'</td>
                            <td>'.$grandTotal_refuse_transfer.'</td>
                            <td>'.$grandTotal_inquired_only.'</td>
                            <td>'.$grandTotal_new_policy.'</td>
                            <td>'.$grandTotal_not_goodcondition.'</td>
                            <td>'.$grandTotal_guardianship.'</td>
                            <td>'.$grandTotal_plp.'</td>
                            <td>'.$grandTotal_not_qualified.'</td>
                            <td>'.$grandTotal_eighteen_mos_sssloan.'</td>
                            <td>'.$grandTotal_on_process.'</td>
                            <td>'.$grandTotal_total.'</td>
                        </tr>
                        </tbody>
                ';
                
                
                
                

                    echo json_encode(['card' => $html]);
                }
        
    }
   
