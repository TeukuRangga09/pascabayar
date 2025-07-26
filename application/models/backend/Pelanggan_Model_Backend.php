<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelanggan_Model_Backend extends CI_Model {

    protected $table = 'pelanggan';

    // Mendapatkan semua data pelanggan
    public function get_all_pelanggans() {
        $this->db->select('pelanggan.*, tarif.daya, tarif.tarifperkwh');
        $this->db->join('tarif', 'pelanggan.id_tarif = tarif.id_tarif', 'left');
        return $this->db->get($this->table)->result_array();
    }

    // Mendapatkan semua data tarif
    public function get_all_tarifs() {
        return $this->db->get('tarif')->result_array();
    }

    // Menambahkan data pelanggan baru
    public function insert_pelanggan($data) {
        return $this->db->insert($this->table, $data);
    }

    // Mengupdate data pelanggan berdasarkan id_pelanggan
    public function update_pelanggan($id_pelanggan, $data) {
        $this->db->where('id_pelanggan', $id_pelanggan);
        return $this->db->update($this->table, $data);
    }

    // Menghapus data pelanggan berdasarkan id_pelanggan
    public function delete_pelanggan($id_pelanggan) {
        $this->db->where('id_pelanggan', $id_pelanggan);
        return $this->db->delete($this->table);
    }
}