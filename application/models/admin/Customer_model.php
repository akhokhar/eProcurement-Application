<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Customer_model extends CI_Model {
    
    /*
    |------------------------------------------------
    | start: add_customer function
    |------------------------------------------------
    |
    | This function add  customer
    |
   */

    function add_customer() {
        $customer_order = $this->input->post();
		$date = date("Y-m-d H:i:s");
        $user_exist = $this->check_user_exist($customer_order['email'], $customer_order['contact_no']);
        if ($user_exist) {
            $user_exist = "Exist";
            return $user_exist;
        } else {
            // Salt and hash Password field logic copied from user
            $salt           =   $this->generate_token(10);
            $hash_password  =   $this->generate_hash_token($customer_order['myPassword'], $salt, TRUE);
            
            $data = array(
                'customer_first_name' => $customer_order['first_name'],
                'customer_last_name' => $customer_order['last_name'],
                'customer_email' => $customer_order['email'],
                'customer_contact_no' => $customer_order['contact_no'],
                'customer_password' => $hash_password,
                'customer_salt' => $salt,
                'customer_address' => $customer_order['address'],
                'created_date' => $date
            );

            //trans_begin
            $this->db->trans_begin();
            $this->db->set($data);
            $this->db->insert('customers');
            $customer_id = $this->db->insert_id();
            $this->db->trans_complete();
            //trans_complete
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            //trans_commit
            $b = $this->db->trans_commit();
            return $customer_id;
        }
    }
    /*---- end: add_customer function ----*/
    
    
    
    
    
    
    /*
    |------------------------------------------------
    | start: update_password_customer function
    |------------------------------------------------
    |
    | This function will update Password of Customer
    |
   */
    function update_password_customer($id) {
        $update_password_cutomer = $this->input->post();
        
        $salt           =   $this->generate_token(10);
        $hash_password  =   $this->generate_hash_token($update_password_cutomer['myPassword'], $salt, TRUE);
        
        $data = array(
            'customer_password' => $hash_password,
            'customer_salt' => $salt
                );
        //trans_begin
        $this->db->trans_begin();
        $this->db->where('customer_id', $id);
        $this->db->set($data);
        $this->db->update('customers');
        $this->db->trans_complete();
        //trans_complete
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $b = $this->db->trans_commit();
            return TRUE;
        }
    }
    /*---- end: update_password_customer function ----*/
    
    
    
    
    
    
    /*
    |------------------------------------------------
    | start: generate_token function
    |------------------------------------------------
    |
    | This function Generate Token
    |
   */
    public function generate_token($length = 8) 
	{
		$characters = '23456789BbCcDdFfGgHhJjKkMmNnPpQqRrSsTtVvWwXxYyZz';
		$count = mb_strlen($characters);

		for ($i = 0, $token = ''; $i < $length; $i++) 
		{
			$index = rand(0, $count - 1);
			$token .= mb_substr($characters, $index, 1);
		}
		return $token;
	}
    /*---- end: generate_token function ----*/
        
        
        
     /*
    |------------------------------------------------
    | start: generate_hash_token function
    |------------------------------------------------
    |
    | This function Generate Hash Token
    |
   */
     public function generate_hash_token($token, $database_salt = FALSE, $is_password = FALSE)
	{
	    if (empty($token))
	    {
	    	return FALSE;
	    }
		
		// Get static salt if set via config file.
		$static_salt = 'change-me!';
		
		if ($is_password)
		{
			require_once(APPPATH.'libraries/phpass/PasswordHash.php');				
			$phpass = new PasswordHash(8, FALSE);
			
			return $phpass->HashPassword($database_salt . $token . $static_salt);
		}
		else
		{
			return sha1($database_salt . $token . $static_salt);
		}
	}
        /*---- end: generate_hash_token function ----*/
    
    
    
    
    /*
    |------------------------------------------------
    | start: check_user_exist function
    |------------------------------------------------
    |
    | This function checking existing customer
    |
   */

    function check_user_exist($email = NULL, $contact_no = NULL) {
        $this->db->select('*');
        $this->db->where('customer_email', $email);
        $this->db->or_where('customer_contact_no', $contact_no);
        $result = $this->db->get('customers');
        if ($result->num_rows() > 0) {
            $array = $result->result_array();
            $array = $array[0];
            return $array;
        } else {
            return 0;
        }
    }
    /*---- end: check_user_exist function ----*/

    
    
    
    
    /*
    |------------------------------------------------
    | start: edit_customer function
    |------------------------------------------------
    |
    | This function edit customer
    |
   */
    function edit_customer($data) {
        $customer_id = $data['edit_form_customer_id'];
        $data = array(
            'customer_first_name' => $data['first_name'],
            'customer_last_name' => $data['last_name'],
            'customer_email' => $data['email'],
            'customer_contact_no' => $data['contact_no'],
            'customer_address' => $data['address']
        );
        //trans_begin
        $this->db->trans_begin();
        $this->db->where('customer_id', $customer_id);
        $this->db->set($data);
        $this->db->update('customers');
        $this->db->trans_complete();
        //trans_complete
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $b = $this->db->trans_commit();
            return TRUE;
        }
    }
    /*---- end: edit_customer function ----*/

    
    
    
    
    /*
    |------------------------------------------------
    | start: get_customer function
    |------------------------------------------------
    |
    | This function fetch all customer
    |
   */
    function get_customer($db_where_column, $db_where_value, $db_where_column_or = null, $db_where_value_or = null, $db_limit = null, $db_order = null) {

        $this->db->select('*');

        if ($db_where_column_or) {
            foreach ($db_where_column_or as $key => $column) {
                if (!empty($db_where_value_or[$key])) {
                    $this->db->or_where($column, $db_where_value_or[$key]);
                }
            }
        }

        if ($db_where_column) {
            foreach ($db_where_column as $key => $column) {
                if (!empty($db_where_value[$key])) {
                    $this->db->where($column, $db_where_value[$key]);
                }
            }
        }

        if ($db_limit) {
            $this->db->limit($db_limit['limit'], $db_limit['pageStart']);
        }

        if ($db_order) {
            foreach ($db_order as $get_order) {
                $this->db->order_by($get_order['title'], $get_order['order_by']);
            }
        }

        $this->db->where('customer_deleted', 0);

        $this->db->group_by('customer_id');

        $result = $this->db->get('customers');

        if ($result->num_rows() > 0) {

            $data = array();

            foreach ($result->result_array() as $key => $get_record) {

                $data[$key] = $get_record;
            }

            return $data;
        } else
            return FALSE;
    }
    /*---- end: get_customer function ----*/

    
    
    
    /*
    |------------------------------------------------
    | start: delete_customer function
    |------------------------------------------------
    |
    | This function delete customer
    |
   */

    function delete_customer($order_id) {

        $user_id = $this->flexi_auth->get_user_id();
        $current_time = date();

        $data = array(
            'customer_deleted' => 1,
            'customer_deleted_by' => $user_id,
            'customer_deleted_date' => date("Y-m-d H:i:s")
        );

        $this->db->trans_begin();

        $this->db->where('customer_id', $order_id);
        $this->db->set($data);
        $this->db->update('customers');

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $b = $this->db->trans_commit();
            return TRUE;
        }
    }
    /*---- end: delete_customer function ----*/
    
    
    
    
    
    
    
    

}
