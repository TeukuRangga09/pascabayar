<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Landing_Model extends CI_Model {

    /**
     * Constructor untuk memuat library dan helper.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Mendapatkan data profil pelanggan berdasarkan ID pelanggan.
     *
     * @param int $id_pelanggan ID pelanggan.
     * @return object|null Objek pelanggan jika ditemukan, null jika tidak.
     */
    // public function get_profil_pelanggan($id_pelanggan) {
    //     $this->db->where('id_pelanggan', $id_pelanggan);
    //     return $this->db->get('pelanggan')->row();
    // }

    /**
     * Mendapatkan tagihan terbaru berdasarkan ID pelanggan.
     *
     * @param int $id_pelanggan ID pelanggan.
     * @return object|null Objek tagihan terbaru jika ditemukan, null jika tidak.
     */
    public function get_tagihan_terbaru($id_pelanggan) {
        $this->db->where('id_pelanggan', $id_pelanggan);
        $this->db->order_by('tahun', 'DESC');
        $this->db->order_by('FIELD(bulan, "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember")', '', FALSE);
        $this->db->limit(1);
        return $this->db->get('tagihan')->row();
    }

    /**
     * Mendapatkan riwayat pembayaran berdasarkan ID pelanggan.
     *
     * @param int $id_pelanggan ID pelanggan.
     * @return array Array objek pembayaran.
     */
    public function get_riwayat_pembayaran($id_pelanggan) {
        $this->db->select('pembayaran.*, tagihan.bulan as bulan_tagihan, tagihan.tahun as tahun_tagihan');
        $this->db->from('pembayaran');
        $this->db->join('tagihan', 'tagihan.id_tagihan = pembayaran.id_tagihan');
        $this->db->where('pembayaran.id_pelanggan', $id_pelanggan);
        $this->db->order_by('pembayaran.tanggal_pembayaran', 'DESC');
        return $this->db->get()->result();
    }
}