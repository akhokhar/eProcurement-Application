
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
                        <h1 class="col-sm-6">Add New Requisition <small></small></h1>
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
                                        $attributes = array('class' => '', 'method' => 'post', 'role' => 'form', 'data-toggle' => 'validator', 'id' => 'rfqForm');
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
                                                                    'data-required-error' => 'Select 3 Vendors'
                                                          );
														  echo form_dropdown('vendors', $vendors, '', $dropdown_data);
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
                                                        <button type="submit" class="btn btn-primary pull-right" id="newRfqButton" disabled>Create RFQ</button>
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

<script type="text/javascript">


$(function () {
    //Date picker
    $('.datepicker').datepicker({
      autoclose: true
    });
  //select 2
  $('.select2').select2({
    width: '100%'
  });

  //calculate total cost
  $('#quantity, #unitPrice').on('change', function() { 
    var quantity = $('#quantity').val();
    var unitPrice = $('#unitPrice').val();
    var totalPrice = Number(quantity) * Number(unitPrice);
    $('#totalPrice').val(totalPrice);
  });
  
  //initializing new array
  var requisitionItems = [];

  //add header to table from form
  function addformHeaderToTable(formId, tableId, firstColName, editDeleteColName) {
    var formData = $(formId).serializeArray();
    var thLabel = '';
    var thHtml = '';
    var tableHead = '<thead></thead>';
    $(tableId).html(tableHead);
    thHtml = (!!firstColName) ? '<th>' + firstColName + '</th>' : '';
    for (i=0; i < formData.length; i++) {
      thdLabel = $(formId).find('label[for=' + formData[i].name + ']').text();
      thHtml += '<th>' + thdLabel + '</th>';
    }
    thHtml += (!!editDeleteColName) ? '<th>' + editDeleteColName + '</th>' : '';
    $(tableId).find('thead').append(thHtml);
  }
  addformHeaderToTable('#addItemForm', '#itemsDataTable', 'S.No.', 'Remove');

  //validate form data
  $('#addItemForm').validator();

  //addItemForm Object Creation and add into Table
  function addformDataToTable(formId, tableId, firstCol, edit, remove) {
    var tableBody = '<tbody></tbody>';
    $(tableId).append(tableBody);
    //if no data in table
    /*console.log($(tableId).find('tbody tr'))
    if ($(tableId).find('tbody tr').length == 0) {
      $(tableId).addClass('hidden');
      $(tableId).after('<h3>No Data Found.</h3>');
    }
    else {alert('a')
      $(tableId).removeClass('hidden');
      $(tableId).after('h3').remove();
    }*/
    $(formId).validator().on('submit', function(e) {
	//$(formId).on('submit', function(e) {alert(isItemFormValidated)
      //if (isItemFormValidated) {
	if (!$(formId).find(':submit').hasClass('disabled')) {
        var formData = $(formId).serializeArray();
        var tableDataLength = $(tableId).find('tbody tr').length;
        requisitionItems[tableDataLength] = formData;
        var numRows = tableDataLength + 1;
        var tdHtml = '<tr>';
        tdHtml += (firstCol) ? '<td>' + numRows + '</td>' : '';
        for (i=0; i < formData.length; i++) {
          tdHtml += '<td>' + formData[i].value + '</td>';
        }
        tdHtml += (edit && remove) ? '<td>' : '';
        tdHtml += (edit) ? '<td><a id="editRow"><span class="glyphicon glyphicon-edit"></span></a></td>' : '';
        tdHtml += (remove) ? '<td><a id="removeRow"><span class="glyphicon glyphicon-remove"></span></a></td>' : '';
        tdHtml += (edit && remove) ? '</td>' : '';
        tdHtml += '</tr>';
        $(tableId).find('tbody').append(tdHtml);
        $(formId)[0].reset();
		$('#totalRequisitionItems').text(tableDataLength+1);
      }
      e.preventDefault();
    });
  }
  addformDataToTable('#addItemForm', '#itemsDataTable', true, false, true);
  
  $('#generalRequisitionForm').validator().on('submit', function(e) {
	  //$('#generalRequisitionForm').validator().trigger('submit', function(e) {
		  //if (isRequisitionFormValidated) {
			  $.ajax({
				  type: "POST",
				  url:"<?php echo base_url().BASE_DIR; ?>requisition/add",
				  dataType: "json",  
				  cache:false,
				  data: {requisition: $('#generalRequisitionForm').serializeArray(), items: requisitionItems},
				  success: function(response) {
					  if (!!response.msg_success) {
						$('#message').removeClass('alert-error');
						$('#message').removeClass('no-display');
						$('#message').addClass('alert-success');
						$('#message').text(response.msg_success);
						$('#generalRequisitionForm')[0].reset();
						requisitionItems = [];
						$('#itemsDataTable tbody').html("");
					  }
					  if (!!response.msg_error) {
						$('#message').removeClass('alert-success');
						$('#message').removeClass('no-display');
						$('#message').addClass('alert-error');
						$('#message').text(response.msg_error);
					  }
				  }
			  });
		  //}
          e.preventDefault();
	  //});
  });
  //enable general requisition button
  $('#addItemForm').validator().on('submit', function(e) {
  //$('#addItemForm').on('submit', function(e) {
	  /*if(tab_pane.find('.has-error').length == 0) {
		var tab_pane_id = tab_pane.attr('id');
		$('a[href=#'+tab_pane_id+']').parent().removeClass('has-error-tab');
	  }
	 
	 if ($('#addItemForm').('.with-errors.').text()) {
		var tab_pane_id = $(element).closest('.form-group').parents('.tab-pane').attr('id');
		$('a[href=#'+tab_pane_id+']').parent('li').addClass('has-error-tab'); 
		var tab_pane = $(element).closest('.form-group').parents('.tab-pane');
	 }
	if(tab_pane.find('.has-error').length == 0) {
		var tab_pane_id = tab_pane.attr('id');
		$('a[href=#'+tab_pane_id+']').parent().removeClass('has-error-tab');
	}*/
      enableDisableGeneralButton();
      e.preventDefault();
  });
  
  function enableDisableGeneralButton() {
    var numRows = $('#itemsDataTable').find('tbody tr').length;
      if (!!numRows) {
        $('#newRequisitionButton').removeAttr('disabled').removeClass('disabled');
      }
      else {
        $('#newRequisitionButton').prop('disabled', true);
      }
  }

  //remove row
  function removeRowFromTable(removeButtonId, tableId) {
    $(tableId).on('click', removeButtonId, function(e) {
      var tRindex = $(this).parents('tr').index();
      requisitionItems.splice(tRindex, 1);
      $(this).parents('tr').remove();
      $(tableId).find('tbody tr').each(function(index, element) {
          $(element).children('td:eq(0)').text(index + 1);
      });
	  
	  $('#totalRequisitionItems').text($('#itemsDataTable').find('tbody tr').length);
      enableDisableGeneralButton();
      e.preventDefault();
    });
  }
  removeRowFromTable('#removeRow', '#itemsDataTable');

  //data table
    /*$('#itemsDataTable').DataTable({
      'paging': true,
      'lengthChange': false,
      'searching': false,
      'ordering': true,
      'info': true,
      'autoWidth': false
    });*/
	
	
	//setting dynamic validation messages
	$("form").find(".form-group").append('<div class="help-block with-errors"></div>');
	/*var emptyMsg = ' cannot be empty';
	$("form").find(":input").each(function(index, element) {
       $(this).after('<div class="help-block with-errors">' + $(this).prev("label").text() + emptyMsg + '</div>'); 
    });*/
	
});

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
<!-- Validation -->
<script src="<?php echo $includes_dir; ?>admin/plugins/bootstrap-validation/validator.min.js"></script>
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
	/*var emptyMsg = " cannot be empty";
	
    var FormValidator = function () {
        var generalRequisitionForm = function () {
            var form1 = $('#generalRequisitionForm');
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
                    RequisitionDate: "Requisition Date" + emptyMsg,
                    refNumber: "Reference Number" + emptyMsg,
                    budgetHead: "Budget Head" + emptyMsg,
                    donor: "Donor" + emptyMsg,
                    requiredUntilDate: "Required Until Date" + emptyMsg,
                    location: "Location" + emptyMsg,
                    project: "Project" + emptyMsg,
                    approvingAuthority: "Approving Authority" + emptyMsg
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
                    isRequisitionFormValidated = false;
                    var tab_pane_id = $(element).closest('.form-group').parents('.tab-pane').attr('id');
                    $('a[href=#'+tab_pane_id+']').parent('li').addClass('has-error-tab');      
					                
                },
                unhighlight: function (element) { // revert the change done by hightlight
                    $(element).closest('.form-group').removeClass('has-error');
                    // set error class to the control group
                    isRequisitionFormValidated = true;
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
                    HTMLFormElement.prototype.submit.call($('#generalRequisitionForm')[0]);
                }
            });
        };

		var addItemForm = function () {
            var form1 = $('#addItemForm');
            var errorHandler1 = $('.errorHandler', form1);
            var successHandler1 = $('.successHandler', form1);
            $('#addItemForm').validate({
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
                    itemName: {
                        required: true
                    },
                    itemDescription: {
                        required: true
                    },
                    costCenter: {
                        required: true
                    },
                    unit: {
                        required: true
                    },
                    quantity: {
                        required: true
                    },
                    unitPrice: {
                        required: true
                    }
                },
                messages: {
                    itemName: "Item Name" + emptyMsg,
                    itemDescription: "Item Description" + emptyMsg,
                    costCenter: "Cost Center" + emptyMsg,
                    unit: "Unit" + emptyMsg,
                    quantity: "Quantity" + emptyMsg,
                    unitPrice: "Unit Price" + emptyMsg
                },
                invalidHandler: function (event, validator) { //display error alert on form submit
                    successHandler1.hide();
                    errorHandler1.show();
					isItemFormValidated = false;
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
					isItemFormValidated = true;
                    // submit form
                    //$('#addItemForm').submit();
                    HTMLFormElement.prototype.submit.call($('#addItemForm')[0]);
                }
            });
        };
		
        return {
            //main function to initiate pages
            init: function () {
                addItemForm();
                generalRequisitionForm();
            }
        };
    }();*/
    /* ========== end: validation ========== */
    
    jQuery(document).ready(function () {
        
        $('.next_tab').click(function() {
            var href = $(this).attr('href'); //alert(href);
            
            $('#myTab').children('li').removeClass('active');
            
            $('a[href='+href+']').parent('li').addClass('active');
            
            //alert($('a[href='+href+']').html());
            
            //$('#myTab').children('a[href='+href+']').addClass('active');
        });

        Main.init();
        FormElements.init();
       // FormValidator.init();
  
        
        
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