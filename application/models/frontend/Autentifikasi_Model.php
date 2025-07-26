<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Autentifikasi_Model extends CI_Model {

    /**
     * Constructor untuk memuat library dan helper.
     */
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('security');
    }

    /**
     * Memeriksa apakah username/email dan password valid.
     *
     * @param string $identifier Username atau email.
     * @param string $password Password yang dimasukkan pengguna.
     * @return object|null Objek pelanggan jika valid, null jika tidak.
     */
    public function login($identifier, $password) {
        // Query untuk mencari pelanggan berdasarkan username atau email
        $this->db->where('username', $identifier)
                 ->or_where('email', $identifier);
        $query = $this->db->get('pelanggan');

        // Jika ditemukan, verifikasi password
        if ($query->num_rows() === 1) {
            $pelanggan = $query->row();

            // Verifikasi password menggunakan password_verify()
            if (password_verify($password, $pelanggan->password)) {
                return $pelanggan; // Return objek pelanggan jika valid
            }
        }

        return null; // Return null jika tidak valid
    }

    /**
     * Mendaftarkan pelanggan baru.
     *
     * @param array $data Data pelanggan baru.
     * @return bool True jika berhasil, false jika gagal.
     */
    public function register($data) {
        // Hash password sebelum disimpan
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);

        // Insert data ke tabel pelanggan
        return $this->db->insert('pelanggan', $data);
    }

    /**
     * Memeriksa apakah username sudah ada.
     *
     * @param string $username Username yang ingin dicek.
     * @return bool True jika sudah ada, false jika belum.
     */
    public function is_username_exists($username) {
        $this->db->where('username', $username);
        return $this->db->get('pelanggan')->num_rows() > 0;
    }

    /**
     * Memeriksa apakah email sudah ada.
     *
     * @param string $email Email yang ingin dicek.
     * @return bool True jika sudah ada, false jika belum.
     */
    public function is_email_exists($email) {
        $this->db->where('email', $email);
        return $this->db->get('pelanggan')->num_rows() > 0;
    }

    /**
     * Memeriksa apakah nomor KWH sudah ada.
     *
     * @param string $nomor_kwh Nomor KWH yang ingin dicek.
     * @return bool True jika sudah ada, false jika belum.
     */
    public function is_nomor_kwh_exists($nomor_kwh) {
        $this->db->where('nomor_kwh', $nomor_kwh);
        return $this->db->get('pelanggan')->num_rows() > 0;
    }
}