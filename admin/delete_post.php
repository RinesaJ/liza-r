<?php
session_start();
if (!isset($_SESSION['admin_id'])) { exit(); }
include '../includes/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // 1. Marrim emrin e fotos që ta fshijmë edhe nga folderi uploads
    $stmt = $conn->prepare("SELECT foto FROM posts WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $post = $result->fetch_assoc();

    if ($post) {
        $foto_path = "../uploads/" . $post['foto'];
        if (file_exists($foto_path)) {
            unlink($foto_path); // Fshin foton fizikisht
        }

        // 2. Fshijmë rekordin nga Databaza
        $delete_stmt = $conn->prepare("DELETE FROM posts WHERE id = ?");
        $delete_stmt->bind_param("i", $id);
        $delete_stmt->execute();
    }
}

header("Location: postimet.php");
exit();
?>