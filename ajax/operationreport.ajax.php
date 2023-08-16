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
        
    }
   
