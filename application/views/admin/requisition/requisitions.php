
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
                        <h1 class="col-sm-6">View all Requisitions</h1>
                        <!-- start: ADD NEW PRODUCT -->
                        <?php if ($this->flexi_auth->is_privileged($add_product)) { ?>
                            <div class="col-md-2 pull-right">
                                <a class="btn btn-teal btn-block" href="<?php echo $base_url; ?>admin/requisition/add">
                                    Add New Requisition
                                </a>
                            </div>
                        <?php } ?>
                        <!-- end: ADD NEW PRODUCT -->
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
                            Search Requisition(s)
                            
                        </div>
                        <?php
                        $attributes = array('class' => 'form-horizontal', 'role' => 'requisitionForm', 'id' => 'search_form');
                        //echo form_open($base_url.'admin/search/product_search', $attributes);
                        echo form_open(current_url(), $attributes);
                        ?>
                            <div class="panel-body">
                                <div class="form-group col-md-4">
                                    <label class="col-sm-5 control-label" for="requisitionDate">
                                        Requisition Date
                                    </label>
                                    <div class="col-sm-7">
                                        <div class="input-group date">
                                          <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                          </div>
											<?php
                                            $input_data = array(
                                                    'type'          => 'text',
                                                    'name'          => 'requisitionDate',
                                                    'id'            => 'requisitionDate',
                                                    'value'         => set_value('requisitionDate'),
                                                    'class'         => 'form-control pull-right datepicker',
                                                    'placeholder'   => 'DD/MM/YYYY'
                                            );
    
                                            echo form_input($input_data);
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="col-sm-4 control-label" for="requiredUntilDate">
                                        Until Date
                                    </label>
                                    <div class="col-sm-8">
                                        <div class="input-group date">
                                          <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                          </div>
                                          <?php
                                          $input_data = array(
                                                    'type'          => 'text',
                                                    'name'          => 'requiredUntilDate',
                                                    'id'            => 'requiredUntilDate',
                                                    'value'         => set_value('requiredUntilDate'),
                                                    'class'         => 'form-control pull-right datepicker',
                                                    'placeholder'   => 'DD/MM/YYYY'
                                          );
                                          echo form_input($input_data);
                                          ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="col-sm-4 control-label" for="approvingAuthority">
                                        Approving Authority
                                    </label>
                                    <div class="col-sm-8">
										<?php
                                          $dropdown_data = array(
                                                    'id'            => 'approvingAuthority',
                                                    'class'         => 'form-control select2'
                                          );
                                          $approvingAuthorities = array(
                                                    ''              => 'Select',
                                                    'Manager 1'     => 'Manager 1',
                                                    'Manager 2'	 => 'Manager 2',
                                                    'Manager 3'	 => 'Manager 3'
                                          );
                                          echo form_dropdown('approvingAuthority', $approvingAuthorities, '', $dropdown_data);
                                          ?>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="col-sm-3 control-label" for="location">
                                        Location
                                    </label>
                                    <div class="col-sm-9">
                                        <?php
										  $dropdown_data = array(
													'id'            => 'location',
													'class'         => 'form-control select2'
										  );
										  echo form_dropdown('location', $locations, '', $dropdown_data);
										  ?>
                                    </div>
                                </div>
                                
                                <div class="form-group col-md-3">
                                    <label class="col-sm-4 control-label" for="project">
                                        Project
                                    </label>
                                    <div class="col-sm-8">
                                        <?php
										  $dropdown_data = array(
													'id'            => 'project',
													'class'         => 'form-control select2'
										  );
										  echo form_dropdown('project', $projects, '', $dropdown_data);
										  ?>
                                    </div>
                                    
                                </div>
                                
                                <div class="form-group col-md-3">
                                    <label class="col-sm-3 control-label" for="donor"> 
                                        Donor 
                                    </label>
                                    <div class="col-sm-9">
                                        <?php
										  $dropdown_data = array(
													'id'            	  => 'donor',
													'class'         	   => 'form-control select2'
										  );
										  echo form_dropdown('donor', $donors, '', $dropdown_data);
										  ?>
                                    </div>
                                </div>
                                
                                
                                <div class="form-group col-md-2 pull-right">
                                    <div class="col-sm-12">
                                        <button id="search_btn" class="btn btn-info btn-block" type="submit">
                                            Search <i class="fa fa-search"></i>
                                        </button>
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
                            Requisition(s)
                            
                        </div>
                        <div class="panel-body">
                            <?php
                            $attributes = array('class' => 'form-horizontal', 'role' => 'cat_form', 'id' => 'cat_form');
                            echo form_open(current_url(), $attributes);
                            ?>
                            <table class="table table-striped table-bordered table-hover" id="requisition_table">
                                <thead>
                                    <tr>
                                        <th class="center">
                                            <!--<div class="checkbox-table">
                                                <label>
                                                    <input type="checkbox" class="flat-grey">
                                                </label>
                                            </div>--></th>
                                        <th class="center">Requisition#</th>
                                        <th class="center">Date Requested</th>
                                        <th class="center">Needed Till</th>
                                        <th class="center">Project</th>
                                        <th class="hidden-xs">Location</th>
                                        <th class="hidden-xs">Donor</th>
                                        <th class="hidden-xs">Approving Authority</th>
                                        <th class="center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                            <?php if($checkbox_disabled!=""){ ?>
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
<?php /* ?><link rel="stylesheet" href="<?php echo $includes_dir; ?>admin/plugins/DataTables_16082016/media/css/DT_bootstrap.css" /><?php */ ?>

<link rel="stylesheet" href="<?php echo $includes_dir; ?>admin/plugins/datatables/dataTables.bootstrap.css">
<link rel="stylesheet" href="<?php echo $includes_dir; ?>admin/plugins/colorbox/example1/colorbox.css" />
<!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->

<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script src="<?php echo $includes_dir; ?>admin/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="<?php echo $includes_dir; ?>admin/js/form-validation-js.js"></script>
<script type="text/javascript" src="<?php echo $includes_dir; ?>admin/plugins/select2/select2.min.js"></script>
<?php /* ?><script type="text/javascript" src="<?php echo $includes_dir; ?>admin/plugins/DataTables_16082016/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo $includes_dir; ?>admin/plugins/DataTables_16082016/media/js/DT_bootstrap.js"></script>
<script src="<?php echo $includes_dir; ?>admin/js/table-data.js"></script><?php */ ?>

<script src="<?php echo $includes_dir; ?>admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo $includes_dir; ?>admin/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo $includes_dir; ?>admin/plugins/colorbox/jquery.colorbox.js"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->

<style>
    
    .edit_btn {
        margin-right: 5px;
    }
    
</style>

<script>
    jQuery(document).ready(function () {
        
        Main.init();
        FormValidator.init();
        //PagesGallery.init();
        //TableData.init();
        
        
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
        $('#requisition_table').DataTable({
            "processing": true,
            "serverSide": true,
            "searching": false,
            "ajax": {
                "url": "<?php echo base_url(); ?>admin/server_datatables/get_requisition",
                "type": "POST",
                "data": function ( d ) {
                    var top_search_like = {
                        prod_product_title: $('#product_title').val(),                        
                        prod_product_model: $('#product_model').val()
                    };
                    
                    var top_search = {
                        prod_product_cat_id: $('#product_cat_id').val(),
                        prod_product_org_price: $('#product_org_price').val(),
                        prod_product_status: $('#product_status').val(),
                        prod_product_featured: $('#product_featured').val(),
                        prod_product_tag_image: $('#product_tag_image').val()
                    };
                    
                    d.top_search_like = top_search_like;
                    d.top_search = top_search;
                }
            },
            "order": [[ 1, "desc" ]],
            "columnDefs": [
                { "orderable": false, "targets": 0 },
                //{ "orderable": false, "targets": 1 },
                { "orderable": false, "targets": 2 },
                { "orderable": false, "targets": 5 }
            ],
            "columns": [
                null,
                null,
                null,
				null,
                null,
                null,
                null,
                null,
                null
            ],
            "pageLength": 20,
            "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
            "initComplete": function(settings, json) {
                //alert( 'DataTables has finished its initialisation.' );
                $(".group1").colorbox();
            }
        }).on( 'draw', function () {
            $('tr td:nth-child(1), tr td:nth-child(3), tr td:nth-child(7)').each(function (){
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
