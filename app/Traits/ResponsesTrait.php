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


    /**
     * Generate standardized meta for pagination.
     *
     * @param \Illuminate\Contracts\Pagination\LengthAwarePaginator $paginator
     * @return array
     */
    public function generateMeta($paginator): array
    {
        return [
            'currentPage' => $paginator->currentPage(),
            'perPage' => $paginator->perPage(),
            'total' => $paginator->total(),
            'lastPage' => $paginator->lastPage(),
        ];
    }
}
