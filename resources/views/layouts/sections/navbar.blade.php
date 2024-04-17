<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
    id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <ul class="navbar-nav flex-row justify-content-center align-items-center ms-auto">
           
            <div class="flex-grow-1 text-end user-data-info text-truncate">
                <span
                    class="fw-semibold d-block text-truncate">{{ auth()->user()->personal ? auth()->user()->personal->getFullName() : null }} </span>
                    <small class="text-muted">{{  auth()->user()->rol->nombre }}</small>
            </div>
            <!-- Perfil de Usuario -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        <img src="{{ Auth::user()->profile_picture ? Auth::user()->profile_picture : asset('img/avatar-profile.jpg') }}"
                            alt class="w-px-40 h-auto rounded-circle" />
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li class="user-data-item">
                        <a class="dropdown-item" href="javascript:void(0);">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-online">
                                        <img src="{{  auth()->user()->profile_picture ?  auth()->user()->profile_picture : asset('img/avatar-profile.jpg') }}"
                                            alt class="w-px-40 h-auto rounded-circle" />
                                    </div>
                                </div>
                                <div class="flex-grow-1 text-truncate">
                                    <span class="fw-semibold d-block text-truncate">{{ auth()->user()->personal ?   auth()->user()->personal->getFullName() : null }}</span>
                                    {{-- @foreach (Auth::user()->roles as $role)
                                        <small class="text-muted">{{ $role->name }}</small>
                                    @endforeach --}}
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="user-data-item">
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        {{-- <a class="dropdown-item" href="{{ route('my-profile') }}"> --}}
                        <a class="dropdown-item" href="">
                            <i class="bx bx-user me-2"></i>
                            <span class="align-middle">Mi Perfil</span>
                        </a>
                    </li>
                  
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); 
                                document.getElementById('logout-form').submit();">
                            <i class='bx bx-log-out-circle me-2'></i>
                            <span class="align-middle">Cerrar Sesión</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
            <!--/ User -->
        </ul>
    </div>
</nav>

