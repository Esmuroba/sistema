@extends('layouts.auth')

@section('title', 'Registrarse')

@section('content')
           
<body>
    <!-- Content -->
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Register Card -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        @if (session('mensaje'))
                            <div class="alert alert-success">
                            <h5>{{session('titulo')}}</h5>
                                {{session('mensaje')}}
                            </div>
                        @elseif(session('error'))
                            <div class="alert alert-danger">
                                {{session('error')}}
                            </div>
                        @endif
                        <div class="app-brand justify-content-center align-items-center">
                            <img src="{{ asset('img/logo-brand1.jpg') }}" alt="Cumplo y Avanzo" width="27">
                            <span class="app-brand-text demo {{-- text-body --}} fw-semibold">Esmuroba</span>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-2">Compártenos tus datos</h4>
                        <p class="mb-4">Para crear tu cuenta, debes de pertenecer a una empresa registrada en nuestro sistema</p>

                        <form id="saveform" method="POST" action="{{ route('registro.store')  }}" autocomplete="off">
                        @csrf                            
                            <div class="mb-3">
                                <label for="curp" class="form-label">CURP</label>
                                <input type="text" class="form-control" id="curp" name="curp" value="{{ old('curp') }}"
                                    placeholder="Ingresa tu CURP" />
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Correo electrónico</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}"
                                    placeholder="Ingresa tu correo electrónico" />
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <label class="form-label" for="password">Contraseña</label><br>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password" value="{{ old('password') }}"/>
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                                @if ($errors->has('password'))
                                    <p class="mb-4 text-danger">{{ $errors->first('password') }}</p>
                                @endif
                                <small>La contraseña debe contener:
                                    <li>Mínimo 8 caracteres</li>
                                    <li>Letras en Mayúscula</li>
                                    <li>Letras en Minúscula</li>
                                    <li>Número</li>
                                </small>

                               
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="terms"
                                        name="terms" required/>
                                    <label class="form-check-label" for="terms-conditions">
                                        Acepto los <a  href="https://google.com" target="_blank" title="Click para ver Términos y Condiciones">términos y condiciones</a>
                                    </label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary d-grid w-100">Registrarse</button>
                        </form>

                        <p class="text-center">
                            <span>¿Ya tienes una cuenta?</span>
                            <a href="{{ route('login') }}">
                                <span>Iniciar sesión</span>
                            </a>
                        </p>
                    </div>
                </div>

        </div>
    </div>
@endsection



{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}

<script>

window.addEventListener("DOMContentLoaded", (e) => {

  const checkForm = (e) => {
    const form = e.target;
  
    if(!form.terms.checked) {
      form.terms.focus();
      e.preventDefault();
      return; /* equivalent to return false */
    }
  };

  const myForm        = document.querySelector("#saveform");
  const myCheckbox    = myForm.querySelector("#terms");
  const myCheckboxMsg = "Por favor indique que acepta los Términos y Condiciones";

  /* attach the form submit handler */
  myForm.addEventListener("submit", checkForm);

  /* set the starting error message */
  myCheckbox.setCustomValidity(myCheckboxMsg);

  /* attach checkbox handler to toggle error message */
  myCheckbox.addEventListener("change", (e) => {
    let el = e.target;
    el.setCustomValidity(el.validity.valueMissing ? myCheckboxMsg : "");
  });

});

</script>
