<?php

namespace App\Model\Specification;

use App\Model\Entity\Entity;
use App\Model\Specification\Assertion\AssertionInterface;
use App\Model\Specification\Exception\ValidateException;

/**
 * エンティティの仕様チェッククラス
 */
abstract class Specification
{
    /**
     * バリデーションルール
     *
     * @var array
     */
    private array $rules;

    /**
     * バリデーションルールの定義
     *
     * @param Entity $entity
     * @return void
     */
    abstract protected function specify(Entity $entity);

    /**
     * バリデーション実行
     *
     * @param Entity $entity エンティティを継承したクラス
     * @return boolean
     * @throws ValidateException
     */
    final public function validate(Entity $entity): bool
    {
        $this->rules = [];
        $this->specify($entity);

        $errors = [];
        foreach ($this->rules as $field => $rule) {
            $assertions = $rule["assertions"];
            foreach ($assertions as $assertion) {
                if ($assertion->isValid($entity->{$field}) == false) {
                    $errors[$field][] = $assertion->getMessage($rule["label"]);
                }
            }
        }
        if ($errors) {
            throw new ValidateException($entity, $errors);
        }
        return true;
    }

    /**
     * バリデーションルールの追加
     *
     * @param string $field エンティティのプロパティ名
     * @param string $label 画面表示用の項目名
     * @param array $assertions AssertionInterfaceを実装したクラス配列
     */
    final protected function addRule(string $field, string $label, array $assertions)
    {
        //$assertionsの要素の型チェック
        (function(AssertionInterface ...$value){})(...$assertions);

        $this->rules[$field] = [
            "label" => $label,
            "assertions" => $assertions
        ];
    }
}
