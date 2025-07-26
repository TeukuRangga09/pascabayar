<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_Backend extends CI_Controller {

    // Konstanta untuk redirect URL
    const LOGIN_URL = 'backend/login';

    public function __construct() {
        parent::__construct();
        $this->load->model('backend/Dashboard_Model_Backend');
        $this->load->model('backend/Weather_model');

        if (!$this->session->userdata('backend_session_login')) {
            redirect(self::LOGIN_URL);
        }
    }

    public function index() {
        // Ambil data dari model jika diperlukan
        $data['title'] = 'Backend - Dashboard'; 
        $data['user'] = $this->session->userdata(); 

        // Ambil data penggunaan listrik bulanan untuk grafik
        $tahun = date('Y'); // Tahun saat ini
        $data['monthly_usage'] = $this->Dashboard_Model_Backend->get_monthly_usage($tahun);
        $data['bill_status_summary'] = $this->Dashboard_Model_Backend->get_bill_status_summary($tahun);

        // Ambil total pelanggan per tahun saat ini
        $data['total_pelanggan_tahun_ini'] = $this->Dashboard_Model_Backend->get_total_pelanggan_per_tahun($tahun);
        // Ambil statistik penggunaan per tahun saat ini
        $data['penggunaan_statistics'] = $this->Dashboard_Model_Backend->get_penggunaan_statistics($tahun);
        // Ambil statistik pembayaran per tahun saat ini
        $data['pembayaran_statistics'] = $this->Dashboard_Model_Backend->get_pembayaran_statistics($tahun);

        $data['weather'] = $this->Weather_model->get_weather_data('Jakarta');

        // Load view untuk halaman dashboard
        $this->load->view('backend/template/backend_header', $data);
        $this->load->view('backend/dashboard/halaman_dashboard', $data);
        $this->load->view('backend/template/backend_footer');
    }

}