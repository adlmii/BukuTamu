// JavaScript untuk aplikasi Buku Tamu

// Menunggu hingga DOM selesai dimuat
document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide notification messages after 5 seconds
    const notifications = document.querySelectorAll('.bg-green-100, .bg-red-100');
    
    if (notifications.length > 0) {
        notifications.forEach(function(notification) {
            notification.classList.add('fade-out');
            
            setTimeout(function() {
                notification.classList.add('hide');
                
                // Setelah animasi selesai, hapus elemen dari DOM
                setTimeout(function() {
                    notification.remove();
                }, 1000);
            }, 5000);
        });
    }
    
    // Konfirmasi password pada form register
    const passwordField = document.getElementById('password');
    const confirmPasswordField = document.getElementById('confirm_password');
    
    if (passwordField && confirmPasswordField) {
        const form = confirmPasswordField.closest('form');
        
        form.addEventListener('submit', function(event) {
            if (passwordField.value !== confirmPasswordField.value) {
                event.preventDefault();
                alert('Konfirmasi password tidak cocok.');
            }
        });
    }

});