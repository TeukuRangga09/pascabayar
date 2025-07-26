<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Autentifikasi_Model_Backend extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function check_login($username, $password) {
        $this->db->select('user.*, level.nama_level');
        $this->db->from('user');
        $this->db->join('level', 'user.id_level = level.id_level', 'left');
        $this->db->where('user.username', $username);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            $user = $query->row();
            log_message('debug', 'User data: ' . print_r($user, true)); // Debugging

            // Verifikasi password
            if (password_verify($password, $user->password)) {
                return $user; // Login berhasil
            } else {
                log_message('debug', 'Password verification failed'); // Debugging
            }
        } else {
            log_message('debug', 'No user found with username: ' . $username); // Debugging
        }
        return false; // Login gagal
    }
}