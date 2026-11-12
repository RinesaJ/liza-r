<?php
session_start();
include '../includes/db.php';
if (!isset($_SESSION['admin_id'])) { header("Location: login.php"); exit(); }

// Fshirja me pastrim skedarësh (Unlink)
if(isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    
    // Marrim emrat e skedarëve para se të fshijmë rreshtin
    $stmt = $conn->prepare("SELECT foto, cv_pdf FROM kryesia WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res_files = $stmt->get_result()->fetch_assoc();

    if ($res_files) {
        if(file_exists("../images/anetaret/" . $res_files['foto'])) unlink("../images/anetaret/" . $res_files['foto']);
        if(file_exists("../uploads/cv/" . $res_files['cv_pdf'])) unlink("../uploads/cv/" . $res_files['cv_pdf']);
    }

    $conn->query("DELETE FROM kryesia WHERE id = $id");
    header("Location: kryesia.php?deleted=1");
    exit();
}
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menaxhimi i Kryesisë - Liza-R</title>
    <style>
        *{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI', sans-serif;}
        body{display:flex;background:#f4f7fb;}
        
        /* SIDEBAR */
        .sidebar{ width:240px; height:100vh; background:#1f2937; color:#fff; position:fixed; padding:20px; }
        .sidebar h2{ text-align:center; margin-bottom:30px; font-size: 1.2rem; border-bottom: 1px solid #374151; padding-bottom: 10px; }
        .sidebar a{ display:flex; align-items:center; color:#cbd5e1; padding:12px; margin:5px 0; text-decoration:none; border-radius:6px; transition:0.3s; }
        .sidebar a:hover, .sidebar a.active{ background:#2563eb; color:#fff; }
        .sidebar a span { margin-right: 10px; }
        
        /* MAIN CONTENT */
        .main{ margin-left:240px; width:calc(100% - 240px); padding:30px; }
        .header{ display:flex; justify-content:space-between; align-items:center; margin-bottom:30px; }
        .header h1 { font-size: 24px; color: #1e293b; }

        /* TABLE STYLING */
        .table-box{ background:#fff; border-radius:12px; padding:25px; box-shadow:0 4px 6px rgba(0,0,0,0.05); }
        table{ width:100%; border-collapse:collapse; }
        th, td{ padding:15px; text-align:left; border-bottom:1px solid #f1f5f9; }
        th{ background:#f8fafc; color:#64748b; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; }
        
        .member-info { display: flex; align-items: center; gap: 15px; }
        .member-img { width: 45px; height: 45px; border-radius: 50%; object-fit: cover; border: 2px solid #e2e8f0; }
        .member-name { font-weight: 600; color: #1e293b; display: block; }
        .member-pos { font-size: 13px; color: #64748b; }

        .cv-badge { background: #fee2e2; color: #dc2626; padding: 4px 10px; border-radius: 6px; text-decoration: none; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 5px; }
        .cv-badge:hover { background: #fecaca; }

        .btn-add{ background:#2563eb; color:#fff; padding:10px 20px; border-radius:8px; text-decoration:none; font-size:14px; font-weight: 600; transition: 0.3s; }
        .btn-add:hover { background: #1d4ed8; transform: translateY(-2px); }
        
        .actions { display: flex; gap: 15px; }
        .delete{ color:#dc2626; text-decoration:none; font-size:13px; font-weight: 700; }
        .delete:hover { text-decoration: underline; }

        /* Status Messages */
        .alert { padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; font-weight: 500; }
        .alert-success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Liza-R Admin</h2>
    <a href="index.php" >📊 Dashboard</a>
    <a href="postimet.php">📋 Postimet</a>
    <a href="galeria.php">🖼️ Galeria</a>
    <a href="sponsors.php">🤝 Sponsorët</a> 
    <a href="kryesia.php" class="active">👥 Kryesia</a>
    <a href="kurset_admin.php">🤝 Kurset</a>
    <a href="kontaktet.php">📩 Mesazhet</a>
    <a href="logout.php" style="margin-top:50px; color:#f87171;">🚪 Dil</a>
</div>

<div class="main">
    <?php if(isset($_GET['deleted'])): ?>
        <div class="alert alert-success">Anëtari u fshi me sukses!</div>
    <?php endif; ?>

    <div class="header">
        <h1>Menaxhimi i Kryesisë</h1>
        <a href="shto_anetar.php" class="btn-add">➕ Shto Anëtar</a>
    </div>

    <div class="table-box">
        <table>
            <thead>
                <tr>
                    <th>Anëtari</th>
                    <th>Pozita</th>
                    <th>Dokumentacioni</th>
                    <th>Renditja</th>
                    <th>Veprime</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $res = $conn->query("SELECT * FROM kryesia ORDER BY renditja ASC");
                if($res->num_rows > 0):
                    while($row = $res->fetch_assoc()):
                ?>
                <tr>
                    <td>
                        <div class="member-info">
                            <img src="../images/anetaret/<?php echo $row['foto']; ?>" class="member-img" alt="">
                            <div>
                                <span class="member-name"><?php echo htmlspecialchars($row['emri'] . " " . $row['mbiemri']); ?></span>
                            </div>
                        </div>
                    </td>
                    <td><span class="member-pos"><?php echo htmlspecialchars($row['pozita']); ?></span></td>
                    <td>
                        <a href="../uploads/cv/<?php echo $row['cv_pdf']; ?>" target="_blank" class="cv-badge">
                            📕 CV (PDF)
                        </a>
                    </td>
                    <td style="color: #94a3b8; font-weight: bold;">#<?php echo $row['renditja']; ?></td>
                    <td class="actions">
                        <a class="delete" href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('A jeni të sigurt që dëshironi të fshini këtë anëtar?')">Fshij</a>
                    </td>
                </tr>
                <?php 
                    endwhile; 
                else:
                    echo "<tr><td colspan='5' style='text-align:center; padding:30px; color:#94a3b8;'>Nuk ka anëtarë të regjistruar.</td></tr>";
                endif;
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>