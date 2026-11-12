<?php
session_start();
include '../includes/db.php';

// Nëse admini është i loguar, e dërgojmë direkt në dashboard
if (isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $error = "Ju lutem plotësoni të gjitha fushat!";
    } else {
        $sql = "SELECT * FROM admin_users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            // Verifikimi i password-it të enkriptuar
if ($password === $user['password']) {
                $_SESSION['admin_id'] = $user['id'];
                $_SESSION['admin_user'] = $user['username'];
                header("Location: index.php");
                exit();
            } else {
                $error = "Fjalëkalimi është i gabuar!";
            }
        } else {
            $error = "Ky përdorues nuk ekziston!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Admin Panel</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-container { background: white; padding: 40px; border-radius: 10px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
        .login-container h2 { text-align: center; color: #333; margin-bottom: 30px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 5px; color: #666; }
        .form-group input { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        .btn-login { width: 100%; padding: 12px; background-color: #007bff; border: none; border-radius: 5px; color: white; font-size: 16px; cursor: pointer; transition: background 0.3s; }
        .btn-login:hover { background-color: #0056b3; }
        .error-msg { background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 20px; text-align: center; font-size: 14px; }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Admin Login</h2>
    
    <?php if ($error): ?>
        <div class="error-msg"><?php echo $error; ?></div>
    <?php endif; ?>

    <form action="" method="POST">
        <div class="form-group">
            <label>Përdoruesi</label>
            <input type="text" name="username" placeholder="Shkruaj username..." required>
        </div>
        <div class="form-group">
            <label>Fjalëkalimi</label>
            <input type="password" name="password" placeholder="Shkruaj password..." required>
        </div>
        <button type="submit" class="btn-login">Hyr në Panel</button>
    </form>
</div>

</body>
</html>