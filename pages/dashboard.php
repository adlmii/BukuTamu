<?php
// Memulai session jika belum dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    // Jika belum login, redirect ke halaman login
    header("Location: login.php");
    exit;
}

// Mendapatkan URL saat ini
$current_page = basename($_SERVER['PHP_SELF']);

// Include file koneksi database
require_once '../config/conn.php';

// Mengambil data user yang sedang login
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$name = $_SESSION['name'];
$email = $_SESSION['email'];

// Mengambil komentar yang dibuat oleh user yang sedang login
$query = "SELECT id, comment_text, created_at FROM comment WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Include header
include_once '../includes/header.php';

// Menampilkan pesan sukses jika ada
$success_message = isset($_SESSION['success']) ? $_SESSION['success'] : '';
unset($_SESSION['success']);

// Menampilkan pesan error jika ada
$error_message = isset($_SESSION['error']) ? $_SESSION['error'] : '';
unset($_SESSION['error']);
?>

<div class="max-w-4xl mx-auto">
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <h1 class="text-2xl font-bold mb-6">Dashboard</h1>
        
        <div class="bg-blue-50 p-4 rounded-lg mb-6">
            <p class="text-lg">Selamat datang, <span class="font-semibold"><?php echo htmlspecialchars($name); ?></span>!</p>
        </div>
        
        <?php if($success_message): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>
        
        <?php if($error_message): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
        
        <div class="mt-8">
            <h2 class="text-xl font-semibold mb-4">Tambahkan Komentar Baru</h2>
            <form action="../controller/comment/add_comment.php" method="post" class="space-y-4">
                <div>
                    <label for="comment" class="block text-gray-700 mb-2">Pesan/Komentar:</label>
                    <textarea id="comment" name="comment_text" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
                </div>
                <div>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Kirim Komentar</button>
                </div>
            </form>
        </div>
    </div>
    
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-6">Komentar Anda</h2>
        
        <?php if($result && $result->num_rows > 0): ?>
            <div class="space-y-4">
                <?php while($row = $result->fetch_assoc()): ?>
                    <div class="border-b pb-4">
                        <div class="flex justify-between">
                            <span class="text-gray-500 text-sm"><?php echo date('d M Y H:i', strtotime($row['created_at'])); ?></span>
                            <div>
                                <a href="../controller/comment/edit_comment_form.php?id=<?php echo $row['id']; ?>" class="text-blue-600 hover:underline mr-2">Edit</a>
                                <a href="../controller/comment/delete_comment.php?id=<?php echo $row['id']; ?>" class="text-red-600 hover:underline" onclick="return confirm('Apakah Anda yakin ingin menghapus komentar ini?')">Hapus</a>
                            </div>
                        </div>
                        <p class="mt-2 text-gray-700"><?php echo nl2br(htmlspecialchars($row['comment_text'])); ?></p>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p class="text-gray-600 text-center py-4">Anda belum membuat komentar.</p>
        <?php endif; ?>
    </div>
</div>

<?php
// Include footer
include_once '../includes/footer.php';
?>