<?php
function get_user($conn, $id){
    if(!filter_var($id, FILTER_VALIDATE_INT)){
        return false;
    }
    $sql = "SELECT * FROM `users` WHERE `id` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $data = $stmt->get_result();
    $row = $data->fetch_array(MYSQLI_ASSOC);
    
    if($row === NULL) return false;
    return $row;
}