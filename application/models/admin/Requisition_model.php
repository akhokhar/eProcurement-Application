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
    function add_requisition() {
        
        $requisition   = $this->input->post();
        $user_id    = $this->flexi_auth->get_user_id();
        
        $data = array(
                'date_req'            		=> date("Y-m-d H:i:s", strtotime($requisition['requisitionDate'])),
                'date_req_until'            => date("Y-m-d H:i:s", strtotime($requisition['requiredUntilDate'])),
                'project_id'			  	=> $requisition['project'],
                'budget_head_id'          	=> $requisition['budgetHead'],
                'location_id'       		=> $requisition['location'],
                'donor_id'            		=> $requisition['donor'],
                'approved_rejected_by'      => $user_id,
				'date_created'				=> date("Y-m-d H:i:s", time()),
				'status'					=> 1,
        ); 
        
        $this->db->trans_begin();
        
        $this->db->set($data);
        $this->db->insert('requisition');
        
        $requisition_id = $this->db->insert_id();

        if($requisition_id){
            //Requisition Item Work will go here.
        }

        $this->db->trans_complete();
        
        if($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $b = $this->db->trans_commit();
            
            $this->session->set_flashdata('requisition_id', $requisition_id);
            return TRUE;
        }
        
    }
    /*---- end: add_requisition function ----*/
    
    /*
    |------------------------------------------------
    | start: get_requisition function
    |------------------------------------------------
    |
    | This function get all requisitions or
    | requisition get by id and other cloumn
    |
    */
    function get_requisition($db_where_column, $db_where_value, $db_where_column_or = null, $db_where_value_or = null, $db_limit = null, $db_order = null, $db_select_column = null) {
        
        if($db_select_column)
            $this->db->select($db_select_column);
        else
            $this->db->select('*, r.*');

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
        
        $this->db->where('r.status', 1);
        //$this->db->join('product_tag pt', 'pt.pt_type = p.product_tag_image', 'LEFT');
		$result = $this->db->get('requisition r');
        
        if($result->num_rows() > 0) {
            $data = array();
            foreach($result->result_array() as $key => $get_record) {
                $data[$key] = $get_record;
                
                if(isset($get_record['requisition_id'])) {
                    $requisition_id = $get_record['requisition_id'];
                }
            }
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

}