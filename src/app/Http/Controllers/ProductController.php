<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductListRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class ProductController extends Controller
{

    public function index(ProductListRequest $request, Product $product): JsonResponse
    {
        try {
            $page = $request->input('page', 1);
            $perPage = $request->input('per_page', 10);
            $sort = $request->input('sort', 'id');
            $direction = $request->input('direction', 'asc');

            $productsQuery = $product::orderBy($sort, $direction);

            if ($name = $request->input('name')) {
                $productsQuery->where('name', 'like', '%' . $name . '%');
            }

            $products = $productsQuery->paginate($perPage, ['*'], 'page', $page);

            $products->getCollection()->transform(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'description' => $product->description,
                    'stock' => $product->stock,
                    'created_at' => $product->created_at,
                    'updated_at' => $product->updated_at,
                    'links' => [
                        [
                            'rel' => 'self',
                            'href' => route('products.show', ['product' => $product->id])
                        ],
                        [
                            'rel' => 'update',
                            'href' => route('products.update', ['product' => $product->id])
                        ],
                        [
                            'rel' => 'delete',
                            'href' => route('products.destroy', ['product' => $product->id])
                        ]
                    ]
                ];
            });

            return response()->json($products);
        } catch (\Exception $e) {
            Log::error('Erro ao retornar a lista de produtos: ' . $e->getMessage());
            return response()->json(['message' => 'Erro interno'], 500);
        }
    }

    public function show(Product $id): JsonResponse
    {
        return response()->json($id);
    }

    public function store(Request $request, Product $product): JsonResponse
    {
        $product::create($request->all());
        return response()->json($product, 201);
    }

    public function update(Request $request, Product $id): JsonResponse
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'description' => 'required',
            'stock' => 'required'
        ]);

        $id->update($request->all());
        return response()->json($id);
    }

    public function destroy(Product $id): JsonResponse
    {
        $id->delete();
        return response()->json(null, 204);
    }
}
