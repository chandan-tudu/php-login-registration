<?php
session_start();
session_regenerate_id(true);

if (!isset($_SESSION['logged_user_id']) || empty($_SESSION['logged_user_id']) || !is_numeric($_SESSION['logged_user_id'])) {
    header('Location: logout.php');
    exit;
}

require_once __DIR__ . "/db_connection.php";
require_once __DIR__ . "/get_user.php";

// Get the User by ID that stored in the session
$user = get_user($conn, $_SESSION['logged_user_id']);

// If User is Empty
if ($user === false) {
    header('Location: logout.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="./style.css">
</head>

<body>
    <div class="container">
        <div class="profile">
            <img src="https://robohash.org/set_set3/<?php echo $user["id"]; ?>?size=200x200" alt="<?php echo $user["name"]; ?>">
            <h2><?php echo $user["name"]; ?><span><?php echo $user["email"]; ?></span></h2>
            <a href="./logout.php">Log out</a>
        </div>

    </div>
</body>

</html>