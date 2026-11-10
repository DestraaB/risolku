<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user_id') || $this->session->userdata('role') !== 'admin') {
            redirect('login');
        }
        $this->load->model('User_model');
    }

    public function cashiers() {
        $data['title'] = 'Kelola Kasir - RisolKu';
        $data['cashiers'] = $this->User_model->get_all_cashiers();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('admin/users/cashiers', $data);
        $this->load->view('templates/footer');
    }

    public function add_cashier() {
        $username = $this->input->post('username', TRUE);
        
        // Cek apakah username sudah dipakai
        $cek = $this->db->get_where('users', ['username' => $username])->num_rows();
        if ($cek > 0) {
            $this->session->set_flashdata('error', 'Username sudah digunakan, silakan pilih yang lain.');
            redirect('admin/kasir');
        }

        $data = [
            'name'           => $this->input->post('name', TRUE),
            'username'       => $username,
            'password'       => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
            'role'           => 'kasir',
            'phone'          => $this->input->post('phone', TRUE),
            'stand_location' => $this->input->post('stand_location', TRUE), // <--- TAMBAHAN INI
            'status'         => 'active'
        ];

        $this->User_model->add_cashier($data);
        $this->session->set_flashdata('success', '✓ Akun Kasir berhasil ditambahkan.');
        redirect('admin/kasir');
    }

    public function toggle_status($id) {
        $new_status = $this->User_model->toggle_status($id);
        if ($new_status == 'active') {
            $this->session->set_flashdata('success', '✓ Akun kasir diaktifkan kembali.');
        } else {
            $this->session->set_flashdata('error', 'Akun kasir berhasil dinonaktifkan.');
        }
        redirect('admin/kasir');
    }
}