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
                        <h1 class="col-sm-6"><?php echo $page_title; ?></h1>
                        <div class="col-sm-6">							
							<?php if (($user_group == "Master Admin" || $user_group == "Manager") && $requisition['is_approved'] == 0){ ?>

                            <?php
								$attributes = array('role' => 'form', 'data-toggle' => 'validator', 'name' => 'changeApproveStatus', 'id' => 'changeApproveStatus');
								echo form_open('', $attributes);
							?>
							
								<label for="approve_reject">Approve / Reject</label>
							<?php
								  $dropdown_data = array(
											'id'            	  => 'approve_reject',
											'class'         	   => 'form-control',
											'required'	  		=> 'required',
											'data-required-error' => 'Select'
								  );
								  $approve_reject = array(
											$this->config->item('activeFlag')	  =>	'Approve',
											$this->config->item('inactiveFlag')	=>	'Reject'
										);
								  echo form_dropdown('approve_reject', $approve_reject, '', $dropdown_data);
                              ?>

							  <input type="hidden" name="requisition_id" value="<?php echo $requisition_id;?>" />
                              <button type="submit" class="btn btn-primary pull-right" id="changeApproveStatusButton">Change Status</button>
                            <?php echo form_close(); ?>
                            <?php } ?>
                            
                            <?php if ($requisition['is_approved'] != 0 && $requisition['is_approved'] != $this->config->item('inactiveFlag')) { ?>
                                <a href="<?php echo base_url()?>admin/requisition/generate_requisition_pdf/<?php echo $requisition_id;?>">
                                  <button type="button" class="btn btn-primary pull-right">Download Requisition</button>
                                </a>
                            <?php } ?>
                            
                            <?php if ($requisition['is_approved'] == 1 && $requisition['status'] == $this->config->item('activeFlag') && in_array($user_group, array("Master Admin", "Manager", "Logistics"))){ ?>
                              <a href="<?php echo base_url(); ?>admin/rfq/add/<?php echo $requisition_id;?>" class="btn btn-primary pull-right">Request for Quotation</a> 
                            <?php } ?>
                         </div>
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
                            Requisition Details
                        </div>
                        <div class="panel-body">
                          <table class="table table-bordered table-hover">
							<tr>
                              <td width="40%">Category</td>
                              <td><?php echo $requisition['category']; ?></td>
                            </tr>
                            <tr>
                              <td width="40%">Requisition #</td>
                              <td><?php echo $requisition['requisition_num']; ?></td>
                            </tr>
                            <tr>
                              <td>Purchasing Detail</td>
                              <td><?php echo $requisition['description']; ?></td>
                            </tr>
                            <tr>
                              <td>Date Requested</td>
                              <td><?php echo date('d-m-Y', strtotime($requisition['date_req'])); ?></td>
                            </tr>
                            <tr>
                              <td>Date Required Until</td>
                              <td><?php echo date('d-m-Y', strtotime($requisition['date_req_until'])); ?></td>
                            </tr>
                            <tr>
                              <td>Project</td>
                              <td><?php echo $requisition['project_name']; ?></td>
                            </tr>
                            <tr>
                              <td>Budget Head</td>
                              <td><?php echo $requisition['budget_head']; ?></td>
                            </tr>
                            <tr>
                              <td>Location</td>
                              <td><?php echo $requisition['location_name']; ?></td>
                            </tr>
                            <tr>
                              <td>Donor</td>
                              <td><?php echo $requisition['donor_name']; ?></td>
                            </tr>
                            <tr>
                              <td>Approving Authority</td>
                              <td><?php echo $requisition['approving_authority']; ?></td>
                            </tr>
                            <tr>
                              <td>Approval Status</td>
                              <td><?php 
							  	if ($requisition['is_approved'] == 1) {
									echo 'Approved';
								}
								else if ($requisition['is_approved'] == 2) {
									echo 'Rejected';
								}
								else {
									echo 'Not Approved';
								}
								?></td>
                            </tr>
                            <tr>
                              <td>Status</td>
                              <td><?php 
							  	if ($requisition['status'] == $this->config->item('activeFlag')) {
									echo 'Approved';
								}
								else if ($requisition['status'] == $this->config->item('inactiveFlag')) {
									echo 'Rejected';
								}
								else if ($requisition['status'] == $this->config->item('sentFlag')) {
									echo 'RFQ Created';
								}
								else if ($requisition['status'] == $this->config->item('receivedFlag')) {
									echo 'Received';
								}
								else {
									echo '-';
								}
								?></td>
                            </tr>
                            <tr>
                              <td><strong>Total of Items</strong></td>
                              <td><strong><?php echo $requisition['total_price']; ?></strong></td>
                            </tr>
                          </table>
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
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-external-link-square"></i>
                            Requisition Items
                        </div>
                        <div class="panel-body">
                            <?php
                            $attributes = array('class' => 'form-horizontal', 'role' => 'cat_form', 'id' => 'cat_form');
                            echo form_open(current_url(), $attributes);
                            ?>
                            <table class="table table-striped table-bordered table-hover" id="itemsDataTable">
                                
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
	
    var items = <?php echo json_encode($requisition['items']); ?>;
	var items_array = [];
	var indx;
	var showItemCol = ['s.no', 'item_name', 'item_desc', 'cost_center', 'unit', 'quantity', 'unit_price', 'total_item_price'];
	for (i = 0; i < items.length; i++) {
		var item_array = [];
		item_array[0] = i+1;
		$.map(items[i], function(value, index) {
			indx = showItemCol.indexOf(index)
			if (indx < 0) {
				return;
			}
			item_array[indx] = value;
			return true;
		});
		items_array[i] = item_array;
	}console.log(items_array);
	
    $(function () {
        $('#itemsDataTable').DataTable({
            "data": items_array,
            "order": [[ 0, "asc" ]],
            "columnDefs": [
                { "orderable": false, "targets": 0 },
                //{ "orderable": false, "targets": 1 },
                { "orderable": false, "targets": 2 },
                { "orderable": false, "targets": 7 }
            ],
            "columns": [
				{ title: "S.No." },
				{ title: "Item Name" },
				{ title: "Item Description" },
				{ title: "Cost Center" },
				{ title: "Unit" },
				{ title: "Quantity", "width": "11%" },
				{ title: "Estimated Unit Value (Rs)"},
				{ title: "Estimated Total Unit Value (Rs)" }
        	],
            "pageLength": 20,
            "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
            "initComplete": function(settings, json) {
                //alert( 'DataTables has finished its initialisation.' );
                $(".group1").colorbox();
            }
        });
    });
</script>
