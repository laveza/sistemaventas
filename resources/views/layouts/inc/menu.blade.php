<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Alexander Pierce</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item" @click="menu=0">
                    <a href="javascript:void(0)" class="nav-link " :class="[menu==0 ? 'active' : '']">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Escritorio
                        </p>
                    </a>
                </li>
                <li class="nav-header text-uppercase">Mantenimiento</li>
                @if(Auth::check())
                    @if(Auth::user()->idrol == 1)
                        <li class="nav-item has-treeview">
                            <a href="javascript:void(0)" class="nav-link" :class="[menu===1 ? 'active' : '', menu===2 ? 'active' : '']">
                                <i class="nav-icon fas fa-archive"></i>
                                <p>
                                    Almacén
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item" @click="menu=1">
                                    <a href="javascript:void(0)" class="nav-link" :class="[menu===1 ? 'active' : '']">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Categorías </p>
                                    </a>
                                </li>
                                <li class="nav-item" @click="menu=2">
                                    <a href="javascript:void(0)" class="nav-link" :class="[menu===2 ? 'active' : '']">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Artículos</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link" :class="[menu===3 ? 'active' : '' , menu===4 ? 'active' : '']">
                                <i class="nav-icon fas fa-wallet"></i>
                                <p>
                                    Compras
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item" @click="menu=3">
                                    <a href="javascript:void(0)" class="nav-link" :class="[menu===3 ? 'active' : '']">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Ingresos</p>
                                    </a>
                                </li>
                                <li class="nav-item" @click="menu=4">
                                    <a href="javascript:void(0)" class="nav-link" :class="[menu===4 ? 'active' : '']">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Proveedores</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link" :class="[menu===5 ? 'active' : '', menu===6 ? 'active' : '']">
                                <i class="nav-icon fas fa-cart-plus"></i>
                                <p>
                                    Ventas
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item" @click="menu=5">
                                    <a href="javascript:void(0)" class="nav-link" :class="[menu===5 ? 'active' : '']">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Clientes</p>
                                    </a>
                                </li>
                                <li class="nav-item" @click="menu=6">
                                    <a href="javascript:void(0)" class="nav-link" :class="[menu===6 ? 'active' : '']">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Ventas</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link" :class="[menu===7 ? 'active' : '',menu===8 ? 'active': '']">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Acceso
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item" @click="menu=7" >
                                    <a href="javascript:void(0)" class="nav-link" :class="[menu===7 ? 'active' : '']">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Usuarios</p>
                                    </a>
                                </li>
                                <li class="nav-item" @click="menu=8" >
                                    <a href="javascript:void(0)" class="nav-link" :class="[menu===8 ? 'active' : '']">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Roles</p>
                                    </a>
                                </li>

                            </ul>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link" :class="[menu===9 ? 'active' : '', menu===10 ? 'active' : '']">
                                <i class="nav-icon fas fa-chart-area"></i>
                                <p>
                                    Reportes
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item" @click="menu=9">
                                    <a href="javascript:void(0)" class="nav-link" :class="[menu===9 ? 'active' : '']">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Reportes de Ingresos</p>
                                    </a>
                                </li>
                                <li class="nav-item" @click="menu=10">
                                    <a href="javascript:void(0)" class="nav-link" :class="[menu===10 ? 'active' : '']">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Reportes de Ventas</p>
                                    </a>
                                </li>

                            </ul>
                        </li>
                        <li class="nav-item" @click="menu=11">
                            <a href="javascript:void(0)" class="nav-link" :class="[menu===11 ? 'active' : '']">
                                <i class="nav-icon fas fa-book-open"></i>
                                <p>
                                    Ayuda
                                </p>
                            </a>
                        </li>
                        <li class="nav-item" @click="menu=12">
                            <a href="javascript:void(0)" class="nav-link " :class="[menu===12 ? 'active' : '']">
                                <i class="nav-icon fas fa-info-circle"></i>
                                <p>
                                    Acerca de...
                                </p>
                            </a>
                        </li>
                    @elseif(Auth::user()->idrol == 2)
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link" :class="[menu===5 ? 'active' : '', menu===6 ? 'active' : '']">
                                <i class="nav-icon fas fa-cart-plus"></i>
                                <p>
                                    Ventas
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item" @click="menu=5">
                                    <a href="javascript:void(0)" class="nav-link" :class="[menu===5 ? 'active' : '']">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Clientes</p>
                                    </a>
                                </li>
                                <li class="nav-item" @click="menu=6">
                                    <a href="javascript:void(0)" class="nav-link" :class="[menu===6 ? 'active' : '']">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Ventas</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link" :class="[menu===9 ? 'active' : '', menu===10 ? 'active' : '']">
                                <i class="nav-icon fas fa-chart-area"></i>
                                <p>
                                    Reportes
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item" @click="menu=10">
                                    <a href="javascript:void(0)" class="nav-link" :class="[menu===10 ? 'active' : '']">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Reportes de Ventas</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item" @click="menu=11">
                            <a href="javascript:void(0)" class="nav-link" :class="[menu===11 ? 'active' : '']">
                                <i class="nav-icon fas fa-book-open"></i>
                                <p>
                                    Ayuda
                                </p>
                            </a>
                        </li>
                        <li class="nav-item" @click="menu=12">
                            <a href="javascript:void(0)" class="nav-link " :class="[menu===12 ? 'active' : '']">
                                <i class="nav-icon fas fa-info-circle"></i>
                                <p>
                                    Acerca de...
                                </p>
                            </a>
                        </li>
                    @elseif(Auth::user()->idrol == 3)
                        <li class="nav-item has-treeview">
                            <a href="javascript:void(0)" class="nav-link" :class="[menu===1 ? 'active' : '', menu===2 ? 'active' : '']">
                                <i class="nav-icon fas fa-archive"></i>
                                <p>
                                    Almacén
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item" @click="menu=1">
                                    <a href="javascript:void(0)" class="nav-link" :class="[menu===1 ? 'active' : '']">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Categorías </p>
                                    </a>
                                </li>
                                <li class="nav-item" @click="menu=2">
                                    <a href="javascript:void(0)" class="nav-link" :class="[menu===2 ? 'active' : '']">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Artículos</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link" :class="[menu===3 ? 'active' : '' , menu===4 ? 'active' : '']">
                                <i class="nav-icon fas fa-wallet"></i>
                                <p>
                                    Compras
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item" @click="menu=3">
                                    <a href="javascript:void(0)" class="nav-link" :class="[menu===3 ? 'active' : '']">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Ingresos</p>
                                    </a>
                                </li>
                                <li class="nav-item" @click="menu=4">
                                    <a href="javascript:void(0)" class="nav-link" :class="[menu===4 ? 'active' : '']">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Proveedores</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link" :class="[menu===9 ? 'active' : '', menu===10 ? 'active' : '']">
                                <i class="nav-icon fas fa-chart-area"></i>
                                <p>
                                    Reportes
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item" @click="menu=9">
                                    <a href="javascript:void(0)" class="nav-link" :class="[menu===9 ? 'active' : '']">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Reportes de Ingresos</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item" @click="menu=11">
                            <a href="javascript:void(0)" class="nav-link" :class="[menu===11 ? 'active' : '']">
                                <i class="nav-icon fas fa-book-open"></i>
                                <p>
                                    Ayuda
                                </p>
                            </a>
                        </li>
                        <li class="nav-item" @click="menu=12">
                            <a href="javascript:void(0)" class="nav-link " :class="[menu===12 ? 'active' : '']">
                                <i class="nav-icon fas fa-info-circle"></i>
                                <p>
                                    Acerca de...
                                </p>
                            </a>
                        </li>
                    @endif
                @endif
                <!--
                <li class="nav-header">EXAMPLES</li>
                <li class="nav-item">
                    <a href="pages/calendar.html" class="nav-link">
                        <i class="nav-icon fas fa-calendar-alt"></i>
                        <p>
                            Calendar
                            <span class="badge badge-info right">2</span>
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="pages/gallery.html" class="nav-link">
                        <i class="nav-icon far fa-image"></i>
                        <p>
                            Gallery
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-envelope"></i>
                        <p>
                            Mailbox
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="pages/mailbox/mailbox.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Inbox</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/mailbox/compose.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Compose</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/mailbox/read-mail.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Read</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                            Pages
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="pages/examples/invoice.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Invoice</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/examples/profile.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Profile</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/examples/e_commerce.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>E-commerce</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/examples/projects.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Projects</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/examples/project_add.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Project Add</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/examples/project_edit.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Project Edit</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/examples/project_detail.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Project Detail</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/examples/contacts.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Contacts</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-plus-square"></i>
                        <p>
                            Extras
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="pages/examples/login.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Login</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/examples/register.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Register</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/examples/forgot-password.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Forgot Password</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/examples/recover-password.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Recover Password</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/examples/lockscreen.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Lockscreen</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/examples/legacy-user-menu.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Legacy User Menu</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/examples/language-menu.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Language Menu</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/examples/404.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Error 404</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/examples/500.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Error 500</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/examples/pace.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pace</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/examples/blank.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Blank Page</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="starter.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Starter Page</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-header">MISCELLANEOUS</li>
                <li class="nav-item">
                    <a href="https://adminlte.io/docs/3.0" class="nav-link">
                        <i class="nav-icon fas fa-file"></i>
                        <p>Documentation</p>
                    </a>
                </li>
                <li class="nav-header">MULTI LEVEL EXAMPLE</li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-circle nav-icon"></i>
                        <p>Level 1</p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-circle"></i>
                        <p>
                            Level 1
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Level 2</p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Level 2
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Level 3</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Level 3</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Level 3</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Level 2</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-circle nav-icon"></i>
                        <p>Level 1</p>
                    </a>
                </li>
                <li class="nav-header">LABELS</li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-circle text-danger"></i>
                        <p class="text">Important</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-circle text-warning"></i>
                        <p>Warning</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-circle text-info"></i>
                        <p>Informational</p>
                    </a>
                </li>
                -->
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
