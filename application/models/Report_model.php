<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_model extends CI_Model {

    // Mengambil ringkasan keuangan berdasarkan rentang tanggal
    public function get_financial_summary($start_date, $end_date) {
        // 1. Total Penjualan (Pemasukan)
        $this->db->select_sum('total_amount');
        $this->db->where('DATE(created_at) >=', $start_date);
        $this->db->where('DATE(created_at) <=', $end_date);
        $this->db->where('status', 'completed');
        $sales = $this->db->get('sales')->row()->total_amount ?? 0;

        // 2. Total Pengeluaran
        $this->db->select_sum('amount');
        $this->db->where('expense_date >=', $start_date);
        $this->db->where('expense_date <=', $end_date);
        $expenses = $this->db->get('expenses')->row()->amount ?? 0;

        // 3. Total Risol Terjual (pcs)
        $this->db->select_sum('sale_items.quantity');
        $this->db->join('sales', 'sales.id = sale_items.sale_id');
        $this->db->where('DATE(sales.created_at) >=', $start_date);
        $this->db->where('DATE(sales.created_at) <=', $end_date);
        $this->db->where('sales.status', 'completed');
        $items_sold = $this->db->get('sale_items')->row()->quantity ?? 0;

        return [
            'total_sales'    => $sales,
            'total_expenses' => $expenses,
            'net_profit'     => $sales - $expenses,
            'items_sold'     => $items_sold
        ];
    }

    // Mengambil produk paling laris (berdasarkan jumlah terjual)
    public function get_top_products($start_date, $end_date, $limit = 5) {
        $this->db->select('products.name, products.variant, products.is_spicy, SUM(sale_items.quantity) as total_qty, SUM(sale_items.subtotal) as total_revenue');
        $this->db->from('sale_items');
        $this->db->join('sales', 'sales.id = sale_items.sale_id');
        $this->db->join('products', 'products.id = sale_items.product_id');
        $this->db->where('DATE(sales.created_at) >=', $start_date);
        $this->db->where('DATE(sales.created_at) <=', $end_date);
        $this->db->where('sales.status', 'completed');
        $this->db->group_by('products.id');
        $this->db->order_by('total_qty', 'DESC'); // Urutkan dari yang terbanyak
        $this->db->limit($limit);
        return $this->db->get()->result_array();
    }
}