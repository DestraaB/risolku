<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cashier extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user_id') || $this->session->userdata('role') !== 'kasir') {
            redirect('login');
        }
        $this->load->model('Stand_model');
        $this->load->model('Stock_model');
    }

    public function dashboard() {
        $data['title'] = 'Kasir - RisolKu';
        $data['active_session'] = $this->Stand_model->get_active_session($this->session->userdata('user_id'));
        
        $this->load->view('templates/header', $data);
        $this->load->view('cashier/dashboard', $data);
        $this->load->view('templates/cashier_nav'); // Navigasi Bawah
        $this->load->view('templates/footer');
    }

    public function open_stand() {
        // Jika sudah ada sesi aktif, tidak boleh buka lagi
        if ($this->Stand_model->get_active_session($this->session->userdata('user_id'))) {
            redirect('cashier/dashboard');
        }

        $data['title'] = 'Buka Stand - RisolKu';
        $data['products'] = $this->Stock_model->get_all_products(); // Untuk tahu batas stok

        $this->load->view('templates/header', $data);
        $this->load->view('cashier/open_stand', $data);
        $this->load->view('templates/footer');
    }

    public function process_open_stand() {
        $items = $this->input->post('qty'); // Array dari form
        $has_items = false;

        // Validasi: pastikan kasir membawa minimal 1 barang
        foreach ($items as $qty) {
            if ($qty > 0) $has_items = true;
        }

        if ($has_items) {
            $this->Stand_model->open_stand($this->session->userdata('user_id'), $items);
            $this->session->set_flashdata('success', '✓ Stand berhasil dibuka. Selamat berjualan!');
            redirect('cashier/sales');
        } else {
            $this->session->set_flashdata('error', 'Anda harus membawa minimal 1 produk.');
            redirect('cashier/open');
        }
    }

    public function sales() {
        $data['title'] = 'Penjualan - RisolKu';
        $data['active_session'] = $this->Stand_model->get_active_session($this->session->userdata('user_id'));
        
        if (!$data['active_session']) {
            $this->session->set_flashdata('error', 'Silakan buka stand terlebih dahulu.');
            redirect('cashier/dashboard');
        }

        $data['stand_stock'] = $this->Stand_model->get_active_stand_stock($data['active_session']['id']);

        $this->load->view('templates/header', $data);
        $this->load->view('cashier/sales', $data);
        $this->load->view('templates/cashier_nav');
        $this->load->view('templates/footer');
    }
}