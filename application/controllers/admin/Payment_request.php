<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
	
require_once APPPATH."/third_party/PHPExcel.php";

class Payment_Request extends CI_Controller {
    
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
		$this->load->model('admin/quotation_model');
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
        $this->load->view('admin/comparative_quotation/comparatives', $this->data);
        
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
    function add($rfq_id) {
        
        		
		if($this->input->post()) {
			
			foreach($_POST['item'] as $count => $item){
				foreach($_POST['unit'][$count] as $vendor => $rate){
					$this->quotation_model->add_comparative($rfq_id, $vendor, $item, $rate);
				}
			}
			redirect('admin/rfq');
		}
		
		$this->load->model('Requisition_model');
		// Set Flash Message
        $this->data['message'] = $this->session->flashdata('message');
        
        // unshift crumb
        $this->breadcrumbs->unshift('Quotations', base_url().'admin/rfq');
        
        
        $btn_array["Add"]["action"] = "";
        //$btn_array["checkbox_disabled"]["action"] = "admin/product/delete_checked_checkbox/";
        $add_category = $this->menu_model->get_privilege_name($btn_array);
		
		$quotation = $this->quotation_model->get_rfq(array('r.rfq_id'), array($rfq_id));
		$quotation = $quotation[0];
		$this->data['quotation'] = $quotation;
		
		$requisition = $this->requisition_model->get_requisition(array('r.requisition_id'), $quotation['requisition_id']);
		$this->data['requisition'] = $requisition[0];
		
		$this->data['requisitionItems'] = $this->requisition_model->get_requisition_items($quotation['requisition_id']);
		
		$this->data['rfqVendors'] = $this->quotation_model->get_rfq(array('r.requisition_id'), array($quotation['requisition_id']));
		
		$this->data['page_title'] = 'Add Purchase Order';
		
		$vendor_ids = explode(',', $quotation['vendor_id']);
		foreach($vendor_ids as $vendor_id) {
			$vendors[] = $this->general_model->list_vendors(false, array('vendor_id'), array($vendor_id));
		}
        $this->data['vendors'] = $vendors;
        $this->load->view('admin/includes/header', $this->data);
        $this->load->view('admin/payment_request/add_new_pr', $this->data);
		
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
	
	
	
	public function generate_comparative($rfq_id){
		
		$this->load->model('Requisition_model');
		
		$quotationData = $this->quotation_model->get_rfq(array('rfq_id'), array($rfq_id));
		$quotation = $quotationData[0];
		
		
		$rfqVendorItemDetails = $this->quotation_model->get_rfq_vender_items($rfq_id);
		$this->data['rfqVendorItemDetails'] = $rfqVendorItemDetails;
		
		$requisitionData = $this->requisition_model->get_requisition(array('r.requisition_id'), array($quotation['requisition_id']));
		$requisition = $requisitionData[0];
		
		$requisitionItems = $this->requisition_model->get_requisition_items($quotation['requisition_id']);
		
		// Create Object of PHP Excel
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		
		$styleArray = array(
		'font'  => array(
			'bold'  => true,
			'size'  => 16,
			'name'  => 'Calibri'
		));
		$styleArray2 = array(
		'font'  => array(
			'bold'  => true,
			'size'  => 14,
			'name'  => 'Calibri'
		));
		$styleArray3 = array(
		'font'  => array(
			'size'  => 14,
			'name'  => 'Calibri'
		));
		$styleArray4 = array(
			'font'  => array(
				'size'  => 11,
				'name'  => 'Calibri'
			),
			'borders' => array(
			  'allborders' => array(
				  'style' => PHPExcel_Style_Border::BORDER_THIN,
				  )
			 ),
		);
		
		$styleArray5 = array(
			'font'  => array(
				'bold'  => true,
				'size'  => 11,
				'name'  => 'Calibri'
			),
			'fill' => array(
				'type' 	=> PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => 'FF0000')
			)
		);
		
		// 1st two lines
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Research and Development Foundation');
		$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Supplier Quotations Evaluation');
		$objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($styleArray2);
		
		// Project Details
		$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Project Detail');
		$objPHPExcel->getActiveSheet()->getStyle('A3')->applyFromArray($styleArray3);
		$objPHPExcel->getActiveSheet()->mergeCells('C3:H3');
		$objPHPExcel->getActiveSheet()->SetCellValue('C3', $requisition['description']);
		$objPHPExcel->getActiveSheet()->mergeCells('I3:J3');
		$objPHPExcel->getActiveSheet()->SetCellValue('I3', 'Date of Joining');
		$joiningDate = date("d/m/Y", strtotime($requisition['date_req']));
		$objPHPExcel->getActiveSheet()->SetCellValue('K3', $joiningDate );
		
		$objPHPExcel->getActiveSheet()->SetCellValue('A4', 'Requisition No');
		$objPHPExcel->getActiveSheet()->getStyle('A4')->applyFromArray($styleArray3);
		$objPHPExcel->getActiveSheet()->SetCellValue('C4', $requisition['requisition_num']);
		$objPHPExcel->getActiveSheet()->SetCellValue('D4', 'PR Date');
		$joiningDate = date("d/m/Y", strtotime($requisition['date_req']));
		$objPHPExcel->getActiveSheet()->SetCellValue('E4', $joiningDate );
		
		$objPHPExcel->getActiveSheet()->SetCellValue('F4', 'RFQ Ref#:');
		//$objPHPExcel->getActiveSheet()->getStyle('F4','G4','I4','K4')->applyFromArray($styleArray4);
		$objPHPExcel->getActiveSheet()->SetCellValue('G4', $quotation['rfq_num']);
		//$objPHPExcel->getActiveSheet()->getStyle('G4')->applyFromArray($styleArray4);
		$objPHPExcel->getActiveSheet()->SetCellValue('I4', 'RFQ Date');
		//$objPHPExcel->getActiveSheet()->getStyle('I4')->applyFromArray($styleArray4);
		$rfqDate = date("d/m/Y", strtotime($quotation['rfq_date']));
		$objPHPExcel->getActiveSheet()->SetCellValue('K4', $rfqDate);
		//$objPHPExcel->getActiveSheet()->getStyle('K4')->applyFromArray($styleArray4);
		$objPHPExcel->getActiveSheet()->getStyle('F4','G4','I4','K4')->applyFromArray($styleArray4);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('A5', 'Purchasing Detail');
		$objPHPExcel->getActiveSheet()->getStyle('A5')->applyFromArray($styleArray3);
		$objPHPExcel->getActiveSheet()->mergeCells('C5:K5');
		$objPHPExcel->getActiveSheet()->SetCellValue('C5', $requisition['description']);
		$objPHPExcel->getActiveSheet()->getStyle('C5')->applyFromArray($styleArray4);
		
		// Items Heading
		$objPHPExcel->getActiveSheet()->SetCellValue('A7', 'S.No');
		$objPHPExcel->getActiveSheet()->SetCellValue('B7', 'Item Name');
		$objPHPExcel->getActiveSheet()->SetCellValue('C7', 'Item Description');
		$objPHPExcel->getActiveSheet()->SetCellValue('D7', 'Unit');
		$objPHPExcel->getActiveSheet()->SetCellValue('E7', 'Quantity Required');
		$objPHPExcel->getActiveSheet()->getStyle('A7:E7')->applyFromArray($styleArray5);
		
		$vendors = $this->quotation_model->get_rfq_vender_items($requisitionItems[0]['requisition_item_id']);
		//65-90 A-Z
		//69E
		$vCount = 1;
		$unitColNo = 70;
		$amountColNO = $unitColNo+1;
		foreach($vendors as $vendor){
				if($vCount == 1){
					$unitcolumn = chr($unitColNo);
				} else{
					$unitColNo = $amountColNO+1;
					$unitcolumn = chr($unitColNo);
				}
				$amountColNO = $unitColNo+1;
				$amountColumn = chr($amountColNO);
			
			$ucCol = $unitcolumn."7";
			$amCol = $amountColumn."7";
			//echo $ucCol." ".$amCol." ";
			
			$objPHPExcel->getActiveSheet()->mergeCells("$ucCol:$amCol");
			$objPHPExcel->getActiveSheet()->SetCellValue($ucCol, $vendor['vendor_name']);
			$objPHPExcel->getActiveSheet()->getStyle($ucCol)->applyFromArray($styleArray5);
			//$objPHPExcel->getActiveSheet()->getStyle($ucCol)->applyFromArray($styleArray5);
			//$objPHPExcel->getActiveSheet()->SetCellValue($amCol, 'Amount');
			//$objPHPExcel->getActiveSheet()->getStyle($amCol)->applyFromArray($styleArray5);
			
			$vCount++;
		}
		
		
		// Set Items Data against each vendor
		$srNo = 1;
		$startingRow = 8;
		foreach($requisitionItems as $rfqItem){
			$objPHPExcel->getActiveSheet()->SetCellValue("A$startingRow", $srNo);
			$objPHPExcel->getActiveSheet()->SetCellValue("B$startingRow", $rfqItem['item_name']);
			$objPHPExcel->getActiveSheet()->SetCellValue("C$startingRow", $rfqItem['item_desc']);
			$objPHPExcel->getActiveSheet()->SetCellValue("D$startingRow", $rfqItem['unit']);
			$objPHPExcel->getActiveSheet()->SetCellValue("E$startingRow", $rfqItem['quantity']);
			$vendors = $this->quotation_model->get_rfq_vender_items($rfqItem['requisition_item_id']);
			//65-90 A-Z
			//69E
			$vCount = 1;
			$unitColNo = 70;
			$amountColNO = $unitColNo+1;
			foreach($vendors as $vendor){
					if($vCount == 1){
						$unitcolumn = chr($unitColNo);
					} else{
						$unitColNo = $amountColNO+1;
						$unitcolumn = chr($unitColNo);
					}
					$amountColNO = $unitColNo+1;
					$amountColumn = chr($amountColNO);
				
				$amount = ($rfqItem['quantity'] * $vendor['unit_rate']);
				$objPHPExcel->getActiveSheet()->SetCellValue("$unitcolumn$startingRow", $vendor['unit_rate']);
				$objPHPExcel->getActiveSheet()->SetCellValue("$amountColumn$startingRow", $amount);
				
				$vCount++;
			}
			$srNo++;
			$startingRow++;
		}
		
		//foreach($rfqVendorItemDetails as $rfqItem){
		//	print_r($rfqItem);
		//}exit;
		
		//$objPHPExcel->getActiveSheet()->SetCellValue('E7', 'Quantity Required');
		
		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
		
		// We'll be outputting an excel file
		header('Content-type: application/vnd.ms-excel');
		// It will be called file.xls
		header('Content-Disposition: attachment; filename="comparative.xlsx"');
		$objWriter->save('php://output');

	}
}
