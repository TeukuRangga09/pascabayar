<?php

class Cek_Tagihan_Pelanggan extends CI_Controller {

    /**
     * Constructor untuk memuat model, library, dan helper.
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('frontend/Cek_Tagihan_P_Model');
        $this->load->library(['session', 'form_validation']);
        $this->load->helper(['form', 'url']);
    }

    /**
     * Fungsi untuk memastikan bahwa pelanggan sudah login.
     */
    private function check_login() {
        if (!$this->session->userdata('sesi_pelanggan')) {
            redirect('login'); // Redirect ke halaman login jika belum login
        }
    }

    /**
     * Halaman utama untuk menampilkan tagihan pelanggan.
     */
    public function index() {
        $this->check_login(); // Pastikan pelanggan sudah login

        // Ambil ID pelanggan dari sesi
        $id_pelanggan = $this->session->userdata('id_pelanggan');

        // Panggil model untuk mendapatkan data tagihan
        $data['tagihan'] = $this->Cek_Tagihan_P_Model->get_tagihan_by_id_pelanggan($id_pelanggan);

        $biaya_admin = $this->config->item('biaya_admin');
        $data['biaya_admin'] = $biaya_admin;

        // Kirim data ke view
        $this->load->view('frontend/template/frontend_header');
        $this->load->view('frontend/tagihan/halaman_cek_tagihan_pelanggan', $data);
        $this->load->view('frontend/template/frontend_footer');
    }

    /**
     * Halaman untuk menampilkan detail pembayaran tagihan.
     *
     * @param int $id_tagihan ID tagihan.
     */
    public function bayar($id_tagihan) {
        $this->check_login();

        // Validasi numeric ID
        if (!is_numeric($id_tagihan) || $id_tagihan < 1) {
            $this->session->set_flashdata('error', 'Format ID tagihan tidak valid');
            redirect('cek_tagihan/p');
        }

        try {
            // Ambil data tagihan dengan error handling
            $data['tagihan'] = $this->Cek_Tagihan_P_Model->get_tagihan_with_tarif($id_tagihan);

            // Validasi keberadaan data
            if (empty($data['tagihan'])) {
                throw new Exception("Data tagihan tidak ditemukan");
            }

            // Validasi kepemilikan tagihan
            if ($data['tagihan']->id_pelanggan != $this->session->userdata('id_pelanggan')) {
                throw new Exception("Anda tidak memiliki akses ke tagihan ini");
            }

            // Validasi status tagihan
            if ($data['tagihan']->status !== 'Belum Lunas') {
                throw new Exception("Tagihan sudah lunas atau dalam proses verifikasi");
            }

            // Perhitungan biaya
            $biaya_admin = $this->config->item('biaya_admin'); // Ambil biaya admin dari config
            $data['biaya_admin'] = $biaya_admin;
            $data['total_bayar'] = ($data['tagihan']->jumlah_meter * $data['tagihan']->tarifperkwh) + $biaya_admin;

            // Data rekening tujuan
            $data['rekening_tujuan'] = [
                'bank' => [
                    [
                        'nama_bank' => 'Bank BCA',
                        'nomor_rekening' => '789-012-3456',
                        'atas_nama' => 'PT Paylistrik',
                        'logo' => 'bca.png'
                    ],
                                        [
                        'nama_bank' => 'Bank BNI',
                        'nomor_rekening' => '3344-5566-7788',
                        'atas_nama' => 'PT Paylistrik',
                        'logo' => 'bni.png'
                    ]
                ],
                'e_wallet' => [
                    [
                        'nama' => 'GoPay',
                        'nomor' => '0812-3456-7890',
                        'logo' => 'gopay.png'
                    ],
                    [
                        'nama' => 'OVO',
                        'nomor' => '0812-3456-7891',
                        'logo' => 'ovo.png'
                    ],
                    [
                        'nama' => 'Dana',
                        'nomor' => '0812-3456-7892',
                        'logo' => 'dana.png'
                    ]
                ]
            ];

            // Load view
            $this->load->view('frontend/template/frontend_header');
            $this->load->view('frontend/tagihan/halaman_pembayaran', $data);
            $this->load->view('frontend/template/frontend_footer');

        } catch (Exception $e) {
            log_message('error', 'Error pada pembayaran tagihan: ' . $e->getMessage());
            $this->session->set_flashdata('error', $e->getMessage());
            redirect('cek_tagihan/p');
        }
    }

    /**
     * Proses pembayaran: Mengunggah bukti pembayaran dan mengubah status tagihan.
     */
    public function proses_pembayaran() {
        $this->check_login(); // Pastikan pelanggan sudah login

        // Validasi input dari form
        $this->form_validation->set_rules('id_tagihan', 'ID Tagihan', 'required|numeric');
        $this->form_validation->set_rules('bukti_pembayaran', 'Bukti Pembayaran', 'callback_validate_file_upload');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('cek_tagihan/p');
        }

        // Ambil input dari form
        $id_tagihan = $this->input->post('id_tagihan', TRUE);
        $bukti_pembayaran = $this->upload_bukti_pembayaran();

        // Update status tagihan menjadi "Menunggu Verifikasi"
        $update_status = $this->Cek_Tagihan_P_Model->update_status_tagihan($id_tagihan, [
            'bukti_pembayaran' => $bukti_pembayaran,
            'status' => 'Menunggu Verifikasi'
        ]);

        // Beri notifikasi ke pelanggan berdasarkan hasil update
        if ($update_status) {
            $this->session->set_flashdata(
                'success', 
                'Bukti pembayaran berhasil diunggah. Silakan tunggu verifikasi admin dalam waktu 1x24 jam.'
            );
        } else {
            $this->session->set_flashdata(
                'error', 
                'Gagal memperbarui status tagihan. Silakan coba lagi atau hubungi admin jika masalah berlanjut.'
            );
        }

        redirect('cek_tagihan/p');
    }

    /**
     * Fungsi callback untuk validasi file upload.
     */
    public function validate_file_upload() {
        if ($_FILES['bukti_pembayaran']['error'] === UPLOAD_ERR_NO_FILE) {
            $this->form_validation->set_message('validate_file_upload', 'Bukti pembayaran wajib diunggah.');
            return FALSE;
        }
        return TRUE;
    }

    /**
     * Fungsi untuk mengunggah file bukti pembayaran.
     */
    private function upload_bukti_pembayaran() {
        $config['upload_path'] = './assets/img/bukti_pembayaran_pelanggan/';
        $config['allowed_types'] = 'jpg|jpeg|png|pdf';
        $config['max_size'] = 2048; // 2MB

        $this->load->library('upload', $config);

        // Ambil nama file asli
        $original_name = $_FILES['bukti_pembayaran']['name'];
        $extension = pathinfo($original_name, PATHINFO_EXTENSION); // Ambil ekstensi file

        // Buat nama file unik dengan timestamp
        $new_name = 'bukti_' . time() . '_' . uniqid() . '.' . $extension;
        $config['file_name'] = $new_name;

        // Reinitialize upload library with new config
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('bukti_pembayaran')) {
            $this->session->set_flashdata('error', $this->upload->display_errors());
            return FALSE;
        }

        return $this->upload->data('file_name'); // Kembalikan nama file baru
    }
}