<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model app\models\SignupForm */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->title = 'Регистрация';
/*$this->params['breadcrumbs'][] = $this->title;
*/?><!--
<div class="site-signup">
    <h1><?/*= Html::encode($this->title) */?></h1>-->

    <p>Пожалуйста, заполните следующие поля для регистрации:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'signup-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-4 col-form-label', 'style'=>'width:1000px'],
        ],
    ]); ?>

        <?= $form->field($model, 'email')->textInput(['autofocus' => true])->label("E-mail (будет использоваться как логин):") ?>
        <?= $form->field($model, 'password')->passwordInput()->label("Пароль:") ?>
        <?= $form->field($model, 'password')->passwordInput()->label("Повторите пароль:") ?>

        <div class="form-group">
            <div class="offset-lg-1 col-lg-11">
                <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>

    <!--<div class="offset-lg-1" style="color:#999;">
        You may login with <strong>admin/admin</strong> or <strong>demo/demo</strong>.<br>
        To modify the username/password, please check out the code <code>app\models\User::$users</code>.
    </div>-->
</div>
