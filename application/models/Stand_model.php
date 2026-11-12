<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stand_model extends CI_Model {

    // Cek apakah kasir sedang memiliki stand yang 'open'
    public function get_active_session($user_id) {
        return $this->db->get_where('stand_sessions', [
            'user_id' => $user_id,
            'status' => 'open'
        ])->row_array();
    }

    // Proses Buka Stand
    public function open_stand($user_id, $items) {
        $this->db->trans_start(); // Mulai Transaksi

        // 1. Buat sesi stand
        $this->db->insert('stand_sessions', [
            'user_id' => $user_id,
            'opened_at' => date('Y-m-d H:i:s'),
            'status' => 'open'
        ]);
        $session_id = $this->db->insert_id();

        // 2. Looping setiap produk yang dibawa
        foreach ($items as $product_id => $qty) {
            if ($qty > 0) {
                // Kurangi stok beku
                $this->db->set('stock_frozen', 'stock_frozen - ' . (int)$qty, FALSE);
                $this->db->where('id', $product_id);
                $this->db->update('products');

                // Masukkan ke stok stand
                $this->db->insert('stand_stock', [
                    'stand_session_id' => $session_id,
                    'product_id' => $product_id,
                    'quantity_opened' => $qty,
                    'quantity_remaining' => $qty
                ]);

                // Catat ke log pergerakan stok
                $this->db->insert('stock_movements', [
                    'product_id' => $product_id,
                    'type' => 'OUT',
                    'quantity' => $qty,
                    'source' => 'stand',
                    'reference_id' => $session_id,
                    'description' => 'Dibawa ke stand',
                    'created_by' => $user_id
                ]);
            }
        }

        $this->db->trans_complete(); // Selesai Transaksi
        return $this->db->trans_status();
    }

    // Ambil data stok stand yang sedang aktif (Untuk kasir jualan)
    public function get_active_stand_stock($session_id) {
        $this->db->select('ss.*, p.name, p.variant, p.price, p.is_spicy');
        $this->db->from('stand_stock ss');
        $this->db->join('products p', 'ss.product_id = p.id');
        $this->db->where('ss.stand_session_id', $session_id);
        return $this->db->get()->result_array();
    }

    // Menghitung ringkasan jualan hari ini (Fungsi yang tadi error/hilang)
    public function get_session_summary($session_id) {
        $this->db->select_sum('total_amount');
        $sales = $this->db->get_where('sales', ['stand_session_id' => $session_id])->row_array();
        
        $this->db->select('SUM(quantity_opened) as total_brought, SUM(quantity_sold) as total_sold, SUM(quantity_remaining) as total_remaining');
        $stock = $this->db->get_where('stand_stock', ['stand_session_id' => $session_id])->row_array();
        
        return [
            'total_sales' => $sales['total_amount'] ?? 0,
            'total_brought' => $stock['total_brought'] ?? 0,
            'total_sold' => $stock['total_sold'] ?? 0,
            'total_remaining' => $stock['total_remaining'] ?? 0
        ];
    }

    // Proses Tutup Stand & Kembalikan Sisa Stok ke Beku
    public function close_stand($session_id, $user_id) {
        $this->db->trans_start();
        
        // 1. Ubah status sesi
        $this->db->where('id', $session_id);
        $this->db->update('stand_sessions', ['status' => 'closed', 'closed_at' => date('Y-m-d H:i:s')]);
        
        // 2. Kembalikan sisa stok
        $remaining_stocks = $this->db->get_where('stand_stock', ['stand_session_id' => $session_id])->result_array();
        foreach ($remaining_stocks as $st) {
            if ($st['quantity_remaining'] > 0) {
                // Tambah kembali ke stock_frozen
                $this->db->set('stock_frozen', 'stock_frozen + ' . $st['quantity_remaining'], FALSE);
                $this->db->where('id', $st['product_id']);
                $this->db->update('products');
                
                // Nol-kan sisa stok di stand
                $this->db->set('quantity_returned', $st['quantity_remaining']);
                $this->db->set('quantity_remaining', 0);
                $this->db->where('id', $st['id']);
                $this->db->update('stand_stock');
                
                // Catat pengembalian
                $this->db->insert('stock_movements', [
                    'product_id' => $st['product_id'],
                    'type' => 'IN',
                    'quantity' => $st['quantity_remaining'],
                    'source' => 'stand_return',
                    'reference_id' => $session_id,
                    'description' => 'Sisa stand dikembalikan',
                    'created_by' => $user_id
                ]);
            }
        }
        $this->db->trans_complete();
        return $this->db->trans_status();
    }
    public function get_active_stands() {
    // Mencari sesi stand yang statusnya masih 'open'
    $this->db->where('status', 'open');
    return $this->db->get('stand_sessions')->result_array();
}
}