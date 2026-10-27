<?php

namespace fingerprint;
require("../core/querydb.php");

if(!empty($_POST["data"])){
    $user_data = json_decode($_POST["data"]);
    $user_id = $user_data->user_id;
    $username = $user_data->username;
    $fullname = $user_data->fullname;
    
    $pre_reg_fmd_array = [
        "user_id" => $user_id,
        "username" => $username,
        "fullname" => $fullname
    ];
    
    // Additional server-side processing based on your requirements
    // You can replace this with your actual logic for user registration

    // For example:
    $registration_result = registerUser($user_id, $username, $fullname);

    echo $registration_result;
} else {
    echo "Post request with 'data' field required";
}
