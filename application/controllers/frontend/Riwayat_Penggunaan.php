<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Riwayat_Penggunaan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('frontend/Riwayat_Penggunaan_Model');
        if (!$this->session->userdata('sesi_pelanggan')) {
            redirect('login'); 
        }
    }

    public function index() {
        $id_pelanggan = $this->session->userdata('id_pelanggan');

        $data['riwayat_penggunaan'] = $this->Riwayat_Penggunaan_Model->get_riwayat_penggunaan_detail($id_pelanggan);

        $this->load->view('frontend/template/frontend_header');
        $this->load->view('frontend/riwayat/halaman_riwayat_penggunaan', $data);
        $this->load->view('frontend/template/frontend_footer');
    }
}