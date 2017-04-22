<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Requisition_model extends CI_Model {
    
    /*
    |------------------------------------------------
    | start: add_requisition function
    |------------------------------------------------
    |
    | This function add new requisition
    |
    */
    function add_requisition($requisition) {
        
        //$requisition   = $this->input->post();
        $user_id    = $this->flexi_auth->get_user_id();
        $data = array(
                'requisition_num'			=> $requisition['req_num'],
                'description'            	=> $requisition['purchasing_detail'],
                'requisition_description'	=> $requisition['requisition_description'],
                'date_req'            	  	=> date("Y-m-d H:i:s", strtotime($requisition['requisitionDate'])),
                'date_req_until'            => date("Y-m-d H:i:s", strtotime($requisition['requiredUntilDate'])),
                'cat_id'				  	=> $requisition['category'],
                'project_id'			  	=> $requisition['project'],
                'budget_head_id'          	=> $requisition['budgetHead'],
                'location_id'				=> $requisition['location'],
                'donor_id'            	  	=> $requisition['donor'],
                'approving_authority'       => $requisition['approvingAuthority'],
                'created_by'       			=> $user_id,
				'is_approved'			   	=> 0,
				'is_tendered'			   	=> 0,
				'date_created'			  	=> date("Y-m-d H:i:s", time()),
				'status'					=> 1,
        ); 
        
        $this->db->trans_begin();
        
        $this->db->set($data);
        $this->db->insert('requisition');
        
        $requisition_id = $this->db->insert_id();

        $this->db->trans_complete();
        
        if($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $b = $this->db->trans_commit();
            
            //$this->session->set_flashdata('requisition_id', $requisition_id);
            return $requisition_id;
        }
        
    }
    /*---- end: add_requisition function ----*/
	
	/*
    |------------------------------------------------
    | start: add_requisition_item function
    |------------------------------------------------
    |
    | This function add item of the requisition
	| @param: requisition_id
    |
    */
    function add_requisition_item($requisition_id, $itemName, $itemDesc, $costCenter, $unit, $quantity, $unitPrice) {
        
        $requisition   = $this->input->post();
        $user_id    = $this->flexi_auth->get_user_id();
        
        $data = array(
                'item_name'				=> $itemName,
                'item_desc'            	=> $itemDesc,
                'cost_center'			=> $costCenter,
                'unit'          		=> $unit,
                'quantity'       		=> $quantity,
                'unit_price'            => $unitPrice,
                'requisition_id'      	=> $requisition_id,
				'date_created'			=> date("Y-m-d H:i:s", time()),
				'status'				=> 1,
        ); 
        
        $this->db->trans_begin();
        
        $this->db->set($data);
        $this->db->insert('requisition_item');
        
        $requisition_item_id = $this->db->insert_id();

        $this->db->trans_complete();
        
        if($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $b = $this->db->trans_commit();
            
            //$this->session->set_flashdata('requisition_item_id', $requisition_item_id);
            return $requisition_item_id;
        }
        
    }
    /*---- end: add_requisition_item function ----*/
    
    /*
    |------------------------------------------------
    | start: get_requisition function
    |------------------------------------------------
    |
    | This function get all requisitions or
    | requisition get by id and other cloumn
    |
    */
    function get_requisition($db_where_column = null, $db_where_value = null, $db_where_column_or = null, $db_where_value_or = null, $db_limit = null, $db_order = null, $db_select_column = null) {
        
        if($db_select_column)
            $this->db->select($db_select_column);
        else
            //$this->db->select('*, r.*');
            $this->db->select('r.requisition_id, r.requisition_num, r.description, r.date_req, r.date_req_until, p.project_name, b.budget_head, l.location_name, d.donor_name, r.approving_authority, CONCAT(up.upro_first_name, " ", up.upro_last_name) AS approving_authority_name, r.approved_by, r.created_by, r.is_approved, r.status, c.category');

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
        
        //$this->db->where('r.status', 1);
        $this->db->join('vendor_categories c', 'r.cat_id = c.cat_id', 'LEFT');
        $this->db->join('project p', 'r.project_id = p.project_id', 'LEFT');
        $this->db->join('location l', 'r.location_id = l.location_id', 'LEFT');
        $this->db->join('donor d', 'r.donor_id = d.donor_id', 'LEFT');
        $this->db->join('budget_head b', 'r.budget_head_id = b.budget_head_id', 'LEFT');
		$this->db->join('user_accounts ua', 'r.approving_authority = ua.uacc_id', 'LEFT');
        $this->db->join('user_profiles up', 'up.upro_uacc_fk = ua.uacc_id', 'left');
		$result = $this->db->get('requisition r');
        
        if($result->num_rows() > 0) {
            $data = array();
            foreach($result->result_array() as $key => $get_record) {
                $data[$key] = $get_record;
                $item_data = array();
                if(isset($get_record['requisition_id'])) {
                    $requisition_id = $get_record['requisition_id'];
					$item_data = $this->get_requisition_items($requisition_id);
					if ($item_data) {
						$data[$key]['items'] = $item_data;
					}
                }
            }
            return $data;
        }
        else{
            return FALSE;
		}
    }
    /*---- end: get_requisition function ----*/
    
	/*---- start: get requisition items ----*/
    function get_requisition_items($requisition_id = null, $db_where_column = null, $db_where_value = null, $db_where_column_or = null, $db_where_value_or = null, $db_limit = null, $db_order = null, $db_select_column = null) {
        
        if($db_select_column)
            $this->db->select($db_select_column);
        else
            //$this->db->select('*, r.*');
            $this->db->select('ri.*');

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
        
		if ($requisition_id) {
        	$this->db->where('ri.requisition_id', $requisition_id);
		}
		$result = $this->db->get('requisition_item ri');
        
        if($result->num_rows() > 0) {
            $data = array();
            foreach($result->result_array() as $key => $get_record) {
                $data[$key] = $get_record;
                
                if(isset($get_record['requisition_item_id'])) {
                    $requisition_item_id = $get_record['requisition_item_id'];
                }
            }
            return $data;
        }
        else{
            return FALSE;
		}
    }
	/*---- end: get requisition items ----*/
    
	function change_requisition_status($requisition_id, $status) {
		$this->db->trans_begin();
        
        $this->db->where('requisition_id', $requisition_id);
        $this->db->set(array('status' => $status));
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
    
	/*---- start: get_requisition num details----*/
    function get_requisition_num_detail($date_year = null, $date_month = null) {
        
        $this->db->select('MAX(r.requisition_num) as requisition_num, MAX(r.requisition_id)+1 AS reqId');

		$current_date = 'DATE()';
		$date_year = !!$date_year ? $date_year : $current_date;
		$date_month = !!$date_month ? $date_month : $current_date;
        $this->db->where('YEAR(r.date_req)', $date_year);
        $this->db->where('MONTH(r.date_req)', $date_month);
		$this->db->group_by('YEAR(r.date_req)', 'MONTH(r.date_req)');
		$result = $this->db->get('requisition r');
		
		if($result->num_rows() > 0) {
            $data = array();
            if($get_record = $result->result_array()) {
                $data = $get_record[0]['requisition_num']."/".$get_record[0]['reqId'];
            }
            return $data;
        }
        else{
            return FALSE;
		}
    }
    /*---- end: get_requisition num details----*/
	
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
	
	// Get coming requisitionId;
	function get_coming_requisition_id() {
        
        $this->db->select('MAX(r.requisition_id)+1 as reqId');
		$result = $this->db->get('requisition r');
		
		if($result->num_rows() > 0) {
            $data = array();
            if($get_record = $result->result_array()) {
                $data = $get_record[0]['reqId'];
            }
            return $data;
        }
        else{
            return FALSE;
		}
    }
	
	/*
    |------------------------------------------------
    | start: add_requisition_files function
    |------------------------------------------------
    |
    | This function add supporting files of the requisition
	| @param: requisition_id, $fileName
    |
    */
    function add_requisition_files($requisition_id, $fileName) {
        
		//$user_id    = $this->flexi_auth->get_user_id();
        
        $data = array(
                'requisition_id'		=> $requisition_id,
                'requisition_file'      => $fileName,
                'file_status'			=> 1
        ); 
        
        $this->db->trans_begin();
        
        $this->db->set($data);
        $this->db->insert('requisition_files');
        
        $requisition_file_id = $this->db->insert_id();

        $this->db->trans_complete();
        
        if($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $b = $this->db->trans_commit();
            
            return $requisition_file_id;
        }
        
    }
    /*---- end: add_requisition_item function ----*/

}