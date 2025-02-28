<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\product;
use Illuminate\Http\Request;

class ApiProductController extends Controller
{
    public function createNewProduct(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required'],
            'description' => ['required'],
            'manufacturing' => ['required'],
            'manufacturer' => ['required'],
            'cost_per_one' => ['required', 'numeric'],
            'price_per_one' => ['required', 'numeric'],
            'total_quantity' => ['required', 'numeric'],
        ]);

        $product = product::create($validatedData);

        if (!$product) {
            return response()->json(['message' => 'Failed to create the product, please try again!'], 500);
        }

        return response()->json(["message" => "Product created successfully!", "product" => $product], 200);
    }
        /** get available products to view products page
     *
     */

     public function getProducts(Request $request)
    {
        $product = Product::query();

        if ($keyword = $request->get("keyword")) {
            $product->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('manufacturer', 'like', '%' . $keyword . '%');
        }

        if ($limit = $request->get("limit")) {
            return response()->json($product->paginate($limit));
        }
        return response()->json($product);
    }
        /** get available products to view update page
     *
     */

     public function getUpdateProduct($id)
     {
         $product = Product::find($id);

         if (is_null($product)) {
             return response()->json(['message' => 'Failed to locate Product!'], 404);
         } else {
             return response()->json([
                 'message' => 'Found role and related permissions!',
                 'product' => $product
             ], 200);
         }
     }
         /** update product
     *
     */
    public function updateProduct(Request $request, $id)
    {
    $validatedData = $request->validate([
        'name' => ['required'],
        'manufacturer' => ['required'],
        'manufacturing' => ['required'],
        'total_quantity' => ['required', 'numeric'],
        'cost_per_one' => ['required', 'numeric'],
        'price_per_one' => ['required', 'numeric'],
        'description' => ['required'],
    ]);

    $product = Product::find($id);
    if (is_null($product)) return response()->json(['message' => "No record found to update!"], 404);

    $product->update($validatedData);

    if (!$product) return response()->json(['message' => 'Please try again!'], 500);
    }
             /** delete product
     *
     */
    public function deleteProduct(Request $request, $id)
    {

    $product = Product::find($id);
    if (is_null($product)) return response()->json(['message' => "No record found to update!"], 404);

    $product->update(["manufacturing"=>"Not In Manufacturing"]);

    if (!$product) return response()->json(['message' => 'Please try again!'], 500);
    }
}
