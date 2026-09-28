<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    
    public function get_by_username($username) {
        // Mengambil 1 baris data user berdasarkan username yang aktif
        return $this->db->get_where('users', [
            'username' => $username, 
            'status' => 'active'
        ])->row_array();
    }
    
}