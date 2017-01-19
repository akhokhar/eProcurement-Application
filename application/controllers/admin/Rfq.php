<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Rfq extends CI_Controller {
    
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

		$this->load->model('admin/requisition_model');
		$this->load->model('admin/general_model');
		
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
                $this->session->set_flashdata('message', '<p class="error_msg">You do not have access privileges to view requisitions.</p>');
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
        //$btn_array["checkbox_disabled"]["action"] = "admin/product/delete_checked_checkbox/";
        $add_category = $this->menu_model->get_privilege_name($btn_array);
        
        $this->data['page_title'] = 'List Requisitions';
		
		$this->requisition_model->get_requisition();
		
		$this->data['projects'] = $this->general_model->list_projects();
		$this->data['locations'] = $this->general_model->list_locations();
		$this->data['donors'] = $this->general_model->list_donors();
        
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
    function add($requisition_id) {
        
        // Check user has privileges to add product, else display a message to notify the user they do not have valid privileges.
        if (! $this->flexi_auth->is_privileged($this->uri_privileged))
        {
                $this->session->set_flashdata('message', '<p class="error_msg">You do not have access privileges to add RFQ.</p>');
                redirect('admin/requisition');		
        }
        
		
		if(isset($requisition_id) && !empty($requisition_id)) {
           
				$requisition = array();
					
				$requisition = $this->requisition_model->get_requisition(array('requisition_id'), array($requisition_id));
				if(!isset($requisition) || empty($requisition)) {
					redirect('admin/rfq/view_all');
				}
				if(!$requisition[0]['is_approved']) {
					$this->session->set_flashdata('message', '<p class="error_msg">The Requisition is not approved.</p>');
					redirect('admin/rfq/view_all');
				}
					
				$this->data['vendors'] = $this->general_model->list_vendors(false);
				
				foreach ($requisition[0]['items'] as $key => $item) {
					$total_item_price = $item['unit_price'] * $item['quantity'];
					$requisition[0]['items'][$key]['total_item_price'] = $total_item_price;
					$total_price += $item['unit_price'] * $item['quantity'];
				}
				$requisition[0]['total_price'] = $total_price;
					
				$this->data['requisition'] = $requisition[0];
					/*foreach($this->input->post('items') as $items){
						
						//Set Parameters for adding items to requisition
						$itemName = '';
						$itemDesc = '';
						$costCenter = '';
						$unit = '';
						$quantity = '';
						$unitPrice = '';
						$totalPrice = '';
						
						foreach($items as $item){
						
							$fieldName = $item['name'];
							$fieldValue = $item['value'];
							
							if($fieldName == "itemName"){
								$itemName = $fieldValue;
							}
							if($fieldName == "itemDescription"){
								$itemDesc = $fieldValue;
							}
							if($fieldName == "costCenter"){
								$costCenter = $fieldValue;
							}
							if($fieldName == "unit"){
								$unit = $fieldValue;
							}
							if($fieldName == "quantity"){
								$quantity = $fieldValue;
							}
							if($fieldName == "unitPrice"){
								$unitPrice = $fieldValue;
							}
							if($fieldName == "totalPrice"){
								$totalPrice = $fieldValue;
							}
							
						}
						
						// Calling method to add requisition item.
						$this->requisition_model->add_requisition_item($requisition_id, $itemName, $itemDesc, $costCenter, $unit, $quantity, $unitPrice);
						
					}*/
					
					//$return['msg_success'] = 'Requisition Added Successfully.';
               
			
			// start: add breadcrumbs
			$this->breadcrumbs->push('Add RFQ', base_url().'admin/rfq/add');
			
			// unshift crumb
			$this->breadcrumbs->unshift('RFQs', base_url().'admin/rfq');
			
			
			$this->data['page_title'] = 'Add New Request for Quotation';
			
			$this->load->view('admin/includes/header', $this->data);
			$this->load->view('admin/req_for_quotation/add_new_rfq', $this->data);
			
			
        }
		
    }
    /*---- end: add function ----*/
	
	
	/*
    |------------------------------------------------
    | start: edit_product function
    |------------------------------------------------
    |
    | This function update requisition
    |
   */
    function edit($requisition_id) {
        
        // Check user has privileges to edit requisition, else display a message to notify the user they do not have valid privileges.
        if (! $this->flexi_auth->is_privileged($this->uri_privileged))
        {
                $this->session->set_flashdata('message', '<p class="error_msg">You do not have access privileges to edit requisition.</p>');
                redirect('admin/requisition');
        }
        
        // active menu
        $this->data['sub_menu'] = $this->data['uri_1'].'/requisition/';
        
        // start: add breadcrumbs
        $this->breadcrumbs->push('Edit Requisition', base_url().'admin/requisition/edit');
        
        // unshift crumb
        $this->breadcrumbs->unshift('Catalog', base_url().'admin/requisition');
        
        if($this->input->post()) {
            
            //echo '<pre>'; print_r($this->input->post()); die();
            
            // load validation helper
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('requisitionDate', 'Requisition Date', 'required');
            $this->form_validation->set_rules('requiredUntilDate', 'Required Until Date', 'required');
            $this->form_validation->set_rules('project', 'Project', 'required');
            $this->form_validation->set_rules('budgetHead', 'Budget Head', 'required');
            $this->form_validation->set_rules('location', 'Location', 'required');
            $this->form_validation->set_rules('donor', 'Donor', 'required');
            $this->form_validation->set_rules('approvingAuthority', 'Approving Authority', 'required');
            
            if ($this->form_validation->run()) {
                
                if($this->requisition_model->edit_requisition($requisition_id)) {
                    //echo '<pre>'; print_r($this->input->post()); die();
                    $this->session->set_flashdata('message', '<p class="status_msg">Requisition updated successfully.</p>');
                    redirect('admin/requisition/view_requisition_detail/'.$requisition_id);
                }
                
            }
            
        }
        
        // ************************************
        // start: get requisition by id
        // ************************************
        $db_where_column    = array('requisition_id');
        $db_where_value     = array($requisition_id);
        
        $this->data['requisition'] = $this->requisition_model->get_requisition($db_where_column, $db_where_value);
        $this->data['requisition'] = $this->data['requisition'][0];
        
		
        $this->data['currentPage'] = $this;

        $this->data['page_title'] = 'Update Requisition';
        
        $this->load->view('admin/includes/header', $this->data);
        $this->load->view('admin/requisition/edit_requisition', $this->data);
        
    }
    /*---- end: edit_requisition function ----*/
    
	function view_all() {
		$this->index();
	}
	
	function view($requisition_id) {
		if (!isset($requisition_id) || empty($requisition_id)) {
			redirect('admin/requisition/view_all');
		}
		
        // Check user has privileges to view product, else display a message to notify the user they do not have valid privileges.
        if (! $this->flexi_auth->is_privileged($this->uri_privileged))
        {
                $this->session->set_flashdata('message', '<p class="error_msg">You do not have access privileges to view requisitions.</p>');
                if($this->flexi_auth->is_admin())
                    redirect('auth_admin');
                else
                    redirect('auth_public');
        }
        
        // Set Flash Message
        $this->data['message'] = $this->session->flashdata('message');
        
        // unshift crumb
        $this->breadcrumbs->unshift('Requisition Details', base_url().'admin/requisition/view');
        
        //$btn_array["checkbox_disabled"]["action"] = "admin/product/delete_checked_checkbox/";
        $add_category = $this->menu_model->get_privilege_name($btn_array);
        
        $this->data['page_title'] = 'Requisition Details';
		
		$requisition = $this->requisition_model->get_requisition(array('requisition_id'), array($requisition_id));
		if(!isset($requisition) || empty($requisition)) {
			redirect('admin/requisition/view_all');
		}
		foreach ($requisition[0]['items'] as $key => $item) {
			$total_item_price = $item['unit_price'] * $item['quantity'];
			$requisition[0]['items'][$key]['total_item_price'] = $total_item_price;
			$total_price += $item['unit_price'] * $item['quantity'];
		}
		$requisition[0]['total_price'] = $total_price;
			
		$this->data['requisition'] = $requisition[0];
		
        $this->load->view('admin/includes/header', $this->data);
        $this->load->view('admin/requisition/view_requisition', $this->data);
	}
	
}