<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */

/* @var $model app\models\LoginForm */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->title = 'Вход';
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Пожалуйста, заполните поля:</p>
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-login']) ?>
            <?= $form->field($model, 'email')->label("Логин (e-mail):") ?>
            <?=$form->field($model, 'password')->passwordInput()->label("Пароль:") ?>
           <!-- $form->field($model, 'rememberMe')->checkbox([
                 'template' => "<div class=\"offset-lg-1 col-lg-3 custom-control custom-checkbox\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
             ])->label("Запомнить меня");-->

            <div class="form-group">
                <div class="offset-lg-1 col-lg-11">
                    <?= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
