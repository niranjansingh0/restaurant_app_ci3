<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Admin_model');
        $this->load->model('Menu_model');
        $this->load->model('Order_model');
    }

    /**
     * Admin login page
     */
    public function login()
    {
        // If already logged in, redirect to dashboard
        if ($this->session->userdata('admin_id')) {
            redirect('admin/dashboard');
        }

        $data['error'] = '';
        $data['debug'] = ''; // For debugging

        if ($this->input->post('login')) {
            $username = trim($this->input->post('username'));
            $password = trim($this->input->post('password'));

            // Debug: Check if username is found
            $admin_by_username = $this->Admin_model->get_admin_by_username($username);

            if (!$admin_by_username) {
                $data['error'] = 'Invalid username or password!';
                $data['debug'] = '<!-- Username not found in database -->';
            } else {
                // Username found, verify password
                $admin = $this->Admin_model->verify_login($username, $password);

                if ($admin) {
                    $this->session->set_userdata('admin_id', $admin['id']);
                    $this->session->set_userdata('admin_username', $admin['username']);
                    redirect('admin/dashboard');
                } else {
                    $data['error'] = 'Invalid username or password!';
                    $data['debug'] = '<!-- Password verification failed for user: ' . htmlspecialchars($username) . ' -->';
                }
            }
        }

        $this->load->view('admin/login', $data);
    }

    /**
     * Admin dashboard
     */
    public function dashboard()
    {
        $this->_check_login();

        // Get statistics
        $data['menu_count'] = $this->Menu_model->get_menu_count();
        $data['order_count'] = $this->Order_model->get_total_count();
        $data['pending_count'] = $this->Order_model->get_count_by_status('Pending');
        $data['accepted_count'] = $this->Order_model->get_count_by_status('Accepted');
        $data['completed_count'] = $this->Order_model->get_count_by_status('Completed');
        $data['recent_orders'] = $this->Order_model->get_recent_orders(5);

        $this->load->view('admin/dashboard', $data);
    }

    /**
     * Add menu item
     */
    public function add_menu()
    {
        $this->_check_login();

        $data['success'] = '';
        $data['error'] = '';

        if ($this->input->post('add')) {
            $name = trim($this->input->post('name'));
            $price = trim($this->input->post('price'));
            $description = trim($this->input->post('description'));

            if (empty($name) || empty($price)) {
                $data['error'] = 'Item name and price are required!';
            } else {
                $menu_data = array(
                    'name' => $name,
                    'price' => $price,
                    'description' => $description,
                    'status' => 'active'
                );

                if ($this->Menu_model->add_menu_item($menu_data)) {
                    $data['success'] = '✅ Menu item added successfully!';
                } else {
                    $data['error'] = '❌ Failed to add menu item.';
                }
            }
        }

        $this->load->view('admin/add_menu', $data);
    }

    /**
     * View all orders
     */
    public function view_orders()
    {
        $this->_check_login();

        $status = $this->input->get('status') ?: 'all';
        $data['status_filter'] = $status;
        $data['orders'] = $this->Order_model->get_all_orders($status);

        $this->load->view('admin/view_orders', $data);
    }

    /**
     * Update order status
     */
    public function update_order()
    {
        $this->_check_login();

        $action = $this->input->get('action');
        $id = $this->input->get('id');
        $status_filter = $this->input->get('status') ?: 'all';

        if ($id && $action) {
            $id = intval($id);

            if ($action === 'accept') {
                $this->Order_model->update_status($id, 'Accepted');
            } elseif ($action === 'complete') {
                $this->Order_model->update_status($id, 'Completed');
            }
        }

        redirect('admin/view_orders?status=' . $status_filter);
    }

    /**
     * Logout
     */
    public function logout()
    {
        $this->session->unset_userdata('admin_id');
        $this->session->unset_userdata('admin_username');
        redirect('admin/login');
    }

    /**
     * Check if admin is logged in
     */
    private function _check_login()
    {
        if (!$this->session->userdata('admin_id')) {
            redirect('admin/login');
        }
    }
}
