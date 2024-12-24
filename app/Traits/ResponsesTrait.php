<?php

namespace App\Traits;

trait ResponsesTrait
{
    public function success($data = null, $msg = null)
    {
        return response()->json([
            'success' => True,
            "result" => $data,
            'msg' => $msg
        ], 200);
    }

    public function failed($data = null, $msg = null)
    {
        return response()->json([
            'success' => False,
            "result" => $data,
            'msg' => $msg
        ], 200);
    }


}
