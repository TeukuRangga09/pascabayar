<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tagihan_Model_Backend extends CI_Model {

    protected $table = 'tagihan';
    protected $table_pembayaran = 'pembayaran';

    public function get_filtered_tagihans($status_filter = null, $nomor_kwh_search = null) {
        $this->db->select('
            tagihan.*,
            pelanggan.nama_pelanggan,
            pelanggan.nomor_kwh,
            pelanggan.alamat,
            tarif.tarifperkwh
        ');

        // Join tabel
        $this->db->join('pelanggan', 'tagihan.id_pelanggan = pelanggan.id_pelanggan', 'left');
        $this->db->join('tarif', 'pelanggan.id_tarif = tarif.id_tarif', 'left');

        // Filter berdasarkan status (jika ada)
        if ($status_filter) {
            $this->db->where('tagihan.status', $status_filter);
        }

        // Pencarian berdasarkan nomor kWh (jika ada)
        if ($nomor_kwh_search) {
            $this->db->like('pelanggan.nomor_kwh', $nomor_kwh_search);
        }

        // Urutkan berdasarkan tanggal tagihan (opsional)
        $this->db->order_by('tagihan.tanggal_tagihan', 'DESC');

        // Ambil data
        return $this->db->get('tagihan')->result_array();
    }

    public function get_tagihan_by_id($id_tagihan) {
        $this->db->select('
            tagihan.*, 
            pelanggan.nama_pelanggan, 
            pelanggan.nomor_kwh, 
            pelanggan.alamat, 
            pelanggan.id_tarif, 
            tarif.tarifperkwh, 
            tarif.daya,
            penggunaan.meter_awal AS stand_meter_awal,
            penggunaan.meter_akhir AS stand_meter_akhir
            ');
        $this->db->from('tagihan');
        $this->db->join('pelanggan', 'tagihan.id_pelanggan = pelanggan.id_pelanggan');
        $this->db->join('tarif', 'pelanggan.id_tarif = tarif.id_tarif');
        $this->db->join('penggunaan', 'tagihan.id_pelanggan = penggunaan.id_pelanggan AND tagihan.bulan = penggunaan.bulan AND tagihan.tahun = penggunaan.tahun', 'left');
        $this->db->where('tagihan.id_tagihan', $id_tagihan);
        return $this->db->get()->row_array();
    }

    // Fungsi untuk mengupdate status verifikasi
    public function update_verifikasi($id_tagihan, $status) {
        $this->db->where('id_tagihan', $id_tagihan);
        return $this->db->update('tagihan', ['status' => $status]);
    }

    // Fungsi untuk mendapatkan data bukti pembayaran
    public function get_bukti_pembayaran($id_tagihan) {
        $this->db->select('bukti_pembayaran');
        $this->db->from('tagihan');
        $this->db->where('id_tagihan', $id_tagihan);
        $query = $this->db->get();
        return $query->row_array();
    }

    // Mendapatkan data pembayaran berdasarkan id_tagihan
    public function get_pembayaran_by_tagihan($id_tagihan) {
        $this->db->where('id_tagihan', $id_tagihan);
        return $this->db->get($this->table_pembayaran)->row_array();
    }

public function update_status_tagihan($id_tagihan, $status) {
    $this->db->where('id_tagihan', $id_tagihan);
    $result = $this->db->update('tagihan', ['status' => $status]);

    // Debugging: Cek apakah query berhasil
    if (!$result) {
        log_message('error', 'Gagal memperbarui status tagihan: ' . $this->db->error()['message']);
    }

    return $result;
}

    // Menambahkan data pembayaran baru
    public function insert_pembayaran($data) {
        return $this->db->insert($this->table_pembayaran, $data);
    }

    // Menghapus data tagihan berdasarkan id_tagihan
    public function delete_tagihan($id_tagihan) {
        $this->db->where('id_tagihan', $id_tagihan);
        return $this->db->delete($this->table);
    }
}