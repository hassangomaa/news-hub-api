<?php

namespace App\Traits;

trait ResponsesTrait
{
    /**
     * Standardized success response.
     *
     * @param mixed $data
     * @param string|null $msg
     * @param int $status
     * @param array|null $meta
     * @return \Illuminate\Http\JsonResponse
     */
    public function success($data = null, $msg = null, $status = 200, $meta = null)
    {
        $response = [
            'success' => true,
            'msg' => $msg,
            'data' => $data,
        ];

        if ($meta) {
            $response['meta'] = $meta;
        }

        return response()->json($response, $status);
    }

    /**
     * Standardized failure response.
     *
     * @param mixed $data
     * @param string|null $msg
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function failed($data = null, $msg = null, $status = 400)
    {
        return response()->json([
            'success' => false,
            'msg' => $msg,
            'data' => $data,
        ], $status);
    }
}
