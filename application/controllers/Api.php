<?php

class Api extends CI_Controller {
  public function pelanggan_json() {
    header('Content-Type: application/json');
    $data = $this->db->get('pelanggan')->result();
    echo json_encode($data);
  }
}
