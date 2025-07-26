<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Riwayat_Pembayaran extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('frontend/Riwayat_Pembayaran_Model');
        $this->load->model('backend/Tagihan_Model_Backend', 'tagihan_model');
        if (!$this->session->userdata('sesi_pelanggan')) {
            redirect('login'); 
        }
    }

    public function index() {
        $id_pelanggan = $this->session->userdata('id_pelanggan');

        $data['riwayat_pembayaran'] = $this->Riwayat_Pembayaran_Model->get_riwayat_pembayaran_detail($id_pelanggan);

        $this->load->view('frontend/template/frontend_header');
        $this->load->view('frontend/riwayat/halaman_riwayat_pembayaran', $data);
        $this->load->view('frontend/template/frontend_footer');
    }

    public function cetak_struk($id_tagihan) {
        $tagihan = $this->tagihan_model->get_tagihan_by_id($id_tagihan);
        if (!$tagihan) {
            show_404(); 
        }

        $pembayaran = $this->tagihan_model->get_pembayaran_by_tagihan($id_tagihan);
        if (!$pembayaran) {
            $this->session->set_flashdata('error', 'Data pembayaran tidak ditemukan.');
            redirect('frontend/riwayat_pembayaran');
        }

        $data['tagihan'] = $tagihan;
        $data['pembayaran'] = $pembayaran;
        $this->load->view('backend/tagihan/struk_pembayaran', $data);
    }
}