<?php
session_start();
if (!isset($_SESSION['admin_id'])) { header("Location: login.php"); exit(); }
include '../includes/db.php';

$message = "";

// 1. LOGJIKA E FSHIRJES SË MEDIAS (GALERISË)
if(isset($_GET['delete_media'])){
    $id = (int)$_GET['delete_media'];
    $conn->query("DELETE FROM galeria WHERE id = $id");
    header("Location: kurset_admin.php?msg=Media u fshi");
    exit();
}

// 2. LOGJIKA E FSHIRJES SË POSTIMIT (LAJMIT/KONKURSIT) - E RE
if(isset($_GET['delete_post'])){
    $id = (int)$_GET['delete_post'];
    $conn->query("DELETE FROM posts WHERE id = $id");
    header("Location: kurset_admin.php?msg=Postimi u fshi");
    exit();
}

// 3. LOGJIKA E NGARKIMIT TË MEDIAVE
if(isset($_POST['upload_media'])){
    $target_dir = "../uploads/galeria/";
    $kategoria = $_POST['kategoria']; 
    $files = $_FILES['media'];

    for($i = 0; $i < count($files['name']); $i++){
        $file_ext = strtolower(pathinfo($files['name'][$i], PATHINFO_EXTENSION));
        $file_name = time() . "_" . uniqid() . "." . $file_ext;
        $target_file = $target_dir . $file_name;

        $allowed = ['jpg','jpeg','png','webp', 'mp4', 'webm'];
        if(in_array($file_ext, $allowed)){
            if(move_uploaded_file($files['tmp_name'][$i], $target_file)){
                $stmt = $conn->prepare("INSERT INTO galeria (image_path, kategoria) VALUES (?, ?)");
                $stmt->bind_param("ss", $file_name, $kategoria);
                $stmt->execute();
            }
        }
    }
    $message = "Mediat u ngarkuan me sukses!";
}

// 4. LOGJIKA E SHTIMIT TË POSTIMIT
if(isset($_POST['add_post'])) {
    $titulli = $_POST['titulli'];
    $pershkrimi = $_POST['pershkrimi'];
    $kategoria = $_POST['kategoria_post']; 
    
    $foto = $_FILES['foto']['name'];
    $foto_paster = str_replace(' ', '_', $foto);
    $file_name = time() . "_" . $foto_paster;
    $target = "../uploads/posts/" . $file_name;

    if (!is_dir('../uploads/posts/')) { mkdir('../uploads/posts/', 0777, true); }

    $stmt = $conn->prepare("INSERT INTO posts (titulli, pershkrimi, foto, kategoria) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $titulli, $pershkrimi, $file_name, $kategoria);
    
    if($stmt->execute()) {
        move_uploaded_file($_FILES['foto']['tmp_name'], $target);
        $message = "Postimi u shtua me sukses!";
    }
}
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <title>Admin - Menaxhimi i Kurseve</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body { display: flex; background: #f4f7fb; }
        
        .sidebar { width: 240px; height: 100vh; background: #1f2937; color: #fff; position: fixed; padding: 20px; }
        .sidebar h2 { text-align: center; margin-bottom: 30px; font-size: 1.2rem; border-bottom: 1px solid #374151; padding-bottom: 10px; }
        .sidebar a { display: block; color: #cbd5e1; padding: 12px; margin: 5px 0; text-decoration: none; border-radius: 6px; transition: 0.3s; }
        .sidebar a:hover, .sidebar a.active { background: #2563eb; color: #fff; }

        .main-content { margin-left: 240px; width: calc(100% - 240px); padding: 40px; }
        .section-card { background: #fff; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin-bottom: 30px; border: 1px solid #e2e8f0; }
        
        h1, h2 { color: #1e2937; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-size: 14px; font-weight: 600; margin-bottom: 5px; color: #4b5563; }
        input, select, textarea { width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; }
        
        .btn-save { background: #2563eb; color: #fff; border: none; padding: 12px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; }
        .alert { padding: 15px; background: #dcfce7; color: #166534; border-radius: 8px; margin-bottom: 20px; }

        /* Tabela e Postimeve */
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        table th, table td { text-align: left; padding: 12px; border-bottom: 1px solid #e2e8f0; font-size: 14px; }
        table th { background: #f8fafc; color: #475569; }
        .btn-edit { color: #2563eb; text-decoration: none; font-weight: 600; margin-right: 10px; }
        .btn-delete { color: #ef4444; text-decoration: none; font-weight: 600; }

        .media-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 15px; margin-top: 20px; }
        .media-item { border: 1px solid #eee; border-radius: 8px; overflow: hidden; }
        .media-item img { width: 100%; height: 100px; object-fit: cover; }
        .tag { background: #ebf2ff; color: #2563eb; padding: 2px 5px; border-radius: 4px; font-size: 10px; }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Liza-R Admin</h2>
    <a href="index.php">📊 Dashboard</a>
    <a href="postimet.php">📋 Postimet</a>
    <a href="galeria.php">🖼️ Galeria</a>
    <a href="sponsors.php">🤝 Sponsorët</a> 
    <a href="kryesia.php">👥 Kryesia</a>
    <a href="kurset_admin.php"class="active">🤝 Kurset</a>
    <a href="kontaktet.php">📩 Mesazhet</a>
    <a href="logout.php" style="margin-top:50px; color:#f87171;">🚪 Dil</a>
</div>

<div class="main-content">
    <h1>Menaxhimi i Kurseve</h1>
    
    <?php if($message || isset($_GET['msg'])): ?>
        <div class="alert"><?php echo $message ? $message : $_GET['msg']; ?></div>
    <?php endif; ?>

    <div class="section-card">
        <h2>📢 Shto Lajm / Konkurs të Ri</h2>
        <form method="POST" enctype="multipart/form-data">
            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label>Titulli</label>
                    <input type="text" name="titulli" required>
                </div>
                <div class="form-group">
                    <label>Kategoria (Ku do shfaqet?)</label>
                    <select name="kategoria_post">
                        <option value="lajme">Lajme të Përgjithshme</option>
                        <option value="rrobaqepesi">Rrobaqepësi</option>
                        <option value="it-dizajn">IT & Dizajn</option>
                        <option value="serra-bujqesi">Serra (Bujqësi)</option>
                        <option value="makina-qepjeje">Makina Qepjeje</option>
                        <option value="bursa-ekselence">Bursa Ekselence</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label>Përshkrimi</label>
                <textarea name="pershkrimi" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label>Foto Kopertina</label>
                <input type="file" name="foto" required>
            </div>
            <button type="submit" name="add_post" class="btn-save">➕ Publiko Postimin</button>
        </form>
    </div>

    <div class="section-card">
        <h2>📝 Menaxho Konkurset e Kurseve</h2>
        <p style="font-size: 13px; color: #64748b; margin-bottom: 15px;">Këtu shfaqen vetëm postimet e lidhura me kurset profesionale.</p>
        <table>
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Titulli</th>
                    <th>Kategoria</th>
                    <th>Veprimet</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Filtrojmë që të mos dalin ato me kategorinë 'lajme'
                $kategorite_e_kurseve = "'rrobaqepesi', 'it-dizajn', 'serra-bujqesi', 'makina-qepjeje', 'bursa-ekselence'";
                $posts = $conn->query("SELECT * FROM posts WHERE kategoria IN ($kategorite_e_kurseve) ORDER BY id DESC");
                
                if($posts->num_rows > 0):
                    while($p = $posts->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <?php if(!empty($p['foto'])): ?>
                                <img src="../uploads/posts/<?php echo $p['foto']; ?>" width="50" height="40" style="border-radius:4px; object-fit:cover;">
                            <?php else: ?>
                                <div style="width:50px; height:40px; background:#eee; border-radius:4px;"></div>
                            <?php endif; ?>
                        </td>
                        <td><?php echo $p['titulli']; ?></td>
                        <td><span class="tag"><?php echo $p['kategoria']; ?></span></td>
                        <td>
                            <a href="edit_post.php?id=<?php echo $p['id']; ?>" class="btn-edit">Edit</a>
                            <a href="?delete_post=<?php echo $p['id']; ?>" class="btn-delete" onclick="return confirm('A jeni të sigurt që dëshironi ta fshini këtë konkurs?')">Fshij</a>
                        </td>
                    </tr>
                    <?php endwhile; 
                else: ?>
                    <tr>
                        <td colspan="4" style="text-align:center; color:#94a3b8; padding:20px;">Nuk ka asnjë postim të regjistruar për kurset.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="section-card">
        <h2>🖼️ Galeria e Kurseve</h2>
        <form method="POST" enctype="multipart/form-data" style="display: flex; gap: 10px; align-items: flex-end;">
            <input type="file" name="media[]" multiple required style="flex: 2;">
            <select name="kategoria" style="flex: 1;">
                <option value="rrobaqepesi">Rrobaqepësi</option>
                <option value="it-dizajn">IT & Dizajn</option>
                <option value="serra-bujqesi">Serra</option>
            </select>
            <button type="submit" name="upload_media" class="btn-save" style="background:#059669;">Ngarko</button>
        </form>

        <div class="media-grid">
            <?php
            $gal = $conn->query("SELECT * FROM galeria ORDER BY id DESC LIMIT 10");
            while($g = $gal->fetch_assoc()): ?>
                <div class="media-item">
                    <img src="../uploads/galeria/<?php echo $g['image_path']; ?>">
                    <div style="padding:5px; display:flex; justify-content:space-between;">
                        <span class="tag"><?php echo $g['kategoria']; ?></span>
                        <a href="?delete_media=<?php echo $g['id']; ?>" style="color:red; font-size:10px;">X</a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>

</body>
</html>