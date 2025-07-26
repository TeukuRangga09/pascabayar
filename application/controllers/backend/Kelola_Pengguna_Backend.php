<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelola_Pengguna_Backend extends CI_Controller {

    const LOGIN_URL = 'backend/login';

    public function __construct() {
        parent::__construct();
        $this->load->model('backend/Kelola_Pengguna_Model_Backend', 'user_model');

        if (!$this->session->userdata('backend_session_login')) {
            redirect(self::LOGIN_URL);
        }
    }

    public function index() {
        $data['title'] = 'Kelola Pengguna';
        // mengambil dari session
        $data['user'] = $this->session->userdata(); 
        
        $data['users'] = $this->user_model->get_all_users();
        $data['levels'] = $this->user_model->get_all_levels();

        $this->load->view('backend/template/backend_header',$data);
        $this->load->view('backend/pengguna/halaman_kelola_pengguna', $data);
        $this->load->view('backend/template/backend_footer');
    }

    public function create() {
        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[user.username]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('nama_admin', 'Nama Admin', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[user.email]');
        $this->form_validation->set_rules('id_level', 'Level', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
        } else {
            $data = [
                'username' => $this->input->post('username'),
                'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
                'nama_admin' => $this->input->post('nama_admin'),
                'email' => $this->input->post('email'),
                'id_level' => $this->input->post('id_level')
            ];
            $this->user_model->insert_user($data);
            $this->session->set_flashdata('success', 'Data pengguna berhasil ditambahkan.');
        }
        redirect('backend/kelola_pengguna');
    }

    public function update($id_user) {
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('nama_admin', 'Nama Admin', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('id_level', 'Level', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
        } else {
            $data = [
                'username' => $this->input->post('username'),
                'nama_admin' => $this->input->post('nama_admin'),
                'email' => $this->input->post('email'),
                'id_level' => $this->input->post('id_level')
            ];

            // Jika password diisi, hash password baru
            $password = $this->input->post('password');
            if (!empty($password)) {
                $data['password'] = password_hash($password, PASSWORD_BCRYPT);
            }

            $this->user_model->update_user($id_user, $data);
            $this->session->set_flashdata('success', 'Data pengguna berhasil diperbarui.');
        }
        redirect('backend/kelola_pengguna');
    }
    
    public function delete($id_user) {
        $this->user_model->delete_user($id_user);
        $this->session->set_flashdata('success', 'Data pengguna berhasil dihapus.');
        redirect('backend/kelola_pengguna');
    }
}