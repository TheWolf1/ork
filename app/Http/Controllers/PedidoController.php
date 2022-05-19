<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\Category;
use App\Models\Product;
use App\Models\Mesa;
use Illuminate\Support\Facades\Auth;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $mesero = Auth::id();

        $newPedido = new Pedido;

        $newPedido->pedido_obj = $request['txtProductJson'];
        $newPedido->pedido_cliente = $request['nombreCliente'];
        $newPedido->pedido_mesero =  $mesero;
        $newPedido->pedido_mesa =$request['mesaCliente'];
        $newPedido->pedido_estado = "En Proceso";
        $newPedido->pedido_precio =$request['precioTotal'];

        $newPedido->save();


        $pedidos = Pedido::where('pedido_estado','!=','Pagado')->join('users','pedido_mesero','=','id')->join('mesa','pedido_mesa','=','mesa_id')->select('pedido.*','users.name','mesa.Mesa')->get();
        $mesas= Mesa::all();
        $products = Product::join('category','product_category',"=",'category_id')->select("product.*","category.category_id","category_categoria")->get();
        return view('pages.home',compact('products','pedidos','mesas'));
        
    }


    public function pagar(Request $request)
    {
        # code...
        Pedido::where('pedido_id',$request['idPedidoPago'])->update([
            'pedido_estado'=> 'Pagado'
        ]);

        $pedidos = Pedido::where('pedido_estado','!=','Pagado')->join('users','pedido_mesero','=','id')->join('mesa','pedido_mesa','=','mesa_id')->select('pedido.*','users.name','mesa.Mesa')->get();
        $mesas= Mesa::all();
        $products = Product::join('category','product_category',"=",'category_id')->select("product.*","category.category_id","category_categoria")->get();
        return view('pages.home',compact('products','pedidos','mesas'));
    }
   


    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
