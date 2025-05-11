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
    <h1 class="text-3xl font-bold text-center mb-6">Pertanyaan yang Sering Diajukan (FAQ)</h1>

    <div x-data="{ selected: null }" class="space-y-4">
        <?php
        $faqs = [
            ["Apa itu Buku Tamu Digital?", "Buku tamu digital adalah sistem untuk mencatat kehadiran atau interaksi tamu secara online."],
            ["Apakah data saya aman?", "Ya, kami melindungi data pengguna dengan sistem keamanan dan enkripsi."],
            ["Bagaimana cara login?", "Klik tombol login di kanan atas lalu masukkan email dan kata sandi Anda."],
            ["Apakah saya bisa mengedit komentar saya?", "Untuk saat ini, fitur edit komentar belum tersedia, namun akan dikembangkan di versi selanjutnya."]
        ];
        $index = 1;
        foreach ($faqs as $faq): ?>
            <div class="border border-gray-300 rounded-md">
                <button @click="selected !== <?php echo $index; ?> ? selected = <?php echo $index; ?> : selected = null"
                        class="w-full text-left px-4 py-3 flex justify-between items-center hover:bg-blue-50 transition">
                    <span class="font-medium text-gray-800"><?php echo $faq[0]; ?></span>
                    <svg :class="selected === <?php echo $index; ?> ? 'rotate-180' : ''"
                         class="w-5 h-5 transform transition-transform"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="selected === <?php echo $index; ?>" x-collapse class="px-4 pb-4 text-gray-600">
                    <?php echo $faq[1]; ?>
                </div>
            </div>
        <?php $index++; endforeach; ?>
    </div>

</div>

<?php
// Include footer
include_once '../includes/footer.php';
?>
