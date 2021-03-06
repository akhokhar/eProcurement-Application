
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
                        
                    </ol>
                    <!-- end: Success and error message -->
                    <div class="page-header row">
                        <h1 class="col-sm-6">Add New Comparative <small></small></h1>
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
                                <?php echo $requisition['description'];?>
                            </div>
                            <div class="panel-body">
                                <div class="tabbable panel-tabs">
                                    <div class="tab-content">
                                        <div id="panel_tab_general" class="tab-pane active">
										<?php
                                        $attributes = array('class' => '', 'method' => 'post', 'role' => 'form', 'id' => 'generalRequisitionForm');
                                        echo form_open_multipart('', $attributes);
                                        ?>
                                            <div class="panel-body">
												<div class="row">
													<div class="col-md-4">Items</div>                                                    
													  <?php foreach ($vendors as $vends) { ?>
                                                        <?php foreach ($vends as $id => $vendor) { ?>
                                                          <?php if ($id == 0) { continue; }?>
                                                      		<div class="col-md-2">
                                                          <?php echo $vendor['vendor_name']; ?>
                                                      		</div>
                                                        <?php } ?>
                                                      <?php } ?>
												</div>
											
											<hr><?php $count = 1;?>
											<?php foreach($requisitionItems as $item){?>
												<div class="row">
													<div class="col-md-4">
													<?php echo $item['item_name'];?>
													<input type="hidden" name="item[<?php echo $count;?>]" value="<?php echo $item['requisition_item_id']?>">
													</div>
													<?php foreach ($vendors as $vends) { ?>
                                                            <?php foreach ($vends as $id => $vendor) { ?>
                                                            	<?php if ($id == 0) { continue; }?>
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
																 <?php $vendorId = $vendor['vendor_id'];
																  $input_data = array(
																			'type'          => 'number',
																			'name'          => "unit[$count][$vendorId]",
																			'class'         => 'form-control',
																  );
																  echo form_input($input_data);
																  ?>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
													<?php } ?>
												</div>
											  <?php $count++;}?>
                                              <hr />
                                              <div class="row">
                                                <div class="col-md-2 pull-right">
                                                    <!--<a href="#panel_tab_items" data-toggle="tab" class="btn btn-teal ladda-button next_tab">
                                                        Next <i class="fa fa-arrow-circle-right"></i>
                                                    </a>-->
                                                    <div class="col-md-2 pull-right">
                                                        <button type="submit" class="btn btn-primary pull-right" id="newRequisitionButton">Create Comparative</button>
                                                    </div>
                                                </div>
                                              </div>
                                          </div> 
                            			<?php echo form_close(); ?>
                                        </div> 
                                            
                                    </div>
                                </div>
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
<link rel="stylesheet" href="<?php echo $includes_dir; ?>admin/plugins/summernote/build/summernote.css">
<!-- Generic page styles -->
<link rel="stylesheet" href="<?php echo $includes_dir; ?>admin/plugins/jQuery-File-Upload/css/style.css">
<!-- blueimp Gallery styles -->
<link rel="stylesheet" href="<?php echo $includes_dir; ?>admin/css/blueimp-gallery.min.css">
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<link rel="stylesheet" href="<?php echo $includes_dir; ?>admin/plugins/jQuery-File-Upload/css/jquery.fileupload.css">
<link rel="stylesheet" href="<?php echo $includes_dir; ?>admin/plugins/jQuery-File-Upload/css/jquery.fileupload-ui.css">
<!-- CSS adjustments for browsers with JavaScript disabled -->
<noscript><link rel="stylesheet" href="<?php echo $includes_dir; ?>admin/plugins/jQuery-File-Upload/css/jquery.fileupload-noscript.css"></noscript>
<noscript><link rel="stylesheet" href="<?php echo $includes_dir; ?>admin/plugins/jQuery-File-Upload/css/jquery.fileupload-ui-noscript.css"></noscript>

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

<script src="<?php echo $includes_dir; ?>admin/plugins/summernote/build/summernote.min.js"></script>
<script src="<?php echo $includes_dir; ?>admin/js/form-elements.js"></script>


<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="<?php echo $includes_dir; ?>admin/plugins/jQuery-File-Upload/js/vendor/jquery.ui.widget.js"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="<?php echo $includes_dir; ?>admin/plugins/blueimp/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="<?php echo $includes_dir; ?>admin/plugins/blueimp/load-image.all.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="<?php echo $includes_dir; ?>admin/plugins/blueimp/canvas-to-blob.min.js"></script>

<!-- blueimp Gallery script -->
<script src="<?php echo $includes_dir; ?>admin/plugins/blueimp/jquery.blueimp-gallery.min.js"></script>
<!-- Validation -->
<script src="<?php echo $includes_dir; ?>admin/plugins/bootstrap-validation/validator.min.js"></script>
<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
<!--[if (gte IE 8)&(lt IE 10)]>
<script src="js/cors/jquery.xdr-transport.js"></script>
<![endif]-->
<script src="<?php echo $includes_dir; ?>admin/plugins/jquery-validation/dist/jquery.validate.min.js"></script>

<script src="<?php echo $includes_dir; ?>admin/plugins/jQuery-Tags-Input/jquery.tagsinput.js"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->

<style>
    #product_meta_tag_tag, #product_meta_description_tag, #product_meta_key_tag, #product_product_tag_tag {
        width: auto !important;
    }
    .custom-header {
        background-color: #f5f5f5;
        font-weight: bold;
        padding: 5px;
        text-align: center;
    }
    .has-error-tab  {
        background: #a94442;
    }
    .has-error-tab a {
        color: #ffffff !important;
    }
    .has-error-tab:hover a {
        color: #555 !important;
    }
    .active.has-error-tab a {
        color: #333333 !important;
    }
    .productTagImage {
        display: none;
        width: 65%;
    }
    .upload_tab {
        border: 1px solid #dddddd !important;
        float: none !important;
        margin-top: 0 !important;
    }
    .upload_tab li.active > a:hover {
        color: #333333 !important;
    }
    .fileuploader {
        margin-top: 25px;
    }
</style>