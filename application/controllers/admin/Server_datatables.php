<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class server_datatables extends CI_Controller {
    
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

        // load product model
        $this->load->model('admin/requisition_model');
        
        // Load Menu Model
        $this->load->model('admin/menu_model');
        
        //get uri segment for active menu
        $this->data['uri_3'] = $this->uri->segment(3);
        $this->data['uri_2'] = $this->uri->segment(2);
        $this->data['uri_1'] = $this->uri->segment(1);

        $this->data['sub_menu'] = $this->data['uri_1'].'/'.$this->data['uri_2'].'/'.$this->data['uri_3'];
        $this->data['menu'] = $this->data['uri_2'];
        
        
        // Get User Privilege 
        $check_slash = substr($this->data['sub_menu'], -1);
        $check_slash = ($check_slash == "/")?$this->data['sub_menu']:$this->data['sub_menu']."/";
        $check_slash = str_replace("//","/",$check_slash);


        $this->uri_privileged = $this->menu_model->get_privilege_name($check_slash);
        $this->data['menu_title'] = $this->uri_privileged;
    }
    
    
    /*
    |------------------------------------------------
    | start: get_requisition function
    |------------------------------------------------
    |
    | This function get requisition and search requisition
    | via ajax
    |
   */
    function get_requisition() {
        
        //echo '<pre>'; print_r($this->input->post()); die();
        
        // database column for searching
        $db_column = array('r.requisition_id', 'r.requisition_num', 'r.date_req', 'r.date_req_until', 'r.approving_authority', 'r.is_approved', 'r.status');
        
        // load requisition model
        $this->load->model('admin/requisition_model');
        
        // *****************************************
        // start: get all requitision or search requisition
        // *****************************************
        $db_where_column    = array('r.status');
        $db_where_value     = array(1);
        $db_where_column_or = array();
        $db_where_value_or  = array();
        $db_limit           = array();
        $db_order           = array();
        
        /***** start: record length and start *****/
        if($this->input->post('length') != '-1') {
            $db_limit['limit'] = $this->input->post('length');
            $db_limit['pageStart'] = $this->input->post('start');
        }
        // end: get data order by
        
        /***** start: get data order by *****/
        $order = $this->input->post('order');
        
        if($order) {
            foreach($order as $key => $get_order) {
                
                $db_order[$key]['title']    = $db_column[$get_order['column']-1];
                $db_order[$key]['order_by'] = $get_order['dir'];
                
            }            
        }
        // end: get data order by
        
        /***** start: top search data by equal to *****/
        if($this->input->post('top_search_like')) {
            foreach($this->input->post('top_search_like') as $key => $search_val) {

                if(preg_match('/prod/', $key)) {

                    $search_key = substr($key, 5);
                    
                    if(!empty($search_val)) {
                        $db_where_column[]  = $search_key . ' LIKE';
                        $db_where_value[]   = '%' . $search_val . '%';
                    }

                }

            }
        }
        
        if($this->input->post('top_search')) {
            foreach($this->input->post('top_search') as $key => $search_val) {

                if(preg_match('/prod/', $key)) {

                    $search_key = substr($key, 5);
                    
                    if($search_val!="") {
                        $db_where_column[]  = $search_key;
                        $db_where_value[]   = $search_val;
                    }

                }

            }
        }
        // end: top search data by equal to
        
        /***** start: search data by like *****/
        $search = $this->input->post('search');
        
        if($search['value'] != '') {
            foreach($db_column as $value) {
                $db_where_column_or[]   = $value . ' LIKE';
                $db_where_value_or[]    = '%' . $search['value'] . '%';
            }
        }
        // end: search data by like
        
        $dataRecord = $this->requisition_model->get_requisition($db_where_column, $db_where_value, $db_where_column_or, $db_where_value_or, $db_limit, $db_order);
        
        $dataCount = $this->requisition_model->get_requisition($db_where_column, $db_where_value, $db_where_column_or, $db_where_value_or);
        // end: get all requisitions or search requisition
        
        $dt_column = array('requisition_num', 'description', 'date_req', 'date_req_until', 'project_name', 'location_name', 'approving_authority_name', 'is_approved');
        
        $data = array();
        $i = 0;
        
        if($dataRecord) {
            
            $view = "admin/requisition/view/";
            $edit = "";//"admin/requisition/edit/";
            $remove = "";//"admin/requisition/delete_requisition/";

            $btn_arr_responce = $this->create_action_array($view,$edit,$remove);
            foreach($dataRecord as $key => $value) {
                
                $btn_array_checked_checkbox = "admin/product/delete_checked_checkbox/";
                $checkbox = "";
                if(!$this->flexi_auth->is_privileged($this->menu_model->get_privilege_name($btn_array_checked_checkbox))){
                    $checkbox="disabled";
                }
                $data[$i][] = '<div class="checkbox-table"><label>
                                    <input type="checkbox" '.$checkbox.' name="requisition['.$value['requisition_id'].']" class="flat-grey deleteThis">
                                </label></div>';
                
                foreach($dt_column as $get_dt_column) {
                    
                    if($get_dt_column == 'is_approved'){
						if ($value[$get_dt_column] == 1) {
							$data[$i][] = 'Approved';
						}
						else if ($value[$get_dt_column] == 2) {
							$data[$i][] = 'Rejected';
						}
						else {
							$data[$i][] = 'Not Approved';
						}
						
                    }
                    else if($get_dt_column == 'date_req'){
                        $data[$i][] = date("d/M/Y", strtotime($value[$get_dt_column]));
                    }
					else if($get_dt_column == 'date_req_until'){
                        $data[$i][] = date("d/M/Y", strtotime($value[$get_dt_column]));
                    }
                    else {
                        $data[$i][] = $value[$get_dt_column];
                    }
                    
                }

                /***** start: delete and edit button *****/
                $action_btn = '';
                
                $action_btn .= '<div class="visible-md visible-lg hidden-sm hidden-xs">';

                $action_btn .= $this->create_action_buttons($btn_arr_responce,$value['requisition_id']);
                
                $action_btn .= '</div>';
                
                $data[$i][] = $action_btn;
                // end: delete and edit button
                
                $i++;
            }
        }
        
        $this->data['datatable']['draw']            = $this->input->post('draw');
        $this->data['datatable']['recordsTotal']    = count($dataCount);
        $this->data['datatable']['recordsFiltered'] = count($dataCount);
        $this->data['datatable']['data']            = $data;
        
        //echo '<pre>'; print_r($this->data['datatable']); die();
        
        echo json_encode($this->data['datatable']);
        
    }
    /*---- end: get_product function ----*/
	
	function get_rfqs(){
		// database column for searching
        $db_column = array('r.rfq_id', 'r.rfq_num', 'r.rfq_date', 'r.due_date');

        // load product model
        $this->load->model('admin/Quotation_model');
		
		// *****************************************
        // start: get all requitision or search requisition
        // *****************************************
        $db_where_column    = array();
        $db_where_value     = array();
        $db_where_column_or = array('r.status', 'r.status', 'r.status');
        $db_where_value_or  = array(1, 3, 4);
        $db_limit           = array();
        $db_order           = array();
        
        /***** start: record length and start *****/
        if($this->input->post('length') != '-1') {
            $db_limit['limit'] = $this->input->post('length');
            $db_limit['pageStart'] = $this->input->post('start');
        }
        // end: get data order by
        
        /***** start: get data order by *****/
        $order = $this->input->post('order');
        
        if($order) {
            foreach($order as $key => $get_order) {
                
                $db_order[$key]['title']    = $db_column[$get_order['column']-1];
                $db_order[$key]['order_by'] = $get_order['dir'];
                
            }            
        }
        // end: get data order by
        
        /***** start: top search data by equal to *****/
        if($this->input->post('top_search_like')) {
            foreach($this->input->post('top_search_like') as $key => $search_val) {

                if(preg_match('/prod/', $key)) {

                    $search_key = substr($key, 5);
                    
                    if(!empty($search_val)) {
                        $db_where_column[]  = $search_key . ' LIKE';
                        $db_where_value[]   = '%' . $search_val . '%';
                    }

                }

            }
        }
        
        if($this->input->post('top_search')) {
            foreach($this->input->post('top_search') as $key => $search_val) {

                if(preg_match('/prod/', $key)) {

                    $search_key = substr($key, 5);
                    
                    if($search_val!="") {
                        $db_where_column[]  = $search_key;
                        $db_where_value[]   = $search_val;
                    }

                }

            }
        }
        // end: top search data by equal to
        
        /***** start: search data by like *****/
        $search = $this->input->post('search');
        
        if($search['value'] != '') {
            foreach($db_column as $value) {
                $db_where_column_or[]   = $value . ' LIKE';
                $db_where_value_or[]    = '%' . $search['value'] . '%';
            }
        }
        // end: search data by like
        
        $dataRecord = $this->Quotation_model->get_all_rfqs($db_where_column, $db_where_value, $db_where_column_or, $db_where_value_or, $db_limit, $db_order);
        
        $dataCount = $this->Quotation_model->get_all_rfqs($db_where_column, $db_where_value, $db_where_column_or, $db_where_value_or);
        // end: get all requisitions or search requisition
        
        $dt_column = array('rfq_num', 'rfq_date', 'due_date');
        
        $data = array();
        $i = 0;
        
        if($dataRecord) {
            
            $view = "admin/rfq/view/";
            $edit = "";//"admin/requisition/edit/";
            $remove = "";//"admin/requisition/delete_requisition/";

            $btn_arr_responce = $this->create_action_array($view,$edit,$remove);
            foreach($dataRecord as $key => $value) {
                
                /*$btn_array_checked_checkbox = "admin/product/delete_checked_checkbox/";
                $checkbox = "";
                if(!$this->flexi_auth->is_privileged($this->menu_model->get_privilege_name($btn_array_checked_checkbox))){
                    $checkbox="disabled";
                }
                $data[$i][] = '<div class="checkbox-table"><label>
                                    <input type="checkbox" '.$checkbox.' name="rfq['.$value['rfq_id'].']" class="flat-grey deleteThis">
                                </label></div>';*/
                
                foreach($dt_column as $get_dt_column) {
                    
                    if($get_dt_column == 'rfq_date'){
                        $data[$i][] = date("d/M/Y", strtotime($value[$get_dt_column]));
                    }
                    else if($get_dt_column == 'due_date'){
                        $data[$i][] = date("d/M/Y", strtotime($value[$get_dt_column]));
                    }
                    else {
                        $data[$i][] = $value[$get_dt_column];
                    }
                    
                }

                /***** start: delete and edit button *****/
                $action_btn = '';
                
                $action_btn .= '<div class="visible-md visible-lg hidden-sm hidden-xs">';

                //$action_btn .= $this->create_action_buttons($btn_arr_responce,$value['rfq_id']);
				$rfq_id = $value['rfq_id'];
				
				$action_btn .= '
				<a href="'.base_url().'admin/rfq/view/'.$rfq_id.'" class="" data-placement="top" data-original-title="View Detail" > <i class="glyphicon glyphicon-eye-open"></i> </a>';
				
				
                $action_btn .= '</div>';
                
                $data[$i][] = $action_btn;
                // end: delete and edit button
                
                $i++;
            }
        }
        
        $this->data['datatable']['draw']            = $this->input->post('draw');
        $this->data['datatable']['recordsTotal']    = count($dataCount);
        $this->data['datatable']['recordsFiltered'] = count($dataCount);
        $this->data['datatable']['data']            = $data;
        
        //echo '<pre>'; print_r($this->data['datatable']); die();
        
        echo json_encode($this->data['datatable']);
	}
	
	function get_comparatives(){
		// database column for searching
        $db_column = array('r.rfq_id', 'r.rfq_num', 'r.rfq_date', 'r.due_date');

        // load product model
        $this->load->model('admin/Quotation_model');
		
		// *****************************************
        // start: get all requitision or search requisition
        // *****************************************
        $db_where_column    = array();
        $db_where_value     = array();
        $db_where_column_or = array('r.status', 'r.status', 'r.status');
        $db_where_value_or  = array(1, 3, 4);
        $db_limit           = array();
        $db_order           = array();
        
        /***** start: record length and start *****/
        if($this->input->post('length') != '-1') {
            $db_limit['limit'] = $this->input->post('length');
            $db_limit['pageStart'] = $this->input->post('start');
        }
        // end: get data order by
        
        /***** start: get data order by *****/
        $order = $this->input->post('order');
        
        if($order) {
            foreach($order as $key => $get_order) {
                
                $db_order[$key]['title']    = $db_column[$get_order['column']-1];
                $db_order[$key]['order_by'] = $get_order['dir'];
                
            }            
        }
        // end: get data order by
        
        /***** start: top search data by equal to *****/
        if($this->input->post('top_search_like')) {
            foreach($this->input->post('top_search_like') as $key => $search_val) {

                if(preg_match('/prod/', $key)) {

                    $search_key = substr($key, 5);
                    
                    if(!empty($search_val)) {
                        $db_where_column[]  = $search_key . ' LIKE';
                        $db_where_value[]   = '%' . $search_val . '%';
                    }

                }

            }
        }
        
        if($this->input->post('top_search')) {
            foreach($this->input->post('top_search') as $key => $search_val) {

                if(preg_match('/prod/', $key)) {

                    $search_key = substr($key, 5);
                    
                    if($search_val!="") {
                        $db_where_column[]  = $search_key;
                        $db_where_value[]   = $search_val;
                    }

                }

            }
        }
        // end: top search data by equal to
        
        /***** start: search data by like *****/
        $search = $this->input->post('search');
        
        if($search['value'] != '') {
            foreach($db_column as $value) {
                $db_where_column_or[]   = $value . ' LIKE';
                $db_where_value_or[]    = '%' . $search['value'] . '%';
            }
        }
        // end: search data by like
        
        $dataRecord = $this->Quotation_model->get_all_rfqs($db_where_column, $db_where_value, $db_where_column_or, $db_where_value_or, $db_limit, $db_order);
        
        $dataCount = $this->Quotation_model->get_all_rfqs($db_where_column, $db_where_value, $db_where_column_or, $db_where_value_or);
        // end: get all requisitions or search requisition
        
        $dt_column = array('rfq_num', 'rfq_date', 'due_date');
        
        $data = array();
        $i = 0;
        
        if($dataRecord) {
            
            $view = "admin/rfq/view/";
            $edit = "";//"admin/requisition/edit/";
            $remove = "";//"admin/requisition/delete_requisition/";

            $btn_arr_responce = $this->create_action_array($view,$edit,$remove);
            foreach($dataRecord as $key => $value) {
                
                /*$btn_array_checked_checkbox = "admin/product/delete_checked_checkbox/";
                $checkbox = "";
                if(!$this->flexi_auth->is_privileged($this->menu_model->get_privilege_name($btn_array_checked_checkbox))){
                    $checkbox="disabled";
                }
                $data[$i][] = '<div class="checkbox-table"><label>
                                    <input type="checkbox" '.$checkbox.' name="rfq['.$value['rfq_id'].']" class="flat-grey deleteThis">
                                </label></div>';*/
                
                foreach($dt_column as $get_dt_column) {
                    
                    if($get_dt_column == 'rfq_date'){
                        $data[$i][] = date("d/M/Y", strtotime($value[$get_dt_column]));
                    }
                    else if($get_dt_column == 'due_date'){
                        $data[$i][] = date("d/M/Y", strtotime($value[$get_dt_column]));
                    }
                    else {
                        $data[$i][] = $value[$get_dt_column];
                    }
                    
                }

                /***** start: delete and edit button *****/
                $action_btn = '';
                
                $action_btn .= '<div class="visible-md visible-lg hidden-sm hidden-xs">';

                //$action_btn .= $this->create_action_buttons($btn_arr_responce,$value['rfq_id']);
				$rfq_id = $value['rfq_id'];
				
				//$action_btn .= '
				//<a href="'.base_url().'admin/rfq/view/'.$rfq_id.'" class="" data-placement="top" data-original-title="View Detail" > <i class="glyphicon glyphicon-eye-open"></i> </a>';
				
				$action_btn .= '
				<a href="'.base_url().'admin/purchase_order/add/'.$rfq_id.'" class="" data-placement="top" data-original-title="Create Purchase Order" > Create Purchase Order </a>';
				
                $action_btn .= '
				<a href="'.base_url().'admin/comparative_quotation/generate_comparative/'.$rfq_id.'" class="" data-placement="top" data-original-title="Generate Comparison" > | <i class="glyphicon glyphicon-save"></i> </a>';

                $action_btn .= '</div>';
                
                $data[$i][] = $action_btn;
                // end: delete and edit button
                
                $i++;
            }
        }
        
        $this->data['datatable']['draw']            = $this->input->post('draw');
        $this->data['datatable']['recordsTotal']    = count($dataCount);
        $this->data['datatable']['recordsFiltered'] = count($dataCount);
        $this->data['datatable']['data']            = $data;
        
        //echo '<pre>'; print_r($this->data['datatable']); die();
        
        echo json_encode($this->data['datatable']);
	}
	
    /*
    |------------------------------------------------
    | start: get_product_for_order function
    |------------------------------------------------
    |
    | This function get product and search product
    | via ajax
    |
   */
  function get_product_for_order() {
        // database column for searching
        $db_column = array('', 'p.product_id', 'p.product_title', 'p.product_model', 'p.product_quantity', 'p.product_org_price', 'p.discount_value');

        // load product model
        $this->load->model('admin/product_model');

        // *****************************************
        // start: get all product or search product
        // *****************************************
        $db_where_column = array();
        $db_where_value = array();
        $db_where_column_or = array();
        $db_where_value_or = array();
        $db_limit = array();
        $db_order = array();

        /*         * *** start: record length and start **** */
        if ($this->input->post('length') != '-1') {
            $db_limit['limit'] = $this->input->post('length');
            $db_limit['pageStart'] = $this->input->post('start');
        }
        // end: get data order by

        /*         * *** start: get data order by **** */
        $order = $this->input->post('order');

        if ($order) {
            foreach ($order as $key => $get_order) {

                $db_order[$key]['title'] = $db_column[$get_order['column']];
                $db_order[$key]['order_by'] = $get_order['dir'];
            }
        }
        // end: get data order by

        /*         * *** start: top search data by equal to **** */

        if ($this->input->post('top_search')) {
            foreach ($this->input->post('top_search') as $key => $search_val) {

                if (preg_match('/prod/', $key)) {

                    $search_key = substr($key, 5);

                    if (!empty($search_val)) {
                        $db_where_column[] = $search_key;
                        $db_where_value[] = $search_val;
                    }
                }
            }
        }
        // end: top search data by equal to

        /*         * *** start: search data by like **** */
        $search = $this->input->post('search');

        if ($search['value'] != '') {
            foreach ($db_column as $value) {
                $db_where_column_or[] = $value . ' LIKE';
                $db_where_value_or[] = '%' . $search['value'] . '%';
            }
        }
        // end: search data by like

        $dataRecord = $this->product_model->get_product($db_where_column, $db_where_value, $db_where_column_or, $db_where_value_or, $db_limit, $db_order);

        $dataCount = $this->product_model->get_product($db_where_column, $db_where_value, $db_where_column_or, $db_where_value_or);
        // end: get all product or search product
        $dt_column = array('img_name', 'product_id', 'product_title', 'product_model', 'product_quantity', 'product_org_price', 'discount_value');

        $data = array();
        $i = 0;

        if ($dataRecord) {

            $view = "admin/product/view_product_detail/";
            $edit = "admin/product/edit_product/";
            $remove = "admin/product/delete_product/";

            //$btn_arr_responce = $this->create_action_array($view,$edit,$remove); 
            foreach ($dataRecord as $key => $value) {
                //echo '<pre>'; print_r($value); die;
                $discount = $value['product_org_price'] - $value['discount_value'];
                foreach ($dt_column as $get_dt_column) {

                    if ($get_dt_column == 'img_name') {
						$image_name = "upload/product/thumbnail_50/" . $value[$get_dt_column];
                        //if ($value[$get_dt_column]) {
						if($value[$get_dt_column] != "" && file_exists($image_name)) {	
                            $product_img = '<a class="group1" href="' . base_url() . 'upload/product/' . $value[$get_dt_column] . '" title="">';
                            $product_img .= '<img src="' . base_url() . 'upload/product/thumbnail_50/' . $value[$get_dt_column] . '" class="img-responsive" alt=""/>';
                            $product_img .= '</a>';

                            $data[$i][] = $product_img;
                        } else
                            $data[$i][] = '<img src="' . base_url() . 'includes/admin/images/no-image.png" alt="image"/>';
                    }
                    else if ($get_dt_column == 'product_title') {
                        $data[$i][] = '<a href="' . base_url() . 'admin/product/view_product_detail/' . $value['product_id'] . '">' . $value[$get_dt_column] . '</a>';
                    } else if ($get_dt_column == 'product_quantity') {
                        $data[$i][] = ($value[$get_dt_column] <= 0) ? 'Out of Stock' : $value[$get_dt_column];
                        $disable = ($value[$get_dt_column] <= 0) ? 'disabled' : '';
                    } else if ($get_dt_column == 'discount_value') {

                        $data[$i][] = number_format($discount, 2); //($value[$get_dt_column] <= 0) ? 'Out of Stock' : $value[$get_dt_column];
                    } else if ($get_dt_column == 'product_org_price') {

                        $data[$i][] = number_format($value[$get_dt_column], 2);
                    } else {
                        $data[$i][] = $value[$get_dt_column];
                    }
                }

                /*                 * *** start: delete and edit button **** */
                $action_btn = '';

                $action_btn .= '<div class="visible-md visible-lg hidden-sm hidden-xs">';

//                $action_btn .= $this->create_action_buttons($btn_arr_responce,$value['product_id']);
                $action_btn .= '<button onclick="add_cart(' . $value["product_id"] . ',' . $value["product_quantity"] . ')" class="' . $disable . ' btn btn-xs btn-bricky btn-teal tooltips add_cart" data-product_id="' . $value["product_id"] . '" data-product_quantity="' . $value["product_quantity"] . '" data-placement="top">Add To Cart</button>';

                $action_btn .= '</div>';

                $data[$i][] = $action_btn;
                // end: delete and edit button

                $i++;
            }
        }

        $this->data['datatable']['draw'] = $this->input->post('draw');
        $this->data['datatable']['recordsTotal'] = count($dataCount);
        $this->data['datatable']['recordsFiltered'] = count($dataCount);
        $this->data['datatable']['data'] = $data;

        //echo '<pre>'; print_r($this->data['datatable']); die();

        echo json_encode($this->data['datatable']);
    }

    /*---- end: get_product_for_order function ----*/
    
    /* =============================================================== */
    
    
    /*
    |------------------------------------------------
    | start: get_category function
    |------------------------------------------------
    |
    | This function get product and search product
    | via ajax
    |
   */
    function get_category() {
        
        // database column for searching
        $db_column = array('c.cat_title');
        
        // load product model
        $this->load->model('admin/category_model');
        
        // *****************************************
        // start: get all product or search product
        // *****************************************
        $db_where_column    = array();
        $db_where_value     = array();
        $db_where_column_or = array();
        $db_where_value_or  = array();
        $db_limit           = array();
        $db_order           = array();
        
        /***** start: record length and start *****/
        if($this->input->post('length') != '-1') {
            //$db_limit['limit'] = $this->input->post('length');
            //$db_limit['pageStart'] = $this->input->post('start');
        }
        // end: get data order by
        
        /***** start: get data order by *****/
        $order = $this->input->post('order');
        //echo '<pre>'; print_r($order); die;
        
        if($order) {
            foreach($order as $key => $get_order) {
                
                $db_order[$key]['title']    = $db_column[$get_order['column']-1];
                $db_order[$key]['order_by'] = $get_order['dir'];
                
            }            
        }
        // end: get data order by
        
        /***** start: search data by equal to *****/
        if($this->input->post('top_search')) {
            foreach($this->input->post('top_search') as $key => $search_val) {

                if(preg_match('/cat/', $key)) {

                    $search_key = substr($key, 4);
                    
                    if(!empty($search_val)) {
                        $db_where_column[]  = $search_key . ' LIKE';
                        $db_where_value[]   = '%' . $search_val . '%';
                    }

                }

            }
        }
        // end: search data by equal to
        
        /***** start: search data by like *****/
        $search = $this->input->post('search');
        
        if($search['value'] != '') {
            foreach($db_column as $value) {
                $db_where_column_or[]   = $value . ' LIKE';
                $db_where_value_or[]    = '%' . $search['value'] . '%';
            }
        }
        // end: search data by like
        
        $dataRecord = $this->category_model->get_category($db_where_column, $db_where_value, $db_where_column_or, $db_where_value_or, $db_limit, $db_order);
        
        $dataCount = $this->category_model->get_category($db_where_column, $db_where_value, $db_where_column_or, $db_where_value_or);
        // end: get all product or search product
        
        //echo count($dataRecord); die();
        
        // start: set array and find parent of child
        $ref = array();
        $items = array();
        $data = array();

        if($dataRecord){
            
            $view_child_category_link   = "admin/category/add_category_child/";
            $view_child_category        = $this->menu_model->get_privilege_name($view_child_category_link);
            $edit                       = "admin/category/edit_category/";
            $remove                     = "admin/category/delete_category/";
            $btn_arr_responce = $this->create_action_array($view_child_category,$edit,$remove);
            
            
        foreach($dataRecord as $category) {
            
            $thisRef = &$ref[$category['cat_id']];

            $thisRef['cat_id'] = $category['cat_id'];
            $thisRef['cat_parent'] = $category['cat_parent_id'];
            $thisRef['cat_title'] = $category['cat_title'];

            if ($category['cat_parent_id'] == 0) {
                $items[$category['cat_id']] = &$thisRef;
            } else {
                $ref[$category['cat_parent_id']]['child'][$category['cat_id']] = &$thisRef;
            }
        }
        
        $dataRecord = $this->get_category_child($items);
        // end: set array and find parent of child
        
        $dataCount = $dataRecord;
        
        if($this->input->post('length') != '-1') {
            $dataRecord = array_slice( $dataRecord, $this->input->post('start'), $this->input->post('length') );
        }
        
        // count category
        //echo $dataCount = count($dataRecord);
        //die();
        
        $dt_column = array('cat_title');
        
        //$data = array();
        $i = 0;
        
        if($dataRecord) {
            foreach($dataRecord as $key => $value) {
                
                $data[$i][] = "CAT_".$value['cat_id'];
                
                foreach($dt_column as $get_dt_column) {
                    
                    $data[$i][] = $value[$get_dt_column];
                    
                }
                
                /***** start: add new child button *****/
                $add_child_btn = '';
                
                $add_child_btn .= '<div class="visible-md visible-lg hidden-sm hidden-xs">';
                (isset($view_child_category) && $view_child_category != "")?$add_child_btn .= '<a href="'.base_url().$view_child_category_link.$value['cat_id'].'" class="" data-placement="top" data-original-title="Add Child Category">Add Child Category</a>':$add_child_btn .= 'No Privilege to Add Child Category';
                
                $add_child_btn .= '</div>';                                
                                                    
                $data[$i][] = $add_child_btn;                         
                // end: add new child button
                
                /***** start: delete and edit button *****/
                $action_btn = '';
                
                $action_btn .= '<div class="visible-md visible-lg hidden-sm hidden-xs">';
                
                $action_btn .= $this->create_action_buttons($btn_arr_responce,$value['cat_id']);
                
                $action_btn .= '</div>';
                
                $data[$i][] = $action_btn;
                // end: delete and edit button
                
                $i++;
            }
        }}
        
        $this->data['datatable']['draw']            = $this->input->post('draw');
        $this->data['datatable']['recordsTotal']    = count($dataCount);
        $this->data['datatable']['recordsFiltered'] = count($dataCount);
        $this->data['datatable']['data']            = $data;
        
       // echo '<pre>'; print_r($data); die();
        
        echo json_encode($this->data['datatable']);
        
    }
    /*---- end: get_category function ----*/
    
    /* =============================================================== */
    
    /*
    |------------------------------------------------
    | start: get_category_child function
    |------------------------------------------------
    |
    | This function set child parent relation of category
    |
   */
    function get_category_child($items, $cat_label = null) {

        foreach ($items as $key => $value) {

            if($cat_label && $value['cat_parent'] != 0) {
                $this->cat_tree[$value['cat_id']]['cat_title'] = $cat_label.' > '.$value['cat_title'];
                $this->cat_tree[$value['cat_id']]['cat_id'] = $value['cat_id'];
                $cat = $cat_label.' > '.$value['cat_title'];
            }
            else {
                $this->cat_tree[$value['cat_id']]['cat_title'] = $value['cat_title'];
                $this->cat_tree[$value['cat_id']]['cat_id'] = $value['cat_id'];
                $cat = $value['cat_title'];
            }

            if (array_key_exists('child', $value)) {
                $this->get_category_child($value['child'], $cat);
            }

        }

        return $this->cat_tree;
        
    }
    /*---- end: get_category_child function ----*/
    
    /* =============================================================== */
    
    
    /*
    |------------------------------------------------
    | start: get_custom_fields function
    |------------------------------------------------
    |
    | This function get custom fields and search custom fields
    | via ajax
    |
   */
    function get_custom_fields() {
        
        //echo '<pre>'; print_r($this->input->post()); die();
        
        // database column for searching
        $db_column = array('cf.field_title', 'cf.field_type', '', 'cf.category_id', 'cf.is_active');
        
        // load product model
        $this->load->model('admin/customfields_model');
        
        // *****************************************
        // start: get all product or search product
        // *****************************************
        $db_where_column    = array();
        $db_where_value     = array();
        $db_where_column_or = array();
        $db_where_value_or  = array();
        $db_limit           = array();
        $db_order           = array();
        
        /***** start: record length and start *****/
        if($this->input->post('length') != '-1') {
            $db_limit['limit'] = $this->input->post('length');
            $db_limit['pageStart'] = $this->input->post('start');
        }
        // end: get data order by
        
        /***** start: get data order by *****/
        $order = $this->input->post('order');
        
        if($order) {
            foreach($order as $key => $get_order) {
                
                $db_order[$key]['title']    = $db_column[$get_order['column']-1];
                $db_order[$key]['order_by'] = $get_order['dir'];
                
            }            
        }
        // end: get data order by
        
        /***** start: top search data by equal to *****/
        /*if($this->input->post('top_search_like')) {
            foreach($this->input->post('top_search_like') as $key => $search_val) {

                if(preg_match('/custom/', $key)) {

                    $search_key = substr($key, 7);
                    
                    if(!empty($search_val)) {
                        $db_where_column[]  = $search_key . ' LIKE';
                        $db_where_value[]   = '%' . $search_val . '%';
                    }

                }

            }
        }*/
        
        if($this->input->post('top_search')) {
            foreach($this->input->post('top_search') as $key => $search_val) {

                if(preg_match('/custom/', $key)) {

                    $search_key = substr($key, 7);
                    
                    if(!empty($search_val)) {
                        $db_where_column[]  = $search_key;
                        $db_where_value[]   = $search_val;
                    }

                }

            }
        }
        // end: top search data by equal to
        
        /***** start: search data by like *****/
        $search = $this->input->post('search');
        
        if($search['value'] != '') {
            foreach($db_column as $value) {
                $db_where_column_or[]   = $value . ' LIKE';
                $db_where_value_or[]    = '%' . $search['value'] . '%';
            }
        }
        // end: search data by like
        
        $dataRecord = $this->customfields_model->get_custom_fields($db_where_column, $db_where_value, $db_where_column_or, $db_where_value_or, $db_limit, $db_order);
        
        $dataCount = $this->customfields_model->get_custom_fields($db_where_column, $db_where_value, $db_where_column_or, $db_where_value_or);
        // end: get all product or search product
        
        $dt_column = array('field_title', 'field_type', 'field_value', 'cat_title', 'is_active');
        
        $data = array();
        $i = 0;
        
        if($dataRecord) {
            
            $view = NULL;
            $edit = "admin/customfields/edit_custom_fields/";
            $remove = "admin/customfields/delete_custom_fields/";
            $btn_arr_responce = $this->create_action_array($view,$edit,$remove);
            
            foreach($dataRecord as $key => $value) {
                
                $data[$i][] = '<div class="checkbox-table"><label>
                                    <input type="checkbox" name="product['.$value['id'].']" class="flat-grey deleteThis">
                                </label></div>';
                
                foreach($dt_column as $get_dt_column) {
                    
                    if($get_dt_column == 'field_value') {
                        
                        $field_title = str_replace(" ", "_", strtolower($value['field_title']));
                        $field_values = explode(",",$value['field_value']);
                        
                        $custom_field_preview = '';
                        
                        if($value['field_type'] == "Dropdown" && $value['field_value'] != ""){
                            
                            $custom_field_preview .= '<select name="'.$field_title.'" class="product_cat_id form-control">';
                            $custom_field_preview .= '<option>-- Select '.$value['field_title'].' --</option>';
                            foreach($field_values as $get_value){
                                $custom_field_preview .= '<option value="' . $get_value . '">' . $get_value . '</option>';
                            }
                            $custom_field_preview .= '</select>';
                            
                        }
                        else if($value['field_type'] == "Textbox") {
                            $custom_field_preview .= '<input type="text" name="'.$field_title.'" placeholder="'.$value['field_placeholder'].'">';
                        }
                        else if($value['field_type'] == "Textarea") {
                            $custom_field_preview .= '<textarea name="'.$field_title.'" placeholder="'.$value['field_placeholder'].'" ></textarea>';
                        }
                        else if($value['field_type'] == "Checkbox" && $value['field_value'] != "") {
                            foreach($field_values as $get_value) {
                                $custom_field_preview .= '<input type="checkbox" class="form-control preview_box" name="'.$field_title.'" value="'.$get_value.'">&nbsp;'.$get_value;
                            }
                        }
                        else if($value['field_type'] == "Radio" && $value['field_value'] != ""){
                            foreach($field_values as $get_value) {
                                $custom_field_preview .= '<input type="radio" name="'.$field_title.'" class="form-control preview_box" value="'.$get_value.'>"> '.$get_value;
                            }
                        }
                        
                        $data[$i][] = $custom_field_preview;
                    }
                    else {
                        $data[$i][] = $value[$get_dt_column];
                    }
                    
                }

                /***** start: delete and edit button *****/
                $action_btn = '';
                
                $action_btn .= '<div class="visible-md visible-lg hidden-sm hidden-xs">';
                
                // Check user has privileges to View product, else display a message to notify the user they do not have valid privileges.
                //if($this->flexi_auth->is_privileged('View Product Detail'))
                    //$action_btn .= '<a href="'.base_url().'admin/product/view_product_detail/'.$value['product_id'].'" class="edit_btn btn btn-xs btn-teal tooltips" data-placement="top" data-original-title="View"><i class="fa fa-arrow-circle-right"></i></a>'; 
                
                $action_btn .= $this->create_action_buttons($btn_arr_responce,$value['id']);
                
                $action_btn .= '</div>';
                
                $data[$i][] = $action_btn;
                // end: delete and edit button
                
                $i++;
            }
        }
        
        $this->data['datatable']['draw']            = $this->input->post('draw');
        $this->data['datatable']['recordsTotal']    = count($dataCount);
        $this->data['datatable']['recordsFiltered'] = count($dataCount);
        $this->data['datatable']['data']            = $data;
        
        //echo '<pre>'; print_r($this->data['datatable']); die();
        
        echo json_encode($this->data['datatable']);
        
    }
    /*---- end: get_custom_fields function ----*/
    
    
    /*
    |------------------------------------------------
    | start: get_orders function
    |------------------------------------------------
    |
    | This function get order and search custom order
    | via ajax
    |
   */
    function get_orders($status = null) {
        
        //echo '<pre>'; print_r($this->input->post()); die();
        
        // database column for searching
        $db_column = array('o.order_id', 'o.order_created_date', 'c.customer_first_name', 'c.customer_last_name', 'o.prod_ordered_total', 'os.status_name', 'smsData');
        //$db_column = array('o.order_id', 'o.order_created_date', 'c.customer_id','c.customer_first_name', 'c.customer_last_name', 'o.prod_ordered_total', 'o.order_status', 'smsData');
        
        // load product model
        $this->load->model('admin/order_model');
        
        // *****************************************
        // start: get all product or search product
        // *****************************************
        $db_where_column    = array();
        $db_where_value     = array();
        $db_where_column_or = array();
        $db_where_value_or  = array();
        $db_limit           = array();
        $db_order           = array();
        
        /***** start: record length and start *****/
        if($this->input->post('length') != '-1') {
            $db_limit['limit'] = $this->input->post('length');
            $db_limit['pageStart'] = $this->input->post('start');
        }
        // end: get data order by
        
        /***** start: get data order by *****/
        $order = $this->input->post('order');
        
        if($order) {
            foreach($order as $key => $get_order) {
                
                if($get_order['column'] >= 4) {
                    $db_order[$key]['title']    = $db_column[$get_order['column']];
                    $db_order[$key]['order_by'] = $get_order['dir'];
                }
                else {
                    $db_order[$key]['title']    = $db_column[$get_order['column']-1];
                    $db_order[$key]['order_by'] = $get_order['dir'];
                }
                
            }            
        }
        // end: get data order by
        
        /***** start: top search data by equal to *****/
        if($this->input->post('top_search_like')) {
            
            //echo '<pre>';
            foreach($this->input->post('top_search_like') as $key => $search_val) {

                if(preg_match('/order/', $key)) { //echo 'REHMAN'; echo '<br />';

                    $search_key = substr($key, 6);
                    
                    if(!empty($search_val)) {     
                        if($search_key == "order_created_date"){ 
                            // Change the date format to get exact date for searching 
                            $search_val = date("Y-m-d", strtotime($search_val));
                        }
                        $db_where_column[]  = 'o.'.$search_key . ' LIKE';
                        $db_where_value[]   = '%' . $search_val . '%';
                    }

                }
                
                if(preg_match('/cus/', $key)) { //echo 'ZIA'; echo '<br />';

                    $search_key = substr($key, 4);
                    
                    if(!empty($search_val)) {
                        
                        if($search_key == 'customer_name')
                            $db_where_column[]  = "concat(c.customer_first_name , ' ' , c.customer_last_name) LIKE";
                        else
                            $db_where_column[]  = 'c.'.$search_key . ' LIKE';
                        
                        $db_where_value[]   = '%' . $search_val . '%';
                        
                    }

                }

            }
        }
        
        //echo '<pre>'; print_r($db_where_column);
        //echo '<pre>'; print_r($db_where_value);
        
        if($this->input->post('top_search')) {
            foreach($this->input->post('top_search') as $key => $search_val) {

                if(preg_match('/order/', $key)) { //echo 'REHMAN 11'; echo '<br />';

                    $search_key = substr($key, 6);
                    
                    if(!empty($search_val)) {
                        if($search_key == 'order_status'){
                            $search_val =$this->order_model->getOrderStatusByName($search_val);
                        }

                        if($search_key == 'order_created_date') {
                            $db_where_column[]  = 'o.'.$search_key.' LIKE';
                            $db_where_value[] = date("Y-m-d", strtotime($search_val)) . '%';
                        }
                        else {
                            $db_where_column[]  = 'o.'.$search_key;
                            $db_where_value[]   = $search_val;
                        }
                        
                        
                    }

                }

            }
        }
        //die();
        // end: top search data by equal to
        
        /***** start: search data by like *****/
        $search = $this->input->post('search');
        
        if($search['value'] != '') {
            foreach($db_column as $value) {
                $db_where_column_or[]   = $value . ' LIKE';
                $db_where_value_or[]    = '%' . $search['value'] . '%';
            }
        }
        // end: search data by like
        
        $dataRecord = $this->order_model->get_order($db_where_column, $db_where_value, $db_where_column_or, $db_where_value_or, $db_limit, $db_order);
        
        $dataCount = $this->order_model->get_order($db_where_column, $db_where_value, $db_where_column_or, $db_where_value_or);
        // end: get all product or search product
        
        //$dt_column = array('order_id', 'order_created_date', 'customer_first_name', 'prod_ordered_total', 'order_status', 'smsData');
        $dt_column = array('order_id', 'order_created_date', 'customer_first_name', 'prod_ordered_total', 'status_name', 'smsData');

        $data = array();
        $i = 0;
        
        if($dataRecord) {
            
            $view = NULL;
            $edit = "admin/order/edit_order/";
            $remove = "admin/order/delete_order/";
            $btn_arr_responce = $this->create_action_array($view,$edit,$remove); 
            
            foreach($dataRecord as $key => $value) {
                
                $btn_array_checked_checkbox = "admin/order/delete_checked_checkbox/";
                $checkbox = "";
                if(!$this->flexi_auth->is_privileged($this->menu_model->get_privilege_name($btn_array_checked_checkbox))){
                    $checkbox="disabled";
                }
                $data[$i][] = '<div class="checkbox-table"><label>
                                    <input type="checkbox" '.$checkbox.' name="product['.$value['order_id'].']" class="flat-grey deleteThis">
                                </label></div>';
                
                foreach($dt_column as $get_dt_column) {
                    
                    if($get_dt_column == 'order_created_date') {
                        $data[$i][] = date("d-m-Y", strtotime($value['order_created_date']));
                    }
                    else if($get_dt_column == 'customer_first_name') {
                        $data[$i][] = $value['customer_first_name'] . ' ' . $value['customer_last_name'];
                    }
                    else if($get_dt_column == 'prod_ordered_total') {
                        $data[$i][] = number_format($value['prod_ordered_total'], 2);
                    }
                    else if($get_dt_column == 'smsData') {
                        
                        $sms_status = "";
                        if ($value['smsData']) {
                            foreach ($value['smsData'] as $recoardKey => $sms_record) {
                                if ($sms_record['action'] == 'sendmessage') {
                                    $sms_status = "Sent";
                                }
                                if ($sms_record['action'] == 'receivemessage') {
                                    $sms_status = "Confirmed";
                                }
                            }
                        }
                        
                        $data[$i][] = $sms_status;
                    }
                    else {
                        $data[$i][] = $value[$get_dt_column];
                    }
                    
                }

                /***** start: delete and edit button *****/
                $action_btn = '';
                
                $action_btn .= '<div class="visible-md visible-lg hidden-sm hidden-xs">';
                
                $btn_array_view = "admin/order/view_detail/";
                if($this->flexi_auth->is_privileged($this->menu_model->get_privilege_name($btn_array_view)))
                    $action_btn .= '<a href="'.base_url().'admin/order/view_detail/'.$value['customer_id'].'/'. $value['order_id'].'" class="edit_btn btn btn-xs btn-teal tooltips" data-placement="top" data-original-title="View"><i class="fa fa-arrow-circle-right"></i></a>'; 
                
                $action_btn .= $this->create_action_buttons($btn_arr_responce,$value['order_id']);
                
                /*
                // Check user has privileges to View order, else display a message to notify the user they do not have valid privileges.
                if($this->flexi_auth->is_privileged('View Order'))
                    $action_btn .= '<a href="'.base_url().'admin/order/view_detail/'.$value['customer_id'].'/'. $value['order_id'].'" class="edit_btn btn btn-xs btn-teal tooltips" data-placement="top" data-original-title="View"><i class="fa fa-arrow-circle-right"></i></a>'; 
                
                
                // Check user has privileges to edit order, else display a message to notify the user they do not have valid privileges.
                if($this->flexi_auth->is_privileged('Edit Order'))
                    $action_btn .= '<a href="'.base_url().'admin/order/edit_order/'.$value['order_id'].'" class="edit_btn btn btn-xs btn-teal tooltips" data-placement="top" data-original-title="Edit"><i class="fa fa-edit"></i></a>';

                // Check user has privileges to delete order, else display a message to notify the user they do not have valid privileges.
                if($this->flexi_auth->is_privileged('Delete Order'))
                    $action_btn .= '<a href="'.base_url().'admin/order/delete_order/'.$value['order_id'].'" class="btn btn-xs btn-bricky tooltips" data-placement="top" data-original-title="Remove"><i class="fa fa-times fa fa-white"></i></a>';
                */
                $action_btn .= '</div>';
                
                $data[$i][] = $action_btn;
                // end: delete and edit button
                
                $i++;
            }
        }
        
        $this->data['datatable']['draw']            = $this->input->post('draw');
        $this->data['datatable']['recordsTotal']    = count($dataCount);
        $this->data['datatable']['recordsFiltered'] = count($dataCount);
        $this->data['datatable']['data']            = $data;
        
        //echo '<pre>'; print_r($this->data['datatable']); die();
        
        echo json_encode($this->data['datatable']);
        
    }
    /*---- end: get_orders function ----*/
    
    
    
    
    /*
    |------------------------------------------------
    | start: get_customers function
    |------------------------------------------------
    |
    | This function get customer and search customer 
    | via ajax
    |
   */
    function get_customers() {
        
        //echo '<pre>'; print_r($this->input->post()); die();
        
        // database column for searching
        $db_column = array('customer_id', 'customer_first_name', 'customer_last_name', 'customer_email', 'customer_contact_no', 'customer_address');
        
        // load customer model
        $this->load->model('admin/customer_model');
        
        // *****************************************
        // start: get all customer or search customer
        // *****************************************
        $db_where_column    = array();
        $db_where_value     = array();
        $db_where_column_or = array();
        $db_where_value_or  = array();
        $db_limit           = array();
        $db_order           = array();
        
        /***** start: record length and start *****/
        if($this->input->post('length') != '-1') {
            $db_limit['limit'] = $this->input->post('length');
            $db_limit['pageStart'] = $this->input->post('start');
        }

        /***** start: get data order by *****/
        $order = $this->input->post('order');
        
        if($order) {
            foreach($order as $key => $get_order) {
                
                if($get_order['column']-1 >= 3) {
                    $db_order[$key]['title']    = $db_column[$get_order['column']];
                    $db_order[$key]['order_by'] = $get_order['dir'];
                }
                else {
                    $db_order[$key]['title']    = $db_column[$get_order['column']-1];
                    $db_order[$key]['order_by'] = $get_order['dir'];
                }
                
            }            
        }
        
        // end: get data order by
        
        
        
        
        
        
        /***** start: top search data by equal to *****/
        if($this->input->post('top_search_like')) {
            
            //echo '<pre>';
            foreach($this->input->post('top_search_like') as $key => $search_val) {

                if(preg_match('/value/', $key)) { // Search By ID and Contact#

                    $search_key = substr($key, 6);
                    
                    if(!empty($search_val)) {
                        $db_where_column[]  = $search_key . ' LIKE';
                        $db_where_value[]   = '%' . $search_val . '%';
                    }

                }else if(preg_match('/cus/', $key)) { //Search By Name 

                    $search_key = substr($key, 4);
                    
                    if(!empty($search_val)) {
                        
                        if($search_key == 'customer_name')
                            $db_where_column[]  = "concat(customer_first_name , ' ' , customer_last_name) LIKE";
                        else
                            $db_where_column[]  = $search_key . ' LIKE';
                        
                        $db_where_value[]   = '%' . $search_val . '%';
                        
                    }

                }

            }
        }
        // end: search data by like
        
        $dataRecord = $this->customer_model->get_customer($db_where_column, $db_where_value, $db_where_column_or, $db_where_value_or, $db_limit, $db_order);
        
        $dataCount = $this->customer_model->get_customer($db_where_column, $db_where_value, $db_where_column_or, $db_where_value_or);
        // end: get all product or search product
        
        $dt_column = array('customer_id', 'customer_name', 'customer_email', 'customer_contact_no', 'customer_address', 'created_date');
        
        $data = array();
        $i = 0;
        
        if($dataRecord) {
            $view = "admin/customer/view_detail/";
            $edit = "admin/customer/edit_customer/";
            $remove = "admin/customer/delete_customer/";

            $btn_arr_responce = $this->create_action_array($view,$edit,$remove);    
                
            foreach($dataRecord as $key => $value) {
                
                $btn_array_checked_checkbox = "admin/customer/delete_checked_checkbox/";
                $checkbox = "";
                if(!$this->flexi_auth->is_privileged($this->menu_model->get_privilege_name($btn_array_checked_checkbox))){
                    $checkbox="disabled";
                }
                $data[$i][] = '<div class="checkbox-table"><label>
                                    <input type="checkbox" '.$checkbox.' name="customer['.$value['customer_id'].']" class="flat-grey deleteThis">
                                </label></div>';
                
                foreach($dt_column as $get_dt_column) {
                    
                    if ($get_dt_column == 'customer_name') {
                        $data[$i][] = $value['customer_first_name'] . ' ' . $value['customer_last_name'];
                    } else if($get_dt_column == 'created_date') {
                        $data[$i][] = date("d-m-Y", strtotime($value['created_date']));
                    }
                    else {

                        $data[$i][] = $value[$get_dt_column];
                    }
                }

                /***** start: delete and edit button *****/
                $action_btn = '';
                
                $action_btn .= '<div class="visible-md visible-lg hidden-sm hidden-xs">';
                
                $action_btn .= $this->create_action_buttons($btn_arr_responce,$value['customer_id']);
                
                $action_btn .= '</div>';
                
                $data[$i][] = $action_btn;
                // end: delete and edit button
                
                $i++;
            }
        }
        
        $this->data['datatable']['draw']            = $this->input->post('draw');
        $this->data['datatable']['recordsTotal']    = count($dataCount);
        $this->data['datatable']['recordsFiltered'] = count($dataCount);
        $this->data['datatable']['data']            = $data;
        
        //echo '<pre>'; print_r($this->data['datatable']); die();
        
        echo json_encode($this->data['datatable']);
        
    }
    /*---- end: get_orders function ----*/
	
	
	function get_purchase_orders(){
		// database column for searching
        $db_column = array('po.vendor_id', 'po.po_date', 'po.po_num', 'po.delivery_address');

        // load purchase model
        $this->load->model('admin/Purchase_model');
		
		// *****************************************
        // start: get all requitision or search requisition
        // *****************************************
        $db_where_column    = array();
        $db_where_value     = array();
        $db_where_column_or = array('r.status', 'r.status', 'r.status');
        $db_where_value_or  = array(1, 3, 4);
        $db_limit           = array();
        $db_order           = array();
        
        /***** start: record length and start *****/
        if($this->input->post('length') != '-1') {
            $db_limit['limit'] = $this->input->post('length');
            $db_limit['pageStart'] = $this->input->post('start');
        }
        // end: get data order by
        
        /***** start: get data order by *****/
        $order = $this->input->post('order');
        
        if($order) {
            foreach($order as $key => $get_order) {
                
                $db_order[$key]['title']    = $db_column[$get_order['column']-1];
                $db_order[$key]['order_by'] = $get_order['dir'];
                
            }            
        }
        // end: get data order by
        
        /***** start: top search data by equal to *****/
        if($this->input->post('top_search_like')) {
            foreach($this->input->post('top_search_like') as $key => $search_val) {

                if(preg_match('/prod/', $key)) {

                    $search_key = substr($key, 5);
                    
                    if(!empty($search_val)) {
                        $db_where_column[]  = $search_key . ' LIKE';
                        $db_where_value[]   = '%' . $search_val . '%';
                    }

                }

            }
        }
        
        if($this->input->post('top_search')) {
            foreach($this->input->post('top_search') as $key => $search_val) {

                if(preg_match('/prod/', $key)) {

                    $search_key = substr($key, 5);
                    
                    if($search_val!="") {
                        $db_where_column[]  = $search_key;
                        $db_where_value[]   = $search_val;
                    }

                }

            }
        }
        // end: top search data by equal to
        
        /***** start: search data by like *****/
        $search = $this->input->post('search');
        
        if($search['value'] != '') {
            foreach($db_column as $value) {
                $db_where_column_or[]   = $value . ' LIKE';
                $db_where_value_or[]    = '%' . $search['value'] . '%';
            }
        }
        // end: search data by like
        
        $dataRecord = $this->Purchase_model->get_orders($db_where_column, $db_where_value, $db_where_column_or, $db_where_value_or, $db_limit, $db_order);
        
        $dataCount = $this->Purchase_model->get_orders($db_where_column, $db_where_value, $db_where_column_or, $db_where_value_or);
        // end: get all orders or search purchase orders
        
        $dt_column = array('po_date', 'description', 'vendor_name', 'delivery_address');
        
        $data = array();
        $i = 0;
        
        if($dataRecord) {
            
            $view = "admin/purchase_order/view/";
            $edit = "";//"admin/requisition/edit/";
            $remove = "";//"admin/requisition/delete_requisition/";

            $btn_arr_responce = $this->create_action_array($view,$edit,$remove);
            foreach($dataRecord as $key => $value) {
                
                /*$btn_array_checked_checkbox = "admin/product/delete_checked_checkbox/";
                $checkbox = "";
                if(!$this->flexi_auth->is_privileged($this->menu_model->get_privilege_name($btn_array_checked_checkbox))){
                    $checkbox="disabled";
                }
                $data[$i][] = '<div class="checkbox-table"><label>
                                    <input type="checkbox" '.$checkbox.' name="rfq['.$value['rfq_id'].']" class="flat-grey deleteThis">
                                </label></div>';*/
                
                foreach($dt_column as $get_dt_column) {
                    
                    if($get_dt_column == 'po_date'){
                        $data[$i][] = date("d/M/Y", strtotime($value[$get_dt_column]));
                    }
                    else {
                        $data[$i][] = $value[$get_dt_column];
                    }
                    
                }

                /***** start: delete and edit button *****/
                $action_btn = '';
                
                $action_btn .= '<div class="visible-md visible-lg hidden-sm hidden-xs">';

                //$action_btn .= $this->create_action_buttons($btn_arr_responce,$value['rfq_id']);
				$po_id = $value['po_id'];
				
				$action_btn .= '
				<a href="'.base_url().'admin/grn/add/'.$po_id.'" class="" data-placement="top" data-original-title="Add Goods Receiving" > Add Grn </a>';
				
				$action_btn .= '
				<a href="'.base_url().'admin/purchase_order/generate_order_pdf/'.$po_id.'" class="" data-placement="top" data-original-title="Generate Order" > | <i class="glyphicon glyphicon-save"></i> </a>';
				
				
                $action_btn .= '</div>';
                
                $data[$i][] = $action_btn;
                // end: delete and edit button
                
                $i++;
            }
        }
        
        $this->data['datatable']['draw']            = $this->input->post('draw');
        $this->data['datatable']['recordsTotal']    = count($dataCount);
        $this->data['datatable']['recordsFiltered'] = count($dataCount);
        $this->data['datatable']['data']            = $data;
        
        //echo '<pre>'; print_r($this->data['datatable']); die();
        
        echo json_encode($this->data['datatable']);
	}
	
	
	function get_grns(){
		// database column for searching
        $db_column = array('grn.vendor_id', 'grn.grn_date', 'grno.grn', 'grn.delivery_challan_no');

        // load purchase model
        $this->load->model('admin/Grn_model');
		
		// *****************************************
        // start: get all requitision or search requisition
        // *****************************************
        $db_where_column    = array();
        $db_where_value     = array();
        $db_where_column_or = array('grn.status', 'grn.status', 'grn.status');
        $db_where_value_or  = array(1, 3, 4);
        $db_limit           = array();
        $db_order           = array();
        
        /***** start: record length and start *****/
        if($this->input->post('length') != '-1') {
            $db_limit['limit'] = $this->input->post('length');
            $db_limit['pageStart'] = $this->input->post('start');
        }
        // end: get data order by
        
        /***** start: get data order by *****/
        $order = $this->input->post('order');
        
        if($order) {
            foreach($order as $key => $get_order) {
                
                $db_order[$key]['title']    = $db_column[$get_order['column']-1];
                $db_order[$key]['order_by'] = $get_order['dir'];
                
            }            
        }
        // end: get data order by
        
        /***** start: top search data by equal to *****/
        if($this->input->post('top_search_like')) {
            foreach($this->input->post('top_search_like') as $key => $search_val) {

                if(preg_match('/prod/', $key)) {

                    $search_key = substr($key, 5);
                    
                    if(!empty($search_val)) {
                        $db_where_column[]  = $search_key . ' LIKE';
                        $db_where_value[]   = '%' . $search_val . '%';
                    }

                }

            }
        }
        
        if($this->input->post('top_search')) {
            foreach($this->input->post('top_search') as $key => $search_val) {

                if(preg_match('/prod/', $key)) {

                    $search_key = substr($key, 5);
                    
                    if($search_val!="") {
                        $db_where_column[]  = $search_key;
                        $db_where_value[]   = $search_val;
                    }

                }

            }
        }
        // end: top search data by equal to
        
        /***** start: search data by like *****/
        $search = $this->input->post('search');
        
        if($search['value'] != '') {
            foreach($db_column as $value) {
                $db_where_column_or[]   = $value . ' LIKE';
                $db_where_value_or[]    = '%' . $search['value'] . '%';
            }
        }
        // end: search data by like
        
        $dataRecord = $this->Grn_model->get_grn($db_where_column, $db_where_value, $db_where_column_or, $db_where_value_or, $db_limit, $db_order);
        
        $dataCount = $this->Grn_model->get_grn($db_where_column, $db_where_value, $db_where_column_or, $db_where_value_or);
        // end: get all Grns or search Grns
        
        $dt_column = array('grn_date', 'grn_num', 'delivery_challan_no', 'description', 'vendor_name', 'received_qty', 'accepted_qty');
        
        $data = array();
        $i = 0;
        
        if($dataRecord) {
            
            $view = "admin/grn/view/";
            $edit = "";//"admin/requisition/edit/";
            $remove = "";//"admin/requisition/delete_requisition/";

            $btn_arr_responce = $this->create_action_array($view,$edit,$remove);
            foreach($dataRecord as $key => $value) {
                
                /*$btn_array_checked_checkbox = "admin/product/delete_checked_checkbox/";
                $checkbox = "";
                if(!$this->flexi_auth->is_privileged($this->menu_model->get_privilege_name($btn_array_checked_checkbox))){
                    $checkbox="disabled";
                }
                $data[$i][] = '<div class="checkbox-table"><label>
                                    <input type="checkbox" '.$checkbox.' name="rfq['.$value['rfq_id'].']" class="flat-grey deleteThis">
                                </label></div>';*/
                
                foreach($dt_column as $get_dt_column) {
                    
                    if($get_dt_column == 'grn_date'){
                        $data[$i][] = date("d/M/Y", strtotime($value[$get_dt_column]));
                    }
                    else {
                        $data[$i][] = $value[$get_dt_column];
                    }
                    
                }

                /***** start: delete and edit button *****/
                $action_btn = '';
                
                $action_btn .= '<div class="visible-md visible-lg hidden-sm hidden-xs">';

                //$action_btn .= $this->create_action_buttons($btn_arr_responce,$value['rfq_id']);
				$grn_id = $value['grn_id'];
				
				$action_btn .= '
				<a href="'.base_url().'admin/grn/generate_grn_pdf/'.$grn_id.'" class="" data-placement="top" data-original-title="Generate Grn Report" > <i class="glyphicon glyphicon-save"></i> </a>';
				
				
                $action_btn .= '</div>';
                
                $data[$i][] = $action_btn;
                // end: delete and edit button
                
                $i++;
            }
        }
        
        $this->data['datatable']['draw']            = $this->input->post('draw');
        $this->data['datatable']['recordsTotal']    = count($dataCount);
        $this->data['datatable']['recordsFiltered'] = count($dataCount);
        $this->data['datatable']['data']            = $data;
        
        //echo '<pre>'; print_r($this->data['datatable']); die();
        
        echo json_encode($this->data['datatable']);
	}
	
	
	function get_vendors(){
		
		
        // load vendor model
        $this->load->model('admin/Vendor_model');
		
        $dataRecord = $this->Vendor_model->get_vendor();
        
        $dataCount = $this->Vendor_model->get_vendor();
        // end: get all Vendors
        
        $dt_column = array('vendor_name', 'vendor_address', 'vendor_date', 'location_name');
        
        $data = array();
        $i = 0;
        
        if($dataRecord) {
            
            $view = "";
            $edit = "";//"admin/requisition/edit/";
            $remove = "admin/vendor/delete_vendor/";

            $btn_arr_responce = $this->create_action_array($view,$edit,$remove);
            foreach($dataRecord as $key => $value) {
                
                foreach($dt_column as $get_dt_column) {
                    
                    if($get_dt_column == 'vendor_date'){
                        $data[$i][] = date("d/M/Y", strtotime($value[$get_dt_column]));
                    }
                    else {
                        $data[$i][] = $value[$get_dt_column];
                    }
                    
                }

                /***** start: delete and edit button *****/
                $action_btn = '';
                
                $action_btn .= '<div class="visible-md visible-lg hidden-sm hidden-xs">';

                $action_btn .= $this->create_action_buttons($btn_arr_responce,$value['vendor_id']);
				$vendor_id = $value['vendor_id'];
				
                $action_btn .= '</div>';
                
                $data[$i][] = $action_btn;
                // end: delete and edit button
                
                $i++;
            }
        }
        
        $this->data['datatable']['draw']            = $this->input->post('draw');
        $this->data['datatable']['recordsTotal']    = count($dataCount);
        $this->data['datatable']['recordsFiltered'] = count($dataCount);
        $this->data['datatable']['data']            = $data;
        
        //echo '<pre>'; print_r($this->data['datatable']); die();
        
        echo json_encode($this->data['datatable']);
	}
	
    
    function create_action_array($view_url,$edit_url,$delete_url){
        
        $btn_array = array();
        if($view_url)
            $btn_array["View"]["action"] = $view_url ;
        if($edit_url)
            $btn_array["Edit"]["action"] = $edit_url ;
        if($delete_url)
            $btn_array["Remove"]["action"] = $delete_url ;
                    
        return $this->menu_model->get_privilege_name($btn_array);
    }
    
    function create_action_buttons($data,$id){
        $action_btn = "";
		$icon_classes = '';
        foreach ($data as $keys => $record) {
            // Dynamic Work for the previliges
			if ($keys == 'View') {
				$icon_classes = 'glyphicon glyphicon-eye-open';
			}
			else if ($keys == 'Edit') {
				$icon_classes = 'glyphicon glyphicon-edit';
			}
			else if ($keys == 'Download') {
				$icon_classes = 'glyphicon glyphicon-save';
			}
			else {
				$link_text = $keys;
			}
            if ($this->flexi_auth->is_privileged($record['title']))
               $action_btn .= '<a href="' . base_url() . $record['action'] . $id . '" class="' . $record['aClass'] . '" data-placement="top" data-original-title="' . $keys . '"><i class="' . $record['iClass'] . ' ' . $icon_classes . '"></i>' . $link_text . '</a> &nbsp;&nbsp;&nbsp;';
        }
			
        return $action_btn;
        
    }
    
}

?>