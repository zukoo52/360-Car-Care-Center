<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_option = ['main' => 'product', 'sub' => 'product_index'];
        $page_name = "Product Overview";
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Product', 'url' => route('product.index')],
            ['name' => 'View', 'url' => '#']
        ];

        return view('page.product.index', compact('page_name', 'breadcrumbs', 'page_option'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_option = ['main' => 'product', 'sub' => 'product_index'];
        $page_name = 'Create New Product';
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Product', 'url' => route('product.create')],
            ['name' => 'New', 'url' => '#']
        ];
        return view('page.product.create', compact('page_name','breadcrumbs','page_option'));
    }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Models\product  $product
    * @return \Illuminate\Http\Response
    */
    public function update($id)
    {
        $product=Product::find($id);
        $page_option = ['main' => 'product', 'sub' => 'product_index'];
        $page_name = 'Update Product';
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Product', 'url' => route('product.index')],
            ['name' => 'New', 'url' => '#']
        ];
        return view('page.product.update', compact('page_name','breadcrumbs','page_option','product'));
    }
}
