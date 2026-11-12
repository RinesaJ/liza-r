<?php
session_start();
if (!isset($_SESSION['admin_id'])) { header("Location: login.php"); exit(); }
include '../includes/db.php';

/* =========================
   UPLOAD MULTIPLE IMAGES WITH CATEGORY
========================= */
if(isset($_POST['upload_foto'])){
    $target_dir = "../uploads/galeria/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $kategoria = $_POST['kategoria']; 
    $files = $_FILES['foto'];

    for($i = 0; $i < count($files['name']); $i++){
        $file_name = time() . "_" . basename($files['name'][$i]);
        $tmp_name  = $files['tmp_name'][$i];
        $size      = $files['size'][$i];
        $error     = $files['error'][$i];

        if($error === 0 && $size > 0){
            $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            $allowed = ['jpg','jpeg','png','webp'];

            if(in_array($ext, $allowed)){
                $target_file = $target_dir . $file_name;
                if(move_uploaded_file($tmp_name, $target_file)){
                    $stmt = $conn->prepare("INSERT INTO galeria (image_path, kategoria) VALUES (?, ?)");
                    $stmt->bind_param("ss", $file_name, $kategoria);
                    $stmt->execute();
                }
            }
        }
    }
    header("Location: galeria.php?success=1");
    exit();
}

/* =========================
   DELETE IMAGE
========================= */
if(isset($_GET['delete'])){
    $id = (int)$_GET['delete'];
    $res = $conn->query("SELECT image_path FROM galeria WHERE id = $id");
    if($res && $res->num_rows > 0){
        $img = $res->fetch_assoc();
        $file = "../uploads/galeria/" . $img['image_path'];
        if(file_exists($file)){
            unlink($file);
        }
        $conn->query("DELETE FROM galeria WHERE id = $id");
    }
    header("Location: galeria.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeria Admin - Liza R</title>
    <style>
        *{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI', sans-serif;}
        body{display:flex;background:#f4f7fb;}
        
        .sidebar{ width:240px; height:100vh; background:#1f2937; color:#fff; position:fixed; padding:20px; }
        .sidebar h2{ text-align:center; margin-bottom:30px; font-size: 1.2rem; border-bottom: 1px solid #374151; padding-bottom: 10px; }
        .sidebar a{ display:block; color:#cbd5e1; padding:12px; margin:5px 0; text-decoration:none; border-radius:6px; transition:0.3s; }
        .sidebar a:hover, .sidebar a.active{ background:#2563eb; color:#fff; }

        .main{ margin-left:240px; width:100%; padding:25px; }
        .header-box { margin-bottom: 25px; }

        .upload-section {
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }

        .upload-form {
            display: grid;
            grid-template-columns: 2fr 1.5fr 1fr;
            gap: 15px;
            align-items: end;
        }

        .form-group { display: flex; flex-direction: column; gap: 8px; }
        .form-group label { font-size: 13px; font-weight: 700; color: #475569; }

        .file-input, .select-input {
            padding: 10px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            background: #fff;
            font-size: 14px;
        }

        .btn-upload {
            background: #2563eb;
            color: #fff;
            padding: 12px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: 0.3s;
        }
        .btn-upload:hover { background: #1e40af; }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
        }

        .gallery-card {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            border: 1px solid #e2e8f0;
        }

        .gallery-card img {
            width: 100%;
            height: 160px;
            object-fit: cover;
        }

        .card-info { padding: 12px; }
        .kat-tag {
            display: inline-block;
            background: #eff6ff;
            color: #2563eb;
            font-size: 10px;
            font-weight: 800;
            padding: 3px 10px;
            border-radius: 20px;
            margin-bottom: 8px;
            text-transform: uppercase;
            border: 1px solid #dbeafe;
        }

        .card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #f1f5f9;
            padding-top: 10px;
        }

        .btn-delete { color: #dc2626; text-decoration: none; font-size: 13px; font-weight: 700; }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Liza-R Admin</h2>
    <a href="index.php" >📊 Dashboard</a>
    <a href="postimet.php">📋 Postimet</a>
    <a href="galeria.php" class="active">🖼️ Galeria</a>
    <a href="sponsors.php">🤝 Sponsorët</a> 
    <a href="kryesia.php">👥 Kryesia</a>
    <a href="kurset_admin.php">🤝 Kurset</a>
    <a href="kontaktet.php">📩 Mesazhet</a>
    <a href="logout.php" style="margin-top:50px; color:#f87171;">🚪 Dil</a>
</div>

<div class="main">
    <div class="header-box">
        <h1>Menaxhimi i Galerisë</h1>
        <p style="color: #64748b;">Zgjidhni kategorinë e duhur në mënyrë që fotot të shfaqen te menuja përkatëse.</p>
    </div>

    <div class="upload-section">
        <form method="POST" enctype="multipart/form-data" class="upload-form">
            <div class="form-group">
                <label>Zgjidh Fotot:</label>
                <input type="file" name="foto[]" multiple accept="image/*" required class="file-input">
            </div>

            <div class="form-group">
                <label>Kategoria (Ku do të shfaqen):</label>
                <select name="kategoria" class="select-input" required>
                    <optgroup label="Galeria Kryesore">
                        <option value="te-pergjithshme">Foto të përgjithshme</option>
                        <option value="vizita">Vizita studentore</option>
                        <option value="delegacionet">Pritje e delegacioneve</option>
                        <option value="evente">Evente</option>
                        <option value="trajnime">Trajnime të mbajtura</option>
                        <option value="trajnime2020/24">Trajnimet 2020-2024</option>
                    </optgroup>
                    <optgroup label="Kategoritë e Aktiviteteve">
                        <option value="trajnimet">TRAJNIMET</option>
                        <option value="konferenca">KONFERENCA</option>
                        <option value="sport">SPORT</option>
                        <option value="rini">RINI</option>
                        <option value="kulture">KULTURË</option>
                        <option value="trashegimi">TRASHËGIMI KULTURORE</option>
                        <option value="verlt">VERLT</option>
                        <option value="erasmus">ERASMUS+</option> 
                        <option value="esc">ESC (European Solidarity Corps)</option> </optgroup>
                    </optgroup>
                    <optgroup label="Nën-kategoritë e Trajnimeve">
        <option value="menaxhimi-strategjik">Menaxhimi Strategjik</option>
        <option value="lidership">Lidership</option>
        <option value="hartim-projektesh">Hartim dhe Menaxhim Projektesh</option>
        <option value="administrim-biznesi">Administrim Biznesi</option>
        <option value="organizim-trajnimeve">Organizim i Trajnimeve</option>
    </optgroup>
                </select>
            </div>

            <button type="submit" name="upload_foto" class="btn-upload">🚀 Ngarko Foto</button>
        </form>
    </div>

    <div class="gallery-grid">
        <?php
        $pics = $conn->query("SELECT * FROM galeria ORDER BY id DESC");
        if($pics->num_rows > 0){
            while($p = $pics->fetch_assoc()){
                ?>
                <div class="gallery-card">
                    <img src="../uploads/galeria/<?php echo htmlspecialchars($p['image_path']); ?>" alt="Galeria">
                    <div class="card-info">
                        <span class="kat-tag"><?php echo str_replace('-', ' ', $p['kategoria']); ?></span>
                        <div class="card-footer">
                            <span style="font-size: 11px; color: #94a3b8;">ID: #<?php echo $p['id']; ?></span>
                            <a href="?delete=<?php echo $p['id']; ?>" 
                               class="btn-delete" 
                               onclick="return confirm('A jeni të sigurt?')">🗑️ Fshij</a>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p style='grid-column: 1/-1; text-align: center; padding: 50px; color: #64748b;'>Nuk ka foto të ngarkuara.</p>";
        }
        ?>
    </div>
</div>

</body>
</html>