<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Autentifikasi_Backend extends CI_Controller {

    const DASHBOARD_URL = 'backend/dashboard';
    const LOGIN_URL = 'backend/login';

    public function __construct() {
        parent::__construct();
    }

    public function login() {
        if ($this->session->userdata('backend_session_login')) {
            redirect(self::DASHBOARD_URL);
        }
        $this->load->view('frontend/template/frontend_header');
        $this->load->view('backend/autentifikasi/halaman_login_backend');
        $this->load->view('frontend/template/frontend_footer');
    }

    public function proses_login() {
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', '<i class="bi bi-exclamation-circle-fill me-2"></i>Silakan isi semua field.');
            redirect(self::LOGIN_URL);
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            $user = $this->Autentifikasi_Model_Backend->check_login($username, $password);

            if ($user) {
                $session_data = [
                    'id_user' => $user->id_user,
                    'username' => $user->username,
                    'nama_admin' => $user->nama_admin,
                    'level' => $user->nama_level,
                    'foto_profil' => $user->foto_profil,
                    'backend_session_login' => TRUE
                ];
                $this->session->set_userdata($session_data);

                redirect(self::DASHBOARD_URL);
            } else {
                $this->session->set_flashdata('error', '<i class="bi bi-exclamation-circle-fill me-2"></i>Username atau password salah.');
                redirect(self::LOGIN_URL);
            }
        }
    }

    public function proses_logout() {
        $this->session->unset_userdata('backend_session_login');
        $this->session->sess_destroy();

        redirect(self::LOGIN_URL);
    }
}