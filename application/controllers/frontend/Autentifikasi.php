<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Autentifikasi extends CI_Controller {
    

    public function __construct() {
        parent::__construct();
        $this->load->model('frontend/Autentifikasi_Model');
    }

    public function login() {

        if ($this->session->userdata('sesi_pelanggan')) {
            redirect('landing');
        }

        $this->load->view('frontend/template/frontend_header');
        $this->load->view('frontend/autentifikasi/halaman_login');
        $this->load->view('frontend/template/frontend_footer');
    }

    public function proses_login() {
        $this->form_validation->set_rules('identifier', 'Username/Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('login');
        }

        $identifier = $this->input->post('identifier', TRUE);
        $password = $this->input->post('password', TRUE);

        $pelanggan = $this->Autentifikasi_Model->login($identifier, $password);

        if ($pelanggan) {
            $session_data = [
                'id_pelanggan' => $pelanggan->id_pelanggan,
                'username' => $pelanggan->username,
                'nama_pelanggan' => $pelanggan->nama_pelanggan,
                'sesi_pelanggan' => TRUE
            ];
            $this->session->set_userdata($session_data);

            redirect('landing'); 
        } else {
            $this->session->set_flashdata('error', 'Username/Email atau Password salah.');
            redirect('login');
        }
    }

    public function register() {
        if ($this->session->userdata('sesi_pelanggan')) {
            redirect('landing'); 
        }

        $this->load->model('frontend/Tarif_Listrik_Model'); 
        $data['tarif'] = $this->Tarif_Listrik_Model->get_tarif_listrik();

        $this->load->view('frontend/template/frontend_header');
        $this->load->view('frontend/autentifikasi/halaman_register',$data);
        $this->load->view('frontend/template/frontend_footer');
    }

    public function proses_register() {
        $this->form_validation->set_rules('username', 'Username', 'required|alpha_numeric|min_length[5]|max_length[50]|is_unique[pelanggan.username]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[pelanggan.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', 'required|matches[password]');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('register');
        }

        // Generate nomor KWH unik
        $unique_nomor_kwh = get_unique_nomor_kwh($this);

        $data = [
            'username' => $this->input->post('username', TRUE),
            'password' => $this->input->post('password', TRUE),
            'nomor_kwh' => $unique_nomor_kwh, // Auto-generate nomor KWH
            'nama_pelanggan' => $this->input->post('nama_pelanggan', TRUE),
            'alamat' => $this->input->post('alamat', TRUE),
            'telepon' => $this->input->post('telepon', TRUE),
            'email' => $this->input->post('email', TRUE),
            'id_tarif' => $this->input->post('id_tarif', TRUE)
        ];

        if ($this->Autentifikasi_Model->register($data)) {
            $this->session->set_flashdata('success', 'Pendaftaran berhasil! Silakan login.');
            redirect('login');
        } else {
            $this->session->set_flashdata('error', 'Pendaftaran gagal. Silakan coba lagi.');
            redirect('register');
        }
    }

    public function logout() {
        $this->session->sess_destroy();

        redirect('landing');
    }
}