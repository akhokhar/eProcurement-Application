<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Navigation extends CI_Model {
    
    /********************************
     * start: GET NAVIGATION
    ********************************/
    function get_navigation() {
        
        $this->db->select('*');
        $this->db->order_by("mu_order_by", 'asc');
        $this->db->where('mu_delete', 0);
        $query = $this->db->get('menu');
        
        if($query->num_rows() > 0) {
            
            $result = $query->result_array();
            
            $refs = array();
            $list = array();
            
            foreach($result as $data) {
                $thisref = &$refs[ $data['mu_id'] ];

                $thisref['mu_id']           = $data['mu_id'];
                $thisref['mu_parent_id']    = $data['mu_parent_id'];
                $thisref['mu_order_by']     = $data['mu_order_by'];
                $thisref['mu_title']        = $data['mu_title'];
                $thisref['mu_class']        = $data['mu_class'];
                $thisref['mu_url']          = $data['mu_url'];
                $thisref['mu_icon_class']   = $data['mu_icon_class'];
                $thisref['mu_active']       = $data['mu_active'];
                $thisref['mu_created_date'] = $data['mu_created_date'];

                if ($data['mu_parent_id'] == 0) {
                    $list[ $data['mu_id'] ] = &$thisref;
                } else {
                    $refs[ $data['mu_parent_id'] ]['mu_children'][ $data['mu_id'] ] = &$thisref;
                }
            }
            
            return $list;
            
        }
        
    }
    /*------------- end: GET NAVIGATION -------------*/
    
}
?>