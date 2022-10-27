<?php

namespace App\Infra\Http;

/**
 * レスポンスクラス
 */
class Response
{
    /**
     * Constructor
     *
     * @param integer $statusCode
     * @param string $content
     */
    public function __construct(
        public readonly int $statusCode,
        public readonly string $content
    ) {
    }
}
