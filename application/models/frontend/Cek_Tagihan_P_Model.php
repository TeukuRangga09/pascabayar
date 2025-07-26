<?php

class Cek_Tagihan_P_Model extends CI_Model {

    /**
     * Constructor untuk memuat database.
     */
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Mengambil data tagihan berdasarkan ID pelanggan.
     *
     * @param int $id_pelanggan ID pelanggan.
     * @return array Array objek tagihan.
     */
    public function get_tagihan_by_id_pelanggan($id_pelanggan) {
        return $this->db->select('tagihan.*, pelanggan.nama_pelanggan, pelanggan.nomor_kwh, tarif.daya, tarif.tarifperkwh')
                         ->from('tagihan')
                         ->join('pelanggan', 'pelanggan.id_pelanggan = tagihan.id_pelanggan', 'inner')
                         ->join('tarif', 'tarif.id_tarif = pelanggan.id_tarif', 'inner') // Join dengan tabel tarif
                         ->where('pelanggan.id_pelanggan', $id_pelanggan)
                         ->order_by('tagihan.status', 'ASC')
                         ->order_by('tagihan.tahun', 'DESC')
                         ->order_by("FIELD(tagihan.bulan, 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember')", FALSE)
                         ->get()
                         ->result();
    }

    /**
     * Mengambil data tagihan beserta informasi pelanggan dan tarif berdasarkan ID tagihan.
     *
     * @param int $id_tagihan ID tagihan.
     * @return object|null Objek tagihan atau null jika tidak ditemukan.
     */
    public function get_tagihan_with_tarif($id_tagihan) {
        $query = $this->db->select('tagihan.*, pelanggan.nama_pelanggan, pelanggan.nomor_kwh, pelanggan.id_tarif, tarif.daya, tarif.tarifperkwh')
                          ->from('tagihan')
                          ->join('pelanggan', 'pelanggan.id_pelanggan = tagihan.id_pelanggan', 'inner')
                          ->join('tarif', 'tarif.id_tarif = pelanggan.id_tarif', 'inner')
                          ->where('tagihan.id_tagihan', $id_tagihan)
                          ->get();

        return $query->row(); // Mengembalikan objek atau null jika tidak ditemukan
    }

    /**
     * Memperbarui status tagihan.
     *
     * @param int $id_tagihan ID tagihan.
     * @param array $data Data untuk diperbarui.
     * @return bool True jika berhasil, false jika gagal.
     */
    public function update_status_tagihan($id_tagihan, $data) {
        $this->db->where('id_tagihan', $id_tagihan);
        $this->db->update('tagihan', $data);

        // Return true jika ada baris yang terpengaruh, false jika tidak ada perubahan
        return $this->db->affected_rows() > 0;
    }

    /**
     * Menyimpan data pembayaran ke tabel pembayaran.
     *
     * @param array $data Data pembayaran.
     * @return bool True jika berhasil, false jika gagal.
     */
    public function simpan_pembayaran($data) {
        return $this->db->insert('pembayaran', $data);
    }
}