<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Pedido;
use App\Models\Mesa;
use App\Models\Gasto; 
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public  $numeroPedidoActual = 0;
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
  



     public function listener()
     {
         # code...
         $nroPedidos = Pedido::where('pedido_estado','!=','Pagado')->count();
        return $nroPedidos;
     }

     public function logouts()
     {
         # code...
         auth()->logout();
         return view('auth.login');
     }
     

    public function __invoke(Request $request)
    {
        //

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
}
