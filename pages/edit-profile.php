<?php
// Include header
include_once '../includes/header.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: ../login.php");
    exit();
}
?>

<div class="max-w-3xl mx-auto mt-10 p-8 bg-white rounded-xl shadow-md space-y-8">
  <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Edit Profile</h2>

  <!-- Display success message -->
  <?php if (isset($_SESSION['success_message'])): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded mb-6">
      <?php echo htmlspecialchars($_SESSION['success_message']); ?>
    </div>
    <?php unset($_SESSION['success_message']); ?>
  <?php endif; ?>

  <!-- Display error messages -->
  <?php if (isset($_SESSION['profile_errors'])): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded mb-6">
      <ul class="list-disc list-inside">
        <?php foreach ($_SESSION['profile_errors'] as $error): ?>
          <li><?php echo htmlspecialchars($error); ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <?php unset($_SESSION['profile_errors']); ?>
  <?php endif; ?>

  <!-- Form Edit Profile -->
  <form method="POST" action="../controller/auth/edit_profile_process.php" class="space-y-8">
    
    <!-- ID (Hidden) -->
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($_SESSION['user_id'] ?? ''); ?>">

    <!-- Informasi Akun -->
    <div class="space-y-6 bg-gray-50 p-6 rounded-lg">
      <h3 class="text-xl font-semibold text-gray-800 border-b pb-2">Informasi Akun</h3>
      
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label for="username" class="block text-sm font-medium text-gray-700 mb-2">Username</label>
          <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($_SESSION['username'] ?? ''); ?>" required
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-base">
        </div>
        
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
          <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_SESSION['email'] ?? ''); ?>" required
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-base">
        </div>
      </div>
    </div>

    <!-- Informasi Pribadi -->
    <div class="space-y-6 bg-gray-50 p-6 rounded-lg">
      <h3 class="text-xl font-semibold text-gray-800 border-b pb-2">Informasi Pribadi</h3>
      
      <div>
        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($_SESSION['name'] ?? ''); ?>" required
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-base">
      </div>
    </div>

    <!-- Ganti Password -->
    <div class="space-y-6 bg-gray-50 p-6 rounded-lg">
      <h3 class="text-xl font-semibold text-gray-800 border-b pb-2">Ganti Password</h3>
      <p class="text-sm text-gray-600 mb-4">Kosongkan semua field password jika Anda tidak ingin mengubahnya</p>
      
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Password Saat Ini</label>
          <input type="password" id="current_password" name="current_password"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-base">
        </div>
        
        <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
            <input type="password" id="new_password" name="new_password"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-base">
            <p class="text-xs text-gray-500 mt-1">Minimal 8 karakter</p>
          </div>
          
          <div>
            <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password Baru</label>
            <input type="password" id="confirm_password" name="confirm_password"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-base">
          </div>
        </div>
      </div>
    </div>

    <div class="flex space-x-4 pt-4">
      <a href="../profile.php" 
         class="w-1/3 bg-gray-500 hover:bg-gray-600 text-white font-semibold py-3 px-6 rounded-lg transition duration-300 text-center">
        Batal
      </a>
      <button type="submit"
              class="w-2/3 bg-blue-800 hover:bg-blue-900 text-white font-semibold py-3 px-6 rounded-lg transition duration-300">
        Simpan Perubahan
      </button>
    </div>
  </form>
</div>

<script>
  // Simple form validation
  document.querySelector('form').addEventListener('submit', function(event) {
    const newPassword = document.getElementById('new_password').value;
    const confirmPassword = document.getElementById('confirm_password').value;
    const currentPassword = document.getElementById('current_password').value;
    
    // If trying to change password
    if (newPassword || confirmPassword || currentPassword) {
      // Check if current password is provided
      if (!currentPassword) {
        alert('Mohon masukkan password saat ini untuk mengubah password');
        event.preventDefault();
        return;
      }
      
      // Check if both new password fields are filled
      if (!newPassword || !confirmPassword) {
        alert('Mohon isi kedua field password baru');
        event.preventDefault();
        return;
      }
      
      // Check if passwords match
      if (newPassword !== confirmPassword) {
        alert('Password baru tidak cocok dengan konfirmasi');
        event.preventDefault();
        return;
      }
      
      // Check password length
      if (newPassword.length < 8) {
        alert('Password baru harus minimal 8 karakter');
        event.preventDefault();
        return;
      }
    }
  });
</script>

<?php
// Include footer
include_once '../includes/footer.php';
?>