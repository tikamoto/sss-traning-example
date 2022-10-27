<?php

namespace App\Controller;

use App\Infra\Http\Exception\ForbiddenException;
use App\Infra\Http\Exception\HttpException;
use App\Infra\Http\Exception\InternalServerErrorException;
use App\Infra\Http\Exception\NotFoundException;
use App\Infra\Http\Exception\UnauthorizedException;
use App\Infra\Http\Request;
use App\Infra\Http\Response;

/**
 * エラー画面コントローラ
 */
class ErrorController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 401 Unauthorized
     *
     * @param Response $request
     * @return Response
     */
    public function e401(Response $request): Response
    {
        return $this->createErrorResponse(new UnauthorizedException());
    }

    /**
     * 403 Forbidden
     *
     * @param Request $request
     * @return Response
     */
    public function e403(Request $request): Response
    {
        return $this->createErrorResponse(new ForbiddenException());
    }

    /**
     * 404 Not Found
     *
     * @param Request $request
     * @return Response
     */
    public function e404(Request $request): Response
    {
        return $this->createErrorResponse(new NotFoundException());
    }

    /**
     * 500 Internal Server Error
     *
     * @param Request $request
     * @return Response
     */
    public function e500(Request $request): Response
    {
        return $this->createErrorResponse(new InternalServerErrorException());
    }

    /**
     * レスポンス生成
     *
     * @param HttpException $error
     * @return Response
     */
    private function createErrorResponse(HttpException $error): Response
    {
        $res = $error->getResponse();
        $message = $res->statusCode . " " . $res->content;
        return $this->view("error", ["message" => $message], $res->statusCode);
    }
}
