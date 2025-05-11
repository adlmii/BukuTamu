<?php
// Memulai session jika belum dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Tentukan base URL secara dinamis
$base_url = '/belajar-php/BukuTamu';

$nama = isset($_SESSION['name']) ? $_SESSION['name'] : null;

// Ambil username jika pengguna sudah login
$username = isset($_SESSION['username']) ? $_SESSION['username'] : null;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- link icon-->


    <link rel="icon" href="<?php echo $base_url; ?>/assets/img/icon.png" type="image/png">
    <title>Buku Tamu</title>
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/style.css">
    <!-- Alpine JS -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
<header class="bg-blue-900 text-white shadow-md">
    <div class="container mx-auto px-4 py-4">
        <div class="flex items-center justify-between">
            <!-- Kiri: Logo -->
            <div class="flex-shrink-0">
                <a href="<?php echo $base_url; ?>/" class="text-2xl font-bold flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class= "w-6 h-6" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path d="M11.25 4.533A9.707 9.707 0 0 0 6 3a9.735 9.735 0 0 0-3.25.555.75.75 0 0 0-.5.707v14.25a.75.75 0 0 0 1 .707A8.237 8.237 0 0 1 6 18.75c1.995 0 3.823.707 5.25 1.886V4.533ZM12.75 20.636A8.214 8.214 0 0 1 18 18.75c.966 0 1.89.166 2.75.47a.75.75 0 0 0 1-.708V4.262a.75.75 0 0 0-.5-.707A9.735 9.735 0 0 0 18 3a9.707 9.707 0 0 0-5.25 1.533v16.103Z" />
                    </svg>
                    <span>Buku Tamu</span>
                </a>
            </div>

            <!-- Tengah: Navigasi -->
            <nav class="flex-1 flex justify-center">
                <ul class="flex space-x-6">
                    <li>
                        <a href="<?php echo $base_url; ?>/" class="hover:font-bold text-white hover:border-b-2 border-white pb-1 transition <?php echo $current_page == 'index.php' ? 'font-bold' : ''; ?>">Beranda</a>
                    </li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li>
                            <a href="<?php echo $base_url; ?>/pages/dashboard.php" class="hover:font-bold text-white hover:border-b-2 border-white pb-1 transition <?php echo $current_page == 'dashboard.php' ? 'font-bold' : ''; ?>">Dashboard</a>
                        </li>
                    <?php endif; ?>
                    <li>
                        <a href="<?php echo $base_url; ?>/pages/about.php" class="hover:font-bold text-white hover:border-b-2 border-white pb-1 transition <?php echo $current_page == 'about.php' ? 'font-bold' : ''; ?>">Tentang Aplikasi</a>
                    </li>
                    <li>
                        <a href="<?php echo $base_url; ?>/pages/faq.php" class="hover:font-bold text-white hover:border-b-2 border-white pb-1 transition <?php echo $current_page == 'faq.php' ? 'font-bold' : ''; ?>">FAQ</a>
                    </li>
                </ul>
            </nav>

            <!-- Kanan: Login / Logout -->
            <div class="flex-shrink-0">
                <ul class="flex space-x-4">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <!-- Jika sudah login -->
                        <li class="relative">
                            <button id="profileDropdownBtn"
                                class="border border-white px-3 py-1.5 rounded-md hover:bg-white/10 flex items-center space-x-2 transition focus:outline-none">
                                <span><?php echo htmlspecialchars($nama); ?></span>
                                <!-- Arrow -->
                                <svg class="h-4 w-4 ml-1" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- Dropdown menu -->
                            <ul id="profileDropdownMenu"
                                class="hidden absolute right-0 mt-2 w-48 bg-white border rounded-md shadow-lg text-gray-800 z-50 transform translate-x-full transition-transform duration-300 ease-in-out">
                                <li><a href="<?php echo $base_url; ?>/pages/edit-profile.php"
                                    class="block px-4 py-2 hover:bg-gray-100">Edit Profile</a></li>
                                <li><a href="<?php echo $base_url; ?>/pages/settings.php"
                                    class="block px-4 py-2 hover:bg-gray-100">Settings</a></li>
                                <li><a href="<?php echo $base_url; ?>/controller/auth/logout.php"
                                    class="block px-4 py-2 hover:bg-gray-100 text-red-600">Logout</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <!-- Jika belum login -->
                        <li>
                            <a href="<?php echo $base_url; ?>/pages/login.php"
                                class="w-24 flex justify-center border border-white px-3 py-1.5 rounded-md hover:bg-white/10 flex items-center space-x-2 transition">
                                <span>Login</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>

<script>
    // Dropdown menu toggle
    const profileBtn = document.getElementById('profileDropdownBtn');
    const dropdownMenu = document.getElementById('profileDropdownMenu');

    if (profileBtn) {
        profileBtn.addEventListener('click', function () {
            dropdownMenu.classList.toggle('hidden');
            dropdownMenu.classList.toggle('translate-x-0'); // Tambahkan kelas untuk transisi
            dropdownMenu.classList.toggle('translate-x-full'); // Tambahkan kelas untuk transisi
        });

        // Optional: Close dropdown if clicked outside
        window.addEventListener('click', function (e) {
            if (!profileBtn.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.classList.add('hidden');
                dropdownMenu.classList.remove('translate-x-0');
                dropdownMenu.classList.add('translate-x-full');
            }
        });
    }
</script>
</header>
<main class="container mx-auto px-4 py-6 flex-grow">