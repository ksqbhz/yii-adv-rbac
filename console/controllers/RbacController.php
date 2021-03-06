<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/24
 * Time: 10:45
 */

namespace console\controllers;


use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // 添加 "createPost" 权限
        $createPost = $auth->createPermission('createPost');
        $createPost->description = 'Create a post';
        $auth->add($createPost);

        // 添加 "updatePost" 权限
        $updatePost = $auth->createPermission('updatePost');
        $updatePost->description = 'Update post';
        $auth->add($updatePost);

        // 添加 "author" 角色并赋予 "createPost" 权限
        $author = $auth->createRole('author');
        $auth->add($author);
        $auth->addChild($author, $createPost);

        /******************/
        // 添加 "test" 权限
        $createTest = $auth->createPermission('createTest');
        $createTest->description = 'Create a test';
        $auth->add($createTest);
        // 添加 "test2" 权限
        $createTest2 = $auth->createPermission('createTest2');
        $createTest2->description = 'Create a test2';
        $auth->add($createTest2);
        // 添加 "test" 角色并赋予 "test" 权限
        $test = $auth->createRole('test');
        $auth->add($test);
        $auth->addChild($test, $createTest);
        $auth->addChild($test, $createTest2);
        /******************/

        // 添加 "admin" 角色并赋予 "updatePost"
        // 和 "author" 权限
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $updatePost);
        $auth->addChild($admin, $author);
        $auth->addChild($admin, $test);

        // 为用户指派角色。其中 1 和 2 是由 IdentityInterface::getId() 返回的id （译者注：user表的id）
        // 通常在你的 User 模型中实现这个函数。
        $auth->assign($author, 2);
        $auth->assign($admin, 1);

        $auth = Yii::$app->authManager;

// 添加规则
        $rule = new \console\controllers\AuthorRule;
        $auth->add($rule);

// 添加 "updateOwnPost" 权限并与规则关联
        $updateOwnPost = $auth->createPermission('updateOwnPost');
        $updateOwnPost->description = 'Update own post';
        $updateOwnPost->ruleName = $rule->name;
        $auth->add($updateOwnPost);

// "updateOwnPost" 权限将由 "updatePost" 权限使用
        $auth->addChild($updateOwnPost, $updatePost);

// 允许 "author" 更新自己的帖子
        $auth->addChild($author, $updateOwnPost);
    }
}