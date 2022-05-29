<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\Category;
use App\Models\Product;
use App\Models\Mesa;
use App\Models\Gasto;
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
        try {
            //code...
             $mesero = Auth::id();

            $newPedido = new Pedido;

            $newPedido->pedido_obj = $request['txtProductJson'];
            $newPedido->pedido_cliente = $request['nombreCliente'];
            $newPedido->pedido_mesero =  $mesero;
            $newPedido->pedido_mesa =$request['mesaCliente'];
            $newPedido->pedido_estado = "En Proceso";
            $newPedido->pedido_precio =$request['precioTotal'];

            $newPedido->save();

            return array([
                "code"=>200,
                "mesaje"=>"Pedido creado exitosamente"
            ]);
        } catch (\Throwable $th) {
            //throw $th
            return array([
                "code"=>500,
                "mesaje"=>"Hubo un error"
            ]);
        }
        
    }


    public function pagar(Request $request)
    {
        # code...
       

        try {
             Pedido::where('pedido_id',$request['idPedidoPago'])->update([
                'pedido_estado'=> 'Pagado'
            ]);
            return array([
                "code"=>200,
                "mesaje"=>"Pedido pagado exitosamente"
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return array([
                "code"=>500,
                "mesaje"=>"Hubo un error"
            ]);
        }
    }
   


    public function store(Request $request)
    {
        //
        
        


        try {
            //code...
            

            $cambioStatus = Pedido::where('pedido_id',$request['id'])->first();

            $arrays =json_decode($cambioStatus['pedido_obj']);
            
            foreach ($arrays as $array) {
                # code...
                //$array['status'];
                $array->status = 1;
                $value = $array->status;
            }


            Pedido::where('pedido_id',$request['id'])->update([
                "pedido_estado"=>$request['value'],
                "pedido_obj" => json_encode($arrays)
            ]);
            return array([
                "code"=>200,
                "mesaje"=>"Pedido Listo"
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return array([
                "code"=>500,
                "mesaje"=>"Hubo un error" .$th
            ]);

        }
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
    public function update(Request $request)
    {
        //

        Pedido::where('pedido_id',$request["txtIdUpdate"])->update([
            "pedido_cliente"=>$request["nombreClienteUp"],
            "pedido_obj"=>$request["txtProductJsonUp"],
            "pedido_mesa"=>$request["mesaClienteUp"],
            "pedido_precio"=>$request["precioTotalUp"],
            "pedido_estado"=>"En Proceso"

        ]);
        

        $dateTimeInit = date('Y-m-d 05:00:00', time());  
        $dateTimeFin = date('Y-m-d 05:00:00', strtotime($dateTimeInit."+ 1 days"));
        $gastos = Gasto::where('created_at','>',$dateTimeInit)->where('created_at','<',$dateTimeFin)->get();
        $pedidosTotal = Pedido::where('pedido.created_at','>',$dateTimeInit)->where('pedido.created_at','<',$dateTimeFin)->join('users','pedido_mesero','=','id')->join('mesa','pedido_mesa','=','mesa_id')->select('pedido.*','users.name','mesa.*')->get();
        $pedidosPagos = Pedido::where('pedido_estado','Pagado')->where('pedido.created_at','>',$dateTimeInit)->where('pedido.created_at','<',$dateTimeFin)->join('users','pedido_mesero','=','id')->join('mesa','pedido_mesa','=','mesa_id')->select('pedido.*','users.name','mesa.*')->get();
        $pedidosSinPagar = Pedido::where('pedido_estado','En Proceso')->where('pedido.created_at','>',$dateTimeInit)->where('pedido.created_at','<',$dateTimeFin)->join('users','pedido_mesero','=','id')->join('mesa','pedido_mesa','=','mesa_id')->select('pedido.*','users.name','mesa.*')->get();
        $pedidosSPListos =  Pedido::where('pedido_estado','Listo')->where('pedido.created_at','>',$dateTimeInit)->where('pedido.created_at','<',$dateTimeFin)->join('users','pedido_mesero','=','id')->join('mesa','pedido_mesa','=','mesa_id')->select('pedido.*','users.name','mesa.*')->get();
        $products = Product::join('category','product_category',"=",'category_id')->select("product.*","category.category_id","category_categoria")->get();
        $mesas= Mesa::all();
        return view('pages.home',compact('products','pedidosSinPagar','mesas','pedidosPagos','pedidosTotal','gastos','pedidosSPListos'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //

        Pedido::where('pedido_id',$request["DelPedidoName"])->delete();

        $dateTimeInit = date('Y-m-d 05:00:00', time());  
        $dateTimeFin = date('Y-m-d 05:00:00', strtotime($dateTimeInit."+ 1 days"));
        $gastos = Gasto::where('created_at','>',$dateTimeInit)->where('created_at','<',$dateTimeFin)->get();
        $pedidosTotal = Pedido::where('pedido.created_at','>',$dateTimeInit)->where('pedido.created_at','<',$dateTimeFin)->join('users','pedido_mesero','=','id')->join('mesa','pedido_mesa','=','mesa_id')->select('pedido.*','users.name','mesa.*')->get();
        $pedidosSPListos =  Pedido::where('pedido_estado','Listo')->where('pedido.created_at','>',$dateTimeInit)->where('pedido.created_at','<',$dateTimeFin)->join('users','pedido_mesero','=','id')->join('mesa','pedido_mesa','=','mesa_id')->select('pedido.*','users.name','mesa.*')->get();
        $pedidosPagos = Pedido::where('pedido_estado','Pagado')->where('pedido.created_at','>',$dateTimeInit)->where('pedido.created_at','<',$dateTimeFin)->join('users','pedido_mesero','=','id')->join('mesa','pedido_mesa','=','mesa_id')->select('pedido.*','users.name','mesa.*')->get();
        $pedidosSinPagar = Pedido::where('pedido_estado','!=','Pagado')->where('pedido.created_at','>',$dateTimeInit)->where('pedido.created_at','<',$dateTimeFin)->join('users','pedido_mesero','=','id')->join('mesa','pedido_mesa','=','mesa_id')->select('pedido.*','users.name','mesa.*')->get();
        $products = Product::join('category','product_category',"=",'category_id')->select("product.*","category.category_id","category_categoria")->get();
        $mesas= Mesa::all();
        return view('pages.home',compact('products','pedidosSinPagar','mesas','pedidosPagos','pedidosTotal','gastos','pedidosSPListos'));
    }
}
