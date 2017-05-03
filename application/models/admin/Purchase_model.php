<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Purchase_model extends CI_Model {
    
    /*
    |------------------------------------------------
    | start: add_purchase_order function
    |------------------------------------------------
    |
    | This function add new Purchase Order
    |
    */
    function add_purchase_order($rfq_id) {
        
        $order   = $this->input->post();
        $user_id    = $this->flexi_auth->get_user_id();
		$orderNum = '1-10-17';
        
        $data = array(
				'po_num'			  		=> $orderNum,
				'po_date'					=> date("Y-m-d H:i:s", strtotime($order['poDate'])),
				'delivery_date'				=> date("Y-m-d H:i:s", strtotime($order['delivery_date'])),
                'rfq_id'            	  	=> $rfq_id,
                'vendor_id'            		=> $order['vendor'],
                'requisition_id'       		=> $order['requisition_id'],
				'delivery_address'			=> $order['delivery_address'],
				'added_by'					=> $user_id,
				'status'					=> $this->config->item('activeFlag'),
        ); 
		
		$this->db->trans_begin();
        
        $this->db->set($data);
        $this->db->insert('purchase_order');
        
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
    | start: get_orders function
    |------------------------------------------------
    |
    | This function get all orders or
    | get get_orders by id and other cloumn
    |
    */
    function get_orders($db_where_column = null, $db_where_value = null, $db_where_column_or = null, $db_where_value_or = null, $db_limit = null, $db_order = null, $db_select_column = null) {
        
        if($db_select_column)
            $this->db->select($db_select_column);
        else

            $this->db->select('po.po_id, po.po_num, po.po_date, po.delivery_date, po.delivery_address, r.requisition_id, r.requisition_num, rfq.rfq_num, v.vendor_id, v.vendor_name, r.description, po.status');

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
        $this->db->join('vendor v', 'po.vendor_id = v.vendor_id', 'INNER');
        $this->db->join('requisition r', 'po.requisition_id = r.requisition_id', 'INNER');
        $this->db->join('rfq', 'po.rfq_id = rfq.rfq_id', 'LEFT');
		$result = $this->db->get('purchase_order po');
		
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
	
	
	function change_po_status($rfq_id, $status) {
		$this->db->trans_begin();
        
        $this->db->where('po_id', $rfq_id);
        $this->db->set(array('status' => $status));
        $this->db->update('purchase_order');
        
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