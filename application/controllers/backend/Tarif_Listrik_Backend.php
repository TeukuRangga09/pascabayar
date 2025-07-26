<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tarif_Listrik_Backend extends CI_Controller {

    // Konstanta untuk redirect URL
    const LOGIN_URL = 'backend/login';

    public function __construct() {
        parent::__construct();
        
        $this->load->model('backend/Tarif_Listrik_Model_Backend', 'tarif_model');

        // Cek apakah pengguna sudah login
        if (!$this->session->userdata('backend_session_login')) {
            // Jika belum login, redirect ke halaman login
            redirect(self::LOGIN_URL);
        }
    }

    /**
     * Halaman utama dashboard backend.
     */
    public function tarif() {
        // Ambil data dari model jika diperlukan
        $data['title'] = 'Backend - Harga Tarif Listrik'; 
        $data['user'] = $this->session->userdata(); 

        $data['tarif_list'] = $this->tarif_model->get_all_tarif();

        // Load view untuk halaman dashboard
        $this->load->view('backend/template/backend_header',$data);
        $this->load->view('backend/tarif/halaman_tarif', $data);
        $this->load->view('backend/template/backend_footer');
    }

    public function add() {
        $this->form_validation->set_rules('daya', 'Daya', 'required|is_unique[tarif.daya]');
        $this->form_validation->set_rules('tarifperkwh', 'Tarif per kWh', 'required|numeric');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'trim');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('backend/tarif');
        } else {
            $data = [
                'daya' => $this->input->post('daya'),
                'tarifperkwh' => $this->input->post('tarifperkwh'),
                'deskripsi' => $this->input->post('deskripsi')
            ];
            $this->tarif_model->add_tarif($data);
            $this->session->set_flashdata('success', 'Tarif berhasil ditambahkan.');
            redirect('backend/tarif');
        }
    }

    public function update($id_tarif) {
        $this->form_validation->set_rules('daya', 'Daya', 'required');
        $this->form_validation->set_rules('tarifperkwh', 'Tarif per kWh', 'required|numeric');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'trim');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('backend/tarif');
        } else {
            $data = [
                'daya' => $this->input->post('daya'),
                'tarifperkwh' => $this->input->post('tarifperkwh'),
                'deskripsi' => $this->input->post('deskripsi')
            ];
            $this->tarif_model->update_tarif($id_tarif, $data);
            $this->session->set_flashdata('success', 'Tarif berhasil diperbarui.');
            redirect('backend/tarif');
        }
    }

    public function delete($id_tarif) {
        $this->tarif_model->delete_tarif($id_tarif);
        $this->session->set_flashdata('success', 'Tarif berhasil dihapus.');
        redirect('backend/tarif');
    }

}