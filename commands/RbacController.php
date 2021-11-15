<?php

namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();

        // добавляем разрешение "createPost"
        $createPost = $auth->createPermission('createPost');
        $createPost->description = 'Создать публикацию';
        $auth->add($createPost);

// добавляем разрешение "updatePost"
        $updatePost = $auth->createPermission('updatePost');
        $updatePost->description = 'Редактировать публикацию';
        $auth->add($updatePost);

        // добавляем разрешение "updatePost"
        $updateUserInfo = $auth->createPermission('updateUserInfo');
        $updateUserInfo->description = 'Редактировать данные о пользователе';
        $auth->add($updateUserInfo);

// добавляем роль "author" и даём роли разрешение "createPost"
        $author = $auth->createRole('author');
        $auth->add($author);
        $auth->addChild($author, $createPost);
        $auth->addChild($author, $updatePost);

// добавляем роль "admin" и даём роли разрешение "updatePost"
// а также все разрешения роли "author"
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $updateUserInfo);
        $auth->addChild($admin, $author);

// Назначение ролей пользователям. 1 и 2 это IDs возвращаемые IdentityInterface::getId()
// обычно реализуемый в модели User.
        $auth->assign($author, 2);
        $auth->assign($admin, 1);
    }
}
