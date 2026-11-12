<?php
session_start();
if (!isset($_SESSION['admin_id'])) { header("Location: login.php"); exit(); }
include '../includes/db.php';

$message = "";

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $res = $conn->query("SELECT * FROM posts WHERE id = $id");
    $post = $res->fetch_assoc();

    if (!$post) {
        header("Location: kurset_admin.php");
        exit();
    }
} else {
    header("Location: kurset_admin.php");
    exit();
}

// Përcaktojmë folderin aktual të fotos në bazë të kategorisë
$kategorite_kurseve = ['rrobaqepesi', 'it-dizajn', 'serra-bujqesi', 'makina-qepjeje', 'bursa-ekselence'];
$current_folder = (in_array($post['kategoria'], $kategorite_kurseve)) ? "../uploads/posts/" : "../uploads/";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulli = trim($_POST['titulli']);
    $pershkrimi = trim($_POST['pershkrimi']);
    $kategoria = $_POST['kategoria_post']; 
    
    // Rregullimi i datës
    $data_raw = $_POST['data_raw']; // Tani marrim datë të plotë (Y-m-d)
    
    $foto_name = $post['foto']; 

    // Kontrollojmë folderin e ri ku do të ruhet fotoja nëse ndryshon kategoria
    $new_folder = (in_array($kategoria, $kategorite_kurseve)) ? "../uploads/posts/" : "../uploads/";

    if (!empty($_FILES["foto"]["name"])) {
        $file_extension = strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION));
        $new_foto_name = time() . "_" . uniqid() . "." . $file_extension;
        $target_file = $new_folder . $new_foto_name;

        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
            // Fshijmë foton e vjetër nga folderi ku ishte
            if (!empty($post['foto']) && file_exists($current_folder . $post['foto'])) {
                unlink($current_folder . $post['foto']);
            }
            $foto_name = $new_foto_name;
        }
    } elseif ($current_folder !== $new_folder && !empty($post['foto'])) {
        // Nëse nuk ka ngarkuar foto të re, por ka ndryshuar kategorinë (nga lajm në kurs ose anasjelltas)
        // duhet ta lëvizim foton ekzistuese në folderin e ri
        if (file_exists($current_folder . $post['foto'])) {
            rename($current_folder . $post['foto'], $new_folder . $post['foto']);
        }
    }

    // Përditësojmë të dyja kolonat e datës për siguri që të shfaqen kudo saktë
    $stmt = $conn->prepare("UPDATE posts SET titulli=?, pershkrimi=?, foto=?, kategoria=?, data=?, data_aktivitetit=? WHERE id=?");
    $stmt->bind_param("ssssssi", $titulli, $pershkrimi, $foto_name, $kategoria, $data_raw, $data_raw, $id);

    if ($stmt->execute()) {
        $message = "<div class='success'>✅ Postimi u përditësua me sukses!</div>";
        // Rifreskojmë të dhënat e postit pas update-it
        $res = $conn->query("SELECT * FROM posts WHERE id = $id");
        $post = $res->fetch_assoc();
        $current_folder = $new_folder; // Përditësojmë folderin për shfaqjen e fotos poshtë
    } else {
        $message = "<div class='error'>❌ Gabim gjatë përditësimit: " . $conn->error . "</div>";
    }
}

// Formatimi i datës për input
$input_date = !empty($post['data_aktivitetit']) ? $post['data_aktivitetit'] : $post['data'];
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <title>Edito Postimin</title>
    <style>
        *{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI', sans-serif;}
        body{display:flex;background:#f4f7fb;}
        .sidebar{ width:240px; height:100vh; background:#1f2937; color:#fff; position:fixed; padding:20px; }
        .sidebar a{ display:block; color:#cbd5e1; padding:12px; margin:5px 0; text-decoration:none; border-radius:6px; transition:0.3s; }
        .sidebar a:hover, .sidebar a.active{ background:#2563eb; color:#fff; }
        .main{ margin-left:240px; width:100%; padding:25px; }
        .container{ max-width:800px; background:#fff; padding:30px; border-radius:12px; box-shadow:0 5px 20px rgba(0,0,0,0.05); margin: auto;}
        .form-group{ margin-bottom:18px; }
        label{ display:block; margin-bottom:6px; font-weight:600; color:#4b5563; }
        input, select, textarea{ width:100%; padding:12px; border:1px solid #ddd; border-radius:8px; }
        .current-img { width: 150px; height: 100px; object-fit: cover; border-radius: 6px; margin-top: 10px; border: 1px solid #ddd; }
        button{ background:#2563eb; color:#fff; padding:12px 20px; border:none; border-radius:8px; cursor:pointer; width: 100%; font-weight: 600; margin-top:10px;}
        .success{ background:#d1fae5; color:#065f46; padding:10px; border-radius:8px; margin-bottom:15px; }
        .error{ background:#fee2e2; color:#991b1b; padding:10px; border-radius:8px; margin-bottom:15px; }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Liza-R Admin</h2>
    <a href="index.php" >📊 Dashboard</a>
    <a href="postimet.php" class="active">📋 Postimet</a>
    <a href="galeria.php">🖼️ Galeria</a>
    <a href="sponsors.php">🤝 Sponsorët</a> 
    <a href="kryesia.php">👥 Kryesia</a>
    <a href="kurset_admin.php">🤝 Kurset</a>
    <a href="kontaktet.php">📩 Mesazhet</a>
    <a href="logout.php" style="margin-top:50px; color:#f87171;">🚪 Dil</a>
</div>

<div class="main">
    <div class="container">
        <h2>✏️ Edito Postimin</h2>
        <p style="color:#666; margin-bottom:20px;">Kategoria përcakton folderin ku ruhet fotoja.</p>
        
        <?php echo $message; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Titulli</label>
                <input type="text" name="titulli" value="<?php echo htmlspecialchars($post['titulli']); ?>" required>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div class="form-group">
                    <label>Data e Postimit</label>
                    <input type="date" name="data_raw" value="<?php echo $input_date; ?>" required>
                </div>
                <div class="form-group">
                    <label>Kategoria</label>
                    <select name="kategoria_post" required>
                        <optgroup label="Kurse (Ruhen te uploads/posts/)">
                            <option value="rrobaqepesi" <?php if($post['kategoria'] == 'rrobaqepesi') echo 'selected'; ?>>Rrobaqepësi</option>
                            <option value="it-dizajn" <?php if($post['kategoria'] == 'it-dizajn') echo 'selected'; ?>>IT & Dizajn</option>
                            <option value="serra-bujqesi" <?php if($post['kategoria'] == 'serra-bujqesi') echo 'selected'; ?>>Serra (Bujqësi)</option>
                            <option value="makina-qepjeje" <?php if($post['kategoria'] == 'makina-qepjeje') echo 'selected'; ?>>Makina Qepjeje</option>
                            <option value="bursa-ekselence" <?php if($post['kategoria'] == 'bursa-ekselence') echo 'selected'; ?>>Bursa Ekselence</option>
                        </optgroup>
                        <optgroup label="Lajme (Ruhen te uploads/)">
                            <option value="Aktivitet" <?php if($post['kategoria'] == 'Aktivitet') echo 'selected'; ?>>Aktivitet</option>
                            <option value="Lajm" <?php if($post['kategoria'] == 'Lajm') echo 'selected'; ?>>Lajm</option>
                        </optgroup>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Përshkrimi</label>
                <textarea name="pershkrimi" rows="6" required><?php echo htmlspecialchars($post['pershkrimi']); ?></textarea>
            </div>

            <div class="form-group">
                <label>Fotoja Aktuale</label><br>
                <?php 
                    $src = !empty($post['foto']) ? $current_folder . $post['foto'] : '../assets/img/default.jpg';
                ?>
                <img src="<?php echo $src; ?>" class="current-img"><br>
                <small style="color: #666;">Zgjidhni skedar të ri vetëm nëse dëshironi ta ndryshoni foton:</small>
                <input type="file" name="foto" accept="image/*" style="margin-top:10px;">
            </div>

            <button type="submit">Ruaj Ndryshimet</button>
            <a href="kurset_admin.php" style="display:block; text-align:center; margin-top:15px; color:#666; text-decoration:none;">Kthehu Mbrapa</a>
        </form>
    </div>
</div>

</body>
</html>