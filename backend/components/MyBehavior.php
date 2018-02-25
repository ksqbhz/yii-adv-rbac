<?php

namespace backend\components;

use Yii;

class MyBehavior extends \yii\base\ActionFilter
{
    public function beforeAction ($action)
    {
        $currentRequestRoute = $action->getUniqueId();
        if (!Yii::$app->user->can('/' . $currentRequestRoute)) {
            throw new \yii\web\ForbiddenHttpException('没有权限，请与管理员联系ss');
        }
        return true;
    }
    public function isGuest ()
    {
        return Yii::$app->user->isGuest;
    }
}