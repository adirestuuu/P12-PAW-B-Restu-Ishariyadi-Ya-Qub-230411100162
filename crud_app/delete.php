<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql_select = "SELECT foto_pesawat FROM inventaris_pesawat WHERE id=$id";
    $result = mysqli_query($conn, $sql_select);
    $row = mysqli_fetch_assoc($result);
    $foto_lama = $row['foto_pesawat'];

    $sql_delete = "DELETE FROM inventaris_pesawat WHERE id=$id";

    if (mysqli_query($conn, $sql_delete)) {
        if (!empty($foto_lama) && file_exists('uploads/' . $foto_lama)) {
            unlink('uploads/' . $foto_lama);
        }
        header('Location: index.php');
    } else {
        echo 'Error: ' . mysqli_error($conn);
    }
}
?>