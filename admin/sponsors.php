<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// LOGJIKA PËR SHTIMIN DHE PËRDITËSIMIN
if (isset($_POST['save_sponsor'])) {
    $emri = mysqli_real_escape_string($conn, $_POST['emri']);
    $linku = mysqli_real_escape_string($conn, $_POST['linku']);
    $pershkrimi = mysqli_real_escape_string($conn, $_POST['pershkrimi']);
    $renditja = (int)$_POST['renditja'];
    $id = isset($_POST['sponsor_id']) ? (int)$_POST['sponsor_id'] : 0;

    if ($id > 0) {
        // UPDATE ekzistues
        if (!empty($_FILES['foto']['name'])) {
            $foto_name = $_FILES['foto']['name'];
            move_uploaded_file($_FILES['foto']['tmp_name'], "../uploads/" . $foto_name);
            $sql = "UPDATE sponsors SET emri='$emri', linku='$linku', pershkrimi='$pershkrimi', foto='$foto_name', renditja=$renditja WHERE id=$id";
        } else {
            $sql = "UPDATE sponsors SET emri='$emri', linku='$linku', pershkrimi='$pershkrimi', renditja=$renditja WHERE id=$id";
        }
    } else {
        // INSERT i ri
        $foto_name = $_FILES['foto']['name'];
        move_uploaded_file($_FILES['foto']['tmp_name'], "../uploads/" . $foto_name);
        $sql = "INSERT INTO sponsors (emri, linku, pershkrimi, foto, renditja) VALUES ('$emri', '$linku', '$pershkrimi', '$foto_name', $renditja)";
    }
    
    $conn->query($sql);
    header("Location: sponsors.php");
    exit();
}

// FSHIRJA
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM sponsors WHERE id = $id");
    header("Location: sponsors.php");
    exit();
}

// MARRJA E TË DHËNAVE PËR EDITIM
$edit_data = null;
if (isset($_GET['edit'])) {
    $edit_id = (int)$_GET['edit'];
    $edit_res = $conn->query("SELECT * FROM sponsors WHERE id = $edit_id");
    $edit_data = $edit_res->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <title>Sponsorët - Admin Panel</title>
    <style>
        *{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI', sans-serif;}
        body{display:flex;background:#f4f7fb;}
        .sidebar{ width:240px; height:100vh; background:#1f2937; color:#fff; position:fixed; padding:20px; }
        .sidebar a{ display:block; color:#cbd5e1; padding:12px; margin:5px 0; text-decoration:none; border-radius:6px; }
        .main{ margin-left:240px; width:100%; padding:25px; }
        .form-box { background:#fff; padding:25px; border-radius:12px; box-shadow:0 4px 6px rgba(0,0,0,0.05); margin-bottom:30px; border-left: 5px solid #2563eb; }
        .btn-save { background:#2563eb; color:#fff; padding:12px 25px; border:none; border-radius:8px; cursor:pointer; font-weight:600; }
        .btn-cancel { background:#94a3b8; color:#fff; padding:12px 25px; border:none; border-radius:8px; cursor:pointer; text-decoration:none; font-size:14px; margin-left:10px; }
        table { width:100%; border-collapse:collapse; background:#fff; border-radius:12px; overflow:hidden; box-shadow:0 4px 6px rgba(0,0,0,0.05); }
        th, td { padding:15px; text-align:left; border-bottom:1px solid #f1f5f9; }
        th { background: #f8fafc; color: #64748b; font-size: 13px; text-transform: uppercase; }
        .img-preview { width: 60px; height: 40px; object-fit: contain; background: #eee; border-radius: 4px; padding: 2px; }
        .actions a { text-decoration: none; margin-right: 10px; font-size: 14px; }
    </style>
</head>
<body>


<div class="sidebar">
    <h2>Liza-R Admin</h2>
    <a href="index.php" >📊 Dashboard</a>
    <a href="postimet.php">📋 Postimet</a>
    <a href="galeria.php">🖼️ Galeria</a>
    <a href="sponsors.php" class="active">🤝 Sponsorët</a> 
    <a href="kryesia.php">👥 Kryesia</a>
    <a href="kurset_admin.php">🤝 Kurset</a>
    <a href="kontaktet.php">📩 Mesazhet</a>
    <a href="logout.php" style="margin-top:50px; color:#f87171;">🚪 Dil</a>
</div>
<div class="main">
    <h1>Menaxhimi i Sponsorëve 🤝</h1><br>

    <div class="form-box">
        <h3><?php echo $edit_data ? "Edito Sponsorin: " . htmlspecialchars($edit_data['emri']) : "Shto Sponsor të ri"; ?></h3><br>
        
        <form method="POST" enctype="multipart/form-data">
            <?php if ($edit_data): ?>
                <input type="hidden" name="sponsor_id" value="<?php echo $edit_data['id']; ?>">
            <?php endif; ?>

            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:15px; margin-bottom:15px;">
                <input type="text" name="emri" placeholder="Emri i Sponsorit" value="<?php echo $edit_data ? htmlspecialchars($edit_data['emri']) : ''; ?>" required style="padding:12px; border:1px solid #ddd; border-radius:8px;">
                <input type="text" name="linku" placeholder="Linku (https://...)" value="<?php echo $edit_data ? htmlspecialchars($edit_data['linku']) : ''; ?>" required style="padding:12px; border:1px solid #ddd; border-radius:8px;">
                <input type="text" name="pershkrimi" placeholder="Përshkrimi (teksti poshtë logos)" value="<?php echo $edit_data ? htmlspecialchars($edit_data['pershkrimi']) : ''; ?>" style="padding:12px; border:1px solid #ddd; border-radius:8px;">
                <input type="number" name="renditja" placeholder="Renditja" value="<?php echo $edit_data ? $edit_data['renditja'] : '0'; ?>" style="padding:12px; border:1px solid #ddd; border-radius:8px;">
            </div>

            <label style="display:block; margin-bottom:10px; font-weight:bold;">Logoja (PNG/JPG): 
                <?php if($edit_data): ?> <span style="font-weight:normal; color:#666;">(Lëre zbrazët nëse nuk dëshiron ta ndryshosh)</span> <?php endif; ?>
            </label>
            <input type="file" name="foto" accept="image/*" <?php echo $edit_data ? '' : 'required'; ?> style="margin-bottom:20px;">
            
            <br>
            <button type="submit" name="save_sponsor" class="btn-save">
                <?php echo $edit_data ? "Përditëso Sponsorin" : "Ruaj Sponsorin"; ?>
            </button>
            <?php if ($edit_data): ?>
                <a href="sponsors.php" class="btn-cancel">Anulo</a>
            <?php endif; ?>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>Logo</th>
                <th>Emri</th>
                <th>Renditja</th>
                <th>Veprime</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $res = $conn->query("SELECT * FROM sponsors ORDER BY renditja ASC");
            if($res->num_rows > 0):
                while($row = $res->fetch_assoc()):
            ?>
            <tr>
                <td><img src="../uploads/<?php echo $row['foto']; ?>" class="img-preview"></td>
                <td><strong><?php echo htmlspecialchars($row['emri']); ?></strong></td>
                <td><?php echo $row['renditja']; ?></td>
                <td class="actions">
                    <a href="?edit=<?php echo $row['id']; ?>" style="color:#2563eb; font-weight:bold;">Edito</a>
                    <a href="?delete=<?php echo $row['id']; ?>" style="color:red; font-weight:bold;" onclick="return confirm('A jeni të sigurt?')">Fshij</a>
                </td>
            </tr>
            <?php 
                endwhile; 
            else:
                echo "<tr><td colspan='4' style='text-align:center;'>Nuk ka sponsorë të shtuar.</td></tr>";
            endif;
            ?>
        </tbody>
    </table>
</div>

</body>
</html>