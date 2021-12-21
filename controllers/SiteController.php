<?php

namespace app\controllers;

use app\models\Petroglyph;
use app\models\SignupForm;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;

class SiteController extends Controller
{
    public function actionManageUsers()
    {
        echo 'Управление пользователями доступно только администратору.';
    }

    public function actionManageArticles()
    {
        echo 'Управление статьями доступно администратору и Автору материалов.';
    }
    //const PAGE_LIMIT = 10;
    public function actionIndex()
    {
        $query = Petroglyph::find()
            ->orderBy(['id' => SORT_ASC]);
        $pages = new Pagination(['totalCount' => $query->count()]);
        //$pages = new Pagination(['totalCount' => 100]);

        $petroglyphs = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('index',[
            'petroglyphs' => $petroglyphs,
            'pages' => $pages,
        ]);
    }

    public function actionSignup()
    {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionPublications()
    {
        $query = Petroglyph::find()
            ->where(['author_id' => Yii::$app->user->getId()])
            ->orderBy(['id' => SORT_ASC]);
        $pages = new Pagination(['totalCount' => $query->count()]);
        //$pages = new Pagination(['totalCount' => 100]);

        $petroglyphs = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('publications',[
            'petroglyphs' => $petroglyphs,
            'pages' => $pages,
        ]);
    }
}
