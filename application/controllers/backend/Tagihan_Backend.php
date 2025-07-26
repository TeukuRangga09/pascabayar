<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tagihan_Backend extends CI_Controller {

    const LOGIN_URL = 'backend/login';

    public function __construct() {
        parent::__construct();
        $this->load->model('backend/Tagihan_Model_Backend', 'tagihan_model');
        // Cek apakah pengguna sudah login
        if (!$this->session->userdata('backend_session_login')) {
            redirect(self::LOGIN_URL);
        }
    }

    // Halaman utama untuk menampilkan data tagihan
    public function index() {
        $data['title'] = 'Data Tagihan';
        $data['user'] = $this->session->userdata();
        $data['biaya_admin'] = $this->config->item('biaya_admin');

        // Ambil parameter filter status dari query string
        $status_filter = $this->input->get('status'); // Contoh: ?status=Lunas
        $nomor_kwh_search = $this->input->get('nomor_kwh'); // Contoh: ?nomor_kwh=12345

        // Panggil model dengan filter dan pencarian
        $data['tagihans'] = $this->tagihan_model->get_filtered_tagihans($status_filter, $nomor_kwh_search);

        // Kirim data ke view
        $this->load->view('backend/template/backend_header', $data);
        $this->load->view('backend/tagihan/halaman_tagihan', $data);
        $this->load->view('backend/template/backend_footer');
    }

public function verifikasi($id_tagihan, $status, $metode_pembayaran = null) {
    // Ganti %20 atau _ menjadi spasi
    $status = str_replace(['%20', '_'], ' ', $status);
    $metode_pembayaran = str_replace(['%20', '_'], ' ', $metode_pembayaran);

    // Validasi input status
    if (!in_array($status, ['Lunas', 'Belum Lunas'])) {
        log_message('error', 'Status verifikasi tidak valid: status=' . $status);
        $this->session->set_flashdata('error', 'Status verifikasi tidak valid.');
        redirect('backend/tagihan');
    }

    // Ambil data tagihan berdasarkan id_tagihan
    $tagihan = $this->tagihan_model->get_tagihan_by_id($id_tagihan);
    if (!$tagihan) {
        show_404();
    }

    // Validasi metode pembayaran jika status Lunas
    if ($status === 'Lunas' && !in_array($metode_pembayaran, ['Tunai', 'Transfer', 'E-Wallet'])) {
        log_message('error', 'Metode pembayaran tidak valid: metode=' . $metode_pembayaran);
        $this->session->set_flashdata('error', 'Metode pembayaran tidak valid.');
        redirect('backend/tagihan');
    }

    // Mulai transaksi database
    $this->db->trans_start();

    try {
        if ($status === 'Lunas') {
            $this->tagihan_model->update_status_tagihan($id_tagihan, 'Lunas');

            $biaya_admin = $this->config->item('biaya_admin');
            $total_bayar = ($tagihan['jumlah_meter'] * $tagihan['tarifperkwh']) + $biaya_admin;

            $data_pembayaran = [
                'id_tagihan' => $id_tagihan,
                'id_pelanggan' => $tagihan['id_pelanggan'],
                'tanggal_pembayaran' => date('Y-m-d H:i:s'),
                'bulan_bayar' => $tagihan['bulan'],
                'biaya_admin' => $biaya_admin,
                'total_bayar' => $total_bayar,
                'metode_pembayaran' => $metode_pembayaran,
                'id_user' => $this->session->userdata('id_user')
            ];
            $this->tagihan_model->insert_pembayaran($data_pembayaran);

            $this->session->set_flashdata('success', 'Tagihan berhasil diverifikasi dengan metode ' . $metode_pembayaran . '.');
        } elseif ($status === 'Belum Lunas') {
            $this->tagihan_model->update_status_tagihan($id_tagihan, 'Belum Lunas');

            if (!empty($tagihan['bukti_pembayaran'])) {
                $file_path = FCPATH . 'assets/img/bukti_pembayaran_pelanggan/' . $tagihan['bukti_pembayaran'];

                if (file_exists($file_path)) {
                    unlink($file_path);
                    log_message('info', 'Bukti pembayaran dihapus dari server: ' . $file_path);
                }

                $this->db->update('tagihan', ['bukti_pembayaran' => NULL], ['id_tagihan' => $id_tagihan]);
                log_message('info', 'Bukti pembayaran dihapus dari database: id_tagihan=' . $id_tagihan);
            }

            $this->session->set_flashdata('success', 'Tagihan ditolak dan status diperbarui menjadi Belum Lunas.');
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            throw new Exception('Gagal memproses transaksi database.');
        }
    } catch (Exception $e) {
        $this->db->trans_rollback();
        log_message('error', 'Error pada proses verifikasi: ' . $e->getMessage());
        $this->session->set_flashdata('error', 'Gagal memproses verifikasi.');
    }

    redirect('backend/tagihan');
}


    // Tampilkan halaman detail tagihan dengan bukti pembayaran
    public function detail($id_tagihan) {
        // Ambil data tagihan berdasarkan id_tagihan
        $data['tagihan'] = $this->tagihan_model->get_tagihan_by_id($id_tagihan);
        if (!$data['tagihan']) {
            show_404(); // Tampilkan halaman 404 jika data tidak ditemukan
        }

        // Ambil data bukti pembayaran
        $data['bukti_pembayaran'] = $this->tagihan_model->get_bukti_pembayaran($id_tagihan);

        // Kirim data ke view
        $this->load->view('backend/template/backend_header', $data);
        $this->load->view('backend/tagihan/detail_tagihan', $data);
        $this->load->view('backend/template/backend_footer');
    }

    public function bayar($id_tagihan) {
        // Ambil data tagihan berdasarkan id_tagihan
        $tagihan = $this->tagihan_model->get_tagihan_by_id($id_tagihan);
        if (!$tagihan) {
            show_404(); 
        }

        // Hitung total bayar dengan biaya admin
        $biaya_admin = $this->config->item('biaya_admin'); 
        $total_bayar = ($tagihan['jumlah_meter'] * $tagihan['tarifperkwh']) + $biaya_admin;

        // Ambil metode pembayaran dari form
        $metode_pembayaran = $this->input->post('metode_pembayaran');

        // Data untuk tabel pembayaran
        $data_pembayaran = [
            'id_tagihan' => $id_tagihan,
            'id_pelanggan' => $tagihan['id_pelanggan'],
            'tanggal_pembayaran' => date('Y-m-d H:i:s'), 
            'bulan_bayar' => $tagihan['bulan'],
            'biaya_admin' => $biaya_admin,
            'total_bayar' => $total_bayar,
            'metode_pembayaran' => $metode_pembayaran,
            'id_user' => $this->session->userdata('id_user')
        ];

        // Mulai transaksi database
        $this->db->trans_start();

        // Update status tagihan menjadi "Lunas"
        $this->tagihan_model->update_status_tagihan($id_tagihan, 'Lunas');

        // Simpan data pembayaran
        $this->tagihan_model->insert_pembayaran($data_pembayaran);

        // Commit transaksi
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata('error', 'Gagal memproses pembayaran.');
            redirect('backend/tagihan');
        } else {
            // Set flashdata untuk pesan sukses
            // Controller
            $this->session->set_flashdata('struk', 'Tagihan telah berhasil dibayar. Silakan cetak struk di sini <i class="bi bi-arrow-right"></i> ');
            $this->session->set_flashdata('cetak_struk_url', base_url('backend/Tagihan_Backend/cetak_struk/' . $id_tagihan));
            redirect('backend/tagihan');
        }

        // Redirect ke halaman utama
        redirect('backend/tagihan');
    }

    public function cetak_struk($id_tagihan) {
        $tagihan = $this->tagihan_model->get_tagihan_by_id($id_tagihan);
        if (!$tagihan) {
            show_404(); 
        }

        $pembayaran = $this->tagihan_model->get_pembayaran_by_tagihan($id_tagihan);
        if (!$pembayaran) {
            $this->session->set_flashdata('error', 'Data pembayaran tidak ditemukan.');
            redirect('backend/tagihan');
        }

        $data['tagihan'] = $tagihan;
        $data['pembayaran'] = $pembayaran;
        $data['enkripsi'] = 'PLG-286114723';
        $this->load->view('backend/tagihan/struk_pembayaran', $data);
    }

    // Menghapus data tagihan
    public function delete($id_tagihan) {
        if ($this->tagihan_model->delete_tagihan($id_tagihan)) {
            $this->session->set_flashdata('success', 'Data tagihan berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data tagihan.');
        }
        redirect('backend/tagihan');
    }
}