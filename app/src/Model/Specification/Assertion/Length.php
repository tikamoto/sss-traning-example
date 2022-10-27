<?php

namespace App\Model\Specification\Assertion;

/**
 * 文字数のチェック
 */
class Length implements AssertionInterface
{
    /**
     * Constructor
     *
     * @param integer|null $min 許容する最小文字数
     * @param integer|null $max 許容する最大文字数
     * @param boolean $ignoreZero 文字数が0文字の場合に文字数チェックをスルーするか
     */
    public function __construct(
        private ?int $min = null,
        private ?int $max = null,
        private bool $ignoreZero = true
    ) {
    }

    /**
     * 入力値の妥当性チェック
     *
     * @param string $value
     * @return boolean
     */
    public function isValid(string $value): bool
    {
        $length = mb_strlen($value, "UTF-8");
        if ($this->ignoreZero && $length == 0) {
            return true;
        }
        if (is_null($this->min) && is_null($this->max)) {
            return true;
        }
        if (is_null($this->min) && !is_null($this->max)) {
            return $length <= $this->max;
        }
        if (!is_null($this->min) && is_null($this->max)) {
            return $this->min <= $length;
        }
        if (!is_null($this->min) && !is_null($this->max)) {
            return $this->min <= $length && $length <= $this->max;
        }
    }

    /**
     * エラーメッセージ取得
     *
     * @param string $label
     * @return string
     */
    public function getMessage(string $label): string
    {
        if (is_null($this->min) && !is_null($this->max)) {
            return sprintf("%s must be at most %s characters.", $label, $this->max);
        }
        if (!is_null($this->min) && is_null($this->max)) {
            return sprintf("%s must be at least %s characters.", $label, $this->min);
        }
        if (!is_null($this->min) && !is_null($this->max)) {
            return sprintf("%s must be between %s and %s characters.", $label, $this->min, $this->max);
        }
        return "";
    }
}
