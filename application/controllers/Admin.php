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
    
    // 1. Total Penjualan Hari Ini
    $this->db->select_sum('total_amount');
    $this->db->where('DATE(created_at)', date('Y-m-d'));
    $this->db->where_in('order_status', ['completed', 'ready']);
    $penjualan = $this->db->get('orders')->row()->total_amount;
    $data['penjualan_hari_ini'] = $penjualan ? $penjualan : 0;

    // 2. Total Pcs Risol Terjual Hari Ini
    $this->db->select_sum('order_items.quantity');
    $this->db->from('order_items');
    $this->db->join('orders', 'orders.id = order_items.order_id');
    $this->db->where('DATE(orders.created_at)', date('Y-m-d'));
    $this->db->where_in('orders.order_status', ['completed', 'ready']);
    $risol = $this->db->get()->row()->quantity;
    $data['risol_terjual'] = $risol ? $risol : 0;

    // 3. Total Stok Beku (Gudang/Pusat)
    $this->db->select_sum('stock_frozen');
    $beku = $this->db->get('products')->row()->stock_frozen;
    $data['stok_beku'] = $beku ? $beku : 0;

    // 4. Total Stok Stand (Cabang)
    $this->db->select_sum('stock_stand');
    $stand = $this->db->get('products')->row()->stock_stand;
    $data['stok_stand'] = $stand ? $stand : 0;

    // 5. Total Pengeluaran Hari Ini (Set 0 jika belum ada tabel expenses)
    $data['pengeluaran_hari_ini'] = 0; 
    if ($this->db->table_exists('expenses')) {
        $this->db->select_sum('amount');
        $this->db->where('DATE(created_at)', date('Y-m-d'));
        $pengeluaran = $this->db->get('expenses')->row()->amount;
        $data['pengeluaran_hari_ini'] = $pengeluaran ? $pengeluaran : 0;
    }

    // Hitung Laba Bersih
    $data['laba_bersih'] = $data['penjualan_hari_ini'] - $data['pengeluaran_hari_ini'];

    // 6. Cek Stand Aktif Hari Ini
    $this->db->where('DATE(opened_at)', date('Y-m-d'));
    $this->db->order_by('opened_at', 'DESC');
    $data['stand_hari_ini'] = $this->db->get('stand_sessions')->result_array();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/navbar');
    $this->load->view('admin/dashboard', $data);
    $this->load->view('templates/footer');
}
}