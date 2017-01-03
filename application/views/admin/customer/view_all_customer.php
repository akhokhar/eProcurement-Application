
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
                        <h1 class="col-sm-6">Customers <small>view all customers</small></h1>
                        <!-- start: ADD NEW CATEGORY -->
                        <?php if ($this->flexi_auth->is_privileged('Add Order')) { ?>
                            <div class="col-md-2 pull-right">
                                <a class="btn btn-teal btn-block" href="<?php echo $base_url; ?>admin/customer/add_customer">
                                    Add Customer
                                </a>
                            </div>
                        <?php } ?>
                        <!-- end: ADD NEW CATEGORY -->
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
                            Search Customer
                        </div>
                        <?php
                        $attributes = array('class' => 'form-horizontal', 'role' => 'cat_form', 'id' => 'search_form');
                        echo form_open($base_url . 'admin/customer', $attributes);
                        ?>
                        <div class="panel-body">
                            <div class="form-group col-md-3">
                                <label class="col-sm-6 control-label" for="form-field-1">
                                    Customer ID
                                </label>
                                <div class="col-sm-6">
                                    <?php
                                    $input_data = array(
                                        'type' => 'text',
                                        'name' => 'customer_id',
                                        'id' => 'customer_id',
                                        'value' => set_value('customer_id'),
                                        'class' => 'form-control',
                                        'placeholder' => ''
                                    );

                                    echo form_input($input_data);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="col-sm-5 control-label" for="form-field-1">
                                    Customer Name
                                </label>
                                <div class="col-sm-7">
                                    <?php
                                    $input_data = array(
                                        'type' => 'text',
                                        'name' => 'cus_customer_first_name',
                                        'id' => 'cus_customer_first_name',
                                        'value' => set_value('cus_customer_first_name'),
                                        'class' => 'form-control',
                                        'placeholder' => ''
                                    );

                                    echo form_input($input_data);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="col-sm-6 control-label" for="form-field-1">
                                    Customer Cell#
                                </label>
                                <div class="col-sm-6">
                                    <?php
                                    $input_data = array(
                                        'type' => 'text',
                                        'name' => 'customer_contact',
                                        'id' => 'customer_contact',
                                        'value' => set_value('customer_contact'),
                                        'class' => 'form-control',
                                        'placeholder' => ''
                                    );

                                    echo form_input($input_data);
                                    ?>
                                </div>
                            </div>                                
                            
                            <div class="form-group col-md-2 pull-right">
                                <div class="col-sm-12">
                                    <button id="search_btn" class="btn btn-info btn-block" type="submit">
                                        Search <i class="fa fa-search"></i>
                                    </button>
                                    <input type="hidden" name="search_form" value="search_form">
                                </div>
                            </div>
                        </div>

                        <?php echo form_close(); ?>
                    </div>
                    <!-- end: TEXT FIELDS PANEL -->
                </div>
            </div>
            <!-- end: PAGE CONTENT-->


            <!-- start: PAGE CONTENT -->
            <div class="row">
                <div class="col-md-12">
                    <!-- start: BASIC TABLE PANEL -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-external-link-square"></i>
                            Customers
                        </div>
                        <div class="panel-body">
                            <?php
                            $attributes = array('class' => 'form-horizontal', 'role' => 'cat_form', 'id' => 'cat_form');
                            echo form_open(current_url(), $attributes);
                            ?>
                            <table class="table table-striped table-bordered table-hover" id="customer_table">
                                <thead>
                                    <tr>
                                        <th class="center">
                                            <div class="checkbox-table">
                                                <!--<label>
                                                    <input type="checkbox" class="flat-grey">
                                                </label>-->
                                            </div>
                                        </th>
                                        <th>Customer ID</th>
                                        <th class="hidden-xs">Customer Name</th>
                                        <th class="hidden-xs">Customer Email</th>
                                        <th class="hidden-xs">Customer Cell#</th>
                                        <th class="hidden-xs">Customer Address</th>
                                        <th class="hidden-xs">Join Date</th>
                                        <th class="center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                            <?php if($checkbox_disabled==1){ ?>
                            <div class="form-group col-md-2 pull-left">
                            <input type="submit" id="delete" name="delete" value="Delete Records" class="btn btn-info btn-block"/>
                            </div>
                            <?php } ?>
                            <?php form_close(); ?>
                        </div>
                    </div>
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
<link rel="stylesheet" href="<?php echo $includes_dir; ?>admin/plugins/datatables/dataTables.bootstrap.css">
<link rel="stylesheet" type="text/css" href="<?php echo $includes_dir; ?>admin/plugins/datetimepicker/jquery.datetimepicker.css"/>
<!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->

<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script src="<?php echo $includes_dir; ?>admin/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="<?php echo $includes_dir; ?>admin/js/form-validation-js.js"></script>
<script type="text/javascript" src="<?php echo $includes_dir; ?>admin/plugins/select2/select2.min.js"></script>
<script src="<?php echo $includes_dir; ?>admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo $includes_dir; ?>admin/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo $includes_dir; ?>admin/plugins/datetimepicker/build/jquery.datetimepicker.full.js"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->

<style>
    
    .edit_btn {
        margin-right: 5px;
    }
    
</style>

<script>
    //Date picker 
    $('.datepicker').datetimepicker({
        timepicker:false,
        format: 'd-m-Y',
    });
    
    jQuery(document).ready(function () {
        Main.init();
        FormValidator.init();
        
        jQuery("#delete").prop('disabled', true);
        var deleteClicks = 0;
        
        jQuery('body').on('ifChecked', function(event){
                deleteClicks++;
                if(deleteClicks > 1){
                jQuery("#delete").prop('disabled', false);
                }else{
                jQuery("#delete").prop('disabled', true);
           }
        });
        
        jQuery('body').on('ifUnchecked', function(event){ 
                deleteClicks--;
                if(deleteClicks > 1){
                jQuery("#delete").prop('disabled', false);
                }else{
                jQuery("#delete").prop('disabled', true);
           }
        });
        
    });
    
    $(function () {
        $('#customer_table').DataTable({
            "processing": true,
            "serverSide": true,
            "searching": false,
            "ajax": {
                "url": "<?php echo $base_url; ?>admin/server_datatables/get_customers",
                "type": "POST",
                "data": function ( d ) {
                    var top_search_like = {
                        value_customer_id: $('#customer_id').val(),
                        cus_customer_name: $('#cus_customer_first_name').val(),
                        value_customer_contact_no: $('#customer_contact').val(),
                    };
                    
                    var top_search = {
                        order_order_status: $('#customer_status').val()
                    };
                    
                    d.top_search_like = top_search_like;
                    d.top_search = top_search;
                }
            },
            "order": [[ 1, "asc" ]],
            "columnDefs": [
                { "orderable": false, "targets": 0 },
                { "orderable": false, "targets": 6 },
                { "orderable": false, "targets": 7 },
                //{ "orderable": false, "targets": 9 }
            ],
            "columns": [
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                { "width": "11%" }
            ],
            "pageLength": 20,
            "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
            "initComplete": function(settings, json) {
                //alert( 'DataTables has finished its initialisation.' );
                //$(".group1").colorbox();
            }
        }).on( 'draw', function () {
            $('tr td:nth-child(1), tr td:nth-child(8)').each(function (){
                  $(this).addClass('center')
            })
            
            $('input[type="checkbox"].flat-grey, input[type="radio"].flat-grey').iCheck({
                checkboxClass: 'icheckbox_flat-grey',
                radioClass: 'iradio_flat-grey',
                increaseArea: '10%' // optional
            });
            if($(".tooltips").length) {$('.tooltips').tooltip();}
        });
    });
</script>
