<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Grn_model extends CI_Model {
    
    /*
    |------------------------------------------------
    | start: add_grn function
    |------------------------------------------------
    |
    | This function add new Goods/Services Receiving
    |
    */
    function add_grn($order_id) {
        
        $grn   = $this->input->post();
        $user_id    = $this->flexi_auth->get_user_id();
		$grnNum = '1-10-17';
        
        $data = array(
				'vendor_id'			  		=> $grn['vendor'],
				'purchase_order_id'			=> $order_id,
				'delivery_challan_no'		=> $grn['challan'],
				'received_qty'				=> $grn['received_qty'],
				'accepted_qty'				=> $grn['accepted_qty'],
				'grn_date'					=> date("Y-m-d H:i:s", strtotime($grn['grnDate'])),
                'grn_num'            	  	=> $grnNum,
				'added_by'					=> $user_id,
				'status'					=> $this->config->item('activeFlag'),
        ); 

		$this->db->trans_begin();
        
        $this->db->set($data);
        $this->db->insert('grn');
        
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
    function get_grn($db_where_column = null, $db_where_value = null, $db_where_column_or = null, $db_where_value_or = null, $db_limit = null, $db_order = null, $db_select_column = null) {
        
        if($db_select_column)
            $this->db->select($db_select_column);
        else
            $this->db->select('grn.grn_id, grn.grn_num, grn.purchase_order_id, grn.received_qty, grn.accepted_qty, grn.grn_date, grn.delivery_challan_no, r.requisition_id, r.requisition_num, rfq.rfq_num, grn.vendor_id, v.vendor_name, r.description');

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
        
        $this->db->where('grn.status', 1);
        $this->db->join('vendor v', 'grn.vendor_id = v.vendor_id', 'LEFT');
        $this->db->join('purchase_order po', 'grn.purchase_order_id = po.po_id', 'LEFT');
        $this->db->join('rfq', 'po.rfq_id = rfq.rfq_id', 'LEFT');
        $this->db->join('requisition r', 'po.requisition_id = r.requisition_id', 'LEFT');
		$result = $this->db->get('grn');
		
        $data = array();
        if($result->num_rows() > 0) {
            $data = $result->result_array();
            return $data;
        }
        else{
            return NULL;
		}
    }
    /*---- end: get_grn function ----*/
	
}