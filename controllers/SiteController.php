<?php

namespace app\controllers;

use app\models\Petroglyph;
use app\models\SignupForm;
use app\utils\SignupService;
use Yii;
use yii\data\Pagination;
use yii\web\Controller;
use app\models\LoginForm;

class SiteController extends Controller
{
    public function actionManageUsers()
    {
        echo 'Управление пользователями доступно только администратору.';
    }

    //const PAGE_LIMIT = 10;
    public function actionIndex()
    {
        $query = Petroglyph::find()
            ->orderBy(['id' => SORT_ASC]);
        //$pages = new Pagination(['totalCount' => $query->count()]);
        $pages = new Pagination(['totalCount' => 100]);

        $petroglyphs = $query->offset($pages->offset)
            //->limit($pages->limit)
            ->limit(8)
            ->all();
        return $this->render('index',[
            'petroglyphs' => $petroglyphs,
            'pages' => $pages,
        ]);
    }

    public function actionSignup()
    {
        $form = new SignupForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $signupService = new SignupService();

            try{
                $user = $signupService->signup($form);
                Yii::$app->session->setFlash('success', 'Check your email to confirm the registration.');
                $signupService->sentEmailConfirm($user);
                return $this->goHome();
            } catch (\RuntimeException $e){
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('signup', [
            'model' => $form,
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

        $form = new LoginForm();
        if ($form->load(Yii::$app->request->post())) {
            try{
                if($form->login()){
                    return $this->goBack();
                }
            } catch (\DomainException $e){
                Yii::$app->session->setFlash('error', $e->getMessage());
                return $this->goHome();
            }
        }

        $form->password = '';
        return $this->render('login', [
            'model' => $form,
        ]);

        /*if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);*/
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

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionSignupConfirm($token)
    {
        $signupService = new SignupService();

        try{
            $signupService->confirmation($token);
            Yii::$app->session->setFlash('success', 'You have successfully confirmed your registration.');
        } catch (\Exception $e){
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->goHome();
    }
}
