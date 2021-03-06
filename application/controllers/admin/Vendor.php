<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
	
class Vendor extends CI_Controller {
    
    public $uri_privileged;

    function __construct() {
        parent::__construct();

        // To load the CI benchmark and memory usage profiler - set 1==1.
        if (1 == 2) {
            $sections = array(
                'benchmarks' => TRUE, 'memory_usage' => TRUE,
                'config' => FALSE, 'controller_info' => FALSE, 'get' => FALSE, 'post' => FALSE, 'queries' => FALSE,
                'uri_string' => FALSE, 'http_headers' => FALSE, 'session_data' => FALSE
            );
            $this->output->set_profiler_sections($sections);
            $this->output->enable_profiler(TRUE);
        }

        // IMPORTANT! This global must be defined BEFORE the flexi auth library is loaded! 
        // It is used as a global that is accessible via both models and both libraries, without it, flexi auth will not work.
        $this->auth = new stdClass;

        // Load 'standard' flexi auth library by default.
        $this->load->library('flexi_auth');

        // Check user is logged in as an admin.
        // For security, admin users should always sign in via Password rather than 'Remember me'.
        if (!$this->flexi_auth->is_logged_in_via_password()) {
            // Set a custom error message.
            $this->flexi_auth->set_error_message('You must login as an admin to access this area.', TRUE);
            $this->session->set_flashdata('message', $this->flexi_auth->get_messages());
            redirect('auth');
        }

        // Note: This is only included to create base urls for purposes of this demo only and are not necessarily considered as 'Best practice'.
        $this->load->vars('base_url', base_url());
        $this->load->vars('includes_dir', base_url() . 'includes/');
        $this->load->vars('current_url', $this->uri->uri_to_assoc(1));

        // Define a global variable to store data that is then used by the end view page.
        $this->data = null;

        // get user data
        $user_data = $this->flexi_auth->get_user_by_id($this->flexi_auth->get_user_id())->row();

        $this->data['designation'] = $user_data->ugrp_name;
        $this->data['user_name'] = $user_data->upro_first_name . ' ' . $user_data->upro_last_name;

        
        //get uri segment for active menu
        $this->data['uri_3'] = $this->uri->segment(3);
        $this->data['uri_2'] = $this->uri->segment(2);
        $this->data['uri_1'] = $this->uri->segment(1);

        $this->data['sub_menu'] = $this->data['uri_1'].'/'.$this->data['uri_2'].'/'.$this->data['uri_3'];
        $this->data['menu'] = $this->data['uri_2'];
        
        $this->cat_tree = array();

        
        // Get User Privilege 
        $this->load->model('admin/menu_model');
        $check_slash = substr($this->data['sub_menu'], -1);
        $check_slash = ($check_slash == "/")?$this->data['sub_menu']:$this->data['sub_menu']."/";
        $check_slash = str_replace("//","/",$check_slash);

		$this->load->model('admin/Vendor_model');
		$this->load->model('admin/General_model');
		
        $this->uri_privileged = $this->menu_model->get_privilege_name($check_slash);
        $this->data['menu_title'] = $this->uri_privileged;

        // Get Dynamic Menus
        $this->data['get_menu'] = $this->menu_model->get_menu();
        
        // Get any status message that may have been set.
        $this->data['message'] = (! isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
        
    }
    
    
    /*
    |------------------------------------------------
    | start: index function
    |------------------------------------------------
    |
    | This function show all requisitions
    |
   */
    function index() {
        
        // Check user has privileges to view product, else display a message to notify the user they do not have valid privileges.
        if (! $this->flexi_auth->is_privileged($this->uri_privileged))
        {
                $this->session->set_flashdata('message', '<p class="error_msg">You do not have access privileges to view Vendors.</p>');
                if($this->flexi_auth->is_admin())
                    redirect('auth_admin');
                else
                    redirect('auth_public');
        }
        
        
        // Set Flash Message
        $this->data['message'] = $this->session->flashdata('message');
        
        // unshift crumb
        $this->breadcrumbs->unshift('Manage Vendors', base_url().'admin/vendor');
        
        
        $btn_array["Add"]["action"] = "admin/vendor/add/";
		$this->data['add_vendor'] = "Add Vendor";
        //$btn_array["checkbox_disabled"]["action"] = "admin/product/delete_checked_checkbox/";
        $add_category = $this->menu_model->get_privilege_name($btn_array);
		
		
        $this->data['page_title'] = 'List Vendors';
		
		$this->load->view('admin/includes/header', $this->data);
        $this->load->view('admin/vendor/vendors', $this->data);
        
    }
    /*---- end: index function ----*/
    
    
    /*
    |------------------------------------------------
    | start: add function
    |------------------------------------------------
    |
    | This function add new vendor
    |
   */
    function add() {
        		
		if($this->input->post()) {
			$this->Vendor_model->add_vendor();
			redirect('admin/vendor');
		}
		
		// Set Flash Message
        $this->data['message'] = $this->session->flashdata('message');
        
        // unshift crumb
        $this->breadcrumbs->unshift('Vendors', base_url().'admin/vendor');
        
        
        $btn_array["Add"]["action"] = "";
        $add_category = $this->menu_model->get_privilege_name($btn_array);
		
		$this->data['page_title'] = 'Add Vendor';
		
		$this->data['locations'] = $this->General_model->list_locations();
		$this->data['categories'] = $this->General_model->list_categories();
		
		$this->load->view('admin/includes/header', $this->data);
        $this->load->view('admin/vendor/add_vendor', $this->data);
		
    }
    /*---- end: add function ----*/
	
    
	function view_all() {
		$this->index();
	}
	
	/*
    |------------------------------------------------
    | start: delete_vendor function
    |------------------------------------------------
    |
    | This function delete vendor
    |
   */
    function delete_vendor($vendor_id) {
        
        // Check user has privileges to edit requisition, else display a message to notify the user they do not have valid privileges.
        if (! $this->flexi_auth->is_privileged($this->uri_privileged))
        {
			$this->session->set_flashdata('message', '<p class="error_msg">You do not have access privileges to delete vendor.</p>');
			redirect('admin/vendor');
        }
        
        if($this->Vendor_model->delete_vendor($vendor_id)) {
			$this->session->set_flashdata('message', '<p class="status_msg">Vendor deleted successfully.</p>');
			redirect('admin/vendor/');
		}
        
    }
    /*---- end: delete_vendor function ----*/
	
}
