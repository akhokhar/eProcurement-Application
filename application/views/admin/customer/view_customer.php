
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
                    <?php if (!empty($this->session->flashdata('message'))) { ?>
                        <div id="message">
                            <?php echo $this->session->flashdata('message'); ?>
                        </div>
                    <?php } ?>
                    <!-- end: Success and error message -->
                    <div class="page-header row">
                        <h1 class="col-sm-3 pull-left">Customer # <?php echo $get_customer['customer_id']; ?></h1>
                        <div class="col-md-5 pull-right">
                            <div class="col-md-4 pull-right">
                                <a class="btn btn-teal btn-block" href="<?php echo $base_url; ?>admin/customer/edit_customer/<?php echo $get_customer['customer_id']; ?>">
                                    Edit Customer
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- end: PAGE TITLE & BREADCRUMB -->
                </div>
            </div>
            <!-- end: PAGE HEADER -->

            
            <div class="row">
                <div class="col-sm-12">
                    <!-- start: INLINE TABS PANEL -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-reorder"></i>
                            Customer Information
                        </div>
                        <table width="100%" cellspacing="2" cellpadding="4" border="2" id="" class="table table-striped table-bordered table-hover">

                            <tr>
                                <th>Customer Name</th>
                                <td><?php echo $get_customer['customer_first_name'] . " " . $get_customer['customer_last_name']; ?></td>
                            </tr>
                            <tr>
                                <th>Customer Email</th>    
                                <td><?php echo $get_customer['customer_email']; ?></td>
                            </tr>

                            <tr>
                                <th>Customer Cell#</th>    
                                <td><?php echo $get_customer['customer_contact_no']; ?></td>
                            </tr>

                            <tr>
                                <th>Customer Address</th>
                                <td><?php echo $get_customer['customer_address']; ?></td>
                            </tr>

                            <tr>
                                <th>Join Date</th>
                                <td><?php echo date("d-m-Y", strtotime($get_customer['created_date'])); ?></td>
                            </tr>

                        </table>
                    </div>
                    <!-- end: INLINE TABS PANEL -->
                </div>
            </div>
            
            
            <div class="row">
                <div class="col-sm-12">
                    <!-- start: INLINE TABS PANEL -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-reorder"></i>
                            Customer Orders
                        </div>
                        <?php if(!empty($orders)){ ?>
                        <div class="panel-body">
                        <table class="table table-striped table-bordered table-hover" id="sample_1">

                            <thead>
                            <tr>
                            <th>Order ID</th>
                            <th>Order Date</th>
                            <th>Total Amount</th>
                            <th>Order Status</th>
                            <th>SMS Status</th>
                            <th class="center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php foreach($orders as $get_orders){ ?>
                                <tr>
                                    <td><?php echo $get_orders['order_id']; ?></td>
                                    <td><?php echo date("d-m-Y",  strtotime($get_orders['order_created_date'])); ?></td>
                                    <td><?php echo number_format($get_orders['prod_ordered_total']); ?></td>
                                    <td><?php echo $get_orders['status_name']; ?></td>
                                    <td><?php echo $get_orders['order_sms_status']; ?></td>
                                    <td class="center"><a href="<?php echo base_url().'admin/order/view_detail/'.$get_customer['customer_id'].'/'. $get_orders['order_id'] ?>" class="edit_btn btn btn-xs btn-teal tooltips" data-placement="top" data-original-title="View"><i class="fa fa-arrow-circle-right"></i></a></td>
                                </tr>
                                <?php } ?>
                            </tbody>

                        </table>
                        <?php }else{ ?>
                        <table class="table table-striped table-bordered table-hover">
                            <tr>
                                <td>
                                    <div class="col-sm-12 red">
                                        No Order to Display
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <?php } ?>
                        </div>
                    </div>
                    <!-- end: INLINE TABS PANEL -->
                </div>
            </div>
            <!--/Middle Row 2 End/-->
        </div>
        <!--end: container-->
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

<script>
    jQuery(document).ready(function () {
        $('.next_tab').click(function () {
            var href = $(this).attr('href');
            $('#myTab').children('li').removeClass('active');
            $('a[href=' + href + ']').parent('li').addClass('active');
        });

        Main.init();
        FormValidator.init();
        $('#sample_1').DataTable();
    });
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
    .btn-space{
        padding-right:5px;
        float:left;
    }
    
    .right{
        text-align: right !important;
    }
</style>