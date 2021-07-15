<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu bg-dark" style="background:#313a46">

    <div class="slimscroll-menu" id="left-side-menu-container">

        <!-- LOGO -->
        <a href="index.html" class="logo text-center bg-dark">
            <span class="logo-lg">
                TAQUERÍA EL MIXTECO
            </span>
            <span class="logo-sm">
                MIXTECO
            </span>
        </a>

        <!--- Sidemenu -->
        <ul class="metismenu side-nav bg-dark">
            @can('Category_List')
                <li class="side-nav-item">
                    <a href="{{url('categories')}}" class="side-nav-link">
                        <i class="uil-apps"></i>
                        <span> Categorías </span>
                    </a>

                </li>
            @endcan
            @can('Product_List')
            <li class="side-nav-item">
                    <a href="{{url('products')}}" class="side-nav-link">
                        <i class="uil-tag-alt"></i>
                        <span> Productos </span>
                    </a>

            </li>
            @endcan
            @can('Sale_List')

            <li class="side-nav-item">
                <a href="{{url('sales')}}" class="side-nav-link">
                    <i class="uil-shopping-cart-alt"></i>
                    <span> Ventas </span>
                </a>
            </li>
            @endcan
            @can('Role_List')

            <li class="side-nav-item">
                <a href="{{url('roles')}}" class="side-nav-link">
                    <i class="uil-keyhole-square"></i>
                    <span> Roles </span>
                </a>
            </li>
            @endcan
            @can('Permission_List')
            <li class="side-nav-item">
                <a href="{{url('permissions')}}" class="side-nav-link">
                    <i class="uil-lock-open-alt"></i>
                    <span> Permisos </span>
                </a>
            </li>
            @endcan
            @can('Asignar_List')
            <li class="side-nav-item">
                <a href="{{url('asignar')}}" class="side-nav-link">
                    <i class="uil-eye"></i>
                    <span> Asignar </span>
                </a>
            </li>
            @endcan
            @can('User_List')
            <li class="side-nav-item">
                <a href="{{url('users')}}" class="side-nav-link">
                    <i class="uil-users-alt"></i>
                    <span> Usuarios </span>
                </a>
            </li>
            @endcan
            @can('Coin_List')
            <li class="side-nav-item">
                <a href="{{url('coins')}}" class="side-nav-link">
                    <i class="uil-usd-circle"></i>
                    <span> Monedas </span>
                </a>
            </li>
            @endcan
            @can('Cashout_List')
            <li class="side-nav-item">
                <a href="{{url('cashout')}}" class="side-nav-link">
                    <i class="uil-notes"></i>
                    <span> Arqueos </span>
                </a>
            </li>
            @endcan
            @can('Report_List')
            <li class="side-nav-item">
                <a href="{{url('reports')}}" class="side-nav-link">
                    <i class="uil-graph-bar"></i>
                    <span> Reportes </span>
                </a>
            </li>
            @endcan

        </ul>

        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->
