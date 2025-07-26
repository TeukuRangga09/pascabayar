<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penggunaan_Backend extends CI_Controller {

    const LOGIN_URL = 'backend/login';

    public function __construct() {
        parent::__construct();
        $this->load->model('backend/Penggunaan_Model_Backend', 'penggunaan_model');
        // Cek apakah pengguna sudah login
        if (!$this->session->userdata('backend_session_login')) {
            redirect(self::LOGIN_URL);
        }
    }

    public function index() {
        $data['title'] = 'Data Penggunaan';
        $data['user'] = $this->session->userdata();

        // Ambil parameter filter dari GET request
        $filter_status = $this->input->get('status'); // 'Lunas' atau 'Belum Lunas'
        $filter_nomor_kwh = $this->input->get('nomor_kwh');

        // Panggil model dengan filter
        $data['penggunas'] = $this->penggunaan_model->get_filtered_penggunas($filter_status, $filter_nomor_kwh);
        $data['pelanggans'] = $this->penggunaan_model->get_all_pelanggans();

        // Kirim data ke view
        $this->load->view('backend/template/backend_header', $data);
        $this->load->view('backend/penggunaan/halaman_penggunaan', $data);
        $this->load->view('backend/template/backend_footer');
    }

    // Menyimpan data penggunaan baru
    public function create() {
        // Set rules untuk validasi form
        $this->form_validation->set_rules('id_pelanggan', 'Pelanggan', 'required');
        $this->form_validation->set_rules('bulan', 'Bulan', 'required');
        $this->form_validation->set_rules('tahun', 'Tahun', 'required|numeric');
        $this->form_validation->set_rules('meter_awal', 'Meter Awal', 'required|numeric');
        $this->form_validation->set_rules('meter_akhir', 'Meter Akhir', 'required|numeric|greater_than_equal_to[' . $this->input->post('meter_awal') . ']');

        // Set pesan validasi kustom
        $this->form_validation->set_message('required', '{field} wajib diisi.');
        $this->form_validation->set_message('numeric', '{field} harus berupa angka.');
        $this->form_validation->set_message('greater_than_equal_to', '{field} harus lebih besar atau sama dengan Meter Awal.');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
        } else {
            $data = [
                'id_pelanggan' => $this->input->post('id_pelanggan'),
                'bulan' => $this->input->post('bulan'),
                'tahun' => $this->input->post('tahun'),
                'meter_awal' => $this->input->post('meter_awal'),
                'meter_akhir' => $this->input->post('meter_akhir')
            ];

            if ($this->penggunaan_model->insert_penggunaan($data)) {
                $this->session->set_flashdata('success', 'Data penggunaan berhasil ditambahkan.');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan data penggunaan.');
            }
        }
        redirect('backend/penggunaan');
    }

    // Mengupdate data penggunaan
    public function update($id_penggunaan) {
        // Set rules untuk validasi form
        // $this->form_validation->set_rules('id_pelanggan', 'Pelanggan', 'required');
        // $this->form_validation->set_rules('bulan', 'Bulan', 'required');
        // $this->form_validation->set_rules('tahun', 'Tahun', 'required|numeric');
        $this->form_validation->set_rules('meter_awal', 'Meter Awal', 'required|numeric');
        $this->form_validation->set_rules('meter_akhir', 'Meter Akhir', 'required|numeric|greater_than_equal_to[' . $this->input->post('meter_awal') . ']');

        // Set pesan validasi kustom
        $this->form_validation->set_message('required', '{field} wajib diisi.');
        $this->form_validation->set_message('numeric', '{field} harus berupa angka.');
        $this->form_validation->set_message('greater_than_equal_to', '{field} harus lebih besar atau sama dengan Meter Awal.');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
        } else {
            $data = [
                // 'id_pelanggan' => $this->input->post('id_pelanggan'),
                // 'bulan' => $this->input->post('bulan'),
                // 'tahun' => $this->input->post('tahun'),
                'meter_awal' => $this->input->post('meter_awal'),
                'meter_akhir' => $this->input->post('meter_akhir')
            ];

            if ($this->penggunaan_model->update_penggunaan($id_penggunaan, $data)) {
                $this->session->set_flashdata('success', 'Data penggunaan berhasil diperbarui.');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui data penggunaan.');
            }
        }
        redirect('backend/penggunaan');
    }

    // Menghapus data penggunaan
    public function delete($id_penggunaan) {
        if ($this->penggunaan_model->delete_penggunaan($id_penggunaan)) {
            $this->session->set_flashdata('success', 'Data penggunaan berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data penggunaan.');
        }
        redirect('backend/penggunaan');
    }
}