<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/products",
     *     summary="Listar todos os produtos",
     *     tags={"Products"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de produtos"
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $products = Product::all();
        return response()->json($products);
    }

    // Método para exibir um produto específico
    public function show($id): JsonResponse
    {
        $product = Product::findOrFail($id);
        return response()->json($product);
    }

    // Método para criar um novo produto
    public function store(Request $request): JsonResponse
    {
        $product = Product::create($request->all());
        return response()->json($product, 201);
    }

    // Método para atualizar um produto existente
    public function update(Request $request, $id): JsonResponse
    {
        $product = Product::findOrFail($id);
        $product->update($request->all());
        return response()->json($product);
    }

    // Método para deletar um produto
    public function destroy($id): JsonResponse
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json(null, 204);
    }
}
