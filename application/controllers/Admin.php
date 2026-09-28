<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        // Proteksi: Cek apakah user sudah login dan rolenya admin
        if (!$this->session->userdata('user_id') || $this->session->userdata('role') !== 'admin') {
            $this->session->set_flashdata('error', 'Anda harus login sebagai Admin untuk mengakses halaman ini.');
            redirect('login');
        }
    }

    public function dashboard() {
        $data['title'] = 'Dashboard Admin - RisolKu';
        
        // Karena ini masih awal, kita siapkan variabel data bernilai 0
        // Nanti di Tahap Keuangan, data ini akan diambil dari database (Model)
        $data['penjualan_hari_ini'] = 0;
        $data['risol_terjual'] = 0;
        $data['stok_beku'] = 0;
        $data['stok_stand'] = 0;
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('admin/dashboard', $data);
        $this->load->view('templates/footer');
    }
}