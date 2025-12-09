<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="#" class="brand-link">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="brand-image img-circle elevation-3">
        <span class="brand-text font-weight" style="color: white">PANEL DE CONTROL</span>
    </a>

    <div class="sidebar">

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="true">


                @can('sidebar.roles.y.permisos')

                    <li class="nav-item">

                        <a href="#" class="nav-link nav-">
                            <i class="far fa-edit"></i>
                            <p>
                                Roles y Permisos
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.roles.index') }}" target="frameprincipal" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Roles</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('admin.permisos.index') }}" target="frameprincipal" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Usuarios</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('admin.finanzas.index') }}" target="frameprincipal" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Finanzas</p>
                                </a>
                            </li>


                            <!-- CONTROL DE DISTRITO PARA BUZON DE SUGERENCIAS -->

                            <li class="nav-item">
                                <a href="{{ route('admin.distritos.index') }}" target="frameprincipal" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Distritos</p>
                                </a>
                            </li>







                        </ul>
                    </li>

                @endcan

                @can('sidebar.buzon')
                    <li class="nav-item">
                        <a href="{{ route('admin.buzon.nuevo.index') }}" target="frameprincipal" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Nuevo Buzón</p>
                        </a>
                    </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.buzon.todos.index') }}" target="frameprincipal" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Buzón Todos</p>
                            </a>
                        </li>

                @endcan


                @can('sidebar.comunicaciones')

                        <li class="nav-item">
                            <a href="{{ route('admin.slider.index') }}" target="frameprincipal" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Slider</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.noticia.index') }}" target="frameprincipal" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Noticia</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.compras.index') }}" target="frameprincipal" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Compras</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.programa.index') }}" target="frameprincipal" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Programa Municipal</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.servicio.index') }}" target="frameprincipal" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Servicios Municipal</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.sugerencias.index') }}" target="frameprincipal" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sugerencias</p>
                            </a>
                        </li>

                @endcan


                @can('sidebar.ucp')

                    <li class="nav-item">

                        <a href="#" class="nav-link nav-">
                            <i class="far fa-edit"></i>
                            <p>
                                Configuración
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">

                            <li class="nav-item">
                                <a href="{{ route('admin.ucp.index') }}" target="frameprincipal" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>UCP</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('admin.compras.index') }}" target="frameprincipal" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Compras</p>
                                </a>
                            </li>

                        </ul>
                    </li>


                @endcan





            </ul>
        </nav>

    </div>
</aside>
