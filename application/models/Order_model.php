<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Create new order
     */
    public function create_order($customer_name, $total_price) {
        $data = array(
            'customer_name' => $customer_name,
            'total_price' => $total_price,
            'status' => 'Pending'
        );
        
        $this->db->insert('orders', $data);
        return $this->db->insert_id();
    }

    /**
     * Add order item
     */
    public function add_order_item($order_id, $menu_id, $quantity) {
        $data = array(
            'order_id' => $order_id,
            'menu_id' => $menu_id,
            'quantity' => $quantity
        );
        
        return $this->db->insert('order_items', $data);
    }

    /**
     * Get order by ID
     */
    public function get_order($order_id) {
        $this->db->where('id', $order_id);
        $query = $this->db->get('orders');
        return $query->row_array();
    }

    /**
     * Get all orders
     */
    public function get_all_orders($status = null) {
        if ($status && $status !== 'all') {
            $this->db->where('status', $status);
        }
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('orders');
        return $query->result_array();
    }

    /**
     * Get recent orders
     */
    public function get_recent_orders($limit = 5) {
        $this->db->order_by('id', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get('orders');
        return $query->result_array();
    }

    /**
     * Get order items
     */
    public function get_order_items($order_id) {
        $this->db->select('order_items.*, menu_items.name, menu_items.price');
        $this->db->from('order_items');
        $this->db->join('menu_items', 'order_items.menu_id = menu_items.id');
        $this->db->where('order_items.order_id', $order_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Update order status
     */
    public function update_status($order_id, $status) {
        $this->db->where('id', $order_id);
        return $this->db->update('orders', array('status' => $status));
    }

    /**
     * Get order counts by status
     */
    public function get_count_by_status($status) {
        $this->db->where('status', $status);
        return $this->db->count_all_results('orders');
    }

    /**
     * Get total order count
     */
    public function get_total_count() {
        return $this->db->count_all('orders');
    }
}
