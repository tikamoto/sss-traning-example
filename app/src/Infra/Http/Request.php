<?php

namespace App\Infra\Http;

/**
 * リクエストクラス
 */
class Request
{
    /**
     * リクエストパス
     *
     * @return void
     */
    public function path()
    {
        return parse_url($_SERVER["REQUEST_URI"])["path"];
    }

    /**
     * リクエストメソッドがGETか
     *
     * @return boolean
     */
    public function isGet ()
    {
        return $_SERVER["REQUEST_METHOD"] == "GET";
    }

    /**
     * リクエストメソッドがPOSTか
     *
     * @return boolean
     */
    public function isPost ()
    {
        return $_SERVER["REQUEST_METHOD"] == "POST";
    }

    /**
     * GETパラメータの値を取得
     *
     * @param string|null $key
     * @param mixed $default キーが存在しない場合のデフォルト値
     * @return mixed
     */
    public function get(?string $key = null, mixed $default = null): mixed
    {
        if (is_null($key)) {
            return $_GET;
        }
        return $_GET[$key] ?? $default;
    }

    /**
     * POSTパラメータの値を取得
     *
     * @param string|null $key
     * @param mixed $default キーが存在しない場合のデフォルト値
     * @return mixed
     */
    public function post(?string $key = null, mixed $default = null): mixed
    {
        if (is_null($key)) {
            return $_POST;
        }
        return $_POST[$key] ?? $default;
    }
}
