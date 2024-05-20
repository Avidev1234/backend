<?php

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case "POST":
        $data = json_decode(file_get_contents('php://input'));
        
        $user_id = $data->userId;
        $password = $data->password;
        $otp = $data->otp; // assuming OTP is also provided in the payload
        
        $hashedPassword = md5($password); // Consider using password_hash for better security
        
        // Update password and OTP in the database
        $result = $objQuery->updateRow(
            "`site_user`", 
            "`password`='$hashedPassword', `otp`='$otp'", 
            "`userId`='$user_id'"
        );
        
        if ($result) {
            http_response_code(200);
            echo json_encode(array(
                'status' => 200,
                'message' => "Password and OTP updated successfully"
            ));
        } else {
            http_response_code(500);
            echo json_encode(array(
                'status' => 500,
                'message' => "Failed to update password and OTP"
            ));
        }
        break;
    default:
        http_response_code(405);
        echo json_encode(array(
            'status' => 405,
            'message' => "Method Not Allowed"
        ));
        break;
}
?>
