<script>
    // Fungsi untuk mendapatkan tanggal sekarang dan memformatnya
    function updateDate() {
        // Mendapatkan tanggal saat ini
        var currentDate = new Date();
        
        // Daftar bulan (untuk nama bulan)
        var months = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];

        // Memformat tanggal dalam format yang diinginkan
        var formattedDate = months[currentDate.getMonth()] + ' ' + currentDate.getDate() + ', ' + currentDate.getFullYear();

        // Mengatur konten teks elemen dengan ID 'current-date'
        document.getElementById('current-date').textContent = formattedDate;
    }

    // Memanggil fungsi updateDate saat halaman dimuat
    document.addEventListener('DOMContentLoaded', updateDate);
</script>