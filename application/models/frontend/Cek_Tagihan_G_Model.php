<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cek_Tagihan_G_Model extends CI_Model {

    /**
     * Fungsi untuk memeriksa nomor KWH apakah valid atau tidak.
     *
     * @param string $nomor_kwh Nomor KWH yang akan dicek.
     * @return object|null Mengembalikan objek pelanggan jika ditemukan, null jika tidak valid.
     */
    public function check_nomor_kwh($nomor_kwh) {
        // Validasi input
        if (empty($nomor_kwh) || !is_numeric($nomor_kwh) || strlen($nomor_kwh) < 6) {
            return null;
        }

        // Query untuk mencari pelanggan berdasarkan nomor KWH
        $this->db->select('id_pelanggan, nama_pelanggan, nomor_kwh');
        $this->db->from('pelanggan');
        $this->db->where('nomor_kwh', $nomor_kwh);
        $query = $this->db->get();

        // Mengembalikan hasil query sebagai objek atau null jika tidak ditemukan
        return $query->row();
    }

    /**
     * Fungsi untuk mendapatkan tagihan berdasarkan nomor KWH.
     *
     * @param string $nomor_kwh Nomor KWH yang akan dicari.
     * @return array Mengembalikan array objek tagihan atau array kosong jika tidak ada data.
     */
    public function get_tagihan_by_nomor_kwh($nomor_kwh) {
        // Validasi input
        if (empty($nomor_kwh) || !is_numeric($nomor_kwh)) {
            return [];
        }

        // Mendapatkan ID pelanggan berdasarkan nomor KWH
        $pelanggan = $this->check_nomor_kwh($nomor_kwh);
        if (!$pelanggan) {
            return [];
        }

        // Query untuk mendapatkan data tagihan
        $this->db->select('
            tagihan.*,
            pelanggan.nama_pelanggan,
            pelanggan.nomor_kwh,
            tarif.daya,
            tarif.tarifperkwh
        ');
        $this->db->from('tagihan');
        $this->db->join('pelanggan', 'pelanggan.id_pelanggan = tagihan.id_pelanggan', 'inner');
        $this->db->join('tarif', 'tarif.id_tarif = pelanggan.id_tarif', 'inner');
        $this->db->where('pelanggan.nomor_kwh', $nomor_kwh);
        $this->db->order_by('tagihan.status', 'ASC');
        $this->db->order_by('tagihan.tahun', 'DESC');
        $this->db->order_by("FIELD(tagihan.bulan, 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember')", FALSE);

        // Eksekusi query
        $query = $this->db->get();

        // Mengembalikan hasil query sebagai array objek atau array kosong jika tidak ada data
        return $query->result();
    }
}