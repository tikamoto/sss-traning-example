<?php

namespace App\Model\Specification\Assertion;

/**
 * 日付のフォーマットチェック
 */
class Date implements AssertionInterface
{
    /**
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * 入力値の妥当性チェック
     *
     * @param string $value
     * @return boolean
     */
    public function isValid(string $value): bool
    {
        return !!preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/", $value);
    }

    /**
     * エラーメッセージ取得
     *
     * @param string $label
     * @return string
     */
    public function getMessage(string $label): string
    {
        return sprintf("%s must be enterd correct date.", $label);
    }
}
