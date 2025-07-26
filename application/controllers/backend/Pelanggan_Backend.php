<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelanggan_Backend extends CI_Controller {

    const LOGIN_URL = 'backend/login';

    public function __construct() {
        parent::__construct();
        $this->load->model('backend/Pelanggan_Model_Backend', 'pelanggan_model');

        // Cek apakah pengguna sudah login
        if (!$this->session->userdata('backend_session_login')) {
            // Jika belum login, redirect ke halaman login
            redirect(self::LOGIN_URL);
        }
    }

    // Halaman utama untuk menampilkan data pelanggan
    public function index() {
        $data['title'] = 'Data Pelanggan';

        $data['user'] = $this->session->userdata(); 
        $data['nomor_kwh'] = generate_nomor_kwh();
        $data['pelanggans'] = $this->pelanggan_model->get_all_pelanggans();
        $data['tarifs'] = $this->pelanggan_model->get_all_tarifs();

        $this->load->view('backend/template/backend_header',$data);
        $this->load->view('backend/pelanggan/halaman_pelanggan', $data);
        $this->load->view('backend/template/backend_footer');
    }

    // Menyimpan data pelanggan baru
    public function create() {
        // Set rules untuk validasi form
        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[pelanggan.username]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('nomor_kwh', 'Nomor KWH', 'required|is_unique[pelanggan.nomor_kwh]');
        $this->form_validation->set_rules('nama_pelanggan', 'Nama Pelanggan', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('telepon', 'Telepon', 'trim'); // Telepon opsional
        $this->form_validation->set_rules('email', 'Email', 'trim|valid_email|is_unique[pelanggan.email]'); // Email opsional
        $this->form_validation->set_rules('id_tarif', 'Tarif', 'required');

        // Set pesan validasi kustom
        $this->form_validation->set_message('required', '{field} wajib diisi.');
        $this->form_validation->set_message('is_unique', '{field} sudah digunakan.');
        $this->form_validation->set_message('min_length', '{field} minimal {param} karakter.');
        $this->form_validation->set_message('valid_email', '{field} harus berupa alamat email yang valid.');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
        } else {
            $data = [
                'username' => $this->input->post('username'),
                'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
                'nomor_kwh' => $this->input->post('nomor_kwh'),
                'nama_pelanggan' => $this->input->post('nama_pelanggan'),
                'alamat' => $this->input->post('alamat'),
                'telepon' => $this->input->post('telepon'),
                'email' => $this->input->post('email'),
                'id_tarif' => $this->input->post('id_tarif')
            ];
            if ($this->pelanggan_model->insert_pelanggan($data)) {
                $this->session->set_flashdata('success', 'Data pelanggan berhasil ditambahkan.');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan data pelanggan.');
            }
        }
        redirect('backend/pelanggan');
    }

    // Mengupdate data pelanggan
    public function update($id_pelanggan) {
        // Set rules untuk validasi form
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('nomor_kwh', 'Nomor KWH', 'required');
        $this->form_validation->set_rules('nama_pelanggan', 'Nama Pelanggan', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('telepon', 'Telepon', 'trim'); // Telepon opsional
        $this->form_validation->set_rules('email', 'Email', 'trim|valid_email'); // Email opsional
        $this->form_validation->set_rules('id_tarif', 'Tarif', 'required');

        // Set pesan validasi kustom
        $this->form_validation->set_message('required', '{field} wajib diisi.');
        $this->form_validation->set_message('is_unique', '{field} sudah digunakan.');
        $this->form_validation->set_message('min_length', '{field} minimal {param} karakter.');
        $this->form_validation->set_message('valid_email', '{field} harus berupa alamat email yang valid.');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
        } else {
            $data = [
                'username' => $this->input->post('username'),
                'nomor_kwh' => $this->input->post('nomor_kwh'),
                'nama_pelanggan' => $this->input->post('nama_pelanggan'),
                'alamat' => $this->input->post('alamat'),
                'telepon' => $this->input->post('telepon'),
                'email' => $this->input->post('email'),
                'id_tarif' => $this->input->post('id_tarif')
            ];

            // Jika password diisi, hash password baru
            $password = $this->input->post('password');
            if (!empty($password)) {
                $data['password'] = password_hash($password, PASSWORD_BCRYPT);
            }

            if ($this->pelanggan_model->update_pelanggan($id_pelanggan, $data)) {
                $this->session->set_flashdata('success', 'Data pelanggan berhasil diperbarui.');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui data pelanggan.');
            }
        }
        redirect('backend/pelanggan');
    }

    // Menghapus data pelanggan
    public function delete($id_pelanggan) {
        if ($this->pelanggan_model->delete_pelanggan($id_pelanggan)) {
            $this->session->set_flashdata('success', 'Data pelanggan berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data pelanggan.');
        }
        redirect('backend/pelanggan');
    }
}