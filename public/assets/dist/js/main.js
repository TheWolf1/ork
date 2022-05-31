

  



//funcion de pagar los pedidos

function btnPagar(id, precio) {
    $("#totalPagar").text("$" + precio);
    $("#pagarPedido").modal("show");
    $("#idPedidoPago").val(id);
    document.getElementById('restPagoId').addEventListener('keyup', () => {
        let restPagoId = $("#restPagoId").val();
        let suma = restPagoId - precio;

        if (suma > 0) {
            $("#devolverId").text("Regreso de: " + suma);
        } else {
            if (suma == 0) {
                $("#devolverId").text("Pago completo");
            } else {
                $("#devolverId").text("Faltan: " + suma);
            }
        }


    });
}




//funcion  actualizar orden 
function updateOrder(id, nombreCliente, mesa, pedidoObj,precio) {



    $("#idDelPedidoName").val(id);
    $("#listOfProductsUp").html('');
    $("#idUpdate").val(id);
    $("#idNameClienteUp").val(nombreCliente);
    $("#precioTotalIdUp").val(precio)
    $("#idMesaClienteUp option").attr("selected", false);
    $("#idMesaClienteUp option[value=" + mesa + "]").attr("selected", true);
    listOfProduct = pedidoObj;
    var objString = JSON.stringify(pedidoObj);
    $("#txtProductJsonUp").val(objString);
    datosPedidoJson = JSON.stringify(pedidoObj);
    var totalProd = 0;

    pedidoObj.forEach(product => {
        totalProd += (product.price * product.cant);
        var addinList = $(`<li>
                                     <p>`+ product.cant + ` ` + product.nombre + ` "` + product.description + `" $` + product.price + ` <button type="button" class="btn btn-danger"  onclick="delProdUp(` + product.id + `)">Del</button></p>
                                 </li>`);
        $("#listOfProductsUp").append(addinList);

    });


  

    $("#updateOrder").modal("show");
}

/* //añadir a la lista acutalizar
function addToListUpdate(){} */


//seleccionar producto para luego ver la cantidad
function agregarProducto(id, nombre, precio) {
    $("#idCantProd").val(1);
    $("#idProds").text(id);
    $("#nameProd").text(nombre);
    $("#priceProd").text(precio);


   
    $("#cantidadProd").modal("show");

}

function agregarProductoUpdate(id, nombre, precio) {
    $("#idCantProdUp").val(1);
    $("#idProdsUp").text(id);
    $("#nameProdUp").text(nombre);
    $("#priceProdUp").text(precio);



    $("#cantidadProdUp").modal("show");

}


var listOfProduct = [];
var productList = [];
var listaProdElement = $("#listOfProducts").children();
var datosPedidoJson;
// Agregar a la lista de productos
function addToList() {

    $("#txtProductJson").val(datosPedidoJson);
    $("#listOfProducts").html('');
  

    let id = $("#idProds").text();
    let nombre = $("#nameProd").text();
    let price = $("#priceProd").text();
    let cant = $("#idCantProd").val();
    let description = $("#idDescriptionProd").val();

    productList = {
        id: id,
        nombre: nombre,
        price: parseFloat(price),
        cant: parseFloat(cant),
        description: description,
        status:0
    };



    listOfProduct.push(productList);

    var totalProd = 0;

    listOfProduct.forEach(product => {
        totalProd += (product.price * product.cant);
        var addinList = $(`<li>
                              <p>`+ product.cant + ` ` + product.nombre + ` "` + product.description + `" $` + product.price + ` <button type="button" class="btn btn-danger" id="btnEliminar" onclick="delProd(` + product.id + `)">Del</button></p>
                          </li>`);

        $("#listOfProducts").append(addinList);
       
    });


    
    datosPedidoJson = JSON.stringify(listOfProduct);
    $("#txtProductJson").val(datosPedidoJson);
    $("#idDescriptionProd").val('');
    $("#totalPrecio").text('$' + totalProd);
    $("#precioTotalId").val(totalProd);
    $("#cantidadProd").modal("hide");

    

}


function addToListUp() {

    $("#txtProductJsonUp").val(datosPedidoJson);
    $("#listOfProductsUp").html('');
  

    let id = $("#idProdsUp").text();
    let nombre = $("#nameProdUp").text();
    let price = $("#priceProdUp").text();
    let cant = $("#idCantProdUp").val();
    let description = $("#idDescriptionProdUp").val();

    productList = {
        id: id,
        nombre: nombre,
        price: parseFloat(price),
        cant: parseFloat(cant),
        description: description,
        status:0
    };



    listOfProduct.push(productList);

    var totalProd = 0;

    listOfProduct.forEach(product => {
        totalProd += (product.price * product.cant);
        var addinList = $(`<li>
                              <p>`+ product.cant + ` ` + product.nombre + ` "` + product.description + `" $` + product.price + ` <button type="button" class="btn btn-danger" onclick="delProdUp(` + product.id + `)">Del</button></p>
                          </li>`);

        $("#listOfProductsUp").append(addinList);
       
    });


    
    datosPedidoJson = JSON.stringify(listOfProduct);
    $("#txtProductJsonUp").val(datosPedidoJson);
    $("#idDescriptionProdUp").val('');
    $("#totalPrecioUp").text('$' + totalProd);
    $("#precioTotalIdUp").val(totalProd);
    $("#cantidadProdUp").modal("hide");

    

}


//Eliminar pedido 
$("#btnEliminarPedido").click((e)=>{
    e.preventDefault();
    $("#formDelPedido").submit();
    
});



function delProd(id) {
    //alert("el id es: "+id);

    if (listOfProduct.length > 0) {
        $("#listOfProducts").html('');

    }

    let eliminarProd = listOfProduct.filter((item) => item.id != id);

    listOfProduct = eliminarProd;


    var totalProd = 0;

    listOfProduct.forEach(product => {
        totalProd += (product.price * product.cant);
        var addinList = $(`<li>
                              <p>`+ product.cant + ` ` + product.nombre + ` "` + product.description + `" $` + product.price + ` <button type="button" class="btn btn-danger" id="btnEliminar" onclick="delProd(` + product.id + `)">Del</button></p>
                          </li>`);
        $("#listOfProducts").append(addinList);
    });
    $("#precioTotalIdUp").val(totalProd);
    var datosPedidoJson = JSON.stringify(eliminarProd);
    $("#txtProductJson").val(datosPedidoJson);
    console.log(eliminarProd);
}

function delProdUp(id) {
    //alert("el id es: "+id);

    if (listOfProduct.length > 0) {
        $("#listOfProductsUp").html('');

    }

    let eliminarProd = listOfProduct.filter((item) => item.id != id);

    listOfProduct = eliminarProd;


    var totalProd = 0;

    listOfProduct.forEach(product => {
        totalProd += (product.price * product.cant);
        var addinList = $(`<li>
                              <p>`+ product.cant + ` ` + product.nombre + ` "` + product.description + `" $` + product.price + ` <button type="button" class="btn btn-danger" id="btnEliminar" onclick="delProd(` + product.id + `)">Del</button></p>
                          </li>`);
        $("#listOfProductsUp").append(addinList);
    });

    $("#precioTotalIdUp").val(totalProd);
    var datosPedidoJson = JSON.stringify(eliminarProd);
    $("#txtProductJsonUp").val(datosPedidoJson);
    console.log(eliminarProd);
}




    // datos de las tablas
$('#tbPedidos').DataTable({
    "paging": true,
    "lengthChange": false,

    "searching": true,
    "ordering": true,
    "info": true,
    "autoWidth": false,
    "responsive": true,
});

$('#tbProductos').DataTable({
    "paging": true,
    "lengthMenu": [[4, 10, 15], [4, 10, 15]],
    "lengthChange": true,

    "searching": true,
    "ordering": true,
    "info": false,
    "autoWidth": false,
    "responsive": true,
});

$('#tbProductosUp').DataTable({
    "paging": true,
    "lengthMenu": [[4, 10, 15], [4, 10, 15]],
    "lengthChange": true,

    "searching": true,
    "ordering": true,
    "info": false,
    "autoWidth": false,
    "responsive": true,
});

