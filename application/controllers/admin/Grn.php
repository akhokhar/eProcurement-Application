<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
	
//require_once APPPATH."/third_party/PHPExcel.php";

class Grn extends CI_Controller {
    
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

		$this->load->model('admin/Requisition_model');
		$this->load->model('admin/Quotation_model');
		$this->load->model('admin/general_model');
		$this->load->model('admin/Purchase_model');
		$this->load->model('admin/Grn_model');
		
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
                $this->session->set_flashdata('message', '<p class="error_msg">You do not have access privileges to view Purchase Order.</p>');
                if($this->flexi_auth->is_admin())
                    redirect('auth_admin');
                else
                    redirect('auth_public');
        }
        
        
        // Set Flash Message
        $this->data['message'] = $this->session->flashdata('message');
        
        // unshift crumb
        //$this->breadcrumbs->unshift('Purchase Order', base_url().'admin/purchase_order');
        
        
        $btn_array["Add"]["action"] = "admin/purchase_order/add/";
        //$btn_array["checkbox_disabled"]["action"] = "admin/product/delete_checked_checkbox/";
        $add_category = $this->menu_model->get_privilege_name($btn_array);
        
        $this->data['page_title'] = 'List Goods Receiving';
		
		$this->load->view('admin/includes/header', $this->data);
        $this->load->view('admin/grn/grn', $this->data);
        
    }
    /*---- end: index function ----*/
    
    
    /*
    |------------------------------------------------
    | start: add function
    |------------------------------------------------
    |
    | This function add new GRN
    |
   */
    function add($order_id) {
        		
		if($this->input->post()) {
			$this->Grn_model->add_grn($order_id);
			redirect('admin/grn');
		}
		
		$this->load->model('Grn_model');
		// Set Flash Message
        $this->data['message'] = $this->session->flashdata('message');
        
        // unshift crumb
        $this->breadcrumbs->unshift('Goods / Services Receiving', base_url().'admin/grn');
        
        
        $btn_array["Add"]["action"] = "";
        //$btn_array["checkbox_disabled"]["action"] = "admin/product/delete_checked_checkbox/";
        $add_category = $this->menu_model->get_privilege_name($btn_array);
		
		$order = $this->Purchase_model->get_orders(array('po.po_id'), array($order_id));
		$purchaseOrder = $order[0];
		
		$requisition = $this->Requisition_model->get_requisition(array('r.requisition_id'), $purchaseOrder['requisition_id']);
		$this->data['requisition'] = $requisition[0];
		
		$this->data['page_title'] = 'Add Grn';
		
		$vendors = $this->general_model->list_vendors(false, array('vendor_id'), array($purchaseOrder['vendor_id']));
		
		$this->data['vendors'] = $vendors;
        $this->load->view('admin/includes/header', $this->data);
        $this->load->view('admin/grn/add_new_grn', $this->data);
		
    }
    /*---- end: add function ----*/
	
    
	function view_all() {
		$this->index();
	}
	
	
	function generate_grn_pdf($grn_id){
		
		$grnData = $this->Grn_model->get_grn(array('grn.grn_id'), array($grn_id));
		$grn = $grnData[0];
		
		$orderData = $this->Purchase_model->get_orders(array('po_id'), array($grn['purchase_order_id']));
		$order = $orderData[0];
		
		$quotationData = $this->Quotation_model->get_rfq(array('rfq_id'), array($order['rfq_id']));
		$quotation = $quotationData[0];
		
		$requisitionData = $this->Requisition_model->get_requisition(array('r.requisition_id', 'r.status'), array($quotation['requisition_id'], $this->config->item('sentFlag') ));
		$requisition = $requisitionData[0];
		
		$requisitionItems = $this->Requisition_model->get_requisition_items($quotation['requisition_id']);
		
		$data['order'] = $order;
		$data['quotation'] = $quotation;
		$data['requisition'] = $requisition;
		$data['requisitionItems'] = $requisitionItems;
		
		//echo "<pre>";
		//print_r($data);
		
		$html = $this->load->view('admin/grn/grn_report', $data, true);
		
		//this the the PDF filename that user will get to download
		$pdfFilePath = "Grn_report.pdf";

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
