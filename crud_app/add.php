<?php
include 'db.php';

if (isset($_POST['submit'])) {
    $nama_model = $_POST['nama_model'];
    $produsen = $_POST['produsen'];
    $tipe_mesin = $_POST['tipe_mesin'];
    $kapasitas_penumpang = $_POST['kapasitas_penumpang'];
    
    $foto_pesawat = $_FILES['foto_pesawat']['name'];
    $target = 'uploads/' . basename($foto_pesawat);

    if (empty($nama_model)) {
        echo 'Nama Model wajib diisi!';
    } else {
        if (move_uploaded_file($_FILES['foto_pesawat']['tmp_name'], $target)) {
            $sql = "INSERT INTO inventaris_pesawat (nama_model, produsen, tipe_mesin, kapasitas_penumpang, foto_pesawat) 
                    VALUES ('$nama_model', '$produsen', '$tipe_mesin', '$kapasitas_penumpang', '$foto_pesawat')";
        } else {
             $sql = "INSERT INTO inventaris_pesawat (nama_model, produsen, tipe_mesin, kapasitas_penumpang, foto_pesawat) 
                    VALUES ('$nama_model', '$produsen', '$tipe_mesin', '$kapasitas_penumpang', '')";
        }
        
        if (mysqli_query($conn, $sql)) {
            header('Location: index.php');
        } else {
            echo 'Error: ' . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Pesawat</title>
</head>
<body>
    <h2>Tambah Data</h2>
    <form method="POST" enctype="multipart/form-data">
        Nama Model: <input type="text" name="nama_model" required><br><br>
        Produsen: <input type="text" name="produsen"><br><br>
        Tipe Mesin (Jet/Turboprop/dll): <input type="text" name="tipe_mesin"><br><br>
        Kapasitas Penumpang: <input type="number" name="kapasitas_penumpang"><br><br>
        Foto Pesawat: <input type="file" name="foto_pesawat"><br><br>
        <button type="submit" name="submit">Save</button>
    </form>
</body>
</html>