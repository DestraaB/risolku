<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cashier extends CI_Controller {
public function index() {
    $data['title'] = 'Dashboard Kasir - RisolKu';
    
    // --- TARIK DATA USER DARI DATABASE ---
    $user_id = $this->session->userdata('user_id');
    $this->db->where('id', $user_id);
    $data['user'] = $this->db->get('users')->row_array(); // Ambil semua kolom termasuk stand_location

    // --- TARIK STATUS STAND ---
    $this->load->model('Stand_model');
    $data['active_session'] = $this->Stand_model->get_active_session($user_id);

    // --- LOAD TAMPILAN ---
    $this->load->view('templates/header', $data);
    $this->load->view('templates/navbar');
    $this->load->view('cashier/dashboard', $data); // Pastikan ini load 'dashboard'
    $this->load->view('templates/footer');
}

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
    public function process_sale() {
        $items = $this->input->post('items');
        $total_amount = $this->input->post('total_amount');
        
        if (empty($items)) {
            $this->session->set_flashdata('error', 'Keranjang masih kosong!');
            redirect('cashier/sales');
        }

        $user_id = $this->session->userdata('user_id');
        $this->load->model('Stand_model');
        $active_session = $this->Stand_model->get_active_session($user_id);
        
        if ($active_session) {
            $this->load->model('Sale_model');
            $this->Sale_model->process_sale($active_session['id'], $items, $total_amount);
            $this->session->set_flashdata('success', '✓ Pembayaran berhasil dicatat!');
        } else {
            $this->session->set_flashdata('error', 'Sesi stand tidak ditemukan!');
        }
        
        redirect('cashier/sales');
    }
}