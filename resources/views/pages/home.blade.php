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


<div class="col-lg" id="contentId">

  @if (auth()->user()->rol == 'Cajero')

<!-- Small boxes (Stat box) -->
<div class="row" >
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-success">  
      <div class="inner">
        @php
            $sum = 0;
        @endphp
        @foreach ($pedidosPagos as $pedido)
            @php
                $sum = $sum+$pedido->pedido_precio;
            @endphp
            
        @endforeach
        <h3>${{$sum}}</h3>

        <p>Ingresos</p>
      </div>
      <div class="icon">
        <i class="ion ion-bag"></i>
      </div>
      <a href="#" class="small-box-footer">Mas informacion <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-6" >
    <!-- small box -->
    <div class="small-box bg-danger">
      <div class="inner" >
        @php
        $sumGastos = 0;
        @endphp
        @foreach ($gastos as $gasto)
            @php
                $sumGastos = $sumGastos+$gasto->gastos_cantidad;
            @endphp
           
        @endforeach
        <h3>${{$sumGastos}}</h3>
        
        <p>Gastos</p>
      </div>
      <div class="icon">
        <i class="ion ion-stats-bars"></i>
      </div>
      <a href="#" class="small-box-footer" data-toggle="modal" data-target="#addGasto">Nuevo gasto <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-warning">
      <div class="inner">

        @php
          $pedidosporpagar = 0;            
        @endphp

        @foreach ($pedidosSinPagar as $pedidos)
            @php
                $pedidosporpagar += 1;
            @endphp
        @endforeach
        <h3>{{$pedidosporpagar}}</h3>

        <p>Pedidos por pagar</p>
      </div>
      <div class="icon">
        <i class="ion ion-person-add"></i>
      </div>
      <a href="#" class="small-box-footer">Mas informacion  <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-info">
      <div class="inner">

        @php
        $totalpedidos = 0;            
      @endphp

      @foreach ($pedidosTotal as $pedidos)
          @php
              $totalpedidos += 1;
          @endphp
      @endforeach


        <h3>{{$totalpedidos}}</h3>

        <p>Total de pedidos</p>
      </div>
      <div class="icon">
        <i class="ion ion-pie-graph"></i>
      </div>
      <a href="#" class="small-box-footer">Mas informacion  <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
</div>

{{-- final de small boxes --}}
@endif


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

                    @if (auth()->user()->rol == 'Cajero')
                        <th class="col-1">Pagar</th>
                    @endif
                    
                    <th class="col-1">Editar</th>
                </tr>
            </thead>
            <tbody class="" id="tbodyPedidosId">
                @foreach ($pedidosSinPagar as $pedido)
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
                    @if (auth()->user()->rol == 'Cajero')
                      <td>
                        <button class="btn btn-success" onclick="btnPagar({{$pedido->pedido_id}},{{$pedido->pedido_precio}})">
                            $
                        </button>
                      </td>  
                    @endif
                    
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

            <form action="#" method="POST" id="formCrearPedidoId">
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
            <form action="#" method="POST" id="formPagarPedidoId">
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



<!-- Modal de gastos -->
  <!-- Nuevo gasto -->
  <div class="modal fade" id="addGasto" tabindex="-1" role="dialog" aria-labelledby="addGastoLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ingresar Gasto</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="formNewGasto" method="POST">
              @csrf
                <div class="form-group">
                    <label for="idValorGasto">¿Cuanto gastaste?</label>
                    <input type="text" id="idValorGasto" name="valorGasto" class="form-control" placeholder="Ejemplo: 5.50">
                </div>
                <div class="form-group">
                  <label for="nameCategory">¿En que gastaste?</label>
                  <textarea class="form-control" name="descriptionGasto" id="idDescriptionGasto" cols="30" rows="5"></textarea>
              </div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="button" id="btnFormNewGasto" class="btn btn-primary">Guardar</button>
        
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

<script>

$("#btnFormNewGasto").click((e)=>{
  e.preventDefault();
  var data = $("#formNewGasto").serializeArray();

  $.ajax({
    type:'POST',
    data: data,
    url:"{{route('gastos.crear')}}",
    success:function(result){
      alertaFun(result[0].code,result[0].mesaje);
      $("#contentId").load(" #contentId");
      $("#addGasto").modal("hide");
      $("#formNewGasto").trigger("reset");
   
    }
  });

});



$("#formPagarPedidoId").submit((e)=>{
  e.preventDefault();
  var data = $("#formPagarPedidoId").serializeArray();
  $.ajax({
    type:"POST",
    data:data,
    url:"{{route('pagar.pedido')}}",
    success:(res)=>{
      alertaFun(res[0].code,res[0].mesaje);
      $("#pagarPedido").modal("hide");
      $("#formPagarPedidoId").trigger("reset");
      $("#contentId").load(" #contentId");
     $("#totalPagar").text('');
     $("#devolverId").text('');

    }
  });
});



$("#formCrearPedidoId").submit((e)=>{
  e.preventDefault();
  
  var data = $("#formCrearPedidoId").serializeArray();
  $.ajax({
    type:"POST",
    data:data,
    url:"{{route('crear.pedido')}}",
    success:(res)=>{
      alertaFun(res[0].code,res[0].mesaje);
      $("#contentId").load(" #contentId");
      $("#newOrder").modal("hide");
      $("#formCrearPedidoId").trigger("reset");
      $("#listOfProducts").html('');
      $("#totalPrecio").html('');
      
      
      listOfProduct = [];
    }
  });
});



var nroPedidosNow = 0;
setInterval(() => {
  $.ajax({
    type:"POST",
    data:{
      "_token": "{{ csrf_token() }}" 
    },
    url:"{{route('listenerPedidos')}}",
    success:(res)=>{
        if(res!=nroPedidosNow){
          nroPedidosNow = res;
          $("#tbPedidos").load(" #tbPedidos");
          
        }
        
    }
  });
}, 3000);

</script>

@endsection