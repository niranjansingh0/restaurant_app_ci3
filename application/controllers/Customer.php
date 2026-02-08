<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Menu_model');
        $this->load->model('Order_model');
    }

    /**
     * Customer menu page
     */
    public function index() {
        $data['menu_items'] = $this->Menu_model->get_active_menu_items();
        $data['cart_count'] = $this->_get_cart_count();
        $this->load->view('customer/index', $data);
    }

    /**
     * Add item to cart
     */
    public function add_to_cart($id) {
        // Validate item exists and is active
        $item = $this->Menu_model->get_active_menu_item($id);
        
        if (!$item) {
            redirect('customer');
        }

        // Initialize cart if not exists
        if (!$this->session->userdata('cart')) {
            $this->session->set_userdata('cart', array());
        }

        $cart = $this->session->userdata('cart');

        // Add or increment
        if (isset($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }

        $this->session->set_userdata('cart', $cart);
        redirect('customer?added=1');
    }

    /**
     * Handle cart actions (add, decrease, remove, clear)
     */
    public function cart_action() {
        $action = $this->input->get('action');
        $id = $this->input->get('id');

        // Clear cart
        if ($action === 'clear') {
            $this->session->unset_userdata('cart');
            redirect('customer/view_cart');
        }

        // Validate ID
        if (!$id || !is_numeric($id)) {
            redirect('customer');
        }

        $id = intval($id);

        // Check item exists and is active
        $item = $this->Menu_model->get_active_menu_item($id);
        if (!$item) {
            redirect('customer');
        }

        $cart = $this->session->userdata('cart') ?: array();

        switch ($action) {
            case 'add':
                if (isset($cart[$id])) {
                    $cart[$id]++;
                } else {
                    $cart[$id] = 1;
                }
                $this->session->set_userdata('cart', $cart);
                redirect('customer/view_cart');
                break;

            case 'decrease':
                if (isset($cart[$id])) {
                    $cart[$id]--;
                    if ($cart[$id] <= 0) {
                        unset($cart[$id]);
                    }
                }
                $this->session->set_userdata('cart', $cart);
                redirect('customer/view_cart');
                break;

            case 'remove':
                if (isset($cart[$id])) {
                    unset($cart[$id]);
                }
                $this->session->set_userdata('cart', $cart);
                redirect('customer/view_cart');
                break;

            default:
                redirect('customer');
        }
    }

    /**
     * View cart
     */
    public function view_cart() {
        $cart = $this->session->userdata('cart') ?: array();
        
        $cart_items = array();
        $total = 0;

        if (!empty($cart)) {
            $menu_items = $this->Menu_model->get_menu_items_by_ids(array_keys($cart));
            
            foreach ($menu_items as $item) {
                $quantity = $cart[$item['id']];
                $subtotal = $item['price'] * $quantity;
                $total += $subtotal;
                
                $cart_items[] = array(
                    'id' => $item['id'],
                    'name' => $item['name'],
                    'price' => $item['price'],
                    'description' => $item['description'],
                    'quantity' => $quantity,
                    'subtotal' => $subtotal
                );
            }
        }

        $data['cart_items'] = $cart_items;
        $data['total'] = $total;
        $this->load->view('customer/view_cart', $data);
    }

    /**
     * Place order
     */
    public function place_order() {
        // Check if cart is empty
        $cart = $this->session->userdata('cart');
        if (!$cart || empty($cart)) {
            redirect('customer');
        }

        // Validate customer name
        $customer_name = trim($this->input->post('customer_name'));
        if (empty($customer_name)) {
            redirect('customer/view_cart?error=name');
        }

        // Start transaction
        $this->db->trans_start();

        // Calculate total
        $total = 0;
        $menu_items = $this->Menu_model->get_menu_items_by_ids(array_keys($cart));
        
        foreach ($menu_items as $item) {
            $quantity = $cart[$item['id']];
            $total += $item['price'] * $quantity;
        }

        // Create order
        $order_id = $this->Order_model->create_order($customer_name, $total);

        // Add order items
        foreach ($menu_items as $item) {
            $quantity = $cart[$item['id']];
            $this->Order_model->add_order_item($order_id, $item['id'], $quantity);
        }

        // Complete transaction
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            redirect('customer/view_cart?error=failed');
        }

        // Clear cart
        $this->session->unset_userdata('cart');

        // Redirect to order success
        redirect('customer/my_order/' . $order_id);
    }

    /**
     * View order status
     */
    public function my_order($order_id) {
        if (!$order_id) {
            redirect('customer');
        }

        $order = $this->Order_model->get_order($order_id);
        
        if (!$order) {
            show_404();
        }

        $data['order'] = $order;
        $this->load->view('customer/my_order', $data);
    }

    /**
     * Get cart count
     */
    private function _get_cart_count() {
        $cart = $this->session->userdata('cart');
        return $cart ? array_sum($cart) : 0;
    }
}
