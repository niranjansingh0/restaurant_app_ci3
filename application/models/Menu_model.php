<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Get all active menu items
     */
    public function get_active_menu_items() {
        $this->db->where('status', 'active');
        $query = $this->db->get('menu_items');
        return $query->result_array();
    }

    /**
     * Get all menu items
     */
    public function get_all_menu_items() {
        $query = $this->db->get('menu_items');
        return $query->result_array();
    }

    /**
     * Get single menu item by ID
     */
    public function get_menu_item($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('menu_items');
        return $query->row_array();
    }

    /**
     * Get active menu item by ID
     */
    public function get_active_menu_item($id) {
        $this->db->where('id', $id);
        $this->db->where('status', 'active');
        $query = $this->db->get('menu_items');
        return $query->row_array();
    }

    /**
     * Add new menu item
     */
    public function add_menu_item($data) {
        return $this->db->insert('menu_items', $data);
    }

    /**
     * Update menu item
     */
    public function update_menu_item($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('menu_items', $data);
    }

    /**
     * Delete menu item
     */
    public function delete_menu_item($id) {
        $this->db->where('id', $id);
        return $this->db->delete('menu_items');
    }

    /**
     * Get total menu count
     */
    public function get_menu_count() {
        return $this->db->count_all('menu_items');
    }

    /**
     * Get menu items by IDs (for cart)
     */
    public function get_menu_items_by_ids($ids) {
        if (empty($ids)) {
            return array();
        }
        $this->db->where_in('id', $ids);
        $this->db->where('status', 'active');
        $query = $this->db->get('menu_items');
        return $query->result_array();
    }
}
