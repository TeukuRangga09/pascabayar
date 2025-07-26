<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaturan_Akun_Model_Backend extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Mengambil data user berdasarkan ID
    public function get_user_by_id($id_user) {
        return $this->db->get_where('user', ['id_user' => $id_user])->row_array();
    }

    // Update data user
    public function update_profile($id_user, $data) {
        $this->db->where('id_user', $id_user);
        return $this->db->update('user', $data);
    }

    // Update password
    public function update_password($id_user, $new_password) {
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
        $sql = "UPDATE user SET password = ? WHERE id_user = ?";
        return $this->db->query($sql, [$hashed_password, $id_user]);
    }

    // Upload foto profil
    public function update_foto_profil($id_user, $foto_profil) {
        $this->db->where('id_user', $id_user);
        return $this->db->update('user', ['foto_profil' => $foto_profil]);
    }
}