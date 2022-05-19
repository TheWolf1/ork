@extends('layoutm')

@section('title')
    Mesas
@endsection


@section('content')
<div class="col-lg">


    <button type="button" class="btn btn-primary mb-4" data-toggle="modal" data-target="#addCategory">Nueva mesa</button>
    <div class="card card-primary card-outline">
      <div class="card-body">
        <h5 class="card-title">Mesas</h5>

        <table class="table table-hover">
            <thead>
                <tr>
                    
                    <th>Nombre mesa</th>
                    
                    <th class="col-1">Edit</th>
                </tr>
            </thead>
            <tbody class="">
              @foreach ($mesas as $mesa)
                  <tr>
                    <td>{{$mesa->Mesa}}</td>
                    <td>
                        <button class="btn btn-primary">
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

  <!-- Nueva Mesa -->
<div class="modal fade" id="addCategory" tabindex="-1" role="dialog" aria-labelledby="addCategoryLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Nueva Mesa</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{route('mesas.crear')}}" method="POST">
              @csrf
                <div class="form-group">
                    <label for="nameMesa">Nombre de la mesa</label>
                    <input type="text" id="idNameMesa" name="nameMesa" class="form-control" placeholder="Ejemplo: Cerveza">
                </div>
            
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
        </div>
      </div>
    </div>
  </div>

    <!-- actualizar Categoria -->
<div class="modal fade" id="updateCategory" tabindex="-1" role="dialog" aria-labelledby="updateCategoryLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Editar categoria</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="">
              <div class="form-group">
                  <label for="UnameCategory">Nombre de la categoria</label>
                  <input type="text" id="idUNameCategory" name="UnameCategory" class="form-control" placeholder="Ejemplo: Cerveza">
              </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Eliminar</button>
          <button type="button" class="btn btn-primary">Guardar Cambios</button>
        </div>
      </div>
    </div>
  </div>
@endsection