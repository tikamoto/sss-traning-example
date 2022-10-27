<?php

namespace App;

/**
 * アプリケーション全体の設定値管理クラス
 */
final class Config
{
    /**
     * @var array
     */
    private static $vars = [];

    /**
     * 値の取得
     *
     * @param string $key
     * @return mixed
     * @throws \DomainException
     */
    public static function get(string $key): mixed
    {
        if (!isset(self::$vars[$key])) {
            throw new \DomainException();
        }
        return self::$vars[$key];
    }

    /**
     * 値のセット
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public static function set(string $key, mixed $value)
    {
        self::$vars[$key] = $value;
    }
}
