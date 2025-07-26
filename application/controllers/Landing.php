<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Landing extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('frontend/Landing_Model');
    }
    
    public function index()
    {      
        $data['judul_halaman'] = 'PayListrik';
        
        $this->load->view('frontend/template/frontend_header', $data);
        $this->load->view('frontend/landing/halaman_landing', $data);
        $this->load->view('frontend/template/frontend_footer');
    }
}