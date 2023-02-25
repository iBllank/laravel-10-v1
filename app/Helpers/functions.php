<?php

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;


function throwResponseExceptionJson(Validator $validator){
    throw new HttpResponseException(response()->json([
        'status'    => 0,
        'message'   => 'Validation errors',
        'data'      => null,
        'errors'    => $validator->errors(),
    ]));
}
