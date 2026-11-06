<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sale_model extends CI_Model {

    public function process_sale($session_id, $items, $total_amount) {
        $this->db->trans_start(); // Mulai transaksi database agar data aman

        // 1. Buat nomor invoice unik (Format: INV-TahunBulanTanggal-AngkaAcak)
        $invoice_number = 'INV-' . date('Ymd') . '-' . rand(1000, 9999);

        // 2. Catat transaksi utama ke tabel 'sales'
        $data_sale = [
            'invoice_number'   => $invoice_number, // Ini yang tadi terlewat
            'stand_session_id' => $session_id,
            'total_amount'     => $total_amount,
            'status'           => 'completed',
            'created_at'       => date('Y-m-d H:i:s')
        ];
        $this->db->insert('sales', $data_sale);
        $sale_id = $this->db->insert_id();

        // 3. Proses setiap item risol yang dibeli
        foreach ($items as $item) {
            $subtotal = $item['qty'] * $item['price'];

            // A. Simpan rincian barang ke 'sale_items'
            $this->db->insert('sale_items', [
                'sale_id'    => $sale_id,
                'product_id' => $item['id'],
                'quantity'   => $item['qty'],
                'price'      => $item['price'],
                'subtotal'   => $subtotal
            ]);

            // B. Kurangi sisa stok di Stand dan catat jumlah laku
            $this->db->set('quantity_remaining', 'quantity_remaining - ' . (int)$item['qty'], FALSE);
            $this->db->set('quantity_sold', 'quantity_sold + ' . (int)$item['qty'], FALSE);
            $this->db->where('stand_session_id', $session_id);
            $this->db->where('product_id', $item['id']);
            $this->db->update('stand_stock');
        }

        $this->db->trans_complete(); // Selesai transaksi
        return $this->db->trans_status();
    }
    
}