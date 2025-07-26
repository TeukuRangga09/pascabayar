<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profil extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('frontend/Profil_Model');
        if (!$this->session->userdata('sesi_pelanggan')) {
            redirect('auth/login'); 
        }
    }

    public function index() {
        $id_pelanggan = $this->session->userdata('id_pelanggan');
        $data['profil'] = $this->Profil_Model->get_profil_detail($id_pelanggan);
        // var_dump($data['profil']);

        if (empty($data['profil'])) {
            $this->session->set_flashdata('error', 'Terjadi kesalahan saat memuat halaman profil.');
            redirect('frontend/dashboard');
        }

        $this->load->view('frontend/template/frontend_header');
        $this->load->view('frontend/profil/halaman_profil', $data);
        $this->load->view('frontend/template/frontend_footer');
    }

    public function update() {
        $this->form_validation->set_rules('nama_pelanggan', 'Nama Pelanggan', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('telepon', 'Telepon', 'numeric');
        $this->form_validation->set_rules('email', 'Email', 'valid_email');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', 'Silakan periksa kembali input Anda.');
            redirect('frontend/profil'); 
        } else {
            $id_pelanggan = $this->session->userdata('id_pelanggan');
            $data = [
                'username' => $this->input->post('username'),
                'nama_pelanggan' => $this->input->post('nama_pelanggan'),
                'alamat' => $this->input->post('alamat'),
                'telepon' => $this->input->post('telepon'),
                'email' => $this->input->post('email')
            ];

            if ($this->Profil_Model->update_profil($id_pelanggan, $data)) {
                $current_session_nama_pelanggan = $this->session->userdata('nama_pelanggan');
                $new_nama_pelanggan = $this->input->post('nama_pelanggan');
                if ($current_session_nama_pelanggan !== $new_nama_pelanggan) {
                    $session_data = [
                        'id_pelanggan' => $id_pelanggan,
                        'username' => $this->session->userdata('username'),
                        'nama_pelanggan' => $new_nama_pelanggan,
                        'sesi_pelanggan' => TRUE
                    ];
                    $this->session->set_userdata($session_data);
                }
                $this->session->set_flashdata('success', 'Profil berhasil diperbarui.');
                redirect('frontend/profil'); 
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui profil. Silakan coba lagi.');
                redirect('frontend/profil');
            }
        }
    }

    public function ubah_password() {
        $this->form_validation->set_rules('password_lama', 'Password Lama', 'required');
        $this->form_validation->set_rules('password_baru', 'Password Baru', 'required|min_length[6]');
        $this->form_validation->set_rules('konfirmasi_password', 'Konfirmasi Password', 'required|matches[password_baru]');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', 'Silakan periksa kembali input Anda.');
            redirect('frontend/profil');
        } else {
            $id_pelanggan = $this->session->userdata('id_pelanggan');
            $pelanggan = $this->Profil_Model->get_profil($id_pelanggan);

            if (password_verify($this->input->post('password_lama'), $pelanggan->password)) {
                $password_baru = password_hash($this->input->post('password_baru'), PASSWORD_DEFAULT);
                $this->Profil_Model->update_password($id_pelanggan, $password_baru);
                $this->session->set_flashdata('success', 'Password berhasil diperbarui.');
                redirect('frontend/profil');
            } else {
                $this->session->set_flashdata('error', 'Password lama tidak sesuai.');
                redirect('frontend/profil');
            }
        }
    }
}