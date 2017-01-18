<!-- start: MAIN CONTAINER -->
<div class="main-container">
    <!-- start: PAGE -->
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
                <!-- start: Success and error message -->
                <?php if (!empty($message)) { ?>
                    <div id="message">
                        <?php echo $message; ?>
                    </div>
                <?php } ?>
                <!-- end: Success and error message -->
                <div class="page-header">
                    <h1><?php echo $page_title; ?></h1>
                </div>
                <!-- end: PAGE TITLE & BREADCRUMB -->
            </div>
        </div>
        <!-- end: PAGE HEADER -->
        
        <!-- start: PAGE CONTENT -->
        <div class="row">
            <div class="col-sm-4">
                <div class="core-box">
                    <div class="heading">
                        <i class="clip-user-4 circle-icon circle-green"></i>
                        <h2>eProcurement App</h2>
                    </div>
                    <div class="content">
                        This app allows you to Create and Track Procurement Processes.
                    </div>
                    <a class="view-more" href="<?php echo base_url(); ?>auth_admin">
                        Go to App <i class="clip-arrow-right-2"></i>
                    </a>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="core-box">
                    <div class="heading">
                        <i class="clip-clip circle-icon circle-teal"></i>
                        <h2>School Management App</h2>
                    </div>
                    <div class="content">
                        Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt.
                    </div>
                    <a class="view-more" href="#">
                        Go to App <i class="clip-arrow-right-2"></i>
                    </a>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="core-box">
                    <div class="heading">
                        <i class="clip-database circle-icon circle-bricky"></i>
                        <h2>Reporting App</h2>
                    </div>
                    <div class="content">
                        Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh.
                    </div>
                    <a class="view-more" href="#">
                        Go to App <i class="clip-arrow-right-2"></i>
                    </a>
                </div>
            </div>
        </div>
        
    </div>
    <!-- end: PAGE -->
</div>
<!-- end: MAIN CONTAINER -->

<!-- statr: INCLUSE FOOTER -->
<?php $this->load->view('admin/includes/footer'); ?>
<!-- end: INCLUSE FOOTER -->

<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
<link rel="stylesheet" href="<?php echo $includes_dir; ?>admin/plugins/fullcalendar/fullcalendar/fullcalendar.css">
<link rel="stylesheet" href="<?php echo $includes_dir; ?>admin/plugins/select2/select2.css" />
<link rel="stylesheet" href="<?php echo $includes_dir; ?>admin/plugins/datatables/dataTables.bootstrap.css">
<!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->

<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->

<script src="<?php echo $includes_dir; ?>admin/plugins/select2/select2.min.js"></script>
<script src="<?php echo $includes_dir; ?>admin/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo $includes_dir; ?>admin/plugins/datatables/media/js/DT_bootstrap.js"></script>
<script src="<?php echo $includes_dir; ?>admin/js/table-data.js"></script>
<script src="<?php echo $includes_dir; ?>admin/js/highcharts.js"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->


<script>
    jQuery(document).ready(function () {
        Main.init();
        TableData.init();
        jQuery("#dashboard_paginate").hide();
    });
    
    
    $(function () {
                /*var chart = new Highcharts.Chart({
                    chart: {
                        renderTo: 'container',
                        type: 'line',
                        title: 'please select a category'
                    },
                    credits: {
                        enabled: false
                        },
                    tooltip: {
                        formatter: function () {
                            return this.point.tooltipData;
                            }
                        }
                    });


                chart.addSeries({
                            name: 'Order By Month(s) <?php echo date('Y'); ?>',
                            type: 'column',
                            color: '#7FCDBB',
                            //data: [100, 280, 300, 490, 670, 900, 100, 200, 300, 400, 500, 100]
                            data:[<?php echo $tooltipMonth; ?>]
                        });

                        chart.yAxis[0].setTitle({text: "#Orders"});
                        chart.setTitle({text: "Sales chart of Order"});
                        chart.xAxis[0].setCategories(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']);

                $("#chartType").change(function () {
                    value = $(this).val();
                    while (chart.series.length > 0) {
                        chart.series[0].remove(true);
                    }
                    console.log("Value : " + value)
                    if (value == 'y') {
                        chart.addSeries({
                            name: 'Order By Year(s)',
                            type: 'column',
                            color: '#ffcc99',
                            data: [<?php echo $tooltipYear; ?>]
                        
                        });
                        chart.yAxis[0].setTitle({text: "#Orders"});
                        chart.xAxis[0].setCategories([<?php if(count($get_graph_year)>0){foreach ($get_graph_year as $graph_year) {echo $graph_year['year'].",";}} ?>]);
                        chart.setTitle({text: "Sales chart of Order"});

                    } else if (value == 'm') {
                        chart.addSeries({
                            name: 'Order By Month(s) <?php echo date('Y'); ?>',
                            type: 'column',
                            color: '#7FCDBB',
                            //data: [100, 280, 300, 490, 670, 900, 100, 200, 300, 400, 500, 100]
                            data:[<?php echo $tooltipMonth; ?>]
                        });

                        chart.yAxis[0].setTitle({text: "#Orders"});
                        chart.setTitle({text: "Sales chart of Order"});
                        chart.xAxis[0].setCategories(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']);
                        
                    } else if (value == 'd') {
                        chart.addSeries({
                            name: 'Order By Day(s) <?php echo date('F Y'); ?>',
                            type: 'column',
                            color: '#FCC5C0',
                            data: [<?php echo $tooltipDay; ?>]
                        });
                        chart.yAxis[0].setTitle({text: "#Orders"});
                        chart.setTitle({text: "Sales chart of Order"});
                        chart.xAxis[0].setCategories([<?php if(count($get_graph_day)>0){foreach ($get_graph_day as $key => $graph_day) {echo $key.",";}} ?>]);

                    } */ /*else {
                        chart.addSeries({
                            name: 'Order By Year(s)',
                            type: 'column',
                            color: '#ffcc99',
                            data: [100, 0, 200, 0, 300, 100, 400, 100, 500, 200, 500, 300]});
                        chart.xAxis[0].setCategories(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']);
                        chart.yAxis[0].setTitle({text: "#Orders"});
                        chart.setTitle({text: "Sales chart of completed order"});
                    }*/
                /*});*/
            });


    
</script>