<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Products",
 *     description="API Endpoints para Gerenciamento de Produtos"
 * )
 * @OA\Schema(
 * schema="Product",
 * type="object",
 * title="Product",
 * description="Modelo de um produto",
 * required={"id", "name", "price", "stock"},
 *
 * @OA\Property(
 * property="id",
 * type="integer",
 * description="ID do produto"
 * ),
 * @OA\Property(
 * property="name",
 * type="string",
 * description="Nome do produto"
 * ),
 * @OA\Property(
 * property="description",
 * type="string",
 * nullable=true,
 * description="Descrição do produto"
 * ),
 * @OA\Property(
 * property="price",
 * type="string",
 * description="Preço do produto"
 * ),
 * @OA\Property(
 * property="stock",
 * type="integer",
 * description="Quantidade em estoque do produto"
 * ),
 * @OA\Property(
 * property="created_at",
 * type="string",
 * format="date-time",
 * nullable=true,
 * description="Data de criação do produto"
 * ),
 * @OA\Property(
 * property="updated_at",
 * type="string",
 * format="date-time",
 * nullable=true,
 * description="Data de atualização do produto"
 * )
 * )
 */
class ProductController extends Controller
{
    /**
     * @OA\Get(
     *     path="/products",
     *     operationId="getProducts",
     *     tags={"Products"},
     *     summary="Retorna a lista de produtos",
     *     description="Retorna todos os produtos disponíveis no sistema",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de produtos retornada com sucesso",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Product")
     *         )
     *     )
     * )
     */
    public function index(Product $product): JsonResponse
    {
        try {
            $page = request('page', 1);
            $perPage = request('per_page', 10);
            $sort = request('sort', 'id');
            $direction = request('direction', 'asc');

            $products = $product::orderBy($sort, $direction)->paginate($perPage, ['*'], 'page', $page);
            return response()->json($products);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro interno'], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/products/{id}",
     *     operationId="getProductById",
     *     tags={"Products"},
     *     summary="Exibe um produto específico",
     *     description="Retorna um produto pelo ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do produto",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Produto encontrado com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Produto não encontrado"
     *     )
     * )
     */
    public function show($id): JsonResponse
    {
        $product = Product::findOrFail($id);
        return response()->json($product);
    }

    /**
     * @OA\Post(
     *     path="/products",
     *     operationId="createProduct",
     *     tags={"Products"},
     *     summary="Cria um novo produto",
     *     description="Cria um novo produto com os dados fornecidos",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Produto criado com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Dados inválidos"
     *     )
     * )
     */
    public function store(Request $request): JsonResponse
    {
        $product = Product::create($request->all());
        return response()->json($product, 201);
    }

    /**
     * @OA\Put(
     *     path="/products/{id}",
     *     operationId="updateProduct",
     *     tags={"Products"},
     *     summary="Atualiza um produto existente",
     *     description="Atualiza os dados de um produto pelo ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do produto",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Produto atualizado com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Produto não encontrado"
     *     )
     * )
     */
    public function update(Request $request, $id): JsonResponse
    {
        $product = Product::findOrFail($id);
        $product->update($request->all());
        return response()->json($product);
    }

    /**
     * @OA\Delete(
     *     path="/products/{id}",
     *     operationId="deleteProduct",
     *     tags={"Products"},
     *     summary="Deleta um produto",
     *     description="Remove um produto pelo ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do produto",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Produto deletado com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Produto não encontrado"
     *     )
     * )
     */
    public function destroy($id): JsonResponse
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json(null, 204);
    }
}
