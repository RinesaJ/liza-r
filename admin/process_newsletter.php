<?php
include '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "invalid"; // Email i gabuar
        exit();
    }

    // Kontrollojmë nëse emaili ekziston njëherë
    $check = $conn->query("SELECT id FROM newsletter WHERE email = '$email'");
    
    if ($check->num_rows > 0) {
        echo "exists";
    } else {
        $sql = "INSERT INTO newsletter (email) VALUES ('$email')";
        if (mysqli_query($conn, $sql)) {
            echo "success";
        } else {
            echo "error";
        }
    }
}
?>