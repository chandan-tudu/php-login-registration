<?php
session_start();
if(isset($_SESSION['logged_user_id'])){
    header('Location: home.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") :
    require_once __DIR__ . "/db_connection.php";
    require_once __DIR__."/on_login.php";
    if (isset($conn) && isset($_POST["email"]) && isset($_POST["password"])) {
        $result = on_login($conn);
    }
endif;

function post_value($field){
    if(isset($_POST[$field])){
        echo 'value="'.trim(htmlspecialchars($_POST[$field])).'"';
        return;
    }    
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="./style.css">
</head>

<body>
    <div class="container">
        <h1>Login</h1>
        <form action="" method="POST">
            <label for="user_email">Email: <span></span></label>
            <input type="email" class="input" name="email" <?php post_value("email"); ?> id="user_email" placeholder="Your email">

            <label for="user_pass">Password: <span></span></label>
            <input type="password" class="input" name="password" <?php post_value("password"); ?> id="user_pass" placeholder="Your password">
            
            <input type="submit" value="Login">
            <div class="link"><a href="./register.php">Sign Up</a></div>
        </form>
    </div>
    <script>
        <?php 
        if(isset($result["field_error"])){ ?>
        let field_error = <?php echo json_encode($result["field_error"]); ?>;
        let el = null;
        let msg_el = null;
        for(let i in field_error){
            el = document.querySelector(`input[name="${i}"]`);
            el.classList.add("error");
            msg_el = document.querySelector(`label[for="${el.getAttribute("id")}"] span`);
            msg_el.innerText = field_error[i];
        }
        <?php } ?>
    </script>
</body>

</html>