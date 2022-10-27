<?php

namespace App\Infra\Http\Exception;

use App\Infra\Http\Response;

/**
 * 500 InternalServerError
 */
class InternalServerErrorException extends HttpException
{
    /**
     * Constructor
     *
     * @param Response $response
     */
    public function __construct(Response $response = new Response(500, "Internal Server Error"))
    {
        parent::__construct($response);
    }
}
