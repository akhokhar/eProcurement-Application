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
    /*---- end: list_donors function ----*/
    
}
    