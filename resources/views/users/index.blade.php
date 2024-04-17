@extends('layouts.app')

@section('title', 'Usuarios')

@section('section-name', 'Usuarios')

@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible d-flex" role="alert">
            <span class="badge badge-center rounded-pill bg-success border-label-success p-3 me-2">
                <i class='bx bx-check-circle bx-sm'></i>
            </span>
            <div class="d-flex flex-column ps-1">
                <h5 class="alert-heading d-flex align-items-center fw-bold mb-1">¡Hecho! 👍</h5>
                <span>{{ Session::get('success') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">/</span> Usuarios</h4>
    <div class="row">
        <div class="d-flex mb-3 gap-3 justify-content-end align-items-center">
            <span class="badge bg-label-primary rounded-2">
                <i class='bx bx-user bx-md'></i>
            </span>
            {{-- <a href="{{ route('users.create') }}" class="btn btn-primary">
                <span>
                    <i class="bx bx-plus me-0 me-sm-1"></i>
                    <span class="d-none d-sm-inline-block">Crear Usuario</span>
                </span>
            </a> --}}
        </div>
    </div>
    @if (count($users) > 0)
        <div class="card">
            <h5 class="card-header">Usuarios</h5>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Estatus</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($users as $user)
                            <tr>
                                <td class="d-flex align-items-center">
                                    <div class="avatar me-2">
                                        <img src="{{ asset('img/avatar-profile.jpg') }}" alt="Empleado"
                                            class="rounded-circle" />
                                    </div>
                                    <strong class="text-primary">{{ $user->personal->getFullName() }}</strong>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    {{ $user->rol->nombre }}
                                </td>
                                <td>
                                    @if ($user->personal->state == 'Activo')
                                        <span class="badge bg-label-primary me-1">{{ $user->personal->state }}</span>
                                    @else
                                        <span class="badge bg-label-danger me-1">{{ $user->personal->state }}</span>
                                    @endif
                                </td>
                              
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination justify-content-end">
                    {{ $users->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    @else
        <div class="d-flex justify-content-center container-xxl container-p-y">
            <div class="misc-wrapper text-center">
                <h2 class="mb-2 mx-2">No hay nada para mostrar :(</h2>
                <p class="mb-4 mx-2">Lo sentimos! 😞 Revisa tu búsqueda o crea un nuevo usuario.</p>
                <div class="mt-3">
                    <img src="{{ asset('img/no-data.svg') }}" alt="page-misc-error-light" width="400" class="img-fluid"
                        data-app-dark-img="illustrations/page-misc-error-dark.png"
                        data-app-light-img="illustrations/page-misc-error-light.png" />
                </div>
            </div>
        </div>
    @endif
@endsection
