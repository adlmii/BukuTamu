<?php
// Memulai session jika belum dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Jika user sudah login, redirect ke dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

// Menampilkan pesan error jika ada
$error_message = isset($_SESSION['error']) ? $_SESSION['error'] : '';
unset($_SESSION['error']);

// Menampilkan pesan sukses jika ada
$success_message = isset($_SESSION['success']) ? $_SESSION['success'] : '';
unset($_SESSION['success']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/img/icon.png" type="image/png">
    <title>Login</title>
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="max-w-md w-full bg-white shadow-md rounded-lg p-6">
        <!-- Tambahkan gambar di atas teks Login -->
        <div class="flex justify-center mb-3">
            <img src="../assets/img/icon.png" alt="Login Icon" class="h-16 w-16">
        </div>
        
        <h1 class="text-2xl font-bold text-center mb-6">Login</h1>
        
        <?php if ($error_message): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>
        
        <?php if ($success_message): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                <?php echo htmlspecialchars($success_message); ?>
            </div>
        <?php endif; ?>
        
        <form action="../controller/auth/login_process.php" method="post" class="space-y-4">
            <input type="hidden" name="action" value="login">
            <div>
                <label for="username" class="block text-gray-700 mb-2">Username atau Email:</label>
                <input type="text" id="username" name="username" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            
            <div>
                <label for="password" class="block text-gray-700 mb-2">Password:</label>
                <input type="password" id="password" name="password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            
            <div>
                <button type="submit" class="w-full px-4 py-2 bg-blue-800 text-white rounded-md hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500">Login</button>
            </div>
        </form>
        
        <div class="mt-4 text-center">
            <p>Belum punya akun? <a href="register.php" class="text-blue-600 hover:underline">Register</a></p>
        </div>
    </div>
</body>
</html>