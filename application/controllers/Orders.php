<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user_id') || $this->session->userdata('role') !== 'admin') {
            redirect('login');
        }
        $this->load->model('Order_model');
    }

    public function index() {
        $data['title'] = 'Kelola Pesanan Online - RisolKu';
        $data['orders'] = $this->Order_model->get_all_orders();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('admin/orders/index', $data);
        $this->load->view('templates/footer');
    }

    public function detail($id) {
        $data['title'] = 'Detail Pesanan - RisolKu';
        
        $this->db->select('orders.*, customers.name, customers.phone');
        $this->db->from('orders');
        $this->db->join('customers', 'customers.id = orders.customer_id');
        $this->db->where('orders.id', $id);
        $data['order'] = $this->db->get()->row_array();

        if (!$data['order']) redirect('admin/orders');

        $data['items'] = $this->Order_model->get_order_items($id);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('admin/orders/detail', $data);
        $this->load->view('templates/footer');
    }

    public function update_status($id) {
        $status = $this->input->post('order_status');
        if ($status) {
            $this->Order_model->update_order_status($id, $status);
            $this->session->set_flashdata('success', '✓ Status pesanan berhasil diperbarui.');
        }
        redirect('admin/orders/detail/' . $id);
    }
}