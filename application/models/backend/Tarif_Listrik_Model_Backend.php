<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tarif_Listrik_Model_Backend extends CI_Model {

    // Ambil semua data tarif
    public function get_all_tarif() {
        return $this->db->get('tarif')->result();
    }

    // Ambil data tarif berdasarkan ID
    public function get_tarif_by_id($id_tarif) {
        return $this->db->get_where('tarif', ['id_tarif' => $id_tarif])->row();
    }

    // Update data tarif
    public function update_tarif($id_tarif, $data) {
        $this->db->where('id_tarif', $id_tarif);
        $this->db->update('tarif', $data);
    }

    // Hapus data tarif
    public function delete_tarif($id_tarif) {
        $this->db->where('id_tarif', $id_tarif);
        $this->db->delete('tarif');
    }

    public function add_tarif($data) {
        $this->db->insert('tarif', $data);
    }
}