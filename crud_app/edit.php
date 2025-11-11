<?php
include 'db.php';

$id = $_GET['id'];

if (isset($_POST['submit'])) {
    $nama_model = $_POST['nama_model'];
    $produsen = $_POST['produsen'];
    $tipe_mesin = $_POST['tipe_mesin'];
    $kapasitas_penumpang = $_POST['kapasitas_penumpang'];
    $foto_lama = $_POST['foto_lama']; 

    $foto_baru = $_FILES['foto_pesawat']['name'];

    if (!empty($foto_baru)) {
        $target = 'uploads/' . basename($foto_baru);
        if (move_uploaded_file($_FILES['foto_pesawat']['tmp_name'], $target)) {
            if (!empty($foto_lama) && file_exists('uploads/' . $foto_lama)) {
                unlink('uploads/' . $foto_lama);
            }
        }
    } else {
        $foto_baru = $foto_lama;
    }

    $sql = "UPDATE inventaris_pesawat SET 
            nama_model='$nama_model', 
            produsen='$produsen', 
            tipe_mesin='$tipe_mesin', 
            kapasitas_penumpang='$kapasitas_penumpang', 
            foto_pesawat='$foto_baru' 
            WHERE id=$id";

    if (mysqli_query($conn, $sql)) {
        header('Location: index.php');
    } else {
        echo 'Error: ' . mysqli_error($conn);
    }
}

$sql_select = "SELECT * FROM inventaris_pesawat WHERE id=$id";
$result = mysqli_query($conn, $sql_select);
$data = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Pesawat</title>
</head>
<body>
    <h2>Edit Data</h2>
    <form method="POST" enctype="multipart/form-data">
        Nama Model: <input type="text" name="nama_model" value="<?php echo $data['nama_model']; ?>" required><br><br>
        Produsen: <input type="text" name="produsen" value="<?php echo $data['produsen']; ?>"><br><br>
        Tipe Mesin: <input type="text" name="tipe_mesin" value="<?php echo $data['tipe_mesin']; ?>"><br><br>
        Kapasitas Penumpang: <input type="number" name="kapasitas_penumpang" value="<?php echo $data['kapasitas_penumpang']; ?>"><br><br>

        Foto Saat Ini: <br>
        <?php if (!empty($data['foto_pesawat'])) { ?>
            <img src="uploads/<?php echo $data['foto_pesawat']; ?>" width="150"><br>
        <?php } else { echo 'Tidak ada foto'; } ?>
        <br>
        
        Ganti Foto (kosongkan jika tidak ingin ganti): <input type="file" name="foto_pesawat"><br><br>
        
        <input type="hidden" name="foto_lama" value="<?php echo $data['foto_pesawat']; ?>">
        
        <button type="submit" name="submit">Update</button>
    </form>
</body>
</html>