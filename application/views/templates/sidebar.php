<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-code"></i>
            </div>
            <div class="sidebar-brand-text mx-3">CI3 Login</div>
        </a>

        <?php
        $userRole = $this->session->userdata('role_id');

        $query = "SELECT `menu`.`id`, `menu`.`name`
                    FROM `menu` JOIN `access`
                    ON `menu`.`id` = `access`.`menu_id`
                    WHERE `access`.`role_id` = $userRole
                    ORDER BY `menu`.`id` ASC";

        $menus = $this->db->query($query)->result_array();

        foreach ($menus as $menu) :
        ?>
            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                <?= $menu['name'] ?>
            </div>

            <?php
            $submenus = $this->db->get_where('submenu', ['menu_id' => $menu['id']])->result_array();
            foreach ($submenus as $submenu) :
            ?>
                <?php if ($submenu['name'] == $title) : ?>
                    <li class="nav-item active">
                    <?php else : ?>
                    <li class="nav-item">
                    <?php endif; ?>

                    <?php if ($submenu['is_active'] == 1) : ?>
                        <a class="nav-link pt-0" href="<?= base_url() . $submenu['url']; ?>">
                        <?php else : ?>
                            <a href="" class="nav-link disabled">
                            <?php endif; ?>
                            <i class="<?= $submenu['icon']; ?>"></i>
                            <span><?= $submenu['name']; ?></span></a>
                    </li>
                <?php endforeach; ?>
            <?php endforeach; ?>

            <!-- Nav Item - Dashboard -->

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Nav Item - Logout -->
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('auth/logout'); ?>">
                    <i class="fas fa-fw fa-sign-out-alt"></i>
                    <span>Logout</span></a>
            </li>

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

    </ul>
    <!-- End of Sidebar -->