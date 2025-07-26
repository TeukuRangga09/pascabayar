<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profil_Model extends CI_Model {

    public function get_profil_detail($id_pelanggan) {
        $this->db->select("
            pelanggan.*,
            tarif.daya,
            tarif.tarifperkwh,
            DATE_FORMAT(pelanggan.created_at, '%d-%m-%Y') AS tanggal_registrasi,
            (
                SELECT SUM(meter_akhir - meter_awal)
                FROM penggunaan
                WHERE id_pelanggan = {$id_pelanggan}
            ) AS total_penggunaan_kwh,
            (
                SELECT COUNT(*)
                FROM tagihan
                WHERE id_pelanggan = {$id_pelanggan} AND status = 'Lunas'
            ) AS total_tagihan_lunas,
            (
                SELECT COUNT(*)
                FROM tagihan
                WHERE id_pelanggan = {$id_pelanggan}
            ) AS total_tagihan
        ");
        $this->db->from('pelanggan');
        $this->db->join('tarif', 'pelanggan.id_tarif = tarif.id_tarif', 'left');
        $this->db->where('pelanggan.id_pelanggan', $id_pelanggan);
        return $this->db->get()->row();
    }

    public function update_profil($id_pelanggan, $data) {
        $this->db->where('id_pelanggan', $id_pelanggan);
        return $this->db->update('pelanggan', $data);
    }

    public function update_password($id_pelanggan, $password_baru) {
        $this->db->where('id_pelanggan', $id_pelanggan);
        return $this->db->update('pelanggan', ['password' => $password_baru]);
    }

    public function get_profil($id_pelanggan) {
        $this->db->select('*');
        $this->db->from('pelanggan');
        $this->db->where('id_pelanggan', $id_pelanggan);
        return $this->db->get()->row();
    }
}