<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Track extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Order_model');
    }

    public function index() {
        $data['title'] = 'Lacak Pesanan - RisolKu';
        
        $order_number = $this->input->post('order_number', TRUE);
        $phone = $this->input->post('phone', TRUE);
        
        if ($order_number && $phone) {
            // Cari data pesanan dan customer
            $this->db->select('orders.*, customers.name, customers.phone');
            $this->db->from('orders');
            $this->db->join('customers', 'customers.id = orders.customer_id');
            $this->db->where('orders.order_number', $order_number);
            $this->db->where('customers.phone', $phone);
            $data['order'] = $this->db->get()->row_array();
            
            if ($data['order']) {
                // Jika ketemu, ambil rincian itemnya
                $data['items'] = $this->Order_model->get_order_items($data['order']['id']);
            } else {
                $this->session->set_flashdata('error', 'Pesanan tidak ditemukan. Pastikan Nomor Pesanan dan WhatsApp sudah benar.');
            }
        }

        $this->load->view('templates/customer_header', $data);
        $this->load->view('customer/track', $data);
        $this->load->view('templates/customer_nav');
        $this->load->view('templates/customer_footer');
    }
}