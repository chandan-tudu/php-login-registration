<?php
function on_login($conn){
    $email = trim($_POST['email']);
    $pass = trim($_POST['password']);
    
    if (empty($email) || empty($pass)) {
        $arr = [];
        if (empty($email)) $arr["email"] = "Must not be empty.";
        if (empty($pass)) $arr["password"] = "Must not be empty.";
        return [
            "ok" => 0,
            "field_error" => $arr
        ];
    }
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return [
            "ok" => 0,
            "field_error" => [
                "email" => "Invalid email address."
            ]
        ];
    }

    $sql = "SELECT * FROM `users` WHERE `email` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $data = $stmt->get_result();
    $row = $data->fetch_array(MYSQLI_ASSOC);

    if($row === NULL){
        return [
            "ok" => 0,
            "field_error" => [
                "email" => "This email is not registered."
            ]
        ];
    }

    $password_check = password_verify($pass, $row["password"]);
    if($password_check === false){
        return [
            "ok" => 0,
            "field_error" => [
                "password" => "Incorrect Password."
            ]
        ];
    }

    $_SESSION['logged_user_id'] = $row["id"];  
    header('Location: home.php');
    exit;
}