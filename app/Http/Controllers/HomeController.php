<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Pedido;
use App\Models\Mesa;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
  

     

    public function __invoke(Request $request)
    {
        //
        $pedidos = Pedido::where('pedido_estado','!=','Pagado')->join('users','pedido_mesero','=','id')->join('mesa','pedido_mesa','=','mesa_id')->select('pedido.*','users.name','mesa.*')->get();
        $products = Product::join('category','product_category',"=",'category_id')->select("product.*","category.category_id","category_categoria")->get();
        $mesas= Mesa::all();
        return view('pages.home',compact('products','pedidos','mesas'));
    }
}
