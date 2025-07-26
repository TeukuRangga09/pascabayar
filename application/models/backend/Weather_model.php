<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Weather_model extends CI_Model {

    public function get_weather_data($city) {
        // Cek apakah data sudah ada di cache
        $cache_file = APPPATH . 'cache/weather_' . md5($city) . '.json';
        if (file_exists($cache_file) && (time() - filemtime($cache_file)) < 3600) {
            // Baca data dari cache jika masih valid (kurang dari 1 jam)
            $cached_data = json_decode(file_get_contents($cache_file), true);
            if (!empty($cached_data) && isset($cached_data['main'])) {
                return $cached_data;
            }
        }

        // Jika tidak ada cache, ambil data dari API
        $api_key = 'f35096bd85d02681911efb0e02a495a1';
        $url = "https://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$api_key}&units=metric";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5); // Timeout koneksi
        curl_setopt($ch, CURLOPT_TIMEOUT, 10); // Timeout eksekusi

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $data = json_decode($response, true);

        // Validasi jika respons API valid
        if ($http_code === 200 && isset($data['main'])) {
            // Simpan data ke cache hanya jika valid
            file_put_contents($cache_file, json_encode($data));
            return $data;
        } else {
            // Jika API error, hapus cache lama untuk menghindari data usang
            if (file_exists($cache_file)) {
                unlink($cache_file);
            }
            log_message('error', "Weather API Error ({$http_code}): " . json_encode($data));
            return null;
        }
    }
}
