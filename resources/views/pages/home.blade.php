@extends('layoutm')

@section('title')
    Inicio
@endsection


@section('css')
<!-- DataTables -->
  <link rel="stylesheet" href="{{asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection
@section('content')
<div class="col-lg">


    <button class="btn btn-lg btn-primary m-3" data-toggle="modal" data-target="#newOrder">Nuevo pedido</button>
    <div class="card card-primary card-outline">
      <div class="card-body">
        <h5 class="card-title">Pedidos po cobrar</h5>

        <table class="table table-hover" id="tbPedidos">
            <thead>
                <tr>
                    <th class="col-1">Mesa:</th>
                    <th>Pedido</th>
                    <th class="col-2">Cliente:</th>
                    <th class="col-2">Mesero</th>
                    <th class="col-2">Total</th>
                    <th class="col-1">Pagar</th>
                    <th class="col-1">Editar</th>
                </tr>
            </thead>
            <tbody class="">
                @foreach ($pedidos as $pedido)
                  <tr>
                    <td>{{$pedido->Mesa}}</td>


                    @php
                      $objPedido = json_decode($pedido->pedido_obj);
                    @endphp
                    
                    <td>
                      <ul>
                    @foreach ($objPedido as $pedObj)
                      @if (empty($pedObj->description))
                          <li>{{$pedObj->cant}} {{$pedObj->nombre}}  </li>
                      @else
                        
                          <li>{{$pedObj->cant}} {{$pedObj->nombre}}  "{{$pedObj->description}}" </li>
                        
                      @endif
                     @endforeach

                     
                     
                    
                        
                            
                            
                        </ul>
                    </td>
                    <td >{{$pedido->pedido_cliente}}</td>
                    <td>{{$pedido->name}}</td>
                    <td>
                     ${{$pedido->pedido_precio}}
                    </td>

                    <td>
                        <button class="btn btn-success" onclick="btnPagar({{$pedido->pedido_id}},{{$pedido->pedido_precio}})">
                            $
                        </button>
                    </td>
                    <td>
                      <button class="btn btn-primary" onclick="updateOrder({{$pedido->pedido_id}},'{{$pedido->pedido_cliente}}',{{$pedido->pedido_mesa}},{{$pedido->pedido_obj}},{{$pedido->pedido_precio}})">
                      
                        <i class="fa fa-pen"></i>
                      </button>
                    </td>
                </tr>   
                @endforeach
               
            </tbody>

        </table>
       
      </div>
    </div><!-- /.card -->
  </div>

    <!-- Nueva Orden -->
<div class="modal fade " id="newOrder" tabindex="-1" role="dialog" aria-labelledby="newOrderLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">

          <h5 class="modal-title" id="exampleModalLabel">Nuevas  Ordenes</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

            <form action="{{route('crear.pedido')}}" method="POST">
              @csrf
                <div class="form-group">
                    <label for="idNameCliente">Nombre cliente:</label>
                    <input type="text" name="nombreCliente" id="idNameCliente" class="form-control" placeholder="Ejemplo: Juan Cevallos" required>
                </div>
                <div class="form-group">
                    <label for="idMesaCliente">Mesa:</label>
                    <select class="form-control" name="mesaCliente" id="idMesaCliente">
                      @foreach ($mesas as $mesa)
                          <option value="{{$mesa->mesa_id}}">{{$mesa->Mesa}}</option>
                      @endforeach 
                        
                    </select>
                </div>
                <textarea name="txtProductJson" id="txtProductJson" cols="30" rows="10" hidden></textarea>
                <input type="text" name="precioTotal" id="precioTotalId" hidden>
                <div class="form-group">
                    <label for="idProductos">Productos del pedido:</label>
                    <ul id="listOfProducts">
                        
                    </ul>
                    
                    
                </div>
            <hr>
            <h3>Total: <b id="totalPrecio"></b></h3>
                <button type="submit" class="btn btn-primary">Crear pedido</button>
              </form>
            <hr>
            <h4>BUSCAR PRODUCTOS</h4>
            <table id="tbProductos" class="table table-bordered table-hover">
                <thead>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Categoria</th>
                    <th>Agregar</th>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                    <tr>
                        <td>{{$product->product_name}}</td>
                        <td>${{$product->product_price}}</td>
                        <td>{{$product->category_categoria}}</td>
                        <td>
                            <button class="btn btn-success" onclick="agregarProducto({{$product->product_id}},'{{$product->product_name}}',{{$product->product_price}})"><i class="fa fa-circle-add"></i></button>
                        </td>
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
            <hr>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          
        </div>
      </div>
    </div>
  </div>
<!-- Actualizar orden -->
  <div class="modal fade " id="updateOrder" tabindex="-1" role="dialog" aria-labelledby="updateOrderLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Actualizar orden Orden</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
  
            <form action="{{route('actualizar.pedido')}}" method="POST">
              @csrf
                <input type="text" id="idUpdate" name="txtIdUpdate" hidden>
                <div class="form-group">
                    <label for="idNameCliente">Nombre:</label>
                    <input type="text" name="nombreClienteUp" id="idNameClienteUp" class="form-control" placeholder="Ejemplo: Juan Cevallos">
                </div>
                <div class="form-group">
                    <label for="idMesaCliente">Mesa:</label>
                    <select class="form-control" name="mesaClienteUp" id="idMesaClienteUp">
                      @foreach ($mesas as $mesa)
                          <option value="{{$mesa->mesa_id}}">{{$mesa->Mesa}}</option>
                      @endforeach
                        
                    </select>
                </div>
                <textarea name="txtProductJsonUp" id="txtProductJsonUp" cols="30" rows="10" hidden></textarea>
                <input type="text" name="precioTotalUp" id="precioTotalIdUp" hidden>
                <div class="form-group">
                    <label for="idProductos">Productos del pedido:</label>
                    <ul id="listOfProductsUp">
                        
                    </ul>
                    
                    
                </div>
            <hr>
            <h3>Total: <b id="totalPrecioUp"></b></h3>
                <button type="submit" class="btn btn-success">Actualizar pedido</button>
              </form>
            <hr>
            <h4>BUSCAR PRODUCTOS</h4>
            <table id="tbProductosUp" class="table table-bordered table-hover">
                <thead>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Categoria</th>
                    <th>Agregar</th>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                    <tr>
                        <td>{{$product->product_name}}</td>
                        <td>${{$product->product_price}}</td>
                        <td>{{$product->category_categoria}}</td>
                        <td>
                            <button class="btn btn-success" onclick="agregarProductoUpdate({{$product->product_id}},'{{$product->product_name}}',{{$product->product_price}})"><i class="fa fa-circle-add"></i></button>
                        </td>
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
            <hr>
        </div>
        <div class="modal-footer">
          <form action="{{route('eliminar.pedido')}}" method="POST" id="formDelPedido">
             @csrf
             <input type="text" name="DelPedidoName" id="idDelPedidoName" hidden>
             <button type="submit" class="btn btn-danger"  id="btnEliminarPedido"   data-dismiss="modal">Eliminar Orden</button>
          </form>
         
          
        </div>
      </div>
    </div>
  </div>    





    <!-- cantidad de productos -->
    <div class="modal fade" id="cantidadProd" tabindex="-1" role="dialog" aria-labelledby="cantidadProdLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Agregar producto</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <label id="idProds"></label>
              <h3>Producto: <label id="nameProd"></label></h3>
              <h3>Precio: <label id="priceProd"></label></h3>
              <label for="idCantProd"></label>
              <input class="form-control" type="number" name="" id="idCantProd" min="1" max="15" placeholder="ingrese la cantida">

              <label for="">Descripcion:</label>
              <textarea class="form-control" name="productosSeleccion" id="idDescriptionProd" cols="10" rows="5" ></textarea>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Eliminar</button>
              <button type="button" class="btn btn-primary" onclick="addToList()">Agregar</button>
            </div>
          </div>
        </div>
      </div>

   <!-- cantidad de productos en actualizar -->
    <div class="modal fade" id="cantidadProdUp" tabindex="-1" role="dialog" aria-labelledby="cantidadProdUpLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Agregar producto</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <label id="idProdsUp"></label>
            <h3>Producto: <label id="nameProdUp"></label></h3>
            <h3>Precio: <label id="priceProdUp"></label></h3>
            <label for="idCantProdUp"></label>
            <input class="form-control" type="number" name="" id="idCantProdUp" min="1" max="15" placeholder="ingrese la cantida">

            <label for="">Descripcion:</label>
            <textarea class="form-control" name="productosSeleccion" id="idDescriptionProdUp" cols="10" rows="5" ></textarea>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Eliminar</button>
            <button type="button" class="btn btn-primary" onclick="addToListUp()">Agregar</button>
          </div>
        </div>
      </div>
    </div>


       <!-- Modal pagar producto -->
    <div class="modal fade" id="pagarPedido" tabindex="-1" role="dialog" aria-labelledby="pagarPedidoLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">PAGAR EL PEDIDO</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <h3>Total: <span id="totalPagar"></span></h3>
            <h2> <span id="devolverId"></span></h2>
            <div class="form-group">
              <label for="restPago">Con cuanto te pago:</label>
              <input type="text" class="form-control" id="restPagoId" placeholder="Ejemplo: 20">
            </div>
            <form action="{{route('pagar.pedido')}}" method="POST">
              @csrf
              <input type="text" id="idPedidoPago" name="idPedidoPago" hidden>
            
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Eliminar</button>
            <button type="submit" class="btn btn-primary" >pagar</button>
          </form>
          </div>
        </div>
      </div>
    </div>




@endsection

@section('script')
<!-- DataTables  & Plugins -->
<script src="{{asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('assets/plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('assets/plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/dist/js/main.js')}}"></script>



@endsection