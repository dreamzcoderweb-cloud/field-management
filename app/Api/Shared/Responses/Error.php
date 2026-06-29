<?php

namespace App\Api\Shared\Responses;

use App\Interfaces\ErrorResponseInterface;
use Exception;
use Illuminate\Http\JsonResponse;

class Error
{
    /**
     * Returns json response needed in controllers.
     *
     * @param string|ErrorResponseInterface $data Data need to be
     * contained in the response.
     * @param integer $code Response status code.
     * @param array $headers Headers needed to be set for the response.
     * @param integer $options Options.
     *
     * @return JsonResponse
     *
     * @throws Exception Throws an exception when status code does not
     * correspond or message property is not set in response data object.
     */
    public static function response(
        string|ErrorResponseInterface $data,
        int $code = 400,
        array $headers = [],
        $options = 0
    ): JsonResponse {

        if ($code < 400) {
            throw new Exception('Status code is invalid');
        }

        if ($data instanceof ErrorResponseInterface) {
            $dataArray = get_object_vars($data);

            if (!array_key_exists('message', $dataArray)) {
                throw new Exception('Message property does not exist');
            }

            foreach ($dataArray as $key => $value) {
                $response[$key] = $value;
            }

            // Replace 'message' key with 'data' key
            if (isset($response['message'])) {
                $response['data'] = $response['message'];
                unset($response['message']);
            }

            return response()->json($response, $code, $headers, $options);
        }

        // For string errors
        return response()->json(
            [
                'statusCode' => $code,
                'status' => 'failed',
                'data' => $data // <-- already set as data
            ],
            $code,
            $headers,
            $options
        );
    }
}
