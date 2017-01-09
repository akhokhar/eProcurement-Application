
<!-- start: MAIN CONTAINER -->
<div class="main-container">
    <div class="navbar-content">
        <!-- start: SIDEBAR -->
        <?php $this->load->view('admin/includes/sidebar'); ?>
        <!-- end: SIDEBAR -->
    </div>
    <!-- start: PAGE -->
    <div class="main-content">
        <!-- start: PANEL CONFIGURATION MODAL FORM -->
        <div class="modal fade" id="panel-config" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            &times;
                        </button>
                        <h4 class="modal-title">Panel Configuration</h4>
                    </div>
                    <div class="modal-body">
                        Here will be a configuration form
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            Close
                        </button>
                        <button type="button" class="btn btn-primary">
                            Save changes
                        </button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
        <!-- end: SPANEL CONFIGURATION MODAL FORM -->
        <div class="container">
            <!-- start: PAGE HEADER -->
            <div class="row">
                <div class="col-sm-12">
                    <!-- start: PAGE TITLE & BREADCRUMB -->
                    <ol class="breadcrumb">
                        <?php echo $this->breadcrumbs->show(); ?>
                        <!--
                        <li class="search-box">
                            <form class="sidebar-search">
                                <div class="form-group">
                                    <input type="text" placeholder="Start Searching...">
                                    <button class="submit">
                                        <i class="clip-search-3"></i>
                                    </button>
                                </div>
                            </form>
                        </li>
                        -->
                    </ol>
                    <!-- start: Success and error message -->
                    <?php if (!empty($message)) { ?>
                        <div id="message">
                            <?php echo $message; ?>
                        </div>
                    <?php } ?>
                    <!-- end: Success and error message -->
                    <div class="page-header row">
                        <h1 class="col-sm-6">Add Procurement <small></small></h1>
                        <div class="col-md-2 pull-right">
                            <button class="btn btn-yellow btn-block" id="submit_btn" type="button">
                                Submit <i class="fa fa-arrow-circle-right"></i>
                            </button>
                        </div>
                    </div>
                    <!-- end: PAGE TITLE & BREADCRUMB -->
                </div>
            </div>
            <!-- end: PAGE HEADER -->
            <?php
            $attributes = array('class' => '', 'role' => 'form', 'id' => 'procurement_form');
            echo form_open_multipart('', $attributes);
            ?>
                <!-- start: PAGE CONTENT -->
                <div class="row">
                    <div class="col-sm-12">
                        <!-- start: PANLEL TABS -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-reorder"></i>
                                Procurement
                            </div>
                            <div class="panel-body">
                                <div class="tabbable panel-tabs">
                                    <ul id="myTab" class="nav nav-tabs tab-blue">
                                        <li class="active">
                                            <a data-toggle="tab" href="#panel_tab_general">
                                                General
                                            </a>
                                        </li>
                                        <li>
                                            <a data-toggle="tab" href="#panel_tab_category">
                                                Category
                                            </a>
                                        </li>
                                        <li>
                                            <a data-toggle="tab" href="#panel_tab_data">
                                                Data
                                            </a>
                                        </li>

                                        <li>
                                            <a data-toggle="tab" href="#panel_tab_images">
                                                Media
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div id="panel_tab_general" class="tab-pane active">
                                            <div class="panel-body">
                                                <div role="form" class="form-horizontal">
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label" for="form-field-1">
                                                            Product Title <span class="symbol required"></span>
                                                        </label>
                                                        <div class="col-sm-9">
                                                            <?php
                                                            $input_data = array(
                                                                    'type'          => 'text',
                                                                    'name'          => 'product_title',
                                                                    'id'            => 'product_title',
                                                                    'value'         => set_value('product_title'),
                                                                    'class'         => 'form-control',
                                                                    'placeholder'   => 'Insert Product Name'
                                                            );

                                                            echo form_input($input_data);
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label" for="form-field-1">
                                                            Meta Description
                                                        </label>
                                                        <div class="col-sm-9">
                                                            <?php
                                                            $input_data = array(
                                                                    'type'          => 'text',
                                                                    'name'          => 'product_meta_description',
                                                                    'id'            => 'product_meta_description',
                                                                    'value'         => set_value('product_meta_description'),
                                                                    'class'         => 'form-control',
                                                                    'placeholder'   => 'Insert Meta Description'
                                                            );

                                                            echo form_input($input_data);
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label" for="form-field-1">
                                                            Meta Key Words
                                                        </label>
                                                        <div class="col-sm-4">
                                                            <?php
                                                            $input_data = array(
                                                                    'type'          => 'text',
                                                                    'name'          => 'product_meta_key',
                                                                    'id'            => 'product_meta_key',
                                                                    'value'         => set_value('product_meta_key'),
                                                                    'class'         => 'form-control',
                                                                    'placeholder'   => 'Insert Meta Key Word'
                                                            );

                                                            echo form_input($input_data);
                                                            ?>
                                                        </div>
                                                        <label class="col-sm-2 control-label" for="form-field-1">
                                                            Product Tag
                                                        </label>
                                                        <div class="col-sm-3">
                                                            <?php
                                                            $input_data = array(
                                                                    'type'          => 'text',
                                                                    'name'          => 'product_product_tag',
                                                                    'id'            => 'product_product_tag',
                                                                    'value'         => set_value('product_product_tag'),
                                                                    'class'         => 'form-control',
                                                                    'placeholder'   => 'Insert Product Tag'
                                                            );

                                                            echo form_input($input_data);
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label" for="form-field-1">
                                                            Product policy
                                                        </label>
                                                        <div class="col-sm-9">
                                                            <textarea name="product_policy" id="product_policy" class="summernote form-control" rows="5"><?php echo set_value('product_policy');  ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label" for="form-field-1">
                                                            Description
                                                        </label>
                                                        <div class="col-sm-9">
                                                            <textarea name="product_description" id="product_description" class="summernote form-control" rows="5"><?php echo set_value('product_description');  ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label" for="form-field-1">
                                                            Packing Include
                                                        </label>
                                                        <div class="col-sm-9">
                                                            <textarea name="pack_include" id="pack_include" class="summernote form-control" rows="5"><?php echo set_value('pack_include');  ?></textarea>
                                                        </div>
                                                    </div>
                                                    <hr />
                                                    <div class="row">
                                                        <div class="col-md-2 pull-right">
                                                            <a href="#panel_tab_category" data-toggle="tab" class="btn btn-teal ladda-button next_tab">
                                                                Next <i class="fa fa-arrow-circle-right"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="panel_tab_category" class="tab-pane">
                                            <div class="panel-body">
                                                <div role="form" class="form-horizontal">
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label" for="form-field-1">
                                                            Parent Category <span class="symbol required"></span>
                                                        </label>
                                                        <div class="col-sm-9">
                                                            <select id="form-field-select-1" name="product_cat_id" class="product_cat_id form-control">
                                                                <option value="">--Select Category--</option>
                                                                <?php
                                                                if($parent_categories) {
                                                                    foreach($parent_categories as $get_record) {
                                                                        echo '<option value="' . $get_record['cat_id'] . '">' . $get_record['cat_title'] . '</option>';
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label" for="form-field-1">
                                                            Category
                                                        </label>
                                                        <div class="col-sm-9" id="multi-selecter-box">
                                                            <select name="category_id[]" id="form-field-select-4" multiple="multiple" class="category_id form-control">
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div id="custom_fields">

                                                    </div>
                                                    <hr />
                                                    <div class="row">
                                                        <div class="col-md-2 pull-left">
                                                            <a href="#panel_tab_general" data-toggle="tab" class="btn btn-light-grey next_tab">
                                                                <i class="fa fa-arrow-circle-left"></i> Back
                                                            </a>
                                                        </div>
                                                        <div class="col-md-2 pull-right">
                                                            <a href="#panel_tab_data" data-toggle="tab" class="btn btn-teal ladda-button next_tab">
                                                                Next <i class="fa fa-arrow-circle-right"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="panel_tab_data" class="tab-pane">
                                            <div class="panel-body">
                                                <div role="form" class="form-horizontal">
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label" for="form-field-1">
                                                            Model <span class="symbol required"></span>
                                                        </label>
                                                        <div class="col-sm-9">
                                                            <?php
                                                            $input_data = array(
                                                                    'type'          => 'text',
                                                                    'name'          => 'product_model',
                                                                    'id'            => 'product_model',
                                                                    'value'         => set_value('product_model'),
                                                                    'class'         => 'form-control',
                                                                    'placeholder'   => 'Insert Model'
                                                            );

                                                            echo form_input($input_data);
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label" for="form-field-1">
                                                            Original Price <span class="symbol required"></span>
                                                        </label>
                                                        <div class="col-sm-9">
                                                            <?php
                                                            $input_data = array(
                                                                    'type'          => 'text',
                                                                    'name'          => 'product_price',
                                                                    'id'            => 'product_price',
                                                                    'value'         => set_value('product_price'),
                                                                    'class'         => 'price_value form-control',
                                                                    'placeholder'   => 'Insert Original Price'
                                                            );

                                                            echo form_input($input_data);
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">
                                                            Discount In
                                                        </label>
                                                        <div class="col-sm-9 discount_div">
                                                            <label class="radio-inline">
                                                                <input type="radio" value="1" name="product_disc_type"  id="discount_in_price" class="discount_type">
                                                                price
                                                            </label>
                                                            <label class="radio-inline">
                                                                <input type="radio" value="2" name="product_disc_type" id="discount_in_percent" class="discount_type">
                                                                Percent
                                                            </label>
                                                            <label class="radio-inline">
                                                                <input type="radio" value="0" name="product_disc_type" id="no_discount" class="discount_type">
                                                                No Discount
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label" for="form-field-1">
                                                            Discount
                                                        </label>
                                                        <div class="col-sm-5">
                                                            <?php
                                                            $input_data = array(
                                                                    'type'          => 'text',
                                                                    'name'          => 'product_discount',
                                                                    'id'            => 'product_discount',
                                                                    'value'         => set_value('product_discount'),
                                                                    'class'         => 'price_value form-control',
                                                                    'placeholder'   => 'Insert Discount Price or Percent',
                                                                    'readonly'      => 'readonly'
                                                            );

                                                            echo form_input($input_data);
                                                            ?>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <?php
                                                            $input_data = array(
                                                                    'type'      => 'text',
                                                                    'class'     => 'form-control',
                                                                    'disabled'  => 'disabled',
                                                                    'id'        => 'discount_value'
                                                            );

                                                            echo form_input($input_data);
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <?php /* ?>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label" for="form-field-1">
                                                            Discount in Percent
                                                        </label>
                                                        <div class="col-sm-9">
                                                            <?php
                                                            $input_data = array(
                                                                    'type'          => 'text',
                                                                    'name'          => 'product_descount_persent',
                                                                    'id'            => 'product_descount_persent',
                                                                    'value'         => set_value('product_descount_persent'),
                                                                    'class'         => 'form-control discount_percent',
                                                                    'placeholder'   => 'Insert Discount in Percent',
                                                            );

                                                            echo form_input($input_data);
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <?php */ ?>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label" for="form-field-1">
                                                            Quantity
                                                        </label>
                                                        <div class="col-sm-9">
                                                            <?php
                                                            $input_data = array(
                                                                    'type'          => 'text',
                                                                    'name'          => 'product_quantity',
                                                                    'id'            => 'product_quantity',
                                                                    'value'         => set_value('product_quantity'),
                                                                    'class'         => 'form-control',
                                                                    'placeholder'   => 'Insert Quantity'
                                                            );

                                                            echo form_input($input_data);
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label" for="form-field-1">
                                                            SKU
                                                        </label>
                                                        <div class="col-sm-9">
                                                            <?php
                                                            $input_data = array(
                                                                    'type'          => 'text',
                                                                    'name'          => 'product_sku',
                                                                    'id'            => 'product_sku',
                                                                    'value'         => set_value('product_sku'),
                                                                    'class'         => 'form-control',
                                                                    'placeholder'   => 'Insert SKU'
                                                            );

                                                            echo form_input($input_data);
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label" for="form-field-1">
                                                            UPC
                                                        </label>
                                                        <div class="col-sm-9">
                                                            <?php
                                                            $input_data = array(
                                                                    'type'          => 'text',
                                                                    'name'          => 'product_upc',
                                                                    'id'            => 'product_upc',
                                                                    'value'         => set_value('product_upc'),
                                                                    'class'         => 'form-control',
                                                                    'placeholder'   => 'Insert UPC'
                                                            );

                                                            echo form_input($input_data);
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label" for="form-field-1">
                                                            SEO
                                                        </label>
                                                        <div class="col-sm-9">
                                                            <?php
                                                            $input_data = array(
                                                                    'type'          => 'text',
                                                                    'name'          => 'product_seo',
                                                                    'id'            => 'product_seo',
                                                                    'value'         => set_value('product_seo'),
                                                                    'class'         => 'form-control',
                                                                    'placeholder'   => 'Insert SEO'
                                                            );

                                                            echo form_input($input_data);
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label" for="form-field-1">
                                                            Material
                                                        </label>
                                                        <div class="col-sm-9">
                                                            <?php
                                                            $input_data = array(
                                                                    'type'          => 'text',
                                                                    'name'          => 'product_material',
                                                                    'id'            => 'product_material',
                                                                    'value'         => set_value('product_material'),
                                                                    'class'         => 'form-control',
                                                                    'placeholder'   => 'Insert Material'
                                                            );

                                                            echo form_input($input_data);
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label" for="form-field-1">
                                                            Weight
                                                        </label>
                                                        <div class="col-sm-9">
                                                            <?php
                                                            $input_data = array(
                                                                    'type'          => 'text',
                                                                    'name'          => 'product_weight',
                                                                    'id'            => 'product_weight',
                                                                    'value'         => set_value('product_weight'),
                                                                    'class'         => 'form-control',
                                                                    'placeholder'   => 'Insert Weight'
                                                            );

                                                            echo form_input($input_data);
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label" for="form-field-1">
                                                            Select Product Tag Image
                                                        </label>
                                                        <div class="col-sm-3">
                                                            <select name="product_tag_image" id="product_tag_image" class="form-control">
                                                                <option value="">--Select Image Tag--</option>
                                                                <!--<option value="new">New</option>
                                                                <option value="sale">Sale</option>-->
                                                                <?php foreach($get_product_tag as $tag_type){ ?>
                                                                <option value="<?php echo $tag_type["ptt_id"]; ?>"><?php echo $tag_type["ptt_name"]; ?></option>
                                                                <?php } ?> 
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-1">
                                                            <?php foreach($get_product_tag as $tag_type){ ?>
                                                            <img id="product_tag_image_<?php echo $tag_type["pt_type"]; ?>" class="productTagImage" src="<?php echo $tag_path.$tag_type["pt_img"]; ?>" alt=""/>
                                                            <?php } ?>
                                                            <!--<img id="product_tag_image_sale" class="productTagImage" src="<?php //echo $includes_dir; ?>admin/images/sale.png" alt=""/>-->
                                                        </div>
                                                        
                                                         <div class="col-sm-5">
                                                            <label class="radio-inline">
                                                                <input type="checkbox" value="1" name="product_featured">
                                                                &nbsp;&nbsp;&nbsp;
                                                                Featured Product
                                                            </label>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label" for="form-field-1">
                                                            Status <span class="symbol required"></span>
                                                        </label>
                                                        <div class="col-sm-9">
                                                            <select name="product_status" id="product_status" class="form-control">
                                                                <option value="">--Select Status--</option>
                                                                <?php
                                                                if($product_ststus) {
                                                                    foreach($product_ststus as $get_data) {
                                                                        echo '<option value="' . $get_data . '">' . $get_data . '</option>';
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label" for="form-field-1">
                                                            Warehouse Status <span class="symbol required"></span>
                                                        </label>
                                                        <div class="col-sm-9">
                                                            <select name="product_house_status" id="product_house_status" class="form-control">
                                                                <option value="">--Select Warehouse Status--</option>
                                                                <?php
                                                                if($warehouse_status) {
                                                                    foreach($warehouse_status as $get_data) {
                                                                        echo '<option value="' . $get_data . '">' . $get_data . '</option>';
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <hr />
                                                    <div class="row">
                                                        <div class="col-md-2 pull-left">
                                                            <a href="#panel_tab_category" data-toggle="tab" class="btn btn-light-grey next_tab">
                                                                <i class="fa fa-arrow-circle-left"></i> Back
                                                            </a>
                                                        </div>
                                                        <div class="col-md-2 pull-right">
                                                            <a href="#panel_tab_images" data-toggle="tab" class="btn btn-teal ladda-button next_tab">
                                                                Next <i class="fa fa-arrow-circle-right"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div id="panel_tab_images" class="tab-pane">
                                            <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <!-- start: INLINE TABS PANEL -->
                                                            <div class="panel panel-default">
                                                                <div class="panel-body">
                                                                    <div class="row">
                                                                        <div class="col-sm-12">
                                                                            <div class="tabbable">
                                                                                <ul id="myTab4" class="upload_tab nav nav-tabs tab-padding tab-space-3 tab-blue">
                                                                                    <li class="active">
                                                                                        <a style="color: #999999" href="#panel_tab3_images" data-toggle="tab">
                                                                                            Images
                                                                                        </a>
                                                                                    </li>
                                                                                    <li>
                                                                                        <a style="color: #999999"  href="#panel_tab3_thumbnail" data-toggle="tab">
                                                                                            Thumbnail
                                                                                        </a>
                                                                                    </li>
                                                                                    <li>
                                                                                        <a style="color: #999999"  href="#panel_tab3_videos" data-toggle="tab">
                                                                                            Videos
                                                                                        </a>
                                                                                    </li>
                                                                                </ul>
                                                                                <div class="tab-content">
                                                                                    <div class="tab-pane in active" id="panel_tab3_images">
                                                                                        <div id="fileupload_images" class="fileuploader">
                                                                                            <!--<form id="fileupload" action="<?php //echo $base_url; ?>admin/fileupload" method="POST" enctype="multipart/form-data">-->
                                                                                            <!-- Redirect browsers with JavaScript disabled to the origin page -->
                                                                                            <noscript><input type="hidden" name="redirect" value="https://blueimp.github.io/jQuery-File-Upload/"></noscript>
                                                                                            <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                                                                                            <div class="row fileupload-buttonbar">
                                                                                                <div class="col-lg-9">
                                                                                                    <!-- The fileinput-button span is used to style the file input field as button -->
                                                                                                    <span class="btn btn-success fileinput-button">
                                                                                                        <i class="glyphicon glyphicon-plus"></i>
                                                                                                        <span>Add files...</span>
                                                                                                        <input type="file" name="files[]" id="file_images" multiple>
                                                                                                    </span>
                                                                                                    <button type="button" id="submit_btn_upload" class="btn btn-primary start">
                                                                                                        <i class="glyphicon glyphicon-upload"></i>
                                                                                                        <span>Start upload</span>
                                                                                                    </button>
                                                                                                    <button type="reset" class="btn btn-warning cancel">
                                                                                                        <i class="glyphicon glyphicon-ban-circle"></i>
                                                                                                        <span>Cancel upload</span>
                                                                                                    </button>
                                                                                                    <button type="button" class="btn btn-danger delete">
                                                                                                        <i class="glyphicon glyphicon-trash"></i>
                                                                                                        <span>Delete</span>
                                                                                                    </button>

                                                                                                    <input type="checkbox" class="toggle">
                                                                                                    <!-- The global file processing state -->
                                                                                                    <span class="fileupload-process"></span>
                                                                                                </div>
                                                                                                <!-- The global progress state -->
                                                                                                <div class="col-lg-5 fileupload-progress fade">
                                                                                                    <!-- The global progress bar -->
                                                                                                    <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                                                                                                        <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                                                                                                    </div>
                                                                                                    <!-- The extended global progress state -->
                                                                                                    <div class="progress-extended">&nbsp;</div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <!-- The table listing the files available for upload/download -->
                                                                                        
                                                                                            <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="tab-pane" id="panel_tab3_thumbnail">
                                                                                        <div id="fileupload_thumbnail" class="fileuploader">
                                                                                            <!--<form id="fileupload" action="<?php //echo $base_url; ?>admin/fileupload" method="POST" enctype="multipart/form-data">-->
                                                                                            <!-- Redirect browsers with JavaScript disabled to the origin page -->
                                                                                            <noscript><input type="hidden" name="redirect" value="https://blueimp.github.io/jQuery-File-Upload/"></noscript>
                                                                                            <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                                                                                            <div class="row fileupload-buttonbar">
                                                                                                <div class="col-lg-9">
                                                                                                    <!-- The fileinput-button span is used to style the file input field as button -->
                                                                                                    <span class="btn btn-success fileinput-button">
                                                                                                        <i class="glyphicon glyphicon-plus"></i>
                                                                                                        <span>Add files...</span>
                                                                                                        <input type="file" name="files[]" id="file_thumbnail" multiple>
                                                                                                    </span>
                                                                                                    <button type="button" id="submit_btn_upload" class="btn btn-primary start">
                                                                                                        <i class="glyphicon glyphicon-upload"></i>
                                                                                                        <span>Start upload</span>
                                                                                                    </button>
                                                                                                    <button type="reset" class="btn btn-warning cancel">
                                                                                                        <i class="glyphicon glyphicon-ban-circle"></i>
                                                                                                        <span>Cancel upload</span>
                                                                                                    </button>
                                                                                                    <button type="button" class="btn btn-danger delete">
                                                                                                        <i class="glyphicon glyphicon-trash"></i>
                                                                                                        <span>Delete</span>
                                                                                                    </button>

                                                                                                    <input type="checkbox" class="toggle">
                                                                                                    <!-- The global file processing state -->
                                                                                                    <span class="fileupload-process"></span>
                                                                                                </div>
                                                                                                <!-- The global progress state -->
                                                                                                <div class="col-lg-5 fileupload-progress fade">
                                                                                                    <!-- The global progress bar -->
                                                                                                    <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                                                                                                        <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                                                                                                    </div>
                                                                                                    <!-- The extended global progress state -->
                                                                                                    <div class="progress-extended">&nbsp;</div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <!-- The table listing the files available for upload/download -->
                                                                                        
                                                                                            <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="tab-pane" id="panel_tab3_videos">
                                                                                        <div id="fileupload_videos" class="fileuploader">
                                                                                            <!--<form id="fileupload" action="<?php //echo $base_url; ?>admin/fileupload" method="POST" enctype="multipart/form-data">-->
                                                                                            <!-- Redirect browsers with JavaScript disabled to the origin page -->
                                                                                            <noscript><input type="hidden" name="redirect" value="https://blueimp.github.io/jQuery-File-Upload/"></noscript>
                                                                                            <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                                                                                            <div class="row fileupload-buttonbar">
                                                                                                <div class="col-lg-9">
                                                                                                    <!-- The fileinput-button span is used to style the file input field as button -->
                                                                                                    <span class="btn btn-success fileinput-button">
                                                                                                        <i class="glyphicon glyphicon-plus"></i>
                                                                                                        <span>Add files...</span>
                                                                                                        <input type="file" name="files[]" id="file_videos" multiple>
                                                                                                    </span>
                                                                                                    <button type="button" class="btn btn-success fileinput-button open_popup">
                                                                                                        <i class="glyphicon glyphicon-plus"></i>
                                                                                                        <span>Add Video URLs...</span>
                                                                                                    </button>
                                                                                                    <button type="button" id="submit_btn_upload" class="btn btn-primary start">
                                                                                                        <i class="glyphicon glyphicon-upload"></i>
                                                                                                        <span>Start upload</span>
                                                                                                    </button>
                                                                                                    <button type="reset" class="btn btn-warning cancel">
                                                                                                        <i class="glyphicon glyphicon-ban-circle"></i>
                                                                                                        <span>Cancel upload</span>
                                                                                                    </button>
                                                                                                    <button type="button" class="btn btn-danger delete">
                                                                                                        <i class="glyphicon glyphicon-trash"></i>
                                                                                                        <span>Delete</span>
                                                                                                    </button>

                                                                                                    <input type="checkbox" class="toggle">
                                                                                                    <!-- The global file processing state -->
                                                                                                    <span class="fileupload-process"></span>
                                                                                                </div>
                                                                                                <div id="event-management" class="modal fade" tabindex="-1" data-width="760" style="display: none;">
                                                                                                    <div class="modal-dialog">
                                                                                                        <div class="modal-content">
                                                                                                            <div class="modal-header">
                                                                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                                                                                                    &times;
                                                                                                                </button>
                                                                                                                <h4 class="modal-title">Paste Youtube URLs</h4>
                                                                                                            </div>
                                                                                                            <div class="modal-body">
                                                                                                                <div class="panel-body">
                                                                                                                <div class="form-group col-md-12">
                                                                                                                    <label for="form-field-1" class="col-sm-4 control-label">
                                                                                                                        Video Name
                                                                                                                    </label>
                                                                                                                    <div class="col-sm-8">
                                                                                                                        <input type="text" placeholder="" class="form-control" id="videoName" value="" />
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                 <div class="form-group col-md-12">
                                                                                                                    <label for="form-field-1" class="col-sm-4 control-label">
                                                                                                                        URL
                                                                                                                    </label>
                                                                                                                    <div class="col-sm-8">
                                                                                                                        <input type="text" placeholder="" class="form-control" id="videoUrl" value="" />
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <div class="modal-footer">
                                                                                                                <button type="button" data-dismiss="modal" class="btn btn-light-grey">
                                                                                                                    Close
                                                                                                                </button>
                                                                                                                <button type="button" class="btn btn-danger remove-event no-display">
                                                                                                                    <i class='fa fa-trash-o'></i> Delete Event
                                                                                                                </button>
                                                                                                                <button id="add_data" type='button' class='btn btn-success save-event'>
                                                                                                                    <i class='fa fa-check'></i> Add
                                                                                                                </button>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <!-- The global progress state -->
                                                                                                <div class="col-lg-5 fileupload-progress fade">
                                                                                                    <!-- The global progress bar -->
                                                                                                    <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                                                                                                        <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                                                                                                    </div>
                                                                                                    <!-- The extended global progress state -->
                                                                                                    <div class="progress-extended">&nbsp;</div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <!-- The table listing the files available for upload/download -->
                                                                                        
                                                                                            <table role="presentation" class="table table-striped"><tbody class="files video_url"></tbody></table>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- end: INLINE TABS PANEL -->
                                                        </div>
                                                    </div>
                                                    <hr />
                                                    <div class="row">
                                                        <div class="col-md-2 pull-left">
                                                            <a href="#panel_tab_data" data-toggle="tab" class="btn btn-light-grey next_tab">
                                                                <i class="fa fa-arrow-circle-left"></i> Back
                                                            </a>
                                                        </div>
                                                    </div>
                                                <!--</form>-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end: PANLEL TABS -->
                    </div>
                </div>                
            <?php echo form_close(); ?>
        </div>
    </div>
    <!-- end: PAGE -->
</div>
<!-- end: MAIN CONTAINER -->

<!-- statr: INCLUSE FOOTER -->
<?php $this->load->view('admin/includes/footer'); ?>
<!-- end: INCLUSE FOOTER -->

<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
<link href="<?php echo $includes_dir; ?>admin/plugins/lou-multi-select/css/multi-select.css" media="screen" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?php echo $includes_dir; ?>admin/plugins/summernote/build/summernote.css">
<!-- Generic page styles -->
<link rel="stylesheet" href="<?php echo $includes_dir; ?>admin/plugins/jQuery-File-Upload/css/style.css">
<!-- blueimp Gallery styles -->
<link rel="stylesheet" href="<?php echo $includes_dir; ?>admin/css/blueimp-gallery.min.css">
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<link rel="stylesheet" href="<?php echo $includes_dir; ?>admin/plugins/jQuery-File-Upload/css/jquery.fileupload.css">
<link rel="stylesheet" href="<?php echo $includes_dir; ?>admin/plugins/jQuery-File-Upload/css/jquery.fileupload-ui.css">
<!-- CSS adjustments for browsers with JavaScript disabled -->
<noscript><link rel="stylesheet" href="<?php echo $includes_dir; ?>admin/plugins/jQuery-File-Upload/css/jquery.fileupload-noscript.css"></noscript>
<noscript><link rel="stylesheet" href="<?php echo $includes_dir; ?>admin/plugins/jQuery-File-Upload/css/jquery.fileupload-ui-noscript.css"></noscript>

<link rel="stylesheet" href="<?php echo $includes_dir; ?>admin/plugins/jQuery-Tags-Input/jquery.tagsinput.css">
<!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->

<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script src="<?php echo $includes_dir; ?>admin/plugins/lou-multi-select/js/jquery.multi-select.js" type="text/javascript"></script>
<script src="<?php echo $includes_dir; ?>admin/plugins/summernote/build/summernote.min.js"></script>
<script src="<?php echo $includes_dir; ?>admin/js/form-elements.js"></script>

<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
    {% console.log(o.options.fileInput[0].id); for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
    <td>
    <span class="preview"></span>
    </td>
    <td>
    <p class="name">{%=file.name%}</p>
    <strong class="error text-danger"></strong>
    </td>
    <td>
                
    {% if(o.options.fileInput[0].id == 'file_images') { %}
        Main Image&nbsp;&nbsp;
        <input type="radio" {% var fileType = file.name.split('.').pop(), allowdtypes = 'jpeg,jpg,png,gif'; if (allowdtypes.indexOf(fileType.toLowerCase()) < 0) { %} disabled="disabled"  {% } %} value="" name="main_image" class="main_image">
    {% } %}
    
    {% if(o.options.fileInput[0].id == 'file_thumbnail') { %}
        Main Thumbnail&nbsp;&nbsp;
        <input type="radio" {% var fileType = file.name.split('.').pop(), allowdtypes = 'jpeg,jpg,png,gif'; if (allowdtypes.indexOf(fileType.toLowerCase()) < 0) { %} disabled="disabled"  {% } %} value="" name="main_thumbnail" class="main_thumbnail">
    {% } %}
    
    
    </td>
    <td>
    <p class="size">Processing...</p>
    <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
    </td>
    <td>
    {% if (!i && !o.options.autoUpload) { %}
    <button class="btn btn-primary start" disabled>
    <i class="glyphicon glyphicon-upload"></i>
    <span>Start</span>
    </button>
    {% } %}
    {% if (!i) { %}
    <button class="btn btn-warning cancel">
    <i class="glyphicon glyphicon-ban-circle"></i>
    <span>Cancel</span>
    </button>
    {% } %}
    </td>
    </tr>
    {% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
    {% console.log(o); for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
    <td>
    <span class="preview">
    {% if (file.thumbnailUrl) { %}
    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img width="150" height="150" src="{%=file.thumbnailUrl%}"></a>
    {% } else { %}
    <video src="{%=file.url%}" width="150" height="150" controls></video>
    {% } %}
    </span>
    <input type="hidden" value="{%=file.id%}" name="images_id[]">
    </td>
    <td>
    <p class="name">
    {% if (file.url) { %}
    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
    {% } else { %}
    <span>{%=file.name%}</span>
    {% } %}
    </p>
    {% if (file.error) { %}
    <div><span class="label label-danger">Error</span> {%=file.error%}</div>
    {% } %}
    </td>
    <td>
    
    {% if(o.options.fileInput[0].id == 'file_images') { %}
        Main Image&nbsp;&nbsp;
        <input type="radio" {% var fileType = file.name.split('.').pop(), allowdtypes = 'jpeg,jpg,png,gif'; if (allowdtypes.indexOf(fileType.toLowerCase()) < 0) { %} disabled="disabled"  {% } %} value="{%=file.id%}" name="main_image" class="main_image">
    {% } %}
    
    {% if(o.options.fileInput[0].id == 'file_thumbnail') { %}
        Main Thumbnail&nbsp;&nbsp;
        <input type="radio" {% var fileType = file.name.split('.').pop(), allowdtypes = 'jpeg,jpg,png,gif'; if (allowdtypes.indexOf(fileType.toLowerCase()) < 0) { %} disabled="disabled"  {% } %} value="{%=file.id%}" name="main_thumbnail" class="main_thumbnail">
    {% } %}
    
    </td>
    <td>
    <span class="size">{%=o.formatFileSize(file.size)%}</span>
    </td>
    <td>
    {% if (file.deleteUrl) { %}
    <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
    <i class="glyphicon glyphicon-trash"></i>
    <span>Delete</span>
    </button>
    <input type="checkbox" name="delete" value="1" class="toggle">
    {% } else { %}
    <button class="btn btn-warning cancel">
    <i class="glyphicon glyphicon-ban-circle"></i>
    <span>Cancel</span>
    </button>
    {% } %}
    </td>
    </tr>
    {% } %}
</script>
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="<?php echo $includes_dir; ?>admin/plugins/jQuery-File-Upload/js/vendor/jquery.ui.widget.js"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="<?php echo $includes_dir; ?>admin/plugins/blueimp/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="<?php echo $includes_dir; ?>admin/plugins/blueimp/load-image.all.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="<?php echo $includes_dir; ?>admin/plugins/blueimp/canvas-to-blob.min.js"></script>

<!-- blueimp Gallery script -->
<script src="<?php echo $includes_dir; ?>admin/plugins/blueimp/jquery.blueimp-gallery.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="<?php echo $includes_dir; ?>admin/plugins/jQuery-File-Upload/js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="<?php echo $includes_dir; ?>admin/plugins/jQuery-File-Upload/js/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="<?php echo $includes_dir; ?>admin/plugins/jQuery-File-Upload/js/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="<?php echo $includes_dir; ?>admin/plugins/jQuery-File-Upload/js/jquery.fileupload-image.js"></script>
<!-- The File Upload audio preview plugin -->
<script src="<?php echo $includes_dir; ?>admin/plugins/jQuery-File-Upload/js/jquery.fileupload-audio.js"></script>
<!-- The File Upload video preview plugin -->
<script src="<?php echo $includes_dir; ?>admin/plugins/jQuery-File-Upload/js/jquery.fileupload-video.js"></script>
<!-- The File Upload validation plugin -->
<script src="<?php echo $includes_dir; ?>admin/plugins/jQuery-File-Upload/js/jquery.fileupload-validate.js"></script>
<!-- The File Upload user interface plugin -->
<script src="<?php echo $includes_dir; ?>admin/plugins/jQuery-File-Upload/js/jquery.fileupload-ui.js"></script>
<!-- The main application script -->
<script src="<?php echo $includes_dir; ?>admin/plugins/jQuery-File-Upload/js/main.js"></script>
<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
<!--[if (gte IE 8)&(lt IE 10)]>
<script src="js/cors/jquery.xdr-transport.js"></script>
<![endif]-->
<script src="<?php echo $includes_dir; ?>admin/plugins/jquery-validation/dist/jquery.validate.min.js"></script>

<script src="<?php echo $includes_dir; ?>admin/plugins/jQuery-Tags-Input/jquery.tagsinput.js"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->

<script>
    $('#fileupload_images').fileupload({
        url: '<?php echo base_url() ?>admin/product/file_upload/add/image'
    }).on('fileuploadsubmit', function (e, data) {
        data.formData = data.context.find(':input').serializeArray();
    });
    
    $('#fileupload_thumbnail').fileupload({
        url: '<?php echo base_url() ?>admin/product/file_upload/add/thumbnail'
    }).on('fileuploadsubmit', function (e, data) {
        data.formData = data.context.find(':input').serializeArray();
    });
    
    $('#fileupload_videos').fileupload({
        url: '<?php echo base_url() ?>admin/product/file_upload/add/video'
    }).on('fileuploadsubmit', function (e, data) {
        data.formData = data.context.find(':input').serializeArray();
    });
</script>

<script>    
    $('#product_meta_description').tagsInput({
        'width':'auto',
        'height':'65px',
        'defaultText':'add a meta description',
    });
    
    $('#product_meta_key').tagsInput({
        'width':'auto',
        'height':'65px',
        'defaultText':'add a meta key words',
    });
    
    $('#product_product_tag').tagsInput({
        'width':'auto',
        'height':'65px',
        'defaultText':'add a product tag',
    });
    
    /************************************************/
    
    $('#product_tag_image').change(function() {
        var value = $(this).val();
        $('.productTagImage').css('display', 'none');
        
        if(value == '') {
            return false;
        }
        
        $('#product_tag_image_'+value).css('display', 'block');
    })
    
    // ==============================
    // atart: validation
    // ==============================
    var FormValidator = function () {
        var productForm = function () {
            var form1 = $('#product_form');
            var errorHandler1 = $('.errorHandler', form1);
            var successHandler1 = $('.successHandler', form1);
            $('#product_form').validate({
                errorElement: "span", // contain the error msg in a span tag
                errorClass: 'help-block',
                errorPlacement: function (error, element) {
                    if ( element.is(":radio") ||  element.is(":checkbox"))
                    {
                        error.appendTo( element.parents('.container_radio') );
                    }
                    else{
                        error.insertAfter(element);
                    }

                        // for other inputs, just perform default behavior
                },
                ignore: ".ignore",
                rules: {
                    product_title: {
                        minlength: 2,
                        required: true
                    },
                    product_cat_id: {
                        required: true
                    },
                    product_model: {
                        required: true
                    },
                    product_price: {
                        required: true
                    },
                    product_status: {
                        required: true
                    },
                    product_house_status: {
                        required: true
                    }
                },
                messages: {
                    product_title: "Please specify product title",
                    product_cat_id: "Please select category",
                    product_model: "Please specify product model",
                    product_price: "Please specify product price",
                    product_status: "Please select product status",
                    product_house_status: "Please select warehouse status",
                },
                invalidHandler: function (event, validator) { //display error alert on form submit
                    successHandler1.hide();
                    errorHandler1.show();
                },
                highlight: function (element) {
                    $(element).closest('.help-block').removeClass('valid');
                    // display OK icon
                    $(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
                    // add the Bootstrap error class to the control group
                    
                    var tab_pane_id = $(element).closest('.form-group').parents('.tab-pane').attr('id');
                    $('a[href=#'+tab_pane_id+']').parent('li').addClass('has-error-tab');                    
                },
                unhighlight: function (element) { // revert the change done by hightlight
                    $(element).closest('.form-group').removeClass('has-error');
                    // set error class to the control group
                    
                    var tab_pane = $(element).closest('.form-group').parents('.tab-pane');
                    
                    if(tab_pane.find('.has-error').length == 0) {
                        var tab_pane_id = tab_pane.attr('id');
                        $('a[href=#'+tab_pane_id+']').parent().removeClass('has-error-tab');
                    }
                },
                success: function (label, element) {
                    label.addClass('help-block valid');
                    // mark the current input as valid and display OK icon
                    $(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
                },
                submitHandler: function (form) {
                    successHandler1.show();
                    errorHandler1.hide();
                    // submit form
                    //$('#form').submit();
                    HTMLFormElement.prototype.submit.call($('#product_form')[0]);
                }
            });
        };

        return {
            //main function to initiate pages
            init: function () {
                productForm();
            }
        };
    }();
    /* ========== end: validation ========== */
    
    jQuery(document).ready(function () {
        
        $(".discount_div input:radio").click(function(){		
	        		
            var val= $("input[name=product_disc_type]:checked").val();		

            if(val==1){		
                $('#product_discount').prop('readonly',false);		
                $('#product_discount').val('');		
                $('#discount_value').val('');		
            }		
            if(val==2){		
                $('#product_discount').prop('readonly',false);		
                $('#product_discount').val('');		
                $('#discount_value').val('');		
            }		
            if(val==0){		
                $('#product_discount').prop('readonly',true);		
                $('#product_discount').val('0');		
                $('#discount_value').val('0');		
            }		
        });
        
        $('.next_tab').click(function() {
            var href = $(this).attr('href'); //alert(href);
            
            $('#myTab').children('li').removeClass('active');
            
            $('a[href='+href+']').parent('li').addClass('active');
            
            //alert($('a[href='+href+']').html());
            
            //$('#myTab').children('a[href='+href+']').addClass('active');
        });

        Main.init();
        FormElements.init();
        FormValidator.init();

        $(".product_cat_id").change(function () {
         
            var category_id = $(this).val();
            
            if(category_id == '') {
                $("#custom_fields").html('');
            }
            
            $.ajax({
                url: '<?php echo base_url(); ?>admin/product/get_category_by_parent',
                type: 'POST',
                dataType: "JSON",
                data: {category_id: category_id},
                success: function(response) {
                    
                    var multi_select = $('#multi-selecter-box');
                    
                    multi_select.empty();
                    
                    multi_select.append('<select name="category_id[]" id="form-field-select-4" multiple="multiple" class="category_id form-control"></select>');
                    
                    var select = $('.category_id');
         
                    if(response.length != 0) {
                        $.each(response, function (i, fb) {
                            if(fb.cat_id != category_id) {
                                console.log(fb);
                                select.append('<option custom_id="" value="' + fb.cat_id + '">' + fb.cat_title + '</option>');
                            }
                        });
                    }
                    
                    $('.category_id').multiSelect({
                        selectableHeader: "<div class='custom-header'>Selectable items</div>",
                        selectionHeader: "<div class='custom-header'>Selection items</div>",
                    })
                },
                error: function () {
                    console.log('Error in retrieving Site.');
                }
            });

            if(category_id != ""){
                $("#custom_fields").load("<?php echo base_url(); ?>admin/product/get_custom_fields/"+true, { category: category_id} );
            }
        });
         
        $('#submit_btn').click(function() {
        //alert('TESTING');
            /*if($('body').hasClass('has-error')) {
                $('.has-error').each(function() {
                    alert('REHMAN');
                })
            }*/

            $('textarea[name="product_policy"]').html($('#product_policy').code());
            $('textarea[name="product_description"]').html($('#product_description').code());
            $('textarea[name="pack_include"]').html($('#pack_include').code());
        
            $('#product_form').attr('action', '<?php echo current_url(); ?>');
            $('#product_form').submit();
        
        });
        
        $('#submit_btn_upload').click(function() {
            
            $('#product_form').attr('action', '<?php echo $base_url; ?>admin/product/file_upload');
        
        });
        
        
        $('.category_id').multiSelect({
            selectableHeader: "<div class='custom-header'>Selectable items</div>",
            selectionHeader: "<div class='custom-header'>Selection items</div>",
        })
        
        // ==============================
        // start: discount type
        // ==============================
        $('.iCheck-helper').click(function() {
            
            if(!$(this).prev('input').hasClass('discount_type')) {
                return false;
            }
            
            var discount_type       = $(this).prev('.discount_type').val();
            var product_price       = parseFloat($('#product_price').val());
            var product_discount    = parseFloat($('#product_discount').val(''));
            
            if(product_price == '' && product_discount == '') {
                return false;
            }
            
            if(discount_type == '1') { 
                if(product_discount < product_price) {
                    var discount_value = product_price-product_discount;
                }
                
                if(product_discount >= product_price) {
                    var count_length = $("product_discount").text().length;
                    $("#product_discount").attr('maxlength', count_length);
                    $("#product_discount").val('');
                }
                else {
                    $("#product_discount").removeAttr('maxlength');
                }
            }
            else if(discount_type == '2') {
                if(product_discount < 100) {
                    var discount_persent_value = (product_discount/100)*product_price;
                    discount_value = product_price-discount_persent_value
                }
                
                if(product_discount > 99) {
                    $("#product_discount").attr('maxlength', '2');
                    $("#product_discount").val('');
                }
                else {
                    $("#product_discount").removeAttr('maxlength');
                }
            }
            
            $('#discount_value').val(discount_value.toFixed(2));
            
        })
        
        
        $('.price_value').keyup(function() {
            
            var price_value     = parseFloat($(this).val());
            var price_value_id  = $(this).attr('id');
            var discount_type   = $("input[name=product_disc_type]:checked").val()
            
            if(typeof discount_type == 'undefined') {
                return false;
            }
            
            if(price_value_id == 'product_price') {
                var product_discount = parseFloat($('#product_discount').val());
                var product_price = price_value;
            }
            else {
                var product_price  = parseFloat($('#product_price').val());
                var product_discount = price_value;
            }
            
            if(product_price == '' && product_discount == '') {
                return false;
            }
            
            if(discount_type == '1') { 
                if(product_discount < product_price) {
                    var discount_value = product_price-product_discount;
                }
                
                if(product_discount >= product_price) {
                    var count_length = $("product_discount").text().length;
                    $("#product_discount").attr('maxlength', count_length);
                    $("#product_discount").val('');
                }
                else {
                    $("#product_discount").removeAttr('maxlength');
                }
                    
            }
            else if(discount_type == '2') {
                if(product_discount < 100) {
                    var discount_persent_value = (product_discount/100)*product_price;
                    discount_value = product_price-discount_persent_value
                }
                
                //alert(product_discount);
                if(product_discount > 99) {
                    $("#product_discount").attr('maxlength', '2');
                    $("#product_discount").val('');
                }
                else {
                    $("#product_discount").removeAttr('maxlength');
                }
            }
            
            $('#discount_value').val(discount_value.toFixed(2));
        })
        /* ========== end: discount type ========== */
        
        $(".open_popup").click(function(){
            $('#event-management').modal('show');
        })
        //https://www.youtube.com/embed/C0DPdy98e4c
        //https://www.youtube.com/watch?v=nPSbOsOJ9Ro
        $(".save-event").click(function(){
            $('#event-management').modal('hide');
            var videoName = $.trim($('#videoName').val());
            var videoUrl = $.trim($('#videoUrl').val());
            if(videoUrl != ""){
                videoUrl = videoUrl.split("=");
                videoUrl = "<?php echo $this->config->item("youtube_http"); ?>"+videoUrl[1];
            $(".video_url").append("<tr class='template-download fade in'><td><input type='hidden' name='videoName[]' value='"+videoName+"'><input type='hidden' name='videoUrl[]' value='"+videoUrl+"'><iframe width='150' height='150' src='"+videoUrl+"'></iframe></td><td>"+videoName+"</td><td>&nbsp;</td><td>0 MB</td><td><button data-type='DELETE' class='btn btn-danger delete'><i class='glyphicon glyphicon-trash'></i><span>Delete</span></button>&nbsp;<input type='checkbox' class='toggle' value='1' name='delete'></td></tr>");
            $('#videoName').val("");
            $('#videoUrl').val("");
         }
        });
        $('.btn-danger').prop("disabled", false); // its by default set to disable thats why place that line
        
    });
</script>

<style>
    #product_meta_tag_tag, #product_meta_description_tag, #product_meta_key_tag, #product_product_tag_tag {
        width: auto !important;
    }
    .custom-header {
        background-color: #f5f5f5;
        font-weight: bold;
        padding: 5px;
        text-align: center;
    }
    .has-error-tab  {
        background: #a94442;
    }
    .has-error-tab a {
        color: #ffffff !important;
    }
    .has-error-tab:hover a {
        color: #555 !important;
    }
    .active.has-error-tab a {
        color: #333333 !important;
    }
    .productTagImage {
        display: none;
        width: 65%;
    }
    .upload_tab {
        border: 1px solid #dddddd !important;
        float: none !important;
        margin-top: 0 !important;
    }
    .upload_tab li.active > a:hover {
        color: #333333 !important;
    }
    .fileuploader {
        margin-top: 25px;
    }
</style>