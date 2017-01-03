<?php

error_reporting(E_ALL | E_STRICT);

require('UploadHandler.php');

class CustomUploadHandler extends UploadHandler {

    protected function handle_file_upload($uploaded_file, $name, $size, $type, $error, $index = null, $content_range = null) {
        $file = parent::handle_file_upload(
                        $uploaded_file, $name, $size, $type, $error, $index, $content_range
        );
        
        if (empty($file->error)) {
            $product_id = $this->options['product_id'];
            $type_model = $this->options['type_model'];
            
            $file_id = $this->CI->uploadhandler_model->insert_file($file, $product_id, $type_model);
            $file->id = $file_id;
        }
        
        return $file;
    }

    protected function set_additional_file_properties($file) {
        parent::set_additional_file_properties($file);
        
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $type_model = $this->options['type_model'];
            
            $db_where_column = array('img_name', 'type_model');
            $db_where_value = array($file->name, $type_model);
            $db_select_value = array('*');
            
            //echo $file->name;

            $files_data = $this->CI->uploadhandler_model->get_file($db_where_column, $db_where_value, $db_select_value);

            //echo '<pre>'; print_r($files_data);
            
            if($files_data) {
                foreach($files_data as $value) {
                    $file->id = $value->img_id;
                    $file->type = $value->img_type;
                    $file->embed_url = $value->img_url;
                    $file->product_id = $value->img_product_id;
                }
            }
        }
    }
    
    protected function get_file_objects($iteration_method = 'get_file_object') {
        
        //echo $this->options['product_id']; die();
        
        parent::get_file_objects($iteration_method = 'get_file_object');
        
        $upload_dir = $this->get_upload_path();
        
        if (!is_dir($upload_dir)) {
            return array();
        }
        
        if(empty($this->options['product_id'])) {
            if($this->options['action'] == 'raw') {
                $db_where_column = array('img_product_id');
                $db_where_value = array($this->options['product_id']);
                
            } else if ($this->options['type_model'] == 'slider') {
                $type_model = $this->options['type_model'];
                $db_where_column = array('img_product_id', 'type_model');
                $db_where_value = array($this->options['product_id'], $type_model);
                
            } else {
                $db_where_column = array('img_product_id !=', 'img_product_id =');
                $db_where_value = array($this->options['product_id'], $this->options['product_id']);
            }
            
        }
        else {
            $type_model = $this->options['type_model'];
            $db_where_column = array('img_product_id', 'type_model');
            $db_where_value = array($this->options['product_id'], $type_model);
        }
            
        $db_select_value = array('img_name');
            
        $files = $this->CI->uploadhandler_model->get_file($db_where_column, $db_where_value, $db_select_value);
        
        if($files) {
            foreach($files as $value) {
                $files_name[] = $value->img_name;
            }
        }
        else {
            $files_name = array();
        }
        return array_values(array_filter( array_map( array($this, $iteration_method), $files_name ) ) );
    }

    public function delete($print_response = true) {
        $response = parent::delete(false);
        
        foreach ($response as $name => $deleted) {
            if ($deleted) {
                $this->CI->uploadhandler_model->delete_file($name);
            } else {
                $this->CI->uploadhandler_model->delete_file($name); // for deleting the Youtube Videos
            }
        }

        return $this->generate_response($response, $print_response);
    }

}