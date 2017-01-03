
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
                        <h1>Edit Customer <small>edit customer</small></h1>
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
                            Edit Information
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <?php
                                    //echo '<pre>'; print_r($order); die;
                                    //echo '<pre>'; print_r($shipment_details); die;
                                    $attributes = array('class' => 'form-horizontal', 'role' => 'add_product_form', 'id' => 'add_product_form');
                                    echo form_open('admin/customer/edit_customer/'.$get_customer['customer_id'], $attributes);
                                    //echo '<pre>'; print_r($customer); die;
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
                                                                        First Name <span class="validField">*</span>
                                                                    </label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" placeholder="Enter first name" name="first_name" id="first_name" class="form-control" value="<?php echo (isset($get_customer['customer_first_name'])) ? $get_customer['customer_first_name'] : ''; ?>">
                                                                        <input type="hidden" name="edit_form_customer_id" value="<?php if(isset($get_customer['customer_id'])) { echo $get_customer['customer_id']; } ?>">
                                                                        <input type="hidden" name="edit_form_order_id" value="<?php if(isset($get_customer['order_id'])) { echo $get_customer['order_id']; } ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 margin_bottom">
                                                                <div class="form-group">
                                                                    <label class="col-sm-3 control-label" for="form-field-1">
                                                                        Last Name <span class="validField">*</span>
                                                                    </label>
                                                                    <div class="col-sm-7">
                                                                        <input type="text" placeholder="Enter last name" name="last_name" id="last_name" class="form-control" value="<?php echo (isset($get_customer['customer_last_name'])) ? $get_customer['customer_last_name'] : ''; ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label class="col-sm-4 control-label" for="form-field-1">
                                                                        Email <span class="validField">*</span>
                                                                    </label>
                                                                    <div class="col-sm-8">
                                                                        <input type="email" placeholder="e.g: admin@admin.com" name="email" id="email" class="form-control" value="<?php echo (isset($get_customer['customer_email'])) ? $get_customer['customer_email'] : ''; ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 margin_bottom">
                                                                <div class="form-group">
                                                                    <label class="col-sm-3 control-label" for="form-field-1">
                                                                        Contact No# <span class="validField">*</span>
                                                                    </label>
                                                                    <div class="col-sm-7">
                                                                        <input type="text" maxlength="11" placeholder="e.g: 00000000000" name="contact_no" id="contact_no" class="form-control" value="<?php echo (isset($get_customer['customer_contact_no'])) ? $get_customer['customer_contact_no'] : ''; ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label class="col-sm-2 control-label" for="form-field-1">
                                                                        Address <span class="validField">*</span>
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <textarea name="address" id="address" class="form-control"><?php echo (isset($get_customer['customer_address'])) ? $get_customer['customer_address'] : ''; ?></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </fieldset>
                                                </div>
                                                    
                                                <div class="row">
                                                    <!--<div class="col-md-2 pull-left">
                                                        <a href="#panel_tab2_example1" data-toggle="tab" class="btn btn-light-grey next_tab">
                                                            <i class="fa fa-arrow-circle-left"></i> Back
                                                        </a>
                                                    </div>-->
                                                    
                                                    <div class="col-md-2 pull-right">
                                                        <input type="hidden" name="edit_form" value="edit_form">
                                                        <button class="btn btn-yellow btn-block" id="submit_btn" type="submit">
                                                            Submit <i class="fa fa-arrow-circle-right"></i>
                                                        </button>
                                                    </div>
                                                    <div class="col-md-2 control-label pull-right">
                                                    <a href="<?php echo base_url(); ?>admin/customer/update_password_customer/<?php echo $get_customer['customer_id']; ?>">Update Password</a>
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

        $('.next_tab').click(function () {
            var href = $(this).attr('href');
            $('#myTab').children('li').removeClass('active');
            $('a[href=' + href + ']').parent('li').addClass('active');
        });

        Main.init();
        FormValidator.init();

        $.validator.addMethod("phone_number", function (value, element) {
            return this.optional(element) || value.match(/^0[\d]{10}$/g);
        }, "Please enter a valid number");


//            $(".new_quantity").focusout(function( e ) {
//                $(".new_quantity").each(function(e) {
//                var val = $(this).val();
//                if(val && $.isNumeric(val)){
//                    $(".checkout_btn").removeClass('disabled');
//                }else{
//                alert('Please enter quantity');
//                $(".checkout_btn").addClass('disabled');
//                return false;
//            }
//            });
//        });

        $('body').on('click', '#search_user', function (e) {
            var email = $('.search_customer_email').val();
            var contact = $('.search_customer_contact_no').val();

            $.ajax({
                url: '<?php echo base_url(); ?>admin/order/check_user_exist',
                type: 'POST',
                data: {email: email, contact: contact},
                dataType: "JSON",
                success: function (data) {
                    //console.log(data);
                    $('#first_name').val(data.customer_first_name);
                    $('#last_name').val(data.customer_last_name);
                    $('#email').val(data.customer_email);
                    $('#contact_no').val(data.customer_contact_no);
                    $('#address').text(data.customer_address);
                },
                error: function () {
                }
            });
            e.preventDefault();
        })

        $('body').on('click', '#shipment_info_same', function () {
            var same_check = 'shipment_info_same';
                if ($('#'+same_check+':checked').val() == "on") {        
                    //console.log(data);
                    var first_name = $('#first_name').val();
                    $('#s_first_name').val(first_name);
                    var last_name = $('#last_name').val();
                    $('#s_last_name').val(last_name);
                    var email = $('#email').val();
                    $('#s_email').val(email);
                    var contact_no = $('#contact_no').val();
                    $('#s_contact_no').val(contact_no);
                    var address = $('#address').val();
                    $('#s_address').text(address);
                    //alert(email+' & '+contact_no+' & '+address);
                }else{
                    $('#s_first_name').val('');
                    $('#s_last_name').val('');
                    $('#s_email').val('');
                    $('#s_contact_no').val('');
                    $('#s_address').text('');
                }
        });

        /*Quantity Function*/
        $('body').on('click', '.remove_prdouct', function (e) {
            //$(this).attr('id');
            var cart_id = $(this).attr('id');

            $.ajax({
                url: '<?php echo base_url(); ?>admin/order/delete_from_cart',
                type: 'POST',
                data: {cart_id: cart_id},
                dataType: "JSON",
                success: function (data) {
                    //console.log(data);
                    //return false;
                    $("#" + cart_id).fadeOut(2000)
                    if (data.rowcount == 0) {
                        $(".checkout_btn").fadeOut(2000);
                        $("#net_total_price").fadeOut(2000);
                    }
                    if (data.total_price) {
                        $("#net_total_price").text(data.total_price);
                    }
                },
                error: function () {
                }
            });
            e.preventDefault();
        })
        /*Quantity Function End*/
//        $(".new_quantity").focusout(function(){
//        var cart_id_1 = $(this).attr('id');
//        var total_price_pre = $("#net_total_price").html();
//        //alert(total_price_pre);
//        if($(this).val() < 1 ){
//            //alert('less');
//                $(this).val('1');
//                var price = $(this).attr('productPrice');
//                $("."+cart_id_1).text(price);
//                var net_val = total_price_pre . price;
//                $("#net_total_price").text();
//                $("#net_total_price").text(net_val);
//           // $('.sendButton').attr('disabled', false);
//            }
//        });

        /*Price Function*/
        $('body').on('focusout', '.new_quantity', function (e) {
            var cart_id = $(this).attr('id');
            //alert($(this).attr('id'));
            var quantity = $(this).val();
            var price = $(this).attr('productPrice');//$(".price_"+cart_id).val();
            var productID = $(this).attr('productID');
            //alert(productID);
            //return false;


            //if(quantity != "" && quantity > -1){
            $.ajax({
                url: '<?php echo base_url(); ?>admin/order/update_cart_price',
                type: 'POST',
                data: {cart_id: cart_id, quantity: quantity, productID: productID},
                dataType: "JSON",
                success: function (data) {

                    if (data.total_price) {
                        var new_total = price * quantity;
                        $("." + cart_id).text(new_total);
                        $("#net_total_price").text(data.total_price);
                    }
                    else {
                        //var one_pro_total = price * 1;
                        //alert()
                        //$("."+cart_id).text(data.cart_product_quantity);
                        //alert(input_quantity);

                        //console.log(quant);
                        $('#' + cart_id + ' input').val(data.cart_product_quantity);
                        if (quantity != 0 && quantity != "") {
                            alert('Out Of Stock');
                        }
                    }
                },
                error: function () {
                    alert('Out Of Stock');
                }
            });
            //}
            //else{
            //alert("Please enter quantity");

            //}
            e.preventDefault();
        })
        /*Price Function End*/
    });

//    var patt = /92[\d]{11}/g; // Shorthand for RegExp object
//    var contact_no = $(".contact_no").val;
//    var result = patt.test(contact_no); // result1 is true
//
//    var s_contact_no = $(".s_contact_no").val;
//    var result2 = patt.test(s_contact_no); // result2 is false
//    
//    alert('contact_no is '+result);
//    alert('shipment contact_no is '+result2);
//    
//    return false;


    var FormValidator = function () {
        // function to initiate category
        var addProductForm = function () {
            var form1 = $('#add_product_form');
            var errorHandler1 = $('.errorHandler', form1);
            var successHandler1 = $('.successHandler', form1);
            $('#add_product_form').validate({
                errorElement: "span", // contain the error msg in a span tag
                errorClass: 'help-block',
                errorPlacement: function (error, element) {
                    error.insertAfter(element);
                    // for other inputs, just perform default behavior
                },
                ignore: "",
                rules: {
                    first_name: {
                        required: true
                    },
                    last_name: {
                        required: true
                    },
                    email: {
                        required: true
                    },
                    contact_no: {
                        required: true,
                        //digits: true,
                        phone_number: true
                    },
                    address: {
                        required: true
                    }
                    
                },
                messages: {
                    first_name: "Please enter First Name",
                    last_name: "Please enter Last Name",
                    email: "Please enter vaild email address",
                    contact_no: "Please enter Contact Number digits only",
                    address: "Please enter Address",
                    
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
                    HTMLFormElement.prototype.submit.call($('#add_product_form')[0]);
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