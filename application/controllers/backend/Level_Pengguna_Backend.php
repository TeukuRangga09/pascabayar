<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Level_Pengguna_Backend extends CI_Controller {

	// Konstanta untuk redirect URL
    const LOGIN_URL = 'backend/login';

    public function __construct() {
        parent::__construct();
        $this->load->model('backend/Level_Pengguna_Model_Backend', 'level_model');

        // Cek apakah pengguna sudah login
        if (!$this->session->userdata('backend_session_login')) {
            // Jika belum login, redirect ke halaman login
            redirect(self::LOGIN_URL);
        }
    }

    // Halaman utama untuk menampilkan data level
    public function index() {
        $data['title'] = 'Data Level Pengguna';
        $data['user'] = $this->session->userdata(); 
        $data['levels'] = $this->level_model->get_all_levels();

        $this->load->view('backend/template/backend_header',$data);
        $this->load->view('backend/pengguna/halaman_level_pengguna', $data);
        $this->load->view('backend/template/backend_footer');
    }

    // Menyimpan data level baru
    public function create() {
        $this->form_validation->set_rules('nama_level', 'Nama Level', 'required|is_unique[level.nama_level]');
        
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
        } else {
            $data = [
                'nama_level' => $this->input->post('nama_level')
            ];
            $this->level_model->insert_level($data);
            $this->session->set_flashdata('success', 'Data level berhasil ditambahkan.');
        }
        redirect('backend/level_pengguna');
    }

    // Mengupdate data level
    public function update($id_level) {
        $this->form_validation->set_rules('nama_level', 'Nama Level', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
        } else {
            $data = [
                'nama_level' => $this->input->post('nama_level')
            ];
            $this->level_model->update_level($id_level, $data);
            $this->session->set_flashdata('success', 'Data level berhasil diperbarui.');
        }
        redirect('backend/level_pengguna');
    }

    // Menghapus data level
    public function delete($id_level) {
        $this->level_model->delete_level($id_level);
        $this->session->set_flashdata('success', 'Data level berhasil dihapus.');
        redirect('backend/level_pengguna');
    }
}