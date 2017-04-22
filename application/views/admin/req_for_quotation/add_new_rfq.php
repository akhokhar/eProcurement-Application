
<!-- Date Picker -->
<link rel="stylesheet" href="<?php echo $includes_dir; ?>admin/plugins/datepicker/datepicker3.css">
<!-- Select2 -->
<link rel="stylesheet" href="<?php echo $includes_dir; ?>admin/plugins/select2/select2.min.css">

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
                    <!-- end: Success and error message -->
                    <div class="page-header row">
                        <h1 class="col-sm-6"><?php echo $page_title; ?> <small></small></h1>
                    </div>
                    
                    <!-- end: PAGE TITLE & BREADCRUMB -->
                </div>
            </div>
            <!-- end: PAGE HEADER -->
            <!--Error and success messages-->
            <div id="message" class="alert no-display"></div>
                <!-- start: PAGE CONTENT -->
                <div class="row">
                    <div class="col-sm-12">
                        <!-- start: PANLEL TABS -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-reorder"></i>
                                RFQ Details
                            </div>
                            <div class="panel-body">
										<?php
                                        $attributes = array('class' => '', 'method' => 'post', 'role' => 'form', 'id' => 'rfqForm');
                                        echo form_open_multipart('', $attributes);
                                        ?>
                                            <div class="panel-body">
                                              <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="rfqDate">
                                                            RFQ Date <span class="symbol required"></span>
                                                        </label>
                                                        <div class="input-group date">
                                                          <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                          </div>
                                                          <?php
                                                          $input_data = array(
                                                                    'type'          		=> 'text',
                                                                    'name'         		=> 'rfqDate',
                                                                    'id'            	  => 'rfqDate',
																	'required'	  		=> 'required',
                                                                    'data-required-error' => 'RFQ Date cannot be empty',
                                                                    'value'         	   => set_value('rfqDate'),
                                                                    'class'         	   => 'form-control pull-right datepicker',
                                                                    'placeholder'   		 => 'DD/MM/YYYY'
                                                          );
                                                          echo form_input($input_data);
                                                          ?>
                                                        </div>
                                                    </div>        
                                                    <div class="form-group">
                                                      <label for="refNumber">Ref#</label>
                                                         <?php
														 $req_num = $req_num ? $req_num : set_value('refNumber');
                                                          $input_data = array(
                                                                    'type'          => 'text',
                                                                    'name'          => 'refNumber',
                                                                    'id'            => 'refNumber',
																	'readonly'	  => 'readonly',
                                                                    'value'         => $req_num,
                                                                    'class'         => 'form-control',
                                                                    'placeholder'   => $req_num
                                                          );
                                                          echo form_input($input_data);
                                                          ?>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="total_price">Total Price</label>
                                                         <?php
                                                          $input_data = array(
                                                                    'type'          => 'number',
                                                                    'name'          => 'total_price',
                                                                    'id'            => 'total_price',
																	'disabled'	  => true,
                                                                    'value'         => $requisition['total_price'],
                                                                    'class'         => 'form-control'
                                                          );
                                                          echo form_input($input_data);
                                                          ?>
                                                    
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="rfqDueDate">
                                                        	Quotation Due Date <span class="symbol required"></span>
                                                        </label>
                                                        <div class="input-group date">
                                                          <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                          </div>
														  <?php
                                                          $input_data = array(
                                                                    'type'          => 'text',
                                                                    'name'          => 'rfqDueDate',
                                                                    'id'            => 'rfqDueDate',
																	'required'	  => 'required',
                                                                    'data-required-error' => 'RFQ Due Date cannot be empty',
                                                                    'value'         => set_value('rfqDueDate'),
                                                                    'class'         => 'form-control pull-right datepicker',
                                                                    'placeholder'   => 'DD/MM/YYYY'
                                                          );
                                                          echo form_input($input_data);
                                                          ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="vendors">
                                                        	Vendors <span class="symbol required"></span>
                                                        </label>
                                                        <?php
                                                          $dropdown_data = array(
                                                                    'id'            => 'vendors',
                                                                    'class'         => 'form-control select2',
                                                                    'required'	  => 'required',
																	'multiple'	  => 'multiple',
                                                                    'data-required-error' => 'Select 3 Vendors'
                                                          );
														  echo form_dropdown('vendors[]', $vendors, '', $dropdown_data);
                                                          ?>
                                                    </div>
                                                </div>
                                              </div>
                                              <hr />
                                              <div class="row">
                                                <div class="col-md-2 pull-right">
                                                    <!--<a href="#panel_tab_items" data-toggle="tab" class="btn btn-teal ladda-button next_tab">
                                                        Next <i class="fa fa-arrow-circle-right"></i>
                                                    </a>-->
                                                    <div class="col-md-2 pull-right">
                                                        <button type="submit" class="btn btn-primary pull-right" id="newRfqButton">Create RFQ</button>
                                                    </div>
                                                </div>
                                              </div>
                                          </div> 
                            			<?php echo form_close(); ?>
                                     
                            </div>
                        </div>
                        <!-- end: PANLEL TABS -->
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
<link href="<?php echo $includes_dir; ?>admin/plugins/lou-multi-select/css/multi-select.css" media="screen" rel="stylesheet" type="text/css">

<link rel="stylesheet" href="<?php echo $includes_dir; ?>admin/plugins/jQuery-Tags-Input/jquery.tagsinput.css">
<!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->

<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script src="<?php echo $includes_dir; ?>admin/plugins/lou-multi-select/js/jquery.multi-select.js" type="text/javascript"></script>
<!-- DataTables -->
<script src="<?php echo $includes_dir; ?>admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo $includes_dir; ?>admin/plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- datepicker -->
<script src="<?php echo $includes_dir; ?>admin/plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Select2 -->
<script src="<?php echo $includes_dir; ?>admin/plugins/select2/select2.full.min.js"></script>

<script src="<?php echo $includes_dir; ?>admin/js/form-elements.js"></script>

<script type="text/javascript">


$(function () {
    //Date picker
    $('.datepicker').datepicker({
		startDate: '+0d',
      autoclose: true
    });
  //select 2
  $('.select2').select2({
    width: '100%'
  });
  
  
  $('#rfqDate').on('change', function() {
		$.ajax({
			url: '<?php echo base_url(); ?>admin/rfq/get_rfq_num_detail',
			type: 'GET',
			data: {rfqDate: $(this).val(), echo: true},
			success: function(data) {
				$('#refNumber').val(data);
				$('#refNumber').attr('placeholder', data);
			}
		});
  });
  
});  
</script>

<!-- Validation -->
<script src="<?php echo $includes_dir; ?>admin/plugins/bootstrap-validation/validator.min.js"></script>
<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
<!--[if (gte IE 8)&(lt IE 10)]>
<script src="js/cors/jquery.xdr-transport.js"></script>
<![endif]-->
<script src="<?php echo $includes_dir; ?>admin/plugins/jquery-validation/dist/jquery.validate.min.js"></script>

<script src="<?php echo $includes_dir; ?>admin/plugins/jQuery-Tags-Input/jquery.tagsinput.js"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
