<?php
function on_register($conn)
{
    $name = htmlspecialchars(trim($_POST['name']));
    $email = trim($_POST['email']);
    $pass = trim($_POST['password']);

    // if there is any empty field
    if (empty($name) || empty($email) || empty($pass)) {
        $arr = [];
        if (empty($name)) $arr["name"] = "Must not be empty.";
        if (empty($email)) $arr["email"] = "Must not be empty.";
        if (empty($pass)) $arr["password"] = "Must not be empty.";
        return [
            "ok" => 0,
            "field_error" => $arr
        ];
    }

    // checking the email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return [
            "ok" => 0,
            "field_error" => [
                "email" => "Invalid email address."
            ]
        ];
    }

    // Password must be at least 4 characters
    if (strlen($pass) < 4) {
        return [
            "ok" => 0,
            "field_error" => [
                "password" => "Must be at least 4 characters."
            ]
        ];
    }

    try {

        // CHECK IF EMAIL IS ALREADY REGISTERED
        $sql = "SELECT `email` FROM `users` WHERE `email` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $email, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() !== 0) {
            return [
                "ok" => 0,
                "field_error" => [
                    "email" => "This Email is already registered."
                ]
            ];
        }

        // Password Hashing
        $pass = password_hash($pass, PASSWORD_DEFAULT);
        // Inserting the User
        $sql = "INSERT INTO `users` (`name`, `email`, `password`) VALUES (?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $name, PDO::PARAM_STR);
        $stmt->bindParam(2, $email, PDO::PARAM_STR);
        $stmt->bindParam(3, $pass, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return [
                "ok" => 1,
                "msg" => "You have been registered successfully.",
                "form_reset" => true
            ];
        }
    } catch (PDOException $e) {
        return [
            "ok" => 0,
            "msg" => $e->getMessage()
        ];
    }
}
