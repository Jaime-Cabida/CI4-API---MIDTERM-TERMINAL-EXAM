<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="light">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
        <a href="<?= base_url('dashboard'); ?>" class="brand-link">
            <span class="brand-text fw-light">MIDTERM TERMINAL EXAM</span>
        </a>
    </div>
    <!--end::Sidebar Brand-->

    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation" aria-label="Main navigation" data-accordion="false" id="navigation">
                
                <!-- Dynamic Menus from DB -->
                <?php foreach ($MenuCategory as $mCategory) : ?>
                    <?php
                        $Menu = getMenu($mCategory['menuCategoryID'], $user['role']);
                        foreach ($Menu as $menu) :
                            if ($menu['parent'] == 0) :
                    ?>
                                <li style="margin-left:-20px;" class="sidebar-item <?= ($segment == $menu['url']) ? 'active' : ''; ?>">
                                    <a class="sidebar-link" href="<?= base_url($menu['url']); ?>">
                                        <i class="align-middle"></i> <span class="align-middle"><?= $menu['title']; ?></span>
                                    </a>
                                </li>
                            <?php
                            else :
                                $SubMenu = getSubMenu($menu['menu_id'], $user['role']);
                            ?>
                                <li class="sidebar-item <?= ($segment == $menu['url']) ? 'active' : ''; ?>">
                                    <a data-bs-target="#<?= $menu['url'] ?>" data-bs-toggle="collapse" class="sidebar-link collapsed" aria-expanded="<?= ($segment == $menu['url']) ? 'true' : 'false'; ?>">
                                        <i class="align-middle" data-feather="<?= $menu['icon']; ?>"></i> <span class="align-middle"><?= $menu['title']; ?></span>
                                    </a>
                                    <ul id="<?= $menu['url'] ?>" class="sidebar-dropdown list-unstyled collapse <?= ($segment == $menu['url']) ? ' show' : ''; ?>" data-bs-parent="#sidebar">
                                        <?php foreach ($SubMenu as $subMenu) : ?>
                                            <li class="sidebar-item <?= ($subsegment == $subMenu['url']) ? 'active' : ''; ?>">
                                                <a class="sidebar-link" href="<?= base_url($menu['url'] . '/' . $subMenu['url']); ?>">
                                                    <?= $subMenu['title']; ?>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </li>
                    <?php
                            endif;
                        endforeach;
                    ?>
                <?php endforeach; ?>

                <!-- Hardcoded CRUD Link for Testing -->
                <li class="sidebar-item <?= ($segment == 'products') ? 'active' : ''; ?>">
                    <a class="sidebar-link" href="<?= base_url('products'); ?>" style="margin-left:-8px">
                        <span class="align-middle">Products</span>
                    </a>
                </li>

                <li class="sidebar-item <?= ($segment == 'api-test') ? 'active' : ''; ?>">
                    <a class="sidebar-link" href="<?= base_url('api-test'); ?>" style="margin-left:-8px">
                        <span class="align-middle">API Test</span>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>
