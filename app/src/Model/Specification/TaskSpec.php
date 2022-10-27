<?php

namespace App\Model\Specification;

use App\Model\Entity\Entity;
use App\Model\Specification\Assertion;

/**
 * タスク作成・更新時のエンティティ仕様定義クラス
 */
class TaskSpec extends Specification
{
    /**
     * バリデーションルールの定義
     *
     * @param Entity $task
     * @return void
     */
    protected function specify(Entity $task)
    {
        //期日
        $this->addRule("expiredOn", "Due date", [
            new Assertion\NotBlank(),
            new Assertion\Date()
        ]);

        //内容
        $this->addRule("description", "To do", [
            new Assertion\NotBlank()
        ]);
    }
}
