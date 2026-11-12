<?php
session_start();
include '../includes/db.php';

// Mbrojtja: Vetëm admini mund ta shohë këtë faqe
if (!isset($_SESSION['admin_id'])) { header("Location: login.php"); exit(); }

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Siguria: Pastrimi i të dhënave
    $emri = mysqli_real_escape_string($conn, $_POST['emri']);
    $mbiemri = mysqli_real_escape_string($conn, $_POST['mbiemri']);
    $pozita = mysqli_real_escape_string($conn, $_POST['pozita']);
    $renditja = intval($_POST['renditja']);
    $lloji = mysqli_real_escape_string($conn, $_POST['lloji']); // Kategoria e re

    // Trajtimi i Fotos
    $foto_name = time() . "_" . $_FILES['foto']['name'];
    $target_foto = "../images/anetaret/" . $foto_name;

    // Trajtimi i CV-së (PDF)
    $cv_name = time() . "_" . $_FILES['cv']['name'];
    $target_cv = "../uploads/cv/" . $cv_name;

    // Ngarkimi i skedarëve
    if (move_uploaded_file($_FILES['foto']['tmp_name'], $target_foto) && 
        move_uploaded_file($_FILES['cv']['tmp_name'], $target_cv)) {
        
        // Query i përditësuar me kolonën 'lloji'
        $sql = "INSERT INTO kryesia (emri, mbiemri, pozita, foto, cv_pdf, lloji, renditja) 
                VALUES ('$emri', '$mbiemri', '$pozita', '$foto_name', '$cv_name', '$lloji', '$renditja')";
        
        if (mysqli_query($conn, $sql)) {
            header("Location: kryesia.php?success=1");
            exit();
        } else {
            $message = "Gabim në databazë: " . mysqli_error($conn);
        }
    } else {
        $message = "Dështoi ngarkimi i skedarëve. Kontrolloni nëse folderat 'images/anetaret' dhe 'uploads/cv' ekzistojnë.";
    }
}
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <title>Shto Anëtar - Liza-R Admin</title>
    <style>
        *{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI', sans-serif;}
        body{display:flex;background:#f4f7fb;}
        
        .sidebar{ width:240px; height:100vh; background:#1f2937; color:#fff; position:fixed; padding:20px; }
        .sidebar h2{ text-align:center; margin-bottom:30px; font-size: 1.2rem; border-bottom: 1px solid #374151; padding-bottom: 10px; }
        .sidebar a{ display:flex; align-items:center; color:#cbd5e1; padding:12px; margin:5px 0; text-decoration:none; border-radius:6px; transition:0.3s; }
        .sidebar a:hover, .sidebar a.active{ background:#2563eb; color:#fff; }
        .sidebar a span { margin-right: 10px; }

        .main{ margin-left:240px; width:calc(100% - 240px); padding:40px; display: flex; justify-content: center; }
        
        .form-container { background: #fff; padding: 30px; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); width: 100%; max-width: 600px; }
        .form-container h2 { margin-bottom: 25px; color: #1e293b; font-size: 22px; border-left: 4px solid #2563eb; padding-left: 15px; }

        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #475569; font-size: 14px; }
        
        .form-group input[type="text"], 
        .form-group input[type="number"],
        .form-group input[type="file"],
        .form-group select {
            width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 8px; outline: none; transition: 0.3s; background: #fff;
        }

        .form-group input:focus, .form-group select:focus { border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1); }

        .btn-save { background: #2563eb; color: #fff; border: none; padding: 15px; border-radius: 8px; cursor: pointer; font-weight: 600; width: 100%; font-size: 16px; transition: 0.3s; margin-top: 10px; }
        .btn-save:hover { background: #1d4ed8; }
        
        .btn-back { display: block; text-align: center; margin-top: 15px; color: #64748b; text-decoration: none; font-size: 14px; }
        .btn-back:hover { color: #1e293b; }

        .error-msg { background: #fee2e2; color: #b91c1c; padding: 10px; border-radius: 6px; margin-bottom: 20px; font-size: 14px; }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Liza-R Admin</h2>
    <a href="index.php" class="active">📊 Dashboard</a>
    <a href="postimet.php">📋 Postimet</a>
    <a href="galeria.php">🖼️ Galeria</a>
    <a href="sponsors.php">🤝 Sponsorët</a> 
    <a href="kryesia.php">👥 Kryesia</a>
    <a href="kurset_admin.php">🤝 Kurset</a>
    <a href="kontaktet.php">📩 Mesazhet</a>
    <a href="logout.php" style="margin-top:50px; color:#f87171;">🚪 Dil</a>
</div>

<div class="main">
    <div class="form-container">
        <h2>Shto Anëtar të Ri</h2>

        <?php if($message != ""): ?>
            <div class="error-msg"><?php echo $message; ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Emri</label>
                <input type="text" name="emri" placeholder="Shkruani emrin" required>
            </div>

            <div class="form-group">
                <label>Mbiemri</label>
                <input type="text" name="mbiemri" placeholder="Shkruani mbiemrin" required>
            </div>

            <div class="form-group">
                <label>Pozita në Organizatë</label>
                <input type="text" name="pozita" placeholder="p.sh. Kryetar, Drejtor, Trainer..." required>
            </div>

            <div class="form-group">
                <label>Kategoria:</label>
                <select name="lloji" required>
                    <option value="kryesia">Bordi Drejtues (Kryesia)</option>
                    <option value="ekipi" selected>Ekipi Ekzekutiv / Puntorët</option>
                </select>
            </div>

            <div class="form-group">
                <label>Renditja (Numër)</label>
                <input type="number" name="renditja" value="1" min="1" required>
                <small style="color:#94a3b8; font-size:11px;">Më i vogli (p.sh. 1) del i pari në faqe.</small>
            </div>

            <div class="form-group">
                <label>Foto Profesionale (JPG/PNG)</label>
                <input type="file" name="foto" accept="image/*" required>
            </div>

            <div class="form-group">
                <label>CV e Anëtarit (Vetëm PDF)</label>
                <input type="file" name="cv" accept=".pdf" required>
            </div>

            <button type="submit" class="btn-save">Ruaj Anëtarin</button>
            <a href="kryesia.php" class="btn-back">Kthehu te lista</a>
        </form>
    </div>
</div>

</body>
</html>