<?php
/*
 * Author: Dahir Muhammad Dahir
 * Date: 26-April-2020 12:41 AM
 * About: this file is responsible
 * for all Database queries
 */

namespace fingerprint;
require_once("../core/Database.php");

function setUserFmds($user_id, $index_finger_fmd_string, $middle_finger_fmd_string){
    $myDatabase = new Database();
    $sql_query = "update accounts set indexfinger=?, middlefinger=? where user_id=?";
    $param_type = "sss";
    $param_array = [$index_finger_fmd_string, $middle_finger_fmd_string, $user_id];
    $affected_rows = $myDatabase->update($sql_query, $param_type, $param_array);

    if($affected_rows > 0){
        return "success";
    }
    else{
        return "failed in querydb";
    }
}

function getUserFmds($user_id){
    $myDatabase = new Database();
    $sql_query = "select indexfinger, middlefinger from accounts where user_id=?";
    $param_type = "s";
    $param_array = [$user_id];
    $fmds = $myDatabase->select($sql_query, $param_type, $param_array);
    return json_encode($fmds);
}

function getUserDetails($user_id){
    $myDatabase = new Database();
    $sql_query = "select username, full_name, id, user_id, type from accounts where user_id=?";
    $param_type = "s";
    $param_array = [$user_id];
    $user_info = $myDatabase->select($sql_query, $param_type, $param_array);

     // Set session variables
     $_SESSION['username'] = $user_info[0]['username'];
     $_SESSION['fullname'] = $user_info[0]['full_name'];
     $_SESSION['id'] = $user_info[0]['id'];
     $_SESSION['user_id'] = $user_info[0]['user_id'];
     $_SESSION['type'] = $user_info[0]['type'];
     
    return json_encode($user_info);
}

function getAllFmds(){
    $myDatabase = new Database();
    $sql_query = "select indexfinger, middlefinger from accounts where indexfinger != ''";
    $allFmds = $myDatabase->select($sql_query);
    return json_encode($allFmds);
}

// This is the modified part

function registerUser($user_id, $username, $fullname){
    $myDatabase = new Database();
    $sql_query = "INSERT INTO `accounts` (`user_id`,`username`, `full_name`) VALUES (?, ?, ?)";
    $param_type = "sss"; // Assuming both username and fullname are strings
    $param_array = [$user_id, $username, $fullname];
    $affected_rows = $myDatabase->register($sql_query, $param_type, $param_array);

    if($affected_rows > 0){
        return "success";
    }
    else{
        return "failed in querydb";
    }

    // function setSession($user_id) {
    //     $myDatabase = new Database();
    //     $sql_query = "SELECT username, full_name, id, user_id, type FROM accounts WHERE user_id=?";
    //     $param_type = "s";
    //     $param_array = [$user_id];
    //     $user_info_session = $myDatabase->select($sql_query, $param_type, $param_array);
    
    //     $_SESSION['username'] = $user_info_session[0]['username'];
    //     $_SESSION['fullname'] = $user_info_session[0]['full_name'];
    //     $_SESSION['id'] = $user_info_session[0]['id'];
    //     $_SESSION['user_id'] = $user_info_session[0]['user_id'];
    //     $_SESSION['type'] = $user_info_session[0]['type'];
    // }
    
}
