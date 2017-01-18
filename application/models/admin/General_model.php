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
}
    