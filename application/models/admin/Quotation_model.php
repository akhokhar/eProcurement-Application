<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Quotation_model extends CI_Model {
    
    /*
    |------------------------------------------------
    | start: add_rfq function
    |------------------------------------------------
    |
    | This function add new rfq
    |
    */
    function add_rfq($requisition_id, $rfqNum) {
        
        $rfq   = $this->input->post();
        $user_id    = $this->flexi_auth->get_user_id();
        
        $data = array(
				'rfq_num'			  		=> $rfqNum,
				'requisition_id'			=> $requisition_id,
                'rfq_date'            	  	=> date("Y-m-d H:i:s", strtotime($rfq['rfqDate'])),
                'due_date'            		=> date("Y-m-d H:i:s", strtotime($rfq['rfqDueDate'])),
                'created_by'       			=> $user_id,
				'status'					=> $this->config->item('activeFlag'),
        ); 
        
        $this->db->trans_begin();
        
        $this->db->set($data);
        $this->db->insert('rfq');
        
        $rfq_id = $this->db->insert_id();
		$this->add_rfq_vendor($rfq_id, $rfq['vendors']);
		
        $this->db->trans_complete();
        
        if($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $b = $this->db->trans_commit();
            
            return $rfq_id;
        }
        
    }
    /*---- end: add_requisition function ----*/
	
	/*
    |------------------------------------------------
    | start: add_requisition_item function
    |------------------------------------------------
    |
    | This function add rfq vendor
	| @param: requisition_id, vendor_id, unit_rate [optional]
    |
    */
    function add_rfq_vendor($rfq_id, $vendor_id, $unit_rate = false) {
        
        $user_id    = $this->flexi_auth->get_user_id();
        
        $data = array(
                'rfq_id'				=> $rfq_id,
                'vendor_id'            	=> $vendor_id,
                'unit_rate'				=> (isset($unit_rate))?$unit_rate:NULL,
                'status'          		=> $this->config->item('activeFlag')
        ); 
        
        $this->db->trans_begin();
        
        $this->db->set($data);
        $this->db->insert('rfq_vendor');
        
        //$rfq_vendor_id = $this->db->insert_id();

        $this->db->trans_complete();
        
        if($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $b = $this->db->trans_commit();
            
            return TRUE;
        }
        
    }
    /*---- end: add_rfq_vendor function ----*/
    
    /*
    |------------------------------------------------
    | start: get_requisition function
    |------------------------------------------------
    |
    | This function get all requisitions or
    | requisition get by id and other cloumn
    |
    */
    function get_rfq($db_where_column = null, $db_where_value = null, $db_where_column_or = null, $db_where_value_or = null, $db_limit = null, $db_order = null, $db_select_column = null) {
        
        if($db_select_column)
            $this->db->select($db_select_column);
        else
            $this->db->select('r.rfq_id, r.rfq_num, r.requisition_id, r.rfq_date, r.due_date, r.created_by, r.status, rv.vendor_id, rv.unit_rate, v.vendor_name');

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
					if($column == "rfq_id"){ $column = "r.rfq_id"; }
                    $this->db->where($column, $db_where_value[$key]);
                }
            }
        }
        
        if ($db_limit) {
            $this->db->limit($db_limit['limit'], $db_limit['pageStart']);
        }
        
        if($db_order) {
            foreach($db_order as $get_order) {
                $this->db->order_by($get_order['title'], $get_order['order_by']);
            } 
        }
        
        //$this->db->where('r.status', 1);
        $this->db->join('rfq_vendor rv', 'r.rfq_id = rv.rfq_id', 'LEFT');
        $this->db->join('vendor v', 'rv.vendor_id = v.vendor_id', 'LEFT');
		$result = $this->db->get('rfq r');
		
        $data = array();
        if($result->num_rows() > 0) {
            $data = $result->result_array();
            return $data;
        }
        else{
            return FALSE;
		}
    }
    /*---- end: get_requisition function ----*/
    
    
    function delete_requisition($requisition_id) {
        
        $user_id    = $this->flexi_auth->get_user_id();
        
        $data = array(
                'product_delete'        => 1,
                'product_deleted_by'    => $user_id
        );
        
        $this->db->trans_begin();
        
        $this->db->where('requisition_id', $requisition_id);
        $this->db->set($data);
        $this->db->update('requisition');
        
        $this->db->trans_complete();
        
        if($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $b = $this->db->trans_commit();
            return TRUE;
        }
        
    }
    
    
    function edit_requisition($requisition_id) {
        
        $requisition   = $this->input->post();
        $user_id    = $this->flexi_auth->get_user_id();
        //$inserted_cat_id = $this->get_prod_category_id($requisition_id);
        
        // calculate discount value
        if(isset($product['product_disc_type']) && $product['product_disc_type'] == '2') {
            $discount_percent_value = ($product['product_discount']/100)*$product['product_price'];
            $discount_value = $product['product_price']-$discount_percent_value;
        }
        else {
            $discount_value = $product['product_price']-$product['product_discount'];
        }
        
        //echo $discount_value; die();
        
        $data = array(
                'date_req'            		=> date("Y-m-d H:i:s", strtotime($requisition['requisitionDate'])),
                'date_req_until'            => date("Y-m-d H:i:s", strtotime($requisition['requiredUntilDate'])),
                'project_id'			  	=> $requisition['project'],
                'budget_head_id'          	=> $requisition['budgetHead'],
                'location_id'       		=> $requisition['location'],
                'donor_id'            		=> $requisition['donor'],
                'approved_rejected_by'      => $user_id,
				'date_modified'				=> date("Y-m-d H:i:s", time()),
				'status'					=> 1,
        );  
        
        $this->db->trans_begin();
        
        $this->db->where('requisition_id', $requisition_id);
        $this->db->set($data);
        $this->db->update('requisition');
        
        //$product_id = $this->db->insert_id();

        if($requisition_id){
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
    
    
    /*
    |------------------------------------------------
    | start: get_status function
    |------------------------------------------------
    |
    | This function get all products or
    | product get by id and other cloumn
    |
    */
    function get_enum_data($table, $field) {
        
        $type = $this->db->query( "SHOW COLUMNS FROM {$table} WHERE Field = '{$field}'" )->row( 0 )->Type;
        preg_match("/^enum\(\'(.*)\'\)$/", $type, $matches);
        $enum = explode("','", $matches[1]);
        return $enum;
        
    }
    /*---- end: get_status function ----*/
	
	
	function approve_and_email_requisition($requisition_id, $approve) {
		
        $user_id    = $this->flexi_auth->get_user_id();
        
        
        $data = array(
                'is_approved'            	=> $approve,
				'approved_by'				=> $user_id,
        );  
        
        $this->db->trans_begin();
        
        $this->db->where('requisition_id', $requisition_id);
        $this->db->set($data);
        $this->db->update('requisition');
        
        //$product_id = $this->db->insert_id();

        if($requisition_id){
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