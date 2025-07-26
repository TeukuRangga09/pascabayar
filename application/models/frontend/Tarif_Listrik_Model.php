<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tarif_Listrik_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_tarif_listrik() {
        $query = $this->db->get('tarif'); 
        return $query->result_array(); 
    }
}