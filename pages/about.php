<?php
// Memulai session jika belum dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Mendapatkan URL saat ini
$current_page = basename($_SERVER['PHP_SELF']);

// Include header
include_once '../includes/header.php';
?>

<div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6">
    <h1 class="text-3xl font-bold text-center mb-6">Tentang Aplikasi Buku Tamu</h1>

    <p class="text-gray-700 mb-4">
        Aplikasi <strong>Buku Tamu</strong> ini merupakan sistem berbasis web yang memungkinkan pengguna untuk memberikan komentar atau pesan secara online. Aplikasi ini dibangun menggunakan PHP, MySQL, dan Tailwind CSS, serta dilengkapi dengan fitur-fitur penting seperti autentikasi dan pengelolaan komentar.
    </p>

    <h2 class="text-xl font-semibold mb-4">Fitur</h2>
    <ul class="list-disc list-inside text-gray-700 space-y-2">
        <li>Registrasi dan Login user</li>
        <li>Sistem autentikasi dan session</li>
        <li>Penambahan komentar oleh user yang telah login</li>
        <li>Manajemen komentar (lihat, tambah, edit, hapus)</li>
        <li>Interface responsif dengan Tailwind CSS</li>
    </ul>

    <h2 class="text-xl font-semibold mt-6 mb-4">Teknologi yang Digunakan</h2>
    <ul class="list-disc list-inside text-gray-700 space-y-2">
        <li>PHP untuk backend</li>
        <li>MySQL untuk database</li>
        <li>HTML, CSS, dan JavaScript untuk frontend</li>
        <li>Tailwind CSS untuk styling</li>
        <li>Alpine.js untuk interaktivitas</li>
    </ul>

    <h2 class="text-xl font-semibold mt-6 mb-4">Pengembang</h2>
    <p class="text-gray-700 mb-4">
        Aplikasi ini dikembangkan oleh [Nama Anda] sebagai bagian dari pembelajaran pemrograman web. Jika Anda memiliki pertanyaan atau saran, silakan hubungi saya melalui email pada <a href="mailto:aidilfahmi601@gmail.com" class="text-blue-500 underline">tautan ini</a>.
    </p>
</div>
    
<?php
// Include footer
include_once '../includes/footer.php';
?>
