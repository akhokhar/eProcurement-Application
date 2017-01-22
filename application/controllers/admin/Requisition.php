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
		$this->data['managers'] = $this->general_model->list_managers();
        
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
        
		
		if($this->input->post()) {
            //echo '<pre>'; print_r($this->input->post()); die();
			// load validation helper
            $this->load->library('form_validation');
            
            /*$this->form_validation->set_rules('requisitionDate', 'Requisition Date', 'required');
            $this->form_validation->set_rules('requiredUntilDate', 'Required Until Date', 'required');
            $this->form_validation->set_rules('project', 'Project', 'required');
            $this->form_validation->set_rules('budgetHead', 'Budget Head', 'required');
            $this->form_validation->set_rules('location', 'Location', 'required');
            $this->form_validation->set_rules('donor', 'Donor', 'required');
            $this->form_validation->set_rules('approvingAuthority', 'Approving Authority', 'required');*/
            
            if ($this->form_validation->run() || true) {
                
				$requisition = array();
				foreach($this->input->post('requisition') as $req){
					$fieldName = $req['name'];
					$fieldValue = $req['value'];
					
					$requisition[$fieldName] = $fieldValue;
				}
				$requisition['req_num'] = '1-10-17';
				if($requisition_id = $this->requisition_model->add_requisition($requisition)) {
					// If Requisition added successfully, then add items
					// Item work goes here....
					foreach($this->input->post('items') as $items){
						
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
						
					}
					
					$return['msg_success'] = 'Requisition Added Successfully.';
                } else{
					$return['msg_error'] = 'Something went wrong, please try again.';
				}
                
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
			
			$this->data['projects'] = $this->general_model->list_projects();
			$this->data['budgetHeads'] = $this->general_model->list_budget_head();
			$this->data['locations'] = $this->general_model->list_locations();
			$this->data['donors'] = $this->general_model->list_donors();
			$this->data['managers'] = $this->general_model->list_managers();
			
			$this->data['page_title'] = 'Add New Requisition';
			
			$this->load->view('admin/includes/header', $this->data);
			$this->load->view('admin/requisition/add_new_requisition', $this->data);
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
		
		// Approve Requisition Check if posted.
		// Send email after approving.
		if($this->input->post()) {
            
			// load validation helper
            $this->load->library('form_validation');
            $this->form_validation->set_rules('approve_reject', 'Approve/Reject', 'required');
            
            if ($this->form_validation->run() || true) {
				$requisition_id = $this->input->post('requisition_id');
				$approve = $this->input->post('approve_reject');
				
				if($this->requisition_model->approve_and_email_requisition($requisition_id, $approve)) {
					$requisition = $this->requisition_model->get_requisition(array('requisition_id'), array($requisition_id));
					
					/*Setup email for manager starts*/
					$managerId = $requisition[0]['approving_authority'];
					$managerData = $this->general_model->get_user_detail($managerId);
					
					$subjectManager = "You have a new Requisition request.";
					
					$bodyManager  	= "Dear ".$managerData['upro_first_name']." ".$managerData['upro_last_name']."\r\n";
					$bodyManager 	.= "Your have a new Requisition Request \R\n";
					$bodyManager 	.= "Requisition Number is ".$requisition_id;
					
					$toManager = $managerData['uacc_email'];
					$toManagerName = $managerData['upro_first_name']." ".$managerData['upro_last_name'];
					
					$this->send_email($toManager, $toManagerName, $subjectManager, $bodyManager);
					/*Setup email for manager ends*/
					
					/*Setup email for purchaser starts*/
					$purchaserId = $requisition[0]['created_by'];
					$purchaserData = $this->general_model->get_user_detail($purchaserId);
					
					$subjectPurchaser = "Your Requisition has been approved!";
					
					$bodyPurchaser  = "Dear ".$purchaserData['upro_first_name']." ".$purchaserData['upro_last_name']."\r\n";
					$bodyPurchaser .= "Your Requisition has been created \R\n";
					$bodyPurchaser .= "Requisition Number is ".$requisition_id;
					
					$toPurchaser = $purchaserData['uacc_email'];
					$toPurchaserName = $purchaserData['upro_first_name']." ".$purchaserData['upro_last_name'];
					
					$this->send_email($toPurchaser, $toPurchaserName, $subjectPurchaser, $bodyPurchaser);
					/*Setup email for purchaser end*/
					redirect('admin/requisition/view_all');
				}
			}
		}
		
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
		
		$total_price = 0;
		if (isset($requisition[0]['items']) && !empty($requisition[0]['items'])) {
			foreach ($requisition[0]['items'] as $key => $item) {
				$total_item_price = $item['unit_price'] * $item['quantity'];
				$requisition[0]['items'][$key]['total_item_price'] = $total_item_price;
				$total_price += $item['unit_price'] * $item['quantity'];
			}
		}
		$requisition[0]['total_price'] = $total_price;
			
		$this->data['requisition'] = $requisition[0];
		$this->data['requisition_id'] = $requisition_id;
		
		$user_id    = $this->flexi_auth->get_user_id();
		$this->data['user_details'] = $this->general_model->get_user_detail($user_id);
		$this->data['user_group'] = $this->data['user_details']['ugrp_name'];
		
        $this->load->view('admin/includes/header', $this->data);
        $this->load->view('admin/requisition/view_requisition', $this->data);
	}
	
	function send_email($to, $toName, $subject, $message) 
	{
		$this->load->library('email');
		
		$this->email->clear(TRUE);
		$this->email->from('fm.memon777@gmail', 'Farman Memon'); 
		$this->email->to($to, $toName);
		$this->email->subject($subject);
		$this->email->message($message);  

		$this->email->send();

		return TRUE;

	}

}
