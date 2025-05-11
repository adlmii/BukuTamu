<?php
// Memulai session jika belum dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "Anda harus login untuk menghapus komentar.";
    header("Location: ../../pages/login.php");
    exit;
}

// Include file koneksi database
require_once '../../config/conn.php';

// Cek apakah ada parameter id
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error'] = "ID komentar tidak valid.";
    header("Location: ../../pages/dashboard.php");
    exit;
}

$comment_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Cek apakah komentar milik user yang sedang login
$query = "SELECT * FROM comment WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $comment_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    $_SESSION['error'] = "Komentar tidak ditemukan atau Anda tidak memiliki akses untuk menghapus komentar ini.";
    header("Location: ../../pages/dashboard.php");
    exit;
}

// Hapus komentar dari database
$query = "DELETE FROM comment WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $comment_id, $user_id);

if ($stmt->execute()) {
    // Komentar berhasil dihapus
    $_SESSION['success'] = "Komentar berhasil dihapus.";
} else {
    // Gagal menghapus komentar
    $_SESSION['error'] = "Terjadi kesalahan saat menghapus komentar.";
}

// Redirect ke dashboard
header("Location: ../../pages/dashboard.php");
exit;
?>