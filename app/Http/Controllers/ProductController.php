<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){
        $products = Product::latest()->paginate(5);
        return view('products.index',compact('products'));
    }
    
    //Add Product
    public function store(Request $request){
        $request->validate(
            [
                'name'=>'required|unique:products',
                'price'=>'required'
            ],
            [
                'name.required'=>'Name is Required',
                'name.unique'=>'Product Already Exists',
                'price.required'=>'Price is Required',
            ]
        );

        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->save();

        return response()->json([
            'status'=>'success'
        ]);
    }

    //Update Product
    public function update(Request $request){
        $request->validate(
            [
                'update_name'=>'required|unique:products,name,'.$request->update_id,
                'update_price'=>'required'
            ],
            [
                'update_name.required'=>'Name is Required',
                'update_name.unique'=>'Product Already Exists',
                'update_price.required'=>'Price is Required',
            ]
        );


        Product::where('id',$request->update_id)->update([
            'name' => $request->update_name,
            'price'=>$request->update_price
        ]);

        return response()->json([
            'status'=>'success'
        ]);
    }

    public function pagination(){
        $products = Product::latest()->paginate(5);
        return view('products.pagination',compact('products'))->render();
    }

    //Delete Product Data
    public function delete(Request $request){
        Product::where('id',$request->product_id)->delete();
        return response()->json([
            'status'=>'success'
        ]);
    }

    //Search Product
    public function search(Request $request){
        $products = Product::where('name','like','%'.$request->search.'%')->orWhere('price','like','%'.$request->search.'%')->orderBy('id','desc')->paginate(5);

        if($products->count() >= 1){
            return view('products.pagination',compact('products'))->render();
        }else{
            return response()->json([
                'status'=>'nothing_found'
            ]);
        }
    }

}
