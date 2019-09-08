<!-- ////////////////////////////////////////////////////////////////////////////-->
<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow menu-bordered" data-scroll-to-active="true">
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">

            <li class=" nav-item">
                <a href="<?php echo base_url(); ?>">
                    <i class="la la-dashboard"></i><span class="menu-title">Ana səhifə</span>
                </a>
            </li>

            <li class=" nav-item"><a href="javascript:void();"><i class="la la-cubes"></i><span class="menu-title">Məhsullar</span></a>
                <ul class="menu-content">
                    <li><a class="menu-item" href="<?php echo base_url('products')?>">Məhsullar</a>
                    </li>
                    <li><a class="menu-item" href="<?php echo base_url('products/create-product')?>">Məhsul yarat</a>
                    </li>
                </ul>
            </li>

            <li class=" nav-item"><a href="javascript:void();"><i class="la la-cart-plus"></i><span class="menu-title">Alışlar</span></a>
                <ul class="menu-content">
                    <li><a class="menu-item" href="<?php echo base_url('purchases')?>">Fakturalar</a>
                    </li>
                    <li><a class="menu-item" href="<?php echo base_url('purchases/add-purchase')?>">Faktura yarat</a>
                    </li>
                </ul>
            </li>

            <li class=" nav-item"><a href="javascript:void();"><i class="la la-cart-arrow-down"></i><span class="menu-title">Satışlar</span></a>
                <ul class="menu-content">
                    <li><a class="menu-item" href="<?php echo base_url('sales')?>">Fakturalar</a>
                    </li>
                    <li><a class="menu-item" href="<?php echo base_url('sales/add-sale')?>">Faktura yarat</a>
                    </li>
                </ul>
            </li>

            <li class=" nav-item"><a href="javascript:void();"><i class="la la-users"></i><span class="menu-title">Tədarükçülər</span></a>
                <ul class="menu-content">
                    <li><a class="menu-item" href="<?php echo base_url('suppliers')?>">Tədarükçülər</a>
                    </li>
                    <li><a class="menu-item" href="<?php echo base_url('suppliers/add-supplier')?>">Tədarükçü əlavə et</a>
                    </li>
                </ul>
            </li>

            <li class=" nav-item"><a href="javascript:void();"><i class="la la-users"></i><span class="menu-title">Müştərilər</span></a>
                <ul class="menu-content">
                    <li><a class="menu-item" href="<?php echo base_url('customers')?>">Müştərilər</a>
                    </li>
                    <li><a class="menu-item" href="<?php echo base_url('customers/add-customer'); ?>">Müştəri əlavə et</a>
                    </li>
                </ul>
            </li>

            <li class=" nav-item"><a href="javascript:void();"><i class="la la-cogs"></i><span class="menu-title">Makinalar</span></a>
                <ul class="menu-content">
                    <li><a class="menu-item" href="<?php echo base_url('machines')?>">Makinalar</a>
                    </li>
                    <li><a class="menu-item" href="<?php echo base_url('machines/add-machine'); ?>">Makina əlavə et</a>
                    </li>
                </ul>
            </li>

            <li class=" nav-item"><a href="javascript:void();"><i class="fa fa-smoking"></i><span class="menu-title">Siqaret növləri</span></a>
                <ul class="menu-content">
                    <li><a class="menu-item" href="<?php echo base_url('cigarette-types')?>">Siqaretlər</a>
                    </li>
                    <li><a class="menu-item" href="<?php echo base_url('cigarette-types/add-type'); ?>">Siqaret növü əlavə et</a>
                    </li>
                </ul>
            </li>

            <li class=" nav-item"><a href="javascript:void();"><i class="la la-flask"></i><span class="menu-title">Premiksler</span></a>
                <ul class="menu-content">
                    <li><a class="menu-item" href="<?php echo base_url('premixes')?>">Premiksler</a>
                    </li>
                    <li><a class="menu-item" href="<?php echo base_url('premixes/add-premix'); ?>">Premiks əlavə et</a>
                    </li>
                </ul>
            </li>

            <li class=" nav-item"><a href="javascript:void();"><i class="la la-file-text"></i><span class="menu-title">Reçeteler</span></a>
                <ul class="menu-content">
                    <li><a class="menu-item" href="<?php echo base_url('recipes')?>">Reçeteler</a>
                    </li>
                    <li><a class="menu-item" href="<?php echo base_url('recipes/add-recipe'); ?>">Reçete əlavə et</a>
                    </li>
                </ul>
            </li>

            <li class=" nav-item"><a href="javascript:void();"><i class="la la-file-text"></i><span class="menu-title">Tasklar</span></a>
                <ul class="menu-content">
                    <li><a class="menu-item" href="<?php echo base_url('tasks')?>">Tasklar</a>
                    </li>
                    <li><a class="menu-item" href="<?php echo base_url('tasks/add-task'); ?>">Task əlavə et</a>
                    </li>
                </ul>
            </li>


            <li class=" nav-item"><a href="javascript:void();"><i class="la la-bank"></i><span class="menu-title">Anbarlar</span></a>
                <ul class="menu-content">
                    <li><a class="menu-item" href="<?php echo base_url('warehouses')?>">Anbarlar</a>
                    </li>
                    <li><a class="menu-item" href="<?php echo base_url('warehouses/add-warehouse'); ?>">Anbar əlavə et</a>
                    </li>
                </ul>
            </li>

            <li class=" nav-item"><a href="javascript:void();"><i class="la la-cogs"></i><span class="menu-title">Ayarlar</span></a>
                <ul class="menu-content">
                    <li><a class="menu-item" href="<?php echo base_url('branches')?>">Filiallar</a></li>
                    <li><a class="menu-item" href="<?php echo base_url('departments'); ?>">Şöbələr</a></li>
                    <li><a class="menu-item" href="<?php echo base_url('users'); ?>">İstifadəçilər</a></li>
					<li><a class="menu-item" href="<?php echo base_url('brands'); ?>">Markalar</a></li>
					<li><a class="menu-item" href="<?php echo base_url('categories'); ?>">Categories</a></li>
					<li><a class="menu-item" href="<?php echo base_url('units'); ?>">Units</a></li>
					<li><a class="menu-item" href="<?php echo base_url('billers'); ?>">Billers</a></li>
                </ul>
            </li>







            <li class=" nav-item">
                <a href="javascript:void();">
                    <i class=""></i><span class="menu-title"></span>
                </a>
            </li>
            <li class=" nav-item">
                <a href="javascript:void();">
                    <i class=""></i><span class="menu-title"></span>
                </a>
            </li>


        </ul>
    </div>
</div>