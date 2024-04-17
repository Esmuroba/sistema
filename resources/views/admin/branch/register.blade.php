@extends('layouts.app')

@section('title', 'Registrar Sucursal')

@section('section-name', 'Usuarios')

@section('content')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Clientes / Sucursal / </span>Registrar</h4>
    <!-- Basic Layout -->
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-center align-items-center">
                    <h5 class="mb-0">Datos de la Sucursal</h5>
                </div>
                <div class="card-body">
                <form method="POST" action="" autocomplete="off">
                @csrf
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="" class="form-label">Nombre</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text">
                                    <i class="bx bx-buildings"></i>
                                </span>
                                <input type="text" id="name_branch" name="name_branch" class="form-control text-uppercase" placeholder="Nombre de la Sucursal"/>
                            </div>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="" class="form-label">RFC</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text">
                                    <i class="bx bx-file"></i>
                                </span>
                                <input type="text" id="rfc" name="rfc" class="form-control text-uppercase" placeholder="Rfc"/>
                            </div>
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="" class="form-label">Teléfono</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text">
                                    <i class="bx bx-phone"></i>
                                </span>
                                <input type="text" id="phone" name="phone" class="form-control" placeholder="Teléfono"/>
                            </div>
                        </div>
                       
                        <div class="mb-3 col-md-2">
                            <label for="" class="form-label">Extensión</label>
                                <input type="text" id="ext" name="ext" class="form-control" placeholder="Extensión"/>
                        </div>
                       
                        <div class="mb-3 col-md-6">
                            <label for="" class="form-label">Calle</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text">
                                    <i class="bx bx-map"></i>
                                </span>
                                <input type="text" id="street" name="street" class="form-control text-uppercase" placeholder="Calle"/>
                            </div>
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="" class="form-label">Núm. Exterior</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text">
                                    <i class="bx bx-hash"></i>
                                </span>
                                <input type="text" id="num_ext" name="num_ext" class="form-control text-uppercase" placeholder="Numero Exterior"/>
                            </div>
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="" class="form-label">Núm. Interior</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text">
                                    <i class="bx bx-hash"></i>
                                </span>
                                <input type="text" id="num_int" name="num_int" class="form-control text-uppercase" placeholder="Numero Interior"/>
                            </div>
                        </div>
                       
                        <div class="mb-3 col-md-6">
                            <label for="cp" class="form-label">Codigo Postal</label>
                            <div class="input-group input-group-merge" id="theCp">
                                <span class="input-group-text">
                                    <i class="bx bx-file-find"></i>
                                </span>
                                <input name="cp" id="cp" type="text" class="form-control text-uppercase " autocomplete="off" maxlength="5" onfocusout="searchCp(this)">
                            </div>
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="" class="form-label">Ciudad</label>
                            <div class="input-group input-group-merge" id="theCity">
                                <span class="input-group-text">
                                    <i class="bx bx-building-house"></i>
                                </span>
                                <input name="city" id="city" type="text" class="form-control text-uppercase" autocomplete="off" readonly>
                            </div>
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="" class="form-label">Estado</label>
                            <div class="input-group input-group-merge" id="theState">
                                <span class="input-group-text">
                                    <i class="bx bx-building"></i>
                                </span>
                                <input name="state" id="state" type="text" class="form-control text-uppercase" autocomplete="off" readonly>
                            </div>
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="" class="form-label">Colonia</label>
                            <div class="input-group input-group-merge" id="theSuburb">
                                <span class="input-group-text">
                                    <i class="bx bx-home"></i>
                                </span>
                                <select name="suburb" id="suburb" class="form-control theSuburbs" type="select" >
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                       
                        <!-- <div class="mb-3 col-md-3">
                            <label for="" class="form-label">Delegación o Municipio</label>
                            <div class="input-group input-group-merge" id="theCity">
                                <span class="input-group-text">
                                    <i class="bx bx-home"></i>
                                </span>
                                <input name="town" id="town" type="text" class="form-control text-uppercase" autocomplete="off">

                            </div>
                        </div>
                        -->
                       
                    </div>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary me-2">Guardar</button>
                        <a type="button" href="{{ route('admin.enterprise') }}" class="btn btn-outline-secondary">Cerrar</a>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

<script >

    function searchCp(input) {
        cp = $('#cp').val();
        if(cp.length == 5){
            $.ajax({
                type: "POST",
                url: "{{ url('/api/checkCp') }}",
                data: {
                    cp : cp
                },
                success:function(data){
                    $(".theSuburbs").empty().trigger('change');
                    if(data != 'Resultado no encontrado'){
                        cpError = 0;
                        $('#cp').removeClass('is-invalid');
                        $('#cp').addClass('is-valid');
                        $('#cpError').remove();
                        $('#city').val(data.Ciudad);
                        $('#state').val(data.Estado);
                        $('#town').val(data.Municipio);
                        let theSuburbs = data.Asentamiento;
                        var data = {};

                        theSuburbs.forEach(function(theCurrentSuburb){
                            data.id = theCurrentSuburb;
                            data.text = theCurrentSuburb;
                            var newOption = new Option(data.text, data.id, false, false);
                            $('#suburb').append(newOption).trigger('change');
                        });
                    }
                    else {
                        cpError = 1;
                        $('#cp').addClass('is-invalid');
                        $('#cpError').remove();
                        $('#theCp').append('<span class="invalid-feedback" id="cpError" role="alert"><strong>No se ha encontrado ese C.P.</strong></span>');
                    }
                }
            });
        }
        else {
            $('#cp').addClass('is-invalid');
            $('#cpError').remove();
            $('#theCp').append('<span class="invalid-feedback" id="cpError" role="alert"><strong>El código postal debe contener 5 números.</strong></span>');
        }
    };
</script>

