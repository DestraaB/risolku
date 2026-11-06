<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user_id') || $this->session->userdata('role') !== 'admin') {
            redirect('login');
        }
        $this->load->model('Report_model');
    }

    public function index() {
        // Default: Tampilkan laporan bulan ini
        $period = $this->input->get('period') ?: 'monthly';
        
        // Tentukan rentang tanggal berdasarkan filter
        if ($period == 'daily') {
            $start_date = date('Y-m-d');
            $end_date = date('Y-m-d');
            $period_title = 'Hari Ini (' . date('d M Y') . ')';
        } elseif ($period == 'weekly') {
            // Senin sampai Minggu minggu ini
            $start_date = date('Y-m-d', strtotime('monday this week'));
            $end_date = date('Y-m-d', strtotime('sunday this week'));
            $period_title = 'Minggu Ini (' . date('d M', strtotime($start_date)) . ' - ' . date('d M Y', strtotime($end_date)) . ')';
        } else {
            // Bulanan (Default)
            $start_date = date('Y-m-01');
            $end_date = date('Y-m-t'); // t = hari terakhir bulan ini
            $period_title = 'Bulan Ini (' . date('F Y') . ')';
        }

        $data['title'] = 'Laporan Keuangan - RisolKu';
        $data['active_period'] = $period;
        $data['period_title'] = $period_title;
        
        // Ambil data dari model
        $data['summary'] = $this->Report_model->get_financial_summary($start_date, $end_date);
        $data['top_products'] = $this->Report_model->get_top_products($start_date, $end_date);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('admin/reports/index', $data);
        $this->load->view('templates/footer');
    }
}