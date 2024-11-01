<?php

namespace App\Swagger;

/**
 * @OA\Tag(
 *      name="Serviços",
 *      description="API Endpoints para Verificação de Status dos Serviços"
 *  )
 */
class HealthCheckControllerAnnotations
{

    /**
     *
     * @OA\Get(
     *     path="/status",
     *     tags={"Serviços"},
     *     summary="Consultar status dos serviços",
     *     description="Este endpoint verifica o status de conexão dos principais serviços da aplicação: banco de dados, cache e fila.",
     *     @OA\Response(
     *         response=200,
     *         description="Status dos serviços",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="OK", description="Status geral da aplicação"),
     *             @OA\Property(
     *                 property="services",
     *                 type="object",
     *                 @OA\Property(property="database", type="string", example="Connected", description="Status da conexão com o banco de dados"),
     *                 @OA\Property(property="cache", type="string", example="Connected", description="Status da conexão com o serviço de cache"),
     *                 @OA\Property(property="queue", type="string", example="Connected", description="Status da conexão com o serviço de filas")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro interno no servidor"
     *     )
     * )
     */
    public function status()
    {

    }
}

