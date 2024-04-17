<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ asset('img/logo-brand1.jpg') }}" alt="Logo Esmuroba" width="57">
            </span>
            <span class="app-brand-text demo menu-text ms-2">Esmuroba</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
      
            <li class="menu-item active">
                <a href="" class="menu-link">
                    <i class='menu-icon tf-icons bx bxs-dashboard'></i>
                    <div data-i18n="Analytics">
                        Dashboard
                    </div>
                </a>
            </li>
      

{{--       
      
            <li class="menu-header small text-uppercase"><span class="menu-header-text">Mi Espacio</span></li>
       
        <li class="menu-item">
          
                <a href="" class="menu-link">
                    <i class='menu-icon tf-icons bx bx-calendar-week'></i>
                    <div>Mis Solicitudes</div>
                </a>
           
           
        </li> --}}

     
      
            <li class="menu-header small text-uppercase"><span class="menu-header-text">Administración</span></li>
                @php
                    $domain = request()->root().'/';
                    $activeM = "";
                    $menuOpen = "";
                @endphp

                @forelse ($menu as $item)
                    @if (!empty($item))
                        
                        @foreach($item->submenus as $subitem)
                            @if (!empty($subitem))
                            
                            @php
                                $ruta = route($subitem->route);
                                $path = str_replace($domain, '', $ruta); //.'/*';
                                $sub_path = str_replace($domain, '', $ruta).'/*';
                                $is_route = request()->is($path) ;
                                $is_sub_route = request()->is($sub_path) ;
                                $active = '';

                                if($is_route || $is_sub_route) {
                                    $active = '';
                                    $activeM = 'active';
                                    $menuOpen = 'active open';
                                }
                            @endphp
                    
                        @endif
                @endforeach
      
            <li class="menu-item {{$menuOpen}}">
                

                <a href="javascript:void(0);" class="menu-link menu-toggle {{$activeM}}">
                    <i class='menu-icon tf-icons {{ $item->icons }}'></i>
                    <div data-i18n="Layouts">{{ $item->nombre_menu }} </div>
                </a>

                <ul class="menu-sub">
                   
                       
                        @foreach($item->submenus as $subitem)
                            @if (!empty($subitem))
                                @php
                                    $ruta = route($subitem->route);
                                    $path = str_replace($domain, '', $ruta); //.'/*';
                                    $sub_path = str_replace($domain, '', $ruta).'/*';
                                    $is_route = request()->is($path) ;
                                    $is_sub_route = request()->is($sub_path) ;
                                    $active = '';

                                    if($is_route || $is_sub_route) {
                                        $active = 'active';
                                        $activeM = "";
                                        $menuOpen = "";
                                    }
                                @endphp

                                <li class="menu-item {{$active}}">
                                    <a href="{{route ($subitem->route) }}" class="menu-link">
                                        <div data-i18n="{{ $subitem->nombre }}">{{ $subitem->nombre }}</div>
                                    </a>
                                </li>
                           
                            @endif
                        @endforeach
                   
                </ul>
            </li>

          
            @endif
            @empty
                
            @endforelse


      
            
        @if (auth()->user()->roles_id == 1) {{-- si el rol es administrador --}}
            <li class="menu-header small text-uppercase"><span class="menu-header-text">Control y Acceso</span></li>
            <li class="menu-item">
                    <a href="{{ route('admin.listUsuarios') }}" class="menu-link">
                        <i class='menu-icon tf-icons bx bx-user'></i>
                        <div data-i18n="Documentation">Usuarios</div>
                    </a>
            
                    <a href="" class="menu-link">
                        <i class='menu-icon tf-icons bx bx-check-shield'></i>
                        <div data-i18n="Documentation">Roles y Permisos</div>
                    </a>
            
            </li>
        @endif
        
    </ul>
</aside>
