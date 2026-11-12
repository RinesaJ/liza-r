<?php
include 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Siguria: Pastrimi i të dhënave
    $emri = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $subjekti = mysqli_real_escape_string($conn, $_POST['subject']);
    $mesazhi = mysqli_real_escape_string($conn, $_POST['message']);

    // 1. Ruajtja në Databazë (për panelin admin)
    $sql = "INSERT INTO kontaktet (emri, email, subjekti, mesazhi) VALUES ('$emri', '$email', '$subjekti', '$mesazhi')";
    
    if (mysqli_query($conn, $sql)) {
        
        // 2. Dërgimi i Email-it (Opsionale)
        $to = "info@lizar.org"; // Email-i ku do të pranoni mesazhet
        $headers = "From: " . $email;
        $body = "Keni marrë një mesazh të ri nga: $emri\n\nEmail: $email\n\nMesazhi:\n$mesazhi";
        
        @mail($to, $subjekti, $body, $headers);

        // Ridrejtimi me sukses
        header("Location: kontakti.php?status=success");
    } else {
        header("Location: kontakti.php?status=error");
    }
}
?>