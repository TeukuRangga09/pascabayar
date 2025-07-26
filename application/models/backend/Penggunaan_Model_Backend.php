<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penggunaan_Model_Backend extends CI_Model {

    protected $table = 'penggunaan';

    // Model: Penggunaan_Model_Backend.php

    public function get_filtered_penggunas($status = null, $nomor_kwh = null) {
        $this->db->select('penggunaan.*, pelanggan.nama_pelanggan, pelanggan.nomor_kwh');
        $this->db->join('pelanggan', 'penggunaan.id_pelanggan = pelanggan.id_pelanggan', 'left');

        // Filter berdasarkan status pembayaran
        if ($status) {
            $this->db->join('tagihan', 'penggunaan.id_penggunaan = tagihan.id_penggunaan', 'left');
            $this->db->where('tagihan.status', $status);
        }

        // Filter berdasarkan nomor KWH
        if ($nomor_kwh) {
            $this->db->where('pelanggan.nomor_kwh', $nomor_kwh);
        }

        return $this->db->get('penggunaan')->result_array();
    }

    // Mendapatkan semua data penggunaan
    public function get_all_penggunas() {
        $this->db->select('penggunaan.*, pelanggan.nama_pelanggan');
        $this->db->join('pelanggan', 'penggunaan.id_pelanggan = pelanggan.id_pelanggan', 'left');
        return $this->db->get($this->table)->result_array();
    }

    // Mendapatkan semua data pelanggan
    public function get_all_pelanggans() {
        return $this->db->get('pelanggan')->result_array();
    }

    // Menambahkan data penggunaan baru
    public function insert_penggunaan($data) {
        return $this->db->insert($this->table, $data);
    }

    // Mengupdate data penggunaan berdasarkan id_penggunaan
    public function update_penggunaan($id_penggunaan, $data) {
        $this->db->where('id_penggunaan', $id_penggunaan);
        return $this->db->update($this->table, $data);
    }

    // Menghapus data penggunaan berdasarkan id_penggunaan
    public function delete_penggunaan($id_penggunaan) {
        $this->db->where('id_penggunaan', $id_penggunaan);
        return $this->db->delete($this->table);
    }
}