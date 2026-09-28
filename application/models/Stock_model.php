<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock_model extends CI_Model {
    
    // Mengambil daftar produk untuk ditampilkan di halaman stok beku
    public function get_all_products() {
        return $this->db->get('products')->result_array();
    }

    // Menambah stok beku dengan Transaction (Poin #59 Master Prompt)
    public function add_frozen_stock($product_id, $quantity, $user_id) {
        $this->db->trans_start(); // Mulai transaksi

        // 1. Tambahkan jumlah ke kolom stock_frozen di tabel products
        $this->db->set('stock_frozen', 'stock_frozen + ' . (int)$quantity, FALSE);
        $this->db->where('id', $product_id);
        $this->db->update('products');

        // 2. Catat ke buku besar pergerakan stok (stock_movements)
        $movement_data = [
            'product_id' => $product_id,
            'type'       => 'IN',
            'quantity'   => $quantity,
            'source'     => 'production',
            'description'=> 'Produksi baru',
            'created_by' => $user_id
        ];
        $this->db->insert('stock_movements', $movement_data);

        $this->db->trans_complete(); // Selesaikan transaksi

        return $this->db->trans_status(); // Mengembalikan TRUE jika berhasil
    }

    // Mengambil riwayat stok (Poin #24)
    public function get_history() {
        $this->db->select('sm.*, p.name, p.variant');
        $this->db->from('stock_movements sm');
        $this->db->join('products p', 'sm.product_id = p.id');
        $this->db->order_by('sm.created_at', 'DESC');
        return $this->db->get()->result_array();
    }
}