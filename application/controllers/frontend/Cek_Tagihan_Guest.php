<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cek_Tagihan_Guest extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('frontend/Cek_Tagihan_G_Model');
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    private function check_sesi_pelanggan() {
        if ($this->session->userdata('sesi_pelanggan')) {
            redirect('landing');
        }
    }

    public function index() {
        $this->check_sesi_pelanggan();

        $data = [
            'tagihan'   => [],
            'pelanggan' => null,
            'nomor_kwh' => ''
        ];

        // Load view
        $this->load->view('frontend/template/frontend_header');
        $this->load->view('frontend/tagihan/halaman_cek_tagihan_guest', $data);
        $this->load->view('frontend/template/frontend_footer');
    }

    public function cari() {
        $this->check_sesi_pelanggan();

        // Validasi input
        $this->form_validation->set_rules('nomor_kwh', 'Nomor KWH', 'required|numeric|min_length[10]|max_length[12]');
        $this->form_validation->set_message('required', '{field} harus diisi.');
        $this->form_validation->set_message('numeric', '{field} harus berupa angka.');
        $this->form_validation->set_message('min_length', '{field} minimal 10 digit.');
        $this->form_validation->set_message('max_length', '{field} maksimal 12 digit.');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('cek_tagihan/g');
        }

        $nomor_kwh = $this->input->post('nomor_kwh', TRUE);

        $pelanggan = $this->Cek_Tagihan_G_Model->check_nomor_kwh($nomor_kwh);
        if (!$pelanggan) {
            log_message('error', 'Nomor KWH tidak valid: ' . $nomor_kwh);
            $this->session->set_flashdata('error', 'Nomor KWH yang Anda masukkan tidak ditemukan.');
            redirect('cek_tagihan/g');
        }

        $tagihan = $this->Cek_Tagihan_G_Model->get_tagihan_by_nomor_kwh($nomor_kwh);

        $this->session->set_flashdata('tagihan', $tagihan);
        $this->session->set_flashdata('pelanggan', $pelanggan);
        $this->session->set_flashdata('nomor_kwh', $nomor_kwh);

        redirect('cek_tagihan/g/hasil');
    }

    public function hasil() {
        $this->check_sesi_pelanggan();

        $data = [
            'tagihan'   => $this->session->flashdata('tagihan') ?? [],
            'pelanggan' => $this->session->flashdata('pelanggan') ?? null,
            'nomor_kwh' => $this->session->flashdata('nomor_kwh') ?? ''
        ];

        $this->session->set_flashdata('tagihan', NULL);
        $this->session->set_flashdata('pelanggan', NULL);
        $this->session->set_flashdata('nomor_kwh', NULL);

        if (!$data['pelanggan']) {
            redirect('cek_tagihan/g');
        }

        $this->load->view('frontend/template/frontend_header');
        $this->load->view('frontend/tagihan/halaman_cek_tagihan_guest', $data);
        $this->load->view('frontend/template/frontend_footer');
    }
}