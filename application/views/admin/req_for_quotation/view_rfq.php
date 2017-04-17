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
							<a href="<?php echo base_url()?>admin/rfq/generate_rfq_pdf/<?php echo $quotation['rfq_id'];?>">
							  <button type="button" class="btn btn-primary pull-right">Download Quotation</button>
							</a>
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
                            Quotation Details
                        </div>
                        <div class="panel-body">
                          <table class="table table-bordered table-hover">
                            <tr>
                              <td width="40%">Rfq #</td>
                              <td><?php echo $quotation['rfq_num']; ?></td>
                            </tr>
                            <tr>
                              <td>Rfq Date</td>
                              <td><?php echo date('d-m-Y', strtotime($quotation['rfq_date'])); ?></td>
                            </tr>
                            <tr>
                              <td>Due Date</td>
                              <td><?php echo date('d-m-Y', strtotime($quotation['due_date'])); ?></td>
                            </tr>
                            <?php /*?><tr>
                              <td>Unit Rate</td>
                              <td><?php echo $quotation['unit_rate']; ?></td>
                            </tr><?php */?>
                            <tr>
                              <td>Vendor</td>
                              <td>
							  <?php foreach ($vendors as $vends) { ?>
                              	<?php foreach ($vends as $id => $vendor) { ?>
								  <?php if ($id == 0) { continue; }?>
                                  <?php echo $vendor; ?><br />
                                <?php } ?>
                              <?php } ?>
                              </td>
                            </tr>
							<tr>
                              <td>Description</td>
                              <td><?php echo $quotation['description']; ?></td>
                            </tr>
                            
                          </table>
                          <?php if ($quotation['status'] == $this->config->item('activeFlag')) { ?>             
                            <a href="<?php echo base_url()?>admin/rfq/change_rfq_status/<?php echo $quotation['rfq_id'];?>/<?php echo $this->config->item('sentFlag');?>">
                              <button type="button" class="btn btn-success pull-right">Sending Quotations? Click here</button>
                            </a>
						  <?php }
						  else if ($quotation['status'] == $this->config->item('sentFlag')) { ?>             
                            <a href="<?php echo base_url()?>admin/rfq/change_rfq_status/<?php echo $quotation['rfq_id'];?>/<?php echo $this->config->item('receivedFlag');?>">
                              <button type="button" class="btn btn-success pull-right">Quotations Received? Click here</button>
                            </a>
						  <?php }
						  else if ($quotation['status'] == $this->config->item('receivedFlag')) { ?>             
                            <a href="<?php echo base_url()?>admin/comparative_quotation/add/<?php echo $quotation['rfq_id'];?>/">
                              <button type="button" class="btn btn-success pull-right">Add to Comparative</button>
                            </a>
						  <?php } ?>
                        </div>
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
