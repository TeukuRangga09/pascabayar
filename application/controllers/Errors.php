<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Errors extends CI_Controller {

    public function page_missing() {
        $this->load->view('frontend/template/frontend_header');
        $this->load->view('errors/halaman_error');
        $this->load->view('frontend/template/frontend_footer');
    }
}
