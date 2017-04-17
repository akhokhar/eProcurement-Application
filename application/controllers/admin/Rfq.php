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
		$this->load->model('admin/Quotation_model');
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
        $this->breadcrumbs->unshift('Quotations', base_url().'admin/rfq');
        
        
        $btn_array["Add"]["action"] = "admin/rfq/add/";
        //$btn_array["checkbox_disabled"]["action"] = "admin/product/delete_checked_checkbox/";
        $add_category = $this->menu_model->get_privilege_name($btn_array);
		
		$quotation = $this->Quotation_model->get_rfq();
        
        $this->data['page_title'] = 'List Quotations';
		
		$this->data['vendors'] = $this->general_model->list_vendors(false);
        
        $this->load->view('admin/includes/header', $this->data);
        $this->load->view('admin/req_for_quotation/rfqs', $this->data);
        
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
		
		$rfq_num = $this->get_rfq_num_detail();
		$this->data['req_num'] = $rfq_num;
		
		if($this->input->post()) {
            //echo '<pre>'; print_r($this->input->post()); die();
			// load validation helper
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('rfqDate', 'Quotation Date', 'required');
            $this->form_validation->set_rules('rfqDueDate', 'Quotation Due Date', 'required');
            $this->form_validation->set_rules('vendors[]', 'Project', 'required');

            if ($this->form_validation->run()) {
				if($rfq_id = $this->Quotation_model->add_rfq($requisition_id)) {
					$this->requisition_model->change_requisition_status($requisition_id, $this->config->item('sentFlag'));
					$this->session->set_flashdata('message', '<p class="status_msg">RFQ Added successfully.</p>');
				}
				else {
					$this->session->set_flashdata('message', '<p class="status_error">Cannot Add RFQ.</p>');
				}
				redirect('admin/rfq/view/'.$rfq_id);
			}
			else {
				$this->session->set_flashdata('message', '<p class="status_error">Fill the empty fields.</p>');
				redirect('admin/rfq/view/'.$rfq_id);
			}
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
	
	
	
    
	function view_all() {
		$this->index();
	}
	
	function view($rfq_id) {
		if (!isset($rfq_id) || empty($rfq_id)) {
			redirect('admin/rfq');
		}
		
		// Check user has privileges to view product, else display a message to notify the user they do not have valid privileges.
        if (! $this->flexi_auth->is_privileged($this->uri_privileged))
        {
                $this->session->set_flashdata('message', '<p class="error_msg">You do not have access privileges to view rfq.</p>');
                if($this->flexi_auth->is_admin())
                    redirect('auth_admin');
                else
                    redirect('auth_public');
        }
        
        // Set Flash Message
        $this->data['message'] = $this->session->flashdata('message');
        
        // unshift crumb
        $this->breadcrumbs->unshift('Quotation Details', base_url().'admin/rfq/view');
        
        //$btn_array["checkbox_disabled"]["action"] = "admin/product/delete_checked_checkbox/";
        $add_category = $this->menu_model->get_privilege_name($btn_array);
        
        $this->data['page_title'] = 'Quotation Details';
		
		$quotation = $this->Quotation_model->get_rfq(array('rfq_id'), array($rfq_id));
		$vendor_ids = explode(',', $quotation[0]['vendor_id']);
		foreach($vendor_ids as $vendor_id) {
			$vendors[] = $this->general_model->list_vendors(false, array('vendor_id'), array($vendor_id));
		}
		
		if(!isset($quotation) || empty($quotation)) {
			redirect('admin/rfq/');
		}
			
		$this->data['quotation'] = $quotation[0];
		$this->data['vendors'] = $vendors;
		
        $this->load->view('admin/includes/header', $this->data);
        $this->load->view('admin/req_for_quotation/view_rfq', $this->data);
	}
	
	function change_rfq_status($rfq_id, $status) {
		$this->Quotation_model->change_rfq_status($rfq_id, $status);
		redirect('admin/rfq/');
	}
	
    function get_rfq_num_detail() {
		$rfqDate = $this->input->get('rfqDate');
		$echo = $this->input->get('echo');
		$req_date_year = date('Y', strtotime($rfqDate));
		$req_date_month = date('m', strtotime($rfqDate));
		$numSeperator = $this->config->item('numSeperator');
		$rfq_num = $this->Quotation_model->get_rfq_num_detail($req_date_year, $req_date_month);
		if (!!$rfq_num) {
			$rfq_num = explode($numSeperator, $rfq_num);
			$rfq_num[count($rfq_num)-1] = $rfq_num[count($rfq_num)-1]+1;
			$rfq_num = implode($numSeperator, $rfq_num);
		}
		else {
			$rfq_num = date('Y-m-').'01';
		}
		if (!!$echo) {
			echo $rfq_num;
		}
		else {
			return $rfq_num;
		}
	}
	
	function generate_rfq_pdf($rfq_id){
		
		$this->load->model('Requisition_model');
		
		$quotationData = $this->Quotation_model->get_rfq(array('rfq_id'), array($rfq_id));
		$quotation = $quotationData[0];
		
		$requisitionData = $this->Requisition_model->get_requisition(array('r.requisition_id'), array($quotation['requisition_id']));
		$requisition = $requisitionData[0];
		
		$requisitionItems = $this->Requisition_model->get_requisition_items($quotation['requisition_id']);
		
		$data['quotation'] = $quotation;
		$data['requisition'] = $requisition;
		$data['requisitionItems'] = $requisitionItems;
		
		$html = $this->load->view('admin/req_for_quotation/quotation', $data, true);
		
		//this the the PDF filename that user will get to download
		$pdfFilePath = "quotation.pdf";

		//load mPDF library
		$this->load->library('m_pdf');
		//actually, you can pass mPDF parameter on this load() function
		$pdf = $this->m_pdf->load($html);
		//generate the PDF!
		$pdf->WriteHTML($html);
		//offer it to user via browser download! (The PDF won't be saved on your server HDD)
		$pdf->Output($pdfFilePath, "D");

	}
	
}
