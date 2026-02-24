<?php


namespace App\Support;

use Throwable;

class ApiResponse
{
    public static function ok(string $message = 'OK', mixed $data = null, int $code = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public static function fail(
        string     $message = 'ERROR',
        ?Throwable $e = null,
        int        $code = 500,
        mixed      $data = null
    )
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $data,
            // ✅ “siempre enviando el error que sale”
            'error' => $e ? [
                'message' => $e->getMessage(),
                'type' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ] : null,
        ], $code);
    }
}
