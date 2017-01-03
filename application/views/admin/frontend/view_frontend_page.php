
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
                        <h1>Frontend Pages <small>view frontend pages</small></h1>
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
                            View Frontend Pages
                            <!--<div class="panel-tools">
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
                            </div>-->
                        </div>
                        <?php
                        $attributes = array('class' => 'form-horizontal', 'role' => 'custom_field_form', 'id' => 'custom_field_form');
                        echo form_open(current_url(), $attributes);
                        ?>
                            <div class="panel-body">
                               
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="form-field-1">
                                        Page Name
                                        <?php //echo '<pre>'; print_r($view_page); die(); ?>
                                    </label>
                                    <div class="col-sm-9">

                                        <input type="text" name="page_name" id="page_name" disabled="disabled" value="<?php print_r($view_page->page_name);?>">

                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="form-field-1">
                                        Page Content
                                    </label>
                                    <div class="col-sm-9">
                                        
                                        <div id="pack_include_box" class="summernote form-control" rows="5"><?php echo $view_page->page_content; ?></div>
                                    </div>
                                </div>

                               

                                

                                

                                <?php /*<div class="form-group">
                                    <label class="col-sm-3 control-label" for="form-field-1">
                                        Is Required
                                    </label>
                                    <div class="col-sm-8">

                                        <div class="col-sm-1">
                                        <?php
                                        //$required_checked = isset($customFields) && ($customFields['is_required'] == "Yes") ? 'checked' : "" ;
                                        $input_yes = array(
                                            'name'          => 'is_required',
                                            'id'            => 'is_required',
                                            'value'         => 'Yes',
                                            'class'         => 'form-control',
                                            'style'         => 'margin:0px !important;',
                                            'checked'       => isset($customFields) && ($customFields['is_required'] == "Yes") ? 'checked' : "" ,
                                        );

                                        echo form_radio($input_yes);
                                        ?>
                                        </div>
                                        <label class="col-sm-1 control-label" for="form-field-1">
                                            Yes
                                        </label>
                                        <div class="col-sm-1">
                                        <?php
                                        $input_no = array(
                                            'name'          => 'is_required',
                                            'id'            => 'is_required',
                                            'value'         => 'No',
                                            'class'         => 'form-control',
                                            'style'         => 'margin:0px !important;',
                                            'checked'      => isset($customFields) && ($customFields['is_required'] == "No") ? 'checked' : (!isset($customFields)) ? 'checked':"",
                                        );

                                        echo form_radio($input_no);
                                        ?>
                                        </div>
                                        <label class="col-sm-1 control-label" for="form-field-1">
                                            No
                                        </label>
                                    </div>
                                </div> */ ?>

                                
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
<link rel="stylesheet" href="<?php echo $includes_dir; ?>admin/plugins/summernote/build/summernote.css">
<!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->

<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script src="<?php echo $includes_dir; ?>admin/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="<?php echo $includes_dir; ?>admin/plugins/summernote/build/summernote.min.js"></script>
<!--<script src="<?php echo $includes_dir; ?>admin/js/form-validation-js.js"></script>-->
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->

<script>
    jQuery(document).ready(function () {
        Main.init();
        FormValidator.init();
        
         $('.summernote').summernote({
		height: "200px",
	});
        
         $('#submit_btn').click(function() {
        
            $('textarea[name="page_content"]').html($('#pack_include_box').code());
           });
           
         $('.summernote').summernote('disable');
           
        
    });
    
   
        
    

    $("#field_type").bind("change",function()	  {
        if($(this). val() == "Textarea" || $(this). val() == "Textbox"){
            $("#valField").css("display","none");
            $('#field_value').val("");
        }
        else{
            $("#valField").css("display","block");
        }
    });

    var field_type = '<?php echo isset($customFields) ? $customFields['field_type'] : "" ?>';
    if(field_type == "Textarea" || field_type == "Textbox"){
        $("#valField").css("display","none");
        $('#field_value').val("");
    }
    else if(field_type != ""){
        $("#valField").css("display","block");
    }

    var FormValidator = function () {
        // function to initiate category
        var customFieldForm = function () {
            var form1 = $('#custom_field_form');
            var errorHandler1 = $('.errorHandler', form1);
            var successHandler1 = $('.successHandler', form1);
            $('#custom_field_form').validate({
                errorElement: "span", // contain the error msg in a span tag
                errorClass: 'help-block',
                errorPlacement: function (error, element) {
                        error.insertAfter(element);
                        // for other inputs, just perform default behavior
                },
                ignore: "",
                rules: {
                    
                    page_name:{
                        required: false
                    },
                    page_content:{
                        required: false
                    }
                },
                messages: {
                    page_name: "Please specify page name",
                    page_content: "Please specify page content"
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
                },
                unhighlight: function (element) { // revert the change done by hightlight
                    $(element).closest('.form-group').removeClass('has-error');
                    // set error class to the control group
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
                    HTMLFormElement.prototype.submit.call($('#form')[0]);
                }
            });
        };


        return {
            //main function to initiate pages
            init: function () {
                customFieldForm();
            }
        };
    }();
</script>
