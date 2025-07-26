<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_Model_Backend extends CI_Model {

    // Fungsi untuk mengambil data penggunaan listrik bulanan
    public function get_monthly_usage($year) {
        $this->db->select('bulan, SUM(meter_akhir - meter_awal) as total_usage');
        $this->db->from('penggunaan');
        $this->db->where('tahun', $year);
        $this->db->group_by('bulan');
        $this->db->order_by('FIELD(bulan, "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember")');
        return $this->db->get()->result_array();
    }

    // Fungsi untuk mengambil data status tagihan berdasarkan tahun tertentu
    public function get_bill_status_summary($tahun) {
        $this->db->select('status, COUNT(*) as total');
        $this->db->from('tagihan');
        $this->db->where('tahun', $tahun); // Filter berdasarkan tahun
        $this->db->group_by('status');
        return $this->db->get()->result_array();
    }

    // Fungsi untuk menghitung total pelanggan berdasarkan tahun tertentu
    public function get_total_pelanggan_per_tahun($tahun) {
        $this->db->select('COUNT(*) as total_pelanggan');
        $this->db->from('pelanggan');
        $this->db->where("YEAR(created_at)", $tahun); // Filter berdasarkan tahun
        $query = $this->db->get();
        return $query->row_array(); // Mengembalikan hasil sebagai array asosiatif
    }

    // Fungsi untuk menghitung statistik penggunaan per tahun
    public function get_penggunaan_statistics($tahun) {
        $this->db->select("SUM(meter_akhir - meter_awal) as total_kwh, COUNT(*) as total_record");
        $this->db->from('penggunaan');
        $this->db->where('tahun', $tahun); // Filter berdasarkan tahun
        $query = $this->db->get();
        return $query->row_array(); // Mengembalikan hasil sebagai array asosiatif
    }

    // Fungsi untuk menghitung statistik pembayaran per tahun
    public function get_pembayaran_statistics($tahun) {
        $this->db->select("SUM(total_bayar) as total_pembayaran, COUNT(*) as total_record");
        $this->db->from('pembayaran');
        $this->db->where("YEAR(tanggal_pembayaran)", $tahun); // Filter berdasarkan tahun
        $query = $this->db->get();
        return $query->row_array(); // Mengembalikan hasil sebagai array asosiatif
    }
}