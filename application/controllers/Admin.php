<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user_id') || $this->session->userdata('role') !== 'admin') {
            redirect('login');
        }
        // Load semua model yang dibutuhkan dashboard
        $this->load->model('Finance_model');
        $this->load->model('Stand_model');
    }

    public function dashboard() {
        $data['title'] = 'Dashboard Admin - RisolKu';
        
        // 1. Data Ringkasan Atas
        $data['penjualan_hari_ini'] = $this->Finance_model->get_today_sales();
        $data['risol_terjual'] = $this->Finance_model->get_today_sold_items();
        
        $this->db->select_sum('stock_frozen');
        $data['stok_beku'] = $this->db->get('products')->row()->stock_frozen ?? 0;

        $this->db->select_sum('stand_stock.quantity_remaining');
        $this->db->join('stand_sessions', 'stand_sessions.id = stand_stock.stand_session_id');
        $this->db->where('stand_sessions.status', 'open');
        $data['stok_stand'] = $this->db->get('stand_stock')->row()->quantity_remaining ?? 0;

        // 2. Data Keuangan Hari Ini
        $data['pengeluaran_hari_ini'] = $this->Finance_model->get_today_expenses();
        $data['bersih_hari_ini'] = $data['penjualan_hari_ini'] - $data['pengeluaran_hari_ini'];

        // 3. Data Stand yang sedang buka hari ini
        $this->db->select('stand_sessions.*, users.name as cashier_name');
        $this->db->join('users', 'users.id = stand_sessions.user_id');
        $this->db->where('stand_sessions.status', 'open');
        $data['active_stands'] = $this->db->get('stand_sessions')->result_array();
        
        // Sisipkan ringkasan stok untuk masing-masing stand
        foreach($data['active_stands'] as $key => $stand) {
            $data['active_stands'][$key]['summary'] = $this->Stand_model->get_session_summary($stand['id']);
        }
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('admin/dashboard', $data);
        $this->load->view('templates/footer');
    }
}