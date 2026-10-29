<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Finance_model extends CI_Model {
    
    // Total penjualan uang hari ini
    public function get_today_sales() {
        $this->db->select_sum('total_amount');
        $this->db->where('DATE(created_at)', date('Y-m-d'));
        $this->db->where('status', 'completed');
        $result = $this->db->get('sales')->row();
        return $result->total_amount ?? 0;
    }

    // Total jumlah (pcs) risol terjual hari ini
    public function get_today_sold_items() {
        $this->db->select_sum('sale_items.quantity');
        $this->db->join('sales', 'sales.id = sale_items.sale_id');
        $this->db->where('DATE(sales.created_at)', date('Y-m-d'));
        $this->db->where('sales.status', 'completed');
        $result = $this->db->get('sale_items')->row();
        return $result->quantity ?? 0;
    }

    // Total pengeluaran hari ini
    public function get_today_expenses() {
        $this->db->select_sum('amount');
        $this->db->where('expense_date', date('Y-m-d'));
        $result = $this->db->get('expenses')->row();
        return $result->amount ?? 0;
    }

    // Tambah data pengeluaran
    public function add_expense($data) {
        return $this->db->insert('expenses', $data);
    }

    // Ambil riwayat pengeluaran
    public function get_recent_expenses($limit = 50) {
        $this->db->select('expenses.*, users.name as admin_name');
        $this->db->join('users', 'users.id = expenses.created_by');
        $this->db->order_by('expense_date', 'DESC');
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('expenses', $limit)->result_array();
    }
}