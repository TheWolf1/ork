@extends('layoutm')

@section('title')
    Categoria: {{$categoryName->category_categoria}}
@endsection


@section('content')
<div class="col-lg">


    <button type="button" class="btn btn-primary mb-4" data-toggle="modal" data-target="#addCategory">Nuevo producto</button>
    <div class="card card-primary card-outline">
      <div class="card-body">
        <h5 class="card-title">Categoria de {{$categoryName->category_categoria}}</h5>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th class="col-1">ID:</th>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>En Stock</th>
                    <th class="col-1">Edit</th>
                </tr>
            </thead>
            <tbody class="">
             @foreach ($products as $product)
                <tr >
                  <td>{{$product->product_id}}</td>
                  <td>
                     
                        {{$product->product_name}}
                     
                  </td>
                <td>${{$product->product_price}}</td>
                  <td class="@if ($product->product_status==1)
                      bg-success
                  @else
                    bg-danger
                  @endif">
                    @if ($product->product_status==1)
                      Si
                  @else
                      No
                  @endif
                </td>
                  <td>
                      <button type="button" class="btn btn-primary mb-4" onclick="cargarDatosA({{$product->product_id}},'{{$product->product_name}}',{{$product->product_price}},{{$product->product_status}})">
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
          <h5 class="modal-title" id="exampleModalLabel">Nuevo Producto</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{route('crear.product')}}" method="POST">
              @csrf
                <input type="text" value="{{$category}}" name="categoryProduct" hidden>
                <div class="form-group">
                    <label for="nameCategory">Nombre del producto</label>
                    <input type="text" id="idNameCategory" name="nameProduct" class="form-control" placeholder="Ejemplo: Cerveza">
                </div>
                <div class="form-group">
                    <label for="nameCategory">Precio</label>
                    <input type="text" id="idNameCategory" name="priceProduct" class="form-control" placeholder="Ejemplo: 2.50">
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
            <form action="{{route('actualizar.product')}}" method="POST">
            @csrf
              <input type="text" id="idProductUp" name="idProductUp" hidden>
              <input type="text" id="statusProductUp" name="statusProductUp" hidden>
              <input type="text" id="categoryProd" name="categoryProdUp" value="{{$category}}" hidden>
                <div class="form-group">
                    <label for="nameCategory">Nombre del producto</label>
                    <input type="text" id="idNameProd" name="nameProductUp" class="form-control" placeholder="Ejemplo: Cerveza">
                </div>
                <div class="form-group">
                    <label for="nameCategory">Precio</label>
                    <input type="text" id="idPriceProd" name="priceProductUp" class="form-control" placeholder="Ejemplo: 2.50">
                </div>

                <div class="form-group">
                  <label class="d-block">En Stock</label>
                  <input  type="radio" name="si" id="checkSi" >Si</input>
                  <input class="ml-5" type="radio" name="no" id="checkNo">No</input>
              </div>
            
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Eliminar</button>
          <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
    <script>
     function cargarDatosA(id,nombre,precio,estado){
        $("#updateCategory").modal("show");
        $("#idProductUp").val(id);
        $("#idNameProd").val(nombre);
        $("#idPriceProd").val(precio)

        if(estado==1){
          $("#checkSi").prop("checked",true);
          $("#statusProductUp").val(1);
        }else{
          $("#checkNo").prop("checked",true);
          $("#statusProductUp").val(0);
        }
      }
      
      

      $("#checkSi").click(()=>{
        $("#checkSi").prop("checked",true);
        $("#checkNo").prop("checked",false);
        $("#statusProductUp").val(1);
      });

      
      $("#checkNo").click(()=>{
        $("#checkSi").prop("checked",false);
        $("#checkNo").prop("checked",true);
        $("#statusProductUp").val(0);
      });

    </script>
@endsection