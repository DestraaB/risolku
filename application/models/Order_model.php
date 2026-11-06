<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends CI_Model {

    public function create_order($customer_data, $order_data, $cart_items) {
        $this->db->trans_start(); // Mulai transaksi database

        // 1. Simpan atau Update data Customer (berdasarkan nomor WA)
        $existing_cust = $this->db->get_where('customers', ['phone' => $customer_data['phone']])->row_array();
        if ($existing_cust) {
            $customer_id = $existing_cust['id'];
            $this->db->where('id', $customer_id)->update('customers', $customer_data);
        } else {
            $this->db->insert('customers', $customer_data);
            $customer_id = $this->db->insert_id();
        }

        // 2. Simpan Data Order Utama
        $order_data['customer_id'] = $customer_id;
        $this->db->insert('orders', $order_data);
        $order_id = $this->db->insert_id();

        // 3. Simpan Detail Item dari Keranjang
        foreach ($cart_items as $item) {
            $this->db->insert('order_items', [
                'order_id'   => $order_id,
                'product_id' => $item['id'],
                'quantity'   => $item['qty'],
                'price'      => $item['price'],
                'subtotal'   => $item['subtotal']
            ]);
        }

        $this->db->trans_complete(); // Selesai transaksi
        return $this->db->trans_status();
    }

    // Ambil data order untuk halaman sukses
    public function get_order_by_number($order_number) {
        $this->db->select('orders.*, customers.name, customers.phone');
        $this->db->from('orders');
        $this->db->join('customers', 'customers.id = orders.customer_id');
        $this->db->where('orders.order_number', $order_number);
        return $this->db->get()->row_array();
    }

// Ambil semua daftar pesanan online untuk admin
    public function get_all_orders() {
        $this->db->select('orders.*, customers.name, customers.phone');
        $this->db->from('orders');
        $this->db->join('customers', 'customers.id = orders.customer_id');
        $this->db->order_by('orders.created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    // Ambil detail item berdasarkan order_id
    public function get_order_items($order_id) {
        $this->db->select('order_items.*, products.name, products.variant, products.is_spicy');
        $this->db->from('order_items');
        $this->db->join('products', 'products.id = order_items.product_id');
        $this->db->where('order_items.order_id', $order_id);
        return $this->db->get()->result_array();
    }

    // Update status pesanan
    public function update_order_status($order_id, $status) {
        $this->db->where('id', $order_id);
        return $this->db->update('orders', ['order_status' => $status]);
    }    }