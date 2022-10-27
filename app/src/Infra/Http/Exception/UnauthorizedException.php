<?php

namespace App\Infra\Http\Exception;

use App\Infra\Http\Response;

/**
 * 401 Unauthorized
 */
class UnauthorizedException extends HttpException
{
    /**
     * Constructor
     *
     * @param Response $response
     */
    public function __construct(Response $response = new Response(401, "Unauthorized"))
    {
        parent::__construct($response);
    }
}
