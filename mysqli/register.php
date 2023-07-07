<?php
session_start();
if(isset($_SESSION['logged_user_id'])){
    header('Location: home.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") :
    require_once __DIR__ . "/db_connection.php";
    require_once __DIR__."/on_register.php";
    if (
        isset($conn) &&
        isset($_POST["name"]) &&
        isset($_POST["email"]) &&
        isset($_POST["password"])
        ) {
        $result = on_register($conn);
    }
endif;

// If the user is registered successfully, don't show the post values.
$show = isset($result["form_reset"]) ? true : false;

function post_value($field){
    global $show;
    if(isset($_POST[$field]) && !$show){
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
    <title>Sign Up</title>
    <link rel="stylesheet" href="./style.css">
</head>

<body>
    <div class="container">
        <h1>Sign Up</h1>
        <form action="" method="POST" id="theForm">
            <label for="user_name">Name: <span></span></label>
            <input type="text" class="input" name="name" <?php post_value("name"); ?> id="user_name" placeholder="Your name">

            <label for="user_email">Email: <span></span></label>
            <input type="email" class="input" name="email" <?php post_value("email"); ?> id="user_email" placeholder="Your email">

            <label for="user_pass">Password: <span></span></label>
            <input type="password" class="input" name="password" <?php post_value("password"); ?> id="user_pass" placeholder="New password">
            <?php if(isset($result["msg"])){ ?>
                <p class="msg<?php if($result["ok"] === 0){ echo " error"; } ?>"><?php echo $result["msg"]; ?></p>
            <?php } ?>
            <input type="submit" value="Sign Up">
            <div class="link"><a href="./login.php">Login</a></div>
        </form>
    </div>
    <?php 
    // JS code to show errors
    if(isset($result["field_error"])){ ?>
    <script>
    let field_error = <?php echo json_encode($result["field_error"]); ?>;
    let el = null;
    let msg_el = null;
    for(let i in field_error){
        el = document.querySelector(`input[name="${i}"]`);
        el.classList.add("error");
        msg_el = document.querySelector(`label[for="${el.getAttribute("id")}"] span`);
        msg_el.innerText = field_error[i];
    }
    </script>
    <?php } ?>
</body>
</html>