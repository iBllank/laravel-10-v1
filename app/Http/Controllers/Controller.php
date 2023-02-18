<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function returnJson( $status, $data = null, $msg = '' ) {
        return response()->json([
            'status' => $status,
            'data' => $data,
            'msg' => $msg,
        ]);
    }

}
