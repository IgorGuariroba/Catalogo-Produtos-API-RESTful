<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductListRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
 *     summary="Lista os produtos",
 *     description="Lista os produtos disponíveis, com suporte a paginação, ordenação, direção de ordenação e links HATEOAS para cada produto.",
 *     @OA\Parameter(
 *         name="page",
 *         in="query",
 *         required=false,
 *         description="Número da página para paginação",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Parameter(
 *         name="per_page",
 *         in="query",
 *         required=false,
 *         description="Número de itens por página para paginação",
 *         @OA\Schema(type="integer", example=10)
 *     ),
 *     @OA\Parameter(
 *         name="sort",
 *         in="query",
 *         required=false,
 *         description="Campo pelo qual os produtos devem ser ordenados",
 *         @OA\Schema(type="string", example="id")
 *     ),
 *     @OA\Parameter(
 *         name="direction",
 *         in="query",
 *         required=false,
 *         description="Direção da ordenação: asc para ascendente e desc para descendente",
 *         @OA\Schema(type="string", enum={"asc", "desc"}, example="asc")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Lista de produtos retornada com sucesso",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="data", type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="name", type="string", example="Produto A"),
 *                     @OA\Property(property="price", type="number", format="float", example=99.99),
 *                     @OA\Property(property="description", type="string", example="Descrição do produto A"),
 *                     @OA\Property(property="stock", type="integer", example=100),
 *                     @OA\Property(property="created_at", type="string", format="date-time", example="2024-10-31T19:06:33.624Z"),
 *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-10-31T19:06:33.624Z"),
 *                     @OA\Property(property="links", type="array",
 *                         description="Links HATEOAS para o produto",
 *                         @OA\Items(
 *                             type="object",
 *                             @OA\Property(property="rel", type="string", example="self"),
 *                             @OA\Property(property="href", type="string", example="http://catalogo-produtos.local/api/products/1")
 *                         )
 *                     )
 *                 )
 *             ),
 *             @OA\Property(property="links", type="object",
 *                 @OA\Property(property="first", type="string", example="http://catalogo-produtos.local/products?page=1"),
 *                 @OA\Property(property="last", type="string", example="http://catalogo-produtos.local/products?page=10"),
 *                 @OA\Property(property="prev", type="string", nullable=true, example="http://catalogo-produtos.local/products?page=1"),
 *                 @OA\Property(property="next", type="string", nullable=true, example="http://catalogo-produtos.local/products?page=3")
 *             ),
 *             @OA\Property(property="meta", type="object",
 *                 @OA\Property(property="current_page", type="integer", example=2),
 *                 @OA\Property(property="from", type="integer", example=11),
 *                 @OA\Property(property="last_page", type="integer", example=10),
 *                 @OA\Property(property="path", type="string", example="http://catalogo-produtos.local/products"),
 *                 @OA\Property(property="per_page", type="integer", example=10),
 *                 @OA\Property(property="to", type="integer", example=20),
 *                 @OA\Property(property="total", type="integer", example=200)
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Erro interno ao retornar a lista de produtos",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Erro interno")
 *         )
 *     )
 * )
 */
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
