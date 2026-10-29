<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Finance extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user_id') || $this->session->userdata('role') !== 'admin') {
            redirect('login');
        }
        $this->load->model('Finance_model');
    }

    public function expenses() {
        $data['title'] = 'Pengeluaran - RisolKu';
        $data['expenses'] = $this->Finance_model->get_recent_expenses();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('admin/finance/expenses', $data);
        $this->load->view('templates/footer');
    }

    public function add_expense() {
        $data = [
            'category' => $this->input->post('category'),
            'amount' => str_replace(['.', ','], '', $this->input->post('amount')), // Hapus format titik jika ada
            'description' => $this->input->post('description'),
            'expense_date' => $this->input->post('expense_date') ?: date('Y-m-d'),
            'created_by' => $this->session->userdata('user_id')
        ];

        if ($data['amount'] > 0) {
            $this->Finance_model->add_expense($data);
            $this->session->set_flashdata('success', '✓ Pengeluaran berhasil dicatat.');
        }
        redirect('admin/pengeluaran');
    }
}