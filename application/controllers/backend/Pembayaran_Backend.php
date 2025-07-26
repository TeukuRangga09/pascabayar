<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembayaran_Backend extends CI_Controller {

    const LOGIN_URL = 'backend/login';

    public function __construct() {
        parent::__construct();
        $this->load->model('backend/Pembayaran_Model_Backend', 'pembayaran_model');
        
        // Cek apakah pengguna sudah login
        if (!$this->session->userdata('backend_session_login')) {
            redirect(self::LOGIN_URL);
        }
    }

    // Halaman utama untuk menampilkan data pembayaran
    public function index() {
        $data['title'] = 'Data Pembayaran';
        $data['user'] = $this->session->userdata();

        // Filter tahun dan bulan dari tanggal_pembayaran
        $tahun = $this->input->get('tahun');
        $bulan = $this->input->get('bulan');

        $data['pembayarans'] = $this->pembayaran_model->get_filtered_pembayaran($tahun, $bulan);
        $data['filter_tahun'] = $tahun;
        $data['filter_bulan'] = $bulan;

        $this->load->view('backend/template/backend_header', $data);
        $this->load->view('backend/pembayaran/halaman_pembayaran', $data);
        $this->load->view('backend/template/backend_footer');
    }

    // Menghapus data pembayaran
    public function delete($id_pembayaran) {
        if ($this->pembayaran_model->delete_pembayaran($id_pembayaran)) {
            $this->session->set_flashdata('success', 'Data pembayaran berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data pembayaran.');
        }
        redirect('backend/Pembayaran_Backend');
    }
}