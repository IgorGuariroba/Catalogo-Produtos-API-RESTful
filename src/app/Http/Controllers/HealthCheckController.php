<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;

class HealthCheckController extends Controller
{
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

//        try {
//            Http::get('https://external-service.com/health');
//            $externalServiceStatus = 'Connected';
//        } catch (\Exception $e) {
//            $externalServiceStatus = 'Not Connected : ' . $e->getMessage();
//        }  @D$¨SG%ryubv
//
//        try {
//            Storage::disk('s3')->exists('health_check');
//            $storageStatus = 'Connected';
//        } catch (\Exception $e) {
//            $storageStatus = 'Not Connected : ' . $e->getMessage();
//        }

        return response()->json([
            'status' => 'OK',
            'services' => [
                'database' => $databaseStatus,
                'cache' => $cacheStatus,
                'queue' => $queueStatus,
//                'external_service' => $externalServiceStatus,
//                'storage' => $storageStatus,
            ]
        ]);
    }
}
