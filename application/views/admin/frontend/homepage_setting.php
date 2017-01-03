
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
                        <h1>Homepage Setting <small></small></h1>
                    </div>
                    <!-- end: PAGE TITLE & BREADCRUMB -->
                </div>
            </div>
            <!-- end: PAGE HEADER -->

            <?php
            $attributes = array('class' => 'form-horizontal', 'role' => 'cat_form', 'id' => 'cat_form');
            echo form_open_multipart(current_url(), $attributes);
            ?>
            <!-- start: PAGE CONTENT -->
            <div class="row">
                <div class="col-sm-12">
                    <!-- start: TEXT FIELDS PANEL -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-external-link-square"></i>
                            Show Product
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label label_left" for="form-field-1">
                                    Show Product
                                </label>
                                <div class="col-sm-8 check_setting" style="margin-left: 20px;">
                                    <?php
                                    $input_data = array(
                                        'name' => 'show_product',
                                        'id' => 'show_product',
                                        'value' => '1',
                                        'checked' => ($general_setting['show_product'] == '1') ? TRUE : FALSE,
                                        'class' => 'grey'
                                    );

                                    echo form_checkbox($input_data);
                                    ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label label_left" for="form-field-1">
                                    Product Limit
                                </label>
                                <div class="col-sm-3 check_setting">
                                    <?php
                                    $input_data = array(
                                        'type' => 'text',
                                        'name' => 'product_limit',
                                        'id' => 'product_limit',
                                        'value' => ($general_setting) ? $general_setting['product_limit'] : set_value('product_limit'),
                                        'class' => 'form-control',
                                        'placeholder' => ''
                                    );

                                    echo form_input($input_data);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label label_left" for="form-field-1">
                                    Product Order
                                </label>
                                <div class="col-sm-3 check_setting">
                                    <select class="form-control" name="product_order">
                                            <option value="ASC" <?php echo (isset($general_setting['product_order']) && $general_setting['product_order']=="ASC")?"selected='selected'":""; ?>>Ascending</option>
                                            <option value="DESC" <?php echo (isset($general_setting['product_order']) && $general_setting['product_order']=="DESC")?"selected='selected'":""; ?>>Descending</option>
                                        </select>
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
                <div class="col-sm-12">
                    <!-- start: TEXT FIELDS PANEL -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-external-link-square"></i>
                            Featured Product
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label label_left" for="form-field-1">
                                    Show Featured Product
                                </label>
                                <div class="col-sm-8 check_setting">
                                    <?php
                                    $input_data = array(
                                        'name' => 'featured_product',
                                        'id' => 'featured_product',
                                        'value' => '1',
                                        'checked' => ($general_setting['featured_product'] == '1') ? TRUE : FALSE,
                                        'class' => 'grey',
                                    );

                                    echo form_checkbox($input_data);
                                    ?>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <select id="category" name="category" class="form-control" size="9">
                                    <?php
                                    if ($categories) {
                                        foreach ($categories as $get_record) {
                                            echo '<option value="' . $get_record['cat_id'] . '">' . $get_record['cat_title'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-sm-8 multiselect_featured" id="multi-selecter-featured">
                                <select name="featured_product_id[]" id="form-field-select-4" multiple="multiple" class="featured_product_id form-control">
                                    <?php
                                    if ($featured_product) {
                                        foreach ($featured_product as $get_data) {
                                            echo '<option selected="selected" custom_id="' . $get_data['product_cat_id'] . '" id="featured_option_' . $get_data['product_id'] . '_' . $get_data['product_cat_id'] . '" value="' . $get_data['product_id'] . '_' . $get_data['product_cat_id'] . '" class="selected">' . $get_data['product_title'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- end: TEXT FIELDS PANEL -->
                </div>
            </div>
            <!-- end: PAGE CONTENT-->

            <!-- start: PAGE CONTENT -->
            <div class="row">
                <div class="col-sm-12">
                    <!-- start: TEXT FIELDS PANEL -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-external-link-square"></i>
                            Category Product
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label label_left" for="form-field-1">
                                    Show Category Product
                                </label>
                                <div class="col-sm-8 check_setting">
                                    <?php
                                    $input_data = array(
                                        'name' => 'category_product',
                                        'id' => 'category_product',
                                        'value' => '1',
                                        'checked' => ($general_setting['category_product'] == '1') ? TRUE : FALSE,
                                        'class' => 'grey',
                                    );

                                    echo form_checkbox($input_data);
                                    ?>
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <select name="category_select_from[]" id="category_select" class="form-control" size="9">
                                    <?php
                                    if ($categories) {
                                        foreach ($categories as $get_record) {
                                            echo '<option value="' . $get_record['cat_id'] . '">' . $get_record['cat_title'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-sm-1" style="margin-top: 70px;">
                                <button type="button" id="category_select_rightSelected" class="btn" style="margin-bottom: 10px;"><i class="glyphicon glyphicon-chevron-right"></i></button>
                                <button type="button" id="category_select_leftSelected" class="btn"><i class="glyphicon glyphicon-chevron-left"></i></button>
                            </div>

                            <div class="col-sm-2" style="margin-left: -15px; margin-right: 15px;">
                                <select name="category_select_to[]" id="category_select_to" class="form-control" size="9" style="height: 222px;">
                                    <?php
                                    if ($selected_category) {
                                        foreach ($selected_category as $get_record) {
                                            echo '<option value="' . $get_record['category_id'] . '">' . $get_record['category_title'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <div id="category_box">
                                <?php
                                if ($selected_category) {
                                    foreach ($selected_category as $get_record) {
                                        echo '<input type="hidden" name="category_select[]" value="' . $get_record['category_id'] . '" id="category_' . $get_record['category_id'] . '">';
                                    }
                                }
                                ?>
                            </div>

                            <div class="col-sm-7 multiselect_category" id="multi-selecter-category">
                                <select name="category_product_id[]" id="form-field-select-5" multiple="multiple" class="category_product_id form-control">
                                    <?php
                                    if ($category_product) {
                                        foreach ($category_product as $get_data) {
                                            echo '<option selected="selected" custom_id="' . $get_data['product_cat_id'] . '" id="featured_option_' . $get_data['product_id'] . '_' . $get_data['product_cat_id'] . '" value="' . $get_data['product_id'] . '_' . $get_data['product_cat_id'] . '" class="selected">' . $get_data['product_title'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- end: TEXT FIELDS PANEL -->
                </div>
            </div>
            <!-- end: PAGE CONTENT-->

            <!-- start: PAGE CONTENT -->
            <div class="row">
                <div class="col-sm-12">
                    <!-- start: TEXT FIELDS PANEL -->
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="col-md-2 pull-right">
                                <button class="btn btn-yellow btn-block" type="submit">
                                    <?php echo (isset($homepage_setting) && $homepage_setting) ? 'Update' : 'Submit' ?> <i class="fa fa-arrow-circle-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- end: TEXT FIELDS PANEL -->
                </div>
            </div>
            <!-- end: PAGE CONTENT-->
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
<!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->

<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script src="<?php echo $includes_dir; ?>admin/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="<?php echo $includes_dir; ?>admin/js/form-validation-js.js"></script>
<script src="<?php echo $includes_dir; ?>admin/plugins/lou-multi-select/js/jquery.multi-select.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo $includes_dir; ?>admin/plugins/multiselect-master/js/multiselect.min.js"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->

<script>
    jQuery(document).ready(function () {
        Main.init();
        //FormValidator.init();
    });

    /*********************************
     start: Category Product
     *********************************/
    $('#category_select').multiselect({
        rightSelected: '#category_select_rightSelected',
        leftSelected: '#category_select_leftSelected',
        moveToRight: function (Multiselect, $options, event, silent, skipStack) {
            var button = $(event.currentTarget).attr('id');

            if (button == 'category_select_rightSelected') {
                var $left_options = Multiselect.$left.find('> option:selected');
                Multiselect.$right.eq(0).append($left_options);

                if (typeof Multiselect.callbacks.sort == 'function' && !silent) {
                    Multiselect.$right.eq(0).find('> option').sort(Multiselect.callbacks.sort).appendTo(Multiselect.$right.eq(0));

                    $('#category_box').append('<input type="hidden" name="category_select[]" value="' + Multiselect.$right.eq(0).val() + '" id="category_' + Multiselect.$right.eq(0).val() + '">');
                }
            }
        },
        moveToLeft: function (Multiselect, $options, event, silent, skipStack) {
            var button = $(event.currentTarget).attr('id');

            if (button == 'category_select_leftSelected') {
                var $right_options = Multiselect.$right.eq(0).find('> option:selected');
                Multiselect.$left.append($right_options);

                if (typeof Multiselect.callbacks.sort == 'function' && !silent) {
                    Multiselect.$left.find('> option').sort(Multiselect.callbacks.sort).appendTo(Multiselect.$left);

                    $('#category_' + Multiselect.$left.val()).remove();
                    $('.category_product_id option[custom_id=' + Multiselect.$left.val() + '], .multiselect_category li[custom_id=' + Multiselect.$left.val() + ']').remove();
                }
            }
        }
    });

    $('.category_product_id').multiSelect({
        selectableHeader: "<div class='custom-header'>Selectable items</div>",
        selectionHeader: "<div class='custom-header'>Selection items</div>",
    })

    $("#category_select_to").change(function () {

        var category_id = $(this).val();

        $.ajax({
            url: '<?php echo base_url(); ?>admin/frontend_setting/get_product_by_category',
            type: 'POST',
            dataType: "JSON",
            data: {category_id: category_id},
            success: function (response) {

                var category_selected_option = $('.category_product_id').children('.selected');

                var multi_select = $('#multi-selecter-category');

                multi_select.empty();

                multi_select.append('<select name="category_product_id[]" id="form-field-select-5" multiple="multiple" class="category_product_id form-control"></select>');

                var select = $('.category_product_id');

                var selected_id_array = new Array();

                if (category_selected_option.length != 0) {
                    var i = 0;
                    category_selected_option.each(function (e) {
                        var value = $(this).val();
                        var text = $(this).text();
                        var custom_id = $(this).attr('custom_id');
                        selected_id_array[i] = value;
                        i++;

                        select.append('<option selected="selected" custom_id="' + custom_id + '" id="category_option_' + value + '" value="' + value + '" class="selected">' + text + '</option>');
                    });
                }

                if (response.length != 0) {
                    $.each(response, function (i, fb) {
                        if (category_selected_option.length != 0) {
                            if (selected_id_array.indexOf(fb.product_id + '_' + fb.product_cat_id) > -1) {
                                return true;
                            }
                        }

                        console.log(fb);
                        select.append('<option custom_id="' + fb.product_cat_id + '" id="category_option_' + fb.product_id + '_' + fb.product_cat_id + '" value="' + fb.product_id + '_' + fb.product_cat_id + '">' + fb.product_title + '</option>');
                    });
                }

                $('.category_product_id').multiSelect({
                    selectableHeader: "<div class='custom-header'>Selectable items</div>",
                    selectionHeader: "<div class='custom-header'>Selection items</div>",
                    afterSelect: function (values) {
                        $('#category_option_' + values).addClass('selected');
                    },
                    afterDeselect: function (values) {
                        $('#category_option_' + values).removeClass('selected');
                    }
                })

                $('.multiselect_category .ms-selection li').css('display', 'none');
                $('.multiselect_category .ms-selection .ms-selected[custom_id="' + category_id + '"]').removeAttr('style');
            },
            error: function () {
                console.log('Error in retrieving Site.');
            }
        });
    });
    // end: Category Product

    /*********************************
     start: Feature Product
     *********************************/
    $('.featured_product_id').multiSelect({
        selectableHeader: "<div class='custom-header'>Selectable items</div>",
        selectionHeader: "<div class='custom-header'>Selection items</div>",
    })

    $('#featured_product').on('ifClicked', function (event) {
        if ($(this).is(":checked")) {
            //$('#category').removeAttr('disabled')
        } else {
            //$('#category').attr('disabled', 'disabled');

            //alert($('.multiselect_featured .ms-selectable .ms-list').html());
            //$('.multiselect_featured .ms-selectable .ms-list').attr('disabled', 'disabled');
        }
    })

    $("#category").change(function () {

        var category_id = $(this).val();

        $.ajax({
            url: '<?php echo base_url(); ?>admin/frontend_setting/get_product_by_category',
            type: 'POST',
            dataType: "JSON",
            data: {category_id: category_id},
            success: function (response) {

                var featured_selected_option = $('.featured_product_id').children('.selected');

                var multi_select = $('#multi-selecter-featured');

                multi_select.empty();

                multi_select.append('<select name="featured_product_id[]" id="form-field-select-4" multiple="multiple" class="featured_product_id form-control"></select>');

                var select = $('.featured_product_id');

                var selected_id_array = new Array();

                if (featured_selected_option.length != 0) {
                    var i = 0;
                    featured_selected_option.each(function (e) {
                        var value = $(this).val();
                        var text = $(this).text();
                        var custom_id = $(this).attr('custom_id');
                        selected_id_array[i] = value;
                        i++;

                        select.append('<option selected="selected" custom_id="' + custom_id + '" id="featured_option_' + value + '" value="' + value + '" class="selected">' + text + '</option>');
                    });
                }

                if (response.length != 0) {
                    $.each(response, function (i, fb) {
                        if (featured_selected_option.length != 0) {
                            if (selected_id_array.indexOf(fb.product_id + '_' + fb.product_cat_id) > -1) {
                                return true;
                            }
                        }

                        console.log(fb);
                        select.append('<option custom_id="' + fb.product_cat_id + '" id="featured_option_' + fb.product_id + '_' + fb.product_cat_id + '" value="' + fb.product_id + '_' + fb.product_cat_id + '">' + fb.product_title + '</option>');
                    });
                }

                $('.featured_product_id').multiSelect({
                    selectableHeader: "<div class='custom-header'>Selectable items</div>",
                    selectionHeader: "<div class='custom-header'>Selection items</div>",
                    afterSelect: function (values) {
                        $('#featured_option_' + values).addClass('selected');
                    },
                    afterDeselect: function (values) {
                        $('#featured_option_' + values).removeClass('selected');
                    }
                })
            },
            error: function () {
                console.log('Error in retrieving Site.');
            }
        });
    });
    // end: Feature Product
</script>

<style>
    .label_left {
        text-align: left !important;
    }
    .check_setting {
        padding-top: 6px;
    }
    .custom-header {
        background-color: #f5f5f5;
        font-weight: bold;
        padding: 5px;
        text-align: center;
    }
    .multiselect_featured .ms-container .ms-list, .multiselect_category .ms-container .ms-list {
        height: 193px;
    }
</style>