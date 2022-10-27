<?php

namespace App\Model\Specification\Assertion;

/**
 * メールアドレスのフォーマットチェック
 */
class Email implements AssertionInterface
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
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    /**
     * エラーメッセージ取得
     *
     * @param string $label
     * @return string
     */
    public function getMessage(string $label): string
    {
        return sprintf("%s must be enterd correct email address.", $label);
    }
}
