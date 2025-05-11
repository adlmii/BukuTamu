<?php
// Memulai session jika belum dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include file koneksi database
require_once '../../config/conn.php';

// Cek apakah form dikirimkan dengan method POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    
    // Validasi input
    if (empty($username) || empty($password)) {
        $_SESSION['error'] = "Username/email dan password harus diisi.";
        header("Location: ../../pages/login.php");
        exit;
    }
    
    // Cek apakah input adalah email atau username
    $is_email = filter_var($username, FILTER_VALIDATE_EMAIL);
    
    // Siapkan query berdasarkan jenis input
    if ($is_email) {
        $query = "SELECT id, username, name, password FROM users WHERE email = ?";
    } else {
        $query = "SELECT id, username, name, password FROM users WHERE username = ?";
    }
    
    // Persiapkan statement
    $stmt = $conn->prepare($query);
    
    // Bind parameter dan eksekusi query
    $stmt->bind_param("s", $username);
    $stmt->execute();
    
    // Ambil hasil
    $result = $stmt->get_result();
    
    // Cek apakah user ditemukan
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            // Password benar, buat session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['name'] = $user['name'];
            
            // Redirect ke dashboard
            header("Location: ../../pages/dashboard.php");
            exit;
        } else {
            // Password salah
            $_SESSION['error'] = "Password yang Anda masukkan salah.";
            header("Location: ../../pages/login.php");
            exit;
        }
    } else {
        // User tidak ditemukan
        $_SESSION['error'] = "Username/email tidak ditemukan.";
        header("Location: ../../pages/login.php");
        exit;
    }
} else {
    // Jika bukan method POST, redirect ke halaman login
    header("Location: ../../pages/login.php");
    exit;
}
?>