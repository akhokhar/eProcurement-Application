<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Requisition extends CI_Controller {
    
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
                $this->session->set_flashdata('message', '<p class="error_msg">You do not have access privileges to view product.</p>');
                if($this->flexi_auth->is_admin())
                    redirect('auth_admin');
                else
                    redirect('auth_public');
        }
        
        
        // Set Flash Message
        $this->data['message'] = $this->session->flashdata('message');
        
        // unshift crumb
        $this->breadcrumbs->unshift('Requisitions', base_url().'admin/requisition');
        
        
        $btn_array["Add"]["action"] = "admin/requisition/add/";
        $btn_array["checkbox_disabled"]["action"] = "admin/product/delete_checked_checkbox/";
        $add_category = $this->menu_model->get_privilege_name($btn_array);
        
<<<<<<< Updated upstream
        $this->data['page_title'] = 'requisitions';
=======
        $this->data['page_title'] = 'List Requisitions';
>>>>>>> Stashed changes
        
        $this->load->view('admin/includes/header', $this->data);
        $this->load->view('admin/requisition/requisitions', $this->data);
        
    }
    /*---- end: index function ----*/
    
    
    /*
    |------------------------------------------------
    | start: add function
    |------------------------------------------------
    |
    | This function add new requisition
    |
   */
    function add() {
        
        // Check user has privileges to add product, else display a message to notify the user they do not have valid privileges.
        if (! $this->flexi_auth->is_privileged($this->uri_privileged))
        {
                $this->session->set_flashdata('message', '<p class="error_msg">You do not have access privileges to add requisition.</p>');
                redirect('admin/requisition');		
        }
        
<<<<<<< Updated upstream
        // start: add breadcrumbs
        $this->breadcrumbs->push('Add Requisition', base_url().'admin/requisition/add_new_requisition');
        
        // unshift crumb
        $this->breadcrumbs->unshift('Requisitions', base_url().'admin/requisition');
=======
		if ($this->input->post()) {
            
            //echo '<pre>'; print_r($this->input->post()); die();
            
            // load validation helper
            $this->load->library('form_validation');
            
			//Requisition Details Form
            $this->form_validation->set_rules('requisitionDate', 'Requisition Date', 'required');
            $this->form_validation->set_rules('requiredUntilDate', 'Required Until Date', 'required');
            $this->form_validation->set_rules('project', 'Project', 'required');
            $this->form_validation->set_rules('budgetHead', 'Budget Head', 'required');
            $this->form_validation->set_rules('location', 'Location', 'required');
            $this->form_validation->set_rules('donor', 'Donor', 'required');
            $this->form_validation->set_rules('approvingAuthority', 'Approving Authority', 'required');
			
			//Requisition Items Form
            /*$this->form_validation->set_rules('requisitionDate', 'Requisition Date', 'required');
            $this->form_validation->set_rules('requiredUntilDate', 'Required Until Date', 'required');
            $this->form_validation->set_rules('project', 'Project', 'required');
            $this->form_validation->set_rules('budgetHead', 'Budget Head', 'required');
            $this->form_validation->set_rules('location', 'Location', 'required');
            $this->form_validation->set_rules('donor', 'Donor', 'required');
            $this->form_validation->set_rules('approvingAuthority', 'Approving Authority', 'required');*/
            
            if ($this->form_validation->run() === TRUE) {
                
                //echo '<pre>'; print_r($this->input->post()); die();
                $return['msg_success'] = 'Requisition Added Successfully.';
                /*if($this->requisition_model->add_requisition()) {
                    //echo '<pre>'; print_r($this->input->post()); die();
                    $this->session->set_flashdata('message', '<p class="status_msg">Requisition inserted successfully.</p>');
                    $product_id = $this->session->flashdata('requisition_id');
                    redirect('admin/requisition/view_requisition_detail/'.$requisition_id);
                }*/
                
            }
			else {
				$return['msg_error'] = 'Please fill all required fields.';
			}
            
			echo json_encode($return);
			die();
        }
		else {
		
			// start: add breadcrumbs
			$this->breadcrumbs->push('Add Requisition', base_url().'admin/requisition/add');
			
			// unshift crumb
			$this->breadcrumbs->unshift('Requisitions', base_url().'admin/requisition');
			
			$this->data['page_title'] = 'Add New Requisition';
			
			$this->load->view('admin/includes/header', $this->data);
			$this->load->view('admin/requisition/add_new_requisition', $this->data);			
		}
    }
	
	
    function add_process() {
>>>>>>> Stashed changes
        
		$return = array();
		
        // Check user has privileges to add product, else display a message to notify the user they do not have valid privileges.
        if (! $this->flexi_auth->is_privileged($this->uri_privileged))
        {
			//$this->session->set_flashdata('message', '<p class="error_msg"></p>');
			//redirect('admin/requisition');
			$return['msg_error'] = 'You do not have access privileges to add requisition.';
			echo json_encode($return);
			die();
        }
        
		if ($this->input->post()) {
            
            //echo '<pre>'; print_r($this->input->post()); die();
            
            // load validation helper
            $this->load->library('form_validation');
            
			//Requisition Details Form
            $this->form_validation->set_rules('requisitionDate', 'Requisition Date', 'required');
            $this->form_validation->set_rules('requiredUntilDate', 'Required Until Date', 'required');
            $this->form_validation->set_rules('project', 'Project', 'required');
            $this->form_validation->set_rules('budgetHead', 'Budget Head', 'required');
            $this->form_validation->set_rules('location', 'Location', 'required');
            $this->form_validation->set_rules('donor', 'Donor', 'required');
            $this->form_validation->set_rules('approvingAuthority', 'Approving Authority', 'required');
			
			//Requisition Items Form
            /*$this->form_validation->set_rules('requisitionDate', 'Requisition Date', 'required');
            $this->form_validation->set_rules('requiredUntilDate', 'Required Until Date', 'required');
            $this->form_validation->set_rules('project', 'Project', 'required');
            $this->form_validation->set_rules('budgetHead', 'Budget Head', 'required');
            $this->form_validation->set_rules('location', 'Location', 'required');
            $this->form_validation->set_rules('donor', 'Donor', 'required');
            $this->form_validation->set_rules('approvingAuthority', 'Approving Authority', 'required');*/
            
            if ($this->form_validation->run() === TRUE) {
                
                //echo '<pre>'; print_r($this->input->post()); die();
                $return['msg_success'] = 'Requisition Added Successfully.';
                /*if($this->requisition_model->add_requisition()) {
                    //echo '<pre>'; print_r($this->input->post()); die();
                    $this->session->set_flashdata('message', '<p class="status_msg">Requisition inserted successfully.</p>');
                    $product_id = $this->session->flashdata('requisition_id');
                    redirect('admin/requisition/view_requisition_detail/'.$requisition_id);
                }*/
                
            }
			else {
				$return['msg_error'] = 'Please fill all required fields.';
			}
            
        }
		else {			
			$return['msg_error'] = 'Please submit form to add requisition.';
		}
        
		echo json_encode($return);
        die();
    }
    /*---- end: add_product function ----*/
    
}
