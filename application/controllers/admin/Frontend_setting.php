<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Frontend_setting extends CI_Controller {
    
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
        $this->load->model('admin/frontend_setting_model');
        
        //get uri segment for active menu
        $this->data['uri_3'] = $this->uri->segment(3);
        $this->data['uri_2'] = $this->uri->segment(2);
        $this->data['uri_1'] = $this->uri->segment(1);

        $this->data['sub_menu'] = $this->data['uri_1'].'/'.$this->data['uri_2'].'/'.$this->data['uri_3'];
        $this->data['menu'] = $this->data['uri_2'];
        
        $this->load->model('admin/order_model');
        
        // Get User Privilege 
        $this->load->model('admin/menu_model');
        $check_slash = substr($this->data['sub_menu'], -1);
        $check_slash = ($check_slash == "/")?$this->data['sub_menu']:$this->data['sub_menu']."/";
        $check_slash = str_replace("//","/",$check_slash);


        $this->uri_privileged = $this->menu_model->get_privilege_name($check_slash);
        $this->data['menu_title'] = $this->uri_privileged;

        // Get Dynamic Menus
        $this->data['get_menu'] = $this->menu_model->get_menu();
        
        //get count orders by status (to show count of orders in main side bar)
        $this->data['total_orders_by_status'] = $this->order_model->total_orders_by_status();

        //get count todays orders (to show count of todays orders in top right)
        $this->data['todays_orders'] = $this->order_model->todays_orders();
        
        $this->cat_tree = array();
        $this->load->model('admin/order_model');
        
        // Error Reporting On index.php not showing the errors thats why placed here, path E:\xammp\ecommerce\index.php
        error_reporting(-1);
        ini_set('display_errors', 1);
        
    }
    
    
    /*
    |------------------------------------------------
    | start: index function
    |------------------------------------------------
    |
    | This function work setting of front side
    |
   */
    function index() {
        
        if($this->input->post()) {
            
            $file_name = $this->logo_upload();
            $this->frontend_setting_model->add_general_setting($file_name);
            redirect('admin/frontend_setting');
        }
        
        // unshift crumb
        $this->breadcrumbs->unshift('General Setting', base_url().'admin/frontend_setting');
        
        $this->data['general_setting'] = $this->frontend_setting_model->get_setting(array('fs.setting_id'), array('1'));
        
        $this->data['page_title'] = 'General Setting';
        
        $this->load->view('admin/includes/header', $this->data);
        $this->load->view('admin/frontend/general_setting', $this->data);
        
    }
    /*---- end: index function ----*/
    
    
    /*
    |------------------------------------------------
    | start: logo_upload function
    |------------------------------------------------
    |
    | This function upload logo
    |
   */
    function logo_upload() {
        
        /*
        |--------------------------------------------------------------------------
        | start: UPLOAD PROFILE IMAGE AND RESIZE
        |--------------------------------------------------------------------------
        */
        $this->load->library('upload');
        $this->load->library('image_lib');

        $upload_conf = array(
                            'upload_path'   => 'upload',
                            'allowed_types' => 'gif|jpg|png',
                            'max_size'      => '30000',
                        );

        $this->upload->initialize( $upload_conf );
        
        if(!$this->upload->do_upload('website_logo')) {
            // if image not upload
            if($this->input->post('website_logo_old'))
               return $this->input->post('website_logo_old');
            else
                return null;
        }
        else {
            
            if($this->input->post('website_logo_old'))
                unlink('upload/' . $this->input->post('website_logo_old'));
            
            // otherwise, put the upload datas here.
            // if you want to use database, put insert query in this loop
            $upload_data = $this->upload->data();

            $infoFile = new SplFileInfo($upload_data['file_name']);
            $extension = $infoFile->getExtension();

            // create new file name
            $full_name = str_replace(" ", "-", $this->input->post('first_name'));
            $new_file_name = 'logo-' . date('Ymd') . '.' . $extension;
            
            /***************************
                SET LOGO IMAGE SIZE
            ***************************/
            list($width, $height, $type, $attr) = getimagesize($upload_data['full_path']);                                  
            $getWidth = $this->config->item("logo_dimensions", "general");
            $getWidth = explode("x", $getWidth);
            $newWidth = $getWidth[0]; // 576x115
            $newHeight = ceil($height/$width*$newWidth);

            // set the resize config
            $resize_conf = array(
                    // it's something like "/full/path/to/the/image.jpg" maybe
                    'source_image'  => $upload_data['full_path'], 
                    // and it's "/full/path/to/the/" + "thumb_" + "image.jpg
                    // or you can use 'create_thumbs' => true option instead
                    'new_image'     => $upload_data['file_path'] . $new_file_name,
                    'width'         => $newWidth,
                    'height'        => $newHeight
                );

            // initializing
            $this->image_lib->initialize($resize_conf);

            // do it!
            if ( ! $this->image_lib->resize()) {
                // if got fail.
                $data['resize'][] = $this->image_lib->display_errors();
            }
            else {
                // otherwise, put each upload data to an array.
                unlink($upload_data['full_path']);
                return $new_file_name;
            }
            
        }
        
    }
    /*---- end: logo_upload function ----*/
    
    
    /*
    |------------------------------------------------
    | start: homepage function
    |------------------------------------------------
    |
    | This function set homepage setting
    |
   */
    function homepage() {
        
        if($this->input->post()) {
            $this->frontend_setting_model->add_homepage_setting();
            //echo '<pre>'; print_r($this->input->post()); die();
        }
        
        // unshift crumb
        $this->breadcrumbs->unshift('Homepage Setting', base_url().'admin/frontend_setting/homepage');
        
        $this->data['general_setting'] = $this->frontend_setting_model->get_setting(array('fs.setting_id'), array('1'));
        $this->data['featured_product'] = $this->frontend_setting_model->get_homepage_product(array('hp.model_type'), array('1'));
        $this->data['category_product'] = $this->frontend_setting_model->get_homepage_product(array('hp.model_type'), array('2'));
        
        $this->data['selected_category'] = array();
        
        if($this->data['category_product']) {
            foreach($this->data['category_product'] as $get_data) {
                $this->data['selected_category'][$get_data['category_id']]['category_id']       = $get_data['category_id'];
                $this->data['selected_category'][$get_data['category_id']]['category_title']    = $get_data['cat_title'];
            }
        }
        
        // ************************************
        // start: get all parent categories
        // ************************************
        $db_where_column    = array('cat_parent_id');
        $db_where_value     = array(0);
        $db_where_column_or = array();
        $db_where_value_or  = array();
        $db_limit           = array();
        $db_order           = array(array('title' => 'cat_title', 'order_by' => 'asc'));
        
        // load category model
        $this->load->model('admin/category_model');
        
        $this->data['categories'] = $this->category_model->get_category($db_where_column, $db_where_value, $db_where_column_or, $db_where_value_or, $db_limit, $db_order);
        // end: get all parent categories
        
        $this->data['page_title'] = 'Homepage Setting';
        
        $this->load->view('admin/includes/header', $this->data);
        $this->load->view('admin/'.$this->config->item('theme_name','general').'/homepage_setting', $this->data);
        
    }
    /*---- end: homepage function ----*/
    
    
    /*
    |------------------------------------------------
    | start: get_product_by_category function
    |------------------------------------------------
    |
    | This function get product bu category
    |
   */
    function get_product_by_category() {
        
        $category_id = $this->input->post('category_id');
        
        // ************************************
        // start: get product by id
        // ************************************
        $this->load->model('admin/product_model');
        
        $db_where_column    = array('p.product_cat_id');
        $db_where_value     = array($category_id);
        
        $this->data['product'] = $this->product_model->get_product($db_where_column, $db_where_value);
        // end: get product by id
        
        echo json_encode($this->data['product']);
        
    }
    /*---- end: get_product_by_category function ----*/
    
    function pages(){
        
        if (!$this->flexi_auth->is_privileged($this->uri_privileged)) {
          $this->session->set_flashdata('message', '<p class="error_msg">You do not have access privileges to Frontend Pages.</p>');
          if ($this->flexi_auth->is_admin())
          redirect('auth_admin');
          else
          redirect('auth_public');
          }
         
        //start breadcrumbs
        $this->breadcrumbs->push('Frontend Pages', base_url() . '/admin/frontend_setting/pages');
        
        $this->data['all_pages'] = $this->frontend_setting_model->get_pages();
        
        $btn_array["Add"]["action"] = "admin/frontend_setting/add_frontend_pages/";
        $btn_array["Edit"]["action"] = "admin/frontend_setting/edit_frontend_pages/";
        $btn_array["View"]["action"] = "admin/frontend_setting/view_frontend_pages/";
        $btn_array["Delete"]["action"] = "admin/frontend_setting/delete_frontend_pages/";
        $methods_privileges = $this->menu_model->get_privilege_name($btn_array);
        $this->data['add_frontend_pages'] = (isset($methods_privileges["Add"]["title"]) && ($methods_privileges["Add"]["title"]!=""))?$methods_privileges["Add"]["title"]:"";
        $this->data['edit_frontend_pages'] = (isset($methods_privileges["Edit"]["title"]) && ($methods_privileges["Edit"]["title"]!=""))?$methods_privileges["Edit"]["title"]:"";
        $this->data['view_frontend_pages'] = (isset($methods_privileges["View"]["title"]) && ($methods_privileges["View"]["title"]!=""))?$methods_privileges["View"]["title"]:"";
        $this->data['delete_frontend_pages'] = (isset($methods_privileges["Delete"]["title"]) &&($methods_privileges["Delete"]["title"]!=""))?$methods_privileges["Delete"]["title"]:"";
        
        
        $this->data['page_title'] = 'Frontend Pages';
        
        $this->data['message'] = $this->session->flashdata('message');
        
        $this->load->view('admin/includes/header', $this->data);

        $this->load->view('admin/frontend/view_all_pages', $this->data);
    }
    
    function add_frontend_pages(){
        
         if (!$this->flexi_auth->is_privileged($this->uri_privileged)) {
          $this->session->set_flashdata('message', '<p class="error_msg">You do not have access privileges to Add Frontend Pages.</p>');
          if ($this->flexi_auth->is_admin())
          redirect('auth_admin');
          else
          redirect('auth_public');
          }
        
        // start: add breadcrumbs
        $this->breadcrumbs->push('Add Frontend Pages', base_url().'/admin/frontend_setting/add_frontend_pages');
        
        //unshift breadcrumbs
        $this->breadcrumbs->unshift('Frontend Pages', base_url() . '/admin/frontend_setting/pages');
        
        if($this->input->post()){
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('page_name','pageName','required');
            $this->form_validation->set_rules('page_content','pageContent','required');
            
            if($this->form_validation->run()){
                
               if ($this->frontend_setting_model->add_pages()){
                   $this->session->set_flashdata('message', '<p class="status_msg">Frontend Page inserted successfully.</p>');
                   redirect('/admin/frontend_setting/pages');
               }
            }
        }
        
        $this->data['page_title'] = 'Add Frontend Pages';
        
        $this->load->view('admin/includes/header', $this->data);
        $this->load->view('admin/frontend/add_frontend_page', $this->data);
        
    }
    
    function view_frontend_pages($id){
        
        if (!$this->flexi_auth->is_privileged($this->uri_privileged)) {
          $this->session->set_flashdata('message', '<p class="error_msg">You do not have access privileges to view Frontend Page.</p>');
          if ($this->flexi_auth->is_admin())
          redirect('auth_admin');
          else
          redirect('auth_public');
          }
          
        // start: add breadcrumbs
        $this->breadcrumbs->push('View Frontend Pages', base_url().'/admin/frontend_setting/view_frontend_pages');
        
        //unshift breadcrumbs
        $this->breadcrumbs->unshift('Frontend Pages', base_url() . '/admin/frontend_setting/pages');
        
        $this->data['view_page'] = $this->frontend_setting_model->view_pages($id);
        $this->data['view_page'] =  $this->data['view_page'][0];
        
        $this->data['page_title'] = 'View Frontend Page';

        $this->load->view('admin/includes/header', $this->data);

        $this->load->view('admin/frontend/view_frontend_page', $this->data);
    }
    
    function delete_frontend_pages($id){
        
         if (!$this->flexi_auth->is_privileged($this->uri_privileged)) {
          $this->session->set_flashdata('message', '<p class="error_msg">You do not have access privileges to delete Frontend Pages.</p>');
          if ($this->flexi_auth->is_admin())
          redirect('auth_admin');
          else
          redirect('auth_public');
          }
        
        $this->frontend_setting_model->delete_pages($id);
        
        $this->session->set_flashdata('message', '<p class="status_msg">Frontend Page deleted successfully.</p>');
        redirect('/admin/frontend_setting/pages');
        
    }
    
    function edit_frontend_pages($id){
        
         if (!$this->flexi_auth->is_privileged($this->uri_privileged)) {
          $this->session->set_flashdata('message', '<p class="error_msg">You do not have access privileges to update Frontend Pages.</p>');
          if ($this->flexi_auth->is_admin())
          redirect('auth_admin');
          else
          redirect('auth_public');
          }
        
        
        // start: add breadcrumbs
        $this->breadcrumbs->push('Edit Frontend Pages', base_url().'/admin/frontend_setting/edit_frontend_pages');
        
        //unshift breadcrumbs
        $this->breadcrumbs->unshift('Frontend Pages', base_url() . '/admin/frontend_setting/pages');
        
        $this->data['view_page'] = $this->frontend_setting_model->view_pages($id);
        $this->data['view_page'] =  $this->data['view_page'][0];
        
        if($this->input->post())
        {
            $this->data['update_page'] = $this->frontend_setting_model->update_pages($id);
            $this->session->set_flashdata('message', '<p class="status_msg">Frontend Page updated successfully.</p>');
            redirect('/admin/frontend_setting/pages');
        }
        
        $this->data['page_title'] = 'Edit Frontend Pages';
        
       $this->load->view('admin/includes/header', $this->data);
       $this->load->view('admin/frontend/edit_frontend_page', $this->data);
        
        
    }
    
}