<?php

namespace App\Infra\Http\Exception;

use App\Infra\Http\Response;

/**
 * HTTPステータス基底クラス
 */
abstract class HttpException extends \Exception
{
    /**
     * @var Response
     */
    protected Response $response;

    /**
     * Constructor
     *
     * @param Response $response
     */
    public function __construct(Response $response)
    {
        parent::__construct();
        $this->response = $response;
    }

    /**
     * レスポンス取得
     *
     * @return Response
     */
    public function getResponse(): Response
    {
        return $this->response;
    }
}
