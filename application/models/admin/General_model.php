<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class General_model extends CI_Model {
    
    /*
    |----------------------------------------------------
    | start: get all projects as dropdown array function
    |----------------------------------------------------
    |
    | This function list_projects
    |
    */
    function list_projects() {
        $this->db->select ( 'project_id, project_name' );

        $this->db->from ( 'project' );
		$this->db->where ('status', 1);
        $this->db->order_by("project_name","ASC");

        $query=$this->db->get();
        $return = array();
        $return[0] = "Select Project";
        foreach($query->result_array() as $row)
        {
            $return[$row["project_id"]] = $row["project_name"];
        }
        return $return;
    }
    /*---- end: list_projects function ----*/
	
	
	/*
    |--------------------------------------------------------
    | start: get all budget heads as dropdown array function 
    |--------------------------------------------------------
    |
    | This function budget_head
    |
    */
    function list_budget_head() {
        $this->db->select ( 'budget_head_id, budget_head' );

        $this->db->from ( 'budget_head' );
		$this->db->where ('status', 1);
        $this->db->order_by("budget_head","ASC");

        $query=$this->db->get();
        $return = array();
        $return[0] = "Select Budget Head";
        foreach($query->result_array() as $row)
        {
            $return[$row["budget_head_id"]] = $row["budget_head"];
        }
        return $return;
    }
    /*---- end: list_budget_head function ----*/
	
	
	/*
    |--------------------------------------------------------
    | start: get all locations as dropdown array function 
    |--------------------------------------------------------
    |
    | This function list_locations
    |
    */
    function list_locations() {
        $this->db->select ( 'location_id, location_name' );

        $this->db->from ( 'location' );
		$this->db->where ('status', 1);
        $this->db->order_by("location_name","ASC");

        $query=$this->db->get();
        $return = array();
        $return[0] = "Select Location";
        foreach($query->result_array() as $row)
        {
            $return[$row["location_id"]] = $row["location_name"];
        }
        return $return;
    }
    /*---- end: list_locations function ----*/
	
	
	/*
    |--------------------------------------------------------
    | start: get all donors as dropdown array function 
    |--------------------------------------------------------
    |
    | This function list_donors
    |
    */
    function list_donors() {
        $this->db->select ( 'donor_id, donor_name' );

        $this->db->from ( 'donor' );
		$this->db->where ('status', 1);
        $this->db->order_by("donor_name","ASC");

        $query=$this->db->get();
        $return = array();
        $return[0] = "Select Donor";
        foreach($query->result_array() as $row)
        {
            $return[$row["donor_id"]] = $row["donor_name"];
        }
        return $return;
    }
    /*---- end: list_managers function ----*/
	
	/*
    |--------------------------------------------------------
    | start: get all vendors as dropdown array function 
    |--------------------------------------------------------
    |
    | This function vendors
    |
    */
    function list_vendors($get_all, $where_col = array(), $where_val = array()) {
        $this->db->select ( 'vendor_id, vendor_name, vendor_address, location_id' );

        $this->db->from ( 'vendor' );
		$this->db->where ('status', 1);
		
		if($where_col) {
            foreach ($where_col as $key => $column) {
                if ($where_val[$key]!="") {
                    $this->db->where($column, $where_val[$key]);
                }
            }
        }
		
        $this->db->order_by("vendor_name","ASC");

        $query=$this->db->get();
        $return = array();
        $return[0] = "Select Vendors";
        foreach($query->result_array() as $row)
        {
            $return[$row["vendor_id"]] = ($get_all) ? $row : $row['vendor_name'];
        }
        return $return;
    }
    /*---- end: list_managers function ----*/
	
	/*
    |--------------------------------------------------------
    | start: get all managers as dropdown array function 
    |--------------------------------------------------------
    |
    | This function list_managers
    |
    */
    function list_managers() {
        $this->db->select ( 'ua.uacc_id, up.upro_first_name, up.upro_last_name' );

        $this->db->from ( 'user_accounts ua' );
		$this->db->join('user_profiles up', 'up.upro_uacc_fk = ua.uacc_id', 'left');
		$this->db->join('user_groups ug', 'ug.ugrp_id = ua.uacc_group_fk', 'left');
		$this->db->where ('ug.ugrp_name', 'Manager');
        $this->db->order_by("up.upro_first_name","ASC");

        $query=$this->db->get();
        $return = array();
        $return[0] = "Select Approving Authority";
        foreach($query->result_array() as $row)
        {
            $return[$row["uacc_id"]] = $row["upro_first_name"]." ".$row["upro_last_name"];
        }
        return $return;
    }
    /*---- end: list_managers function ----*/
	
	
    /*
    |--------------------------------------------------------
    | start: get user detail by user Id
    |--------------------------------------------------------
    | This function list_managers
    | @param, $userId
	| return {userId, firstname, lastname, email, username}
	| {groupId, groupName, phone}
    |
    */
    function get_user_detail($userId) {
        $this->db->select ( 'ua.uacc_id, up.upro_first_name, up.upro_last_name, ua.uacc_email, ua.uacc_username, ug.ugrp_id, ug.ugrp_name, up.upro_phone' );

        $this->db->from ( 'user_accounts ua' );
		$this->db->join('user_profiles up', 'up.upro_uacc_fk = ua.uacc_id', 'LEFT');
		$this->db->join('user_groups ug', 'ug.ugrp_id = ua.uacc_group_fk', 'LEFT');
		$this->db->where ('ua.uacc_id', $userId);

        $query=$this->db->get();
        $return = $query->result_array();
        
        return $return[0];
    }
    /*---- end: list_managers function ----*/

	/*start: Count Requisitions*/
	function requisition_count() {
        
    	$this->db->select('r.requisition_id');
        
        $this->db->or_where('r.status', $this->config->item('activeFlag'));
        $this->db->or_where('r.status', $this->config->item('inactiveFlag'));
        $this->db->or_where('r.status', $this->config->item('sentFlag'));
        $this->db->or_where('r.status', $this->config->item('receivedFlag'));
        $this->db->join('project p', 'r.project_id = p.project_id', 'LEFT');
        $this->db->join('location l', 'r.location_id = l.location_id', 'LEFT');
        $this->db->join('donor d', 'r.donor_id = d.donor_id', 'LEFT');
        $this->db->join('budget_head b', 'r.budget_head_id = b.budget_head_id', 'LEFT');
		$this->db->join('user_accounts ua', 'r.approving_authority = ua.uacc_id', 'LEFT');
        $this->db->join('user_profiles up', 'up.upro_uacc_fk = ua.uacc_id', 'left');
		$result = $this->db->get('requisition r');
	
		return $result->num_rows();
	
    }
	/*end: Count Requisitions*/
	
	/*start: Count RFQ*/
	function rfq_count() {
        
    	$this->db->select('r.rfq_id');
        
        $this->db->or_where('r.status', $this->config->item('activeFlag'));
        $this->db->or_where('r.status', $this->config->item('sentFlag'));
        $this->db->or_where('r.status', $this->config->item('receivedFlag'));
        $this->db->or_where('r.status', $this->config->item('addedComparative'));
        $this->db->group_by('r.requisition_id');
		$result = $this->db->get('rfq r');
	
		return $result->num_rows();
	
    }
	/*end: Count RFQ*/
	
	/*start: Count Comparative Quotations*/
	function comparative_q_count() {
        
    	$this->db->select('r.rfq_id');
        
        $this->db->where('r.status', $this->config->item('addedComparative'));
        $this->db->group_by('r.requisition_id');
		$result = $this->db->get('rfq r');
	
		return $result->num_rows();
	
    }
	/*end: Count Comparative Quotations*/
	
	/*start: Count Purchase Orders*/
	function po_count() {
        
    	$this->db->select('po.po_id');
        
        $this->db->or_where('po.status', $this->config->item('activeFlag'));
        $this->db->or_where('po.status', $this->config->item('sentFlag'));
        $this->db->group_by('po.requisition_id');
		$result = $this->db->get('purchase_order po');
	
		return $result->num_rows();
	
    }
	/*end: Count Purchase Orders*/
	
	/*start: Count GRN*/
	function grn_count() {
        
    	$this->db->select('g.grn_id');
        
        $this->db->or_where('g.status', $this->config->item('activeFlag'));
        $this->db->or_where('g.status', $this->config->item('sentFlag'));
        $this->db->group_by('g.purchase_order_id');
		$result = $this->db->get('grn g');
	
		return $result->num_rows();
	
    }
	/*end: Count GRN*/
	
	/*start: Count Payment Requests*/
	function pr_count() {
        
    	$this->db->select('pr.pr_id');
        
        $this->db->where('pr.status', $this->config->item('activeFlag'));
        $this->db->group_by('pr.requisition_id');
		$result = $this->db->get('payment_request pr');
	
		return $result->num_rows();
	
    }
	/*end: Count Payment Requests*/
	
	
	/*
    |--------------------------------------------------------
    | start: get all categories as dropdown array function 
    |--------------------------------------------------------
    |
    | This function list_categories
    |
    */
    function list_categories($where_col = array(), $where_val = array()) {
        $this->db->select ( 'cat_id, category' );

        $this->db->from ( 'vendor_categories' );
		$this->db->where ('category_status', 1);
		
		if($where_col) {
            foreach ($where_col as $key => $column) {
                if ($where_val[$key]!="") {
                    $this->db->where($column, $where_val[$key]);
                }
            }
        }
		
        $this->db->order_by("category","ASC");

        $query=$this->db->get();
        $return = array();
        $return[0] = "Select Category";
        foreach($query->result_array() as $row)
        {
            $return[$row["cat_id"]] = $row['category'];
        }
        return $return;
    }
    /*---- end: list_managers function ----*/
}
    