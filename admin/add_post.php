<?php
session_start();
if (!isset($_SESSION['admin_id'])) { 
    header("Location: login.php"); 
    exit(); 
}
include '../includes/db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulli = trim($_POST['titulli']);
    $pershkrimi = trim($_POST['pershkrimi']);
    $kategoria = $_POST['kategoria']; // Marrja e kategorisë nga forma
    
    // Rregullimi i datës për MySQL
    $data_raw = $_POST['data']; 
    $data_per_db = $data_raw . "-01"; 

    // Krijimi i slug-ut
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $titulli)));

    // Folderi për postimet e rregullta (jo kurset)
    $target_dir = "../uploads/";
    
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $file_extension = strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION));
    $foto_name = time() . "_" . $slug . "." . $file_extension;
    $target_file = $target_dir . $foto_name;

    $allowed_types = ['jpg', 'jpeg', 'png', 'webp'];
    
    if (!in_array($file_extension, $allowed_types)) {
        $message = "<div class='error'>Gabim: Lejohen vetëm formatet JPG, PNG dhe WEBP.</div>";
    } elseif ($_FILES["foto"]["size"] > 5000000) {
        $message = "<div class='error'>Gabim: Fotoja është shumë e madhe (Max 5MB).</div>";
    } else {
        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
            // SHTIMI: Përfshijmë kategorinë dhe të dyja kolonat e datës (data dhe data_aktivitetit)
            $stmt = $conn->prepare("INSERT INTO posts (titulli, pershkrimi, foto, data, data_aktivitetit, kategoria, slug) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", $titulli, $pershkrimi, $foto_name, $data_per_db, $data_per_db, $kategoria, $slug);

            if ($stmt->execute()) {
                $message = "<div class='success'>✅ Postimi u publikua me sukses në kategorinë $kategoria!</div>";
            } else {
                $message = "<div class='error'>❌ Gabim në databazë: " . $conn->error . "</div>";
            }
            $stmt->close();
        } else {
            $message = "<div class='error'>❌ Ngarkimi i fotos dështoi.</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <title>Shto Postim - Admin Panel</title>
    <style>
        *{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI', sans-serif;}
        body{ background:#f4f7fb; color: #333; padding: 20px;}
        .container{ max-width:800px; margin:0 auto; background:#fff; padding:30px; border-radius:12px; box-shadow:0 5px 20px rgba(0,0,0,0.05); }
        .header{ display:flex; justify-content:space-between; align-items:center; margin-bottom:25px; border-bottom: 1px solid #eee; padding-bottom: 15px; }
        .back{ text-decoration:none; color:#2563eb; font-weight: 600; }
        .form-group{ margin-bottom:20px; }
        label{ display:block; margin-bottom:8px; font-weight:600; color: #4b5563; }
        input, textarea, select{ width:100%; padding:12px; border:1px solid #d1d5db; border-radius:8px; font-size: 15px; }
        .file-box{ border:2px dashed #cbd5e1; padding:20px; text-align:center; border-radius:10px; cursor:pointer; background: #f9fafb; }
        .preview img{ max-width:100%; max-height:250px; border-radius:8px; margin-top:10px; }
        button{ background:#2563eb; color:#fff; padding:13px; border:none; border-radius:8px; cursor:pointer; font-size:16px; font-weight: 600; width: 100%; }
        .success{ background:#d1fae5; color:#065f46; padding:12px; border-radius:8px; margin-bottom:20px; }
        .error{ background:#fee2e2; color:#991b1b; padding:12px; border-radius:8px; margin-bottom:20px; }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h2>➕ Shto Postim të Ri</h2>
        <a href="postimet.php" class="back">← Mbrapa</a>
    </div>

    <?php echo $message; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Titulli</label>
            <input type="text" name="titulli" placeholder="Titulli i postimit..." required>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
            <div class="form-group">
                <label>Muaji dhe Viti</label>
                <input type="month" name="data" required>
            </div>
            <div class="form-group">
                <label>Kategoria</label>
                <select name="kategoria" required>
                    <option value="Aktivitet">Aktivitet</option>
                    <option value="Konkurs">Konkurs</option>
                    <option value="Trajnim">Trajnim</option>
                    <option value="Lajm">Lajm</option>
                    <option value="Kulturë">Kulturë</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label>Përshkrimi</label>
            <textarea name="pershkrimi" placeholder="Shkruani përmbajtjen..." required></textarea>
        </div>

        <div class="form-group">
            <label>Fotoja</label>
            <div class="file-box" onclick="document.getElementById('file').click()">
                <p id="file-text">📸 Kliko për të ngarkuar foton</p>
            </div>
            <input type="file" id="file" name="foto" accept="image/*" hidden onchange="previewImage(event)">
            <div class="preview" id="preview" style="display:none;">
                <img id="imgPreview">
            </div>
        </div>

        <button type="submit">Publiko Postimin</button>
    </form>
</div>

<script>
function previewImage(event){
    const reader = new FileReader();
    reader.onload = function(){
        document.getElementById('imgPreview').src = reader.result;
        document.getElementById('preview').style.display = "block";
    }
    if(event.target.files[0]) reader.readAsDataURL(event.target.files[0]);
}
</script>

</body>
</html>