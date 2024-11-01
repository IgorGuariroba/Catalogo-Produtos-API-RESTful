<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductListRequest;
use App\Http\Requests\ProductUpdateRequest;
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
                return $this->transformProduct($product);
            });

            return response()->json($products);
        } catch (\Exception $e) {
            Log::error('Erro ao retornar a lista de produtos: ' . $e->getMessage());
            return response()->json(['message' => 'Erro interno'], 500);
        }
    }

    public function show(Product $product): JsonResponse
    {
        try {
            return response()->json($this->transformProduct($product));
        } catch (\Exception $e) {
            Log::error('Erro ao retornar o produto: ' . $e->getMessage());
            return response()->json(['message' => 'Erro interno'], 500);
        }
    }

    public function store(Request $request, Product $product): JsonResponse
    {
        try {
            $createdProduct = $product::create($request->all());
            return response()->json($this->transformProduct($createdProduct), 201);
        } catch (\Exception $e) {
            Log::error('Erro ao criar o produto: ' . $e->getMessage());
            return response()->json(['message' => 'Erro interno'], 500);
        }
    }

    public function update(ProductUpdateRequest $request, Product $id): JsonResponse
    {
        try {
            $id->update($request->all());
            return response()->json($this->transformProduct($id));
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar o produto: ' . $e->getMessage());
            return response()->json(['message' => 'Erro interno'], 500);
        }
    }

    public function destroy(Product $id): JsonResponse
    {
        try {
            $id->delete();
            return response()->json(['message' => 'Produto deletado com sucesso'], 204);
        } catch (\Exception $e) {
            Log::error('Erro ao deletar o produto: ' . $e->getMessage());
            return response()->json(['message' => 'Erro interno'], 500);
        }
    }

    private function transformProduct($product): array
    {
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
    }
}
