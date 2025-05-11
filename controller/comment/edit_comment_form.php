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

// Cek apakah ada parameter id
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error'] = "ID komentar tidak valid.";
    header("Location: ../../pages/dashboard.php");
    exit;
}

$comment_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Ambil data komentar
$query = "SELECT * FROM comment WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $comment_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Cek apakah komentar ditemukan dan milik user yang sedang login
if ($result->num_rows !== 1) {
    $_SESSION['error'] = "Komentar tidak ditemukan atau Anda tidak memiliki akses untuk mengedit komentar ini.";
    header("Location: ../../pages/dashboard.php");
    exit;
}

$comment = $result->fetch_assoc();

// Include header
include_once '../../includes/header.php';
?>

<div class="max-w-2xl mx-auto">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-6">Edit Komentar</h1>
        
        <form action="update_comment.php" method="post" class="space-y-4">
            <input type="hidden" name="comment_id" value="<?php echo $comment['id']; ?>">
            
            <div>
                <label for="comment_text" class="block text-gray-700 mb-2">Komentar:</label>
                <textarea id="comment_text" name="comment_text" rows="6" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required><?php echo htmlspecialchars($comment['comment_text']); ?></textarea>
            </div>
            
            <div class="flex space-x-4">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Simpan Perubahan</button>
                <a href="../../pages/dashboard.php" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500">Batal</a>
            </div>
        </form>
    </div>
</div>

<?php
// Include footer
include_once '../../includes/footer.php';
?>