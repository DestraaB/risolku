<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller {

    public function index() {
        $data['title'] = 'Keranjang - RisolKu';
        
        $this->load->view('templates/customer_header', $data);
        $this->load->view('customer/cart');
        $this->load->view('templates/customer_nav');
        $this->load->view('templates/customer_footer');
    }

    // Fungsi menambah produk dari katalog
    public function add() {
        $data = array(
            'id'      => $this->input->post('id'),
            'qty'     => 1, // Default tambah 1
            'price'   => $this->input->post('price'),
            'name'    => $this->input->post('name'),
            'options' => array(
                'variant'  => $this->input->post('variant'),
                'is_spicy' => $this->input->post('is_spicy')
            )
        );

        $this->cart->insert($data);
        $this->session->set_flashdata('success', 'Risol ditambahkan ke keranjang!');
        redirect('home');
    }

    // Fungsi mengubah jumlah barang di halaman keranjang
    public function update() {
        $data = array(
            'rowid' => $this->input->post('rowid'),
            'qty'   => $this->input->post('qty')
        );
        $this->cart->update($data);
        redirect('cart');
    }

    // Fungsi menghapus satu item
    public function remove($rowid) {
        $this->cart->remove($rowid);
        redirect('cart');
    }
}