<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Level_Pengguna_Model_Backend extends CI_Model {

    protected $table = 'level';

    // Mendapatkan semua data level
    public function get_all_levels() {
        return $this->db->get($this->table)->result_array();
    }

    // Menambahkan data level baru
    public function insert_level($data) {
        return $this->db->insert($this->table, $data);
    }

    // Mengupdate data level berdasarkan id_level
    public function update_level($id_level, $data) {
        $this->db->where('id_level', $id_level);
        return $this->db->update($this->table, $data);
    }

    // Menghapus data level berdasarkan id_level
    public function delete_level($id_level) {
        $this->db->where('id_level', $id_level);
        return $this->db->delete($this->table);
    }
}