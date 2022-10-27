<?php

namespace App\Infra\Http\Exception;

use App\Infra\Http\Response;

/**
 * 404 Not Found
 */
class NotFoundException extends HttpException
{
    /**
     * Constructor
     *
     * @param Response $response
     */
    public function __construct(Response $response = new Response(404, "Not Found"))
    {
        parent::__construct($response);
    }
}
