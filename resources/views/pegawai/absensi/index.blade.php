@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold text-gray-800 mb-6">Absensi Harian Pegawai</h1> {{-- Tailwind classes --}}



<div class="flex flex-wrap -mx-4"> {{-- Tailwind flex container for columns --}}
    <div class="w-full md:w-1/2 px-4 mb-6"> {{-- Tailwind column (w-1/2 for md screens) --}}
        <div class="bg-white shadow-md rounded-lg overflow-hidden"> {{-- Tailwind card --}}
            <div class="bg-green-500 text-white px-6 py-4 font-semibold text-lg"> {{-- Tailwind card-header --}}
                Absen Masuk
            </div>
            <div class="p-6"> {{-- Tailwind card-body --}}
                <p class="text-gray-700 text-lg mb-2">Waktu saat ini: <strong id="current-time-masuk"></strong></p>
                <p class="text-gray-700 text-lg mb-4">Tanggal: <strong id="current-date-masuk"></strong></p>

                <form id="formAbsenMasuk" action="{{ route('pegawai.absensi.masuk') }}" method="POST">
                    @csrf
                    <input type="hidden" name="latitude_masuk" id="latitude_masuk">
                    <input type="hidden" name="longitude_masuk" id="longitude_masuk">
                    <button type="submit"
                        class="px-6 py-3 bg-green-600 text-white font-bold rounded-md hover:bg-green-700 transition duration-300"
                        id="absenMasukBtn">Absen Masuk</button>
                    <div id="loading-masuk" class="spinner-border spinner-border-sm text-green-600 ml-2 hidden"
                        role="status"> {{-- Tailwind spinner --}}
                        <span class="sr-only">Loading...</span>
                    </div>
                    <small class="text-gray-500 mt-2 block text-sm">Membutuhkan akses lokasi.</small>
                </form>
            </div>
        </div>
    </div>

    <div class="w-full md:w-1/2 px-4 mb-6"> {{-- Tailwind column --}}
        <div class="bg-white shadow-md rounded-lg overflow-hidden"> {{-- Tailwind card --}}
            <div class="bg-yellow-500 text-gray-800 px-6 py-4 font-semibold text-lg"> {{-- Tailwind card-header --}}
                Absen Pulang
            </div>
            <div class="p-6"> {{-- Tailwind card-body --}}
                <p class="text-gray-700 text-lg mb-2">Waktu saat ini: <strong id="current-time-pulang"></strong></p>
                <p class="text-gray-700 text-lg mb-4">Tanggal: <strong id="current-date-pulang"></strong></p>

                <form id="formAbsenPulang" action="{{ route('pegawai.absensi.pulang') }}" method="POST">
                    @csrf
                    <input type="hidden" name="latitude_pulang" id="latitude_pulang">
                    <input type="hidden" name="longitude_pulang" id="longitude_pulang">
                    <button type="submit"
                        class="px-6 py-3 bg-yellow-600 text-white font-bold rounded-md hover:bg-yellow-700 transition duration-300"
                        id="absenPulangBtn">Absen Pulang</button>
                    <div id="loading-pulang" class="spinner-border spinner-border-sm text-yellow-600 ml-2 hidden"
                        role="status"> {{-- Tailwind spinner --}}
                        <span class="sr-only">Loading...</span>
                    </div>
                    <small class="text-gray-500 mt-2 block text-sm">Membutuhkan akses lokasi.</small>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Script JavaScript untuk Geolocation dan Waktu --}}
@push('scripts')
<script>
// Fungsi untuk memperbarui waktu secara real-time
function updateCurrentTime() {
    const now = new Date();
    const timeString = now.toLocaleTimeString('id-ID', {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
    });
    const dateString = now.toLocaleDateString('id-ID', {
        day: '2-digit',
        month: 'long',
        year: 'numeric'
    });
    document.getElementById('current-time-masuk').textContent = timeString;
    document.getElementById('current-date-masuk').textContent = dateString;
    document.getElementById('current-time-pulang').textContent = timeString;
    document.getElementById('current-date-pulang').textContent = dateString;
}
setInterval(updateCurrentTime, 1000); // Perbarui setiap detik
updateCurrentTime(); // Panggil pertama kali saat halaman dimuat

// Fungsi untuk mendapatkan lokasi GPS dan submit form
function getLocationAndSubmit(formId, latInputId, longInputId, submitBtnId, loadingId) {
    const submitBtn = document.getElementById(submitBtnId);
    const loadingSpinner = document.getElementById(loadingId);
    const form = document.getElementById(formId);

    submitBtn.disabled = true; // Disable tombol saat proses dimulai
    loadingSpinner.classList.remove('hidden'); // Tampilkan spinner (Tailwind class)

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                document.getElementById(latInputId).value = position.coords.latitude;
                document.getElementById(longInputId).value = position.coords.longitude;
                form.submit(); // Submit form setelah lokasi didapat
            },
            (error) => {
                // Tangani error jika pengguna menolak akses lokasi atau ada masalah lain
                let errorMessage;
                switch (error.code) {
                    case error.PERMISSION_DENIED:
                        errorMessage = "Akses lokasi ditolak. Harap izinkan akses lokasi untuk absen.";
                        break;
                    case error.POSITION_UNAVAILABLE:
                        errorMessage = "Informasi lokasi tidak tersedia.";
                        break;
                    case error.TIMEOUT:
                        errorMessage = "Permintaan mendapatkan lokasi timeout.";
                        break;
                    case error.UNKNOWN_ERROR:
                        errorMessage = "Terjadi kesalahan tidak dikenal saat mendapatkan lokasi.";
                        break;
                }
                alert("Kesalahan GPS: " + errorMessage);
                submitBtn.disabled = false; // Aktifkan kembali tombol
                loadingSpinner.classList.add('hidden'); // Sembunyikan spinner (Tailwind class)
            }, {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
            } // Opsi akurasi tinggi, timeout 10 detik
        );
    } else {
        alert("Geolocation tidak didukung oleh browser Anda.");
        submitBtn.disabled = false; // Aktifkan kembali tombol
        loadingSpinner.classList.add('hidden'); // Sembunyikan spinner (Tailwind class)
    }
}

// Event listener untuk tombol Absen Masuk
document.getElementById('absenMasukBtn').addEventListener('click', function(event) {
    event.preventDefault(); // Mencegah submit form secara default
    getLocationAndSubmit('formAbsenMasuk', 'latitude_masuk', 'longitude_masuk', 'absenMasukBtn',
        'loading-masuk');
});

// Event listener untuk tombol Absen Pulang
document.getElementById('absenPulangBtn').addEventListener('click', function(event) {
    event.preventDefault(); // Mencegah submit form secara default
    getLocationAndSubmit('formAbsenPulang', 'latitude_pulang', 'longitude_pulang', 'absenPulangBtn',
        'loading-pulang');
});
</script>
@endpush
@endsection