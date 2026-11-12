<?php
session_start();
if (!isset($_SESSION['admin_id'])) { header("Location: login.php"); exit(); }
include '../includes/db.php';

// Logjika për fshirjen e mesazhit
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM kontaktet WHERE id = $id");
    header("Location: kontaktet.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mesazhet - Liza R Admin</title>
    <style>
        *{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI', sans-serif;}
        body{display:flex;background:#f4f7fb;}
        
        /* SIDEBAR */
        .sidebar{ width:240px; height:100vh; background:#1f2937; color:#fff; position:fixed; padding:20px; }
        .sidebar h2{ text-align:center; margin-bottom:30px; font-size: 1.2rem; border-bottom: 1px solid #374151; padding-bottom: 10px; }
        .sidebar a{ display:block; color:#cbd5e1; padding:12px; margin:5px 0; text-decoration:none; border-radius:6px; transition:0.3s; }
        .sidebar a:hover, .sidebar a.active{ background:#2563eb; color:#fff; }

        /* MAIN CONTENT */
        .main{ margin-left:240px; width:100%; padding:25px; }
        .header-box { margin-bottom: 30px; }
        
        /* MESSAGE CARDS */
        .messages-container { max-width: 900px; }
        
        .message-card {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            border-left: 5px solid #ff6b35; /* Ngjyra accent nga front-endi */
            transition: 0.3s;
        }
        
        .message-card:hover { box-shadow: 0 6px 12px rgba(0,0,0,0.1); transform: translateX(5px); }

        .msg-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
            border-bottom: 1px solid #f1f5f9;
            padding-bottom: 10px;
        }

        .user-info h3 { color: #1e293b; font-size: 18px; margin-bottom: 5px; }
        .user-info p { color: #64748b; font-size: 14px; margin-bottom: 3px; }
        
        .subject-tag { 
            display: inline-block; 
            background: #fff7ed; 
            color: #ea580c; 
            padding: 4px 12px; 
            border-radius: 8px; 
            font-size: 13px; 
            font-weight: 700;
            margin-top: 8px;
            border: 1px solid #fdba74;
        }
        
        .msg-date { font-size: 12px; color: #94a3b8; font-weight: 600; }

        .msg-body {
            color: #475569;
            font-size: 15px;
            line-height: 1.6;
            white-space: pre-line;
            background: #f8fafc;
            padding: 15px;
            border-radius: 8px;
            margin-top: 10px;
            border: 1px solid #f1f5f9;
        }

        .msg-footer { margin-top: 15px; text-align: right; }

        .btn-delete {
            color: #dc2626;
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
            padding: 8px 12px;
            border-radius: 5px;
            transition: 0.2s;
        }
        .btn-delete:hover { background: #fee2e2; }

        .empty-state {
            text-align: center;
            padding: 100px 20px;
            color: #64748b;
            background: #fff;
            border-radius: 12px;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Liza-R Admin</h2>
    <a href="index.php" >📊 Dashboard</a>
    <a href="postimet.php">📋 Postimet</a>
    <a href="galeria.php">🖼️ Galeria</a>
    <a href="sponsors.php">🤝 Sponsorët</a> 
    <a href="kryesia.php">👥 Kryesia</a>
    <a href="kurset_admin.php">🤝 Kurset</a>
    <a href="kontaktet.php" class="active">📩 Mesazhet</a>
    <a href="logout.php" style="margin-top:50px; color:#f87171;">🚪 Dil</a>
</div>

<div class="main">
    <div class="header-box">
        <h1>Inbox - Mesazhet e Pranuara</h1>
        <p style="color: #64748b;">Këtu mund të shihni të gjitha mesazhet që vijnë nga faqja e kontaktit.</p>
    </div>

    <div class="messages-container">
        <?php
        // Kontrollojmë nëse tabela ka datat e krijimit, ndryshe përdorim ORDER BY id
        $res = $conn->query("SELECT * FROM kontaktet ORDER BY id DESC");
        
        if($res && $res->num_rows > 0){
            while($m = $res->fetch_assoc()){
                ?>
                <div class="message-card">
                    <div class="msg-header">
                        <div class="user-info">
                            <h3>👤 <?php echo htmlspecialchars($m['emri']); ?></h3>
                            <p>📧 <?php echo htmlspecialchars($m['email']); ?></p>
                            <div class="subject-tag">📌 Subjekti: <?php echo htmlspecialchars($m['subjekti']); ?></div>
                        </div>
                        <span class="msg-date">
                            📅 <?php echo isset($m['data_krijimit']) ? date('d.m.Y', strtotime($m['data_krijimit'])) : ""; ?>
                        </span>
                    </div>
                    
                    <div class="msg-body">
                        <strong>Mesazhi:</strong><br>
                        <?php echo nl2br(htmlspecialchars($m['mesazhi'])); ?>
                    </div>

                    <div class="msg-footer">
                        <a href="?delete=<?php echo $m['id']; ?>" 
                           class="btn-delete" 
                           onclick="return confirm('A jeni të sigurt që dëshironi ta fshini këtë mesazh?')">
                            🗑️ Fshij Mesazhin
                        </a>
                    </div>
                </div>
                <?php
            }
        } else {
            ?>
            <div class="empty-state">
                <h2 style="font-size: 40px; margin-bottom: 10px;">📩</h2>
                <p>Nuk ka asnjë mesazh të ri në inbox.</p>
            </div>
            <?php
        }
        ?>
    </div>
</div>

</body>
</html>