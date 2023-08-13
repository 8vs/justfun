<?php

namespace AdventureTime\Utils;

trait ResponseJson
{
    /**
     * @param array $ctx
     * @param int $status
     */
    public function response(array $ctx = [], int $status = 200) {
        http_response_code($status);
        header('Content-Type: application/json');

        echo \json_encode(
            $status >= 400
                ? ['error' => $ctx]
                : ['response' => $ctx],
            JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
        );

        exit;
    }
}