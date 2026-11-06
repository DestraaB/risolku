<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Order_model');
        
        // Jika keranjang kosong tapi user maksa buka checkout, kembalikan ke keranjang
        if (empty($this->cart->contents()) && $this->uri->segment(2) !== 'success') {
            $this->session->set_flashdata('error', 'Keranjangmu masih kosong.');
            redirect('cart');
        }
    }

    public function index() {
        $data['title'] = 'Checkout - RisolKu';
        
        $this->load->view('templates/customer_header', $data);
        $this->load->view('customer/checkout');
        $this->load->view('templates/customer_nav');
        $this->load->view('templates/customer_footer');
    }

    public function process() {
        $order_number = 'RSL-' . date('Ymd') . rand(1000, 9999);
        
        $customer_data = [
            'name'    => $this->input->post('name', TRUE),
            'phone'   => $this->input->post('phone', TRUE),
            'address' => $this->input->post('pickup_method') == 'delivery' ? $this->input->post('address', TRUE) : ''
        ];

        $order_data = [
            'order_number'  => $order_number,
            'order_type'    => 'online',
            'pickup_method' => $this->input->post('pickup_method', TRUE),
            'address'       => $customer_data['address'],
            'subtotal'      => $this->cart->total(),
            'total_amount'  => $this->cart->total(), // (Tambahan ongkir bisa dipisah nanti jika ada)
            'payment_method'=> $this->input->post('payment_method', TRUE),
            'notes'         => $this->input->post('notes', TRUE)
        ];

        $cart_items = $this->cart->contents();

        if ($this->Order_model->create_order($customer_data, $order_data, $cart_items)) {
            $this->cart->destroy(); // Kosongkan keranjang
            redirect('checkout/success/' . $order_number);
        } else {
            $this->session->set_flashdata('error', 'Gagal memproses pesanan. Coba lagi.');
            redirect('checkout');
        }
    }

    public function success($order_number) {
        $data['title'] = 'Pesanan Berhasil - RisolKu';
        $data['order'] = $this->Order_model->get_order_by_number($order_number);

        if (!$data['order']) redirect('home');

        $this->load->view('templates/customer_header', $data);
        $this->load->view('customer/order_success', $data);
        $this->load->view('templates/customer_nav');
        $this->load->view('templates/customer_footer');
    }
}