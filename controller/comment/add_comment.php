<?php
// Memulai session jika belum dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "Anda harus login untuk menambahkan komentar.";
    header("Location: ../../pages/login.php");
    exit;
}

// Include file koneksi database
require_once '../../config/conn.php';

// Cek apakah form dikirimkan dengan method POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $comment_text = trim($_POST['comment_text']);
    $user_id = $_SESSION['user_id'];
    
    // Validasi input
    if (empty($comment_text)) {
        $_SESSION['error'] = "Komentar tidak boleh kosong.";
        
        // Redirect ke halaman sebelumnya
        if (isset($_SERVER['HTTP_REFERER'])) {
            header("Location: " . $_SERVER['HTTP_REFERER']);
        } else {
            header("Location: ../../pages/dashboard.php");
        }
        exit;
    }
    
    // Masukkan komentar ke database
    $query = "INSERT INTO comment (user_id, comment_text) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("is", $user_id, $comment_text);
    
    if ($stmt->execute()) {
        // Komentar berhasil ditambahkan
        $_SESSION['success'] = "Komentar berhasil ditambahkan.";
    } else {
        // Gagal menambahkan komentar
        $_SESSION['error'] = "Terjadi kesalahan saat menambahkan komentar.";
    }
    
    // Redirect ke halaman sebelumnya
    if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'dashboard.php') !== false) {
        header("Location: ../../pages/dashboard.php");
    } elseif (isset($_SERVER['HTTP_REFERER'])) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
    } else {
        header("Location: ../../index.php");
    }
    exit;
} else {
    // Jika bukan method POST, redirect ke halaman dashboard
    header("Location: ../../pages/dashboard.php");
    exit;
}
?>