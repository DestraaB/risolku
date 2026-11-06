<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    
    public function get_by_username($username) {
        return $this->db->get_where('users', [
            'username' => $username, 
            'status' => 'active'
        ])->row_array();
    }

    // Ambil semua data kasir
    public function get_all_cashiers() {
        $this->db->where('role', 'kasir');
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('users')->result_array();
    }

    // Tambah kasir baru
    public function add_cashier($data) {
        return $this->db->insert('users', $data);
    }

    // Ubah status kasir (Aktif / Nonaktif)
    public function toggle_status($id) {
        $user = $this->db->get_where('users', ['id' => $id])->row_array();
        if ($user) {
            $new_status = ($user['status'] == 'active') ? 'inactive' : 'active';
            $this->db->where('id', $id);
            $this->db->update('users', ['status' => $new_status]);
            return $new_status;
        }
        return false;
    }
}