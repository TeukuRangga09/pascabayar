<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelola_Pengguna_Model_Backend extends CI_Model {

    protected $table = 'user';

    // Mendapatkan semua data pengguna
    public function get_all_users() {
        $this->db->select('user.*, level.nama_level');
        $this->db->join('level', 'user.id_level = level.id_level', 'left');
        return $this->db->get($this->table)->result_array();
    }

    // Mendapatkan semua data level
    public function get_all_levels() {
        return $this->db->get('level')->result_array();
    }

    // Menambahkan data pengguna baru
    public function insert_user($data) {
        return $this->db->insert($this->table, $data);
    }

    // Mengupdate data pengguna berdasarkan id_user
    public function update_user($id_user, $data) {
        $this->db->where('id_user', $id_user);
        return $this->db->update($this->table, $data);
    }

    // Menghapus data pengguna berdasarkan id_user
    public function delete_user($id_user) {
        $this->db->where('id_user', $id_user);
        return $this->db->delete($this->table);
    }
}