<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user_id') || $this->session->userdata('role') !== 'admin') {
            redirect('login');
        }
        $this->load->model('Stock_model');
    }

    public function frozen() {
        $data['title'] = 'Stok Beku - RisolKu';
        $data['products'] = $this->Stock_model->get_all_products();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('admin/stock/frozen', $data);
        $this->load->view('templates/footer');
    }

    public function add_frozen() {
        $product_id = $this->input->post('product_id');
        $quantity = $this->input->post('quantity');
        $user_id = $this->session->userdata('user_id');

        if ($quantity > 0) {
            if ($this->Stock_model->add_frozen_stock($product_id, $quantity, $user_id)) {
                $this->session->set_flashdata('success', '✓ Stok berhasil ditambahkan.');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan stok. Silakan coba lagi.');
            }
        }
        redirect('stock/frozen');
    }

    public function history() {
        $data['title'] = 'Riwayat Stok - RisolKu';
        $data['movements'] = $this->Stock_model->get_history();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('admin/stock/history', $data);
        $this->load->view('templates/footer');
    }
}