<?php

namespace App\Api\Shared\Responses;

use Exception;
use Illuminate\Http\JsonResponse;

class Success
{

    public static function response(
        $data,
        int $code = 200,
        array $headers = [],
        $options = 0
    ): JsonResponse
    {
        if ($code < 200 || $code >= 300) {
            throw new Exception('Status code is invalid');
        }

        /* if ($data instanceof SuccessfulResponseInterface) {
             $dataArray = get_object_vars($data);

             if (!array_key_exists('message', $dataArray)) {
                 throw new Exception('Message property does not exist');
             }

             foreach ($dataArray as $key => $value) {
                 $response[$key] = $value;
             }

             return response()->json($response, $code, $headers, $options);
         }*/

        return response()->json(
            [
                'statusCode' => $code,
                'status' => 'success',
                'data' => $data
            ],
            $code,
            $headers,
            $options
        );
    }
}
