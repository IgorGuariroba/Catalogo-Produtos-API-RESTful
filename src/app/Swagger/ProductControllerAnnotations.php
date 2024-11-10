<?php

namespace App\Swagger;

/**
 * @OA\Tag(
 *      name="Products",
 *      description="API Endpoints para Gerenciamento de Produtos"
 *  )
 *
 * @OA\Schema(
 *      schema="Product",
 *      type="object",
 *      title="Product",
 *      description="Modelo de um produto",
 *      required={"id", "name", "price", "stock"},
 *      @OA\Property(property="id", type="integer", description="ID do produto"),
 *      @OA\Property(property="name", type="string", description="Nome do produto"),
 *      @OA\Property(property="description", type="string", nullable=true, description="Descrição do produto"),
 *      @OA\Property(property="price", type="string", description="Preço do produto"),
 *      @OA\Property(property="stock", type="integer", description="Quantidade em estoque do produto"),
 *      @OA\Property(property="created_at", type="string", format="date-time", nullable=true, description="Data de criação do produto"),
 *      @OA\Property(property="updated_at", type="string", format="date-time", nullable=true, description="Data de atualização do produto")
 *  )
 */
class ProductControllerAnnotations
{

    /**
     *
     * @OA\Get(
     *      path="/products",
     *      operationId="getProducts",
     *      tags={"Products"},
     *      security={{"bearerAuth":{}}},
     *      summary="Lista os produtos",
     *      description="Lista os produtos disponíveis, com suporte a paginação, ordenação, direção de ordenação e links HATEOAS para cada produto.",
     *      @OA\Parameter(
     *          name="page",
     *          in="query",
     *          required=false,
     *          description="Número da página para paginação",
     *          @OA\Schema(type="integer", example=1)
     *      ),
     *      @OA\Parameter(
     *          name="per_page",
     *          in="query",
     *          required=false,
     *          description="Número de itens por página para paginação",
     *          @OA\Schema(type="integer", example=10)
     *      ),
     *      @OA\Parameter(
     *          name="sort",
     *          in="query",
     *          required=false,
     *          description="Campo pelo qual os produtos devem ser ordenados",
     *          @OA\Schema(type="string", example="id")
     *      ),
     *      @OA\Parameter(
     *          name="direction",
     *          in="query",
     *          required=false,
     *          description="Direção da ordenação: asc para ascendente e desc para descendente",
     *          @OA\Schema(type="string", enum={"asc", "desc"}, example="asc")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Lista de produtos retornada com sucesso",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="data", type="array",
     *                  @OA\Items(ref="#/components/schemas/Product")
     *              ),
     *              @OA\Property(property="links", type="object",
     *                  @OA\Property(property="first", type="string", example="http://catalogo-produtos.local/products?page=1"),
     *                  @OA\Property(property="last", type="string", example="http://catalogo-produtos.local/products?page=10"),
     *                  @OA\Property(property="prev", type="string", nullable=true, example="http://catalogo-produtos.local/products?page=1"),
     *                  @OA\Property(property="next", type="string", nullable=true, example="http://catalogo-produtos.local/products?page=3")
     *              ),
     *              @OA\Property(property="meta", type="object",
     *                  @OA\Property(property="current_page", type="integer", example=2),
     *                  @OA\Property(property="from", type="integer", example=11),
     *                  @OA\Property(property="last_page", type="integer", example=10),
     *                  @OA\Property(property="path", type="string", example="http://catalogo-produtos.local/products"),
     *                  @OA\Property(property="per_page", type="integer", example=10),
     *                  @OA\Property(property="to", type="integer", example=20),
     *                  @OA\Property(property="total", type="integer", example=200)
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Erro interno ao retornar a lista de produtos",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="Erro interno")
     *          )
     *      )
     *  )
     */
    public function index()
    {

    }

    /**
     *
     * @OA\Get(
     *      path="/products/{id}",
     *      operationId="getProductById",
     *      tags={"Products"},
     *      security={{"bearerAuth":{}}},
     *      summary="Exibe um produto específico",
     *      description="Retorna um produto pelo ID",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID do produto",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Produto encontrado com sucesso",
     *          @OA\JsonContent(ref="#/components/schemas/Product")
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Produto não encontrado"
     *      )
     *  )
     */
    public function show()
    {

    }

    /**
     * @OA\Post(
     *      path="/products",
     *      operationId="createProduct",
     *      tags={"Products"},
     *      security={{"bearerAuth":{}}},
     *      summary="Cria um novo produto",
     *      description="Cria um novo produto com os dados fornecidos",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/Product")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Produto criado com sucesso",
     *          @OA\JsonContent(ref="#/components/schemas/Product")
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Dados inválidos"
     *      )
     *  )
     */
    public function store()
    {

    }

    /**
     * @OA\Put(
     *      path="/products/{id}",
     *      operationId="updateProduct",
     *      tags={"Products"},
     *      security={{"bearerAuth":{}}},
     *      summary="Atualiza um produto existente",
     *      description="Atualiza os dados de um produto pelo ID",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID do produto",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/Product")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Produto atualizado com sucesso",
     *          @OA\JsonContent(ref="#/components/schemas/Product")
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Produto não encontrado"
     *      )
     *  )
     */
    public function update()
    {

    }

    /**
     * @OA\Delete(
     *      path="/products/{id}",
     *      operationId="deleteProduct",
     *      tags={"Products"},
     *      security={{"bearerAuth":{}}},
     *      summary="Deleta um produto",
     *      description="Remove um produto pelo ID",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID do produto",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Produto deletado com sucesso"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Produto não encontrado"
     *      )
     *  )
     */
    public function destroy()
    {

    }
}
