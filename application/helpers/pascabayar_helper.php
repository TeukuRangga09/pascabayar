<?php
if (!function_exists('level_user')) {
    /**
     * Fungsi untuk mendapatkan label level berdasarkan nilai level.
     *
     * @param string $level Nilai level dari session atau database.
     * @return string Label level yang telah dipetakan.
     */
    function level_user($level) {
        // Mapping level ke label deskriptif
        $levelMapping = [
            'admin' => 'Administrator',
            'petugas' => 'Petugas Berwenang',
            // Tambahkan level lain jika diperlukan
        ];

        // Gunakan nilai mapping jika ada, jika tidak gunakan nilai asli
        return $levelMapping[$level] ?? $level;
    }
}

if (!function_exists('is_active')) {
    /**
     * Fungsi untuk mengecek halaman aktif
     *
     * @param string $route Route yang ingin dicek
     * @return bool True jika route aktif, false jika tidak
     */
    function is_active($route) {
        $CI =& get_instance(); // Mengambil instance CodeIgniter
        return ($CI->uri->uri_string() === $route); // Gunakan === untuk memastikan kecocokan tepat
    }
}

if (!function_exists('is_parent_active')) {
    /**
     * Fungsi untuk mengecek apakah salah satu submenu aktif
     *
     * @param array $routes Array route yang ingin dicek
     * @return bool True jika salah satu route aktif, false jika tidak
     */
    function is_parent_active($routes) {
        $CI =& get_instance(); // Mengambil instance CodeIgniter
        foreach ($routes as $route) {
            if ($CI->uri->uri_string() === $route) { // Gunakan === untuk memastikan kecocokan tepat
                return true;
            }
        }
        return false;
    }
}

// if (!function_exists('rupiah')) {
//     function rupiah($angka, $desimal = 2) {
//         return 'Rp ' . number_format($angka, $desimal, ',', '.');
//     }
// }
if (!function_exists('rupiah')) {
    function rupiah($angka) {
        // Pastikan angka dibulatkan ke bilangan bulat terdekat
        $angka = round($angka);
        // Format angka tanpa desimal
        return 'Rp ' . number_format($angka, 0, ',', '.');
    }
}

if (!function_exists('format_kwh')) {
    function format_kwh($angka) {
        // Hilangkan bagian desimal dan format angka tanpa koma
        return number_format($angka, 0, ',', '.');
    }
}

if (!function_exists('generate_nomor_kwh')) {
    function generate_nomor_kwh($length = 12) {
        // Nomor meter PLN biasanya terdiri dari 11-12 digit angka
        $nomor_kwh = '';
        for ($i = 0; $i < $length; $i++) {
            $nomor_kwh .= rand(0, 9);
        }
        return $nomor_kwh;
    }
}

// Fungsi untuk memastikan nomor KWH unik
if (!function_exists('get_unique_nomor_kwh')) {
    function get_unique_nomor_kwh($CI) {
        do {
            $nomor_kwh = generate_nomor_kwh();
            // Periksa apakah nomor KWH sudah ada di database
            $exists = $CI->db->get_where('pelanggan', ['nomor_kwh' => $nomor_kwh])->row();
        } while ($exists); // Jika nomor KWH sudah ada, ulangi proses

        return $nomor_kwh;
    }
}

if (!function_exists('bulan_indonesia')) {
    function bulan_indonesia($bulan) {
        $bulan_array = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];
        return $bulan_array[$bulan] ?? '';
    }
}

function format_tanggal_id($tanggal) {
    $hari = [
        'Sunday' => 'Minggu',
        'Monday' => 'Senin',
        'Tuesday' => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday' => 'Kamis',
        'Friday' => 'Jumat',
        'Saturday' => 'Sabtu'
    ];

    $bulan = [
        '01' => 'Januari',
        '02' => 'Februari',
        '03' => 'Maret',
        '04' => 'April',
        '05' => 'Mei',
        '06' => 'Juni',
        '07' => 'Juli',
        '08' => 'Agustus',
        '09' => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Desember'
    ];

    $timestamp = strtotime($tanggal);
    $hari_id = $hari[date('l', $timestamp)];
    $tgl = date('d', $timestamp);
    $bulan_id = $bulan[date('m', $timestamp)];
    $tahun = date('Y', $timestamp);

    return "$hari_id, $tgl $bulan_id $tahun";
}


// function is_active($route1, $route2 = null) {
//     $current_url = uri_string(); 
//     return ($current_url === $route1 || $current_url === $route2);
// }


if (!function_exists('format_nama_pelanggan')) {
    function format_nama_pelanggan($nama) {
        $nama_array = explode(' ', trim($nama));
        $nama_array = array_slice($nama_array, 0, 2); // Ambil maksimal 2 kata

        $kata_pertama = isset($nama_array[0]) ? $nama_array[0] : '';
        $kata_kedua = isset($nama_array[1]) ? $nama_array[1] : '';

        // Gabungkan keduanya dalam satu span agar tidak terpisah ke bawah
        if ($kata_kedua) {
            return '<span class="text-nowrap"><span class="text-primary">' . htmlspecialchars($kata_pertama, ENT_QUOTES, 'UTF-8') . '</span> ' . htmlspecialchars($kata_kedua, ENT_QUOTES, 'UTF-8') . '</span>';
        } else {
            return '<span class="text-primary text-nowrap">' . htmlspecialchars($kata_pertama, ENT_QUOTES, 'UTF-8') . '</span>';
        }
    }
}
