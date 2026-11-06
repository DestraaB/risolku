<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load model produk agar kita bisa menampilkan katalog
        $this->load->model('Stock_model'); // Kita manfaatkan model stok beku untuk ambil daftar produk
    }

    public function index() {
        $data['title'] = 'RisolKu - Risol Hangat, Gurih, dan Bikin Nagih';
        $data['products'] = $this->Stock_model->get_all_products();

        // Kita buat template terpisah khusus customer agar lebih luwes
        $this->load->view('templates/customer_header', $data);
        $this->load->view('customer/home', $data);
        $this->load->view('templates/customer_nav');
        $this->load->view('templates/customer_footer');
    }
}