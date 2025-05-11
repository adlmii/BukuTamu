<?php
// Memulai session jika belum dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Mendapatkan URL saat ini
$current_page = basename($_SERVER['PHP_SELF']);

// Include file koneksi database
require_once 'config/conn.php';

// Mengambil daftar komentar terbaru untuk ditampilkan di halaman beranda
$query = "SELECT c.id, c.comment_text, c.created_at, u.name
          FROM comment c 
          JOIN users u ON c.user_id = u.id 
          ORDER BY c.created_at DESC 
          LIMIT 10";
$result = $conn->query($query);

// Include header
include_once 'includes/header.php';
?>

<div class="max-w-4xl mx-auto">
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <h1 class="text-3xl font-bold text-center mb-6">Selamat Datang di Buku Tamu</h1>
        <p class="text-gray-700 mb-4 text-center">
            Aplikasi sederhana untuk meninggalkan pesan dan komentar Anda.
        </p>
        <?php if(isset($_SESSION['user_id'])): ?>
            <div class="mt-8 bg-gray-50 p-4 rounded-lg">
                <h2 class="text-xl font-semibold mb-4">Tambahkan Komentar</h2>
                <form action="controller/comment/add_comment.php" method="post" class="space-y-4">
                    <div>
                        <label for="comment" class="block text-gray-700 mb-2">Pesan/Komentar:</label>
                        <textarea id="comment" name="comment_text" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
                    </div>
                    <div>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Kirim Komentar</button>
                    </div>
                </form>
            </div>
        <?php else: ?>
            <p class="text-gray-700 text-center">
                Buku Tamu ini memungkinkan Anda untuk berbagi kesan, kritik, dan saran dengan mudah. 
                Setiap entri yang Anda tulis akan membantu kami memahami pengalaman pengguna dan terus meningkatkan layanan.
            </p>

            <div class="text-center mt-8">
                <p class="mb-4">Silakan login untuk meninggalkan komentar</p>
                <div class="flex justify-center space-x-4">
                    <a href="pages/login.php" class="w-24 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Login</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
    
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-semibold mb-6">Komentar Terbaru</h2>
        
        <?php if($result && $result->num_rows > 0): ?>
            <div class="space-y-4">
                <?php while($row = $result->fetch_assoc()): ?>
                    <div class="border-b pb-4">
                        <div class="flex justify-between">
                            <span class="font-semibold"><?php echo htmlspecialchars($row['name']); ?></span>
                            <span class="text-gray-500 text-sm"><?php echo date('d M Y H:i', strtotime($row['created_at'])); ?></span>
                        </div>
                        <p class="mt-2 text-gray-700"><?php echo nl2br(htmlspecialchars($row['comment_text'])); ?></p>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p class="text-gray-600 text-center py-4">Belum ada komentar.</p>
        <?php endif; ?>
    </div>
</div>

<?php
// Include footer
include_once 'includes/footer.php';
?>