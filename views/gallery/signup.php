<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model app\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Регистрация';
?>
<div class="gallery-signup">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Пожалуйста, заполните поля:</p>
    <div class="row">
        <div class="col-lg-5">

            <?php $form = ActiveForm::begin(['id' => 'form-signup']) ?>
            <?= $form->field($model, 'email')->label("Логин (e-mail):") ?>
            <?= $form->field($model, 'password')->passwordInput()->label("Пароль:") ?>
            <?= $form->field($model, 'passwordValidate')->passwordInput()->label("Повторите пароль:") ?>
            <div class="form-group">
                <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
