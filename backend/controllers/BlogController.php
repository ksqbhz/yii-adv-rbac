<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;

class BlogController extends Controller
{
//
    public function behaviors()
    {
        return [
            //附加行为
            'myBehavior' => \backend\components\MyBehavior::className(),
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

//    public function beforeAction($action)
//    {
//        //$currentRequestRoute 返回当前URL后缀
//        $currentRequestRoute = $action->getUniqueId();
//        if (!Yii::$app->user->can('/' . $currentRequestRoute)) {
//            throw new \yii\web\ForbiddenHttpException('没有权限，请与管理员联系');
//        }
//
//        return true;
//    }

    public function actionIndex()
    {
//        if (!Yii::$app->user->can('/blog/index')) {
//            throw new \yii\web\ForbiddenHttpException("没权限访问.");
//        }



        $myBehavior = $this->getBehavior('myBehavior');
        $isGuest = $myBehavior->isGuest();
        var_dump($isGuest);

        // 或者你也可以这样直接调用
        $isGuest = $this->isGuest();
        var_dump($isGuest);

        return $this->render('index');
    }

}
