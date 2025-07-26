<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Riwayat_Pembayaran_Model extends CI_Model {
    public function get_riwayat_pembayaran_detail($id_pelanggan) {
        $this->db->select('
            pembayaran.tanggal_pembayaran,
            pembayaran.bulan_bayar,
            pembayaran.biaya_admin,
            pembayaran.total_bayar,
            pembayaran.metode_pembayaran,
            tagihan.id_tagihan,
            tagihan.bukti_pembayaran,
            tagihan.status AS status_pembayaran,
            pelanggan.nomor_kwh,
            tagihan.jumlah_meter,
            tarif.tarifperkwh
        ');
        $this->db->from('pembayaran');
        $this->db->join('tagihan', 'pembayaran.id_tagihan = tagihan.id_tagihan', 'left');
        $this->db->join('pelanggan', 'pembayaran.id_pelanggan = pelanggan.id_pelanggan', 'left');
        $this->db->join('tarif', 'pelanggan.id_tarif = tarif.id_tarif', 'left');
        $this->db->where('pembayaran.id_pelanggan', $id_pelanggan);

        $this->db->order_by("FIELD(pembayaran.bulan_bayar, 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember') DESC");
        $this->db->order_by('pembayaran.tanggal_pembayaran DESC'); 

        $query = $this->db->get();
        return $query->result();
    }
}