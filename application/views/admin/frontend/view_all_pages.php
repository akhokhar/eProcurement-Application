
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
                        <h1 class="col-sm-6">Frontend Pages <small>view all frontend pages</small></h1>
                        
                        <?php if ($this->flexi_auth->is_privileged($add_frontend_pages)) { ?>
                        <div class="col-md-2 pull-right">
                            <a class="btn btn-teal btn-block" href="<?php echo $base_url; ?>admin/frontend_setting/add_frontend_pages">
                                Add Frontend Pages
                            </a>
                        </div>
                        <?php } ?>

                    </div>
                    <!-- end: PAGE TITLE & BREADCRUMB -->
                </div>
            </div>
            <!-- end: PAGE HEADER -->



            <!-- start: PAGE CONTENT -->
            <div class="row">
                <div class="col-md-12">
                    <!-- start: BASIC TABLE PANEL -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-external-link-square"></i>
                            Frontend Pages

                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-bordered table-hover" id="sample_1">
                                <thead>
                                    <tr>

                                        <th>Page ID</th>
                                        <th class="hidden-xs">Page Name</th>
                                        
                                        <?php if ($this->flexi_auth->is_privileged($view_frontend_pages) || $this->flexi_auth->is_privileged($edit_frontend_pages) || $this->flexi_auth->is_privileged($delete_frontend_pages)) { ?>
                                        <th class="center">Action</th>
                                        <?php } ?>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($all_pages) {
                                        //$smsTemplates = (array) $smsTemplates;
                                        //echo '<pre>'; print_r($orders); die;
                                        foreach ($all_pages as $templateKey => $template) {

                                            ?>
                                            <tr>
                                                <td><?php echo $template['page_id']; ?></td>
                                                <td><?php echo $template['page_name']; ?></td>
                                                
                                                <?php if ($this->flexi_auth->is_privileged($view_frontend_pages) || $this->flexi_auth->is_privileged($edit_frontend_pages) || $this->flexi_auth->is_privileged($delete_frontend_pages)) { ?>
                                                <td class="center">
                                                    <div class="visible-md visible-lg hidden-sm hidden-xs">
                                                        <?php if ($this->flexi_auth->is_privileged($view_frontend_pages)) { ?>
                                                        <a href="<?php echo $base_url; ?>admin/frontend_setting/view_frontend_pages/<?php echo $template['page_id']; ?>" class="btn btn-xs btn-teal tooltips" data-placement="top" data-original-title="View"><i class="fa fa-arrow-circle-right"></i></a>
                                                        <?php } ?>
                                                        
                                                        <?php if ($this->flexi_auth->is_privileged($edit_frontend_pages)) { ?>
                                                        <a href="<?php echo $base_url; ?>admin/frontend_setting/edit_frontend_pages/<?php echo $template['page_id']; ?>" class="btn btn-xs btn-teal tooltips" data-placement="top" data-original-title="Edit"><i class="fa fa-edit"></i></a>
                                                        <?php } ?>
                                                        
                                                        <?php if ($this->flexi_auth->is_privileged($delete_frontend_pages)) { ?>
                                                        <a href="<?php echo $base_url; ?>admin/frontend_setting/delete_frontend_pages/<?php echo $template['page_id']; ?>" class="btn btn-xs btn-bricky tooltips" data-placement="top" data-original-title="Remove"><i class="fa fa-times fa fa-white"></i></a>
                                                        <?php } ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php 
                                                
                                            }
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
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
<link rel="stylesheet" href="<?php echo $includes_dir; ?>admin/plugins/datatables/media/css/DT_bootstrap.css" />
<!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->

<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script src="<?php echo $includes_dir; ?>admin/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="<?php echo $includes_dir; ?>admin/js/form-validation-js.js"></script>
<script type="text/javascript" src="<?php echo $includes_dir; ?>admin/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="<?php echo $includes_dir; ?>admin/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo $includes_dir; ?>admin/plugins/datatables/media/js/DT_bootstrap.js"></script>
<script src="<?php echo $includes_dir; ?>admin/js/table-data.js"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->

<script>
    jQuery(document).ready(function () {
        Main.init();
        FormValidator.init();
        TableData.init();
    });
</script>
