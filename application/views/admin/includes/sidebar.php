<div class="main-navigation navbar-collapse collapse">
    <!-- start: MAIN MENU TOGGLER BUTTON -->
    <div class="navigation-toggler">
        <i class="clip-chevron-left"></i>
        <i class="clip-chevron-right"></i>
    </div>
    <!-- end: MAIN MENU TOGGLER BUTTON -->
    <!-- start: MAIN NAVIGATION MENU -->
    <ul class="main-navigation-menu">
        <?php
        //**************************
        //  DYNAMIC MENU WORK START
        //**************************  
        if (!empty($get_menu)) {
            foreach ($get_menu as $get_val) {
                $menu_child = array();
                $main_menu_without_child = array();
                $mu_url = $get_val['mu_url'];
                $exploded_url = explode("/", $get_val['mu_url']);
                if (isset($get_val['child_menu'])) {
                    if (sizeof($get_val['child_menu']) > 0) {
                        foreach ($get_val['child_menu'] as $key => $child_val) {
                            $menu_child[] = $child_val['mu_title'];
                            // Unset those childs which are not showing in menus
                            if ($child_val["mu_main_menu"] == 0) {
                                unset($get_val['child_menu'][$key]);
                                if (sizeof($get_val['child_menu']) == 0) {
                                    unset($get_val['child_menu']);
                                }
                            }
                        }
                    }
                }
                $arrow_class = "icon-arrow";
                // if no any child then
                if (!isset($get_val['child_menu'])) {
                    $main_menu_without_child[] = $get_val['mu_title'];
                    $arrow_class = "";
                }

                // If child menus then change url
                if (isset($get_val['child_menu'])) {
                    if (sizeof($get_val['child_menu']) > 0) {
                        $mu_url = "javascript:void(0)";
                    }
                }
				
				//echo $menu_title."---".$exploded_url[0]."---".$menu;print_r($main_menu_without_child);echo "--";print_r($menu_child);
                if ($this->flexi_auth->is_privileged($this->uri_privileged)) {
                    ?>
                    <?php /*<li class="<?php echo (in_array($menu_title, $main_menu_without_child) || ($exploded_url[0] == $menu && empty($menu_child)) || (!empty($menu_child) && isset($menu_title) && in_array($menu_title, $menu_child))) ? 'active open' : '' ?>"> */?>
					<li class="<?php echo (in_array($menu_title, $main_menu_without_child) || (!empty($menu_child) && isset($menu_title) && in_array($menu_title, $menu_child))) ? 'active open' : '' ?>"> 
                        <a href="<?php echo (strpos($mu_url, 'javascript:void') !== false) ? "javascript:void(0);" : $base_url . $get_val['mu_url']; ?>"><i class="<?php echo $get_val['mu_icon_class']; ?>"></i>
                            <span class="title"> <?php echo $get_val["mu_title"] ?> </span>
                            <?php
                            if($arrow_class != ""){
                            ?>
                            <i class="<?php echo $arrow_class; ?>"></i>
                            <?php
                            }
                            ?>
                            <span class="selected"></span>
                        </a>
                        <?php
                        if (isset($get_val['child_menu'])) {
                            if (sizeof($get_val['child_menu']) > 0) { ?>
                                <ul class="sub-menu">
                                <?php
                                foreach ($get_val['child_menu'] as $child_val) {
                                    if ($child_val["mu_main_menu"] == 0)
                                        continue;

                                    if ($this->flexi_auth->is_privileged($this->uri_privileged)) {
                                        ?>
                                        
                                            <li class="<?php echo (uri_string() . '/' == $child_val['mu_url']) ? $child_val['mu_class'] : ""; ?>">
                                                <a href="<?php echo $base_url . $child_val['mu_url']; ?>"><i class="<?php echo $child_val['mu_icon_class']; ?>"></i>
                                                    <span class="title"> <?php echo $child_val['mu_title']; ?> </span>
                                                    <?php 
                                                    $status = str_replace('Orders', '', $child_val['mu_title']);
                                                    $status = trim($status);
                                                    if(isset($total_orders_by_status[$status])){ ?>
                                                    <span class="badge badge-new"><?php echo $total_orders_by_status[$status]; ?></span>
                                                    <?php } ?>
                                                </a>
                                            </li>
                                        
                                        <?php
                                    }
                                }
                                ?>
                                </ul>
                            <?php
                            }
                        }
                        ?>
                    </li>

                    <?php
                }
            }
        }
        //**************************
        //  DYNAMIC MENU WORK END
        //**************************
        ?>

    </ul>
    <!-- end: MAIN NAVIGATION MENU -->
</div>