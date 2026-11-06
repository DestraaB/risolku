<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user_id') || $this->session->userdata('role') !== 'admin') {
            redirect('login');
        }
        // Pastikan kedua model ini dimuat
        $this->load->model('Stock_model');
        $this->load->model('Stand_model'); 
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
        redirect('admin/stok-beku');
    }

    public function history() {
        $data['title'] = 'Riwayat Stok - RisolKu';
        $data['movements'] = $this->Stock_model->get_history();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('admin/stock/history', $data);
        $this->load->view('templates/footer');
    }

    public function stand() {
        $data['title'] = 'Stok Stand - RisolKu';
        
        // Ambil semua sesi stand yang sedang 'open'
        $this->db->select('stand_sessions.*, users.name as cashier_name');
        $this->db->join('users', 'users.id = stand_sessions.user_id');
        $this->db->where('stand_sessions.status', 'open');
        $data['active_stands'] = $this->db->get('stand_sessions')->result_array();

        // Ambil detail stok untuk masing-masing stand
        foreach($data['active_stands'] as $key => $stand) {
            $data['active_stands'][$key]['stock'] = $this->Stand_model->get_active_stand_stock($stand['id']);
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('admin/stock/stand', $data);
        $this->load->view('templates/footer');
    }
}