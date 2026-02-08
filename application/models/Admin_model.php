<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Get admin by username
     */
    public function get_admin_by_username($username) {
        $this->db->where('username', $username);
        $query = $this->db->get('admins');
        return $query->row_array();
    }

    /**
     * Verify admin login
     */
    public function verify_login($username, $password) {
        $admin = $this->get_admin_by_username($username);
        
        if ($admin && password_verify($password, $admin['password'])) {
            return $admin;
        }
        
        return false;
    }

    /**
     * Check if admin is logged in
     */
    public function is_logged_in() {
        return $this->session->userdata('admin_id') ? true : false;
    }
}
