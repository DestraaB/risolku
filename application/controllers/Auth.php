<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function index() {
        // Jika sudah login, langsung tendang ke dashboard sesuai role
        if ($this->session->userdata('user_id')) {
            $this->_redirect_by_role($this->session->userdata('role'));
        }

        // Aturan validasi input
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            // Tampilkan halaman login
            $data['title'] = 'Login - RisolKu';
            $this->load->view('templates/header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/footer');
        } else {
            $this->_login();
        }
    }

    private function _login() {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $user = $this->User_model->get_by_username($username);

        if ($user) {
            // Cek password hash bcrypt
            if (password_verify($password, $user['password'])) {
                $session_data = [
                    'user_id' => $user['id'],
                    'username' => $user['username'],
                    'name' => $user['name'],
                    'role' => $user['role']
                ];
                $this->session->set_userdata($session_data);
                
                // Arahkan ke dashboard masing-masing
                $this->_redirect_by_role($user['role']);
            } else {
                $this->session->set_flashdata('error', 'Password salah!');
                redirect('login');
            }
        } else {
            $this->session->set_flashdata('error', 'Username tidak ditemukan atau dinonaktifkan.');
            redirect('login');
        }
    }

    private function _redirect_by_role($role) {
        if ($role == 'admin') {
            redirect('admin/dashboard');
        } elseif ($role == 'kasir') {
            redirect('cashier/dashboard');
        } else {
            redirect('login');
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('login');
    }
}