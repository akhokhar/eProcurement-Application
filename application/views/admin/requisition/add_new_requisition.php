
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
			<?php
            $attributes = array('class' => '', 'role' => 'form', 'data-toggle' => 'validator', 'id' => 'generalRequisitionForm');
            echo form_open_multipart('', $attributes);
            ?>
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
                        <h1 class="col-sm-6">Add New Requisition <small></small></h1>
                        <div class="col-md-2 pull-right">
                            <button class="btn btn-yellow btn-block" id="submit_btn" type="button">
                                Submit <i class="fa fa-arrow-circle-right"></i>
                            </button>
                        </div>
                    </div>
                    <!-- end: PAGE TITLE & BREADCRUMB -->
                </div>
            </div>
            <!-- end: PAGE HEADER -->
            
                <!-- start: PAGE CONTENT -->
                <div class="row">
                    <div class="col-sm-12">
                        <!-- start: PANLEL TABS -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-reorder"></i>
                                Requisition Details
                            </div>
                            <div class="panel-body">
                                <div class="tabbable panel-tabs">
                                    <ul id="myTab" class="nav nav-tabs tab-blue">
                                        <li class="active">
                                            <a data-toggle="tab" href="#panel_tab_general">
                                                General
                                            </a>
                                        </li>
                                        <li>
                                            <a data-toggle="tab" href="#panel_tab_item">
                                                Items
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div id="panel_tab_general" class="tab-pane active">
                                            <div class="panel-body">
                                              <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="requisitionDate">
                                                            Date <span class="symbol required"></span>
                                                        </label>
                                                        <div class="input-group date">
                                                          <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                          </div>
                                                          <?php
                                                          $input_data = array(
                                                                    'type'          => 'text',
                                                                    'name'          => 'requisitionDate',
                                                                    'id'            => 'requisitionDate',
																	'required'	  => 'required',
                                                                    'value'         => set_value('requisitionDate'),
                                                                    'class'         => 'form-control pull-right datepicker',
                                                                    'placeholder'   => 'DD/MM/YYYY'
                                                          );
                                                          echo form_input($input_data);
                                                          ?>
                                                        </div>
                                                    </div>        
                                                    <div class="form-group">
                                                      <label for="refNumber">Ref#</label>
                                                         <?php
                                                          $input_data = array(
                                                                    'type'          => 'number',
                                                                    'name'          => 'refNumber',
                                                                    'id'            => 'refNumber',
																	'disabled'	  => true,
                                                                    'value'         => set_value('refNumber'),
                                                                    'class'         => 'form-control',
                                                                    'placeholder'   => '10-16-1'
                                                          );
                                                          echo form_input($input_data);
                                                          ?>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="budgetHead">
                                                        	Budget Head <span class="symbol required"></span>
                                                        </label>
                                                        <?php
                                                          $dropdown_data = array(
                                                                    'id'            => 'budgetHead',
                                                                    'class'         => 'form-control select2',
                                                                    'required'	  => 'required'
                                                          );
														  $budgetHeads = array(
                                                                    ''              => 'Select',
                                                                    'of'         	=> 'Office',
                                                                    'fl'	  		=> 'Field'
                                                          );
                                                          echo form_dropdown('budgetHead', $budgetHeads, '', $dropdown_data);
                                                          ?>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="donors">
                                                        	Donor <span class="symbol required"></span>
                                                        </label>
                                                        <?php
                                                          $dropdown_data = array(
                                                                    'id'            => 'donor',
                                                                    'class'         => 'form-control select2',
                                                                    'required'	  => 'required'
                                                          );
														  $donors = array(
                                                                    ''              => 'Select',
                                                                    'USAid'         => 'USAid',
                                                                    'EU'	  		=> 'EU',
                                                                    'Oxfam'	  	 => 'Oxfam'
                                                          );
                                                          echo form_dropdown('donor', $donors, '', $dropdown_data);
                                                          ?>
                                                    </div>
                                                  </div>
                                                  <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="requiredUntilDate">
                                                        	Required until Date <span class="symbol required"></span>
                                                        </label>
                                                        <div class="input-group date">
                                                          <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                          </div>
														  <?php
                                                          $input_data = array(
                                                                    'type'          => 'text',
                                                                    'name'          => 'requiredUntilDate',
                                                                    'id'            => 'requiredUntilDate',
																	'required'	  => 'required',
                                                                    'value'         => set_value('requiredUntilDate'),
                                                                    'class'         => 'form-control pull-right datepicker',
                                                                    'placeholder'   => 'DD/MM/YYYY'
                                                          );
                                                          echo form_input($input_data);
                                                          ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="location">
                                                        	Project <span class="symbol required"></span>
                                                        </label>
                                                        <?php
                                                          $dropdown_data = array(
                                                                    'id'            => 'project',
                                                                    'class'         => 'form-control select2',
                                                                    'required'	  => 'required'
                                                          );
														  $projects = array(
                                                                    ''              => 'Select',
                                                                    'Project 1'     => 'Project 1',
                                                                    'Project 2'	 => 'Project 2',
                                                                    'Project 3'	 => 'Project 3'
                                                          );
                                                          echo form_dropdown('project', $projects, '', $dropdown_data);
                                                          ?>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="location">
                                                        	Location <span class="symbol required"></span>
                                                        </label>
                                                        <?php
                                                          $dropdown_data = array(
                                                                    'id'            => 'location',
                                                                    'class'         => 'form-control select2',
                                                                    'required'	  => 'required'
                                                          );
														  $locations = array(
                                                                    ''              => 'Select',
                                                                    'Hyderabad'     => 'Hyderabad',
                                                                    'Jamshoro'	  => 'Jamshoro',
                                                                    'Hala'	 	  => 'Hala'
                                                          );
                                                          echo form_dropdown('location', $locations, '', $dropdown_data);
                                                          ?>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="approvingAuthority">
                                                        	Approving Authority <span class="symbol required"></span>
                                                        </label>
                                                        <?php
                                                          $dropdown_data = array(
                                                                    'id'            => 'approvingAuthority',
                                                                    'class'         => 'form-control select2',
                                                                    'required'	  => 'required'
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
                                                </div>
              </div>
              <div class="box-footer pull-right-container">
                <button type="submit" class="btn btn-primary pull-right" disabled>Create Requisition</button>
              </div>
                                                    
                                                    
                                                    
                                                   
                                                    <hr />
                                                    <div class="row">
                                                        <div class="col-md-2 pull-right">
                                                            <a href="#panel_tab_category" data-toggle="tab" class="btn btn-teal ladda-button next_tab">
                                                                Next <i class="fa fa-arrow-circle-right"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php echo form_close(); ?>
                                        </div>
                                        <div id="panel_tab_category" class="tab-pane">
                                            <div class="panel-body">
                                                <div role="form" class="form-horizontal">
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label" for="form-field-1">
                                                            Parent Category <span class="symbol required"></span>
                                                        </label>
                                                        <div class="col-sm-9">
                                                            <select id="form-field-select-1" name="product_cat_id" class="product_cat_id form-control">
                                                                <option value="">--Select Category--</option>
                                                                <?php
                                                                if($parent_categories) {
                                                                    foreach($parent_categories as $get_record) {
                                                                        echo '<option value="' . $get_record['cat_id'] . '">' . $get_record['cat_title'] . '</option>';
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label" for="form-field-1">
                                                            Category
                                                        </label>
                                                        <div class="col-sm-9" id="multi-selecter-box">
                                                            <select name="category_id[]" id="form-field-select-4" multiple="multiple" class="category_id form-control">
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div id="custom_fields">

                                                    </div>
                                                    <hr />
                                                    <div class="row">
                                                        <div class="col-md-2 pull-left">
                                                            <a href="#panel_tab_general" data-toggle="tab" class="btn btn-light-grey next_tab">
                                                                <i class="fa fa-arrow-circle-left"></i> Back
                                                            </a>
                                                        </div>
                                                        <div class="col-md-2 pull-right">
                                                            <a href="#panel_tab_data" data-toggle="tab" class="btn btn-teal ladda-button next_tab">
                                                                Next <i class="fa fa-arrow-circle-right"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
<script src="<?php echo $includes_dir; ?>admin/plugins/summernote/build/summernote.min.js"></script>
<script src="<?php echo $includes_dir; ?>admin/js/form-elements.js"></script>

<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
    {% console.log(o.options.fileInput[0].id); for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
    <td>
    <span class="preview"></span>
    </td>
    <td>
    <p class="name">{%=file.name%}</p>
    <strong class="error text-danger"></strong>
    </td>
    <td>
                
    {% if(o.options.fileInput[0].id == 'file_images') { %}
        Main Image&nbsp;&nbsp;
        <input type="radio" {% var fileType = file.name.split('.').pop(), allowdtypes = 'jpeg,jpg,png,gif'; if (allowdtypes.indexOf(fileType.toLowerCase()) < 0) { %} disabled="disabled"  {% } %} value="" name="main_image" class="main_image">
    {% } %}
    
    {% if(o.options.fileInput[0].id == 'file_thumbnail') { %}
        Main Thumbnail&nbsp;&nbsp;
        <input type="radio" {% var fileType = file.name.split('.').pop(), allowdtypes = 'jpeg,jpg,png,gif'; if (allowdtypes.indexOf(fileType.toLowerCase()) < 0) { %} disabled="disabled"  {% } %} value="" name="main_thumbnail" class="main_thumbnail">
    {% } %}
    
    
    </td>
    <td>
    <p class="size">Processing...</p>
    <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
    </td>
    <td>
    {% if (!i && !o.options.autoUpload) { %}
    <button class="btn btn-primary start" disabled>
    <i class="glyphicon glyphicon-upload"></i>
    <span>Start</span>
    </button>
    {% } %}
    {% if (!i) { %}
    <button class="btn btn-warning cancel">
    <i class="glyphicon glyphicon-ban-circle"></i>
    <span>Cancel</span>
    </button>
    {% } %}
    </td>
    </tr>
    {% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
    {% console.log(o); for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
    <td>
    <span class="preview">
    {% if (file.thumbnailUrl) { %}
    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img width="150" height="150" src="{%=file.thumbnailUrl%}"></a>
    {% } else { %}
    <video src="{%=file.url%}" width="150" height="150" controls></video>
    {% } %}
    </span>
    <input type="hidden" value="{%=file.id%}" name="images_id[]">
    </td>
    <td>
    <p class="name">
    {% if (file.url) { %}
    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
    {% } else { %}
    <span>{%=file.name%}</span>
    {% } %}
    </p>
    {% if (file.error) { %}
    <div><span class="label label-danger">Error</span> {%=file.error%}</div>
    {% } %}
    </td>
    <td>
    
    {% if(o.options.fileInput[0].id == 'file_images') { %}
        Main Image&nbsp;&nbsp;
        <input type="radio" {% var fileType = file.name.split('.').pop(), allowdtypes = 'jpeg,jpg,png,gif'; if (allowdtypes.indexOf(fileType.toLowerCase()) < 0) { %} disabled="disabled"  {% } %} value="{%=file.id%}" name="main_image" class="main_image">
    {% } %}
    
    {% if(o.options.fileInput[0].id == 'file_thumbnail') { %}
        Main Thumbnail&nbsp;&nbsp;
        <input type="radio" {% var fileType = file.name.split('.').pop(), allowdtypes = 'jpeg,jpg,png,gif'; if (allowdtypes.indexOf(fileType.toLowerCase()) < 0) { %} disabled="disabled"  {% } %} value="{%=file.id%}" name="main_thumbnail" class="main_thumbnail">
    {% } %}
    
    </td>
    <td>
    <span class="size">{%=o.formatFileSize(file.size)%}</span>
    </td>
    <td>
    {% if (file.deleteUrl) { %}
    <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
    <i class="glyphicon glyphicon-trash"></i>
    <span>Delete</span>
    </button>
    <input type="checkbox" name="delete" value="1" class="toggle">
    {% } else { %}
    <button class="btn btn-warning cancel">
    <i class="glyphicon glyphicon-ban-circle"></i>
    <span>Cancel</span>
    </button>
    {% } %}
    </td>
    </tr>
    {% } %}
</script>
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
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="<?php echo $includes_dir; ?>admin/plugins/jQuery-File-Upload/js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="<?php echo $includes_dir; ?>admin/plugins/jQuery-File-Upload/js/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="<?php echo $includes_dir; ?>admin/plugins/jQuery-File-Upload/js/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="<?php echo $includes_dir; ?>admin/plugins/jQuery-File-Upload/js/jquery.fileupload-image.js"></script>
<!-- The File Upload audio preview plugin -->
<script src="<?php echo $includes_dir; ?>admin/plugins/jQuery-File-Upload/js/jquery.fileupload-audio.js"></script>
<!-- The File Upload video preview plugin -->
<script src="<?php echo $includes_dir; ?>admin/plugins/jQuery-File-Upload/js/jquery.fileupload-video.js"></script>
<!-- The File Upload validation plugin -->
<script src="<?php echo $includes_dir; ?>admin/plugins/jQuery-File-Upload/js/jquery.fileupload-validate.js"></script>
<!-- The File Upload user interface plugin -->
<script src="<?php echo $includes_dir; ?>admin/plugins/jQuery-File-Upload/js/jquery.fileupload-ui.js"></script>
<!-- The main application script -->
<script src="<?php echo $includes_dir; ?>admin/plugins/jQuery-File-Upload/js/main.js"></script>
<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
<!--[if (gte IE 8)&(lt IE 10)]>
<script src="js/cors/jquery.xdr-transport.js"></script>
<![endif]-->
<script src="<?php echo $includes_dir; ?>admin/plugins/jquery-validation/dist/jquery.validate.min.js"></script>

<script src="<?php echo $includes_dir; ?>admin/plugins/jQuery-Tags-Input/jquery.tagsinput.js"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->



<script>    

    // ==============================
    // atart: validation
    // ==============================
    var FormValidator = function () {
        var productForm = function () {
            var form1 = $('#product_form');
            var errorHandler1 = $('.errorHandler', form1);
            var successHandler1 = $('.successHandler', form1);
            $('#generalRequisitionForm').validate({
                errorElement: "span", // contain the error msg in a span tag
                errorClass: 'help-block',
                errorPlacement: function (error, element) {
                    if ( element.is(":radio") ||  element.is(":checkbox"))
                    {
                        error.appendTo( element.parents('.container_radio') );
                    }
                    else{
                        error.insertAfter(element);
                    }

                        // for other inputs, just perform default behavior
                },
                ignore: ".ignore",
                rules: {
                    RequisitionDate: {
                        minlength: 2,
                        required: true
                    },
                    refNumber: {
                        required: true
                    },
                    budgetHead: {
                        required: true
                    },
                    donor: {
                        required: true
                    },
                    requiredUntilDate: {
                        required: true
                    },
                    location: {
                        required: true
                    },
                    project: {
                        required: true
                    },
                    approvingAuthority: {
                        required: true
                    }
                },
                messages: {
                    product_title: "Please specify product title",
                    product_cat_id: "Please select category",
                    product_model: "Please specify product model",
                    product_price: "Please specify product price",
                    product_status: "Please select product status",
                    product_house_status: "Please select warehouse status",
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
                    
                    var tab_pane_id = $(element).closest('.form-group').parents('.tab-pane').attr('id');
                    $('a[href=#'+tab_pane_id+']').parent('li').addClass('has-error-tab');                    
                },
                unhighlight: function (element) { // revert the change done by hightlight
                    $(element).closest('.form-group').removeClass('has-error');
                    // set error class to the control group
                    
                    var tab_pane = $(element).closest('.form-group').parents('.tab-pane');
                    
                    if(tab_pane.find('.has-error').length == 0) {
                        var tab_pane_id = tab_pane.attr('id');
                        $('a[href=#'+tab_pane_id+']').parent().removeClass('has-error-tab');
                    }
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
                    HTMLFormElement.prototype.submit.call($('#product_form')[0]);
                }
            });
        };

        return {
            //main function to initiate pages
            init: function () {
                productForm();
            }
        };
    }();
    /* ========== end: validation ========== */
    
    jQuery(document).ready(function () {
        
        $(".discount_div input:radio").click(function(){		
	        		
            var val= $("input[name=product_disc_type]:checked").val();		

            if(val==1){		
                $('#product_discount').prop('readonly',false);		
                $('#product_discount').val('');		
                $('#discount_value').val('');		
            }		
            if(val==2){		
                $('#product_discount').prop('readonly',false);		
                $('#product_discount').val('');		
                $('#discount_value').val('');		
            }		
            if(val==0){		
                $('#product_discount').prop('readonly',true);		
                $('#product_discount').val('0');		
                $('#discount_value').val('0');		
            }		
        });
        
        $('.next_tab').click(function() {
            var href = $(this).attr('href'); //alert(href);
            
            $('#myTab').children('li').removeClass('active');
            
            $('a[href='+href+']').parent('li').addClass('active');
            
            //alert($('a[href='+href+']').html());
            
            //$('#myTab').children('a[href='+href+']').addClass('active');
        });

        Main.init();
        FormElements.init();
        FormValidator.init();

        $(".product_cat_id").change(function () {
         
            var category_id = $(this).val();
            
            if(category_id == '') {
                $("#custom_fields").html('');
            }
            
            $.ajax({
                url: '<?php echo base_url(); ?>admin/product/get_category_by_parent',
                type: 'POST',
                dataType: "JSON",
                data: {category_id: category_id},
                success: function(response) {
                    
                    var multi_select = $('#multi-selecter-box');
                    
                    multi_select.empty();
                    
                    multi_select.append('<select name="category_id[]" id="form-field-select-4" multiple="multiple" class="category_id form-control"></select>');
                    
                    var select = $('.category_id');
         
                    if(response.length != 0) {
                        $.each(response, function (i, fb) {
                            if(fb.cat_id != category_id) {
                                console.log(fb);
                                select.append('<option custom_id="" value="' + fb.cat_id + '">' + fb.cat_title + '</option>');
                            }
                        });
                    }
                    
                    $('.category_id').multiSelect({
                        selectableHeader: "<div class='custom-header'>Selectable items</div>",
                        selectionHeader: "<div class='custom-header'>Selection items</div>",
                    })
                },
                error: function () {
                    console.log('Error in retrieving Site.');
                }
            });

            if(category_id != ""){
                $("#custom_fields").load("<?php echo base_url(); ?>admin/product/get_custom_fields/"+true, { category: category_id} );
            }
        });
         
        $('#submit_btn').click(function() {
        //alert('TESTING');
            /*if($('body').hasClass('has-error')) {
                $('.has-error').each(function() {
                    alert('REHMAN');
                })
            }*/

            $('textarea[name="product_policy"]').html($('#product_policy').code());
            $('textarea[name="product_description"]').html($('#product_description').code());
            $('textarea[name="pack_include"]').html($('#pack_include').code());
        
            $('#product_form').attr('action', '<?php echo current_url(); ?>');
            $('#product_form').submit();
        
        });
        
        $('#submit_btn_upload').click(function() {
            
            $('#product_form').attr('action', '<?php echo $base_url; ?>admin/product/file_upload');
        
        });
        
        
        $('.category_id').multiSelect({
            selectableHeader: "<div class='custom-header'>Selectable items</div>",
            selectionHeader: "<div class='custom-header'>Selection items</div>",
        })
        
        // ==============================
        // start: discount type
        // ==============================
        $('.iCheck-helper').click(function() {
            
            if(!$(this).prev('input').hasClass('discount_type')) {
                return false;
            }
            
            var discount_type       = $(this).prev('.discount_type').val();
            var product_price       = parseFloat($('#product_price').val());
            var product_discount    = parseFloat($('#product_discount').val(''));
            
            if(product_price == '' && product_discount == '') {
                return false;
            }
            
            if(discount_type == '1') { 
                if(product_discount < product_price) {
                    var discount_value = product_price-product_discount;
                }
                
                if(product_discount >= product_price) {
                    var count_length = $("product_discount").text().length;
                    $("#product_discount").attr('maxlength', count_length);
                    $("#product_discount").val('');
                }
                else {
                    $("#product_discount").removeAttr('maxlength');
                }
            }
            else if(discount_type == '2') {
                if(product_discount < 100) {
                    var discount_persent_value = (product_discount/100)*product_price;
                    discount_value = product_price-discount_persent_value
                }
                
                if(product_discount > 99) {
                    $("#product_discount").attr('maxlength', '2');
                    $("#product_discount").val('');
                }
                else {
                    $("#product_discount").removeAttr('maxlength');
                }
            }
            
            $('#discount_value').val(discount_value.toFixed(2));
            
        })
        
        
        $('.price_value').keyup(function() {
            
            var price_value     = parseFloat($(this).val());
            var price_value_id  = $(this).attr('id');
            var discount_type   = $("input[name=product_disc_type]:checked").val()
            
            if(typeof discount_type == 'undefined') {
                return false;
            }
            
            if(price_value_id == 'product_price') {
                var product_discount = parseFloat($('#product_discount').val());
                var product_price = price_value;
            }
            else {
                var product_price  = parseFloat($('#product_price').val());
                var product_discount = price_value;
            }
            
            if(product_price == '' && product_discount == '') {
                return false;
            }
            
            if(discount_type == '1') { 
                if(product_discount < product_price) {
                    var discount_value = product_price-product_discount;
                }
                
                if(product_discount >= product_price) {
                    var count_length = $("product_discount").text().length;
                    $("#product_discount").attr('maxlength', count_length);
                    $("#product_discount").val('');
                }
                else {
                    $("#product_discount").removeAttr('maxlength');
                }
                    
            }
            else if(discount_type == '2') {
                if(product_discount < 100) {
                    var discount_persent_value = (product_discount/100)*product_price;
                    discount_value = product_price-discount_persent_value
                }
                
                //alert(product_discount);
                if(product_discount > 99) {
                    $("#product_discount").attr('maxlength', '2');
                    $("#product_discount").val('');
                }
                else {
                    $("#product_discount").removeAttr('maxlength');
                }
            }
            
            $('#discount_value').val(discount_value.toFixed(2));
        })
        /* ========== end: discount type ========== */
        
        $(".open_popup").click(function(){
            $('#event-management').modal('show');
        })
        //https://www.youtube.com/embed/C0DPdy98e4c
        //https://www.youtube.com/watch?v=nPSbOsOJ9Ro
        $(".save-event").click(function(){
            $('#event-management').modal('hide');
            var videoName = $.trim($('#videoName').val());
            var videoUrl = $.trim($('#videoUrl').val());
            if(videoUrl != ""){
                videoUrl = videoUrl.split("=");
                videoUrl = "<?php echo $this->config->item("youtube_http"); ?>"+videoUrl[1];
            $(".video_url").append("<tr class='template-download fade in'><td><input type='hidden' name='videoName[]' value='"+videoName+"'><input type='hidden' name='videoUrl[]' value='"+videoUrl+"'><iframe width='150' height='150' src='"+videoUrl+"'></iframe></td><td>"+videoName+"</td><td>&nbsp;</td><td>0 MB</td><td><button data-type='DELETE' class='btn btn-danger delete'><i class='glyphicon glyphicon-trash'></i><span>Delete</span></button>&nbsp;<input type='checkbox' class='toggle' value='1' name='delete'></td></tr>");
            $('#videoName').val("");
            $('#videoUrl').val("");
         }
        });
        $('.btn-danger').prop("disabled", false); // its by default set to disable thats why place that line
        
    });
</script>

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