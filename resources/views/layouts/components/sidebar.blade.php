<aside class="js-navbar-vertical-aside navbar navbar-vertical-aside navbar-vertical navbar-vertical-fixed navbar-expand-xl navbar-bordered bg-white  ">
    <div class="navbar-vertical-container">
        <div class="navbar-vertical-footer-offset">
            <!-- Logo -->

            <a class="navbar-brand" href="#" aria-label="Front">
                <img class="navbar-brand-logo" src="{{ asset('assets/logos/logo.png') }}" alt="Logo" data-hs-theme-appearance="default">
                <img class="navbar-brand-logo" src="{{ asset('assets/logos/logo.png') }}" alt="Logo" data-hs-theme-appearance="dark">
                <img class="navbar-brand-logo-mini" src="{{ asset('assets/logos/logo.png') }}" alt="Logo" data-hs-theme-appearance="default">
                <img class="navbar-brand-logo-mini" src="{{ asset('assets/logos/logo.png') }}" alt="Logo" data-hs-theme-appearance="dark">
            </a>

            <!-- End Logo -->

            <!-- Navbar Vertical Toggle -->
            <button type="button" class="js-navbar-vertical-aside-toggle-invoker navbar-aside-toggler">
                <i class="bi-arrow-bar-left navbar-toggler-short-align" data-bs-template='<div class="tooltip d-none d-md-block" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>' data-bs-toggle="tooltip" data-bs-placement="right" title="Collapse"></i>
                <i class="bi-arrow-bar-right navbar-toggler-full-align" data-bs-template='<div class="tooltip d-none d-md-block" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>' data-bs-toggle="tooltip" data-bs-placement="right" title="Expand"></i>
            </button>

            <!-- End Navbar Vertical Toggle -->

            <!-- Content -->
            <div class="navbar-vertical-content">
                <div id="navbarVerticalMenu" class="nav nav-pills nav-vertical card-navbar-nav">
                    @if(Auth::user()->hasAnyRoleId([1,2]))
                    <div class="nav-item">
                        <a class="nav-link dropdown-toggle {{ ($activePage == 'dash_general' || $activePage == 'dash_credito' || $activePage == 'dash_cartera' || $activePage == 'dash_inversion' || $activePage == 'dash_ahorro' || $activePage == 'dash_egresos' || $activePage == 'dash_ingresos' )? '': 'collapsed'}}" href="#navbarVerticalDash" role="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalDash" aria-expanded="{{ ($activePage == 'dash_general' || $activePage == 'dash_credito'  || $activePage == 'dash_cartera' || $activePage == 'dash_inversion' || $activePage == 'dash_ahorro' || $activePage == 'dash_egresos' || $activePage == 'dash_ingresos')? 'true': 'false'}}" aria-controls="navbarVerticalDash">
                            <i class="bi-bar-chart-steps nav-icon"></i>
                            <span class="nav-link-title">Dashboard</span>
                        </a>

                        <div id="navbarVerticalDash" class="nav-collapse collapse {{ ($activePage == 'dash_general' || $activePage == 'dash_credito' || $activePage == 'dash_cartera' || $activePage == 'dash_inversion' ||$activePage == 'dash_ahorro' || $activePage == 'dash_egresos' || $activePage == 'dash_ingresos' )? 'show': ''}}" data-bs-parent="#navbarVerticalMenuPagesMenu">
                            <a class="nav-link {{ ($activePage == 'dash_general')? 'active': ''}}" href="{{ url('dash_general') }}">General</a>
                        </div>
                    </div>
                    @endif

                    @if(Auth::user()->hasAnyRoleId([1,2,3,4,5,6]))
                    <div class="nav-item">
                        <a class="nav-link dropdown-toggle {{ ($activePage == 'lista' ||$activePage == 'clientes' )? '': 'collapsed'}}" href="#navbarMenuCrm" role="button" data-bs-toggle="collapse" data-bs-target="#navbarMenuCrm" aria-expanded=" {{ ($activePage == 'lista' ||$activePage == 'clientes')? 'true': 'false'}}" aria-controls="navbarMenuCrm">
                            <i class="bi-building nav-icon"></i>
                            <span class="nav-link-title">Manufactura</span>
                        </a>
                        <div id="navbarMenuCrm" class="nav-collapse collapse  {{ ($activePage == 'lista' ||$activePage == 'clientes' )? 'show': ''}}" data-bs-parent="#navbarVerticalMenuPagesMenu">
                            {{-- <a class="nav-link {{ ($activePage == 'leads')? 'active': ''}}" href="{{ route('leads.index') }}">Leads -</a> --}}
                            <a class="nav-link {{ ($activePage == 'clientes')? 'active': ''}}" href="{{ route('clientes.index') }}">Presupuestos</a>
                            <a class="nav-link {{ ($activePage == 'clientes')? 'active': ''}}" href="{{ route('clientes.index') }}">Ordenes de compra</a>
                            <a class="nav-link {{ ($activePage == 'clientes')? 'active': ''}}" href="{{ route('clientes.index') }}">Lista de materias</a>
                            <a class="nav-link {{ ($activePage == 'clientes')? 'active': ''}}" href="{{ route('clientes.index') }}">Administración de fases de manufactura</a>
                            <a class="nav-link {{ ($activePage == 'clientes')? 'active': ''}}" href="{{ route('clientes.index') }}">Administración de áreas de producción</a>
                            <a class="nav-link {{ ($activePage == 'clientes')? 'active': ''}}" href="{{ route('clientes.index') }}">Tipos de ordenes de trabajo</a>
                            <a class="nav-link {{ ($activePage == 'clientes')? 'active': ''}}" href="{{ route('clientes.index') }}">Planeación de manufactura</a>
                            <a class="nav-link {{ ($activePage == 'clientes')? 'active': ''}}" href="{{ route('clientes.index') }}">Matenimiento</a>
                        </div>
                    </div>
                    @endif
                    
                    @if(Auth::user()->hasAnyRoleId([1,2,3,4,5,6]))
                    <div class="nav-item">
                        <a class="nav-link dropdown-toggle {{ ($activePage == 'lista' ||$activePage == 'clientes' )? '': 'collapsed'}}" href="#navbarMenuCrm" role="button" data-bs-toggle="collapse" data-bs-target="#navbarMenuCrm" aria-expanded=" {{ ($activePage == 'lista' ||$activePage == 'clientes')? 'true': 'false'}}" aria-controls="navbarMenuCrm">
                            <i class="bi-person-circle nav-icon"></i>
                            <span class="nav-link-title">Clientes</span>
                        </a>
                        <div id="navbarMenuCrm" class="nav-collapse collapse  {{ ($activePage == 'lista' ||$activePage == 'clientes' )? 'show': ''}}" data-bs-parent="#navbarVerticalMenuPagesMenu">
                            {{-- <a class="nav-link {{ ($activePage == 'leads')? 'active': ''}}" href="{{ route('leads.index') }}">Leads -</a> --}}
                            <a class="nav-link {{ ($activePage == 'clientes')? 'active': ''}}" href="{{ route('clientes.index') }}">Clientes</a>
                        </div>
                    </div>
                    @endif
                
                    @if(Auth::user()->hasAnyRoleId([1,2]))
                    <div class="nav-item">
                        <a class="nav-link dropdown-toggle {{ ($activePage == 'egresos' || $activePage == 'ingresos')? '': 'collapsed'}}" href="#navbarMenuEgresos" role="button" data-bs-toggle="collapse" data-bs-target="#navbarMenuEgresos" aria-expanded=" {{ ($activePage == 'egresos' || $activePage == 'ingresos')? 'true': 'false'}}" aria-controls="navbarMenuEgresos">
                            <i class="bi-cart4 nav-icon"></i>
                            <span class="nav-link-title">Contabilidad y cuentas</span>
                        </a>
                        <div id="navbarMenuEgresos" class="nav-collapse collapse  {{ ($activePage == 'egresos'  || $activePage == 'ingresos')? 'show': ''}}" data-bs-parent="#navbarVerticalMenuPagesMenu">
                            <a class="nav-link {{ ($activePage == 'egresos')? 'active': ''}}" href="{{ route('egresos.index') }}">Egresos</a>
                            <a class="nav-link {{ ($activePage == 'ingresos')? 'active': ''}}" href="{{ route('ingresos.index') }}">Ingresos</a>
                            <a class="nav-link {{ ($activePage == 'ingresos')? 'active': ''}}" href="{{ route('ingresos.index') }}">Cuentas por cobrar</a>
                            <a class="nav-link {{ ($activePage == 'ingresos')? 'active': ''}}" href="{{ route('ingresos.index') }}">Cuentas por pagar</a>
                        </div>
                    </div>
                    @endif
                    <div class="nav-item">
                        <a class="nav-link {{ ($activePage == 'reportes')? 'active': ''}}" href="{{ url('reportes') }}" data-placement="left">
                          <i class="bi-flag nav-icon"></i>
                          <span class="nav-link-title">Reportes</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link dropdown-toggle {{ ($activePage == 'productos' || $activePage == 'articulos' || $activePage == 'inventarios' || $activePage == 'movimientos')? '': 'collapsed'}}" href="#navbarMenuInventario" role="button" data-bs-toggle="collapse" data-bs-target="#navbarMenuInventario" aria-expanded=" {{ ($activePage == 'productos' || $activePage == 'articulos' || $activePage == 'inventarios' || $activePage == 'movimientos')? 'true': 'false'}}" aria-controls="navbarMenuInventario">
                            <i class="bi-shop nav-icon"></i>
                            <span class="nav-link-title">Inventario</span>
                        </a>
                        <div id="navbarMenuInventario" class="nav-collapse collapse  {{ ($activePage == 'productos'  || $activePage == 'articulos' || $activePage == 'inventarios' || $activePage == 'movimientos')? 'show': ''}}" data-bs-parent="#navbarVerticalMenuPagesMenu">
                            <a class="nav-link {{ ($activePage == 'productos')? 'active': ''}}" href="{{ route('productos.index') }}">Productos N.A.</a>
                            <a class="nav-link {{ ($activePage == 'articulos')? 'active': ''}}" href="{{ route('articulos.index') }}">Articulos</a>
                            <a class="nav-link {{ ($activePage == 'inventarios')? 'active': ''}}" href="{{ route('inventarios.index') }}">Inventario</a>
                            <a class="nav-link {{ ($activePage == 'movimientos')? 'active': ''}}" href="{{ route('movimientos.index') }}">Movimientos</a>
                        </div>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link dropdown-toggle {{ ($activePage == 'ventas' || $activePage == 'ingresos')? '': 'collapsed'}}" href="#navbarMenuVentas" role="button" data-bs-toggle="collapse" data-bs-target="#navbarMenuVentas" aria-expanded=" {{ ($activePage == 'ventas' || $activePage == 'ingresos')? 'true': 'false'}}" aria-controls="navbarMenuVentas">
                            <i class="bi-cash-stack nav-icon"></i>
                            <span class="nav-link-title">Ventas</span>
                        </a>
                        <div id="navbarMenuVentas" class="nav-collapse collapse  {{ ($activePage == 'ventas'  || $activePage == 'ingresos')? 'show': ''}}" data-bs-parent="#navbarVerticalMenuPagesMenu">
                            <a class="nav-link {{ ($activePage == 'ventas')? 'active': ''}}" href="{{ route('ventas.index') }}">Ventas</a>
                            <a class="nav-link {{ ($activePage == 'ingresos')? 'active': ''}}" href="{{ route('ingresos.index') }}">Ingresos</a>
                        </div>
                    </div>
                    
                    @if(Auth::user()->hasAnyRoleId([1,2]))
                    <div class="nav-item">
                        <a class="nav-link dropdown-toggle {{ ($activePage == 'compras' ||$activePage == 'rutas' || $activePage == 'productos' || $activePage == 'cat_inversiones' || $activePage == 'bancos' || $activePage == 'cat_ahorros')? '': 'collapsed'}}" href="#navbarVerticalCompras" role="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalCompras" aria-expanded=" {{ ($activePage == 'compras' ||$activePage == 'rutas' || $activePage == 'productos' || $activePage == 'cat_inversiones' || $activePage == 'bancos' || $activePage == 'cat_ahorros' )? 'true': 'false'}}" aria-controls="navbarVerticalCompras">
                            <i class="bi-piggy-bank nav-icon"></i>
                            <span class="nav-link-title">Compras</span>
                        </a>
                        <div id="navbarVerticalCompras" class="nav-collapse collapse  {{ ($activePage == 'compras' ||$activePage == 'rutas' || $activePage == 'productos' || $activePage == 'cat_inversiones'  || $activePage == 'bancos' || $activePage == 'cat_ahorros' )? 'show': ''}}" data-bs-parent="#navbarVerticalMenuPagesMenu">
                            <a class="nav-link {{ ($activePage == 'compras')? 'active': ''}}" href="{{ route('compras.index') }}">Compras</a>                            
                        </div>
                        <div id="navbarVerticalCompras" class="nav-collapse collapse  {{ ($activePage == 'compras' ||$activePage == 'rutas' || $activePage == 'productos' || $activePage == 'cat_inversiones'  || $activePage == 'bancos' || $activePage == 'cat_ahorros' )? 'show': ''}}" data-bs-parent="#navbarVerticalMenuPagesMenu">
                            <a class="nav-link {{ ($activePage == 'compras')? 'active': ''}}" href="{{ route('compras.index') }}">Ordenes de compra</a>                            
                        </div>
                        <div id="navbarVerticalCompras" class="nav-collapse collapse  {{ ($activePage == 'compras' ||$activePage == 'rutas' || $activePage == 'productos' || $activePage == 'cat_inversiones'  || $activePage == 'bancos' || $activePage == 'cat_ahorros' )? 'show': ''}}" data-bs-parent="#navbarVerticalMenuPagesMenu">
                            <a class="nav-link {{ ($activePage == 'compras')? 'active': ''}}" href="{{ route('compras.index') }}">Devolución de compra</a>                            
                        </div>
                    </div>
                    @endif
                    @if(Auth::user()->hasAnyRoleId([1,2]))
                    <div class="nav-item">
                        <a class="nav-link dropdown-toggle {{ ($activePage == 'proveedores' ||$activePage == 'almacen' || $activePage == 'productos' || $activePage == 'sucursales' || $activePage == 'bancos' || $activePage == 'lineas' || $activePage == 'marcas')? '': 'collapsed'}}" href="#navbarVerticalCatalogos" role="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalCatalogos" aria-expanded=" {{ ($activePage == 'proveedores' ||$activePage == 'almacen' || $activePage == 'productos' || $activePage == 'sucursales' || $activePage == 'bancos' || $activePage == 'lineas' || $activePage == 'marcas' )? 'true': 'false'}}" aria-controls="navbarVerticalCatalogos">
                            <i class="bi-archive nav-icon"></i>
                            <span class="nav-link-title">Catálogos</span>
                        </a>
                        <div id="navbarVerticalCatalogos" class="nav-collapse collapse  {{ ($activePage == 'proveedores' ||$activePage == 'almacen' || $activePage == 'productos' || $activePage == 'sucursales'  || $activePage == 'bancos' || $activePage == 'lineas' || $activePage == 'marcas' )? 'show': ''}}" data-bs-parent="#navbarVerticalMenuPagesMenu">
                            <a class="nav-link {{ ($activePage == 'bancos')? 'active': ''}}" href="{{ route('bancos.index') }}">Bancos</a>                            
                            <a class="nav-link {{ ($activePage == 'proveedores')? 'active': ''}}" href="{{ route('proveedores.index') }}">Proveedores</a>                            
                            <a class="nav-link {{ ($activePage == 'almacen')? 'active': ''}}" href="{{ route('almacen.index') }}">Almacenes</a>                            
                            <a class="nav-link {{ ($activePage == 'sucursales')? 'active': ''}}" href="{{ route('sucursales.index') }}">Sucursales</a>                            
                            <a class="nav-link {{ ($activePage == 'lineas')? 'active': ''}}" href="{{ route('lineas.index') }}">Líneas</a>                            
                            <a class="nav-link {{ ($activePage == 'marcas')? 'active': ''}}" href="{{ route('marcas.index') }}">Marcas</a>                            
                            <a class="nav-link {{ ($activePage == 'marcas')? 'active': ''}}" href="{{ route('marcas.index') }}">Formatos</a>                            
                        </div>
                    </div>
                    @endif
                    @if(Auth::user()->hasAnyRoleId([1,2,3,4,5,6]))
                    <div class="nav-item">
                        <a class="nav-link dropdown-toggle {{ ($activePage == 'usuarios' || $activePage == 'perfil' || $activePage == 'empresa')? '': 'collapsed'}}" href="#navbarVerticalMenuPagesUsersMenu" role="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalMenuPagesUsersMenu" aria-expanded=" {{ ($activePage == 'usuarios' || $activePage == 'perfil' || $activePage == 'empresa')? 'true': 'false'}}" aria-controls="navbarVerticalMenuPagesUsersMenu">
                            <i class="bi-gear nav-icon"></i>
                            <span class="nav-link-title">Configuración</span>
                        </a>
                        <div id="navbarVerticalMenuPagesUsersMenu" class="nav-collapse collapse  {{ ($activePage == 'usuarios' || $activePage == 'perfil' || $activePage == 'empresa')? 'show': ''}}" data-bs-parent="#navbarVerticalMenuPagesMenu">
                            @if(Auth::user()->hasAnyRoleId([1,2]))
                            <a class="nav-link {{ ($activePage == 'usuarios')? 'active': ''}}" href="{{ route('usuarios.index') }}">Usuarios</a>
                            @endif
                            <a class="nav-link {{ ($activePage == 'perfil')? 'active': ''}}" href="{{ route('perfil.index') }}">Perfil</a>
                            <a class="nav-link {{ ($activePage == 'empresa')? 'active': ''}}" href="{{ route('empresa.index') }}">Empresa</a>
                        </div>
                    </div>
                    @endif
                </div>

            </div>
            <!-- End Content -->
        </div>
    </div>
</aside>
