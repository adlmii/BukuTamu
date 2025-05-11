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
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validasi input
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $_SESSION['error'] = "Semua field harus diisi.";
        header("Location: ../../pages/register.php");
        exit;
    }
    
    // Validasi format email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Format email tidak valid.";
        header("Location: ../../pages/register.php");
        exit;
    }
    
    // Validasi password
    if (strlen($password) < 6) {
        $_SESSION['error'] = "Password harus memiliki minimal 6 karakter.";
        header("Location: ../../pages/register.php");
        exit;
    }
    
    // Cek konfirmasi password
    if ($password !== $confirm_password) {
        $_SESSION['error'] = "Konfirmasi password tidak cocok.";
        header("Location: ../../pages/register.php");
        exit;
    }
    
    // Cek apakah username sudah digunakan
    $query = "SELECT id FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $_SESSION['error'] = "Username sudah digunakan. Silakan pilih username lain.";
        header("Location: ../../pages/register.php");
        exit;
    }
    
    // Cek apakah email sudah digunakan
    $query = "SELECT id FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $_SESSION['error'] = "Email sudah digunakan. Silakan gunakan email lain.";
        header("Location: ../../pages/register.php");
        exit;
    }
    
    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert user ke database
    $query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $username, $email, $hashed_password);
    
    if ($stmt->execute()) {
        // Registrasi berhasil
        $_SESSION['success'] = "Registrasi berhasil! Silakan login.";
        header("Location: ../../pages/login.php");
        exit;
    } else {
        // Registrasi gagal
        $_SESSION['error'] = "Terjadi kesalahan saat registrasi. Silakan coba lagi.";
        header("Location: ../../pages/register.php");
        exit;
    }
} else {
    // Jika bukan method POST, redirect ke halaman register
    header("Location: ../../pages/register.php");
    exit;
}
?>