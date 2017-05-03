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
				'receiving_location'		=> $grn['receiving_location'],
				'grn_date'					=> date("Y-m-d H:i:s", strtotime($grn['grnDate'])),
                'grn_num'            	  	=> $grnNum,
				'added_by'					=> $user_id,
				'status'					=> $this->config->item('activeFlag'),
        ); 

		$this->db->trans_begin();
        
        $this->db->set($data);
        $this->db->insert('grn');
        
        $grn_id = $this->db->insert_id();
		
		if ($grn_id) {
			$this->add_grn_items_detail($grn_id);
		}
		
		$this->db->trans_complete();
        
        if($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->change_po_status($order_id, $this->config->item('sentFlag'));
            $b = $this->db->trans_commit();
            
            return $grn_id;
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
            $this->db->select('grn.grn_id, grn.grn_num, grn.purchase_order_id, grn.grn_date, grn.delivery_challan_no, grn.receiving_location, r.requisition_id, r.requisition_num, rfq.rfq_num, grn.vendor_id, v.vendor_name, r.description, grn.status');

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
	
	
	/*
    |------------------------------------------------
    | start: add_grn items function
    |------------------------------------------------
    |
    | This function add new Goods/Services Receiving
    |
    */
    function add_grn_items_detail($grn_id) {
		
        $requisition_item_ids   = $this->input->post('requisition_item');
		$qty_received   = $this->input->post('qty_received');
		$qty_accepted   = $this->input->post('qty_accepted');
		$remarks   		= $this->input->post('remarks');
        $user_id    	= $this->flexi_auth->get_user_id();
        
		$this->db->trans_begin();
		
		foreach ($requisition_item_ids as $requisition_item_id) {
			$data = array(
					'grn_id'			  		=> $grn_id,
					'requisition_item_id'	   => $requisition_item_id,
					'qty_received'			  => $qty_received[$requisition_item_id],
					'qty_accepted'			  => $qty_accepted[$requisition_item_id],
					'remarks'			  	   => $remarks[$requisition_item_id],
					'status'					=> $this->config->item('activeFlag'),
			); 
			$this->db->set($data);
			$this->db->insert('grn_item_details');
		}
		
		$this->db->trans_complete();
        
        if($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $b = $this->db->trans_commit();
            
            return TRUE;
        }
        
    }
    /*---- end: add_grn items function ----*/
	
	/*
    |------------------------------------------------
    | start: get_grn items function
    |------------------------------------------------
    |
    | This function get all orders or
    | get get_grn by id and other cloumn
    |
    */
    function get_grn_items($db_where_column = null, $db_where_value = null, $db_where_column_or = null, $db_where_value_or = null, $db_limit = null, $db_order = null, $db_select_column = null) {
        
        if($db_select_column)
            $this->db->select($db_select_column);
        else
            $this->db->select('gid.*');

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
        
        $this->db->where('gid.status', 1);
		$result = $this->db->get('grn_item_details gid');
		
        $data = array();
        if($result->num_rows() > 0) {
            $data = $result->result_array();
            return $data;
        }
        else{
            return NULL;
		}
    }
    /*---- end: get_grn items function ----*/
	
	
	function change_po_status($order_id, $status) {
		$this->db->trans_begin();
        
        $this->db->where('po_id', $order_id);
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