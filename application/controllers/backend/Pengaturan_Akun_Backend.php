<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaturan_Akun_Backend extends CI_Controller {

    const LOGIN_URL = 'backend/login';

    public function __construct() {
        parent::__construct();
        $this->load->model('backend/Pengaturan_Akun_Model_Backend', 'profile_model');
        if (!$this->session->userdata('backend_session_login')) {
            redirect(self::LOGIN_URL);
        }
    }

    // Halaman utama pengaturan akun
    public function index() {
        $id_user = $this->session->userdata('id_user');
        $data['title'] = 'Pengaturan Akun';

        $data['user'] = $this->session->userdata();
        $data['user_settings'] = $this->profile_model->get_user_by_id($id_user);

        $this->load->view('backend/template/backend_header', $data);
        $this->load->view('backend/akun/halaman_pengaturan_akun', $data);
        $this->load->view('backend/template/backend_footer');
    }

    public function update_profile() {
    $id_user = $this->session->userdata('id_user');

    // Validasi input
    $this->form_validation->set_rules('nama_admin', 'Full Name', 'required');
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

    if ($this->form_validation->run() == FALSE) {
        $this->session->set_flashdata('error', validation_errors());
        redirect('backend/pengaturan_akun');
    } else {
        // Ambil data dari form
        $data = [
            'nama_admin' => $this->input->post('nama_admin'),
            'email' => $this->input->post('email')
        ];

        // Handle upload foto profil jika ada file yang diupload
        if (!empty($_FILES['foto_profil']['name'])) {
            $config['upload_path'] = './assets/img/foto_profil/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 2048; // 2MB

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('foto_profil')) {
                $upload_data = $this->upload->data();
                $data['foto_profil'] = $upload_data['file_name'];

                // Hapus foto lama jika ada
                $old_foto_profil = $this->session->userdata('foto_profil');
                if (!empty($old_foto_profil) && file_exists(FCPATH . 'assets/img/foto_profil/' . $old_foto_profil)) {
                    unlink(FCPATH . 'assets/img/foto_profil/' . $old_foto_profil);
                }
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('backend/pengaturan_akun');
            }
        }

        // Update data profil di database
        $this->profile_model->update_profile($id_user, $data);

        // Perbarui session dengan data terbaru
        $updated_user = $this->profile_model->get_user_by_id($id_user);
        $this->session->set_userdata([
            'nama_admin' => $updated_user['nama_admin'],
            'email' => $updated_user['email'],
            'foto_profil' => $updated_user['foto_profil']
        ]);

        // Set flashdata untuk tab aktif
        $this->session->set_flashdata('active_tab', 'profile-edit');
        $this->session->set_flashdata('success', 'Profil berhasil diperbarui.');

        redirect('backend/pengaturan_akun');
    }
}


    public function update_password() {
        $id_user = $this->session->userdata('id_user');

        // Validasi input
        $this->form_validation->set_rules('current_password', 'Password Saat Ini', 'required');
        $this->form_validation->set_rules('new_password', 'Password Baru', 'required|min_length[5]');
        $this->form_validation->set_rules('retype_password', 'Konfirmasi Password', 'required|matches[new_password]');

        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal, arahkan kembali ke halaman pengaturan akun dengan tab "Change Password" aktif
            $this->session->set_flashdata('error', validation_errors());
            $this->session->set_flashdata('active_tab', 'profile-change-password');
            redirect('backend/pengaturan_akun');
        } else {
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password');
            $user = $this->profile_model->get_user_by_id($id_user);

            // Verifikasi password saat ini
            if (!password_verify($current_password, $user['password'])) {
                $this->session->set_flashdata('error', 'Password saat ini salah.');
                $this->session->set_flashdata('active_tab', 'profile-change-password');
                redirect('backend/pengaturan_akun');
            } else {
                // Update password baru
                $this->profile_model->update_password($id_user, $new_password);
                $this->session->set_flashdata('success', 'Password berhasil diperbarui.');
                $this->session->set_flashdata('active_tab', 'profile-change-password');
                redirect('backend/pengaturan_akun');
            }
        }
    }
}