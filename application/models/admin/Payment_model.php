<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment_model extends CI_Model {
    
    /*
    |------------------------------------------------
    | start: add_purchase_order function
    |------------------------------------------------
    |
    | This function add new Purchase Order
    |
    */
    function add_payment_request($grn_id) {
        
        $payment_request   = $this->input->post();
        $user_id    = $this->flexi_auth->get_user_id();
        
        $data = array(
				'requisition_id'			=> $payment_request['requisition_id'],
				'grn_id'					=> $grn_id,
				'pr_date'				   => date("Y-m-d H:i:s", strtotime($payment_request['prDate'])),
                'payment_mode'              => $payment_request['paymentMode'],
                'payment_purpose'           => $payment_request['paymentPurpose'],
				'added_by'				  => $user_id,
				'added_on'				  => date("Y-m-d H:i:s"),
				'status'					=> $this->config->item('activeFlag'),
        ); 
		
		$this->db->trans_begin();
        
        $this->db->set($data);
        $this->db->insert('payment_request');
        
        $order_id = $this->db->insert_id();
		
		$this->db->trans_complete();
        
        if($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $b = $this->db->trans_commit();
			$this->change_grn_status($grn_id, $this->config->item('sentFlag'));
            return $order_id;
        }
        
    }
    /*---- end: add_purchase_order function ----*/
	
	
	/*
    |------------------------------------------------
    | start: get_orders function
    |------------------------------------------------
    |
    | This function get all orders or
    | get get_orders by id and other cloumn
    |
    */
    function get_prs($db_where_column = null, $db_where_value = null, $db_where_column_or = null, $db_where_value_or = null, $db_limit = null, $db_order = null, $db_select_column = null) {
        
        if($db_select_column)
            $this->db->select($db_select_column);
        else

            $this->db->select('pr.*, r.requisition_num, r.description');

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
        
        if($db_order) {
            foreach($db_order as $get_order) {
                $this->db->order_by($get_order['title'], $get_order['order_by']);
            } 
        }
        
        //$this->db->where('po.status', 1);
        $this->db->join('requisition r', 'pr.requisition_id = r.requisition_id', 'INNER');
		$result = $this->db->get('payment_request pr');
		
        $data = array();
        if($result->num_rows() > 0) {
            $data = $result->result_array();
            return $data;
        }
        else{
            return NULL;
		}
    }
    /*---- end: get_orders function ----*/
	
	
	function change_grn_status($grn_id, $status) {
		$this->db->trans_begin();
        
        $this->db->where('grn_id', $grn_id);
        $this->db->set(array('status' => $status));
        $this->db->update('grn');
        
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