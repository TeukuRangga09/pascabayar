<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembayaran_Model_Backend extends CI_Model {

    protected $table = 'pembayaran';

    // Mendapatkan semua data pembayaran dengan filter tahun dan bulan dari tanggal_pembayaran
    public function get_filtered_pembayaran($tahun = null, $bulan = null) {
        $this->db->select('pembayaran.*, pelanggan.nama_pelanggan, MONTH(tanggal_pembayaran) as bulan, YEAR(tanggal_pembayaran) as tahun');
        $this->db->from($this->table);
        $this->db->join('pelanggan', 'pembayaran.id_pelanggan = pelanggan.id_pelanggan', 'left');

        if (!empty($tahun)) {
            $this->db->where('YEAR(tanggal_pembayaran)', $tahun);
        }
        if (!empty($bulan)) {
            $this->db->where('MONTH(tanggal_pembayaran)', $bulan);
        }

        return $this->db->get()->result_array();
    }

    // Menghapus data pembayaran berdasarkan id_pembayaran
    public function delete_pembayaran($id_pembayaran) {
        $this->db->where('id_pembayaran', $id_pembayaran);
        return $this->db->delete($this->table);
    }
}