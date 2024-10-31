<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Queue;

/**
 * @OA\Tag(
 *     name="Serviços",
 *     description="API Endpoints para Verificação de Status dos Serviços"
 * )
 */
class HealthCheckController extends Controller
{
    /**
     * @OA\Get(
     *     path="/status",
     *     tags={"Serviços"},
     *     summary="consultar status dos serviços",
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
     *                  @OA\Property(property="cache", type="string", example="Connected", description="Status da conexão com o serviço de cache"),
     *                  @OA\Property(property="queue", type="string", example="Connected", description="Status da conexão com o serviço de filas")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *     response=500,
     *     description="Erro interno no servidor"
     *    )
     * )
     */
    public function check(DB $db): JsonResponse
    {
        try {
            $db::connection()->getPdo();
            $databaseStatus = 'Connected';
        } catch (\Exception $e) {
            $databaseStatus = 'Not Connected : ' . $e->getMessage();
        }

        try {
            Cache::store('redis')->put('health_check', true, 1);
            $cacheStatus = 'Connected';
        } catch (\Exception $e) {
            $cacheStatus = 'Not Connected : ' . $e->getMessage();
        }

        try {
            Queue::connection()->size();
            $queueStatus = 'Connected';
        } catch (\Exception $e) {
            $queueStatus = 'Not Connected : ' . $e->getMessage();
        }

        return response()->json([
            'status' => 'OK',
            'services' => [
                'database' => $databaseStatus,
                'cache' => $cacheStatus,
                'queue' => $queueStatus,
            ]
        ]);
    }
}
