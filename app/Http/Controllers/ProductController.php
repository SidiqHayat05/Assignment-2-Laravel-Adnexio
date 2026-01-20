<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // THIS LINE GOES HERE, outside the class
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    // GET /api/products
    public function index()
    {
        abort_if(! Auth::user()->can('product_view'), Response::HTTP_FORBIDDEN, "You don't have permission to access the list of products.");
        return response()->json(Product::all(), Response::HTTP_OK);
    }

    // GET /api/products/{id}
    public function show($id)
    {
        abort_if(! Auth::user()->can('product-view'), Response::HTTP_FORBIDDEN, "You don't have permission to access the products.");
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        }

        return response()->json($product, 200);
    }

    // POST /api/products
    public function store(Request $request)
    {
        abort_if(! Auth::user()->can('product-create'), Response::HTTP_FORBIDDEN, "You do not have permission to create this product.");
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'nullable|integer',
        ]);

        $product = Product::create($validated);

        return response()->json($product, 201);
    }

    // PUT /api/products/{id}
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'nullable|integer',
        ]);

        $product->update($validated);

        return response()->json($product, 200);
    }

    // DELETE /api/products/{id}
    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        }

        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully'
        ], 200);
    }
}
