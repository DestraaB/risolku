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
}