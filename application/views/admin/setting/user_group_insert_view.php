
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
                        <h1 class="col-sm-6">Manage User Account <small></small></h1>
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
                                Manage User Group
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
                            <div class="panel-body">
                                <div class="form-group">
                                    <div class="col-sm-2 pull-left">
                                        <a href="<?php echo $base_url; ?>auth_admin/manage_user_groups" class="btn btn-info ladda-button">Manage User Groups</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <!-- end: TEXT FIELDS PANEL -->
                </div>
            </div>
            <!-- end: PAGE CONTENT-->
            
            <!-- start: PAGE CONTENT -->
            <div class="row">
                <div class="col-md-12">
                    <!-- start: BASIC TABLE PANEL -->
                    <?php
                    $attributes = array('class' => 'form-horizontal', 'role' => 'cat_form', 'id' => 'search_form');
                    echo form_open(current_url(), $attributes);
                    ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-external-link-square"></i>
                                Group
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
                            <div class="panel-body">
                                <fieldset>
                                    <legend>Group Details</legend>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="form-field-1">
                                            Group Name <span class="validField">*</span>
                                        </label>
                                        <div class="col-sm-7">
                                            <?php
                                            $input_data = array(
                                                    'type'          => 'text',
                                                    'name'          => 'insert_group_name',
                                                    'id'            => 'group',
                                                    'value'         => set_value('insert_group_name'),
                                                    'class'         => 'form-control',
                                                    'placeholder'   => ''
                                            );

                                            echo form_input($input_data);
                                            ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="form-field-1">
                                            Group Description
                                        </label>
                                        <div class="col-sm-7">
                                            <textarea id="description" name="insert_group_description" class="form-control"><?php echo set_value('insert_group_description'); ?></textarea>
                                        </div>
                                    </div>
                                    <!--
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="form-field-1">
                                            Is Admin Group
                                        </label>
                                        <div class="col-sm-7">
                                            <input type="checkbox" id="admin" name="insert_group_admin" value="1" <?php //echo set_checkbox('insert_group_admin', 1); ?> class=""/>
                                        </div>
                                    </div>
                                    -->
                                </fieldset>
                                <div class="form-group">
                                    <div class="col-sm-2 pull-right">
                                        <input type="hidden" value="Submit" name="insert_user_group">
                                        <button type="submit" class="btn btn-info btn-block" id="search_btn">
                                            Submit <i class=""></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php echo form_close(); ?>
                    <!-- end: BASIC TABLE PANEL -->
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
<link rel="stylesheet" type="text/css" href="<?php echo $includes_dir; ?>admin/plugins/select2/select2.css" />
<link rel="stylesheet" href="<?php echo $includes_dir; ?>admin/plugins/datatables/media/css/DT_bootstrap.css" />
<!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->

<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script src="<?php echo $includes_dir; ?>admin/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="<?php echo $includes_dir; ?>admin/js/form-validation-js.js"></script>
<script type="text/javascript" src="<?php echo $includes_dir; ?>admin/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="<?php echo $includes_dir; ?>admin/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo $includes_dir; ?>admin/plugins/datatables/media/js/DT_bootstrap.js"></script>
<script src="<?php echo $includes_dir; ?>admin/js/table-data.js"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->

<script>
    jQuery(document).ready(function () {
        Main.init();
        FormValidator.init();
        TableData.init();
        });

    var FormValidator = function () {
        // function to initiate category
        var customFieldForm = function () {
            var form1 = $('#search_form');
            var errorHandler1 = $('.errorHandler', form1);
            var successHandler1 = $('.successHandler', form1);
            $('#search_form').validate({
                errorElement: "span", // contain the error msg in a span tag
                errorClass: 'help-block',
                errorPlacement: function (error, element) {
                        error.insertAfter(element);
                        // for other inputs, just perform default behavior
                },
                ignore: "",
                rules: {
                    insert_group_name: {
                        required: true
                    }
                },
                messages: {
                    insert_group_name: "Please enter Group Name"
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
                    HTMLFormElement.prototype.submit.call($('#search_form')[0]);
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