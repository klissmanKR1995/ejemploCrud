@extends('layouts.app')

@section('content')


<div class="modal-dialog text-center"> 
    <div class="modal-content login-container">
        <div class="panel panelejemplo">
            <div class="panel-heading"> <h3 class="texto"> <strong> Poder Judicial del Estado de Tlaxcala </strong> </h3> 
            <br> <hr>
                <img src="{{ asset('/images/escudo.png') }}">
            </div>
        </div>
        <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="col-md-4 control-label">Correo electrónico</label>

                <div class="col-md-6">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="password" class="col-md-4 control-label">Contraseña</label>

                <div class="col-md-6">
                    <input id="password" type="password" class="form-control" name="password" required>

                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-8 col-md-offset-2">
                    <button type="submit" class="btn btn-primary">
                        Iniciar Sesión
                    </button>   
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-6"> 
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> 
                            Recordar Sesión
                        </label>
                    </div>
                </div>
                 <div class="col-md-6"> 
                    <div class="checkbox">
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                        ¿Olvidaste tu contraseña?
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<br>

<div class="jumbotron"> </div>

@endsection
