<?php
include 'db.php';

// Search
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Pagination setup
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Count total records
$countSql = "SELECT COUNT(*) AS total FROM inventaris_pesawat WHERE nama_model LIKE '%$search%'";
$countResult = mysqli_query($conn, $countSql);
$countRow = mysqli_fetch_assoc($countResult);
$total = $countRow['total'];
$pages = ceil($total / $limit);

// Fetch records
$sql = "SELECT * FROM inventaris_pesawat WHERE nama_model LIKE '%$search%' LIMIT $start, $limit";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>CRUD Inventaris Pesawat</title>
</head>
<body>
    <h2>Inventaris Pesawat</h2>
    
    <form method="GET">
        <input type="text" name="search" placeholder="Cari berdasarkan nama model..." value="<?php echo $search; ?>">
        <button type="submit">Cari</button>
    </form>
    <br>

    <a href="add.php">Tambah Data</a>
    <br><br>

    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Nama Model</th>
            <th>Produsen</th>
            <th>Tipe Mesin</th>
            <th>Kapasitas</th>
            <th>Foto</th>
            <th>Action</th>
        </tr>
        
        <?php if (mysqli_num_rows($result) > 0) { ?>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['nama_model']; ?></td>
                <td><?php echo $row['produsen']; ?></td>
                <td><?php echo $row['tipe_mesin']; ?></td>
                <td><?php echo $row['kapasitas_penumpang']; ?></td>
                <td>
                    <?php if (!empty($row['foto_pesawat'])) { ?>
                        <img src="uploads/<?php echo $row['foto_pesawat']; ?>" width="100">
                    <?php } else { echo 'No Image'; } ?>
                </td>
                <td>
                    <a href="edit.php?id=<?php echo $row['id']; ?>">Edit</a> |
                    <a href="delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Yakin mau hapus data ini?')">Delete</a>
                </td>
            </tr>
            <?php } ?>
        <?php } else { ?>
            <tr>
                <td colspan="7">No data found</td>
            </tr>
        <?php } ?>
    </table>
    <br>

    <?php for ($i = 1; $i <= $pages; $i++) { ?>
        <a href="?page=<?php echo $i; ?>&search=<?php echo $search; ?>"
           style="<?php if($i == $page) { echo 'font-weight: bold;'; } ?>">
           <?php echo $i; ?>
        </a>
    <?php } ?>

</body>
</html>