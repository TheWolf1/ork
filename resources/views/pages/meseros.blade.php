@extends('layoutm')

@section('title')
    Meseros
@endsection


@section('content')
<div class="col-lg">


    <button type="button" class="btn btn-primary mb-4" data-toggle="modal" data-target="#addCategory">Nuevo mesero</button>
    <div class="card card-primary card-outline">
      <div class="card-body">
        <h5 class="card-title">Mesas</h5>

        <table class="table table-hover">
            <thead>
                <tr>
                    
                    <th>Nombre Mesero</th>
                    <th>Rol</th>
                    <th>Correo:</th>
                    <th class="col-1">Edit</th>
                </tr>
            </thead>
            <tbody class="">
            @foreach ($meseros as $mesero)
                <tr>
                    <td>{{$mesero->name}}</td>
                    <td>{{$mesero->rol}}</td>
                    <td>{{$mesero->email}}</td>
                    <td>
                        <button class="btn btn-primary" onclick="mostrarUser({{$mesero->id}},'{{$mesero->name}}','{{$mesero->rol}}','{{$mesero->email}}')">
                            <i class="fa fa-pen">
                            </i>
                        </button>
                        
                    </td>
                </tr>
            @endforeach
                  
              
                
            </tbody>

        </table>
       
      </div>
    </div><!-- /.card -->
  </div>

  <!-- Nuevo mesero -->
<div class="modal fade" id="addCategory" tabindex="-1" role="dialog" aria-labelledby="addCategoryLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Nuev0 Mesero</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{ route('mesero.crear') }}">
                @csrf

                <div class="row mb-3">
                    <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Nombre') }}</label>

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
                    <label for="rol" class="col-md-4 col-form-label text-md-end">{{ __('Rol') }}</label>

                    <div class="col-md-6">
                       <select class="form-control" name="rol" id="rol">

                        <option value="Mesero">Mesero</option>
                        <option value="Cajero">Cajero</option>
                       </select>

                        @error('rol')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Correo') }}</label>

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
                    <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Contraseña') }}</label>

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
                    <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirmar contraseña') }}</label>

                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>
                </div>

                
            
        </div>
        <div class="modal-footer">
         
          <div class="row mb-0">
                    <div class="col-md-6 ">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Registrar') }}
                        </button>
                    </div>
                </div>
            </form>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </div>
  </div>
  </div>



  <!-- actualizar mesero -->
<div class="modal fade" id="updateMesero" tabindex="-1" role="dialog" aria-labelledby="updateMeseroLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Nuev0 Mesero</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{ route('mesero.actualizar') }}">
                @csrf
                <input type="text" id="idUserUpdate" name="idUserUpdate" hidden>
                <div class="row mb-3">
                    <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Nombre') }}</label>

                    <div class="col-md-6">
                        <input id="nameUp" type="text" class="form-control @error('name') is-invalid @enderror" name="nameUp" value="{{ old('name') }}" required autocomplete="name" autofocus>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="rol" class="col-md-4 col-form-label text-md-end">{{ __('Rol') }}</label>

                    <div class="col-md-6">
                       <select class="form-control" name="rolUp" id="rolUp">

                        <option value="Mesero">Mesero</option>
                        <option value="Cajero">Cajero</option>
                       </select>

                        @error('rol')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="emailUp" class="col-md-4 col-form-label text-md-end">{{ __('Correo') }}</label>

                    <div class="col-md-6">
                        <input id="emailUp" type="email" class="form-control @error('email') is-invalid @enderror" name="emailUp" value="{{ old('email') }}" required autocomplete="email">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Nueva contraseña') }}</label>

                    <div class="col-md-6">
                        <input id="passwordUp" type="password" class="form-control @error('password') is-invalid @enderror" name="passwordUp"  >

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirmar contraseña') }}</label>

                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" >
                    </div>
                </div>

                <div class="row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Actualizar') }}
                        </button>
                    </div>
                </div>
            </form>
            
        </div>
        
      </div>
    </div>
  </div>
  </div>
@endsection

@section('script')
<script src="{{asset('assets/dist/js/meseros.js')}}"></script>
@endsection