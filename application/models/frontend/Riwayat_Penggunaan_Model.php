<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Riwayat_Penggunaan_Model extends CI_Model {

    public function get_riwayat_penggunaan_detail($id_pelanggan) {
        // Query untuk mengambil data riwayat penggunaan dengan detail tambahan
        $this->db->select('
            penggunaan.bulan,
            penggunaan.tahun,
            penggunaan.meter_awal,
            penggunaan.meter_akhir,
            penggunaan.created_at AS tanggal_input,
            (penggunaan.meter_akhir - penggunaan.meter_awal) AS jumlah_meter,
            tarif.daya AS tipe_daya,
            tarif.tarifperkwh,
            (penggunaan.meter_akhir - penggunaan.meter_awal) * tarif.tarifperkwh AS total_tagihan,
            tagihan.status AS status_pembayaran
        ');
        $this->db->from('penggunaan');
        $this->db->join('pelanggan', 'penggunaan.id_pelanggan = pelanggan.id_pelanggan', 'left');
        $this->db->join('tarif', 'pelanggan.id_tarif = tarif.id_tarif', 'left');
        $this->db->join('tagihan', 'penggunaan.id_penggunaan = tagihan.id_penggunaan', 'left');
        $this->db->where('penggunaan.id_pelanggan', $id_pelanggan);
        $this->db->order_by('penggunaan.tahun DESC, FIELD(penggunaan.bulan, "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember") DESC');
        $query = $this->db->get();

        // Kembalikan hasil query sebagai array
        return $query->result();
    }
}
