@extends('layoutm')

@section('title')
    Productos
@endsection


@section('content')
<div class="col-lg">


    <button type="button" class="btn btn-primary mb-4" data-toggle="modal" data-target="#addCategory">Nueva Categoria</button>
    <div class="card card-primary card-outline">
      <div class="card-body">
        <h5 class="card-title">Categorias</h5>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th class="col-1">ID:</th>
                    <th>Pedido</th>
                    
                    <th class="col-1">Edit</th>
                </tr>
            </thead>
            <tbody class="">
                @foreach ($category as $item)
                <tr>
                  <td>{{$item->category_id}}</td>
                  <td>
                    <a href="/product/{{$item->category_id}}" >
                      {{$item->category_categoria}}
                    </a>
                  </td>
                 
                  
                  <td>
                      <button type="button" class="btn btn-primary mb-4" data-toggle="modal" data-target="#updateCategory">
                          Edit
                      </button>
                  </td>
              </tr>
                @endforeach
                
            </tbody>

        </table>
       
      </div>
    </div><!-- /.card -->
  </div>

  <!-- Nueva Categoria -->
<div class="modal fade" id="addCategory" tabindex="-1" role="dialog" aria-labelledby="addCategoryLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Nueva Categoria</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{route('crear.category')}}" method="POST">
              @csrf
                <div class="form-group">
                    <label for="nameCategory">Nombre de la categoria</label>
                    <input type="text" id="idNameCategory" name="nameCategory" class="form-control" placeholder="Ejemplo: Cerveza">
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