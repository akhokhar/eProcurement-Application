<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vendor_model extends CI_Model {
    
    /*
    |------------------------------------------------
    | start: add_grn function
    |------------------------------------------------
    |
    | This function add new Goods/Services Receiving
    |
    */
    function add_vendor() {
        
        $vendor   = $this->input->post();
        $user_id    = $this->flexi_auth->get_user_id();
		
		$data = array(
				'vendor_name'			  	=> $vendor['vendor_name'],
				'vendor_address'			=> $vendor['vendor_address'],
				'location_id'				=> $vendor['location'],
				'vendor_date'				=> date("Y-m-d H:i:s", time()),
				'status'					=> $this->config->item('activeFlag'),
        ); 
		
		$this->db->trans_begin();
        
        $this->db->set($data);
        $this->db->insert('vendor');
        
        $order_id = $this->db->insert_id();
		
		$this->db->trans_complete();
        
        if($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $b = $this->db->trans_commit();
            
            return $order_id;
        }
        
    }
    /*---- end: add_purchase_order function ----*/
	
	
	/*
    |------------------------------------------------
    | start: get_grn function
    |------------------------------------------------
    |
    | This function get all orders or
    | get get_grn by id and other cloumn
    |
    */
    function get_vendor($db_where_column = null, $db_where_value = null, $db_where_column_or = null, $db_where_value_or = null, $db_limit = null, $db_order = null, $db_select_column = null) {
        
        if($db_select_column)
            $this->db->select($db_select_column);
        else
            $this->db->select('v.vendor_id, v.vendor_name, v.vendor_address, v.location_id, v.vendor_date, l.location_name');

        if($db_where_column_or) {
            foreach($db_where_column_or as $key => $column) {
                if (!empty($db_where_value_or[$key])) {
                    $this->db->or_where($column, $db_where_value_or[$key]);
                }
            }
        }
        
        if($db_where_column) {
            foreach ($db_where_column as $key => $column) {
                if ($db_where_value[$key]!="") {
					$this->db->where($column, $db_where_value[$key]);
                }
            }
        }
        
        if ($db_limit) {
            $this->db->limit($db_limit['limit'], $db_limit['pageStart']);
        }
        
		$this->db->where('v.status', 1);
		$this->db->order_by("vendor_name", "ASC");
        $this->db->join('location l', 'v.location_id = l.location_id', 'LEFT');
        $result = $this->db->get('vendor v');
		
        $data = array();
        if($result->num_rows() > 0) {
            $data = $result->result_array();
            return $data;
        }
        else{
            return NULL;
		}
    }
    /*---- end: get_vendor function ----*/
	
	
	function delete_vendor($vendor_id) {
		
        $data = array( 'status'  => 0);  
        
        $this->db->trans_begin();
        
        $this->db->where('vendor_id', $vendor_id);
        $this->db->set($data);
        $this->db->update('vendor');
        
        if($this->db->affected_rows() != 1){
            //Requisition Item Work will go here.
        }
        
        $this->db->trans_complete();
        
        if($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            return TRUE;
        }
        
    }
	
}