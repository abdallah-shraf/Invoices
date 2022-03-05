<?php

namespace App\Http\Controllers;

use App\products;
use App\sections;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /*
    ** Display a listing of the resource.
    ** @return \Illuminate\Http\Response
    */

    function __construct()
    {
        $this->middleware('permission:المنتجات', ['only' => ['index', 'store']]);
        $this->middleware('permission:اضافة منتج', ['only' => ['create', 'store']]);
        $this->middleware('permission:تعديل منتج', ['only' => ['edit', 'update']]);
        $this->middleware('permission:حذف منتج', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = products::all();

        $section= sections::all();

        return view('products.products',compact('section', 'product'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $section= sections::all();
        return view('products.create',compact('section'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $request->validate([
            'Product_name' => 'required|unique:products|max:255',
            'section_id' => 'required',
            'description' => 'required',
        ], [
            'Product_name.required' => 'الرجاء إدخال أسم القسم',
            'Product_name.unique' => 'أسم المنتج مسجل مسبقا',
            'section_id.required' => 'الرجاء إدخال أسم القسم',

            'description.required' => 'الرجاء إدخال الوصف',

        ]);

        $product=new products();
        $product->Product_name=$request->input('Product_name');
        $product->section_id=$request->input('section_id');
        $product->description=$request->input('description');

        $product->save();
        return redirect('/products')->with("done", "تمت الإضافه بنجاح");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\products  $products
     * @return \Illuminate\Http\Response
     */
    public function show(products $products)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\products  $products
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pro = products::find($id);
        $section = sections::all();

        return view('products.edit', compact('pro', 'section'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\products  $products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'Product_name' => 'required|max:255',
            'section_id' => 'required',
            'description' => 'required',
        ], [
            'Product_name.required' => 'الرجاء إدخال أسم المنتج',
            'Product_name.unique' => 'أسم المنتج مسجل مسبقا',
            'section_id.required' => 'الرجاء إدخال أسم القسم',

            'description.required' => 'الرجاء إدخال الوصف',

        ]);

        $pro = products::find($id);

        $pro->update([
            'Product_name' => $request->Product_name,
            'section_id' =>$request->section_id,
            'description'=>$request->description,
        ]);

        $pro->save();
        return redirect('/products')->with("done", "تمت التعديل بنجاح");


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\products  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pro = products::find($id);
        $pro->delete();
        return redirect('/products')->with("done", "تم حذف المنتج بنجاح");
    }
}
