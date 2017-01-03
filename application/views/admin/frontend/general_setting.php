
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
                    <div class="page-header">
                        <h1>General Setting <small></small></h1>
                    </div>
                    <!-- end: PAGE TITLE & BREADCRUMB -->
                </div>
            </div>
            <!-- end: PAGE HEADER -->
            <!-- start: PAGE CONTENT -->
            <div class="row">
                <div class="col-sm-12">
                    <!-- start: TEXT FIELDS PANEL -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-external-link-square"></i>
                            Setting
                            

                            <!-- <div class="panel-tools">
                                <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                                </a>
                                <a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal">
                                    <i class="fa fa-wrench"></i>
                                </a>
                                <a class="btn btn-xs btn-link panel-refresh" href="#">
                                    <i class="fa fa-refresh"></i>
                                </a>
                                <a class="btn btn-xs btn-link panel-expand" href="#">
                                    <i class="fa fa-resize-full"></i>
                                </a>
                                <a class="btn btn-xs btn-link panel-close" href="#">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div> -->
                        </div>
                        <?php
                        $attributes = array('class' => 'form-horizontal', 'role' => 'cat_form', 'id' => 'cat_form');
                        echo form_open_multipart(current_url(), $attributes);
                        ?>
                            <div class="panel-body">
                                <h3>General Details </h3>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="form-field-1">
                                        Website Name <span class="validField">*</span>
                                    </label>
                                    <div class="col-sm-8">
                                        <?php
                                        $input_data = array(
                                                'type'          => 'text',
                                                'name'          => 'website_name',
                                                'id'            => 'website_name',
                                                'value'         => ($general_setting) ? $general_setting['website_name'] : set_value('website_name'),
                                                'class'         => 'form-control',
                                                'placeholder'   => ''
                                        );

                                        echo form_input($input_data);
                                        ?>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="form-field-1">
                                        Contact Number <span class="validField">*</span>
                                    </label>
                                    <div class="col-sm-8">
                                        <?php
                                        $input_data = array(
                                                'type'          => 'text',
                                                'name'          => 'contact_number',
                                                'id'            => 'contact_number',
                                                'value'         => ($general_setting) ? $general_setting['contact_number'] : set_value('contact_number'),
                                                'class'         => 'form-control',
                                                'placeholder'   => ''
                                        );

                                        echo form_input($input_data);
                                        ?>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="form-field-1">
                                        WhatsApp Number <span class="validField">*</span>
                                    </label>
                                    <div class="col-sm-8">
                                        <?php
                                        $input_data = array(
                                                'type'          => 'text',
                                                'name'          => 'whatsapp_number',
                                                'id'            => 'whatsapp_number',
                                                'value'         => ($general_setting) ? $general_setting['whatsapp_number'] : set_value('whatsapp_number'),
                                                'class'         => 'form-control',
                                                'placeholder'   => ''
                                        );

                                        echo form_input($input_data);
                                        ?>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="form-field-1">
                                        Viber Number <span class="validField">*</span>
                                    </label>
                                    <div class="col-sm-8">
                                        <?php
                                        $input_data = array(
                                                'type'          => 'text',
                                                'name'          => 'viber_number',
                                                'id'            => 'viber_number',
                                                'value'         => ($general_setting) ? $general_setting['viber_number'] : set_value('viber_number'),
                                                'class'         => 'form-control',
                                                'placeholder'   => ''
                                        );

                                        echo form_input($input_data);
                                        ?>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="form-field-1">
                                        Home Page Title <span class="validField">*</span>
                                    </label>
                                    <div class="col-sm-8">
                                        <?php
                                        $input_data = array(
                                                'type'          => 'text',
                                                'name'          => 'homepage_title',
                                                'id'            => 'homepage_title',
                                                'value'         => ($general_setting) ? $general_setting['homepage_title'] : set_value('homepage_title'),
                                                'class'         => 'form-control',
                                                'placeholder'   => ''
                                        );

                                        echo form_input($input_data);
                                        ?>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="form-field-1">
                                        Copyright <span class="validField">*</span>
                                    </label>
                                    <div class="col-sm-8">
                                        <?php
                                        $input_data = array(
                                                'type'          => 'text',
                                                'name'          => 'copyright',
                                                'id'            => 'copyright',
                                                'value'         => ($general_setting) ? $general_setting['copyright'] : set_value('copyright'),
                                                'class'         => 'form-control',
                                                'placeholder'   => ''
                                        );

                                        echo form_input($input_data);
                                        ?>
                                    </div>
                                    <input type="hidden" name="setting_id" value="<?php echo ($general_setting) ? $general_setting['setting_id'] : ''; ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="form-field-1">
                                        Meta Description <span class="validField">*</span>
                                    </label>
                                    <div class="col-sm-8">
                                        <?php
                                        $input_data = array(
                                                'type'          => 'text',
                                                'name'          => 'meta_description',
                                                'id'            => 'meta_description',
                                                'value'         => ($general_setting) ? $general_setting['meta_description'] : set_value('meta_description'),
                                                'class'         => 'form-control',
                                                'placeholder'   => ''
                                        );

                                        echo form_input($input_data);
                                        ?>
                                    </div>
                                    <input type="hidden" name="setting_id" value="<?php echo ($general_setting) ? $general_setting['setting_id'] : ''; ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="form-field-1">
                                        Meta Key Words <span class="validField">*</span>
                                    </label>
                                    <div class="col-sm-8">
                                        <?php
                                        $input_data = array(
                                                'type'          => 'text',
                                                'name'          => 'meta_key_words',
                                                'id'            => 'meta_key_words',
                                                'value'         => ($general_setting) ? $general_setting['meta_key_words'] : set_value('meta_key_words'),
                                                'class'         => 'form-control',
                                                'placeholder'   => ''
                                        );

                                        echo form_input($input_data);
                                        ?>
                                    </div>
                                    <input type="hidden" name="setting_id" value="<?php echo ($general_setting) ? $general_setting['setting_id'] : ''; ?>">
                                </div>
                                
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label class="col-sm-3 control-label" for="form-field-1">
                                            Logo <span class="validField">*</span>
                                        </label>
                                        <div class="col-sm-8 fileupload fileupload-new" data-provides="fileupload">
                                            <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                                <?php if(!empty($general_setting['website_logo']) && $general_setting) { ?>
                                                    <img src="<?php echo $base_url . 'upload/' . $general_setting['website_logo']; ?>" alt=""/>
                                                <?php } else { ?>
                                                    <img src="<?php echo $includes_dir . 'admin/images/no-image1.png'; ?>" alt=""/>
                                                <?php } ?>
                                                <input type="hidden" name="website_logo_old" value="<?php echo (!empty($general_setting['website_logo'])) ? $general_setting['website_logo'] : ''; ?>">
                                            </div>
                                            
                                            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                            <div style="float: right; padding-right: 28%; padding-top: 20%;">
                                                Logo Dimension (<?php echo $this->config->item("logo_dimensions", "general") ?>) Width x Height
                                            </div>
                                            <div>
                                                <span class="btn btn-light-grey btn-file"><span class="fileupload-new"><i class="fa fa-picture-o"></i> Select image</span><span class="fileupload-exists"><i class="fa fa-picture-o"></i> Change</span>
                                                    <input type="file" name="website_logo">
                                                </span>
                                                <a href="#" class="btn fileupload-exists btn-light-grey" data-dismiss="fileupload">
                                                    <i class="fa fa-times"></i> Remove
                                                </a>
                                            </div>
                                            
                                        </div>
                                        
                                    </div>
                                </div>
                                
                                <hr />
                                <h3>Invoice Details </h3>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="form-field-1">
                                        Company Address <span class="validField">*</span>
                                    </label>
                                    <div class="col-sm-8">
                                        <?php
                                        $input_data = array(
                                                'type'          => 'text',
                                                'name'          => 'company_address',
                                                'id'            => 'company_address',
                                                'value'         => ($general_setting) ? $general_setting['company_address'] : set_value('company_address'),
                                                'class'         => 'form-control',
                                                'placeholder'   => ''
                                        );

                                        echo form_input($input_data);
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="form-field-1">
                                        Telephone Number <span class="validField">*</span>
                                    </label>
                                    <div class="col-sm-8">
                                        <?php
                                        $input_data = array(
                                                'type'          => 'text',
                                                'name'          => 'company_telephone_no',
                                                'id'            => 'company_telephone_no',
                                                'value'         => ($general_setting) ? $general_setting['company_telephone_no'] : set_value('company_telephone_no'),
                                                'class'         => 'form-control',
                                                'placeholder'   => ''
                                        );

                                        echo form_input($input_data);
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="form-field-1">
                                        Email <span class="validField">*</span>
                                    </label>
                                    <div class="col-sm-8">
                                        <?php
                                        $input_data = array(
                                                'type'          => 'text',
                                                'name'          => 'company_email',
                                                'id'            => 'company_email',
                                                'value'         => ($general_setting) ? $general_setting['company_email'] : set_value('company_email'),
                                                'class'         => 'form-control',
                                                'placeholder'   => ''
                                        );

                                        echo form_input($input_data);
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="form-field-1">
                                        Webite <span class="validField">*</span>
                                    </label>
                                    <div class="col-sm-8">
                                        <?php
                                        $input_data = array(
                                                'type'          => 'text',
                                                'name'          => 'company_website',
                                                'id'            => 'company_website',
                                                'value'         => ($general_setting) ? $general_setting['company_website'] : set_value('company_website'),
                                                'class'         => 'form-control',
                                                'placeholder'   => ''
                                        );

                                        echo form_input($input_data);
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="col-md-2 pull-right">
                                    <button class="btn btn-yellow btn-block" type="submit">
                                        <?php echo ($general_setting) ? 'Update' : 'Submit' ?> <i class="fa fa-arrow-circle-right"></i>
                                    </button>
                                </div>
                            </div>
                        <?php echo form_close(); ?>
                    </div>
                    <!-- end: TEXT FIELDS PANEL -->
                </div>
            </div>
            <!-- end: PAGE CONTENT-->
        </div>
    </div>
    <!-- end: PAGE -->
</div>
<!-- end: MAIN CONTAINER -->

<!-- statr: INCLUSE FOOTER -->
<?php $this->load->view('admin/includes/footer'); ?>
<!-- end: INCLUSE FOOTER -->

<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
<link rel="stylesheet" href="<?php echo $includes_dir; ?>admin/plugins/bootstrap-fileupload/bootstrap-fileupload.min.css">
<link rel="stylesheet" href="<?php echo $includes_dir; ?>admin/plugins/jQuery-Tags-Input/jquery.tagsinput.css">
<!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->

<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script src="<?php echo $includes_dir; ?>admin/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="<?php echo $includes_dir; ?>admin/js/form-validation-js.js"></script>
<script src="<?php echo $includes_dir; ?>admin/plugins/bootstrap-fileupload/bootstrap-fileupload.min.js"></script>
<script src="<?php echo $includes_dir; ?>admin/plugins/jQuery-Tags-Input/jquery.tagsinput.js"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->

<script>
    jQuery(document).ready(function () {
        Main.init();
        //FormValidator.init();
    });
    
    $('#meta_description').tagsInput({
        'width':'auto',
        'height':'65px',
        'defaultText':'add a meta description',
    });
    
    $('#meta_key_words').tagsInput({
        'width':'auto',
        'height':'65px',
        'defaultText':'add a meta key words',
    });
</script>

<style>
    #meta_description_tag, #meta_key_words_tag {
        width: auto !important;
    }
</style>