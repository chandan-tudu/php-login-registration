<?php
function get_user($conn, $id){
    if(!filter_var($id, FILTER_VALIDATE_INT)){
        return false;
    }
    $sql = "SELECT * FROM `users` WHERE `id` = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $data = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_array($data, MYSQLI_ASSOC);

    if($row === NULL) return false;
    return $row;
}