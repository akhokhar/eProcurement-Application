<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Frontend_setting_model extends CI_Model {
    
    /*
    |------------------------------------------------
    | start: add_general_setting function
    |------------------------------------------------
    |
    | This function add frontend setting
    |
   */
    function add_general_setting($file_name) {
        
        $setting = $this->input->post();
        
        $data = array(
                'website_name'          => $setting['website_name'],
                'contact_number'        => $setting['contact_number'],
                'whatsapp_number'       => $setting['whatsapp_number'],
                'viber_number'          => $setting['viber_number'],
                'homepage_title'        => $setting['homepage_title'],
                'copyright'             => $setting['copyright'],
                'meta_description'      => $setting['meta_description'],
                'meta_key_words'        => $setting['meta_key_words'],
                'website_logo'          => $file_name,
                'company_address'       => $setting['company_address'],
                'company_telephone_no'  => $setting['company_telephone_no'],
                'company_email'         => $setting['company_email'],
                'company_website'       => $setting['company_website']
        ); 
        
        $this->db->trans_begin();
        
        if(!$setting['setting_id']) {
            $this->db->set($data);
            $this->db->insert('frontend_setting');
            $setting_id = $this->db->insert_id();
        }
        else {
            $setting_id = $setting['setting_id'];
            $this->db->where('setting_id', $setting_id);
            $this->db->set($data);
            $this->db->update('frontend_setting');
        }

        $this->db->trans_complete();
        
        if($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return $setting_id;
        }
        
    }
    /*---- end: add_general_setting function ----*/
    
    
    /*
    |------------------------------------------------
    | start: get_setting function
    |------------------------------------------------
    |
    | This function get all home and general page setting
    |
    */
    function get_setting($db_where_column, $db_where_value) {
        
        $this->db->select('*');
        
        if($db_where_column) {
            foreach ($db_where_column as $key => $column) {
                if (!empty($db_where_value[$key])) {
                    $this->db->where($column, $db_where_value[$key]);
                }
            }
        }

        $result = $this->db->get('frontend_setting fs');
        
        if($result->num_rows() > 0) {            
            $data = $result->result_array();            
            return $data[0];
        }
        else
            return FALSE;
        
    }
    /*---- end: get_setting function ----*/
    
    
    /*
    |------------------------------------------------
    | start: add_homepage_setting function
    |------------------------------------------------
    |
    | This function add home page setting
    | and home page product
    |
    */
    function add_homepage_setting() {
        
        $setting = $this->input->post();
        
        if(isset($setting['category_select'])) {
            $model_type = 2; //Menu item
            $this->delete_homepage_product($model_type);
            $this->add_homepage_product($setting['category_select'], $model_type);
        }else{
            $model_type = 2; //Menu item
            $this->delete_homepage_product($model_type);
        }
    }
    /*---- end: add_homepage_setting function ----*/
    
    
    /*
    |------------------------------------------------
    | start: add_homepage_product function
    |------------------------------------------------
    |
    | This function add home page product
    |
    */
    function add_homepage_product($product, $model_type) {
        
        foreach($product as $get_data) {
            //list($product_id, $category_id) = explode('_', $get_data);
            $data = array(
                    'model_type'    => $model_type,
                    'category_id'   => $get_data
            ); 
//            /print_r($data); exit;
            $this->db->trans_begin();

            $this->db->set($data);
            $this->db->insert('frontend_homepage_product');
            $setting_id = $this->db->insert_id();

            $this->db->trans_complete();

            if($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return FALSE;
            } else {
                $this->db->trans_commit();
                //return $setting_id;
            }
        }
        
    }
    /*---- end: add_homepage_product function ----*/
    
    
    /*
    |------------------------------------------------
    | start: delete_homepage_product function
    |------------------------------------------------
    |
    | This function delete home page product
    |
    */
    function delete_homepage_product($model_type) {
        
        $this->db->trans_begin();

        //$this->db->set($data);
        $this->db->where('model_type', $model_type);
        $this->db->delete('frontend_homepage_product');

        $this->db->trans_complete();

        if($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            //return FALSE;
        } else {
            $b = $this->db->trans_commit();
            //return TRUE;
        }
        
    }
    /*---- end: delete_homepage_product function ----*/
    
    
    /*
    |------------------------------------------------
    | start: get_homepage_product function
    |------------------------------------------------
    |
    | This function get all home and general page setting
    |
    */
    function get_homepage_product($db_where_column, $db_where_value) {
        
        $this->db->select('hp.*, c.cat_title');
        
        if($db_where_column) {
            foreach ($db_where_column as $key => $column) {
                if (!empty($db_where_value[$key])) {
                    $this->db->where($column, $db_where_value[$key]);
                }
            }
        }

        //$this->db->join('product p', 'p.product_id = hp.product_id');
        $this->db->join('category c', 'c.cat_id = hp.category_id');
        $result = $this->db->get('frontend_homepage_product hp');
        
        if($result->num_rows() > 0) {            
            $data = $result->result_array();            
            return $data;
        }
        else
            return FALSE;
        
    }
    /*---- end: get_homepage_product function ----*/
    
    
    function get_pages() {

        $this->db->select('*');
        $this->db->from('frontend_pages');
        $this->db->where('is_deleted', 0);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        } else {
            return FALSE;
        }
    }
    
    function view_pages($id){
        
        
        $this->db->select('*');
        $this->db->from('frontend_pages');
        $this->db->where('page_id' , $id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            $result = $query->result();
            return $result;
        }
        else
        {
            return FALSE;
        }
    }
    
    function add_pages(){
        
        $data= array(
            'page_name' => $this->input->post('page_name'),
            'page_content' => $this->input->post('page_content'),
            'is_deleted' => 0
        );
        
        $this->db->trans_begin();
        $this->db->set($data);
        $this->db->insert('frontend_pages');
        $id = $this->db->insert_id();
        $this->db->trans_complete();
        
        //trans_complete

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $b = $this->db->trans_commit();
            return $id;
        }
    }
    
    function delete_pages($id){
        
        $data = array(
            
            'is_deleted' => 1
        );
        
        $this->db->trans_begin();
        $this->db->where('page_id', $id);
        $this->db->set($data);
        $this->db->update('frontend_pages');
        $id = $this->db->insert_id();
        $this->db->trans_complete();
        
        //trans_complete

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $b = $this->db->trans_commit();
            return $id;
        }
    }
    
    function update_pages($id){
        
        $data = array(
            
            'page_name' => $this->input->post('page_name'),
            'page_content' => $this->input->post('page_content')
        );
        
        $this->db->trans_begin();
        $this->db->where('page_id' , $id);
        $this->db->set($data);
        $this->db->update('frontend_pages');
        $id = $this->db->insert_id();
        $this->db->trans_complete();
        
            //trans_complete
        
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $b = $this->db->trans_commit();
            return $id;
        }
    }

}
    
