<?php

namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


     public function selectCategory($idCategory)
     {
         # code...

        $products= Product::where('product_category',$idCategory)->get();
        $category = $idCategory;
        $categoryName = Category::where('category_id',$idCategory)->get()->first();
         return view('pages.productByCategory', compact('products','category','categoryName'));
     }




     public function addProduct(Request $request)
     {
         # code...

         $newProduct = new Product;
         $newProduct->product_name = $request['nameProduct'];
         $newProduct->product_price = $request['priceProduct'];
         $newProduct->product_category = $request['categoryProduct'];
         $newProduct->product_status = 1;

         $newProduct->save();

         $products= Product::where('product_category',$request['categoryProduct'])->get();
         $category = $request['categoryProduct'];
         $categoryName = Category::where('category_id',$request['categoryProduct'])->get()->first();
          return view('pages.productByCategory', compact('products','category','categoryName'));

         
     }

     public function updateProduct(Request $request)
     {
         # code...
         Product::where("product_id",$request['idProductUp'])->update([
             "product_name"=>$request['nameProductUp'],
             "product_price"=>$request['priceProductUp'],
             "product_status"=>$request['statusProductUp']
         ]);

         $url = url()->current();

         

         $products= Product::where('product_category',$request['categoryProdUp'])->get();
         $category = $request['categoryProdUp'];
         $categoryName = Category::where('category_id',$request['categoryProdUp'])->get()->first();
          return view('pages.productByCategory', compact('products','category','categoryName'));
        
     }

     public function addCategory(Request $request)
     {
         # code...
         $newCategory = new Category;
         $newCategory->category_categoria = $request['nameCategory'];
         $newCategory->save();

         $category = Category::all();
         return view('pages.product', compact('category'));
         
     }


    public function __invoke(Request $request)
    {
        //
        $category = Category::all();
        return view('pages.product', compact('category'));
    }
}
