<?php
 
namespace App\Http\Helpers;

class ApiResponse
{
    public static function success(int $statusCode, string $message = "Success", array $data = [])
    {
        if (count($data) == 0) {
            return response()->json([
                "success"     => true,
                "statusCode"  => $statusCode,
                "message"     => $message,
            ], $statusCode);
        } else {
            return response()->json([
                "success"     => true,
                "statusCode"  => $statusCode,
                "message"     => $message,
                "data"        => $data
            ], $statusCode);
        }
    }
    public static function error(int $statusCode, string $message)
    {
        return response()->json([
            "success"     => false,
            "statusCode"  => $statusCode,
            "message"     => $message
        ]);
    }
}
