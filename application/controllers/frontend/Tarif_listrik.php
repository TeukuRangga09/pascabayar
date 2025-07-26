<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tarif_Listrik extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('frontend/Tarif_Listrik_Model'); 
    }

    
    public function index() {
        
        $data['tarif_listrik'] = $this->Tarif_Listrik_Model->get_tarif_listrik();
        // var_dump($data['tarif_listrik']);

        $this->load->view('frontend/template/frontend_header');
        $this->load->view('frontend/tarif/halaman_tarif_listrik', $data);
        $this->load->view('frontend/template/frontend_footer');
    }
}