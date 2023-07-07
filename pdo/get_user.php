<?php
function get_user($conn, $id)
{
    if (!filter_var($id, FILTER_VALIDATE_INT)) {
        return false;
    }
    try {
        $sql = "SELECT * FROM `users` WHERE `id` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row === NULL) return false;
        return $row;
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }
}