
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
                    </ol>
                    <!-- start: Success and error message -->
                    <?php if (!empty($message)) { ?>
                        <div id="message">
                            <?php echo $message; ?>
                        </div>
                    <?php } ?>
                    <!-- end: Success and error message -->
                    <div class="page-header">
                        <h1>Update Customer Password <small></small></h1>
                    </div>
                    <!-- end: PAGE TITLE & BREADCRUMB -->
                </div>
            </div>
            <!-- end: PAGE HEADER -->

            <!-- start: PAGE CONTENT -->
            <div class="row">
                <div class="col-sm-12">
                    <!-- start: INLINE TABS PANEL -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-reorder"></i>
                            Update Password
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <?php
                                    //echo '<pre>'; print_r($order); die;
                                    //echo '<pre>'; print_r($shipment_details); die;
                                    $attributes = array('class' => 'form-horizontal', 'role' => 'update_password_customer', 'id' => 'update_password_customer');
                                    echo form_open('admin/customer/update_password_customer/', $attributes);
                                    ?>
                                    <div class="tabbable">
                                        <div class="tab-content">
                                            <div class="tab-pane in active" id="panel_tab2_example1">
                                                <div class="panel-body">

                                                    <fieldset>
                                                        <legend>Customer Information</legend>
                                                        <div role="form" class="form-horizontal">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label class="col-sm-4 control-label" for="form-field-1">
                                                                        Password <span class="validField">*</span>
                                                                    </label>
                                                                    <div class="col-sm-8">
                                                                        <input type="password" placeholder="" name="myPassword" id="myPassword" class="form-control" value="<?php echo (isset($get_customer['customer_password'])) ? $get_customer['customer_password'] : set_value('myPassword'); ?>">
                                                                        <input type="hidden" name="customer_id" value="<?php echo (isset($customer_id))?$customer_id:""; ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 margin_bottom">
                                                                <div class="form-group">
                                                                    <label class="col-sm-3 control-label" for="form-field-1">
                                                                        Confirm Password <span class="validField">*</span>
                                                                    </label>
                                                                    <div class="col-sm-7">
                                                                        <input type="password" placeholder="" name="myConPass" id="myConPass" class="form-control" value="<?php echo set_value('myConPass'); ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                                    
                                                <div class="row">
                                                    <div class="col-md-2 pull-right">
                                                        <input type="hidden" name="edit_form" value="edit_form">
                                                        <button class="btn btn-yellow btn-block" id="submit_btn" type="submit">
                                                            Submit <i class="fa fa-arrow-circle-right"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
<?php echo form_close(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end: INLINE TABS PANEL -->
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


<!-- ***********************************
// statr: fancy-box for show searching product
************************************ -->
<!--<div id="product_box" class="" style="width:800px; display: none">
    <div class="col-md-12">
         start: BASIC TABLE PANEL 
        <div class="panel panel-default">
            <div class="panel-body" id="table_inserHTML">
                <table class="table table-striped table-bordered table-hover table-full-width" id="product_table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Model</th>
                            <th>Price</th>
                            <th>Discount Price</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>-->
<!-- end: fancy-box for show searching product -->


<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
<link rel="stylesheet" type="text/css" href="<?php echo $includes_dir; ?>admin/plugins/select2/select2.css" />
<link rel="stylesheet" href="<?php echo $includes_dir; ?>admin/plugins/datatables/media/css/DT_bootstrap.css" />
<!-- fancy box -->
<link rel="stylesheet" type="text/css" href="<?php echo $includes_dir; ?>admin/plugins/fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />
<!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->

<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script src="<?php echo $includes_dir; ?>admin/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="<?php echo $includes_dir; ?>admin/js/form-validation-js.js"></script>
<script type="text/javascript" src="<?php echo $includes_dir; ?>admin/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="<?php echo $includes_dir; ?>admin/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo $includes_dir; ?>admin/plugins/datatables/media/js/DT_bootstrap.js"></script>
<script src="<?php echo $includes_dir; ?>admin/js/table-data.js"></script>
<!-- fancy box -->
<script type="text/javascript" src="<?php echo $includes_dir; ?>admin/plugins/fancybox/jquery.fancybox.js?v=2.1.5"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->

<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script src="<?php echo $includes_dir; ?>admin/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->

<script>
    jQuery(document).ready(function () {

        Main.init();
        FormValidator.init();

        

        
    });
    
    var FormValidator = function () {
        // function to initiate category
        var addProductForm = function () {
            var form1 = $('#update_password_customer');
            var errorHandler1 = $('.errorHandler', form1);
            var successHandler1 = $('.successHandler', form1);
            $('#update_password_customer').validate({
                errorElement: "span", // contain the error msg in a span tag
                errorClass: 'help-block',
                errorPlacement: function (error, element) {
                    error.insertAfter(element);
                    // for other inputs, just perform default behavior
                },
                ignore: "",
                rules: {
                    myPassword: {
                        required: true
                    },
                    myConPass: {
                        required: true
                    }
                    
                },
                messages: {
                    myPassword: "Please enter Password",
                    myConPass: "Please enter Confirm Password"
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
                    HTMLFormElement.prototype.submit.call($('#update_password_customer')[0]);
                }
            });
        };


        return {
            //main function to initiate pages
            init: function () {
                addProductForm();
            }
        };
    }();



</script>

<style>
    .content-box {
        border: 1px solid #dddddd;
        margin-bottom: 10px;
    }

    .content-box .box-content {
        padding: 10px;
    }

    .content-box .box-head {
        background: #f6f6f6 none repeat scroll 0 0;
        color: #333333;
        font-size: 13px;
        font-weight: 500;
        padding: 10px;
        text-transform: uppercase;
    }

    .margin_bottom{
        margin-bottom:25px;
    }

</style>