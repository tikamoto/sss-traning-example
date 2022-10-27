<?php

namespace App\Infra\Http\Exception;

use App\Infra\Http\Response;

/**
 * 403 Forbidden
 */
class ForbiddenException extends HttpException
{
    /**
     * Constructor
     *
     * @param Response $response
     */
    public function __construct(Response $response = new Response(403, "Forbidden"))
    {
        parent::__construct($response);
    }
}
