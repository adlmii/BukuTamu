<?php
// Memulai session jika belum dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "Anda harus login untuk mengedit komentar.";
    header("Location: ../../pages/login.php");
    exit;
}

// Include file koneksi database
require_once '../../config/conn.php';

// Cek apakah form dikirimkan dengan method POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $comment_id = $_POST['comment_id'];
    $comment_text = trim($_POST['comment_text']);
    $user_id = $_SESSION['user_id'];
    
    // Validasi input
    if (empty($comment_text)) {
        $_SESSION['error'] = "Komentar tidak boleh kosong.";
        header("Location: edit_comment_form.php?id=" . $comment_id);
        exit;
    }
    
    // Cek apakah komentar milik user yang sedang login
    $query = "SELECT * FROM comment WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $comment_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows !== 1) {
        $_SESSION['error'] = "Komentar tidak ditemukan atau Anda tidak memiliki akses untuk mengedit komentar ini.";
        header("Location: ../../pages/dashboard.php");
        exit;
    }
    
    // Update komentar di database
    $query = "UPDATE comment SET comment_text = ? WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sii", $comment_text, $comment_id, $user_id);
    
    if ($stmt->execute()) {
        // Komentar berhasil diupdate
        $_SESSION['success'] = "Komentar berhasil diperbarui.";
        header("Location: ../../pages/dashboard.php");
        exit;
    } else {
        // Gagal mengupdate komentar
        $_SESSION['error'] = "Terjadi kesalahan saat memperbarui komentar.";
        header("Location: edit_comment_form.php?id=" . $comment_id);
        exit;
    }
} else {
    // Jika bukan method POST, redirect ke halaman dashboard
    header("Location: ../../pages/dashboard.php");
    exit;
}
?>